<?php
include 'config.php';

if(isset($_GET['id'])){
    $id = intval($_GET['id']); // sanitize input
    $sql = "DELETE FROM contacts WHERE id=$id";
    if($conn->query($sql) === TRUE){
        header("Location: view.php");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    header("Location: view.php");
    exit();
}
?>
