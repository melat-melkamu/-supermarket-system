<?php session_start();
 include("../backend/connection.php");
  if(isset($_POST['login'])){ $email = $_POST['email'];
   $password = $_POST['password']; 
   $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn,$sql);
     if(mysqli_num_rows($result) > 0){ $user = mysqli_fetch_assoc($result); if(password_verify($password, $user['password'])){ $_SESSION['user_id'] = $user['id']; $_SESSION['user_name'] = $user['name']; header("Location: cart.php"); exit;
 } else { echo "<script>alert('Invalid Password');</script>"; }




} else { echo "<script>alert('User not found');</script>";


 } } ?>












<!DOCTYPE html>
<html>
<head>
<title>User Login</title>
<style>
body{
    font-family: Arial;
    background: rgba(150, 100, 255, 0.3);
}

.form-box{
    width:400px;
    margin:100px auto;
    padding:30px;
    background:white;
    box-shadow:0 0 10px #c884cd;
}

input{
    width:100%;
    padding:10px;
    margin:10px 0;
}

button{
    background: #a24088;
    color:white;
    padding:10px;
    width:100%;
    border:none;
    cursor:pointer;
}

.nav-links{
    text-align:center;
    margin-top:10px;
}
.nav-links a{
    text-decoration:none;
    color:#a24088;
    font-weight:bold;
    margin:0 5px;
}

.back-btn{
    margin-top:10px;
    width:100%;
    padding:10px;
    background:#c884cd;
    border:none;
    color:white;
    cursor:pointer;
}
</style>
</head>

<body>

<div class="form-box">
<h2>Customer Login</h2>

<form method="POST">
    <input type="name" name="name" placeholder="Name" required>
<input type="email" name="email" placeholder="Email" required>
<input type="password" name="password" placeholder="Password" required>
<button name="login">Login</button>
</form>

<div class="nav-links">
    Don’t have an account? <a href="register.php">Register here</a>
</div>

<button class="back-btn" onclick="window.history.back()">Go Back</button>

</div>

</body>
</html>