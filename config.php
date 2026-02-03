<?php
$host = "localhost";
$user = "root";
$pass = "root";
$dbname = "gallery_db";
$port = 8889;

$conn = new mysqli($host, $user, $pass, $dbname, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
session_start();
?>