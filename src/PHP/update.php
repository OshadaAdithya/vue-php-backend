<?php


include "db.php";

header("Access-Control-Allow-Origin: *");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $recived_data= file_get_contents("php://input");
    $decoded_data= json_decode($recived_data, true);   

    $id= $decoded_data["id"];
    $taskName= $decoded_data["taskName"];
    $status_pass= $decoded_data["status_pass"];

    /*$query= "UPDATE vue_task 
    set task= $taskName, status=$status_pass  
    WHERE id= $id";*/

    $query= "UPDATE vue_task 
    SET task = ?, status = ? 
    WHERE id = ?";

    $stmt= $connection->prepare($query);
    $stmt->bind_param("ssi", $taskName, $status_pass, $id);
    $stmt->execute();

}
?>