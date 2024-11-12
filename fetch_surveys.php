<?php
include 'auth.php';

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "survey_app";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$survey_id = $_GET['id'];

$sql = "SELECT * FROM survey_responses WHERE survey_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $survey_id);
$stmt->execute();
$result = $stmt->get_result();

$responses = [];
while ($row = $result->fetch_assoc()) {
    $responses[] = $row;
}

$stmt->close();
$conn->close();

header('Content-Type: application/json');
echo json_encode($responses);
?>
