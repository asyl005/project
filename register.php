<?php
// Қазақша түсініктемелер:
// Бұл файл пайдаланушыны "users" кестесіне тіркеуге арналған.

// Деректер базасына қосылу параметрлері
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "survey_db";

// Деректер базасына қосылу
$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Қосылымды тексеру
if ($conn->connect_error) {
    die("<script>alert('Дерекқорға қосылу қатесі: " . $conn->connect_error . "');</script>");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Пайдаланушының енгізген деректерін алу
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Деректерді тексеру
    if (empty($username) || empty($email) || empty($password)) {
        echo "<script>alert('Барлық өрістерді толтырыңыз.');</script>";
        exit();
    }

    // Email форматты тексеру
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Неверный формат email.');</script>";
        exit();
    }

    // Пайдаланушының email қайталанбауын тексеру
    $sql_check = "SELECT id FROM users WHERE email = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        echo "<script>alert('Бұл email-ге тіркелген пайдаланушы бар.');</script>";
        exit();
    }
    $stmt_check->close();

    // Құпиясөзді хештеу
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Пайдаланушыны дерекқорға қосу
    $sql_insert = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("sss", $username, $email, $hashed_password);

    if ($stmt_insert->execute()) {
        // Тіркелу сәтті аяқталды, login.html бетіне өту
        header("Location: login.html");
        exit();
    } else {
        echo "<script>alert('Қате: " . $stmt_insert->error . "');</script>";
    }

    $stmt_insert->close();
}

$conn->close();
?>
