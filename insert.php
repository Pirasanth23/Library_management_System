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

    // Server-side validation
    if (!empty($name) && !empty($email) && !empty($phone) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $sql = "INSERT INTO contacts (name, email, phone, created_at) 
                VALUES ('$name','$email','$phone', NOW())";
        if ($conn->query($sql) === TRUE) $success = true;
    } else {
        $error = "Please enter valid Name, Email, and Phone!";
    }
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
.btn-secondary { background-color: #6c757d; border: none; color: #fff; }
.btn-secondary:hover { background-color: #5a6268; color: #fff; }
footer { background: rgba(0,0,0,0.85); color: white; text-align: center; padding: 15px; margin-top: 50px; }
input:invalid { border-color: red; }
input:valid { border-color: green; }
</style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php"><i class="bi bi-book-half"></i> Dashboard</a>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link active" href="insert.php">Insert Entry</a></li>
        <li class="nav-item"><a class="nav-link" href="view.php">View Entries</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- Form -->
<div class="container mt-5 pt-5">
    <div class="content-card mx-auto" style="max-width:600px;">
        <h2 class="mb-4 text-center"><i class="bi bi-person-plus-fill"></i> Insert New Entry</h2>

        <?php if(isset($success) && $success): ?>
            <div class="alert alert-success text-center">Entry inserted successfully!</div>
        <?php elseif(isset($error)): ?>
            <div class="alert alert-danger text-center"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST" id="insertForm" novalidate>
            <div class="mb-3">
                <label>Name</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Full Name" required oninput="this.value = this.value.toUpperCase()">
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="Email Address" required>
            </div>
            <div class="mb-3">
                <label>Phone</label>
                <input type="text" id="phone" name="phone" class="form-control" placeholder="Phone Number" required oninput="this.value=this.value.replace(/[^0-9]/g,'')">
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Insert Entry</button>
                <a href="view.php" class="btn btn-secondary"><i class="bi bi-eye"></i> View Entries</a>
            </div>
        </form>
    </div>
</div>

<footer>
  Developed by Shanmugam Pirasanth | <i class="bi bi-c-circle"></i> <?= date("Y") ?>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Real-time validation
document.getElementById("name").addEventListener("input", function() {
    if(this.value.length < 3) this.style.borderColor = "red";
    else this.style.borderColor = "green";
});
document.getElementById("email").addEventListener("input", function() {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    this.style.borderColor = regex.test(this.value) ? "green" : "red";
});
document.getElementById("phone").addEventListener("input", function() {
    this.value = this.value.replace(/[^0-9]/g,'');
    this.style.borderColor = this.value.length >= 10 ? "green" : "red";
});
</script>

</body>
</html>
