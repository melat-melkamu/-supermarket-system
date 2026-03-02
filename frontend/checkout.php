<?php
session_start();
include "../backend/connection.php";

$_SESSION['user_id'] = 1; // TEMP USER
$user_id = $_SESSION['user_id'];

// Check cart
if(!isset($_SESSION['cart']) || count($_SESSION['cart'])==0){
    die("Error: Your cart is empty!");
}

$total = 0;
$cart_items = [];

foreach($_SESSION['cart'] as $product_id){
    $product_id = intval($product_id);
    $result = $conn->query("SELECT * FROM products WHERE id=$product_id");

    if($result && $result->num_rows>0){
        $product = $result->fetch_assoc();
        $total += $product['price'];
        $cart_items[] = $product;
    }
}

// Handle checkout
if(isset($_POST['checkout'])){
    $payment_method = $_POST['payment_method'];
    $telebirr_txn_id = ($payment_method == 'TeleBirr') ? $_POST['telebirr_txn_id'] : NULL;

    $order_sql = "INSERT INTO orders 
    (user_id, total_amount, payment_method, telebirr_txn_id, payment_status, created_at) 
    VALUES (?, ?, ?, ?, ?, NOW())";

    $status = "Pending";

    $stmt = $conn->prepare($order_sql);
    $stmt->bind_param("idsss", $user_id, $total, $payment_method, $telebirr_txn_id, $status);
    $stmt->execute();

    $order_id = $stmt->insert_id;

    foreach($cart_items as $product){
        $pid = $product['id'];
        $price = $product['price'];
        $quantity = 1;

        $item_sql = "INSERT INTO order_items (order_id, product_id, quantity, price) 
                     VALUES (?, ?, ?, ?)";

        $item_stmt = $conn->prepare($item_sql);
        $item_stmt->bind_param("iiid", $order_id, $pid, $quantity, $price);
        $item_stmt->execute();
    }

    unset($_SESSION['cart']);
    header("Location: checkout_success.php?total=$total&method=$payment_method");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Checkout</title>

<style>

body{
    font-family:Arial;
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background: linear-gradient(135deg,#6a11cb,#8e2de2,#4a00e0);
}

/* MAIN BOX */
.checkout-container{
    display:flex;
    width:800px;
    background: rgba(255,255,255,0.12);
    backdrop-filter: blur(25px);
    border-radius:20px;
    overflow:hidden;
    box-shadow:0 0 25px rgba(0,0,0,0.2);
}

/* LEFT IMAGE SIDE */
.image-side{
    width:20%;
    padding:20px;
    display:flex;
    justify-content:center;
    align-items:center;
}

.image-side img{
    width:100%;
    height:70%;
    border-radius:15px;
}

/* RIGHT FORM SIDE */
.checkout-card{
    width:50%;
    padding:40px;
    text-align:center;
    color:white;
}

input, select{
    padding:10px;
    width:90%;
    margin:10px 0;
    border-radius:5px;
    border:none;
}

button{
    padding:12px 25px;
    border-radius:25px;
    border:none;
    background: rgba(138,160,73,0.6);
    color:white;
    cursor:pointer;
}

button:hover{
    background: rgba(138,160,73,0.9);
}

#telebirr-info{
    display:none;
}

</style>

<script>
function toggleTeleBirr(){
    var method = document.getElementById('payment_method').value;
    document.getElementById('telebirr-info').style.display = 
        (method=='TeleBirr') ? 'block' : 'none';
}

function goBack(){
    window.history.back();
}
</script>

</head>

<body>

<div class="checkout-container">

    <div class="image-side">
        <img src="https://tse4.mm.bing.net/th/id/OIP.lf04BQdWOYaPqyGJXKyV_gHaO5?pid=ImgDet&w=474&h=953&rs=1&o=7&rm=3">
    </div>

    <div class="checkout-card">
        <h2>  🎉 Checkout</h2>
        <p>Total: $<?php echo number_format($total,2); ?></p>

        <form method="POST">

            <label>Payment Method:</label>
            <select name="payment_method" id="payment_method" onchange="toggleTeleBirr()" required>
                <option value="COD">Cash on Delivery</option>
                <option value="TeleBirr">TeleBirr</option>
            </select>

            <div id="telebirr-info">
                <p>Send payment to TeleBirr Number: <b>0912 345 678</b></p>
                <input type="text" name="telebirr_txn_id" placeholder="Enter Transaction ID">
            </div>

            <button type="submit" name="checkout">Place Order</button>
            <br><br>
            <button type="button" onclick="goBack()">⬅ Back</button>

        </form>
    </div>

</div>

</body>
</html>