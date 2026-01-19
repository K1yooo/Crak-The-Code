<?php
include('../connect/connection.php');
require 'C:\xampp\htdocs\CrackTheCode\Mail\phpmailer\class.phpmailer.php';
require 'C:\xampp\htdocs\CrackTheCode\Mail\phpmailer\class.smtp.php';

session_start();
header('Content-Type: application/json');

function sendOtp($email, $otp) {
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'aera.montefalco33@gmail.com';
    $mail->Password = 'cmcw pnwe fqxx meih'; // App password
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('aera.montefalco33@gmail.com', 'CRACK THE CODE');
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = 'Your New OTP Code';
    $mail->Body = '
        <div style="background-color: #08136F; padding: 20px; text-align: center; border-radius: 10px; width: 400px; margin: auto; font-family: Arial, sans-serif;">
            <div style="background-color: #fff; padding: 30px; border-radius: 10px;">
                <img src="https://i.pinimg.com/736x/7f/2b/43/7f2b43aefb00790ce00bbba202619259.jpg" alt="Logo Icon" width="170px" style="margin-bottom: 0px; margin-left: 10px;">
                <h2 style="color: #333;">Your new verification code:</h2>
                <h1 style="font-size: 40px; margin: 10px 0; color: #000;">' . $otp . '</h1>
            </div>
        </div>';

    return $mail->send();
}

if (isset($_SESSION['otp_email'])) {
    $email = $_SESSION['otp_email'];
    $otp = rand(100000, 999999);

    if (sendOtp($email, $otp)) {
        $_SESSION['otp'] = $otp;
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error"]);
    }
} else {
    echo json_encode(["status" => "error"]);
}
?>
