<?php
session_start(); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $isAuthenticated = true; 

    if ($isAuthenticated) {
       
        $_SESSION['username'] = htmlspecialchars($username); 
        header("Location: dashboard.html"); 
        exit();
    } else {
        echo "Неправильное имя пользователя или пароль!";
    }
}
?>