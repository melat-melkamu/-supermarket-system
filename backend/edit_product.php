<?php
include 'connection.php';

$id = $_GET['id'];

$result = $conn->query("SELECT * FROM products WHERE id=$id");
$row = $result->fetch_assoc();
?>

<h4>Edit Product</h4>

<form action="backend/update_product.php" method="post">
  <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

  <input type="text" name="name" 
  value="<?php echo $row['name']; ?>" required>

  <input type="number" step="0.01" name="price" 
  value="<?php echo $row['price']; ?>" required>

  <input type="number" name="quantity" 
  value="<?php echo $row['quantity']; ?>" required>

  <button type="submit">Update Product</button>
</form>