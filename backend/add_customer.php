<?php
include 'connection.php'; 

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $name = $_POST['name'];
    $email = !empty($_POST['email']) ? $_POST['email'] : NULL;
    $phone = !empty($_POST['phone']) ? $_POST['phone'] : NULL;

    $stmt = $conn->prepare("INSERT INTO customers (name, email, phone) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $phone);

    if($stmt->execute()){
        header("Location: ../dashboard.php"); 
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request";
}
?>