<?php
include 'db.php';

// Handle inserting a new robot
if (isset($_POST['model_name']) && isset($_POST['manufacturer_id'])) {
    $model = $_POST['model_name'];
    $type = $_POST['type'];
    $weight = $_POST['weight'];
    $payload = $_POST['payload'];
    $manu_id = $_POST['manufacturer_id'];

    // Insert the robot
    $stmt = $conn->prepare("INSERT INTO robots (model_name, type, weight, payload, manufacturer_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssddi", $model, $type, $weight, $payload, $manu_id);
    $stmt->execute();
    header("Location: index.php");
    exit();
}

// Handle inserting a new manufacturer
if (isset($_POST['name']) && isset($_POST['country'])) {
    $name = $_POST['name'];
    $country = $_POST['country'];
    $year = $_POST['founded_year'];
    $website = $_POST['website'];
    $rating = $_POST['rating'];

    // Insert the manufacturer
    $stmt = $conn->prepare("INSERT INTO manufacturers (name, country, founded_year, website, rating) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssisd", $name, $country, $year, $website, $rating);
    $stmt->execute();
    header("Location: index.php");
    exit();
}
?>

<html>
<head>
    <title>Insert Robot and Manufacturer</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Добавить нового робота и производителя</h1>

    <!-- Robot Form -->
    <h2>Добавить нового робота</h2>
    <form action="insert.php" method="POST">
        Модель: <input type="text" name="model_name" required><br>
        Тип: <input type="text" name="type" required><br>
        Вес (кг): <input type="number" step="0.1" name="weight" required><br>
        Грузоподъёмность (кг): <input type="number" step="0.1" name="payload" required><br>
        Производитель: 
        <select name="manufacturer_id" required>
            <?php
            // Fetch manufacturers for the dropdown
            $manu_result = $conn->query("SELECT id, name FROM manufacturers");
            while ($manu = $manu_result->fetch_assoc()) {
                echo "<option value='{$manu['id']}'>{$manu['name']}</option>";
            }
            ?>
        </select><br>
        <button type="submit">Добавить робота</button>
    </form>

    <!-- Manufacturer Form -->
    <h2>Добавить нового производителя</h2>
    <form action="insert.php" method="POST">
        Название: <input type="text" name="name" required><br>
        Страна: <input type="text" name="country" required><br>
        Год основания: <input type="number" name="founded_year" required><br>
        Веб-сайт: <input type="url" name="website"><br>
        Рейтинг: <input type="number" step="0.1" name="rating"><br>
        <button type="submit">Добавить производителя</button>
    </form>

</body>
</html>
