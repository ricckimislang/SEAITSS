<?php
include '../includes/dbconn.php';

$response = [
    'totalResponses' => 0,
    'overallSatisfaction' => 0,
    'questions' => [] // For the input-type questions only
];

if (isset($_GET['survey_id']) && isset($_GET['response_id'])) {
    $survey_id = $_GET['survey_id'];
    $response_id = $_GET['response_id'];

    // Step 1: Fetch all questions for the specific survey
    $questionQuery = "SELECT question_id, question_text, question_type FROM surveyquestions WHERE survey_id = ?";
    $stmt = $conn->prepare($questionQuery);
    $stmt->bind_param("i", $survey_id);
    $stmt->execute();
    $questionResult = $stmt->get_result();

    // Step 2: Create an associative array to store question texts and types
    $questionsArray = [];
    while ($row = $questionResult->fetch_assoc()) {
        $questionsArray[$row['question_id']] = [
            'text' => $row['question_text'],
            'type' => $row['question_type']
        ];
    }

    // Step 3: Query to fetch responses for the specific response_id
    $responseQuery = "SELECT question_id, response_text, rating FROM responsedetails WHERE response_id = ?";
    $stmt = $conn->prepare($responseQuery);
    $stmt->bind_param("i", $response_id);
    $stmt->execute();
    $responseResult = $stmt->get_result();

    // Step 4: Process responses and accumulate totals
    $totalResponses = 0;
    $totalRating = 0;
    $ratingCount = 0;

    while ($row = $responseResult->fetch_assoc()) {
        $questionId = $row['question_id'];

        // Check if the question exists
        if (isset($questionsArray[$questionId])) {
            $questionData = $questionsArray[$questionId];
            $responseText = $row['response_text'] ?: $row['rating'];

            // Count total responses
            if (!empty($responseText)) {
                $totalResponses++;
                // Calculate overall satisfaction based on ratings
                if (!empty($row['rating']) && is_numeric($row['rating'])) {
                    $totalRating += $row['rating'];
                    $ratingCount++;
                }
            }

            // Only add input-type questions for the table
            if ($questionData['type'] === 'input') {
                $response['questions'][] = [
                    'number' => $questionId,
                    'description' => $questionData['text'], // Get question text
                    'response' => $responseText // User's response
                ];
            }
        }
    }

    // Set total responses and overall satisfaction
    $response['totalResponses'] = $totalResponses;
    $response['overallSatisfaction'] = $ratingCount ? round($totalRating / $ratingCount, 2) : 0; // Average rating

    echo json_encode($response);
    exit;
}

// Return error if parameters are not set
echo json_encode($response);
?>