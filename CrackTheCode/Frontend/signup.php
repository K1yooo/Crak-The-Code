<?php
    include('../Backend/signup_process.php');
?>
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
    <link href="http://localhost/CrackTheCode/Frontend/css/success_modal.css" rel="stylesheet">

    </head>
<body>

    <div class="signup-page-container">
        <div class="signup-panel">
            <h2 class="signup-title">SIGN UP</h2>
            <form id="signupForm" class="signup-form" method="post">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="signup_username" name="signup_username" class="form-control" required>
                    <div class="form-text text-danger error-message1">Username already exist</div>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="signup_email" name="signup_email" class="form-control" required>
                    <div class="form-text text-danger error-message2">Email already exist</div>
                </div>
                <label for="password">Password</label>
                <div class="form-group">
                    <input type="password" class="form-control" id="signup_password" name="signup_password">
                    <i class="fa-solid fa-eye" id="togglePassword" style="cursor: pointer; position: absolute; right: 10px; top: 50%; transform: translateY(-50%); font-size: 1.2rem;"></i>
                 </div>
                <div class="req-list">
                    <div class="form-text">Password must contain:</div>
                        <ul class="list-unstyled requirements">
                            <li class="listrequirements"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill me-1" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-.05z"/></svg>At least 8 characters</li>
                            <li class="listrequirements"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill me-1" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-.05z"/></svg>At least 1 uppercase letter (A-Z)</li>
                            <li class="listrequirements"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill me-1" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-.05z"/></svg>At least 1 special character (!, @, #, $, %)</li>
                            <li class="listrequirements"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill me-1" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-.05z"/></svg>At least 1 number</li>
                    </ul>
                </div>

                <label>Confirm Password</label>
                <div class="form-group">
                    <input type="password" class="form-control" id="signup_confirmPassword" id="signup_confirmPassword">
                    <i class="fa-solid fa-eye" id="toggleConfirmPassword" style="cursor: pointer; position: absolute; right: 10px; top: 50%; transform: translateY(-50%); font-size: 1.2rem;"></i>
                </div>
                <div class="form-text text-danger error-message3">Password do not match!</div>

                <button type="submit" class="register-btn">Register</button>
            </form>
            <p class="signin-text">Already have an account? <a href="login.php" class="signin-link">Sign In</a></p>
        </div>

        <div class="crack-the-code-branding" style="z-index: 1000;">
            <img src="http://localhost/CrackTheCode/Image/ctc.png" alt="CRACK THE CODE" class="crack-the-code-img">
        </div>

        <div class="circle-wrapper position-absolute top-50 end-0 translate-middle-y">
            <img src="http://localhost/CrackTheCode/Image/circle.png" alt="Right Decoration" class="rotating-inner rotate-right">
        </div>

        <div class="circle-wrapper position-absolute end-0 translate-middle-y" style="z-index: -999;">
            <img src="http://localhost/CrackTheCode/Image/bglight.png" alt="Right Decoration" class="lightbg" style="width: 100%; height: auto; margin-left: 500px; z-index: -5;">
        </div>
    </div>

    
    <!-- Success Modal -->
    <div id="successModalSignup" class="custom-modal-backdrop hidden">
        <div class="custom-modal-box">
            <p id="modalMessage">Registration successful!</p>
            <button id="modalOkBtn" class="btn btn-primary">OK</button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="http://localhost/CrackTheCode/Frontend/js/signup.js"></script>
</body>
</html>