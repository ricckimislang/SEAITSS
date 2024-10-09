<?php
session_start();
include '../includes/dbconn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the answers from the POST data
    $survey_id = $_POST['survey_id'];
    $answers = $_POST['answer'];

    // Sort answers by Question ID
    ksort($answers); // This will sort the array by keys (question IDs) in ascending order


    $survrespo = "INSERT INTO surveyresponses (survey_id, user_id, submitted_at) VALUES (?, NULL, NOW())";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $survrespo);
    mysqli_stmt_bind_param($stmt, "i", $survey_id);
    mysqli_stmt_execute($stmt);

    
    // Loop through each answer and print the question ID and the corresponding answer
    foreach ($answers as $question_id => $answer) {



        echo "<div class='form-group'>";
        echo "<label><strong>Question ID: </strong> $question_id</label><br>";
        echo "<label><strong>Answer: </strong> $answer</label>";
        echo "</div>";
    }

    echo "</div>";
}
?>