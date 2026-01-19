<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crack the Code</title>
    <link href="https://fonts.googleapis.com/css2?family=Itim&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://localhost/CrackTheCode/Frontend/css/signup.css" rel="stylesheet">
    </head>
<body>

    <div class="signup-page-container">
        <div class="signup-panel">
            <h2 class="signup-title">FORGOT PASSWORD</h2>
            <form id="forgotForm" class="signup-form" method="post">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="forgot_email" name="forgot_email" class="form-control" required>
                    <div class="form-text text-danger error-message1">Email doesn't exist</div>
                </div>                
                 <div class="d-flex gap-3">
                    <button type="back" id="btn-back" class="login-btn" onclick="window.location.href='login.php'">Back</button>
                    <button type="submit" id="btn-send" class="login-btn">Send</button>
                </div>
            </form>
        </div>

        <div class="circle-wrapper position-absolute top-50 end-0 translate-middle-y">
            <img src="http://localhost/CrackTheCode/Image/circle.png" alt="Right Decoration" class="rotating-inner rotate-right">
        </div>

        <div class="circle-wrapper position-absolute end-0 translate-middle-y" style="z-index: -5;">
            <img src="http://localhost/CrackTheCode/Image/bglight.png" alt="Right Decoration" class="lightbg" style="width: 100%; height: auto; margin-left: 500px; z-index: -5;">
        </div>

        <div class="crack-the-code-branding" style="z-index: 1000;">
            <img src="http://localhost/CrackTheCode/Image/ctc.png" alt="CRACK THE CODE" class="crack-the-code-img">
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="http://localhost/CrackTheCode/Frontend/js/forgotpass.js"></script>
</body>
</html>