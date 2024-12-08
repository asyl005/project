<?php
// Тексеру үшін қателерді көрсетуді қосамыз
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Форма арқылы алынған деректерді тексереміз
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $questions = $_POST['question'];
    $options = $_POST['option'];

    // Деректерді тексеріп, базада сақтау үшін код қосуға болады

    // Успех туралы хабарды көрсетеміз
    echo "Опрос успешно сохранен!";
} else {
    echo "Данные не были отправлены.";
}
?>

<script>
    document.querySelector('.survey-form').onsubmit = function(event) {
        event.preventDefault(); // Әдеттегі жіберуді болдырмау
        alert('Опрос успешно сохранен!'); // Пайдаланушыға хабарды көрсету
    };
</script>
