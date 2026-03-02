<?php
include 'connection.php';

if(isset($_POST['product_id'])){

    $product_id = $_POST['product_id'];
    $customer_id = $_POST['customer_id'];
    $quantity_sold = $_POST['quantity_sold'];
    $sale_date = date("Y-m-d");

    
    $checkProduct = $conn->query("SELECT quantity FROM products WHERE id='$product_id'");

    if($checkProduct->num_rows > 0){

        $product = $checkProduct->fetch_assoc();
        $current_quantity = $product['quantity'];

        
        if($current_quantity >= $quantity_sold){

            
            $insertSale = "INSERT INTO sales (product_id, customer_id, quantity_sold, sale_date)
                           VALUES ('$product_id', '$customer_id', '$quantity_sold', '$sale_date')";

            if($conn->query($insertSale) === TRUE){

                
                $new_quantity = $current_quantity - $quantity_sold;

                $updateProduct = "UPDATE products 
                                  SET quantity='$new_quantity' 
                                  WHERE id='$product_id'";

                $conn->query($updateProduct);

                header("Location: ../dashboard.php");
                exit();

            } else {
                echo "Error adding sale: " . $conn->error;
            }

        } else {
            echo "<h3 style='color:red;'>Not enough stock available!</h3>";
        }

    } else {
        echo "<h3 style='color:red;'>Product not found!</h3>";
    }

} else {
    echo "Invalid Request";
}

$conn->close();
?>