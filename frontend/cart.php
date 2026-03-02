
<?php 
session_start();
 include "../backend/connection.php";
 $_SESSION['user_id'] = 1; // assume user ID 1 exists in your database 
  if(isset($_GET['add'])) {
     $id = intval($_GET['add']); // product id to add
      if(!isset($_SESSION['cart'])) {
         $_SESSION['cart'] = []; // initialize cart if empty } // add the product ID to cart 
         $_SESSION['cart'][] = $id; // optional: prevent multiple refresh adding the same item 
         header("Location: cart.php");
          exit();
           }}
            $total = 0;
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>My Cart</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}

body{
    height:100vh;
    overflow:hidden; /* NO PAGE SCROLL */
    background: linear-gradient(135deg,#6a11cb,#8e2de2,#4a00e0);
}

/* NAVBAR */
.navbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:20px 50px;
    background: rgba(255,255,255,0.08);
    backdrop-filter: blur(20px);
}

.navbar a{
    color:white;
    text-decoration:none;
    margin-left:25px;
    font-weight:500;
}

.logo{
    color:white;
    font-size:24px;
    font-weight:bold;
}

h1{
    text-align:center;
    color:white;
    margin:20px 0;
    font-family:'Playfair Display',serif;
}

/* MAIN LAYOUT */
.main-container{
    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    width:90%;
    margin:auto;
    height:70vh;
}

/* CART SIDE */
.cart-container{
    width:65%;
    overflow-y:auto; /* Scroll only inside cart if needed */
    padding-right:10px;
}

/* SIDE IMAGE */
.side-image{
    width:30%;
    text-align:center;
}

.side-image img{
    width:100%;
    max-height:350px;
    object-fit:cover;
    border-radius:15px;
}

/* CART CARD */
.cart-card{
    background: rgba(255,255,255,0.12);
    backdrop-filter: blur(25px);
    border-radius:20px;
    padding:20px;
    margin-bottom:15px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    color:white;
}

.btn{
    padding:8px 15px;
    border-radius:20px;
    text-decoration:none;
    color:white;
    font-size:14px;
}

.remove-btn{
    background: #a8bb9b;
}

.checkout-btn{
    background: rgba(138, 160, 73, 0.5);
    padding:12px 25px;
    font-size:16px;
    display:inline-block;
    text-decoration:none;
    border-radius:6px;
}

.total{
    text-align:right;
    color:white;
    font-size:22px;
    margin-top:20px;
}

.empty{
    text-align:center;
    color:white;
    margin-top:50px;
}
</style>
</head>

<body>

<div class="navbar">
    <div class="logo">🛒 My Supermarket</div>
    <div>
        <a href="products.php">Products</a>
        <a href="cart.php">Cart</a>
        <a href="../backend/login.php">Admin</a>
        <a href="checkout.php" class="btn checkout-btn">Checkout</a>
    </div>
</div>

<h1>My Shopping Cart</h1>

<div class="main-container">

<div class="cart-container">

<?php
if(isset($_SESSION['cart']) && count($_SESSION['cart']) > 0){

    foreach($_SESSION['cart'] as $key => $id){

        $id = intval($id); // security

        $result = $conn->query("SELECT * FROM products WHERE id = $id");

        if($result && $result->num_rows > 0){

            $product = $result->fetch_assoc();
            $total += $product['price'];
?>

    <div class="cart-card">
        <div>
            <h3><?php echo $product['name']; ?></h3>
            <p>$<?php echo $product['price']; ?></p>
        </div>

<a href="/supermarket_system/backend/remove_from_cart.php?id=<?php echo $product['id']; ?>">
    <button>Remove</button>
</a>


    </div>

<?php
        }
    }
?>

    <div class="total">
        Total: $<?php echo $total; ?>
    </div>

    <div style="text-align:right;margin-top:20px;">
        

<form action="checkout.php" method="post" style="text-align:right;margin-top:20px;">
    <button type="submit" class="btn checkout-btn">Checkout</button>
</form>

    </div>

<?php
}else{
    echo "<div class='empty'>Your cart is empty 🛒</div>";
}
?>

</div>

<!-- SIDE IMAGE ADDED HERE -->
<div class="side-image">
    <img src="https://media.istockphoto.com/id/1204016839/photo/satisfied-customer-purchasing-goods-in-supermarket.jpg?s=170667a&w=0&k=20&c=vW2w_UixXviRRKLFYtNP5yB7cwfiWB9wpeVRFxQOR1k=">
</div>

</div>

</body>
</html>