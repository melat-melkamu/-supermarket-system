<?php
session_start();
include ('connection.php');


if(isset($_SESSION['admin_id'])){
    header("Location: ../dashboard.php");
    exit;
}

$error = "";

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if(!empty($username) && !empty($password)){
        
        $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows == 1){
            $admin = $result->fetch_assoc();
            
            if($password === $admin['password']){
            
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_username'] = $admin['username'];
                header("Location:  ../dashboard.php");
                exit;
            } else {
                $error = "Incorrect password!";
            }
        } else {
            $error = "Admin not found!";
        }
    } else {
        $error = "Please enter username and password!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <style>
        body { 
            font-family: Arial; 
            background: rgba(130, 80, 239, 0.3); 
            display:flex; 
            justify-content:center; 
            align-items:center; 
            height:100vh; 
        }
        .login-box { 
            background: #f4f4f4; 
            padding:30px; 
            border-radius:10px; 
            box-shadow:0 0 10px rgba(0,0,0,0.1); 
            width:300px; 
        }
        input[type=text], input[type=password] { 
            width:100%; 
            padding:10px; 
            margin:10px 0; 
            border-radius:5px; 
            border:1px solid #ccc; 
        }
        button { 
            width:100%; 
            padding:10px; 
            border:none; 
            border-radius:5px; 
            background:purple; 
            color:white; 
            cursor:pointer; 
            margin-top:5px;
        }
        .error { 
            color:red; 
            margin:10px 0; 
        }
        .back-btn {
            width:100%;
            padding:10px;
            margin-top:10px;
            border:none;
            border-radius:5px;
            background:#af5591; 
            color:white;
            cursor:pointer;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Admin Login</h2>
        <?php if($error) echo "<div class='error'>$error</div>"; ?>
        <form method="POST" action="">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <button onclick="window.location.href='../frontend/products.php'">Go Back</button>
    </div>
</body>
</html>