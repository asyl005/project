<?php 
session_start();
<<<<<<< HEAD
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Перенаправление на страницу входа, если пользователь не авторизован
=======

// Қазақша түсініктемелер:
// Бұл файл пайдаланушының авторизациясын тексеру үшін қолданылады.
// Егер пайдаланушы авторизацияланбаған болса, ол login.html бетіне қайта бағытталады.

if (!isset($_SESSION['username']) || !isset($_SESSION['user_id'])) {
    // Егер username немесе user_id сессияда жоқ болса, қайта бағыттау
    header("Location: login.html"); // Кіру бетіне қайта бағыттау
>>>>>>> a9f650cbd2d36c323b20eec8db46240e18b06fd1
    exit();
}
?>
