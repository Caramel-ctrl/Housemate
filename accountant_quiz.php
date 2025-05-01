<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Management Quiz</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

<div class="bg-white p-8 rounded-xl shadow-xl max-w-lg w-full text-center">
    <h2 class="text-2xl font-bold text-pink-600 mb-4">Answer the Accounting Question</h2>
    <div id="question" class="text-lg font-medium mb-4"></div>
    <input type="text" id="answer" class="w-full p-2 border border-gray-300 rounded mb-4" placeholder="Your answer...">
    <button onclick="checkAnswer()" class="bg-pink-600 hover:bg-pink-700 text-white px-4 py-2 rounded">
        Submit
    </button>
    <p id="feedback" class="mt-4 text-sm font-semibold text-red-600"></p>
</div>

<script>
    const questions = [
        { question: "What is the formula for Net Income?", answer: "Revenue - Expenses" },
        { question: "What does GAAP stand for?", answer: "Generally Accepted Accounting Principles" },
        { question: "Which financial statement shows a company's assets and liabilities?", answer: "Balance Sheet" },
        { question: "What is the normal balance of an asset account?", answer: "Debit" },
        { question: "Which account type is affected when a company receives cash?", answer: "Asset" },
        { question: "What is depreciation?", answer: "Allocation of asset cost over time" },
        { question: "What does ROI stand for?", answer: "Return on Investment" },
        { question: "Which account increases with a credit?", answer: "Liability" }
    ];

    let usedIndexes = new Set();
    let currentQuestion = {};

    function loadQuestion() {
        document.getElementById('feedback').innerText = '';

        if (usedIndexes.size === questions.length) {
            usedIndexes.clear(); // Reset if all questions used
        }

        let index;
        do {
            index = Math.floor(Math.random() * questions.length);
        } while (usedIndexes.has(index));

        usedIndexes.add(index);
        currentQuestion = questions[index];

        document.getElementById('question').innerText = currentQuestion.question;
        document.getElementById('answer').value = '';
    }

    function checkAnswer() {
        const userAnswer = document.getElementById('answer').value.trim().toLowerCase();
        const correctAnswer = currentQuestion.answer.toLowerCase();

        if (userAnswer === correctAnswer) {
            window.location.href = 'success.php';
        } else {
            document.getElementById('feedback').innerText = "❌ Incorrect. Try another question!";
            loadQuestion(); // Generate a new one
        }
    }

    loadQuestion();
</script>

</body>
</html>
