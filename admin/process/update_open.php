<?php
include '../includes/dbconn.php';

$survey_id = $_GET['survey_id'];
$is_closed = $_GET['is_closed'];

// Prepare and execute the update statement
$sql = "UPDATE surveys SET is_complete = ? WHERE survey_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $is_closed, $survey_id);
$stmt->execute();
$stmt->close();

// Return the updated closure status
echo json_encode(['status' => 'success', 'is_closed' => $is_closed]);
?>
