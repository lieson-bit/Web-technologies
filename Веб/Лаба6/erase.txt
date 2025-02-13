<?php
$connection = new mysqli("localhost", "root", "Orlov476qwer!", "web");
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
if ($_POST["idRow"] != null) {
    $sql =
        "select id_developer from audioeditor where id_audioeditor = " .
        $_POST["idRow"];
    $result = $connection->query($sql);

    if (!$result) {
        die("Invalid query: " . $connection->error);
    }
    foreach ($result as $row) {
        $idKey = $row["id_developer"];
    }
    $sql = "delete from audioeditor where id_audioeditor = " . $_POST["idRow"];
    $result = $connection->query($sql);

    if (!$result) {
        die("Invalid query: " . $connection->error);
    }
    $sql = "select * from audioeditor where id_developer =" . $idKey;
    $result = $connection->query($sql);
    if (!$result) {
        die("Invalid query: " . $connection->error);
    }
    if ($result->num_rows == 0) {
        $sql = "delete from developer where id_developer =" . $idKey;
        $result = $connection->query($sql);
        if (!$result) {
            die("Invalid query: " . $connection->error);
        }
    }
}

header("Location: db.php");
die();
?>
