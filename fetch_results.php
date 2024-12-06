<?php
// Деректер базасына қосылу параметрлері
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "survey_db";

// Дерекқорға қосылу
$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Қосылымды тексеру
if ($conn->connect_error) {
    die("Дерекқорға қосылу қатесі: " . $conn->connect_error);
}

// Сауалнама ID-сін тексеру
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo json_encode(["error" => "Сауалнама ID көрсетілмеген."]);
    exit;
}

$survey_id = intval($_GET['id']);

// Нәтижелерді алу
$sql = "SELECT response, response_date FROM responses WHERE survey_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $survey_id);
$stmt->execute();
$result = $stmt->get_result();

$responses = [];
while ($row = $result->fetch_assoc()) {
    $responses[] = $row;
}

$conn->close();

// JSON форматында нәтижелерді қайтару
header('Content-Type: application/json');
echo json_encode($responses);
?>
