<?php 
session_start(); 

// Проверка, существует ли имя пользователя в сессии
if (!isset($_SESSION['username'])) {
    // Если имя пользователя не найдено в сессии, перенаправить на страницу логина
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Личный кабинет - Testograf</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
    <header>
        <div class="header-content">
            <!-- Подставляем имя пользователя из сессии -->
            <h1>Добро пожаловать, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
            <a href="logout.php" class="logout-btn">Выйти</a>
        </div>
    </header>

    <main>
        <aside class="sidebar">
            <nav>
                <ul>
                    <li><a href="create_survey.html">Создать новый опрос</a></li>
                    <li><a href="my_surveys.php">Мои опросы</a></li>
                    <li><a href="results.html">Результаты</a></li>
                    <li><a href="profile.html">Настройки профиля</a></li>
                </ul>
            </nav>
        </aside>

        <section class="content">
            <h2>Ваши последние опросы</h2>
            <div class="survey-list">
                <!-- Здесь можно динамически подгружать список опросов пользователя -->
                <div class="survey-item">
                    <h3>Опрос: Удовлетворенность продуктом</h3>
                    <p>Дата создания: 12.03.2024</p>
                    <p>Количество участников: 120</p>
                    <a href="view_survey.html" class="view-btn">Посмотреть</a>
                </div>
                <div class="survey-item">
                    <h3>Опрос: Обратная связь</h3>
                    <p>Дата создания: 10.03.2024</p>
                    <p>Количество участников: 90</p>
                    <a href="view_survey.html" class="view-btn">Посмотреть</a>
                </div>
                <!-- Добавьте больше блоков опросов или сделайте их динамическими через базу данных -->
            </div>
        </section>
    </main>
</body>
</html>
