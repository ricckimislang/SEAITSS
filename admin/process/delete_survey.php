<?php
include '../includes/dbconn.php';

header('Content-Type: application/json');

if (isset($_POST['survey_id'])) {
    $survey_id = $_POST['survey_id'];

    mysqli_begin_transaction($conn);

    try {
        // Step 1: Get associated response_ids
        $get_response_ids = "SELECT response_id FROM surveyresponses WHERE survey_id = ?";
        $stmt = mysqli_prepare($conn, $get_response_ids);
        if (!$stmt) {
            throw new Exception("Prepare failed: " . mysqli_error($conn));
        }
        mysqli_stmt_bind_param($stmt, "i", $survey_id);
        mysqli_stmt_execute($stmt);
        $response_ids_result = mysqli_stmt_get_result($stmt);
        $response_ids = [];
        while ($row = mysqli_fetch_assoc($response_ids_result)) {
            $response_ids[] = $row['response_id'];
        }
        mysqli_stmt_close($stmt);

        // Step 2: Delete related records in responsedetails table if there are any response_ids
        if (!empty($response_ids)) {
            $response_ids_placeholder = implode(',', array_fill(0, count($response_ids), '?'));
            $delete_response_details = "DELETE FROM responsedetails WHERE response_id IN ($response_ids_placeholder)";
            $stmt = mysqli_prepare($conn, $delete_response_details);
            if (!$stmt) {
                throw new Exception("Prepare failed: " . mysqli_error($conn));
            }
            mysqli_stmt_bind_param($stmt, str_repeat('i', count($response_ids)), ...$response_ids);
            if (!mysqli_stmt_execute($stmt)) {
                throw new Exception("Execute failed: " . mysqli_stmt_error($stmt));
            }
            mysqli_stmt_close($stmt);
        }

        // Step 3: Delete related records in surveyresponses table
        $delete_responses = "DELETE FROM surveyresponses WHERE survey_id = ?";
        $stmt = mysqli_prepare($conn, $delete_responses);
        if (!$stmt) {
            throw new Exception("Prepare failed: " . mysqli_error($conn));
        }
        mysqli_stmt_bind_param($stmt, "i", $survey_id);
        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception("Execute failed: " . mysqli_stmt_error($stmt));
        }
        mysqli_stmt_close($stmt);

        // Step 4: Delete related records in questions table
        $delete_questions = "DELETE FROM surveyquestions WHERE survey_id = ?";
        $stmt = mysqli_prepare($conn, $delete_questions);
        if (!$stmt) {
            throw new Exception("Prepare failed: " . mysqli_error($conn));
        }
        mysqli_stmt_bind_param($stmt, "i", $survey_id);
        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception("Execute failed: " . mysqli_stmt_error($stmt));
        }
        mysqli_stmt_close($stmt);

        // Step 5: Delete the survey
        $delete_survey = "DELETE FROM surveys WHERE survey_id = ?";
        $stmt = mysqli_prepare($conn, $delete_survey);
        if (!$stmt) {
            throw new Exception("Prepare failed: " . mysqli_error($conn));
        }
        mysqli_stmt_bind_param($stmt, "i", $survey_id);
        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception("Execute failed: " . mysqli_stmt_error($stmt));
        }
        mysqli_stmt_close($stmt);

        mysqli_commit($conn);

        echo json_encode(['status' => 'success']);
    } catch (Exception $e) {
        mysqli_rollback($conn);
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Survey ID is missing']);
}
?>
