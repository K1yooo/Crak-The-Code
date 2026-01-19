<?php
    include('../Backend/get_user_info.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile</title>
    <link href="https://fonts.googleapis.com/css2?family=Luckiest+Guy&family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Itim&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://localhost/CrackTheCode/Frontend/css/profile.css" rel="stylesheet">
</head>
<body>

  <div class="container">
    <div class="top-buttons">
      <button class="go-back" onclick="window.location.href='startpage.php'">Back to Menu</button>
      <form action="http://localhost/CrackTheCode/Backend/logout.php" method="post">
        <button type="submit" class="logout">Logout</button>
      </form>
    </div>


    <div class="profile-header">
      <div class="profile-left">
        <form id="profileForm" method="post" enctype="multipart/form-data" action="http://localhost/CrackTheCode/Backend/update_profile_image.php">
          <input type="file" id="profileInput" name="profile_img" accept="image/*" style="display:none">
          <img id="profileImage" src="data:image/jpeg;base64,<?= base64_encode($user['profile_img']) ?>" alt="Player" class="profile-img" onclick="document.getElementById('profileInput').click();">
        </form>
        <div>
          <div class="player-name"><?= htmlspecialchars($user['username']) ?></div>
          <div style="font-size: 16px; color: #ccc;">Player since: <?= (new DateTime($user['created_at']))->format('F Y') ?></div>
        </div>
      </div>
    </div>

    <div class="stats">
      <div class="stat-box">
        <div class="stat-title">Total Games Played</div>
        <div class="stat-value"><?= $achievements['total_games'] ?></div>
      </div>
      <div class="stat-box">
        <div class="stat-title">Total Wins</div>
        <div class="stat-value"><?= $achievements['total_wins'] ?></div>
      </div>
      <div class="stat-box">
        <div class="stat-title">Best Cipher</div>
        <div class="stat-value"><?= htmlspecialchars($achievements['best_cipher']) ?></div>
      </div>
      <div class="stat-box">
        <div class="stat-title">Last Played</div>
        <div class="stat-value"> <?= $achievements['last_played'] ?></div>
      </div>
    </div>
  </div>
<script>
document.getElementById('profileInput').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (!file) return;

    const formData = new FormData();
    formData.append('profile_img', file);

    fetch('http://localhost/CrackTheCode/Backend/update_profile_image.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const img = document.getElementById('profileImage');
            const reader = new FileReader();
            reader.onload = function(e) {
                img.src = e.target.result;
            };
            reader.readAsDataURL(file);
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(() => {
        alert('Error uploading profile image.');
    });
});
</script>

</body>
</html>
