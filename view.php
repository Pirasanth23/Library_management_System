<?php
$conn = new mysqli("localhost", "root", "", "library_db");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// Handle search query
$search = "";
if (isset($_GET['search'])) {
    $search = $conn->real_escape_string($_GET['search']);
    $sql = "SELECT * FROM contacts 
            WHERE name LIKE '%$search%' 
               OR email LIKE '%$search%' 
               OR phone LIKE '%$search%' 
            ORDER BY id DESC";
} else {
    $sql = "SELECT * FROM contacts ORDER BY id DESC";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>View Contact Entries</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<style>
body { background: #1c1c1c; color: #fff; font-family: Arial, sans-serif; }
.content-card { background: rgba(0,0,0,0.75); padding: 30px; border-radius: 15px; box-shadow: 0 8px 20px rgba(0,0,0,0.3); }
.btn-primary { background-color: #0d6efd; border: none; }
.btn-primary:hover { background-color: #0b5ed7; }
.btn-danger { background-color: #dc3545; border: none; }
.btn-danger:hover { background-color: #b02a37; }
.btn-secondary { background-color: #6c757d; border: none; color: #fff; }
.btn-secondary:hover { background-color: #5a6268; color: #fff; }
table { background: rgba(255,255,255,0.05); color: #fff; }
th, td { vertical-align: middle !important; text-align: center; cursor: pointer; }
table tbody tr:hover { background: rgba(13, 110, 253, 0.2); }
footer { background: rgba(0,0,0,0.85); color: white; text-align: center; padding: 15px; margin-top: 50px; }
.navbar-dark .navbar-nav .nav-link { color: #fff; }
.navbar-dark .navbar-nav .nav-link:hover { color: #0d6efd; }
</style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php"><i class="bi bi-book-half"></i> Dashboard</a>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="insert.php">Insert Entry</a></li>
        <li class="nav-item"><a class="nav-link active" href="view.php">View Entries</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- Content Card -->
<div class="container mt-5 pt-5">
    <div class="content-card mx-auto" style="max-width:1100px;">
        <h2 class="mb-4 text-center"><i class="bi bi-eye-fill"></i> All Contact Entries</h2>

        <!-- Success Alert -->
        <?php if(isset($_GET['success'])): ?>
            <div class="alert alert-success text-center" role="alert">
                <?= htmlspecialchars($_GET['success']) ?>
            </div>
        <?php endif; ?>

        <!-- Search Bar -->
        <form method="GET" class="mb-4 text-center">
            <div class="input-group" style="max-width:500px; margin:auto;">
                <input type="text" name="search" class="form-control" placeholder="Search by name, email, or phone" value="<?= htmlspecialchars($search) ?>">
                <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i> Search</button>
                <a href="view.php" class="btn btn-secondary"><i class="bi bi-x-circle"></i> Reset</a>
            </div>
        </form>

        <!-- Table -->
        <div class="table-responsive">
            <table class="table table-bordered text-white" id="entriesTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th onclick="sortTable(1)">Name</th>
                        <th onclick="sortTable(2)">Email</th>
                        <th onclick="sortTable(3)">Phone</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= $row['name'] ?></td>
                            <td><?= $row['email'] ?></td>
                            <td><?= $row['phone'] ?></td>
                            <td><?= $row['created_at'] ?></td>
                            <td>
                                <a href="update.php?id=<?= $row['id'] ?>" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Edit</a>
                                <!-- Delete Button triggers modal -->
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $row['id'] ?>">
                                    <i class="bi bi-trash"></i> Delete
                                </button>

                                <!-- Delete Modal -->
                                <div class="modal fade" id="deleteModal<?= $row['id'] ?>" tabindex="-1" aria-hidden="true">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title">Confirm Delete</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                      </div>
                                      <div class="modal-body">
                                        Are you sure you want to delete <b><?= $row['name'] ?></b>?
                                      </div>
                                      <div class="modal-footer">
                                        <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-danger">Yes, Delete</a>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="6" class="text-center">No entries found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="text-center mt-4">
            <a href="insert.php" class="btn btn-primary"><i class="bi bi-person-plus-fill"></i> Insert New Entry</a>
        </div>
    </div>
</div>

<footer>
  Developed by Shanmugam Pirasanth | <i class="bi bi-c-circle"></i> <?= date("Y") ?>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Table Sorting -->
<script>
function sortTable(n) {
    let table = document.getElementById("entriesTable");
    let switching = true;
    while (switching) {
        switching = false;
        let rows = table.rows;
        for (let i = 1; i < rows.length - 1; i++) {
            let shouldSwitch = false;
            let x = rows[i].getElementsByTagName("TD")[n];
            let y = rows[i + 1].getElementsByTagName("TD")[n];
            if(x && y && x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()){
                shouldSwitch = true;
                break;
            }
        }
        if(shouldSwitch){
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
        }
    }
}
</script>

</body>
</html>
