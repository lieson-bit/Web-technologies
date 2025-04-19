<?php
include 'db.php';

$id = $_GET['id'];
$table = $_GET['table'];

if ($table == 'robots') {
    $query = "SELECT * FROM robots WHERE id = $id";
    $result = $conn->query($query);
    $item = $result->fetch_assoc();

    echo '
        <div class="form-group">
            <label>Модель:</label>
            <input type="text" name="model_name" value="'.htmlspecialchars($item['model_name']).'" required>
        </div>
        <div class="form-group">
            <label>Тип:</label>
            <input type="text" name="type" value="'.htmlspecialchars($item['type']).'" required>
        </div>
        <div class="form-group">
            <label>Вес (кг):</label>
            <input type="number" step="0.1" name="weight" value="'.$item['weight'].'" required>
        </div>
        <div class="form-group">
            <label>Грузоподъёмность (кг):</label>
            <input type="number" step="0.1" name="payload" value="'.$item['payload'].'" required>
        </div>
        <div class="form-group">
            <label>Производитель:</label>
            <select id="edit-manufacturer-select" name="manufacturer_id" required>';
    
    $manu_result = $conn->query("SELECT id, name FROM manufacturers");
    while ($manu = $manu_result->fetch_assoc()) {
        $selected = ($manu['id'] == $item['manufacturer_id']) ? ' selected' : '';
        echo "<option value='{$manu['id']}'$selected>{$manu['name']}</option>";
    }
    
    echo '</select></div>';
} else {
    $query = "SELECT * FROM manufacturers WHERE id = $id";
    $result = $conn->query($query);
    $item = $result->fetch_assoc();

    echo '
        <div class="form-group">
            <label>Название:</label>
            <input type="text" name="name" value="'.htmlspecialchars($item['name']).'" required>
        </div>
        <div class="form-group">
            <label>Страна:</label>
            <input type="text" name="country" value="'.htmlspecialchars($item['country']).'" required>
        </div>
        <div class="form-group">
            <label>Год основания:</label>
            <input type="number" name="founded_year" value="'.$item['founded_year'].'" required>
        </div>
        <div class="form-group">
            <label>Веб-сайт:</label>
            <input type="url" name="website" value="'.htmlspecialchars($item['website']).'">
        </div>
        <div class="form-group">
            <label>Рейтинг:</label>
            <input type="number" step="0.1" name="rating" value="'.$item['rating'].'" min="0" max="10">
        </div>';
}
?>