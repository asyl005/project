<?php
session_start();

// Деректер базасының параметрлері
$servername = "localhost"; // Сервер атауы
$username_db = "root";     // Деректер базасының пайдаланушысы
$password_db = "";         // Деректер базасының құпиясөзі
$dbname = "survey_db";     // Деректер базасының атауы

// Деректер базасына қосылу
$conn = new mysqli($servername, $username_db, $password_db, $dbname);

// Қосылымды тексеру
if ($conn->connect_error) {
    die("Дерекқорға қосылу қатесі: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']); // Пайдаланушының енгізген аты
    $password = trim($_POST['password']); // Пайдаланушының енгізген құпиясөзі

<<<<<<< HEAD
    if ($isAuthenticated) {
       
        $_SESSION['username'] = htmlspecialchars($username); 
        header("Location: dashboard.php"); 
        exit();
=======
    // SQL сұрау: пайдаланушыны табу
    $sql = "SELECT id, password FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // Пайдаланушы табылды, құпиясөзді тексеру
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) { // Құпиясөз тексеру
            // Сессия параметрлерін орнату
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $row['id']; // Пайдаланушының ID-ін сақтау

            // Жеке кабинетке өту
            header("Location: dashboard.html");
            exit();
        } else {
            echo "Қате: Құпиясөз дұрыс емес!";
        }
>>>>>>> a9f650cbd2d36c323b20eec8db46240e18b06fd1
    } else {
        echo "Қате: Пайдаланушы табылмады!";
    }

    // Ресурстарды босату
    $stmt->close();
}

$conn->close();
?>
