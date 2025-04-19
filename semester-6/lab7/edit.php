<?php
include 'db.php';

$id = $_GET['id'];
$table = $_GET['table'];

// Fetch the item to edit
if ($table == 'robots') {
    $query = "SELECT * FROM robots WHERE id = $id";
    $result = $conn->query($query);
    $item = $result->fetch_assoc();
    
    $title = "Редактировать робота";
} else {
    $query = "SELECT * FROM manufacturers WHERE id = $id";
    $result = $conn->query($query);
    $item = $result->fetch_assoc();
    
    $title = "Редактировать производителя";
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1><?php echo $title; ?></h1>
        
        <form action="update.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="hidden" name="table" value="<?php echo $table; ?>">
            
            <?php if ($table == 'robots'): ?>
                <div class="form-group">
                    <label>Модель:</label>
                    <input type="text" name="model_name" value="<?php echo htmlspecialchars($item['model_name']); ?>" required>
                </div>
                <div class="form-group">
                    <label>Тип:</label>
                    <input type="text" name="type" value="<?php echo htmlspecialchars($item['type']); ?>" required>
                </div>
                <div class="form-group">
                    <label>Вес (кг):</label>
                    <input type="number" step="0.1" name="weight" value="<?php echo $item['weight']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Грузоподъёмность (кг):</label>
                    <input type="number" step="0.1" name="payload" value="<?php echo $item['payload']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Производитель:</label>
                    <select name="manufacturer_id" required>
                        <?php
                        $manu_result = $conn->query("SELECT id, name FROM manufacturers");
                        while ($manu = $manu_result->fetch_assoc()) {
                            $selected = ($manu['id'] == $item['manufacturer_id']) ? ' selected' : '';
                            echo "<option value='{$manu['id']}'$selected>{$manu['name']}</option>";
                        }
                        ?>
                    </select>
                </div>
            <?php else: ?>
                <div class="form-group">
                    <label>Название:</label>
                    <input type="text" name="name" value="<?php echo htmlspecialchars($item['name']); ?>" required>
                </div>
                <div class="form-group">
                    <label>Страна:</label>
                    <input type="text" name="country" value="<?php echo htmlspecialchars($item['country']); ?>" required>
                </div>
                <div class="form-group">
                    <label>Год основания:</label>
                    <input type="number" name="founded_year" value="<?php echo $item['founded_year']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Веб-сайт:</label>
                    <input type="url" name="website" value="<?php echo htmlspecialchars($item['website']); ?>">
                </div>
                <div class="form-group">
                    <label>Рейтинг:</label>
                    <input type="number" step="0.1" name="rating" value="<?php echo $item['rating']; ?>" min="0" max="10">
                </div>
            <?php endif; ?>
            
            <div class="form-actions">
                <button type="submit" class="submit-btn">Сохранить</button>
                <a href="index.php" class="cancel-btn">Отмена</a>
            </div>
        </form>
    </div>
</body>
</html>