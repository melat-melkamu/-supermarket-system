
<?php session_start(); include "../backend/connection.php"; if(isset($_GET['add'])){ $id = intval($_GET['add']); if(!isset($_SESSION['cart'])){ $_SESSION['cart'] = []; } $_SESSION['cart'][] = $id; header("Location: cart.php"); exit(); } ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Our Products</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}

body{
    min-height:100vh;
    background: linear-gradient(135deg,#6a11cb,#8e2de2,#4a00e0);
    overflow :hidden;

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

.navbar a:hover{
    color:#ffd6ff;
}

.logo{
    color:white;
    font-size:24px;
    font-weight:bold;
}

/* TITLE */
h1{
    text-align:center;
    color:white;
    margin:15px 0 10px;
    font-family:'Playfair Display',serif;
    font-size:42px;
    letter-spacing:2px;
}

/* GRID */
.products-container{
    display:grid;
    grid-template-columns: repeat(auto-fit,minmax(260px,1fr));
    gap:15px;
    padding:10px;
}

/* CARD */
.product-card{
    background: rgba(255,255,255,0.2);
    backdrop-filter: blur(25px);
    border-radius:15px;
    padding:15px;
    text-align:center;
    color:white;
    box-shadow:0 10px 40px rgba(0,0,0,0.3);
    transition:0.4s ease;
    font-size: 10px; 
    height: 270px;
}

.product-card:hover{
    transform:translateY(-12px);
    box-shadow:0 15px 50px rgba(0,0,0,0.4);
}

.product-card img{
    width:100%;
    height:100px;
    object-fit:cover;
    border-radius:18px;
    margin-bottom:15px;
}

.product-card h3{
    margin:10px 0;
    font-size:20px;

}

.price{
    font-size:22px;
    font-weight:bold;
    margin:1px 0 15px;
}

.btn{
    display:inline-block;
    padding:10px 25px;
    background: linear-gradient(45deg,#c471f5,#fa71cd);
    border-radius:30px;
    text-decoration:none;
    color:white;
    transition:0.3s;
}

.btn:hover{
    transform:scale(1.08);
    box-shadow:0 0 20px #9338c8;
}
</style>
</head>

<body>

<div class="navbar">
    <div class="logo">🛒 My Supermarket</div>
    <div>
        <a href="index.php">Home</a>
        <a href="products.php">Products</a>
       <a href="../frontend/cart.php">Cart</a>
       <a href="../backend/login.php">Admin</a>
    </div>
</div>

<h1>Welcome To Our Supermarket</h1>

<div class="products-container">

<?php
$result = $conn->query("SELECT * FROM products");

if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){

        $image = "";

        // Different images based on product name
        switch(strtolower($row['name'])){
            case "milk":
                $image = "https://img.freepik.com/premium-photo/shopper-picking-up-milk-grocery-store-aisle_1198884-63158.jpg";
                break;
            case "egg":
                $image = "https://tse4.mm.bing.net/th/id/OIP.UuR-QVqqr0-yDvDnypsMhQHaFP?rs=1&pid=ImgDetMain&o=7&rm=3";
                break;
            case "honey":
                $image = "https://thumbs.dreamstime.com/b/kuala-lumpur-malaysia-february-processed-honey-packed-plastic-bottle-displayed-shelf-to-customer-138937922.jpg";
                break;
             case "bread":
                $image ="https://thumbs.dreamstime.com/z/assorted-breads-displayed-shelves-bakery-supermarkets-various-types-bread-rolls-baguettes-bagels-many-other-fresh-317699275.jpg?w=768";
                break;
                case "chocolate":
                $image ="https://thumbs.dreamstime.com/b/famous-sweet-candy-market-confectionery-boqueria-market-place-barcelona-spain-assorted-chocolate-candy-shop-famous-sweet-120978525.jpg";
            break;
                case "soft drink":
                $image = "https://www.shutterstock.com/image-photo/kota-bharu-kelantan-malaysia-10-260nw-1068678668.jpg";
                break;

                 break;
            case "marmalade":
                $image = "https://c8.alamy.com/comp/C0F1HP/smuckers-and-other-jams-and-jellies-in-a-supermarket-C0F1HP.jpg";
                break;
            case "apple":
                $image ="https://img.freepik.com/premium-photo/apple-packing-line-fruit-washing-apple-automated-sorting-conveyor-food-industry-automatic-technology_162695-48879.jpg?w=1060";
                break;
            case "vegetables":
                $image = "https://static.vecteezy.com/system/resources/thumbnails/043/179/585/small_2x/colorful-fresh-vegetables-and-fruits-display-at-grocery-store-photo.jpeg";
                break;
            case "meat":
            case "meats":
                $image = "https://img.freepik.com/premium-photo/variety-neatly-arranged-labeled-cuts-red-meat-fill-display-case-supermarket_127746-6044.jpg";
                break;
            default:
                $image = "https://img.freepik.com/free-photo/shopping-cart-supermarket_144627-16530.jpg";
        }
?>

    <div class="product-card">
        <img src="<?php echo $image; ?>" alt="Product">
        <h3><?php echo $row['name']; ?></h3>
        <div class="price">$<?php echo $row['price']; ?></div>
        <a href="products.php?add=<?php echo $row['id']; ?>" class="btn">Add to cart</a>
    </div>

<?php
    }
}else{
    echo "<p style='color:white;'>No products found.</p>";
}
?>

</div>

</body>
</html> 