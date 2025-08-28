<?php
include 'config.php';

if(isset($_GET['id'])){
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM contacts WHERE id=$id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
}

if(isset($_POST['update'])){
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);

    if(empty($name) || empty($email) || empty($phone)){
        die("All fields are required!");
    }

    $sql = "UPDATE contacts SET name='$name', email='$email', phone='$phone' WHERE id=$id";
    if($conn->query($sql) === TRUE){
        header("Location: view.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Update Entry</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<style>
body { background: #1c1c1c; color: #fff; font-family: Arial, sans-serif; }
.content-card { background: rgba(0,0,0,0.75); padding: 30px; border-radius: 15px; box-shadow: 0 8px 20px rgba(0,0,0,0.3); max-width:600px; margin:auto; margin-top:80px;}
.btn-success { background-color: #198754; border:none; }
.btn-success:hover { background-color: #157347; }
</style>
</head>
<body>

<div class="content-card">
<h2 class="mb-4 text-center"><i class="bi bi-pencil-square"></i> Update Entry</h2>

<form method="POST">
    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" value="<?= $row['name'] ?>" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" value="<?= $row['email'] ?>" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Phone</label>
        <input type="text" name="phone" value="<?= $row['phone'] ?>" class="form-control" required>
    </div>
    <div class="text-center">
        <button type="submit" name="update" class="btn btn-success"><i class="bi bi-save"></i> Update</button>
        <a href="view.php" class="btn btn-secondary"><i class="bi bi-x-circle"></i> Cancel</a>
    </div>
</form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
