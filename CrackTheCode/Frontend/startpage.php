<?php
    include('../Backend/get_user_info.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Crack The Code Menu</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Luckiest+Guy&family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link href="http://localhost/CrackTheCode/Frontend/css/startpage.css" rel="stylesheet">
</head>
<body>
  <!-- Background Light -->
  <div class="background-light"></div>

  <!-- Rotating Circles -->
  <div class="circle-wrapper position-absolute top-50 start-0 translate-middle-y">
    <img src="http://localhost/CrackTheCode/Image/circle.png" alt="Left Decoration" class="rotating-inner rotate-left">
  </div>

  <div class="circle-wrapper position-absolute top-50 end-0 translate-middle-y">
    <img src="http://localhost/CrackTheCode/Image/circle.png" alt="Right Decoration" class="rotating-inner rotate-right">
  </div>

    <!-- Trophy Icon -->
 <a href="#">
  <img src="http://localhost/CrackTheCode/Image/trophy.png" alt="Profile" class="trophy-icon">
</a>

  <!-- Profile Icon -->
 <a href="profile.php">
  <img src="data:image/jpeg;base64,<?= base64_encode($user['profile_img']) ?>" alt="Profile" class="profile-icon">
</a>


  <!-- Content Section -->
  <section class="titlelight">
    <div class="header-image">
      <img src="http://localhost/CrackTheCode/Image/cryptotitle.png" alt="Cryptography Heading">
    </div>

   <div class="button-container">
  <button class="cipher-button" onclick="location.href='caesardef.php'">
    <img src="http://localhost/CrackTheCode/Image/caesar.png" alt="Caesar Cipher"><br>
  </button>

  <button class="cipher-button" onclick="location.href='keyworddef.php'">
    <img src="http://localhost/CrackTheCode/Image/keyword.png" alt="Keyword Cipher"><br>
  </button>
</div>


  <!-- Decorative Stars as Images -->
  <img src="http://localhost/CrackTheCode/Image/star.png" alt="Star" class="decor star1">
  <img src="http://localhost/CrackTheCode/Image/star.png" alt="Star" class="decor star2">

  <!-- Decorative Swirl Strings -->
  <img src="http://localhost/CrackTheCode/Image/string.png" alt="Swirl" class="string string1">
  <img src="http://localhost/CrackTheCode/Image/string.png" alt="Swirl" class="string string2">
  <img src="http://localhost/CrackTheCode/Image/string.png" alt="Swirl" class="string string3">



<div class="modal-overlay" id="leaderboardModal">
  <div class="modal-content">
    <h3>🏆 Leaderboard</h3>

    <div class="leaderboard-scroll">
      <table class="leaderboard-table">
        <thead>
          <tr>
            <th>Rank</th>
            <th>Username</th>
            <th>Wins</th>
          </tr>
        </thead>
        <tbody id="leaderboardBody">
        </tbody>
      </table>
    </div>

    <button onclick="closeModal()" id="closebtn">Close</button>
  </div>
</div>

<script>
  document.querySelector('.trophy-icon').addEventListener('click', function (e) {
    e.preventDefault();

    fetch('http://localhost/CrackTheCode/Backend/get_leaderboard.php')
      .then(res => res.json())
      .then(data => {
        const tbody = document.getElementById('leaderboardBody');
        tbody.innerHTML = ''; 

        data.forEach((player, index) => {
          const tr = document.createElement('tr');

          const rankTd = document.createElement('td');
          rankTd.textContent = index + 1;

          const userTd = document.createElement('td');
          userTd.style.display = 'flex';
          userTd.style.alignItems = 'center';
          userTd.style.justifyContent = 'flex-start';

          const img = document.createElement('img');
          img.src = `data:image/jpeg;base64,${player.profile_img}`;
          img.alt = 'Profile';
          img.style.width = '40px';
          img.style.height = '40px';
          img.style.borderRadius = '50%';
          img.style.marginRight = '8px';
          img.style.objectFit = 'cover';
          img.style.border = '1px solid #ccc';

          const nameSpan = document.createElement('span');
          nameSpan.textContent = player.username;
          nameSpan.style.fontWeight = '500';
          nameSpan.style.fontFamily = 'Poppins, sans-serif';
          nameSpan.style.fontSize = '16px';

          userTd.appendChild(img);
          userTd.appendChild(nameSpan);

          const winsTd = document.createElement('td');
          winsTd.textContent = player.wins;

          tr.appendChild(rankTd);
          tr.appendChild(userTd);
          tr.appendChild(winsTd);

          tbody.appendChild(tr);
        });

        document.getElementById('leaderboardModal').style.display = 'flex';
      })
      .catch(err => {
        console.error('Error loading leaderboard:', err);
        alert('Could not load leaderboard.');
      });
  });

  function closeModal() {
    document.getElementById('leaderboardModal').style.display = 'none';
  }
</script>


</body>
</html>
