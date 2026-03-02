<?php
include '../backend/connection.php';

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Get product price
    $result = $conn->query("SELECT * FROM products WHERE id = $product_id");
    $product = $result->fetch_assoc();

    $total = $product['price'] * $quantity;

    // Insert into sales table
    $stmt = $conn->prepare("INSERT INTO sales (product_id, quantity, total) VALUES (?, ?, ?)");
    $stmt->bind_param("iid", $product_id, $quantity, $total);
    $stmt->execute();

    // Reduce product stock
    $new_qty = $product['quantity'] - $quantity;
    $conn->query("UPDATE products SET quantity = $new_qty WHERE id = $product_id");

    header("Location: index.php");
}
?>