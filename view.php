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
.btn-secondary { background-color: #6c757d; border: none; color: #fff; }
.btn-secondary:hover { background-color: #5a6268; color: #fff; }
table { background: rgba(255,255,255,0.05); color: #fff; }
table tbody tr:hover { background: rgba(13, 110, 253, 0.2); }
th, td { vertical-align: middle !important; }
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

<!-- Table -->
<div class="container mt-5 pt-5">
    <div class="content-card mx-auto" style="max-width:1000px;">
        <h2 class="mb-4 text-center"><i class="bi bi-eye-fill"></i> All Contact Entries</h2>

        <!-- Search Bar -->
        <form method="GET" class="mb-3 text-center">
            <div class="input-group" style="max-width:500px; margin:auto;">
                <input type="text" name="search" class="form-control" placeholder="Search by name, email, or phone" value="<?= htmlspecialchars($search) ?>">
                <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i> Search</button>
                <a href="view.php" class="btn btn-secondary"><i class="bi bi-x-circle"></i> Reset</a>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered text-white">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Created At</th>
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
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="5" class="text-center">No entries found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="text-center mt-3">
            <a href="insert.php" class="btn btn-primary"><i class="bi bi-person-plus-fill"></i> Insert New Entry</a>
        </div>
    </div>
</div>

<footer>
  Developed by Shanmugam Pirasanth | <i class="bi bi-c-circle"></i> <?= date("Y") ?>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
