<?php
require_once 'config.php';

$perPage = 10;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $perPage;

$search = isset($_GET['search']) ? trim($_GET['search']) : "";

$filter = isset($_GET['filter']) ? $_GET['filter'] : "All";

$where = " WHERE 1 ";
$params = [];
$types = "";

if ($search !== "") {
    $where .= " AND material_name LIKE ? ";
    $params[] = "%$search%";
    $types .= "s";
}

if ($filter === "Active" || $filter === "Inactive") {
    $where .= " AND status = ? ";
    $params[] = $filter;
    $types .= "s";
}

$countSql = "SELECT COUNT(*) FROM materials $where";
$stmt = $mysqli->prepare($countSql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$stmt->bind_result($totalRows);
$stmt->fetch();
$stmt->close();

$totalPages = ceil($totalRows / $perPage);

$dataSql = "SELECT * FROM materials $where ORDER BY id ASC LIMIT ?, ?";
$stmt = $mysqli->prepare($dataSql);

if (!empty($params)) {
    $types2 = $types . "ii";
    $params2 = array_merge($params, [$offset, $perPage]);
    $stmt->bind_param($types2, ...$params2);
} else {
    $stmt->bind_param("ii", $offset, $perPage);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<?php include 'header.php'; ?>

<h3 class="mb-4 fw-bold">Material List</h3>

<form class="row g-3 mb-3" method="GET">
    <div class="col-md-4">
        <input type="text" name="search" class="form-control" placeholder="Search material"
               value="<?php echo htmlspecialchars($search); ?>">
    </div>

    <div class="col-md-3">
        <select name="filter" class="form-select">
            <option value="All" <?php if ($filter === "All") echo "selected"; ?>>All</option>
            <option value="Active" <?php if ($filter === "Active") echo "selected"; ?>>Active</option>
            <option value="Inactive" <?php if ($filter === "Inactive") echo "selected"; ?>>Inactive</option>
        </select>
    </div>

    <div class="col-md-3">
        <button class="btn btn-primary w-100">Search</button>
    </div>

    <div class="col-md-2">
        <a href="add.php" class="btn btn-success w-100">+ Add Material</a>
    </div>
</form>

<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Material Name</th>
            <th>UOM</th>
            <th>Cost / Unit</th>
            <th>Status</th>
            <th width="180px">Actions</th>
        </tr>
        </thead>

        <tbody>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['material_name']); ?></td>
                    <td><?php echo $row['uom']; ?></td>
                    <td><?php echo number_format($row['cost_per_unit'], 2); ?></td>
                    <td><?php echo $row['status']; ?></td>

                    <td>
                        <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                        <a href="delete.php?id=<?php echo $row['id']; ?>"
                           class="btn btn-sm btn-danger"
                           onclick="return confirm('Are you sure you want to delete this material?');">
                           Delete
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="6" class="text-center">No materials found.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<nav>
    <ul class="pagination">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                <a class="page-link"
                   href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>&filter=<?php echo $filter; ?>">
                    <?php echo $i; ?>
                </a>
            </li>
        <?php endfor; ?>
    </ul>
</nav>

<?php include 'footer.php'; ?>
