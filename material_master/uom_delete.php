<?php
require_once 'config.php';

if (!isset($_GET['id'])) die("Invalid ID");
$id = intval($_GET['id']);

$stmt = $mysqli->prepare("UPDATE uom_master SET status='Inactive' WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: uom_list.php?msg=deleted");
exit;
