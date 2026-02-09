<?php

$db_host = 'localhost';
$db_username = 'root';
$db_password = '';
$db_name = 'xy_shop';

$conn = new mysqli("localhost", "root", "", "xy_shop");
if ($conn->connect_error) 
{
    die("Connection failed: " . $conn->connect_error);
}
 else 
{
    echo "Database connection successful.";
}
?>