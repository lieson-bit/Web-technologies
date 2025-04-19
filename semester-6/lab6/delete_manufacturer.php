<?php
include 'db.php';
$id = $_GET['id'];
$conn->query("DELETE FROM manufacturers WHERE id=$id");
header("Location: index.php?table=manufacturers");
?>