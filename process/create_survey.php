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
    $_POST['end_date']
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
    $question_number = $_POST['question_number'];
    $question_text = $_POST['question_text'];
    $question_type = $_POST['question_type'];
    $creator = $_SESSION['user_id'];

    // Prepare SQL statement
    $sql = "INSERT INTO surveys (office, title, objective, is_anonymous, is_published, start_date, end_date, created_by, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";

    $stmt = mysqli_stmt_init($conn);

    if (mysqli_stmt_prepare($stmt, $sql)) {
        // Bind parameters and execute
        mysqli_stmt_bind_param($stmt, "ssssssss", $office, $survey_title, $objective, $anonymous, $publish, $start_date, $end_date, $creator);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        echo 'Survey added successfully';
    } else {
        echo 'SQL error: Failed to prepare statement';
    }
} else {
    echo 'Error: Missing required fields';
}

// Close database connection
mysqli_close($conn);
?>