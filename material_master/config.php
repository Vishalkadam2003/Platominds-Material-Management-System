<?php
$host = 'localhost';
$db   = 'platominds_tests';
$user = 'root';
$pass = ''; 
$charset = 'utf8mb4';

$mysqli = new mysqli($host, $user, $pass, $db);

if ($mysqli->connect_errno) {
    die("Database connection failed: " . $mysqli->connect_error);
}

$mysqli->set_charset($charset);
?>
