<?php
// Деректер базасына қосылу
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "survey_db"; // Құрылымға сәйкес база атауы

$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Қосылымды тексеру
if ($conn->connect_error) {
    die("Дерекқорға қосылу қатесі: " . $conn->connect_error);
}

// Сауалнама ID алу
if (isset($_GET['id'])) {
    $survey_id = $_GET['id'];

    // Сауалнамаға қатысушылардың жауаптарын алу
    $sql = "SELECT r.response_date, o.text AS response, u.username 
            FROM responses r
            JOIN options o ON r.option_id = o.id
            JOIN users u ON r.user_id = u.id
            WHERE o.survey_id = ?";

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

    // JSON форматында жауаптарды қайтару
    echo json_encode($responses);
} else {
    echo json_encode(["error" => "Не указан ID опроса."]);
}
?>
