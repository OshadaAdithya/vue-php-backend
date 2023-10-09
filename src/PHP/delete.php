<?php

include('db.php');
header("Access-Control-Allow-Origin: *");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $recived_data= file_get_contents("php://input");
    $decoded_data= json_decode($recived_data, true);   

    $id= $decoded_data["id"];
    $query = "DELETE FROM vue_task WHERE id=$id";

    $stmt= $connection->prepare($query);
    $stmt->execute();
    
 }

?>