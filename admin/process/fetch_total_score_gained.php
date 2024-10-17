<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../includes/dbconn.php'; // Assuming you have a database connection in $conn

if (isset($_GET['survey_id'])) {
    $survey_id = $_GET['survey_id']; // Get the survey ID from the request

    // Query to calculate total score gained and possible maximum score for the entire survey
    $query = "SELECT 
                     SUM(r.rating) as total_score_gained, 
                     (COUNT(r.response_id) * 5) as total_possible_score 
              FROM surveyquestions q
              LEFT JOIN responsedetails r ON q.question_id = r.question_id
              WHERE q.survey_id = ?";

    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $survey_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $scores = $result->fetch_assoc();

        // Return JSON response
        echo json_encode([
            'total_score_gained' => $scores['total_score_gained'] ? $scores['total_score_gained'] : 0,
            'total_possible_score' => $scores['total_possible_score'] ? $scores['total_possible_score'] : 0
        ]);
    } else {
        echo json_encode(['error' => 'Query preparation failed.']);
    }
} else {
    echo json_encode(['error' => 'No survey ID provided.']);
}
?>