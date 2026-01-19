document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("forgotForm");
    const emailInput = document.getElementById("forgot_email");
    const errorMessage1 = document.querySelector(".error-message1");
    const sendButton = document.getElementById("btn-send"); 

    form.addEventListener("submit", function (e) {
        e.preventDefault();

        errorMessage1.style.display = "none";

        const email = emailInput.value;

        sendButton.disabled = true;
        sendButton.textContent = "Sending...";

        fetch("http://localhost/CrackTheCode/Backend/forgotp_process.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            body: `forgot_email=${encodeURIComponent(email)}`
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === "error" && data.field === "email") {
                errorMessage1.style.display = "block";
                sendButton.disabled = false;
                sendButton.textContent = "Send";
            } else if (data.status === "success") {
                sendButton.textContent = "Sent ✔";

                setTimeout(() => {
                    window.location.href = `verify_otp.php?email=${encodeURIComponent(email)}`;
                }, 2000);
            }
        })
        .catch(err => {
            console.error("Request failed", err);
            sendButton.disabled = false;
            sendButton.textContent = "Send";
        });
    });
});
