<?php
include('../connect/connection.php');

header('Content-Type: application/json');

$query = "
    SELECT 
        u.iduser,
        u.username,
        u.profile_img,
        SUM(a.win_count) AS total_wins
    FROM 
        cc_user u
    INNER JOIN 
        cc_user_achievements a ON u.iduser = a.user_id
    GROUP BY 
        u.iduser
    HAVING 
        total_wins > 0
    ORDER BY 
        total_wins DESC
    LIMIT 50
";

$result = $conn->query($query);

$leaderboard = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $leaderboard[] = [
            'id' => $row['iduser'],
            'username' => $row['username'],
            'profile_img' => base64_encode($row['profile_img']),
            'wins' => (int)$row['total_wins']
        ];
    }
}

echo json_encode($leaderboard);
$conn->close();
