<?php
include '../includes/dbconn.php';

if (isset($_POST['department_update_id']) && isset($_POST['department_update_name'])) {
    $departmentId = trim($_POST['department_update_id']);
    $officeName = trim($_POST['department_update_name']);

    if (empty($departmentId) || empty($officeName)) {
        echo json_encode(['status' => 'error', 'message' => 'Department ID and office name cannot be empty']);
        exit();
    }

    // Check for duplication (excluding the current department)
    $checkQuery = "SELECT * FROM department WHERE office_name = ? AND department_id != ?";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bind_param("si", $officeName, $departmentId);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        // Duplicate found
        echo json_encode(['status' => 'duplicate', 'message' => 'Department name already exists']);
        $checkStmt->close();
        $conn->close();
        exit();
    }

    // Prepare the UPDATE query
    $updateQuery = "UPDATE department SET office_name = ? WHERE department_id = ?";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bind_param("si", $officeName, $departmentId);

    if ($updateStmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Department updated successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update department']);
    }

    $updateStmt->close();
    $checkStmt->close(); // Close check statement
    $conn->close();
}
