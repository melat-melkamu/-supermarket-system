<?php
include("connection.php"); 

if(isset($_POST['register'])) {

    
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    
    $stmt = $conn->prepare("SELECT id FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if($stmt->num_rows > 0){
    
        echo "<script>alert('User with this email already exists!'); window.location.href='../frontend/register.php';</script>";
        exit();
    }
    $stmt->close();

    
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    
    $insert = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'customer')");
    $insert->bind_param("sss", $name, $email, $hashed_password);

    if($insert->execute()){
        echo "<script>alert('Registration successful! Please login.'); window.location.href='../frontend/login.php';</script>";
    } else {
        echo "<script>alert('Registration failed! Try again.'); window.location.href='../frontend/register.php';</script>";
    }

    $insert->close();
    $conn->close();
}
?>