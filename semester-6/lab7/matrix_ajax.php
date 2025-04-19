<?php
header('Content-Type: application/json');

// Function to generate random matrix
function generateRandomMatrix($n, $m) {
    $matrix = [];
    for ($i = 0; $i < $n; $i++) {
        $row = [];
        for ($j = 0; $j < $m; $j++) {
            $row[] = rand(-10, 10);
        }
        $matrix[] = $row;
    }
    return $matrix;
}

// Function to filter matrix
function filterMatrix($matrix) {
    return array_filter($matrix, function($row) {
        $negativeCount = count(array_filter($row, function($num) {
            return $num < 0;
        }));
        return $negativeCount <= 3;
    });
}

// Format matrix for display
function formatMatrix($matrix) {
    if (empty($matrix)) return "Нет подходящих строк";
    return implode("\n", array_map(function($row) {
        return implode("\t", $row);
    }, $matrix));
}

// Main logic
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $n = (int)$_POST['rows'];
    $m = (int)$_POST['cols'];
    $mode = $_POST['mode'];

    // Validate input
    if ($n <= 0 || $m <= 0) {
        echo json_encode(['error' => 'Неверные размеры матрицы']);
        exit;
    }

    // Generate matrix
    if ($mode === 'random') {
        $matrix = generateRandomMatrix($n, $m);
    } else {
        $matrix = [];
        for ($i = 0; $i < $n; $i++) {
            $row = array_map('intval', explode(',', $_POST["row_$i"]));
            if (count($row) !== $m) {
                echo json_encode(['error' => "Неверный ввод для строки " . ($i + 1)]);
                exit;
            }
            $matrix[] = $row;
        }
    }

    // Filter matrix
    $filteredMatrix = filterMatrix($matrix);

    // Prepare response
    echo json_encode([
        'original' => formatMatrix($matrix),
        'filtered' => formatMatrix($filteredMatrix)
    ]);
}
?>