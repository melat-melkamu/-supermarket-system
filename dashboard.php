<?php
include 'backend/connection.php';


$totalProducts = $conn->query("SELECT COUNT(*) as total FROM products")->fetch_assoc()['total'];

$totalCustomers = $conn->query("SELECT COUNT(*) as total FROM users WHERE role='customer'")->fetch_assoc()['total'];

$totalSales = $conn->query("SELECT COUNT(*) as total FROM sales")->fetch_assoc()['total'];

 
$revenueQuery = $conn->query("
    SELECT SUM(products.price * sales.quantity_sold) AS total_revenue
    FROM sales
    JOIN products ON sales.product_id = products.id
");

$totalRevenue = $revenueQuery->fetch_assoc()['total_revenue'];

if(!$totalRevenue){
    $totalRevenue = 0;
}

session_start();
if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit;
}




?>


<!DOCTYPE html>
<html>
<head>
<title>Supermarket Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
body{
    margin:0;
    font-family:Arial, sans-serif;
    background: rgba(150, 100, 255, 0.3);
    overflow-x:hidden;
}

.topbar{
    height:60px;
    background:#111;
    color:white;
    display:flex;
    align-items:center;
    padding:0 20px;
}

.topbar h2{
    margin:0;
}

.menu-icon{
    font-size:22px;
    cursor:pointer;
    background:#000;
    padding:8px 12px;
    border-radius:6px;
    color:white;
    margin-left:auto;
}

.wrapper{
    display:flex;
}

.sidebar{
    width:0;
    background:#000;
    color:white;
    overflow:hidden;
    transition:0.3s;
    height:calc(100vh - 60px);
}

.sidebar.active{
    width:230px;
}

.sidebar a{
    display:block;
    padding:15px;
    color:white;
    text-decoration:none;
    border-bottom:1px solid #222;
}

.sidebar a:hover{
    background:#222;
}

.sidebar a.active{
    background:#444;
}

.content{
    flex:1;
    padding:25px;
}

.card{
    background: linear-gradient(to right, #d8c1ff, #b29cff);
    padding:20px;
    border-radius:10px;
    box-shadow:0 4px 10px rgba(0,0,0,0.05);
}

table{
    width:100%;
    border-collapse:collapse;
    margin-top:15px;
    background:white;
}

th, td{
    padding:10px;
    border:1px solid #ddd;
    text-align:center;
}

.button{
    padding:5px 10px;
    margin:2px;
    border:none;
    border-radius:5px;
    cursor:pointer;
    color:white;
}

.edit-btn{
    background:#4CAF50;
}

.delete-btn{
    background:#f44336;
}

.section{
    display:none;
}

.section.active{
    display:block;
}

.editForm{
    margin-top:20px;
    display:none;
    background: linear-gradient(to right, #d8c1ff, #b29cff);
    padding:20px;
    border-radius:10px;
    box-shadow:0 4px 10px rgba(0,0,0,0.05);

}

</style>
</head>

<body>

<div class="topbar">
    <h2>Supermarket Backend</h2>
    <div class="menu-icon" onclick="toggleMenu()">☰</div>
</div>

<div class="wrapper">

<div class="sidebar" id="sidebar">
    <a href="#" class="menu-link active" onclick="showSection('products', this)">🛒 Products</a>
    <a href="#" class="menu-link" onclick="showSection('customers', this)">👤 Customers</a>
    
    <a href="#" class="menu-link" onclick="showSection('sales', this)">💰 Sales</a>

<a href="backend/logout.php" style="color:white; margin-left:auto;">Logout</a>




</div>

<div class="content">


<div id="products" class="section active">
<div class="card">
<h3>🛒 Products</h3>
<table>
<tr><th>ID</th><th>Name</th><th>Price</th><th>Quantity</th><th>Actions</th></tr>






<?php
$result = $conn->query("SELECT * FROM products");
if($result && $result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        echo "<tr>
        <td>{$row['id']}</td>
        <td>{$row['name']}</td>
        <td>{$row['price']}</td>
        <td>{$row['quantity']}</td>

        <td>
            <button class='button edit-btn' onclick='loadEditProduct({$row['id']},\"{$row['name']}\",{$row['price']},{$row['quantity']})'>Edit</button>
            <form style='display:inline;' action='backend/delete_product.php' method='post'>
                <input type='hidden' name='id' value='{$row['id']}'>
                <button type='submit' class='button delete-btn'>Delete</button>
            </form>
        </td>
        </tr>";
    }
}else{
    echo "<tr><td colspan='5'>No products found</td></tr>";
}
?>
</table>
</div>














<div id="editProductFormDiv" class="editForm">
<h4>Edit Product</h4>
<form id="editProductForm" action="backend/edit_product.php" method="post">
    <input type="hidden" name="id" id="editProduct_id">
    <input type="text" name="name" id="editProduct_name" placeholder="Product Name" required>
    <input type="number" step="0.01" name="price" id="editProduct_price" placeholder="Price" required>
    <input type="number" name="quantity" id="editProduct_quantity" placeholder="Quantity" required>
    <button type="submit">Update Product</button>
    <button type="button" onclick="cancelEdit('editProductFormDiv')">Cancel</button>
</form>
</div>

</div>


<div id="customers" class="section">
<div class="card">
<h3>👤 Customers</h3>
<table>
<tr><th>ID</th><th>Name</th><th>Email</th><th>role</th></tr>
<?php
$result = $conn->query("SELECT * FROM users WHERE role='customer'");
if($result && $result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        echo "<tr>
        <td>{$row['id']}</td>
        <td>{$row['name']}</td>
        <td>{$row['email']}</td>
        <td>{$row['role']}</td>
       
        </tr>";
    }
}else{
    echo "<tr><td colspan='5'>No customers found</td></tr>";
}
?>
</table>
</div>

<div id="editCustomerFormDiv" class="editForm">
<h4>Edit Customer</h4>
<form id="editCustomerForm" action="backend/edit_customer.php" method="post">
    <input type="hidden" name="id" id="editCustomer_id">
    <input type="text" name="name" id="editCustomer_name" placeholder="Customer Name" required>
    <input type="email" name="email" id="editCustomer_email" placeholder="Email" required>
    <input type="text" name="phone" id="editCustomer_phone" placeholder="Phone" required>
    <button type="submit">Update Customer</button>
    <button type="button" onclick="cancelEdit('editCustomerFormDiv')">Cancel</button>
</form>
</div>

</div>


<div id="sales" class="section">
<div class="card">
<h3>💰 Sales</h3>
<table>
<tr><th>ID</th><th>Product ID</th><th>Customer ID</th><th>Quantity</th><th>Date</th><th>Actions</th></tr>
<?php
$result = $conn->query("SELECT * FROM sales");
if($result && $result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        echo "<tr>
        <td>{$row['id']}</td>
        <td>{$row['product_id']}</td>
        <td>{$row['customer_id']}</td>
        <td>{$row['quantity_sold']}</td>
        <td>{$row['sale_date']}</td>
        <td>
            <button class='button edit-btn' onclick='loadEditSale({$row['id']},{$row['product_id']},{$row['customer_id']},{$row['quantity_sold']})'>Edit</button>
            <form style='display:inline;' action='backend/delete_sale.php' method='post'>
                <input type='hidden' name='id' value='{$row['id']}'>
                <button type='submit' class='button delete-btn'>Delete</button>
            </form>
        </td>
        </tr>";
    }
}else{
    echo "<tr><td colspan='6'>No sales found</td></tr>";
}
?>
</table>
</div>

<h4>Add New Sale</h4>
<form id="addSaleForm" action="backend/add_sale.php" method="post">
  <input type="number" name="product_id" placeholder="Product ID" required>
  <input type="number" name="customer_id" placeholder="Customer ID" required>
  <input type="number" name="quantity_sold" placeholder="Quantity" required>
  <button type="submit">Add Sale</button>
</form>


<div id="editSaleFormDiv" class="editForm">
<h4>Edit Sale</h4>
<form id="editSaleForm" action="backend/edit_sale.php" method="post">
    <input type="hidden" name="id" id="editSale_id">
    <input type="number" name="product_id" id="editSale_product_id" placeholder="Product ID" required>
    <input type="number" name="customer_id" id="editSale_customer_id" placeholder="Customer ID" required>
    <input type="number" name="quantity_sold" id="editSale_quantity_sold" placeholder="Quantity" required>
    <button type="submit">Update Sale</button>
    <button type="button" onclick="cancelEdit('editSaleFormDiv')">Cancel</button>
</form>
</div>

</div>
</div>
<div class="content">


<div style="display:flex; gap:20px; flex-wrap:wrap; margin-bottom:25px;">

    <div class="card" style="flex:1; min-width:200px; text-align:center;">
        <h3>Total Products</h3>
        <h2><?php echo $totalProducts; ?></h2>
    </div>

    <div class="card" style="flex:1; min-width:200px; text-align:center;">
        <h3>Total Customers</h3>
        <h2><?php echo $totalCustomers; ?></h2>
    </div>

    <div class="card" style="flex:1; min-width:200px; text-align:center;">
        <h3>Total Sales</h3>
        <h2><?php echo $totalSales; ?></h2>
    </div>

    <div class="card" style="flex:1; min-width:200px; text-align:center;">
        <h3>Total Revenue</h3>
        <h2>$<?php echo number_format($totalRevenue,2); ?></h2>
    </div>
<div class="card" style="margin-top:20px;">
    <h4>Add New Product</h4>
    <form id="addProductForm" action="backend/add_product.php" method="post">
      <input type="text" name="name" placeholder="Product Name" required>
      <input type="number" step="0.01" name="price" placeholder="Price" required>
      <input type="number" name="quantity" placeholder="Quantity" required>
      <button type="submit">Add Product</button>
    </form>
</div>
</div>











<script>
function toggleMenu(){
    document.getElementById("sidebar").classList.toggle("active");
}

function showSection(section, element){
    let sections=document.querySelectorAll('.section');
    sections.forEach(sec=>sec.classList.remove('active'));
    document.getElementById(section).classList.add('active');

    let links=document.querySelectorAll('.menu-link');
    links.forEach(link=>link.classList.remove('active'));
    element.classList.add('active');
}


function loadEditProduct(id, name, price, quantity){
    document.getElementById('editProductFormDiv').style.display = 'block';
    document.getElementById('editProduct_id').value = id;
    document.getElementById('editProduct_name').value = name;
    document.getElementById('editProduct_price').value = price;
    document.getElementById('editProduct_quantity').value = quantity;
    document.getElementById('editProductFormDiv').scrollIntoView({behavior: "smooth"});
}


function loadEditCustomer(id, name, email, phone){
    document.getElementById('editCustomerFormDiv').style.display = 'block';
    document.getElementById('editCustomer_id').value = id;
    document.getElementById('editCustomer_name').value = name;
    document.getElementById('editCustomer_email').value = email;
    document.getElementById('editCustomer_phone').value = phone;
    document.getElementById('editCustomerFormDiv').scrollIntoView({behavior: "smooth"});
}


function loadEditSale(id, product_id, customer_id, quantity){
    document.getElementById('editSaleFormDiv').style.display = 'block';
    document.getElementById('editSale_id').value = id;
    document.getElementById('editSale_product_id').value = product_id;
    document.getElementById('editSale_customer_id').value = customer_id;
    document.getElementById('editSale_quantity_sold').value = quantity;
    document.getElementById('editSaleFormDiv').scrollIntoView({behavior: "smooth"});
}


function cancelEdit(formDivId){
    document.getElementById(formDivId).style.display = 'none';
}
</script>

</body>
</html> i want to give me the i will pasty it give me at it is please