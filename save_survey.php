<?php
// Деректер базасына қосылу параметрлері
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "survey_db";

// Деректер базасына қосылу
$conn = new mysqli($servername, $db_username, $db_password, $dbname);
if ($conn->connect_error) {
    die("Дерекқорға қосылу қатесі: " . $conn->connect_error);
}

// Тек POST сұранысын өңдейміз
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    session_start();
    if (!isset($_SESSION['user_id'])) {
        die("Сессия өшірілген немесе дұрыс емес. Қайта кіріңіз.");
    }

    $user_id = $_SESSION['user_id'];
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $questions = $_POST['question'];
    $options = $_POST['option'];

    if (empty($title)) {
        echo "Опрос атауын енгізіңіз.";
        exit();
    }

    // Транзакцияны бастаймыз
    $conn->begin_transaction();

    try {
        // Surveys кестесіне жазу
        $stmt_survey = $conn->prepare("INSERT INTO surveys (title, description, created_at, user_id) VALUES (?, ?, NOW(), ?)");
        $stmt_survey->bind_param("ssi", $title, $description, $user_id);
        $stmt_survey->execute();
        $survey_id = $stmt_survey->insert_id;
        $stmt_survey->close();

        // Сұрақтарды қосу
        foreach ($questions as $index => $question_text) {
            if (!empty($question_text)) {
                $stmt_question = $conn->prepare("INSERT INTO questions (question_text, survey_id) VALUES (?, ?)");
                $stmt_question->bind_param("si", $question_text, $survey_id);
                $stmt_question->execute();
                $question_id = $stmt_question->insert_id;
                $stmt_question->close();

                // Нұсқаларды қосу
                if (isset($options[$index])) {
                    foreach ($options[$index] as $option) {
                        if (!empty($option)) {
                            $stmt_option = $conn->prepare("INSERT INTO options (text, question_id) VALUES (?, ?)");
                            $stmt_option->bind_param("si", $option, $question_id);
                            $stmt_option->execute();
                            $stmt_option->close();
                        }
                    }
                }
            }
        }

        // Транзакцияны сақтау
        $conn->commit();
        echo "Опрос сәтті сақталды! <a href='dashboard.html'>Негізгі бетке оралу</a>";
    } catch (Exception $e) {
        $conn->rollback();
        echo "Қате: " . $e->getMessage();
    }
}

$conn->close();
?>
