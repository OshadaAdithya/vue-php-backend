<?php

//header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Origin: http://127.0.0.1:5173");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Origin, Content-Type, Accept");

//header("Content-Type: application/json");
function fetchRecords(){
  include "db.php";
  
  $sql = "SELECT id,task,status FROM vue_task";
  $result= $connection -> query($sql);

  $response= array();

  while($row= mysqli_fetch_array($result)){
    $response[]= $row;
  }

  echo json_encode($response);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  fetchRecords();
}
exit;
?>