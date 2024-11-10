<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Здесь можно добавить код для проверки имени пользователя и пароля из базы данных
    
    echo "Добро пожаловать, " . htmlspecialchars($username) . "!";
}
?>
