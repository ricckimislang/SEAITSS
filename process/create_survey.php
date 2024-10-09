<?php
session_start();
include '../includes/dbconn.php';

if (
    isset(
        $_POST['office'],
        $_POST['survey_title'],
        $_POST['objective'],
        $_POST['anonymous'],
        $_POST['publish'],
        $_POST['start_date'],
        $_POST['end_date'],
        $_POST['questions'] // Added to handle the questions array
    )
) {
    // Assign variables
    $office = $_POST['office'];
    $survey_title = $_POST['survey_title'];
    $objective = $_POST['objective'];
    $anonymous = $_POST['anonymous'];
    $publish = $_POST['publish'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $creator = $_SESSION['user_id'];
    
    // Decode the questions JSON array
    $questions = json_decode($_POST['questions'], true); // Assumes questions is sent as a JSON string

    // Prepare SQL statement to insert survey
    $sql = "INSERT INTO surveys (office, title, objective, is_anonymous, is_published, start_date, end_date, created_by, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";

    $stmt = mysqli_stmt_init($conn);

    if (mysqli_stmt_prepare($stmt, $sql)) {
        // Bind parameters and execute the survey insert query
        mysqli_stmt_bind_param($stmt, "ssssssss", $office, $survey_title, $objective, $anonymous, $publish, $start_date, $end_date, $creator);
        mysqli_stmt_execute($stmt);

        // Get the last inserted survey ID
        $survey_id = mysqli_insert_id($conn);
       

        // Insert the questions into the 'questions' table
        $sql_question = "INSERT INTO surveyquestions (survey_id, question_text, question_type, created_at) VALUES (?, ?, ?, NOW())";
        $stmt_question = mysqli_stmt_init($conn);

        if (mysqli_stmt_prepare($stmt_question, $sql_question)) {
            // Loop through the questions and insert each one
            foreach ($questions as $question) {
                $question_number = $question['question_number'];
                $question_text = $question['question_text'];
                $question_description = $question_number . '. ' . $question_text;
                $question_type = $question['question_type'];

                // Bind and execute each question insert
                mysqli_stmt_bind_param($stmt_question, "iss", $survey_id, $question_description, $question_type);
                mysqli_stmt_execute($stmt_question);
            }
            mysqli_stmt_close($stmt_question);
            echo 'Survey and questions added successfully';
        } else {
            echo 'SQL error: Failed to prepare question statement';
        }

        mysqli_stmt_close($stmt);
    } else {
        echo 'SQL error: Failed to prepare survey statement';
    }
} else {
    echo 'Error: Missing required fields';
}

// Close database connection
mysqli_close($conn);
?>
