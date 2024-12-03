<?php
// Деректер базасына қосылу параметрлері
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "survey_db";

// Деректер базасына қосылу
$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Қосылымды тексеру
if ($conn->connect_error) {
    die("Дерекқорға қосылу қатесі: " . $conn->connect_error);
}

// Сессияны тексеру
session_start();
if (!isset($_SESSION['user_id'])) {
    die("Сессия өшірілген. Алдымен кіріңіз.");
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

$conn->close();
?>

<!DOCTYPE html>
<html lang="kk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Менің сауалнамаларым</title>
    <style>
        .survey-item {
            border: 1px solid #ddd;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
        }
        .view-btn {
            color: blue;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <h1>Сіздің сақталған сауалнамаларыңыз</h1>
    <div id="surveyList">
        <?php if (empty($surveys)): ?>
            <p>Сізде ешқандай сақталған сауалнама жоқ.</p>
        <?php else: ?>
            <?php foreach ($surveys as $survey): ?>
                <div class="survey-item">
                    <h3>Сауалнама: <?= htmlspecialchars($survey['title']) ?></h3>
                    <p>Құрылған күні: <?= htmlspecialchars($survey['created_at']) ?></p>
                    <p>Қатысушылар саны: <?= htmlspecialchars($survey['participant_count']) ?></p>
                    <a href="view_survey.php?id=<?= htmlspecialchars($survey['id']) ?>" class="view-btn">Қарау</a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>
</html>
