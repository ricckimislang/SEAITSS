<?php
include '../includes/dbconn.php';

if (isset($_POST['eAddress'])) {
    $eAddress = $_POST['eAddress'];

    $query = "INSERT INTO surveyresponses (respondent_email) VALUES (?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $eAddress);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $response = ['status' => 'success', 'message' => 'Email address recorded successfully!'];
    } else {
        $response = ['status' => 'error', 'message' => 'Failed to record email address. Please try again.'];
    }

    $stmt->close();
    $conn->close();

    echo json_encode($response);
    exit;
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
