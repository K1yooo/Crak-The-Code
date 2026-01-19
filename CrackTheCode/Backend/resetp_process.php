<?php
session_start();
header('Content-Type: application/json');

include('../connect/connection.php'); 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $password = $_POST['reset_password'] ?? '';
    $email = $_SESSION['otp_email'] ?? null;

    if (!$email) {
        echo json_encode(["status" => "error", "message" => "Email not found in session"]);
        exit;
    }

    if (!empty($password)) {
        $hashed = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("UPDATE cc_user SET password = ? WHERE email = ?");
        if ($stmt) {
            $stmt->bind_param("ss", $hashed, $email);
            $stmt->execute();
            $stmt->close();
            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Database error"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Password missing"]);
    }
    exit;
}

echo json_encode(["status" => "error", "message" => "Invalid request"]);
exit;
