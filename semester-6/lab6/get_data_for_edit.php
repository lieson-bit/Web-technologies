<?php
include 'db.php';

$id = $_GET['id'];
$table = $_GET['table'];

// Get data for robots
if ($table == 'robots') {
    $query = "SELECT * FROM robots WHERE id = $id";
    $result = $conn->query($query);
    $robot = $result->fetch_assoc();

    // Return the HTML form for editing a robot
    echo '
        <label for="model_name">Модель:</label>
        <input type="text" name="model_name" value="' . $robot['model_name'] . '" required><br>
        
        <label for="type">Тип:</label>
        <input type="text" name="type" value="' . $robot['type'] . '" required><br>

        <label for="weight">Вес (кг):</label>
        <input type="number" step="0.1" name="weight" value="' . $robot['weight'] . '" required><br>

        <label for="payload">Грузоподъёмность (кг):</label>
        <input type="number" step="0.1" name="payload" value="' . $robot['payload'] . '" required><br>

        <label for="manufacturer_id">Производитель:</label>
        <select name="manufacturer_id" required>';
    
    // Fetch manufacturers for the dropdown
    $manu_result = $conn->query("SELECT id, name FROM manufacturers");
    while ($manu = $manu_result->fetch_assoc()) {
        echo "<option value='{$manu['id']}'" . ($robot['manufacturer_id'] == $manu['id'] ? ' selected' : '') . ">{$manu['name']}</option>";
    }
    
    echo '</select><br>';
} else {
    // Get data for manufacturers
    $query = "SELECT * FROM manufacturers WHERE id = $id";
    $result = $conn->query($query);
    $manufacturer = $result->fetch_assoc();

    // Return the HTML form for editing a manufacturer
    echo '
        <label for="name">Название:</label>
        <input type="text" name="name" value="' . $manufacturer['name'] . '" required><br>
        
        <label for="country">Страна:</label>
        <input type="text" name="country" value="' . $manufacturer['country'] . '" required><br>

        <label for="founded_year">Год основания:</label>
        <input type="number" name="founded_year" value="' . $manufacturer['founded_year'] . '" required><br>

        <label for="website">Веб-сайт:</label>
        <input type="url" name="website" value="' . $manufacturer['website'] . '"><br>

        <label for="rating">Рейтинг:</label>
        <input type="number" step="0.1" name="rating" value="' . $manufacturer['rating'] . '"><br>';
}
?>
