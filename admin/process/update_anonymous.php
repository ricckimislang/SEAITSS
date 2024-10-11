<?php
include '../includes/dbconn.php';

$survey_id = $_GET['survey_id'];
$is_anonymous = $_GET['is_anonymous'];

// Prepare and execute the update statement
$sql = "UPDATE surveys SET is_anonymous = ? WHERE survey_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $is_anonymous, $survey_id);
$stmt->execute();
$stmt->close();

// Return the updated anonymous status
echo json_encode(['status' => 'success', 'is_anonymous' => $is_anonymous]);
