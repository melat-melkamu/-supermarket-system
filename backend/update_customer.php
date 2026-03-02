<?php
include 'connection.php';

if(isset($_POST['id'])){
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $conn->query("UPDATE customers SET name='$name', email='$email', phone='$phone' WHERE id='$id'");
}

header("Location: ../dashboard.php");
exit;
?>