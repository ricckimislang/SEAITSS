<?php
session_start();
include '../includes/dbconn.php';
header('Content-Type: application/json');

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
    $anonymous = 1;
    $publish = $_POST['publish'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $creator = $_SESSION['user_id'];

    // Step 1: Get department_id using office name
    $dept_query = "SELECT department_id FROM department WHERE office_name = ?";
    $stmt_dept = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt_dept, $dept_query)) {
        echo json_encode(['status' => 'error', 'message' => 'Department query preparation failed']);
        exit;
    }

    mysqli_stmt_bind_param($stmt_dept, "s", $office);
    mysqli_stmt_execute($stmt_dept);
    $dept_result = mysqli_stmt_get_result($stmt_dept);

    if (mysqli_num_rows($dept_result) == 0) {
        echo json_encode(['status' => 'error', 'message' => 'Department not found']);
        exit;
    }

    $dept_row = mysqli_fetch_assoc($dept_result);
    $department_id = $dept_row['department_id'];
    mysqli_stmt_close($stmt_dept);

    // Step 2: Check if survey already exists for this office
    $survey_check_query = "SELECT survey_id FROM surveys WHERE office = ?";
    $stmt_survey_check = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt_survey_check, $survey_check_query)) {
        echo json_encode(['status' => 'error', 'message' => 'Survey check query preparation failed']);
        exit;
    }

    mysqli_stmt_bind_param($stmt_survey_check, "s", $office);
    mysqli_stmt_execute($stmt_survey_check);
    mysqli_stmt_store_result($stmt_survey_check);

    if (mysqli_stmt_num_rows($stmt_survey_check) > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Survey already exists for this office']);
        mysqli_stmt_close($stmt_survey_check);
        exit;
    }
    mysqli_stmt_close($stmt_survey_check);

    // Step 3: Insert survey
    $survey_insert_query = "INSERT INTO surveys 
        (office, title, objective, is_anonymous, is_published, start_date, end_date, created_by, created_at) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";

    $stmt_survey = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt_survey, $survey_insert_query)) {
        echo json_encode(['status' => 'error', 'message' => 'Survey insert query preparation failed']);
        exit;
    }

    mysqli_stmt_bind_param(
        $stmt_survey,
        "ssssssss",
        $office,
        $survey_title,
        $objective,
        $anonymous,
        $publish,
        $start_date,
        $end_date,
        $creator
    );

    if (!mysqli_stmt_execute($stmt_survey)) {
        echo json_encode(['status' => 'error', 'message' => 'Failed to insert survey']);
        exit;
    }

    $survey_id = mysqli_insert_id($conn);
    mysqli_stmt_close($stmt_survey);

    // Step 4: Retrieve and insert questions for the department
    $questions_query = "SELECT question_text, question_type FROM questions WHERE department_id = ?";
    $stmt_questions = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt_questions, $questions_query)) {
        echo json_encode(['status' => 'error', 'message' => 'Questions query preparation failed']);
        exit;
    }

    mysqli_stmt_bind_param($stmt_questions, "i", $department_id);
    mysqli_stmt_execute($stmt_questions);
    $questions_result = mysqli_stmt_get_result($stmt_questions);

    // Check if there are any questions
    if (mysqli_num_rows($questions_result) == 0) {
        // Optionally delete the survey if no questions are found
        $delete_survey_query = "DELETE FROM surveys WHERE survey_id = ?";
        $stmt_delete = mysqli_stmt_init($conn);

        if (mysqli_stmt_prepare($stmt_delete, $delete_survey_query)) {
            mysqli_stmt_bind_param($stmt_delete, "i", $survey_id);
            mysqli_stmt_execute($stmt_delete);
            mysqli_stmt_close($stmt_delete);
        }

        echo json_encode(['status' => 'error', 'message' => 'No questions found for this department']);
        exit;
    }

    // Insert questions into surveyquestions
    $question_insert_query = "INSERT INTO surveyquestions 
        (survey_id, question_text, question_type, created_at) 
        VALUES (?, ?, ?, NOW())";

    $stmt_survey_questions = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt_survey_questions, $question_insert_query)) {
        echo json_encode(['status' => 'error', 'message' => 'Survey questions insert query preparation failed']);
        exit;
    }

    // Start transaction
    mysqli_begin_transaction($conn);

    try {
        // Insert each question
        while ($question_row = mysqli_fetch_assoc($questions_result)) {
            mysqli_stmt_bind_param(
                $stmt_survey_questions,
                "iss",
                $survey_id,
                $question_row['question_text'],
                $question_row['question_type']
            );

            if (!mysqli_stmt_execute($stmt_survey_questions)) {
                throw new Exception('Failed to insert a question');
            }
        }

        // Commit transaction
        mysqli_commit($conn);

        echo json_encode([
            'status' => 'success',
            'message' => 'Survey and questions successfully added',
            'survey_id' => $survey_id
        ]);
    } catch (Exception $e) {
        // Rollback transaction
        mysqli_rollback($conn);

        // Delete the survey if questions insertion fails
        $delete_survey_query = "DELETE FROM surveys WHERE survey_id = ?";
        $stmt_delete = mysqli_stmt_init($conn);

        if (mysqli_stmt_prepare($stmt_delete, $delete_survey_query)) {
            mysqli_stmt_bind_param($stmt_delete, "i", $survey_id);
            mysqli_stmt_execute($stmt_delete);
            mysqli_stmt_close($stmt_delete);
        }

        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to add survey questions: ' . $e->getMessage()
        ]);
    }

    // Close statements
    mysqli_stmt_close($stmt_questions);
    mysqli_stmt_close($stmt_survey_questions);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Missing required fields']);
}

// Close database connection
mysqli_close($conn);
