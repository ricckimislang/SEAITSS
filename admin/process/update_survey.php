<?php
session_start();
include '../includes/dbconn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $survey_id = $_POST['survey_id'];
    $office = $_POST['office'];
    $title = $_POST['title'];
    $objective = $_POST['objective'];
    $anonymous = $_POST['anonymous'];
    $publish = $_POST['publish'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    $query = "UPDATE surveys SET 
              office = ?, 
              title = ?, 
              objective = ?, 
              is_anonymous = ?, 
              is_published = ?, 
              start_date = ?, 
              end_date = ? 
              WHERE survey_id = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssiissi", $office, $title, $objective, $anonymous, $publish, $start_date, $end_date, $survey_id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Survey updated successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update survey']);
    }

    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}

$conn->close();
?>