<?php
require_once 'config.php';

$result = $mysqli->query("SELECT * FROM uom_master ORDER BY id DESC");
?>

<?php include 'header.php'; ?>

<h3 class="fw-bold mb-4">UOM List</h3>

<a href="uom_add.php" class="btn btn-success mb-3">+ Add UOM</a>

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>UOM Name</th>
            <th>Status</th>
            <th width="180px">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['uom_name']) ?></td>
            <td><?= $row['status'] ?></td>
            <td>
                <a href="uom_edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                <a href="uom_delete.php?id=<?= $row['id'] ?>" 
                   class="btn btn-sm btn-danger"
                   onclick="return confirm('Delete this UOM?');">
                    Delete
                </a>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php include 'footer.php'; ?>
