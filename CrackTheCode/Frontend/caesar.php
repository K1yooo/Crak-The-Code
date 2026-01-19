<?php
    include('../Backend/get_user_info.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Caesar Cipher Game</title>
    <link href="https://fonts.googleapis.com/css2?family=Luckiest+Guy&family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://localhost/CrackTheCode/Frontend/css/caesar.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <img src="http://localhost/CrackTheCode/Image/gametitle.png" alt="Crack the Code!" class="title-image">

    <div class="topic-buttons" id="topicButtons">
        <button onclick="chooseTopic('Animals')">
          <span class="icon animal-feet">🐾</span>
          <span>Animals</span>
        </button>
        <button onclick="chooseTopic('Cybersecurity')">
          <span class="icon">🛡️</span>
          <span>Cybersecurity</span>
        </button>
        <button onclick="chooseTopic('Famous Brands')">
          <span class="icon">🛍️</span>
          <span>Famous Brands</span>
        </button>
        <button onclick="chooseTopic('Human Body Systems')">
          <span class="icon">🧠</span>
          <span>Body Systems</span>
        </button>
        <button onclick="chooseTopic('Mobile Games')">
          <span class="icon animal-feet">📱</span>
          <span>Mobile Games</span>
        </button>
        <button onclick="chooseTopic('Local Wonders')">
          <span class="icon">🏝️</span>
          <span>Local Wonders</span>
        </button>
        <button onclick="chooseTopic('School Subjects')">
          <span class="icon">📖</span>
          <span>School Subjects</span>
        </button>
        <button onclick="chooseTopic('Transportation Modes')">
          <span class="icon">🚌</span>
          <span>Travel Ways</span>
        </button>
    </div>

    <div class="selected-topic" id="selectedTopic">
        <button id="gameNavBtn" class="back-btn" onclick="window.location.href='startpage.php'" title="Back to Start">←</button>
        <span id="topicNameLabel"></span>
    </div>

    <!-- How to Play button -->
    <button id="howToPlayBtn" class="howtoplay-btn" onclick="toggleHowToPlay()" title="How to Play">❓</button>
    <div id="howToPlayModal" class="modal-hidden">
        <div class="modal-content">
            <button class="close-btn" onclick="toggleHowToPlay()">✖</button>
            <h2>🔍 How to Play</h2>
            <p>Welcome to <strong>Crack the Code!</strong> Your goal is to decrypt the encrypted words based on the given <strong>hint</strong> and <strong>cipher type</strong>.</p>
            <br>
            <h3>🛠️ Decrypt Using Caesar Cipher</h3>
            <ol>
            <li>We'll give you a <strong>shift number</strong> (e.g., 3).</li>
            <li>Write down the alphabets:</li>
            <br>
<pre>
Plain Alphabet   : A B C D E F G H I J K L M N O P Q R S T U V W X Y Z
Shifted Alphabet : D E F G H I J K L M N O P Q R S T U V W X Y Z A B C
</pre>
<br>
            <li>Shift each letter <strong>backward</strong> by the shift.</li>
            <p><strong>Example:</strong></p>
            <p>Encrypted: <code>KHOOR</code> ➜ Decryption:</p>
            <ul>
                <li>K → H</li>
                <li>H → E</li>
                <li>O → L</li>
                <li>O → L</li>
                <li>R → O</li>
            </ul>
            <p><strong>Result: HELLO</strong></p>
            </ol>
            <p style="margin-top: 15px;"><strong>🎯 Your Task:</strong> Use the hints and decryption techniques to crack the encrypted words. Each correct answer helps you unlock a flag. You have <strong>2 minutes per question</strong> - if time runs out, you'll lose a life but stay on the same question. Good luck!</p>
        </div>
    </div>

  <!-- Game Box -->
  <div class="game-box" id="gameBox" style="display: none;">
    <div class="game-info-bar">
        <div class="stars" id="starDisplay">❤️❤️❤️</div>
        <button class="hint-btn" onclick="toggleHint()" title="Show Hint">💡</button>
        <div class="timer" id="gameTimer" style="font-size: 1.2em; margin-left: 20px;">⏰ 02:00</div>
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



    <div class="shift-info" id="shiftInfo">Shift: </div>
    <div class="encrypted-word"><div style="font-size: 20px;">Encrypted</div><div class="encryptedword"><strong>XXXXX</strong></div></div>


    <div class="hint" id="hintText" style="display: none;">Hint: A common greeting</div>

    <div class="input-area">
      <input type="text" placeholder="Type your decrypted word..." id="decryptedInput">
    </div>

    <button class="submit-btn">SUBMIT</button>

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

<!-- Sounds -->
<audio id="correctSound" src="http://localhost/CrackTheCode/Frontend/mp3/correct.mp3" preload="auto"></audio>
<audio id="wrongSound" src="http://localhost/CrackTheCode/Frontend/mp3/wrong.mp3" preload="auto"></audio>
<audio id="successSound" src="http://localhost/CrackTheCode/Frontend/mp3/success.mp3" preload="auto"></audio>

<!-- JavaScript -->
<script>
  const CURRENT_USER_ID = <?php echo json_encode($_SESSION['iduser']); ?>;
</script>
<script src="http://localhost/CrackTheCode/Frontend/js/caesargame.js"></script>
</body>
</html>