<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name  = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);

    // ---- Server-side Validation ----
    if (empty($name) || empty($email) || empty($phone)) {
        die("<script>alert('⚠️ All fields are required!'); window.history.back();</script>");
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("<script>alert('⚠️ Invalid email format!'); window.history.back();</script>");
    }
    if (!is_numeric($phone) || strlen($phone) != 10) {
        die("<script>alert('⚠️ Phone must be 10 digits!'); window.history.back();</script>");
    }

    // ---- Insert Data ----
    $stmt = $conn->prepare("INSERT INTO entries (name, email, phone) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $phone);

    if ($stmt->execute()) {
        echo "<script>alert('✅ Entry added successfully!'); window.location.href='form.php';</script>";
    } else {
        echo "<script>alert('❌ Database Error'); window.history.back();</script>";
    }
    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Library Management - Form</title>
  <link rel="icon" type="image/x-icon" href="assets/favicon.ico">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background: url('assets/bg.jpg') no-repeat center center fixed;
      background-size: cover;
      min-height: 100vh;
    }
    .content-card {
      background: rgba(255, 255, 255, 0.92);
      border-radius: 15px;
      padding: 20px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }
    footer {
      background: rgba(0, 0, 0, 0.7);
      color: white;
      padding: 10px;
      border-radius: 10px;
      margin-top: 30px;
    }
  </style>
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.html"><i class="bi bi-book-half"></i> Library</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="index.html"><i class="bi bi-house-door"></i> Home</a></li>
          <li class="nav-item"><a class="nav-link active" href="form.php"><i class="bi bi-file-earmark-plus"></i> Form</a></li>
          <li class="nav-item"><a class="nav-link" href="about.html"><i class="bi bi-info-circle"></i> About</a></li>
          <li class="nav-item"><a class="nav-link" href="contact.html"><i class="bi bi-envelope"></i> Contact</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Form -->
  <div class="container mt-5">
    <div class="content-card">
      <h2 class="mb-4 text-center"><i class="bi bi-pencil-square"></i> Add Entry</h2>
      <form method="POST" action="form.php" onsubmit="return validateForm()">
        <div class="mb-3">
          <label class="form-label"><i class="bi bi-person-fill"></i> Name</label>
          <input type="text" id="name" name="name" class="form-control" placeholder="Enter Name">
        </div>
        <div class="mb-3">
          <label class="form-label"><i class="bi bi-envelope-fill"></i> Email</label>
          <input type="email" id="email" name="email" class="form-control" placeholder="Enter Email">
        </div>
        <div class="mb-3">
          <label class="form-label"><i class="bi bi-telephone-fill"></i> Phone</label>
          <input type="text" id="phone" name="phone" class="form-control" placeholder="Enter 10-digit Phone">
        </div>
        <button type="submit" class="btn btn-success"><i class="bi bi-check2-circle"></i> Submit</button>
        <button type="reset" class="btn btn-secondary"><i class="bi bi-x-circle"></i> Clear</button>
      </form>
    </div>
  </div>

  <footer class="text-center">Developed by [Your Name] | <i class="bi bi-c-circle"></i> 2025</footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function validateForm() {
      let name = document.getElementById("name").value.trim();
      let email = document.getElementById("email").value.trim();
      let phone = document.getElementById("phone").value.trim();
      if (name===""||email===""||phone===""){alert("⚠️ All fields required");return false;}
      if (!email.includes("@")||!email.includes(".")){alert("⚠️ Invalid email");return false;}
      if (phone.length!==10||isNaN(phone)){alert("⚠️ Phone must be 10 digits");return false;}
      return true;
    }
  </script>
</body>
</html>
