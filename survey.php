<?php include 'includes/header.php'; ?>
<?php include 'includes/dbconn.php'; ?>

<?php
$survey_id = $_GET['survey_id'] ?? null;
$scanQR = $_GET['scannedQRCode'] ?? '';
if (is_null($survey_id)) {
    echo '<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>';
    echo '<script>
        swal({
            title: "Please Scan The QR CODE again",
            text: "Please Scan The QR CODE to take the survey",
            icon: "error",
            button: "OK",
        }).then(function() {
            window.location.href = "index.php";
        });
    </script>';
    exit;
}


// Check if the survey is published
$status_query = "SELECT is_published FROM surveys WHERE survey_id = $survey_id";
$status_result = mysqli_query($conn, $status_query);

if (!$status_result) {
    echo '<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>';
    echo '<script>
        swal({
            title: "Error",
            text: "Did you scan? please scan the QR Code again.",
            icon: "error",
            button: "OK",
        }).then(function() {
            window.location.href = "index.php";
        });
    </script>';
    exit;
    // Query failed, print the error message
}

$status_row = mysqli_fetch_assoc($status_result);
$is_published = $status_row['is_published'];

if ($is_published == 0) {
    // Survey is not published, display the message and redirect
    echo '
    <link rel="stylesheet" href="css/survey.css">
    <link rel="stylesheet" href="css/radio-button.css">
    <body>
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="e-card text-center" style="background-color: #f8d7da; border-color: #f5c6cb; color: #721c24; padding: 20px; border-radius: 8px;">
                    <div class="form-title" style="font-size: 24px; font-weight: bold;">Office Satisfaction Survey</div>
                    <div class="form-container">
                        <p style="font-size: 18px;">The survey is not published yet.</p>
                        <p style="font-size: 16px;">You will be redirected to the homepage shortly.</p>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script>
        setTimeout(function() {
            window.location.href = "index.php";
        }, 3000); // Redirect after 3 seconds
    </script>';
    exit;
}


// Get the current page from the URL, default to 1
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$limit = 5; // Questions per page
$offset = ($page - 1) * $limit;

// Fetch questions from the database with pagination
$query = "SELECT * FROM surveyquestions WHERE survey_id = $survey_id LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $query);

// Fetch total question count for pagination
$total_query = "SELECT COUNT(*) AS total FROM surveyquestions WHERE survey_id = $survey_id";
$total_result = mysqli_query($conn, $total_query);
$total_row = mysqli_fetch_assoc($total_result);
$total_questions = $total_row['total'];
$total_pages = ceil($total_questions / $limit);
?>

<link rel="stylesheet" href="css/survey.css">
<link rel="stylesheet" href="css/radio-button.css">
<div class="container mt-5">
    <div class="row justify-content-center">
        <form id="surveyForm">
            <input type="hidden" value="<?php echo $survey_id; ?>" name="survey_id" id="survey_id">
            <input type="hidden" value="<?php echo $scanQR; ?>" name="scannedQR" id="scannedQR">

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

                    <input type="hidden" name="is_anonymous"
                        value="<?php echo isset($_POST['is_anonymous']) ? $_POST['is_anonymous'] : 1; ?>">

                    <div class="form-group buttons">
                        <?php if ($page > 1): ?>
                            <button type="button" class="btn btn-primary" id="prevBtn">Back</button>
                        <?php endif; ?>

                        <?php if ($page < $total_pages): ?>
                            <button type="button" class="btn btn-primary" id="nextBtn">Next</button>
                        <?php else: ?>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

<script>
    $(document).ready(function () {
        let answers = {}; // To store answers

        // Clear answers if a new survey is started
        let currentSurveyId = $('#survey_id').val();
        let storedSurveyId = localStorage.getItem('survey_id');
        if (storedSurveyId !== currentSurveyId) {
            localStorage.setItem('survey_id', currentSurveyId); // Set current survey ID in storage
            localStorage.clear(); // Clear all previous data
        }

        // Load existing answers from localStorage if available
        if (localStorage.getItem('answers')) {
            answers = JSON.parse(localStorage.getItem('answers'));
        }

        // Save answers on each input change
        $('input').on('change', function () {
            let questionId = $(this).attr('name').replace('answer[', '').replace(']', '');
            answers[questionId] = $(this).val();
            localStorage.setItem('answers', JSON.stringify(answers));
        });

        // Pre-fill answers if available
        $.each(answers, function (questionId, answer) {
            $(`input[name="answer[${questionId}]"][value="${answer}"]`).prop('checked', true);
            $(`#question_${questionId}`).val(answer);
        });

        // Validate the current page fields before moving to the next page
        function validatePage() {
            let isValid = true;

            // Check only the visible inputs on the current page
            $('.form-group:visible input[required]').each(function () {
                if ($(this).is(':radio')) {
                    let radioGroupName = $(this).attr('name');
                    if (!$(`input[name="${radioGroupName}"]:checked`).length) {
                        isValid = false;
                        $(this).closest('.form-group').find('label').css('color', 'red'); // Highlight missing field
                    } else {
                        $(this).closest('.form-group').find('label').css('color', ''); // Reset label color
                    }
                } else if ($(this).is(':text') && $(this).val().trim() === '') {
                    isValid = false;
                    $(this).closest('.form-group').find('label').css('color', 'red'); // Highlight missing field
                } else {
                    $(this).closest('.form-group').find('label').css('color', ''); // Reset label color
                }
            });

            return isValid;
        }

        // Handle Next button click with validation
        $('#nextBtn').click(function (e) {
            e.preventDefault(); // Prevent default behavior

            // Perform validation before moving to the next page
            if (validatePage()) {
                // Validation passed, move to next page
                let url = window.location.href;
                url = url.replace(/(&|\?)page=\d+/, ''); // Remove existing page number
                window.location.href = url + '&page=<?php echo $page + 1; ?>';
            } else {
                alert('Please fill out all required fields before proceeding.');
            }
        });

        // Handle Back button click
        $('#prevBtn').click(function (e) {
            e.preventDefault(); // Prevent default behavior
            let url = window.location.href;
            url = url.replace(/(&|\?)page=\d+/, ''); // Remove existing page number
            window.location.href = url + '&page=<?php echo $page - 1; ?>';
        });

        // Submit form with AJAX
        $('#surveyForm').submit(function (e) {
            e.preventDefault();

            if (validatePage()) {
                // Collect answers from localStorage before submission
                if (localStorage.getItem('answers')) {
                    answers = JSON.parse(localStorage.getItem('answers'));
                }

                // Append answers to the form data
                let scannedQRC = $('#scannedQR').val();
                let formData = $(this).serializeArray();
                $.each(answers, function (questionId, answer) {
                    formData.push({ name: `answer[${questionId}]`, value: answer });
                });

                // Perform the AJAX submission if the current page is valid
                $.ajax({
                    url: 'process/take_respondent_survey.php',
                    type: 'POST',
                    data: {
                        formData: formData,
                        scannedQRC: scannedQRC
                    },
                    success: function (data) {
                        let response = JSON.parse(data);
                        if (response.status === 'success') {
                            $.jGrowl(response.message, { theme: "alert alert-success", life: 2000 });
                            // Clear localStorage after successful submission
                            localStorage.clear();
                            setTimeout(function () {
                                window.location.href = "thank_you_page.php";
                            }, 2000);
                        } else {
                            $.jGrowl(response.message, { theme: "alert alert-danger", life: 3000 });
                            localStorage.clear();
                        }
                    },
                    error: function () {
                        localStorage.clear();
                        $.jGrowl('An unexpected error occurred. Please try again.', { theme: "alert alert-danger", life: 4000 });
                    }
                });
            } else {
                alert('Please fill out all required fields before submitting.');
            }
        });
    });
</script>