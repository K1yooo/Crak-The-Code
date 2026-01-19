//password functions
document.addEventListener('DOMContentLoaded', function() {
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('reset_password');

    const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
    const confirmPasswordInput = document.getElementById('reset_confirmPassword');

    

    if (togglePassword) {
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.type === 'password' ? 'text' : 'password';
            passwordInput.type = type;
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    }

    if (toggleConfirmPassword) {
        toggleConfirmPassword.addEventListener('click', function() {
            const type = confirmPasswordInput.type === 'password' ? 'text' : 'password';
            confirmPasswordInput.type = type;
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    }
});

//form
document.addEventListener("DOMContentLoaded", () => {
  const passwordInput = document.getElementById("reset_password");
  const confirmInput = document.getElementById("reset_confirmPassword");
  const requirements = document.querySelector(".req-list");
  const errorMismatch = document.querySelector(".error-message3");
  const form = document.getElementById("resetForm");
  const modal = document.getElementById("successModal");
  const modalBtn = document.getElementById("modalOkBtn");
  const requirementsList = document.querySelectorAll(".listrequirements");

  // Always show requirements on focus
  passwordInput.addEventListener("focus", () => {
    requirements.style.display = "block";
  });

  // Password rules
  const passwordRules = {
    length: /.{8,}/,
    uppercase: /[A-Z]/,
    special: /[!@#$%^&*(),.?":{}|<>]/,
    number: /[0-9]/,
  };

  // Real-time password validation
  passwordInput.addEventListener("input", () => {
    const val = passwordInput.value;
    const checks = [
      passwordRules.length.test(val),
      passwordRules.uppercase.test(val),
      passwordRules.special.test(val),
      passwordRules.number.test(val),
    ];

    requirementsList.forEach((item, index) => {
      item.style.color = checks[index] ? "green" : "red";
    });

    const confirmPassword = confirmInput.value.trim();
    if (confirmPassword && val !== confirmPassword) {
      errorMismatch.style.display = "block";
    } else {
      errorMismatch.style.display = "none";
    }
  });

  confirmInput.addEventListener("input", () => {
    const password = passwordInput.value.trim();
    const confirmPassword = confirmInput.value.trim();

    if (confirmPassword && password !== confirmPassword) {
      errorMismatch.style.display = "block";
      errorMismatch.textContent = "Passwords do not match!";
    } else {
      errorMismatch.style.display = "none";
    }
  });

  // Form 
  form.addEventListener("submit", function (e) {
    e.preventDefault();

    const password = passwordInput.value.trim();
    const confirmPassword = confirmInput.value.trim();

    const isValid = Object.values(passwordRules).every(rule => rule.test(password));

    if (!isValid) {
      requirements.style.display = "block";
      return;
    }

    if (password !== confirmPassword) {
      errorMismatch.style.display = "block";
      return;
    }

    errorMismatch.style.display = "none";

    fetch("http://localhost/CrackTheCode/Backend/resetp_process.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `reset_password=${encodeURIComponent(password)}`
    })
    .then(res => res.text()) 
    .then(text => {
    try {
        const data = JSON.parse(text); 
        console.log("Server response:", data);

        if (data.status === "success") {
        modal.classList.remove("hidden");
        } else {
        console.error("Server error:", data.message || "Unknown error");
        }
    } catch (e) {
        console.error("Invalid JSON response:", text);
    }
    })
    .catch(err => {
    console.error("Reset password error:", err);
    });

  modalBtn.addEventListener("click", () => {
    window.location.href = "login.php";
  });
});
});
