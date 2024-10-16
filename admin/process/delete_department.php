<?php
include '../includes/dbconn.php';

if (isset($_POST['department_delete_id'])) {
    $departmentId = $_POST['department_delete_id'];

    if (empty($departmentId)) {
        echo json_encode(['status' => 'error', 'message' => 'Department ID cannot be empty']);
        exit();
    }

    // Prepare the DELETE query
    $delQuery = "DELETE FROM department WHERE department_id = ?";
    $delStmt = $conn->prepare($delQuery);
    $delStmt->bind_param("i", $departmentId);

    if ($delStmt->execute()) {
        // Check if any rows were affected
        if ($delStmt->affected_rows > 0) {
            echo json_encode(['status' => 'success', 'message' => 'Department deleted successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No department found with the provided ID']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete department']);
    }

    $delStmt->close();
    $conn->close();
}
?>