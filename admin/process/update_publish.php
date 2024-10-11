<?php
include '../includes/dbconn.php';

$survey_id = $_GET['survey_id'];
$is_published = $_GET['is_published'];

// Prepare and execute the update statement
$sql = "UPDATE surveys SET is_published = ? WHERE survey_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $is_published, $survey_id);
$stmt->execute();
$stmt->close();

// Return the updated anonymous status
echo json_encode(['status' => 'success', 'is_published' => $is_published]);
