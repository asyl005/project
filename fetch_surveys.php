<?php
// Қазақша түсініктеме:
// Бұл файл тек ағымдағы пайдаланушының (сессия бойынша) сауалнамаларын қайтару үшін арналған.

// Деректер базасына қосылу
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "survey_db"; // Қате түзетілді: survey_app -> survey_db

$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Қосылымды тексеру
if ($conn->connect_error) {
    die("Дерекқорға қосылу қатесі: " . $conn->connect_error);
}

// Сессияны бастау және пайдаланушыны тексеру
session_start();
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "Пайдаланушы кірмеген."]);
    exit();
}

$user_id = $_SESSION['user_id']; // Сессиядан ағымдағы пайдаланушының ID-ын алу

// Тек ағымдағы пайдаланушының сауалнамаларын алу
$sql = "SELECT s.id, s.title, s.created_at, 
               (SELECT COUNT(*) FROM responses WHERE survey_id = s.id) AS participant_count
        FROM surveys s
        WHERE s.user_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id); // Пайдаланушы ID-ын сұрауға қосу
$stmt->execute();
$result = $stmt->get_result();

$surveys = [];
while ($row = $result->fetch_assoc()) {
    $surveys[] = $row; // Сауалнамалардың мәліметтерін жинау
}

$stmt->close();
$conn->close();

// Нәтижелерді JSON форматында қайтару
echo json_encode($surveys);
?>
