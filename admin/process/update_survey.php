<?php
session_start();
include '../includes/dbconn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate required fields
    if (empty($_POST['survey_id']) || empty($_POST['office']) || empty($_POST['title']) || empty($_POST['objective']) || empty($_POST['publish']) || empty($_POST['start_date']) || empty($_POST['end_date'])) {
        echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
        exit;
    }

    // Retrieve survey details from the POST request
    $survey_id = $_POST['survey_id'];
    $office = $_POST['office'];
    $title = $_POST['title'];
    $objective = $_POST['objective'];
    $anonymous = 1; // Assuming anonymous is always set to 1
    $publish = $_POST['publish'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Prepare the update statement
    $query = "UPDATE surveys SET 
              office = ?, 
              title = ?, 
              objective = ?, 
              is_anonymous = ?, 
              is_published = ?, 
              start_date = ?, 
              end_date = ? 
              WHERE survey_id = ?";

    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("sssiissi", $office, $title, $objective, $anonymous, $publish, $start_date, $end_date, $survey_id);

        // Execute the statement
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Survey updated successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update survey: ' . $stmt->error]);
        }

        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to prepare SQL statement: ' . $conn->error]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}

$conn->close();
?>