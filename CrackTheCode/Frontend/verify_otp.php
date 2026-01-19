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
            <h2 class="signup-title">CODE VERIFICATION</h2>
            <form id="otpForm" class="signup-form" method="post">
                <div class="form-group">
                    <label for="OTP">Enter Code</label>
                    <input type="number" id="otp_email" name="otp_email" class="form-control" maxlength="6">
                    <div class="form-text text-danger error-message1">Wrong Code</div>
                </div>
                
                <button type="submit" class="login-btn">Verify</button>
            </form>
            <div class="resend-message mt-2 text-success" style="display: none;"></div>
            <p class="signin-text">Didn't get the email? <a href="#" class="signin-link" id="resend-otp">Resend code</a></p>
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
    <script src="http://localhost/CrackTheCode/Frontend/js/verifyotp.js"></script>
</body>
</html>