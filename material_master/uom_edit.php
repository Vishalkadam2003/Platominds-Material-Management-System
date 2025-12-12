<?php
require_once 'config.php';

if (!isset($_GET['id'])) die("Invalid ID");
$id = intval($_GET['id']);

$errors = [];
$success = "";

$res = $mysqli->query("SELECT * FROM uom_master WHERE id=$id");
$data = $res->fetch_assoc();
$uom_name = $data['uom_name'];
$status = $data['status'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uom_name = trim($_POST['uom_name']);
    $status = $_POST['status'];

    if ($uom_name === "") $errors[] = "UOM name is required.";

    if (empty($errors)) {
        $stmt = $mysqli->prepare("UPDATE uom_master SET uom_name=?, status=? WHERE id=?");
        $stmt->bind_param("ssi", $uom_name, $status, $id);

        if ($stmt->execute()) {
            $success = "UOM updated!";
        }
        $stmt->close();
    }
}
?>

<?php include 'header.php'; ?>

<h3 class="fw-bold mb-4">Edit UOM</h3>

<?php if ($success): ?>
<div class="alert alert-success"><?= $success ?></div>
<?php endif; ?>

<form method="POST" class="row g-3">

    <div class="col-md-6">
        <label class="form-label">UOM Name *</label>
        <input type="text" name="uom_name" class="form-control"
               value="<?= htmlspecialchars($uom_name) ?>" required>
    </div>

    <div class="col-md-6">
        <label class="form-label">Status *</label>
        <select name="status" class="form-select">
            <option value="Active"   <?= $status=='Active'?'selected':'' ?>>Active</option>
            <option value="Inactive" <?= $status=='Inactive'?'selected':'' ?>>Inactive</option>
        </select>
    </div>

    <div class="col-12">
        <button class="btn btn-primary">Update</button>
        <a href="uom_list.php" class="btn btn-secondary">Back</a>
    </div>

</form>

<?php include 'footer.php'; ?>
