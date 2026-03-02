<?php
include 'connection.php';

if(isset($_POST['id'])){
    $id = $_POST['id'];
    $result = $conn->query("SELECT * FROM sales WHERE id='$id'");
    if($result && $result->num_rows > 0){
        $row = $result->fetch_assoc();
        ?>
        <form action="update_sale.php" method="post">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <input type="number" name="product_id" value="<?php echo $row['product_id']; ?>" required>
            <input type="number" name="customer_id" value="<?php echo $row['customer_id']; ?>" required>
            <input type="number" name="quantity_sold" value="<?php echo $row['quantity_sold']; ?>" required>
            <button type="submit">Update Sale</button>
        </form>
        <?php
    }
}
?>