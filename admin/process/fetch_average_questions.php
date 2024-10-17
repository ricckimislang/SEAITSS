<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../includes/dbconn.php'; // Assuming you have a database connection in $conn

if (isset($_GET['survey_id'])) {
    $survey_id = $_GET['survey_id']; // Get the survey ID from the request

    // Simplified query to fetch question text and average rating
    $query = "SELECT q.question_text, AVG(r.rating) as average_rating 
              FROM surveyquestions q
              LEFT JOIN responsedetails r ON q.question_id = r.question_id
              WHERE q.survey_id = ? AND r.rating IS NOT NULL AND r.rating != ''
              GROUP BY q.question_id";

    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $survey_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $questions = [];
        while ($row = $result->fetch_assoc()) {
            $questions[] = [
                'question_text' => $row['question_text'],  // Adjusted to match the query field name
                'average_rating' => $row['average_rating'] ? round($row['average_rating'], 2) : 'N/A' // Rounded to 2 decimal places
            ];
        }

        // Return JSON response
        echo json_encode($questions);
    } else {
        // Query preparation failed
        echo json_encode(['error' => 'Query preparation failed.']);
    }
} else {
    echo json_encode(['error' => 'No survey ID provided.']);
}
?>