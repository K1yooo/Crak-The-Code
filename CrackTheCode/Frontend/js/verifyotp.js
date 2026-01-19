document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("otpForm");
  const otpInput = document.getElementById("otp_email");
  const errorMessage = document.querySelector(".error-message1");
  const resendBtn = document.getElementById("resend-otp");
  const messageDiv = document.querySelector(".resend-message");

  otpInput.addEventListener("input", () => {
  if (otpInput.value.length > 6) {
    otpInput.value = otpInput.value.slice(0, 6);
  }
});

  form.addEventListener("submit", function (e) {
    e.preventDefault();
    errorMessage.style.display = "none";

    const otp = otpInput.value.trim();

    fetch("http://localhost/CrackTheCode/Backend/verifyotp_process.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: `otp=${encodeURIComponent(otp)}`
    })
      .then(res => res.json())
      .then(data => {
        if (data.status === "success") {
          window.location.href = "http://localhost/CrackTheCode/Frontend/reset_password.php";
        } else {
          errorMessage.style.display = "block";
        }
      })
      .catch(() => {
        errorMessage.style.display = "block";
      });
  });

  resendBtn.addEventListener("click", function (e) {
    e.preventDefault();
    messageDiv.style.display = "none";

    fetch("http://localhost/CrackTheCode/Backend/resend_process.php", {
      method: "POST"
    })
      .then(res => res.json())
      .then(data => {
        if (data.status === "success") {
          messageDiv.textContent = "A new code has been sent to your email.";
          messageDiv.classList.replace("text-danger", "text-success");
        } else {
          messageDiv.textContent = "Failed to resend code. Try again later.";
          messageDiv.classList.replace("text-success", "text-danger");
        }
        messageDiv.style.display = "block";
      })
      .catch(() => {
        messageDiv.textContent = "Something went wrong.";
        messageDiv.classList.replace("text-success", "text-danger");
        messageDiv.style.display = "block";
      });
  });
});
