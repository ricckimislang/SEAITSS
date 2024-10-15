<?php
include '../includes/dbconn.php';

if (isset($_POST['departmentName'])) {
    $departmentName = $_POST['departmentName'];

    // Check if the department already exists
    $checkQuery = "SELECT * FROM department WHERE office_name = ?";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bind_param("s", $departmentName);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        // Department already exists, return an error
        echo json_encode(['status' => 'duplicate', 'message' => 'Department already exists']);
    } else {
        // If no duplicates, insert the new department
        $query = "INSERT INTO department (office_name, created_at) VALUES (?, NOW())";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $departmentName);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo json_encode(['status' => 'success', 'message' => 'Department added successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to add Department']);
        }

        $stmt->close();
    }

    // Close the check statement and connection
    $checkStmt->close();
    $conn->close();

} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>