const translations = {
    kk: {
        "main-heading": "Сауалнама сервисінен де көп",
        "features-link": "Мүмкіндіктер",
        "pricing-link": "Тарифтер",
        "login-link": "Кіру",
        "feature-tests": "тесттер",
        "feature-analytics": "талдау",
        "feature-statistics": "статистика",
        "feature-surveys": "сауалнама",
        "feature-voting": "дауыс беру",
        "connect-btn": "Қосылу",
        "footer-text": "© 2024 Тестограф. Барлық құқықтар қорғалған."
    },
    ru: {
        "main-heading": "Больше, чем сервис опросов",
        "features-link": "Возможности",
        "pricing-link": "Тарифы",
        "login-link": "Войти",
        "feature-tests": "тестов",
        "feature-analytics": "аналитики",
        "feature-statistics": "статистики",
        "feature-surveys": "анкетирования",
        "feature-voting": "голосований",
        "connect-btn": "Подключиться",
        "footer-text": "© 2024 Тестограф. Все права защищены."
    },
    en: {
        "main-heading": "More than a survey service",
        "features-link": "Features",
        "pricing-link": "Pricing",
        "login-link": "Login",
        "feature-tests": "tests",
        "feature-analytics": "analytics",
        "feature-statistics": "statistics",
        "feature-surveys": "surveys",
        "feature-voting": "voting",
        "connect-btn": "Connect",
        "footer-text": "© 2024 Testograf. All rights reserved."
    }
};

function changeLanguage(language) {
    document.getElementById("main-heading").textContent = translations[language]["main-heading"];
    document.getElementById("features-link").textContent = translations[language]["features-link"];
    document.getElementById("pricing-link").textContent = translations[language]["pricing-link"];
    document.getElementById("login-link").textContent = translations[language]["login-link"];
    document.getElementById("feature-tests").textContent = translations[language]["feature-tests"];
    document.getElementById("feature-analytics").textContent = translations[language]["feature-analytics"];
    document.getElementById("feature-statistics").textContent = translations[language]["feature-statistics"];
    document.getElementById("feature-surveys").textContent = translations[language]["feature-surveys"];
    document.getElementById("feature-voting").textContent = translations[language]["feature-voting"];
    document.getElementById("connect-btn").textContent = translations[language]["connect-btn"];
    document.getElementById("footer-text").textContent = translations[language]["footer-text"];
}

document.getElementById("language-select").addEventListener("change", function() {
    changeLanguage(this.value);
});
