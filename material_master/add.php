<?php
require_once 'config.php';

$errors = [];
$success = "";

$material_name = "";
$uom = "KG";
$cost_per_unit = "";
$description = "";
$status = "Active";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $material_name = trim($_POST['material_name']);
    $uom = $_POST['uom'];
    $cost_per_unit = $_POST['cost_per_unit'];
    $description = trim($_POST['description']);
    $status = $_POST['status'];

    if ($material_name === "") {
        $errors[] = "Material Name is required.";
    }

    $uCheck = $mysqli->prepare("SELECT id FROM uom_master WHERE uom_name=? AND status='Active'");
    $uCheck->bind_param("s", $uom);
    $uCheck->execute();
    $uResult = $uCheck->get_result();

    if ($uResult->num_rows == 0) {
        $errors[] = "Invalid UOM selected.";
    }
    $uCheck->close();


    if ($cost_per_unit === "" || !is_numeric($cost_per_unit)) {
        $errors[] = "Cost per Unit must be a number.";
    }

    if (empty($errors)) {
        $stmt = $mysqli->prepare("INSERT INTO materials (material_name, uom, cost_per_unit, description, status) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdss", $material_name, $uom, $cost_per_unit, $description, $status);

        if ($stmt->execute()) {
            $success = "Material added successfully!";
            // here i have created Reset form
            $material_name = "";
            $uom = "KG";
            $cost_per_unit = "";
            $description = "";
            $status = "Active";
        } else {
            $errors[] = "Database error: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>

<?php include 'header.php'; ?>

<h2 class="fw-bold mb-4">Add Material</h2>

<?php if (!empty($success)): ?>
    <div class="alert alert-success"><?php echo $success; ?></div>
<?php endif; ?>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach ($errors as $e): ?>
                <li><?php echo htmlspecialchars($e); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="POST" class="row g-3">

    <div class="col-md-6">
        <label class="form-label">Material Name *</label>
        <input type="text" name="material_name" class="form-control"
               value="<?php echo htmlspecialchars($material_name); ?>" required>
    </div>

<div class="col-md-6">
    <label class="form-label">Unit of Measurement *</label>
    <select name="uom" class="form-select">
        <?php
        $uoms = $mysqli->query("SELECT uom_name FROM uom_master WHERE status='Active'");
        while ($u = $uoms->fetch_assoc()):
        ?>
            <option value="<?= $u['uom_name'] ?>"
                <?= ($uom == $u['uom_name']) ? 'selected' : '' ?>>
                <?= $u['uom_name'] ?>
            </option>
        <?php endwhile; ?>
    </select>
</div>


    <div class="col-md-6">
        <label class="form-label">Cost per Unit *</label>
        <input type="number" step="0.01" name="cost_per_unit" class="form-control"
               value="<?php echo htmlspecialchars($cost_per_unit); ?>" required>
    </div>

    <div class="col-md-6">
        <label class="form-label">Status *</label>
        <select name="status" class="form-select">
            <option value="Active" <?php if($status == "Active") echo "selected"; ?>>Active</option>
            <option value="Inactive" <?php if($status == "Inactive") echo "selected"; ?>>Inactive</option>
        </select>
    </div>

    <div class="col-12">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" rows="3"><?php echo htmlspecialchars($description); ?></textarea>
    </div>

    <div class="col-12">
        <button class="btn btn-primary">Add Material</button>
        <a href="list.php" class="btn btn-secondary">Back</a>
    </div>
</form>

<?php include 'footer.php'; ?>
