<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "library_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);

    $sql = "INSERT INTO contacts (name, email, phone, created_at) 
            VALUES ('$name','$email','$phone', NOW())";
    if ($conn->query($sql) === TRUE) $success = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Insert Entry - Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<style>
body { background: #1c1c1c; color: #fff; font-family: Arial, sans-serif; }
.content-card { background: rgba(0,0,0,0.75); padding: 30px; border-radius: 15px; box-shadow: 0 8px 20px rgba(0,0,0,0.3); }
.btn-primary { background-color: #0d6efd; border: none; }
.btn-primary:hover { background-color: #0b5ed7; }
footer { background: rgba(0,0,0,0.85); color: white; text-align: center; padding: 15px; margin-top: 50px; }
</style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php"><i class="bi bi-book-half"></i> Dashboard</a>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="insert_entry.php">Insert Entry</a></li>
        <li class="nav-item"><a class="nav-link" href="view.php">View Entries</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- Form -->
<div class="container mt-5 pt-5">
    <div class="content-card mx-auto" style="max-width:600px;">
        <h2 class="mb-4 text-center"><i class="bi bi-person-plus-fill"></i> Insert New Entry</h2>

        <?php if($success): ?>
            <div class="alert alert-success text-center">Entry inserted successfully!</div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" class="form-control" placeholder="Full Name" required>
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" placeholder="Email Address" required>
            </div>
            <div class="mb-3">
                <label>Phone</label>
                <input type="text" name="phone" class="form-control" placeholder="Phone Number" required>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Insert Entry</button>
                <a href="view.php" class="btn btn-secondary"><i class="bi bi-eye"></i> View Entries</a>
            </div>
        </form>
    </div>
</div>

<footer>
  Developed by Shanmugam Pirasanth | <i class="bi bi-c-circle"></i> <?php echo date("Y"); ?>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
