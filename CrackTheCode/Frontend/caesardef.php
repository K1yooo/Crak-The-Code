<?php
    include('../Backend/get_user_info.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Caesar Game</title>
    <link href="https://fonts.googleapis.com/css2?family=Itim&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://localhost/CrackTheCode/Frontend/css/caesardef.css" rel="stylesheet">

</head>
<body>
   <button class="button back-arrow" onclick="window.location.href='startpage.php'">←</button>

    <section class="main-content position-relative overflow-hidden">
        <div class="circle-wrapper position-absolute top-50 end-0 translate-middle-y">
            <img src="http://localhost/CrackTheCode/Image/circle.png" alt="Right Decoration" class="rotating-inner rotate-right">
        </div>
        <div class="spring">
            <img src="http://localhost/CrackTheCode/Image/string.png" alt="Right Decoration" class="spring-image">
        </div>
        <div class="ekis">
            <img src="http://localhost/CrackTheCode/Image/ekis.png" alt="ekis" class="ekis-image">
        </div>
        <div class="ekis1">
            <img src="http://localhost/CrackTheCode/Image/ekis.png" alt="ekis" class="ekis-image1">
        </div>
        <div class="star">
            <img src="http://localhost/CrackTheCode/Image/star.png" alt="" class="star-image">
        </div>
        <div class="star1">
            <img src="http://localhost/CrackTheCode/Image/star.png" alt="" class="star-image1">
        </div>
        <div class="main d-flex">
            <div class="left-content bg-light p-5" style="width: 43%; margin: auto; z-index: 1000;">
                <br><br><br>
                <p>The Caesar Cipher is a type of substitution cipher and is one of the oldest and most well-known encryption techniques. It was named after Julius Caesar, who is said to have used this method to send secret military messages to his generals. The technique is simple but historically significant, laying the groundwork for more complex encryption systems used in modern cryptography.</p>
            </div>
            <div class="right-content d-flex justify-content-center align-items-center flex-column">
                <img src="http://localhost/CrackTheCode/Image/caesar.png" alt="Crack The Code" class="img-fluid" style="height: 40vh; z-index: 1000; margin-right: 50px;">
               <button class="start-button" style="z-index: 1000; margin-right: 50px;" onclick="window.location.href='caesar.php'">NEXT</button>

            </div>
        </div>
    </section>
</body>

</html>