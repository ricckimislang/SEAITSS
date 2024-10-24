<?php
session_start();
include '../includes/dbconn.php';

$response = ['status' => 'error', 'message' => 'An error occurred']; // Default response

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $survey_id = $_POST['survey_id'];
    $eAddress = $_POST['eAddress'];
    $answers = $_POST['answer'];

    ksort($answers); // Sort answers by keys (question IDs)

    // Step 1: Insert into surveyresponses
    $survrespo = "INSERT INTO surveyresponses (survey_id, student_id, submitted_at) VALUES (?, ?, NOW())";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $survrespo)) {
        $response['message'] = 'Failed to prepare statement for surveyresponses';
        respondAndExit($response);
    }

    mysqli_stmt_bind_param($stmt, "is", $survey_id, $eAddress);
    if (!mysqli_stmt_execute($stmt)) {
        $response['message'] = 'Failed to execute statement for surveyresponses';
        respondAndExit($response);
    }

    // Step 2: Get last inserted response_id
    $response_id = mysqli_insert_id($conn);

    // Step 3: Loop through answers and insert into responsedetails
    foreach ($answers as $question_id => $answer) {
        // Skip empty answers
        if (empty($answer)) {
            continue;
        }

        // Get question type
        $query = "SELECT question_type FROM surveyquestions WHERE question_id = ?";
        if (!mysqli_stmt_prepare($stmt, $query)) {
            $response['message'] = 'Failed to prepare statement for question type';
            respondAndExit($response);
        }

        mysqli_stmt_bind_param($stmt, "i", $question_id);
        if (!mysqli_stmt_execute($stmt)) {
            $response['message'] = 'Failed to execute statement for question type';
            respondAndExit($response);
        }

        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        $question_type = $row['question_type'];

        // Insert answer into responsedetails
        if ($question_type == 'input') {
            $insertDetail = "INSERT INTO responsedetails (response_id, question_id, response_text) VALUES (?, ?, ?)";
            $param_type = "iis";  // response_id (integer), question_id (integer), response_text (string)
        } elseif ($question_type == 'rating') {
            $insertDetail = "INSERT INTO responsedetails (response_id, question_id, rating) VALUES (?, ?, ?)";
            $param_type = "iii";  // response_id (integer), question_id (integer), rating (integer)
        }

        if (!mysqli_stmt_prepare($stmt, $insertDetail)) {
            $response['message'] = 'Failed to prepare statement for responsedetails';
            respondAndExit($response);
        }

        mysqli_stmt_bind_param($stmt, $param_type, $response_id, $question_id, $answer);
        if (!mysqli_stmt_execute($stmt)) {
            $response['message'] = 'Failed to insert response details';
            respondAndExit($response);
        }
    }

    // If everything went well, return success
    $response['status'] = 'success';
    $response['message'] = 'Survey submitted successfully!';
    respondAndExit($response);
}

// Helper function for sending JSON response and exiting
function respondAndExit($response)
{
    echo json_encode($response);
    exit;
}
?>