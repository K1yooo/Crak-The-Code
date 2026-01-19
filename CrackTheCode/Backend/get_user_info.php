<?php
session_start();
include('../connect/connection.php');

if (!isset($_SESSION['iduser'])) {
    header("Location: login.php"); 
    exit();
}

$iduser = $_SESSION['iduser'];

$sql = "SELECT * FROM cc_user WHERE iduser = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $iduser);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
} else {
    echo "User not found.";
    exit(); 
}

$ach_sql = "
    SELECT 
        SUM(ua.completion_count) AS total_games,
        SUM(ua.win_count) AS total_wins,
        MAX(ua.last_played) AS last_played
    FROM cc_user_achievements ua
    WHERE ua.user_id = ?
";
$ach_stmt = $conn->prepare($ach_sql);
$ach_stmt->bind_param("i", $iduser);
$ach_stmt->execute();
$ach_result = $ach_stmt->get_result();
$ach_data = $ach_result->fetch_assoc();

$cipher_sql = "
    SELECT c.name, SUM(ua.completion_count) AS games_played
    FROM cc_user_achievements ua
    JOIN cc_sets s ON ua.set_id = s.set_id
    JOIN cc_topics t ON s.topic_id = t.topic_id
    JOIN cc_ciphers c ON t.cipher_id = c.cipher_id
    WHERE ua.user_id = ?
    GROUP BY c.name
    ORDER BY games_played DESC
    LIMIT 1
";
$cipher_stmt = $conn->prepare($cipher_sql);
$cipher_stmt->bind_param("i", $iduser);
$cipher_stmt->execute();
$cipher_result = $cipher_stmt->get_result();

if ($cipher_result->num_rows > 0) {
    $cipher_data = $cipher_result->fetch_assoc();
    $best_cipher = $cipher_data['name'];
} else {
    $best_cipher = "N/A";
}

$achievements = [
    'total_games' => $ach_data['total_games'] ?? 0,
    'total_wins' => $ach_data['total_wins'] ?? 0,
    'best_cipher' => $best_cipher,
    'last_played' => $ach_data['last_played'] 
        ? date("F j, Y", strtotime($ach_data['last_played'])) 
        : 'N/A'
];
?>

