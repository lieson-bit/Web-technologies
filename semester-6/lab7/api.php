<?php
header('Content-Type: application/json');
include 'db.php';

$response = ['success' => false];

try {
    // Get input data from GET or POST
    $requestData = $_SERVER['REQUEST_METHOD'] === 'POST' ? $_POST : $_GET;
    
    $table = $requestData['table'] ?? 'robots';
    $id = isset($requestData['id']) ? (int)$requestData['id'] : null;
    $action = $requestData['action'] ?? 'get'; // Default to 'get' if no action specified

    // Validate table
    if (!in_array($table, ['robots', 'manufacturers'])) {
        throw new Exception("Invalid table specified");
    }

    switch ($action) {
        case 'get':
            if ($table === 'robots') {
                $query = "SELECT robots.*, manufacturers.name AS manufacturer_name, manufacturers.country 
                         FROM robots 
                         JOIN manufacturers ON robots.manufacturer_id = manufacturers.id";
                if ($id) {
                    $query .= " WHERE robots.id = $id LIMIT 1";
                }
            } elseif ($table === 'manufacturers') {
                $query = "SELECT * FROM manufacturers";
                if ($id) {
                    $query .= " WHERE id = $id LIMIT 1";
                }
            }

            $result = $conn->query($query);
            
            if (!$result) {
                throw new Exception($conn->error);
            }

            $data = [];
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }

            $response = [
                'success' => true,
                'data' => $data,
                'columns' => $table === 'robots' ? 
                    ['Модель', 'Тип', 'Вес (кг)', 'Грузоподъёмность (кг)', 'Производитель', 'Страна'] :
                    ['Название', 'Страна', 'Год основания', 'Веб-сайт', 'Рейтинг']
            ];
            break;

        case 'delete':
            if (!$id) {
                throw new Exception("ID is required for deletion");
            }
            
            $query = "DELETE FROM $table WHERE id = $id";
            if ($conn->query($query)) {
                $response['success'] = true;
            } else {
                throw new Exception($conn->error);
            }
            break;

        default:
            // For other actions (insert/update), let the existing files handle them
            throw new Exception("Invalid action specified");
    }
} catch (Exception $e) {
    $response = [
        'success' => false,
        'error' => $e->getMessage()
    ];
}

echo json_encode($response);
?>