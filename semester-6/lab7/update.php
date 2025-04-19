<?php
header('Content-Type: application/json');
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $response = ['success' => false];
    
    try {
        $id = (int)$_POST['id'];
        $table = $_POST['table'];

        if ($table == 'robots') {
            $model_name = $conn->real_escape_string($_POST['model_name']);
            $type = $conn->real_escape_string($_POST['type']);
            $weight = (float)$_POST['weight'];
            $payload = (float)$_POST['payload'];
            $manufacturer_id = (int)$_POST['manufacturer_id'];

            $query = "UPDATE robots SET 
                     model_name = '$model_name', 
                     type = '$type', 
                     weight = $weight, 
                     payload = $payload, 
                     manufacturer_id = $manufacturer_id 
                     WHERE id = $id";
        } else {
            $name = $conn->real_escape_string($_POST['name']);
            $country = $conn->real_escape_string($_POST['country']);
            $founded_year = (int)$_POST['founded_year'];
            $website = $conn->real_escape_string($_POST['website']);
            $rating = (float)$_POST['rating'];

            $query = "UPDATE manufacturers SET 
                     name = '$name', 
                     country = '$country', 
                     founded_year = $founded_year, 
                     website = '$website', 
                     rating = $rating 
                     WHERE id = $id";
        }

        if ($conn->query($query)) {
            $response['success'] = true;
        } else {
            $response['error'] = $conn->error;
        }
    } catch (Exception $e) {
        $response['error'] = $e->getMessage();
    }
    
    echo json_encode($response);
    exit();
}

echo json_encode(['success' => false, 'error' => 'Invalid request method']);
?>