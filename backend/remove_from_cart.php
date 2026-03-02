<?php
include 'connection.php';

if(isset($_GET['id'])){

    $cart_id = $_GET['id'];

    $sql = "DELETE FROM cart WHERE id='$cart_id'";

    if($conn->query($sql) === TRUE){
        header("Location: /supermarket_system/frontend/cart.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>