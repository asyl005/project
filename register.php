<?php
// Қазақша түсініктемелер:
// Бұл файл пайдаланушыны "users" кестесіне тіркеуге арналған.

// Деректер базасына қосылу параметрлері
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "survey_db";
<<<<<<< HEAD
$db_port=3307;

$conn = new mysqli($servername, $db_username, $db_password, $dbname, $db_port);
=======

// Деректер базасына қосылу
$conn = new mysqli($servername, $db_username, $db_password, $dbname);
>>>>>>> a9f650cbd2d36c323b20eec8db46240e18b06fd1

// Қосылымды тексеру
if ($conn->connect_error) {
    die("Дерекқорға қосылу қатесі: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Пайдаланушының енгізген деректерін алу
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

<<<<<<< HEAD
    
    $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
=======
    // Деректерді тексеру
    if (empty($username) || empty($email) || empty($password)) {
        echo "Барлық өрістерді толтырыңыз.";
        exit();
    }
>>>>>>> a9f650cbd2d36c323b20eec8db46240e18b06fd1

    // Email форматты тексеру
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Неверный формат email.";
        exit();
    }

    // Пайдаланушының email қайталанбауын тексеру
    $sql_check = "SELECT id FROM users WHERE email = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        echo "Бұл email-ге тіркелген пайдаланушы бар.";
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
        echo "Тіркелу сәтті аяқталды. <a href='login.html'>Кіру</a>";
    } else {
        echo "Қате: " . $stmt_insert->error;
    }

    $stmt_insert->close();
}

$conn->close();
?>


