<?php
session_start();
include('../connect/connection.php');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_img']) && isset($_SESSION['iduser'])) {
    $iduser = $_SESSION['iduser'];

    if ($_FILES['profile_img']['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(['success' => false, 'message' => 'Upload error']);
        exit();
    }

    $fileType = $_FILES['profile_img']['type'];
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($fileType, $allowedTypes)) {
        echo json_encode(['success' => false, 'message' => 'Invalid file type']);
        exit();
    }

    $imageData = file_get_contents($_FILES['profile_img']['tmp_name']);

    $stmt = $conn->prepare("UPDATE cc_user SET profile_img = ? WHERE iduser = ?");
    $stmt->bind_param("si", $imageData, $iduser);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database update failed']);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Unauthorized or invalid request']);
}
?>
