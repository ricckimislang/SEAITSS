<?php include 'includes/header.php'; ?>
<?php include 'includes/dbconn.php'; ?>

<?php
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the survey is anonymous
    $survey_id = 1; // Example survey ID, adjust based on the survey
    $is_anonymous = isset($_POST['is_anonymous']) ? $_POST['is_anonymous'] : 1;

    if ($is_anonymous == 1) {
        // Anonymous survey: No personal data to capture
        $name = NULL;
        $course = NULL;
        $year_level = NULL;
        $gender = NULL;

        // Insert into surveyresponses (anonymous)
        $query = "INSERT INTO surveyresponses (survey_id, user_id, name, course, year_level, gender, submitted_at) 
                  VALUES ($survey_id, NULL, NULL, NULL, NULL, NULL, NOW())";
    } else {
        // Non-anonymous survey: Capture full user details
        $name = isset($_POST['name']) ? mysqli_real_escape_string($conn, $_POST['name']) : NULL;
        $course = isset($_POST['course']) ? mysqli_real_escape_string($conn, $_POST['course']) : NULL;
        $year_level = isset($_POST['year-level']) ? mysqli_real_escape_string($conn, $_POST['year-level']) : NULL;
        $gender = isset($_POST['gender']) ? mysqli_real_escape_string($conn, $_POST['gender']) : NULL;

        // Insert into surveyresponses (non-anonymous)
        $query = "INSERT INTO surveyresponses (survey_id, user_id, name, course, year_level, gender, submitted_at) 
                  VALUES ($survey_id, NULL, '$name', '$course', '$year_level', '$gender', NOW())";
    }

    // Execute the insertion query
    if (mysqli_query($conn, $query)) {
        $response_id = mysqli_insert_id($conn); // Get the last inserted response_id

        // Fetch questions from the database
        $query = "SELECT * FROM surveyquestions WHERE survey_id = $survey_id";
        $result = mysqli_query($conn, $query);

        // Loop through the questions and insert each response into responsedetails table
        while ($row = mysqli_fetch_assoc($result)) {
            $question_id = $row['question_id'];
            if (isset($_POST['answer'][$question_id])) {
                $response_text = mysqli_real_escape_string($conn, $_POST['answer'][$question_id]);
                $query = "INSERT INTO responsedetails (response_id, question_id, response_text) 
                          VALUES ($response_id, $question_id, '$response_text')";
                mysqli_query($conn, $query);
            }
        }
        
        // Show SweetAlert success message
        echo "
        <script>
        Swal.fire({
            title: 'Thank you!',
            text: 'Your responses have been submitted successfully.',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then(function() {
            window.location = 'survey.php'; // Redirect after the alert is closed
        });
        </script>";
        
    } else {
        // Show SweetAlert error message
        $error_message = mysqli_error($conn);
        echo "
        <script>
        Swal.fire({
            title: 'Error!',
            text: 'There was an error submitting your responses: $error_message',
            icon: 'error',
            confirmButtonText: 'Try Again'
        });
        </script>";
    }
}
?>

<?php
// Fetch questions from the database based on survey_id
$query = "SELECT * FROM surveyquestions WHERE survey_id = 1"; // Adjust survey_id as necessary
$result = mysqli_query($conn, $query);
?>

<link rel="stylesheet" href="css/survey.css">
<link rel="stylesheet" href="css/radio-button.css">

<div class="container mt-5">
    <div class="row justify-content-center">
        <form method="POST" action="survey.php">
            <div class="e-card">
                <div class="form-title">Office Satisfaction Survey</div> <!-- OFFICE NAME -->
                <div class="form-container">
                    <?php while ($row = mysqli_fetch_assoc($result)) {
                        $question_text = $row['question_text'];
                        $question_id = $row['question_id'];
                        $question_type = $row['question_type']; ?>

                        <div class="form-group">
                            <label for="question_<?php echo $question_id; ?>"><?php echo $question_text; ?></label>

                            <?php
                            if ($question_type == 'input') {
                                // Show a text input
                                echo "<input type='text' class='form-control' id='question_$question_id' name='answer[$question_id]' required>";
                            } elseif ($question_type == 'rating') {
                                // Show radio button options
                                echo "<div class='form-check radio'>";
                                for ($i = 1; $i <= 5; $i++) {
                                    echo "<input label='$i' type='radio' name='answer[$question_id]' value='$i' required><br>";
                                }
                                echo "</div>";
                            }
                            ?>
                        </div>
                    <?php } ?>

                    <input type="hidden" name="is_anonymous" value="<?php echo isset($_POST['is_anonymous']) ? $_POST['is_anonymous'] : 1; ?>">

                    <div class="form-group buttons">
                        <a href="form.php"><button type="button" class="btn btn-primary">Back</button></a>
                        <button type="submit" class="btn btn-primary">Next</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
