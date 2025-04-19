<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $table = isset($_POST['table']) ? $_POST['table'] : 'robots'; // Default to robots

    if ($table == 'robots') {
        $model_name = $_POST['model_name'];
        $type = $_POST['type'];
        $weight = $_POST['weight'];
        $payload = $_POST['payload'];
        $manufacturer_id = $_POST['manufacturer_id'];

        $query = "UPDATE robots SET model_name = '$model_name', type = '$type', weight = '$weight', payload = '$payload', manufacturer_id = '$manufacturer_id' WHERE id = $id";
    } else {
        $name = $_POST['name'];
        $country = $_POST['country'];
        $founded_year = $_POST['founded_year'];
        $website = $_POST['website'];
        $rating = $_POST['rating'];

        $query = "UPDATE manufacturers SET name = '$name', country = '$country', founded_year = '$founded_year', website = '$website', rating = '$rating' WHERE id = $id";
    }

    if ($conn->query($query)) {
        echo 'success';
    } else {
        echo 'error';
    }
}
?>
