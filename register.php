<?php
//hfgcfeuhk//
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "survey_db";
$db_port=3307;

$conn = new mysqli($servername, $db_username, $db_password, $dbname, $db_port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    
    $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";

    if ($conn->query($sql) === TRUE) {
        echo "Тіркелу сәтті аяқталды. <a href='login.html'>Кіру</a>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}


$conn->close();
?>
