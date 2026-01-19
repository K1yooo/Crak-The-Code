let currentSetIndex = 0;
let currentQuestionIndex = 0;
let sets = [];
let topic = null;
let lives = 3;
let score = 0;
let completedSetIndices = [];

// Timer variables
let timerInterval;
let secondsRemaining = 120; 
let isTimeUp = false;
const TIMER_DURATION = 120; 

function chooseTopic(topicName) {
    localStorage.removeItem("cipherGameState");

    lives = 3;
    document.getElementById("starDisplay").innerText = "❤️❤️❤️";
    topic = topicName;

    fetch('http://localhost/CrackTheCode/Backend/game_data.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ topic: topicName })
    })
        .then(response => response.json())
        .then(data => {
            if (!data || !data.sets || data.sets.length === 0) {
                alert("⚠️ No questions available for this topic.");
                return;
            }

            sets = data.sets;
            currentSetIndex = 0;
            currentQuestionIndex = 0;

            document.getElementById("topicButtons").style.display = "none";
            document.getElementById("gameBox").style.display = "block";
            const topicHeader = document.getElementById("selectedTopic");
            topicHeader.innerHTML = `<button class="back-btn" onclick="confirmExit()">←</button><span>Topic: ${topicName}</span>`;

            displayQuestion();
        })
        .catch(error => {
            console.error('Error loading game data:', error);
            alert("❌ Could not load game data.");
        });
}

function startGameTimer() {
    stopGameTimer(); 
    secondsRemaining = TIMER_DURATION; 
    isTimeUp = false;
    document.getElementById("resultArea").innerText = ''; 

    updateTimerDisplay();
    timerInterval = setInterval(() => {
        secondsRemaining--;
        updateTimerDisplay();

        if (secondsRemaining <= 0) {
            isTimeUp = true;
            handleTimeUp();
        }
    }, 1000);
}

function stopGameTimer() {
    if (timerInterval) {
        clearInterval(timerInterval);
        timerInterval = null;
    }
}

function updateTimerDisplay() {
    const minutes = String(Math.floor(secondsRemaining / 60)).padStart(2, '0');
    const seconds = String(secondsRemaining % 60).padStart(2, '0');
    const timerElement = document.getElementById('gameTimer');
    timerElement.textContent = `⏰ ${minutes}:${seconds}`;

    if (secondsRemaining <= 30) {
        timerElement.style.color = 'red';
    } else {
        timerElement.style.color = '#fff';
    }
}

function handleTimeUp() {
    stopGameTimer();
    document.getElementById("wrongSound").play();

    lives--;
    const starDisplay = document.getElementById("starDisplay");

    if (lives === 2) {
        starDisplay.innerText = "❤️❤️";
        document.getElementById("resultArea").innerHTML = '<span style="color:red;font-weight:bold;">⏰ Time\'s up! You lost a life!</span>';
    } else if (lives === 1) {
        starDisplay.innerText = "❤️";
        document.getElementById("resultArea").innerHTML = '<span style="color:red;font-weight:bold;">⏰ Time\'s up! You lost a life!</span>';
    } else if (lives === 0) {
        starDisplay.innerText = "";
        localStorage.removeItem("cipherGameState");
        document.getElementById("gameOverModal").style.display = "flex";
        return;
    }

    // Reset timer for the same question 
    setTimeout(() => {
        startGameTimer();
        document.getElementById("resultArea").innerText = 'Try again! Time reset.';
        
        setTimeout(() => {
            document.getElementById("resultArea").innerText = '';
        }, 2000);
    }, 2000);

    saveGameState();
}

function displayQuestion() {
    if (!sets.length || !sets[currentSetIndex]) {
        console.warn("No sets or invalid index:", currentSetIndex);
        return;
    }

    const set = sets[currentSetIndex];

    if (!set.questions || !set.questions.length || !set.questions[currentQuestionIndex]) {
        console.warn("No questions or invalid question index:", currentQuestionIndex);
        return;
    }

    const question = set.questions[currentQuestionIndex];
    const shiftInfo = document.getElementById("shiftInfo");
    const encryptedWord = document.querySelector(".encrypted-word strong");
    const hintText = document.getElementById("hintText");
    const input = document.getElementById("decryptedInput");
    const resultArea = document.getElementById("resultArea");

    if (!shiftInfo || !encryptedWord || !hintText || !input || !resultArea) {
        console.error("❌ Missing one or more elements in the DOM.");
        return;
    }

    const topicHeader = document.getElementById("selectedTopic");
    if (topicHeader && topic) {
        topicHeader.innerHTML = `<button class="back-btn" onclick="confirmExit()">←</button><span>Topic: ${topic}</span>`;
        topicHeader.style.display = "block";
    }

    shiftInfo.innerText = `Keyword: ${set.keyword_key ?? "None"}`;
    encryptedWord.innerText = question.ciphertext;
    hintText.innerText = `Hint: ${question.hint || ''}`;
    input.value = '';
    resultArea.innerText = '';

    startGameTimer();

    saveGameState();
}

function checkAnswer() {
    // Prevent submission if time is up 
    if (isTimeUp) {
        document.getElementById("resultArea").innerHTML = '<span style="color:red;font-weight:bold;">⏰ Please wait for timer to reset!</span>';
        return;
    }

    const userInput = document.getElementById("decryptedInput").value.trim().toLowerCase();
    const correctAnswer = sets[currentSetIndex].questions[currentQuestionIndex].plaintext.toLowerCase();

    const starDisplay = document.getElementById("starDisplay");

    if (userInput === correctAnswer) {
        stopGameTimer(); 
        document.getElementById("correctSound").play();

        score += 20;
        updateProgressBar();

        currentQuestionIndex++;

        if (score >= 100) {
            document.getElementById("successSound").play();
            localStorage.removeItem("cipherGameState");

            const currentSetName = sets[currentSetIndex]?.set_name || "unknown";
            document.getElementById("flagResult").innerText = "🎉 You've unlocked the final flag!";
            document.getElementById("flagDefinition").innerText = `🏁 FLAG: crack{${currentSetName}}`;
            document.getElementById("successModal").style.display = "flex";

            const userId = CURRENT_USER_ID;
            const setId = sets[currentSetIndex]?.set_id;
            updateAchievement(userId, setId, 1, 1);

            document.querySelectorAll(".cipher-input").forEach(input => input.value = "");
            document.getElementById("alphabetCipher").style.display = "none";
            return;
        }

        if (currentQuestionIndex >= sets[currentSetIndex].questions.length) {
            if (!completedSetIndices.includes(currentSetIndex)) {
                completedSetIndices.push(currentSetIndex);
            }
            currentSetIndex++;
            currentQuestionIndex = 0;

            if (currentSetIndex >= sets.length) {
                localStorage.removeItem("cipherGameState");
                document.getElementById("successModal").style.display = "flex";
                return;
            }
        }

        displayQuestion();
    } else {
        document.getElementById("wrongSound").play();

        lives--;

        if (lives === 2) {
            starDisplay.innerText = "❤️❤️";
            document.getElementById("resultArea").innerText = "❌ Try Again!";
        } else if (lives === 1) {
            starDisplay.innerText = "❤️";
            document.getElementById("resultArea").innerText = "❌ Try Again!";
        } else if (lives === 0) {
            stopGameTimer();
            starDisplay.innerText = "";
            localStorage.removeItem("cipherGameState");
            document.getElementById("gameOverModal").style.display = "flex";
            return;
        }

        saveGameState();
    }
}

function goHome() {
    stopGameTimer();
    localStorage.removeItem("cipherGameState");
    window.location.href = 'startpage.php';
}

function loadRandomSet() {
    document.getElementById("successModal").style.display = "none";

    const remainingIndices = sets
        .map((_, index) => index)
        .filter(index => !completedSetIndices.includes(index));

    if (remainingIndices.length === 0) {
        alert("🎉 You've completed all available sets!");
        goHome();
        return;
    }

    const randomIndex = remainingIndices[Math.floor(Math.random() * remainingIndices.length)];

    currentSetIndex = randomIndex;
    currentQuestionIndex = 0;
    score = 0;
    lives = 3;
    document.getElementById("starDisplay").innerText = "❤️❤️❤️";

    updateProgressBar();
    saveGameState();
}

function handleContinue() {
    stopGameTimer();
    document.getElementById("successModal").style.display = "none";

    if (!completedSetIndices.includes(currentSetIndex)) {
        completedSetIndices.push(currentSetIndex);
    }

    const remainingIndices = sets
        .map((_, index) => index)
        .filter(index => !completedSetIndices.includes(index));

    if (remainingIndices.length === 0) {
        alert("🎉 You've completed all available sets!");
        goHome();
        return;
    }

    const randomIndex = remainingIndices[Math.floor(Math.random() * remainingIndices.length)];
    currentSetIndex = randomIndex;
    currentQuestionIndex = 0;
    score = 0;
    lives = 3;

    document.getElementById("starDisplay").innerText = "❤️❤️❤️";
    updateProgressBar();

    document.getElementById("decryptedInput").value = '';
    document.querySelectorAll(".cipher-input").forEach(input => input.value = '');

    document.getElementById("resultArea").innerText = '';
    document.getElementById("alphabetCipher").style.display = "none";

    saveGameState();
    displayQuestion();
}

function updateProgressBar() {
    const bar = document.getElementById("progressBar");
    const percentage = Math.min(score, 100);
    bar.style.width = `${percentage}%`;
}

function toggleHowToPlay() {
    const modal = document.getElementById("howToPlayModal");
    modal.classList.toggle("modal-visible");
    modal.classList.toggle("modal-hidden");
}

function retryGame() {
    stopGameTimer();
    localStorage.removeItem("cipherGameState");
    location.reload();
}

function confirmExit() {
    const modal = document.getElementById("exitModal");
    modal.style.display = "flex";

    const yesBtn = document.getElementById("exitYesBtn");
    const noBtn = document.getElementById("exitNoBtn");

    yesBtn.onclick = function () {
        stopGameTimer();
        localStorage.removeItem("cipherGameState");
        window.location.href = "startpage.php";
    };

    noBtn.onclick = function () {
        modal.style.display = "none";
    };
}

function toggleHint() {
    const hint = document.getElementById("hintText");
    hint.style.display = hint.style.display === "none" ? "block" : "none";
}

function toggleAlphabetCipher() {
    const container = document.getElementById("alphabetCipher");
    container.style.display = container.style.display === "none" ? "block" : "none";
}

function getCipherInputs() {
    const inputs = document.querySelectorAll(".cipher-input");
    return Array.from(inputs).map(input => input.value || "");
}

function saveGameState() {
    const state = {
        topic,
        currentSetIndex,
        currentQuestionIndex,
        cipherInputs: getCipherInputs(),
        sets,
        lives,
        score,
        hasStartedGame: true,
        completedSetIndices,
        timerSeconds: secondsRemaining,
        isTimeUp: isTimeUp
    };
    localStorage.setItem("cipherGameState", JSON.stringify(state));
}

function restoreCipherInputs(inputValues) {
    const inputs = document.querySelectorAll(".cipher-input");
    inputValues.forEach((val, i) => {
        if (inputs[i]) inputs[i].value = val;
    });
}

function loadGameState() {
    const savedState = localStorage.getItem("cipherGameState");
    if (!savedState) return;

    const state = JSON.parse(savedState);

    if (!state.hasStartedGame || !state.topic || !state.sets) return;

    if (state.lives !== undefined) lives = state.lives;
    document.getElementById("starDisplay").innerText = "❤️".repeat(lives);

    if (state.score !== undefined) {
        score = state.score;
        updateProgressBar();
    }

    topic = state.topic;
    currentSetIndex = state.currentSetIndex;
    currentQuestionIndex = state.currentQuestionIndex;
    sets = state.sets;

    document.getElementById("topicButtons").style.display = "none";
    document.getElementById("gameBox").style.display = "block";

    const topicHeader = document.getElementById("selectedTopic");
    topicHeader.innerHTML = `<button class="back-btn" onclick="confirmExit()">←</button><span>Topic: ${topic}</span>`;

    displayQuestion();

    if (state.timerSeconds !== undefined) {
        secondsRemaining = state.timerSeconds;
        isTimeUp = state.isTimeUp || false;
        if (!isTimeUp && secondsRemaining > 0) {
            startGameTimer();
        }
    }

    setTimeout(() => restoreCipherInputs(state.cipherInputs), 100);
}

document.addEventListener("DOMContentLoaded", () => {
    const submitBtn = document.querySelector(".submit-btn");
    submitBtn.addEventListener("click", checkAnswer);
    loadGameState();

    const letters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ".split("");
    const plainRow = document.getElementById("plainAlphabetRow");
    const inputRow = document.getElementById("cipherInputRow");

    letters.forEach((letter, index) => {
        // Plain Alphabet Box
        const box = document.createElement("div");
        box.className = "cipher-box";
        box.textContent = letter;
        plainRow.appendChild(box);

        // Cipher Input Box
        const input = document.createElement("input");
        input.type = "text";
        input.maxLength = 1;
        input.className = "cipher-input";
        input.dataset.index = index;

        input.addEventListener("input", function () {
            this.value = this.value.toUpperCase().replace(/[^A-Z]/g, '');
            if (this.value && index < 25) {
                const next = document.querySelector(`input[data-index="${index + 1}"]`);
                if (next) next.focus();
            }
            saveGameState();
        });

        input.addEventListener("keydown", function (e) {
            if (e.key === "ArrowLeft" && index > 0) {
                e.preventDefault();
                const prev = document.querySelector(`input[data-index="${index - 1}"]`);
                if (prev) prev.focus();
            } else if (e.key === "ArrowRight" && index < 25) {
                e.preventDefault();
                const next = document.querySelector(`input[data-index="${index + 1}"]`);
                if (next) next.focus();
            } else if (e.key === "Backspace") {
                if (!this.value && index > 0) {
                    e.preventDefault();
                    const prev = document.querySelector(`input[data-index="${index - 1}"]`);
                    if (prev) {
                        prev.value = "";
                        prev.focus();
                    }
                }
            }
        });

        inputRow.appendChild(input);
    });
});

function updateAchievement(userId, setId, completed = 1, won = 1) {
    const formData = new FormData();
    formData.append("user_id", userId);
    formData.append("set_id", setId);
    formData.append("completed", completed);
    formData.append("won", won);

    fetch('http://localhost/CrackTheCode/Backend/update_achievement.php', {
        method: 'POST',
        body: formData
    })
        .then(res => res.text())
        .then(result => {
            if (result.trim() === "success") {
                console.log("Achievement updated successfully!");
            } else {
                console.error("Server returned an error:", result);
            }
        })
        .catch(err => {
            console.error("Fetch error:", err);
        });
}