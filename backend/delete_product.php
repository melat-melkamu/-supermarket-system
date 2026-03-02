<?php
include 'connection.php';

if(isset($_POST['id'])){
    $id = $_POST['id'];
    $conn->query("DELETE FROM products WHERE id='$id'");
}
header("Location: ../dashboard.php");
exit;
?>