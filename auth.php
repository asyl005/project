<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.html"); // Перенаправление на страницу входа, если пользователь не авторизован
    exit();
}
?>
