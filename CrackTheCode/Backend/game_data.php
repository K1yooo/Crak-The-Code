<?php
session_start();
header('Content-Type: application/json');
include('../connect/connection.php');

$input = json_decode(file_get_contents("php://input"), true);
$topicName = $input['topic'] ?? null;

if (!$topicName) {
    echo json_encode(["error" => "No topic specified."]);
    exit;
}

$topicQuery = "
    SELECT t.topic_id, t.topic_name, c.name AS cipher_name
    FROM cc_topics t
    JOIN cc_ciphers c ON t.cipher_id = c.cipher_id
    WHERE t.topic_name = ?
";
$stmt = $conn->prepare($topicQuery);
$stmt->bind_param("s", $topicName);
$stmt->execute();
$topicResult = $stmt->get_result()->fetch_assoc();

if (!$topicResult) {
    echo json_encode(["error" => "Topic not found."]);
    exit;
}

$topicId = $topicResult['topic_id'];

$setQuery = "
    SELECT set_id, set_name, caesar_shift, keyword_key
    FROM cc_sets
    WHERE topic_id = ?
    ORDER BY RAND()
";
$stmt = $conn->prepare($setQuery);
$stmt->bind_param("i", $topicId);
$stmt->execute();
$sets = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

$fullData = [];
foreach ($sets as $set) {
    $setId = $set['set_id'];

    $questionQuery = "
        SELECT question_id, question_number, plaintext, ciphertext, hint
        FROM cc_questions
        WHERE set_id = ?
        ORDER BY question_number
    ";
    $stmt = $conn->prepare($questionQuery);
    $stmt->bind_param("i", $setId);
    $stmt->execute();
    $questions = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

     if (count($questions) > 0) {
        $fullData[] = [
            'set_id' => $set['set_id'],
            'set_name' => $set['set_name'],
            'caesar_shift' => $set['caesar_shift'],
            'keyword_key' => $set['keyword_key'],
            'questions' => $questions
        ];
     }
}

if (empty($fullData)) {
    echo json_encode(["error" => "No sets with questions found."]);
    exit;
}

echo json_encode([
    'topic' => $topicResult,
    'sets' => $fullData
]);


$conn->close();
?>
