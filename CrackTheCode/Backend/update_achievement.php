<?php
include('../connect/connection.php');

$_SESSION['iduser'] = $row['iduser'];


$user_id = (int) $_POST['user_id'];
$set_id = (int) $_POST['set_id'];
$completed = (int) $_POST['completed']; 
$won = (int) $_POST['won'];            

$sql_check = "SELECT id FROM cc_user_achievements WHERE user_id = ? AND set_id = ?";
$stmt = $conn->prepare($sql_check);
$stmt->bind_param("ii", $user_id, $set_id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $sql_update = "
        UPDATE cc_user_achievements
        SET 
            completion_count = completion_count + ?,
            win_count = win_count + ?,
            total_games = total_games + 1,
            last_played = CURRENT_TIMESTAMP
        WHERE user_id = ? AND set_id = ?
    ";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("iiii", $completed, $won, $user_id, $set_id);
    $stmt_update->execute();
    $stmt_update->close();
} else {
    $sql_insert = "
        INSERT INTO cc_user_achievements (user_id, set_id, completion_count, win_count, total_games)
        VALUES (?, ?, ?, ?, 1)
    ";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("iiii", $user_id, $set_id, $completed, $won);
    $stmt_insert->execute();
    $stmt_insert->close();
}

$stmt->close();
$conn->close();

echo "success";
?>
