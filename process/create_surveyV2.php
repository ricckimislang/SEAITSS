<?php
session_start();
include '../includes/dbconn.php';

if (
    isset(
    $_POST['office'],
    $_POST['survey_title'],
    $_POST['objective'],
    $_POST['publish'],
    $_POST['start_date'],
    $_POST['end_date']
)
) {
    // Assign variables
    $office = $_POST['office'];
    $survey_title = $_POST['survey_title'];
    $objective = $_POST['objective'];
    $anonymous = 1; // Hardcoded since anonymous is not selectable anymore
    $publish = $_POST['publish'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $creator = $_SESSION['user_id'];

    // Anti-duplicate check: Check if a survey with the same title and office already exists
    $duplicate_check_sql = "SELECT survey_id FROM surveys WHERE office = ? LIMIT 1";
    $stmt_duplicate = mysqli_stmt_init($conn);

    if (mysqli_stmt_prepare($stmt_duplicate, $duplicate_check_sql)) {
        mysqli_stmt_bind_param($stmt_duplicate, "s", $office);
        mysqli_stmt_execute($stmt_duplicate);
        mysqli_stmt_store_result($stmt_duplicate);

        if (mysqli_stmt_num_rows($stmt_duplicate) > 0) {
            // If a duplicate is found
            echo 'Error: A survey already exists for this office.';
            mysqli_stmt_close($stmt_duplicate);
            exit;
        }
        mysqli_stmt_close($stmt_duplicate);
    } else {
        echo 'SQL error: Failed to prepare duplicate check statement';
        exit;
    }

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

        // Predefined questions
        $predefined_questions = [
            ["How satisfied are you with the quality of services provided by this office/department?", "rating"],
            ["How effectively does the office/department handle your requests or concerns?", "rating"],
            ["How would you rate the professionalism and courtesy of the staff in this office/department?", "rating"],
            ["How easy is it to access the services or assistance you need from this office/department?", "rating"],
            ["How satisfied are you with the communication between you and the staff in this office/department?", "rating"],
            ["How would you rate the timeliness of the responses you receive from this office/department?", "rating"],
            ["How well does this office/department provide the necessary resources or information you require?", "rating"],
            ["How satisfied are you with the clarity and transparency of the processes in this office/department?", "rating"],
            ["How well does this office/department support your needs or objectives?", "rating"],
            ["What suggestions do you have for improving the department's programs and services?", "input"],
            ["Do you have complaints or concerns about this office/department? Enter None if none.", "input"],
        ];

        // Insert the questions into the 'surveyquestions' table
        $sql_question = "INSERT INTO surveyquestions (survey_id, question_text, question_type, created_at) VALUES (?, ?, ?, NOW())";
        $stmt_question = mysqli_stmt_init($conn);

        if (mysqli_stmt_prepare($stmt_question, $sql_question)) {
            // Loop through the predefined questions and insert each one
            foreach ($predefined_questions as $question) {
                $question_text = $question[0];
                $question_type = $question[1];

                // Bind and execute each question insert
                mysqli_stmt_bind_param($stmt_question, "iss", $survey_id, $question_text, $question_type);
                mysqli_stmt_execute($stmt_question);
            }
            mysqli_stmt_close($stmt_question);
            echo 'Survey and predefined questions added successfully';
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