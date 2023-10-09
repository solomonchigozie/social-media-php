<?php 

$host = "localhost";
$database = "phpour";
$username = "root";
$password = "";

$conn = mysqli_connect($host, $username, $password, $database);

if(!$conn){
    die('connection failed');
}



?>