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

// Prepare questions in an array
$questions = [];
while ($row = mysqli_fetch_assoc($result)) {
    $questions[] = $row;
}
?>

<link rel="stylesheet" href="css/survey.css">
<link rel="stylesheet" href="css/radio-button.css">

<div class="container mt-5">
    <div class="row justify-content-center">
        <form method="POST" action="survey.php" id="survey-form">
            <div class="e-card">
                <div class="form-title">Office Satisfaction Survey</div> <!-- OFFICE NAME -->
                <div class="bg-white w-[90vw] md:w-[50vw] p-6 rounded-lg shadow-md form-container" id="question-container">
                    <!-- Questions will be dynamically loaded here -->
                </div>

                <input type="hidden" name="is_anonymous"
                    value="<?php echo isset($_POST['is_anonymous']) ? $_POST['is_anonymous'] : 1; ?>">
                <div class="form-group buttons">
                    <button type="button" class="btn btn-primary" id="back-button" style="display: none;">Back</button>
                    <button type="button" class="btn btn-primary" id="next-button">Next</button>
                    <button type="submit" class="btn btn-success" id="submit-button" style="display: none;">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    let currentQuestionIndex = 0;
    const questions = <?php echo json_encode($questions); ?>;
    const questionsPerPage = 5;
    const answers = {}; // Object to store the user's answers

    function loadQuestions() {
        const questionContainer = document.getElementById('question-container');
        questionContainer.innerHTML = ''; // Clear previous questions

        const start = currentQuestionIndex * questionsPerPage;
        const end = start + questionsPerPage;

        for (let i = start; i < end && i < questions.length; i++) {
            const question = questions[i];
            let questionHTML = `<div class="form-group">
            <label class='block text-gray-700 text-sm font-bold mb-2' for="question_${question.question_id}">${question.question_text}</label>`;

            // Load saved answers if available
            const savedAnswer = answers[question.question_id] || '';
            if (question.question_type === 'input') {
                questionHTML += `<input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline form-control" id="question_${question.question_id}" name="answer[${question.question_id}]" value="${savedAnswer}" required>`;
            } else if (question.question_type === 'rating') {
                questionHTML += `<div class="form-check radio">`;
                for (let j = 1; j <= 5; j++) {
                    const checked = savedAnswer == j ? 'checked' : '';
                    questionHTML += `<input class='shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline' label='${j}' type='radio' name='answer[${question.question_id}]' value='${j}' ${checked} required><br>`;
                }
                questionHTML += `</div>`;
            }

            questionHTML += `</div>`;
            questionContainer.innerHTML += questionHTML;
        }

        // Show or hide buttons based on current index
        document.getElementById('next-button').style.display = (end < questions.length) ? 'block' : 'none';
        document.getElementById('back-button').style.display = (currentQuestionIndex > 0) ? 'block' : 'none';
        document.getElementById('submit-button').style.display = (end >= questions.length) ? 'block' : 'none'; // Show submit button when on last question
    }

    function saveAnswers() {
        const answerInputs = document.querySelectorAll('input[name^="answer"]');
        answerInputs.forEach(input => {
            const questionId = input.name.split('[')[1].split(']')[0]; // Extract question_id
            if (input.type === 'radio') {
                if (input.checked) {
                    answers[questionId] = input.value;
                }
            } else {
                answers[questionId] = input.value;
            }
        });
    }

    document.getElementById('next-button').addEventListener('click', function () {
        saveAnswers(); // Save current answers before proceeding

        // Check if there are more questions to show
        if (currentQuestionIndex * questionsPerPage + questionsPerPage < questions.length) {
            currentQuestionIndex++;
            loadQuestions();
        } else {
            // If no more questions, submit the form
            document.getElementById('survey-form').submit();
        }
    });

    document.getElementById('back-button').addEventListener('click', function () {
        saveAnswers(); // Save current answers before going back
        if (currentQuestionIndex > 0) {
            currentQuestionIndex--;
            loadQuestions();
        }
    });

    // Load the first set of questions on page load
    loadQuestions();
</script>

<?php include 'includes/footer.php'; ?>
