<?php
include 'connection.php';

$id = $_POST['id'];
$name = $_POST['name'];
$price = $_POST['price'];
$quantity = $_POST['quantity'];

$stmt = $conn->prepare("UPDATE products SET name=?, price=?, quantity=? WHERE id=?");
$stmt->bind_param("sdii", $name, $price, $quantity, $id);
$stmt->execute();

header("Location: ../dashboard.php");
exit();
?>