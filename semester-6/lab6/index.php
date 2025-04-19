<?php
include 'db.php';

// Check if the user selected which view to display
$view = isset($_GET['view']) ? $_GET['view'] : 'robots';

// Query for Robots
$robot_query = "SELECT robots.id, model_name, type, weight, payload, manufacturers.name AS manufacturer_name, country 
                FROM robots 
                JOIN manufacturers ON robots.manufacturer_id = manufacturers.id";

// Query for Manufacturers
$manufacturer_query = "SELECT * FROM manufacturers";

// Query for Combined View (Model+Type from robots, Year+Website from manufacturers)
$combined_query = "SELECT 
                    robots.id AS robot_id,
                    robots.model_name, 
                    robots.type, 
                    manufacturers.founded_year, 
                    manufacturers.website
                  FROM robots
                  JOIN manufacturers ON robots.manufacturer_id = manufacturers.id";

// Fetch the results based on view
if ($view == 'robots') {
    $result = $conn->query($robot_query);
    $columns = ['Модель', 'Тип', 'Вес (кг)', 'Грузоподъёмность (кг)', 'Производитель', 'Страна', 'Действия'];
    $data = $result;
} elseif ($view == 'manufacturers') {
    $result = $conn->query($manufacturer_query);
    $columns = ['Название', 'Страна', 'Год основания', 'Веб-сайт', 'Рейтинг', 'Действия'];
    $data = $result;
} elseif ($view == 'combined') {
    $result = $conn->query($combined_query);
    $columns = ['Модель', 'Тип', 'Год основания', 'Веб-сайт', 'Действия'];
    $data = $result;
}

echo "<html><head><link rel='stylesheet' href='style.css'><script src='https://code.jquery.com/jquery-3.6.0.min.js'></script></head><body>";
?>

<h1>Промышленные роботы и Производители</h1>

<!-- Buttons to select which view to display -->
<div class="button-container">
    <a href="?view=robots" class="button">Просмотр Роботов</a>
    <a href="?view=manufacturers" class="button">Просмотр Производителей</a>
    <a href="?view=combined" class="button">Комбинированный просмотр</a>
    <a href="?view=matrix" class="button">Матричные операции</a>
</div>

<?php if (in_array($view, ['robots', 'manufacturers', 'combined'])): ?>
    <!-- Displaying Table Based on User's Choice -->
    <?php
    $view_titles = [
        'robots' => 'Роботы',
        'manufacturers' => 'Производители',
        'combined' => 'Роботы и информация о производителях'
    ];
    echo "<h2>{$view_titles[$view]}</h2>";
    echo "<table><tr>";
    foreach ($columns as $column) {
        echo "<th>$column</th>";
    }
    echo "</tr>";

    while ($row = $data->fetch_assoc()) {
        echo "<tr>";
        if ($view == 'robots') {
            // Display robot data
            echo "<td>{$row['model_name']}</td>";
            echo "<td>{$row['type']}</td>";
            echo "<td>{$row['weight']}</td>";
            echo "<td>{$row['payload']}</td>";
            echo "<td>{$row['manufacturer_name']}</td>";
            echo "<td>{$row['country']}</td>";
        } elseif ($view == 'manufacturers') {
            // Display manufacturer data
            printf(
                "<td>%s</td><td>%s</td><td>%s</td><td><a href='%s' target='_blank'>%s</a></td><td>%s</td>",
                htmlspecialchars($row['name']),
                htmlspecialchars($row['country']),
                htmlspecialchars($row['founded_year']),
                htmlspecialchars($row['website']),
                htmlspecialchars($row['website']),
                htmlspecialchars($row['rating'])
            );
        } elseif ($view == 'combined') {
            // Display combined data
            echo "<td>{$row['model_name']}</td>";
            echo "<td>{$row['type']}</td>";
            echo "<td>{$row['founded_year']}</td>";
            echo "<td><a href='{$row['website']}' target='_blank'>{$row['website']}</a></td>";
        }

        // Add actions (edit/delete) in the last column
        $id = isset($row['id']) ? $row['id'] : (isset($row['robot_id']) ? $row['robot_id'] : 0);
        echo "<td>";
        if ($view != 'combined') {
            echo "<a href='#' class='edit-button' data-id='{$id}'>✏️</a>";
        }
        echo "<a href='" . ($view == 'robots' ? 'delete.php?id=' : 
              ($view == 'manufacturers' ? 'delete_manufacturer.php?id=' : '#')) . "{$id}' class='action-button'>🗑️</a>
              </td>";
        echo "</tr>";
    }
    echo "</table>";
    ?>

    <!-- Form to Add New Robot or Manufacturer -->
    <div id="add-form" class="form-container">
        <?php if ($view == 'robots') { ?>
            <h2>Добавить нового робота</h2>
            <form action="insert.php" method="POST">
                Модель: <input type="text" name="model_name" required><br>
                Тип: <input type="text" name="type" required><br>
                Вес (кг): <input type="number" step="0.1" name="weight" required><br>
                Грузоподъёмность (кг): <input type="number" step="0.1" name="payload" required><br>
                Производитель: 
                <select name="manufacturer_id" required>
                    <?php
                    $manu_result = $conn->query("SELECT id, name FROM manufacturers");
                    while ($manu = $manu_result->fetch_assoc()) {
                        echo "<option value='{$manu['id']}'>{$manu['name']}</option>";
                    }
                    ?>
                </select><br>
                <button type="submit">Добавить робота</button>
            </form>
        <?php } elseif ($view == 'manufacturers') { ?>
            <h2>Добавить нового производителя</h2>
            <form action="insert.php" method="POST">
                Название: <input type="text" name="name" required><br>
                Страна: <input type="text" name="country" required><br>
                Год основания: <input type="number" name="founded_year" required><br>
                Веб-сайт: <input type="url" name="website"><br>
                Рейтинг: <input type="number" step="0.1" name="rating"><br>
                <button type="submit">Добавить производителя</button>
            </form>
        <?php } ?>
    </div>

    <!-- Update Form (Initially Hidden) -->
    <div id="update-form" class="form-container" style="display: none;">
        <h2>Редактировать данные</h2>
        <form id="update-form-data" method="POST">
            <input type="hidden" name="id" id="update-id">
            <div id="update-form-content"></div>
            <button type="submit">Обновить</button>
            <button type="button" id="close-update-form">Закрыть</button>
        </form>
    </div>

<?php elseif ($view == 'matrix'): ?>
    <!-- Matrix Operations Section -->
    <div id="matrix-section">
        <h2>Матричные операции</h2>
        <form id="matrixForm">
            <label>Строки (n): <input type="number" name="rows" min="1" required></label><br>
            <label>Столбцы (m): <input type="number" name="cols" min="1" required></label><br>
            
            <label>
                <input type="radio" name="mode" value="random" checked> Заполнить случайными числами (-10 до 10)
            </label><br>
            <label>
                <input type="radio" name="mode" value="manual"> Ввести вручную
            </label><br>

            <div id="manualInput" style="display:none;">
                <!-- Dynamic inputs for manual entry -->
            </div>

            <button type="submit">Обработать матрицу</button>
        </form>

        <div id="matrixResult" style="margin-top: 20px;"></div>
    </div>

    <script>
        // Dynamic form for manual input
        $(document).on('change', 'input[name="mode"]', function() {
            const manualDiv = $('#manualInput');
            manualDiv.toggle(this.value === 'manual');
            
            if (this.value === 'manual') {
                const rows = parseInt($('input[name="rows"]').val()) || 0;
                const cols = parseInt($('input[name="cols"]').val()) || 0;
                let html = '';
                for (let i = 0; i < rows; i++) {
                    html += `<label>Строка ${i+1} (через запятую): <input type="text" name="row_${i}" required></label><br>`;
                }
                manualDiv.html(html);
            }
        });

        // AJAX form submission
        $('#matrixForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: 'matrix_ajax.php',
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    $('#matrixResult').html(`
                        <h3>Исходная матрица:</h3>
                        <pre>${response.original}</pre>
                        <h3>Отфильтрованная матрица (≤3 отрицательных в строке):</h3>
                        <pre>${response.filtered}</pre>
                    `);
                }
            });
        });
    </script>
<?php endif; ?>

<!-- Common JavaScript for all views -->
<script>
// Handle Edit Button Click
$(document).on('click', '.edit-button', function() {
    var id = $(this).data('id');
    var view = '<?php echo $view; ?>';
    
    $('#add-form').hide();
    $('#update-form').show();

    $.ajax({
        url: 'get_data_for_edit.php',
        method: 'GET',
        data: { id: id, table: view },
        success: function(response) {
            $('#update-form-content').html(response);
            $('#update-id').val(id);
        }
    });
});

// Handle Close Button Click
$('#close-update-form').on('click', function() {
    $('#update-form').hide();
    $('#add-form').show();
});

// Handle Update Form Submit
$('#update-form-data').on('submit', function(e) {
    e.preventDefault();
    var view = '<?php echo $view; ?>';
    
    $.ajax({
        url: 'update.php',
        method: 'POST',
        data: $(this).serialize() + '&table=' + view,
        success: function(response) {
            window.location.href = 'index.php?view=' + view;
        }
    });
});
</script>

</body></html>