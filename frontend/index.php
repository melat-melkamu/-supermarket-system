<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Supermarket | Home</title>

    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family: 'Poppins', sans-serif;
        }

        body{
           min-height: 100vh; 
    

background: linear-gradient(rgba(80, 0, 120, 0.6), rgba(80, 0, 120, 0.6)), url('https://images.unsplash.com/photo-1604719312566-8912e9227c6a?auto=format&fit=crop&q=80&w=1600') no-repeat center center/cover;




    display: flex;
    flex-direction: column;
        }

        
        .navbar{
            display:flex;
            justify-content:space-between;
            align-items:center;
            padding:20px 50px;
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-bottom:1px solid rgba(255,255,255,0.2);s
        }

        .logo{
            color:white;
            font-size:24px;
            font-weight:700;
        }

        .nav-links a{
            text-decoration:none;
            color:white;
            margin-left:25px;
            font-weight:500;
            transition:0.3s;
        }

        .nav-links a:hover{
            color:#ffd6ff;
        }

        /* HERO SECTION */
        .hero{
            flex:1;
            display:flex;
            justify-content:center;
            align-items:center;
            text-align:center;
            color:white;
            padding:20px;
        }

        .glass-box{
            background: rgba(255,255,255,0.15);
            padding:50px;
            border-radius:20px;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border:1px solid rgba(255,255,255,0.3);
            box-shadow:0 8px 32px rgba(0,0,0,0.3);
        }

        .hero h1{
            font-family: 'Playfair Display', serif;
            font-size:48px;
            margin-bottom:20px;
        }

        .hero p{
            font-size:18px;
            margin-bottom:30px;
        }

        .btn{
            display:inline-block;
            padding:12px 30px;
            background: linear-gradient(45deg, #a855f7, #6d28d9);
            color:white;
            text-decoration:none;
            border-radius:30px;
            transition:0.3s;
            font-weight:500;
        }

        .btn:hover{
            transform:scale(1.05);
            box-shadow:0 0 15px #c084fc;
        }

        
        footer{
            text-align:center;
            padding:15px;
            color:white;
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
        }

        @media(max-width:768px){
            .hero h1{
                font-size:32px;
            }
            .navbar{
                flex-direction:column;
            }
            .nav-links{
                margin-top:10px;
            }
        }

    </style>
</head>
<body>

    
    <div class="navbar">
        <div class="logo">🛒 My Supermarket</div>
        <div class="nav-links">
            <a href="index.php">Home</a>
            <a href="products.php">Products</a>
            <a href="register.php">Register</a>
            <a href="login.php">Login</a>
        </div>
    </div>

    
    <div class="hero">
        <div class="glass-box">
            <h1>Welcome to Our Supermarket</h1>
            <p>Fresh Products • Best Prices • Fast Service</p>
            <a href="login.php" class="btn">Shop Now</a>
        </div>
    </div>

    
    <footer>
        © <?php echo date("Y"); ?> My Supermarket System | All Rights Reserved
    </footer>

</body>
</html>