<?php
session_start(); // Запуск сессии

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Здесь проверка имени пользователя и пароля в базе данных (добавьте реальную проверку)
    $isAuthenticated = true; // Установите переменную на основе результата проверки

    if ($isAuthenticated) {
        // Сохраняем данные в сессии
        $_SESSION['username'] = htmlspecialchars($username); // сохраняем имя пользователя в сессию
        header("Location: dashboard.html"); // Перенаправляем на приборную панель
        exit();
    } else {
        echo "Неправильное имя пользователя или пароль!";
    }
}
?>
