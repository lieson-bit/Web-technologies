<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "robotics"; // you must create this DB manually

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}
?>
