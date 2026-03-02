<?php
$total = $_GET['total'];
$method = $_GET['method'];
?>

<!DOCTYPE html>
<html>
<head>
<title>Order Success</title>

<style>
body{
    font-family:Arial;
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background: linear-gradient(135deg,#6a11cb,#8e2de2,#4a00e0);
    color:white;
}

.success-box{
    background: rgba(255,255,255,0.12);
    backdrop-filter: blur(25px);
    padding:40px;
    border-radius:20px;
    text-align:center;
    width:400px;
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
</style>

</head>

<body>

<div class="success-box">

<h2>🎉 Order Successful</h2>

<p>Total Paid: <b>$<?php echo number_format($total,2); ?></b></p>

<p>Payment Method: <b><?php echo $method; ?></b></p>

<br>

<a href="products.php">
<button>Continue Shopping</button>
</a>

</div>

</body>
</html>