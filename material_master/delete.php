<?php
require_once 'config.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid material ID");
}

$id = intval($_GET['id']);

$stmt = $mysqli->prepare("UPDATE materials SET status = 'Inactive' WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: list.php?msg=deleted");
    exit;
} else {
    die("Error deleting material: " . $stmt->error);
}
