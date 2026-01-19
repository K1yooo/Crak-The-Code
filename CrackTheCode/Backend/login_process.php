<?php
include('../connect/connection.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['login_email']);
    $password = $_POST['login_password'];

    $stmt = $conn->prepare("SELECT iduser, password FROM cc_user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 0) {
        echo json_encode(["status" => "error", "field" => "email"]);
        exit;
    }

    $stmt->bind_result($user_id, $hashedPassword);
    $stmt->fetch();

    if (!password_verify($password, $hashedPassword)) {
        echo json_encode(["status" => "error", "field" => "password"]);
        exit;
    }

    $_SESSION['iduser'] = $user_id;

    echo json_encode(["status" => "success", "redirect" => "startpage.php"]);
    exit;
}
?>
