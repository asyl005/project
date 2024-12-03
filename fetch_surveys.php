<?php
// Мәліметтер базасына қосылу параметрлері
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "survey_db";

// Мәліметтер базасына қосылу
$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Қосылымды тексеру
if ($conn->connect_error) {
    die("Дерекқорға қосылу қатесі: " . $conn->connect_error);
}

// Сессияны тексеру
session_start();
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(["error" => "Сессия аяқталған. Қайта кіріңіз."]);
    exit();
}

$user_id = $_SESSION['user_id'];

// Пайдаланушының сауалнамаларын алу
$sql = "SELECT s.id, s.title, s.created_at, 
               (SELECT COUNT(*) FROM participants p WHERE p.survey_id = s.id) AS participant_count 
        FROM surveys s 
        WHERE s.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$surveys = [];
while ($row = $result->fetch_assoc()) {
    $surveys[] = $row;
}

// JSON форматында мәліметтерді қайтарамыз
header('Content-Type: application/json');
echo json_encode($surveys);

$conn->close();
?>
