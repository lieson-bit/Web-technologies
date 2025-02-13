<?php
$connection = new mysqli("localhost", "root", "Orlov476qwer!", "web");
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
if (
    ($_POST["typeCompany"] != null ||
        $_POST["developer_name"] != null ||
        $_POST["headquarter"] != null ||
        $_POST["dateOfFoundation"] != null ||
        $_POST["keyPeople"] != null) &&
    ($_POST["audioEditor_Name"] != null ||
        $_POST["licence"] != null ||
        $_POST["Windows"] != null ||
        $_POST["MacOS"] != null ||
        $_POST["Linux"] != null)
) {
    $sql = "select id_developer from developer where typeCompany like '".$_POST["typeCompany"]."' and developer_name like '".$_POST["developer_name"]."' and headquarter like '".$_POST["headquarter"]."' and dateOfFoundation like '".$_POST["dateOfFoundation"]."' and keyPeople like '".$_POST["keyPeople"]."'";
    $result = $connection->query($sql);

    if (!$result) {
        die("Invalid query: " . $connection->error);
    }
    
    if($result->num_rows == 0){
        $sql =
        "INSERT INTO developer(typeCompany, developer_name, headquarter, dateOfFoundation, keyPeople) values ('" .
        $_POST["typeCompany"] .
        "','" .
        $_POST["developer_name"] .
        "','" .
        $_POST["headquarter"] .
        "','" .
        $_POST["dateOfFoundation"] .
        "','" .
        $_POST["keyPeople"] .
        "')";
    $result = $connection->query($sql);

        if (!$result) {
            die("Invalid query: " . $connection->error);
        }
        $next_id=mysqli_insert_id($connection);
    }
    else{
        foreach($result as $row){
            $next_id = $row["id_developer"];
        }        
    }
    $sql =
        "INSERT INTO audioEditor(audioEditor_Name, licence, Windows, MacOS, Linux, id_developer) values ('" .
        $_POST["audioEditor_Name"] .
        "','" .
        $_POST["licence"] .
        "','" .
        $_POST["Windows"] .
        "','" .
        $_POST["MacOS"] .
        "','" .
        $_POST["Linux"] .
        "',$next_id)";
    $result = $connection->query($sql);

    if (!$result) {
        die("Invalid query: " . $connection->error);
    }
}

header("Location: db.php");
die();
?>
