<?php
$database = "ECEInDB";
$host = 'db'; 
$user = 'root'; 
$pass = 'mypassword'; 
$charset = 'utf8mb4'; 

$db_handle = mysqli_connect($host, $user, $pass, $database, 3300);

$db_found = mysqli_select_db($db_handle, $database);
?>