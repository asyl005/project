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

// Сауалнама ID-сін тексеру
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Сауалнама ID көрсетілмеген.");
}

$survey_id = intval($_GET['id']);

// Сауалнаманың сұрақтарын алу
$sql = "SELECT question_text FROM questions WHERE survey_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $survey_id);
$stmt->execute();
$result = $stmt->get_result();

$questions = [];
while ($row = $result->fetch_assoc()) {
    $questions[] = $row;
}

// Сауалнама туралы ақпаратты алу
$sql_survey = "SELECT title, created_at FROM surveys WHERE id = ?";
$stmt_survey = $conn->prepare($sql_survey);
$stmt_survey->bind_param("i", $survey_id);
$stmt_survey->execute();
$survey_result = $stmt_survey->get_result();
$survey = $survey_result->fetch_assoc();

$conn->close();
?>

<!DOCTYPE html>
<html lang="kk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Сауалнама - <?= htmlspecialchars($survey['title']) ?></title>
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
            min-height: 100vh;
            background: linear-gradient(135deg, #dcdbcf, #b5ae9c); /* Жоғарыдағы градиент түстер */
            padding: 20px;
        }

        h1 {
            color: #6c4f3d; /* Қара қоңыр түс */
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
        }

        .survey-info {
            margin-bottom: 30px;
            background: linear-gradient(135deg, #aeaa9e, #c0c0b8); /* Әдемі фон */
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .survey-info p {
            color: #fff; /* Ақ түсті мәтін */
            font-size: 16px;
        }

        .questions {
            margin-top: 20px;
        }

        .question-item {
            background: linear-gradient(135deg, #fff3e6, #f9d9b6); /* Сұрақтардың фоны */
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .question-item p {
            font-size: 18px;
            color: #7c5c4f; /* Жұмсақ қоңыр түс */
        }

        button {
            padding: 10px 20px;
            background: linear-gradient(135deg, #ff9f75, #ff8e53); /* Батырманың фоны */
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button:hover {
            background: linear-gradient(135deg, #ff8e53, #d47e5d); /* Батырманың hover түстері */
        }
    </style>
</head>
<body>
    <h1>Сауалнама: <?= htmlspecialchars($survey['title']) ?></h1>
    <div class="survey-info">
        <p>Құрылған күні: <?= htmlspecialchars($survey['created_at']) ?></p>
    </div>

    <div class="questions">
        <h2>Сұрақтар</h2>
        <?php if (empty($questions)): ?>
            <p>Сұрақтар жоқ.</p>
        <?php else: ?>
            <?php foreach ($questions as $question): ?>
                <div class="question-item">
                    <p><strong>Сұрақ:</strong> <?= htmlspecialchars($question['question_text']) ?></p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>
</html>




