<?php

$servername="localhost";
$username="root";
$password="";
$database= "php-vue.js";

$connection = new mysqli($servername, $username, $password, $database);

if (!$connection){
    die("connection failed: " . $connection -> connect_error);

}
?>