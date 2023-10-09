
<?php

include "db.php";
header("Access-Control-Allow-Origin: *");
//header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
//header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] === 'POST') { 

$recived_data= file_get_contents("php://input");
$decoded_data= json_decode($recived_data, true);

if($decoded_data!== null){
    $stmt = $connection->prepare("INSERT INTO vue_task (task, status) VALUES (?, ?)");

    $stmt->bind_param("ss", $decoded_data['taskName'], $decoded_data['status_pass']);

    $stmt->execute();

    echo json_encode(array('message' => 'Data saved successfully'));

    $stmt->close();
    $connection->close();

}else {
    // JSON data couldn't be decoded
    echo json_encode(array('message' => 'Invalid JSON data'));
}

}


?>