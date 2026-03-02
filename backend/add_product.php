<?php
include 'connection.php'; 


$name = $_POST['name'];
$price = $_POST['price'];
$quantity = $_POST['quantity'];


$sql = "INSERT INTO products (name, price, quantity) VALUES ('$name', '$price', '$quantity')";
if($conn->query($sql) === TRUE){
    header("Location: ../dashboard.php");
    exit();
}else{
    echo "Error: " . $conn->error;
}
?>