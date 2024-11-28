<?php
// Insert questionnaire to departments
include("../includes/dbconn.php");

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Prepare response array
    $response = [
        'status' => 'error',
        'message' => ''
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

    if ($count > 0) {
        $response['message'] = 'A questionnaire already exists for this department.';
        echo json_encode($response);
        exit();
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

    // Prepare success response
    $response['status'] = 'success';
    $response['message'] = 'Questionnaire successfully created for the department.';
    $response['redirectUrl'] = 'create_questionnaire.php';

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
