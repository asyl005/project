let questionCount = 0;

function addQuestion() {
    const questionsContainer = document.getElementById("questionsContainer");

    const questionDiv = document.createElement("div");
    questionDiv.classList.add("question");

    questionDiv.innerHTML = `
        <input type="text" placeholder="Вопрос" class="questionTitle">
        <div class="options">
            <div class="option">
                <input type="radio" name="q${questionCount}"> <input type="text" placeholder="Вариант 1">
            </div>
            <button onclick="addOption(this)">Добавить вариант</button>
        </div>
    `;

    questionsContainer.appendChild(questionDiv);
    questionCount++;
}

function addOption(button) {
    const optionDiv = document.createElement("div");
    optionDiv.classList.add("option");

    optionDiv.innerHTML = `<input type="radio" name="q${questionCount}"> <input type="text" placeholder="Новый вариант">`;

    button.parentNode.insertBefore(optionDiv, button);
}

function saveSurvey() {
    const surveyTitle = document.getElementById("surveyTitle").value;
    const surveyDescription = document.getElementById("surveyDescription").value;

    const questions = [];
    document.querySelectorAll(".question").forEach(questionDiv => {
        const questionTitle = questionDiv.querySelector(".questionTitle").value;
        const options = Array.from(questionDiv.querySelectorAll(".option input[type='text']")).map(input => input.value);

        questions.push({ title: questionTitle, options });
    });

    const survey = { title: surveyTitle, description: surveyDescription, questions };
    let surveys = JSON.parse(localStorage.getItem("surveys")) || [];
    surveys.push(survey);

    localStorage.setItem("surveys", JSON.stringify(surveys));
    alert("Анкета сохранена!");

    // Форму сбросить
    document.getElementById("surveyTitle").value = "";
    document.getElementById("surveyDescription").value = "";
    document.getElementById("questionsContainer").innerHTML = "";
    questionCount = 0;
}

function loadSurveys() {
    const surveys = JSON.parse(localStorage.getItem("surveys")) || [];
    const surveysContainer = document.getElementById("mySurveysContainer");

    surveysContainer.innerHTML = "";
    surveys.forEach(survey => {
        const surveyDiv = document.createElement("div");
        surveyDiv.classList.add("survey");

        surveyDiv.innerHTML = `
            <h2>${survey.title}</h2>
            <p>${survey.description}</p>
            ${survey.questions.map(q => `
                <div class="question">
                    <h3>${q.title}</h3>
                    ${q.options.map(option => `<p>${option}</p>`).join("")}
                </div>
            `).join("")}
        `;

        surveysContainer.appendChild(surveyDiv);
    });
}
