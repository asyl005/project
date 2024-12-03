<?php
// Қазақша түсініктемелер:
// Бұл файл опросты "surveys", "questions" және "options" кестелеріне сақтауға арналған.
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

// Тек POST сұранысын өңдейміз
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Пайдаланушы енгізген деректерді алу
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $questions = $_POST['question'];
    $options = $_POST['option'];

    // Сауалнама тақырыбы мен сипаттамасын тексеру
    if (empty($title)) {
        echo "Опрос атауын енгізіңіз.";
        exit();
    }

    // "surveys" кестесіне сауалнама мәліметтерін сақтау
    $sql_insert_survey = "INSERT INTO surveys (title, description, created_at, user_id) VALUES (?, ?, NOW(), ?)";
    $stmt_survey = $conn->prepare($sql_insert_survey);

    // Пайдаланушы идентификаторын сессиядан аламыз
    session_start();
    $user_id = $_SESSION['user_id'];

    $stmt_survey->bind_param("ssi", $title, $description, $user_id);
    $stmt_survey->execute();

    // Сақталған сауалнаманың ID-н аламыз
    $survey_id = $stmt_survey->insert_id;
    $stmt_survey->close();

    // Әр сұрақты және олардың жауап нұсқаларын сақтау
    foreach ($questions as $index => $question_text) {
        if (!empty($question_text)) {
            // "questions" кестесіне сұрақты қосу
            $sql_insert_question = "INSERT INTO questions (question_text, survey_id) VALUES (?, ?)";
            $stmt_question = $conn->prepare($sql_insert_question);
            $stmt_question->bind_param("si", $question_text, $survey_id);
            $stmt_question->execute();

            // Сақталған сұрақтың ID-н аламыз
            $question_id = $stmt_question->insert_id;
            $stmt_question->close();

            // Сұраққа байланысты нұсқаларды "options" кестесіне қосу
            foreach ($options as $option) {
                if (!empty($option)) {
                    $sql_insert_option = "INSERT INTO options (text, question_id) VALUES (?, ?)";
                    $stmt_option = $conn->prepare($sql_insert_option);
                    $stmt_option->bind_param("si", $option, $question_id);
                    $stmt_option->execute();
                    $stmt_option->close();
                }
            }
        }
    }

    echo "Опрос сәтті сақталды! <a href='dashboard.php'>Негізгі бетке оралу</a>";
}

$conn->close();
?>