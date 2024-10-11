<?php
session_start();
include '../includes/dbconn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve survey details from the POST request
    $survey_id = $_POST['survey_id'];
    $office = $_POST['office'];
    $title = $_POST['title'];
    $objective = $_POST['objective'];
    $anonymous = $_POST['anonymous'];
    $publish = $_POST['publish'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Update the survey details
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
        // Check if there are edited questions to update
        if (isset($_POST['edited_questions'])) {
            $editedQuestions = json_decode($_POST['edited_questions'], true);

            // Update each question in the database
            foreach ($editedQuestions as $question_id => $question_data) {
                $question_text = $question_data['question_text'];
                $question_type = $question_data['question_type'];

                // Prepare and execute the update for each question
                $questionQuery = "UPDATE surveyquestions 
                                  SET question_text = ?, 
                                  question_type = ? 
                                  WHERE question_id = ? AND survey_id = ?";

                if ($questionStmt = $conn->prepare($questionQuery)) {
                    $questionStmt->bind_param("ssii", $question_text, $question_type, $question_id, $survey_id);
                    $questionStmt->execute();
                    $questionStmt->close();
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Failed to update question']);
                    exit;
                }
            }

            echo json_encode(['status' => 'success', 'message' => 'Survey and questions updated successfully']);
        } else {
            echo json_encode(['status' => 'success', 'message' => 'Survey updated successfully']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update survey']);
    }

    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}

$conn->close();
?>