<?php
    include('../Backend/get_user_info.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Keyword Cipher Game</title>
  <link href="https://fonts.googleapis.com/css2?family=Luckiest+Guy&family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="http://localhost/CrackTheCode/Frontend/css/keyword.css" rel="stylesheet">
</head>
<body>

<div class="container">
  <img src="http://localhost/CrackTheCode/Image/gametitle.png" alt="Crack the Code!" class="title-image">

  <button id="howToPlayBtn" class="howtoplay-btn" onclick="toggleHowToPlay()" title="How to Play">❓</button>

  <div class="topic-buttons" id="topicButtons">
    <button onclick="chooseTopic('Data Privacy')">
      <span class="icon">🔐</span>
      <span>Data Privacy</span>
    </button>
    <button onclick="chooseTopic('Famous People')">
      <span class="icon">🌟</span>
      <span>Famous People</span>
    </button>
      <button onclick="chooseTopic('Medicine')">
      <span class="icon">💊</span>
      <span>Medicine</span>
    </button>
    <button onclick="chooseTopic('Continents')">
      <span class="icon">🌍</span>
      <span>Continents</span>
    </button>
    <button onclick="chooseTopic('Fruit')">
      <span class="icon">🍉</span>
      <span>Fruit</span>
    </button>
    <button onclick="chooseTopic('Vegetables')">
      <span class="icon">🥦</span>
      <span>Vegetables</span>
    </button>
      <button onclick="chooseTopic('Earth Wonders')">
      <span class="icon">🌍</span>
      <span>Earth Wonders</span>
    </button>
    <button onclick="chooseTopic('Outer Space')">
      <span class="icon">🪐</span>
      <span>Outer Space</span>
    </button>
  </div>


  <div class="selected-topic" id="selectedTopic">
    <button class="back-btn" onclick="window.location.href='startpage.php'" title="Back to Start">←</button>
    <span id="topicNameLabel"></span>
  </div>

  </div>
    <!-- How to Play button -->
    <button id="howToPlayBtn" class="howtoplay-btn" onclick="toggleHowToPlay()" title="How to Play">❓</button>
    <div id="howToPlayModal" class="modal-hidden">
        <div class="modal-content">
            <button class="close-btn" onclick="toggleHowToPlay()">✖</button>
    <h2>🔍 How to Play</h2>
    <p>Welcome to <strong>Crack the Code!</strong> Your goal is to decrypt the encrypted words based on the given <strong>hint</strong> and <strong>cipher type</strong>.</p>

    <h3>🔑 Decrypt Using Keyword Cipher</h3>
    <ol>
      <li>We/’ll give you a <strong>keyword</strong> (e.g., FLAG).</li>
      <li>Build a cipher alphabet using that keyword (no duplicate letters).</li>
      <br>
      <pre>
Cipher Alphabet : F L A G B C D E H I J K M N O P Q R S T U V W X Y Z
Plain Alphabet  : A B C D E F G H I J K L M N O P Q R S T U V W X Y Z
      </pre>
      <li>Match each letter in the encrypted word using this custom alphabet.</li>
      <p><strong>Example:</strong></p>
      <p>Encrypted: <code>CORBST</code> ➜ Decryption:</p>
      <ul>
        <li>C → F</li>
        <li>O → O</li>
        <li>R → R</li>
        <li>B → E</li>
        <li>S → S</li>
        <li>T → T</li>
      </ul>
      <p><strong>Result: FOREST</strong></p>
    </ol>

    <p style="margin-top: 15px;"><strong>🎯 Your Task:</strong> Use the hints and decryption techniques to crack the encrypted words. Each correct answer helps you unlock a flag. Good luck!</p>
  </div>
</div>


   <div class="game-box" id="gameBox" style="display: none;">
    <div class="game-info-bar">
      <div class="stars" id="starDisplay">❤️❤️❤️</div>
      <button class="hint-btn" onclick="toggleHint()" title="Show Hint">💡</button>
      <div class="timer" id="gameTimer" style="font-size: 1.2em; margin-left: 20px;">⏰ 00:00</div>
    </div>

    <!-- Cipher chart -->
    <div class="cipher-chart-wrapper">
      <div class="cipher-chart-header">
        <button class="cipher-icon-btn" onclick="toggleAlphabetCipher()" title="Show/Hide Cipher Chart">🧩</button>
      </div>
      <div id="alphabetCipher" style="display: none; text-align: center;">
            <div class="cipher-block">
                <p><strong>Plain Alphabet:</strong></p>
                <div class="cipher-row" id="plainAlphabetRow"></div>

                <p><strong>Shifted Alphabet:</strong></p>
                <div class="cipher-row" id="cipherInputRow"></div>
            </div>
        </div>
    </div>

    <div class="shift-info" id="shiftInfo">Keyword: </div>
    <div class="encrypted-word"><div style="font-size: 20px;">Encrypted</div><div class="encryptedword"><strong>XXXXX</strong></div></div>
    <div class="hint" id="hintText" style="display: none;">Hint: Guess the answer</div>

    <div class="input-area">
      <input type="text" placeholder="Type your decrypted word..." id="decryptedInput">
    </div>

    <button class="submit-btn" >SUBMIT</button>

    <div class="result" id="resultArea"></div>

    <div class="progress-area">
      <div class="progress-bar-wrapper">
        <div class="progress-bar-fill" id="progressBar"></div>
      </div>
      <img src="http://localhost/CrackTheCode/Image/flag.png" alt="Finish Flag" class="flag-image">
    </div>

    <div id="gameOverModal">
      <div class="modal-content">
        <h2>💀 Game Over</h2>
        <p>You've lost all your lives! But you can try again and continue from where you left off.</p>
        <button onclick="retryGame()">Retry</button>
      </div>
    </div>

    <div id="successModal">
        <div class="modal-content">
          <h2>🎉 Congratulations!</h2>
          <p id="flagResult"></p>
          <p id="flagDefinition"></p>
          <div class="d-flex gap-5 btnflag">
                <button class=" w-100" onclick="window.location.href='startpage.php'">Home</button>
                <button class=" w-100" onclick="handleContinue()" >Continue</button>
          </div>
        </div>
    </div>

    <div id="exitModal">
      <div class="modal-content">
        <p>Are you sure you want to exit the game?</p>
        <div class="modal-buttons gap-5 d-flex">
          <button id="exitYesBtn" class="modal-btn confirm w-100">Yes</button>
          <button id="exitNoBtn" class="modal-btn cancel w-100">No</button>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<!-- Sounds -->
<audio id="correctSound" src="http://localhost/CrackTheCode/Frontend/mp3/correct.mp3" preload="auto"></audio>
<audio id="wrongSound" src="http://localhost/CrackTheCode/Frontend/mp3/wrong.mp3" preload="auto"></audio>
<audio id="successSound" src="http://localhost/CrackTheCode/Frontend/mp3/success.mp3" preload="auto"></audio>

<!-- JavaScript -->
<script>
  const CURRENT_USER_ID = <?php echo json_encode($_SESSION['iduser']); ?>;
</script>
<script src="http://localhost/CrackTheCode/Frontend/js/keywordgame.js"></script>
</body>
</html>
