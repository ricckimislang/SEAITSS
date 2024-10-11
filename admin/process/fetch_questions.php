<?php
if (isset($_POST['survey_id'])) {
    include '../includes/dbconn.php'; // Correct your database connection path
    $survey_id = $_POST['survey_id'];

    $query = "SELECT * FROM surveyquestions WHERE survey_id = ? ORDER BY question_id ASC";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $survey_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $questions = [];
        while ($row = $result->fetch_assoc()) {
            $questions[] = $row;
        }

        echo json_encode(['success' => true, 'questions' => $questions]);
    } else {
        echo json_encode(['success' => false, 'error' => 'SQL error']);
    }
}
?>