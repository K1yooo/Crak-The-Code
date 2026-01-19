<?php
session_start();
include('../connect/connection.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['signup_username']);
    $email = trim($_POST['signup_email']);
    $password = $_POST['signup_password'];
    $confirmPassword = $_POST['signup_confirmPassword'];

    if (empty($username) || empty($email) || empty($password) || empty($confirmPassword)) {
        echo json_encode(["status" => "error", "field" => "missing_fields"]);
        exit;
    }

    $checkUsername = $conn->prepare("SELECT iduser FROM cc_user WHERE username = ?");
    $checkUsername->bind_param("s", $username);
    $checkUsername->execute();
    $checkUsername->store_result();

    if ($checkUsername->num_rows > 0) {
        echo json_encode(["status" => "error", "field" => "username"]);
        exit;
    }

    $checkEmail = $conn->prepare("SELECT iduser FROM cc_user WHERE email = ?");
    $checkEmail->bind_param("s", $email);
    $checkEmail->execute();
    $checkEmail->store_result();

    if ($checkEmail->num_rows > 0) {
        echo json_encode(["status" => "error", "field" => "email"]);
        exit;
    }

    if ($password !== $confirmPassword) {
        echo json_encode(["status" => "error", "field" => "password_mismatch"]);
        exit;
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $defaultProfilePath = 'C:\xampp\htdocs\CrackTheCode\Image\default_profile.jpg';
    $profileImage = null;
    if (file_exists($defaultProfilePath)) {
        $profileImage = file_get_contents($defaultProfilePath);
    }

    $stmt = $conn->prepare("INSERT INTO cc_user (username, email, password, profile_img, created_at, last_updated)
                            VALUES (?, ?, ?, ?, NOW(), NOW())");
    $stmt->bind_param("ssss", $username, $email, $hashedPassword, $profileImage);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "field" => "server"]);
    }

    $stmt->close();
    $checkUsername->close();
    $checkEmail->close();
    $conn->close();
}
?>
