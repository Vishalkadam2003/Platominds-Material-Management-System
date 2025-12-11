<?php
require_once 'config.php';

$result = $mysqli->query("SELECT COUNT(*) AS total FROM materials");
$row = $result->fetch_assoc();

echo "Materials count: " . $row['total'];
?>
