<?php
include 'config.php';

if(isset($_GET['id'])){
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM contacts WHERE id=$id";
    $result = $conn->query($sql);
    if($result->num_rows == 0){
        die("Record not found!");
    }
    $row = $result->fetch_assoc();
}

$success = false;

if(isset($_POST['update'])){
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);

    if(empty($name) || empty($email) || empty($phone)){
        $error = "All fields are required!";
    } else {
        $sql = "UPDATE contacts SET name='$name', email='$email', phone='$phone' WHERE id=$id";
        if($conn->query($sql) === TRUE){
            $success = true;
        } else {
            $error = "Error updating record: " . $conn->error;
        }
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
input:invalid { border-color: red; }
input:valid { border-color: green; }
</style>
</head>
<body>

<div class="content-card">
<h2 class="mb-4 text-center"><i class="bi bi-pencil-square"></i> Update Entry</h2>

<?php if($success): ?>
    <div class="alert alert-success text-center">Entry updated successfully! <a href="view.php" class="text-decoration-underline">Go back</a></div>
<?php elseif(isset($error)): ?>
    <div class="alert alert-danger text-center"><?= $error ?></div>
<?php endif; ?>

<form method="POST" id="updateForm" novalidate>
    <div class="mb-3">
        <label>Name</label>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($row['name']) ?>" class="form-control" required oninput="this.value = this.value.toUpperCase()">
    </div>
    <div class="mb-3">
        <label>Email</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($row['email']) ?>" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Phone</label>
        <input type="text" id="phone" name="phone" value="<?= htmlspecialchars($row['phone']) ?>" class="form-control" required oninput="this.value=this.value.replace(/[^0-9]/g,'')">
    </div>
    <div class="text-center">
        <button type="submit" name="update" class="btn btn-success"><i class="bi bi-save"></i> Update</button>
        <a href="view.php" class="btn btn-secondary"><i class="bi bi-x-circle"></i> Cancel</a>
    </div>
</form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Real-time validation
document.getElementById("name").addEventListener("input", function() {
    this.style.borderColor = this.value.length < 3 ? "red" : "green";
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
