<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Здесь можно добавить код для регистрации нового пользователя
    
    echo "Регистрация успешна для пользователя " . htmlspecialchars($username) . "!";
}
?>
