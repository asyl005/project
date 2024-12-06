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
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            display: flex;
            flex-direction: column;
            height: 100vh;
            background: linear-gradient(135deg, #dcdbcf, #b5ae9c);
        }

        header {
            background: linear-gradient(135deg, #aeaa9e, #c0c0b8);
            color: #fff;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .content {
            flex: 1;
            padding: 20px;
            background: linear-gradient(135deg, #f9fbfd, #e2dff0);
            border-radius: 8px;
            margin: 10px;
        }

        .content h1 {
            color: #6c4f3d;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .survey-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .survey-item {
            background: linear-gradient(135deg, #fff3e6, #f9d9b6);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .survey-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 14px rgba(0, 0, 0, 0.2);
        }

        .survey-item h3 {
            font-size: 20px;
            color: #d47e5d;
            margin-bottom: 10px;
        }

        .survey-item p {
            color: #7c5c4f;
            margin-bottom: 10px;
            font-size: 16px;
        }

        .view-btn {
            display: inline-block;
            padding: 10px 15px;
            color: #fff;
            background: linear-gradient(135deg, #ff9f75, #ff8e53);
            text-decoration: none;
            border-radius: 8px;
            font-size: 14px;
            transition: background 0.3s ease;
        }

        .view-btn:hover {
            background: linear-gradient(135deg, #ff8e53, #d47e5d);
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
