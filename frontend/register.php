<?php
include("../backend/connection.php");

if(isset($_POST['register'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name,email,password,role)
            VALUES ('$name','$email','$hashed_password','customer')";

    if(mysqli_query($conn,$sql)){
        echo "<script>alert('Registration Successful'); window.location='login.php';</script>";
    }else{
        echo "Error: ".mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>User Register</title>
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
    box-shadow:0 0 10px #d673d1;
}

input{
    width:100%;
    padding:10px;
    margin:10px 0;
}

button{
    background: #af5591;
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
    color:#af5591;
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
<h2>Customer Register</h2>

<form method="POST" action="../backend/register.php">
<input type="text" name="name" placeholder="Name" required>
<input type="email" name="email" placeholder="Email" required>
<input type="password" name="password" placeholder="Password" required>
<button name="register">Register</button>
</form>

<div class="nav-links">
    Already have an account? <a href="login.php">Login here</a>
</div>

<button class="back-btn" onclick="window.history.back()">Go Back</button>

</div>

</body>
</html>