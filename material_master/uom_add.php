<?php
require_once 'config.php';
$errors = [];
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uom = trim($_POST['uom_name']);

    if ($uom === "") {
        $errors[] = "UOM name is required.";
    }

    if (empty($errors)) {
        $stmt = $mysqli->prepare("INSERT INTO uom_master (uom_name, status) VALUES (?, 'Active')");
        $stmt->bind_param("s", $uom);

        if ($stmt->execute()) {
            $success = "UOM added successfully!";
        } else {
            $errors[] = "Database error: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>

<?php include 'header.php'; ?>

<h3 class="fw-bold mb-3">Add UOM</h3>

<?php if ($success): ?>
    <div class="alert alert-success"><?= $success ?></div>
<?php endif; ?>

<form method="POST" class="row g-3">
    <div class="col-md-6">
        <label class="form-label">UOM Name *</label>
        <input type="text" name="uom_name" class="form-control" required>
    </div>

    <div class="col-12">
        <button class="btn btn-primary">Add UOM</button>
        <a href="uom_list.php" class="btn btn-secondary">Back</a>
    </div>
</form>

<?php include 'footer.php'; ?>
