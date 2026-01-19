<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crack The Code</title>
    <link href="https://fonts.googleapis.com/css2?family=Itim&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://localhost/CrackTheCode/Frontend/css/homepage.css" rel="stylesheet">
    
</head>
<body>
    <section class="main-content position-relative overflow-hidden">
    <div class="circle-wrapper position-absolute top-50 start-0 translate-middle-y">
        <img src="http://localhost/CrackTheCode/Image/circle.png" alt="Left Decoration" class="rotating-inner rotate-left">
    </div>

    <div class="circle-wrapper position-absolute top-50 end-0 translate-middle-y">
        <img src="http://localhost/CrackTheCode/Image/circle.png" alt="Right Decoration" class="rotating-inner rotate-right">
    </div>
        <div class="titlelight text-center">
            <div class="d-flex justify-content-center align-items-center flex-column">
                <img src="http://localhost/CrackTheCode/Image/HomepageTitle.png" alt="Crack The Code" class="img-fluid" style="height: 75vh; z-index: 1000;">
                <img src="http://localhost/CrackTheCode/Image/smallDesign.png" alt="Design Overlay" class="overlay-design">                
                <button id="start-btn" style="z-index: 1000;" class="start-button"  onclick="window.location.href='signup.php'">START</button>
            </div>
        </div>
    </section>
</body>

</html>