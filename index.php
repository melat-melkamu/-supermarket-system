<?php
include 'backend/connection.php';


if (isset($_POST['add_product'])) {
    $name = $_POST['product_name'];
    $price = $_POST['product_price'];
    $quantity = $_POST['product_quantity'];

    $stmt = $conn->prepare("INSERT INTO products (name, price, quantity) VALUES (?, ?, ?)");
    $stmt->bind_param("sdi", $name, $price, $quantity);
    $stmt->execute();
    $stmt->close();
    header("Location: index.php");
    exit;
}

if (isset($_POST['add_customer'])) {
    $name = $_POST['customer_name'];
    $email = $_POST['customer_email'];
    $phone = $_POST['customer_phone'];

    $stmt = $conn->prepare("INSERT INTO customers (name, email, phone) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $phone);
    $stmt->execute();
    $stmt->close();
    header("Location: index.php");
    exit;
}

if (isset($_POST['add_sale'])) {
    $product_id = $_POST['sale_product'];
    $customer_id = $_POST['sale_customer'];
    $quantity_sold = $_POST['sale_quantity'];

    $stmt = $conn->prepare("INSERT INTO sales (product_id, customer_id, quantity_sold) VALUES (?, ?, ?)");
    $stmt->bind_param("iii", $product_id, $customer_id, $quantity_sold);
    $stmt->execute();
    $stmt->close();

    $stmt2 = $conn->prepare("UPDATE products SET quantity = quantity - ? WHERE id = ?");
    $stmt2->bind_param("ii", $quantity_sold, $product_id);
    $stmt2->execute();
    $stmt2->close();

    header("Location: index.php");
    exit;
}


$products = $conn->query("SELECT * FROM products");
$customers = $conn->query("SELECT * FROM customers");
$sales = $conn->query("SELECT s.id, p.name AS product_name, c.name AS customer_name, s.quantity_sold, s.sale_date 
                       FROM sales s
                       JOIN products p ON s.product_id = p.id
                       JOIN customers c ON s.customer_id = c.id
                       ORDER BY s.sale_date DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Supermarket Backend Dashboard</title>
    <style>
        
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif; }

        body { display: flex; min-height: 100vh; background: #f0f2f5; }

        
        .sidebar {
            width: 220px;
            background: rgba(255, 255, 255, 0.2); /* glass effect */
            backdrop-filter: blur(10px);
            padding-top: 20px;
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100%;
        }
        .sidebar a {
            padding: 15px 20px;
            text-decoration: none;
            color: #fff;
            display: block;
            transition: 0.3s;
            border-radius: 5px;
            margin: 5px 10px;
        }
        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        
        .main {
            margin-left: 220px;
            padding: 20px;
            width: calc(100% - 220px);
        }

        h2 { text-align: center; margin-bottom: 20px; color: #333; }

        table { border-collapse: collapse; width: 95%; margin: 0 auto 20px auto; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }
        th { background: rgba(255, 255, 255, 0.3); }
        tr:nth-child(even){background-color: rgba(255,255,255,0.1);}

        form { width: 50%; margin: 0 auto 30px auto; text-align: center; padding: 15px; 
               background: rgba(255,255,255,0.2); backdrop-filter: blur(10px); border-radius: 10px; }
        input[type=text], input[type=number], select { padding: 5px; margin: 5px; width: 80%; }
        input[type=submit] { padding: 8px 15px; margin-top: 10px; cursor: pointer; background-color: #333; color: #fff; border: none; border-radius: 5px; }
        input[type=submit]:hover { background-color: #555; }

        header { width: 100%; padding: 15px; background: rgba(255,255,255,0.2); backdrop-filter: blur(10px); color: #fff; text-align: center; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="sidebar">
        <a href="#products">Products</a>
        <a href="#customers">Customers</a>
        <a href="#sales">Sales</a>
    </div>

    <div class="main">
        <header>
            <h1>Supermarket Backend Dashboard</h1>
        </header>

        <section id="products">
            <h2>Products</h2>
            <table>
                <tr><th>ID</th><th>Name</th><th>Price</th><th>Quantity</th></tr>
                <?php
                if ($products->num_rows > 0) {
                    while($row = $products->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['name']}</td>
                                <td>{$row['price']}</td>
                                <td>{$row['quantity']}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No products found</td></tr>";
                }
                ?>
            </table>

            <h3>Add New Product</h3>
            <form method="POST" action="">
                <input type="text" name="product_name" placeholder="Product Name" required><br>
                <input type="number" step="0.01" name="product_price" placeholder="Price" required><br>
                <input type="number" name="product_quantity" placeholder="Quantity" required><br>
                <input type="submit" name="add_product" value="Add Product">
            </form>
        </section>

        <section id="customers">
            <h2>Customers</h2>
            <table>
                <tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th></tr>
                <?php
                if ($customers->num_rows > 0) {
                    while($row = $customers->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['name']}</td>
                                <td>{$row['email']}</td>
                                <td>{$row['phone']}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No customers found</td></tr>";
                }
                ?>
            </table>

            <h3>Add New Customer</h3>
            <form method="POST" action="">
                <input type="text" name="customer_name" placeholder="Customer Name" required><br>
                <input type="text" name="customer_email" placeholder="Email"><br>
                <input type="text" name="customer_phone" placeholder="Phone"><br>
                <input type="submit" name="add_customer" value="Add Customer">
            </form>
        </section>

        <section id="sales">
            <h2>Sales</h2>
            <table>
                <tr><th>ID</th><th>Product</th><th>Customer</th><th>Quantity</th><th>Date</th></tr>
                <?php
                if ($sales->num_rows > 0) {
                    while($row = $sales->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['product_name']}</td>
                                <td>{$row['customer_name']}</td>
                                <td>{$row['quantity_sold']}</td>
                                <td>{$row['sale_date']}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No sales found</td></tr>";
                }
                ?>
            </table>

            <h3>Record New Sale</h3>
            <form method="POST" action="">
                <select name="sale_product" required>
                    <option value="">Select Product</option>
                    <?php
                    $products2 = $conn->query("SELECT * FROM products WHERE quantity > 0");
                    while($row = $products2->fetch_assoc()) {
                        echo "<option value='{$row['id']}'>{$row['name']} (Stock: {$row['quantity']})</option>";
                    }
                    ?>
                </select><br>
                <select name="sale_customer" required>
                    <option value="">Select Customer</option>
                    <?php
                    $customers2 = $conn->query("SELECT * FROM customers");
                    while($row = $customers2->fetch_assoc()) {
                        echo "<option value='{$row['id']}'>{$row['name']}</option>";
                    }
                    ?>
                </select><br>
                <input type="number" name="sale_quantity" placeholder="Quantity" required><br>
                <input type="submit" name="add_sale" value="Record Sale">
            </form>
        </section>
    </div>
</body>
</html>