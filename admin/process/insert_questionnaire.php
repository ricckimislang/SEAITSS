<?php
// Insert questionnaire to departments
include("../includes/dbconn.php");

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Prepare response array
    $response = [
        'status' => 'error',
        'message' => '',
        'action' => '' // New field to indicate required action
    ];

    // Get the department ID from the form
    $department_id = $_POST['department_id'];

    // Validate department ID
    if (empty($department_id)) {
        $response['message'] = 'Department ID is required';
        echo json_encode($response);
        exit();
    }

    // Check if a questionnaire already exists for the department
    $checkQuestionnaireStmt = $conn->prepare("SELECT COUNT(*) FROM questions WHERE department_id = ?");
    $checkQuestionnaireStmt->bind_param("i", $department_id);
    $checkQuestionnaireStmt->execute();
    $checkQuestionnaireStmt->bind_result($count);
    $checkQuestionnaireStmt->fetch();
    $checkQuestionnaireStmt->close();

    // Check if overwrite is requested
    $overwrite = isset($_POST['overwrite']) ? $_POST['overwrite'] : false;

    if ($count > 0 && !$overwrite) {
        // Questionnaire exists and no overwrite flag
        $response['status'] = 'confirm';
        $response['action'] = 'overwrite';
        $response['message'] = 'A questionnaire already exists for this department. Do you want to overwrite?';
        echo json_encode($response);
        exit();
    }

    // If overwrite is requested or no existing questionnaire
    if ($overwrite || $count == 0) {
        // Start a transaction
        $conn->begin_transaction();

        try {
            // Delete existing questions for the department if overwriting
            if ($overwrite) {
                $deleteStmt = $conn->prepare("DELETE FROM questions WHERE department_id = ?");
                $deleteStmt->bind_param("i", $department_id);
                $deleteStmt->execute();
                $deleteStmt->close();
            }

            // Prepare to insert questions
            $insertQuestion = "INSERT INTO questions (department_id, question_text, question_type) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($insertQuestion);

            // Loop through each question and insert it
            foreach ($_POST['question_text'] as $index => $text) {
                $question_type = $_POST['question_type'][$index];
                $stmt->bind_param("iss", $department_id, $text, $question_type);
                $stmt->execute();
            }

            // Close the statement
            $stmt->close();

            // Commit the transaction
            $conn->commit();

            // Prepare success response
            $response['status'] = 'success';
            $response['message'] = 'Questionnaire successfully ' . ($overwrite ? 'updated' : 'created') . ' for the department.';
            $response['redirectUrl'] = 'create_questionnaire.php';
        } catch (Exception $e) {
            // Rollback the transaction
            $conn->rollback();

            $response['status'] = 'error';
            $response['message'] = 'Failed to create/update questionnaire: ' . $e->getMessage();
        }
    }

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}