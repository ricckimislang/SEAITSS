<?php include 'includes/header.php';
include 'includes/navtop.php';

$username = $_SESSION['username'];

$check = "SELECT * FROM users WHERE username = '$username'";
$checkresult = mysqli_query($conn, $check);
$checkrow = mysqli_fetch_assoc($checkresult);
$_SESSION['user_id'] = $checkrow['user_id'];

?>
<link rel="stylesheet" href="css/home.css">
<link rel="stylesheet" href="css/radio-button.css">
<div class="container mt-5">
    <div class="row justify-content-center">
        <form id="create-survey">
            <div class="e-card">
                <div class="form-title">SEAIT SATISFACTION SURVEY</div> <!-- OFFICE NAME -->
                <div class="form-container">
                    <div class="row">
                        <div class="col">
                            <div class="form-group row">
                                <input type="text" id="user_id" value="<?php echo $_SESSION['user_id']; ?>" hidden>
                                <label class="col-sm-3 col-form-label" for="office">Select Office</label>
                                <select class="form-controloffice" id="office">
                                    <option value="CICT">CICT OFFICE</option>
                                    <option value="SAO">SAO OFFICE</option>
                                    <option value="EDUC">EDUCATION OFFICE</option>
                                </select>
                            </div>
                            <div class="form-group row">
                                <label for="survey_title" class="col-sm-3 col-form-label">Title</label>
                                <input type="text" class="form-controloffice" id="survey_title" required>
                            </div>
                            <div class="form-group row">
                                <label for="objective" class="col-sm-3 col-form-label">Objective</label>
                                <input type="text" class="form-controloffice" id="objective" required>
                            </div>

                            <div class="form-group row radio">
                                <label class="col-sm-3 col-form-label" for="anonymous">Is Anonymous</label>
                                <input style="width:10%" label='Yes' type='radio' id="anonymous" name='anonymous'
                                    value='1' required><br>
                                <input style="width:10%" label='No' type='radio' id="anonymous" name='anonymous'
                                    value='0' required>
                            </div>
                            <div class="form-group row radio">
                                <label class="col-sm-3 col-form-label" for="publish">Is Published</label>
                                <input style="width:10%" label='Yes' type='radio' id="publish" name='publish' value='1'
                                    required><br>
                                <input style="width:10%" label='No' type='radio' id="publish" name='publish' value='0'
                                    required>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label" for="start_date">Start Date</label>
                                <input class="col-sm-3 form-controloffice" type='date' name="start_date" id="start_date"
                                    required>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label" for="end_date">End Date</label>
                                <input class="col-sm-3 form-controloffice" type='date' name="end_date" id="end_date"
                                    required>
                            </div>
                        </div>



                        <!---question--->
                        <div class="col">


                            <div class="col">
                                <div id="questions-container"></div> <!-- Container for dynamic questions -->

                                <div class="form-group buttons">
                                    <button type="button" class="btn btn-secondary" id="back-question">Back
                                        Question</button>
                                    <button type="button" class="btn btn-primary" id="next-question">Next
                                        Question</button>
                                </div>


                            </div>
                            <button type="submit" class="btn btn-success float-right" id="submit">Submit Survey</button>


                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>
<?php include 'includes/footer.php'; ?>

<script>
    $(document).ready(function () {
        let questions = [];
        let questionCount = 1;

        // Function to render a question block dynamically
        function renderQuestion() {
            let questionHtml = `
                <div id="question-block-${questionCount}" class="question-block">
                    <div class="form-group row">
                        <label for="question_number_${questionCount}" class="col">Question Number ${questionCount}</label>
                    </div>
                    <div class="form-group row">
                        <label for="question_text_${questionCount}" class="col-sm-3 col-form-label">Question Text</label>
                        <textarea class="col-sm-9 form-control" id="question_text_${questionCount}" required>${questions[questionCount - 1]?.question_text || ''}</textarea>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" for="question_type_${questionCount}">Select Type</label>
                        <select class="form-controloffice" id="question_type_${questionCount}">
                            <option value="input" ${questions[questionCount - 1]?.question_type === 'input' ? 'selected' : ''}>Input</option>
                            <option value="rating" ${questions[questionCount - 1]?.question_type === 'rating' ? 'selected' : ''}>Rating</option>
                        </select>
                    </div>
                </div>
            `;
            // Replace the content of the questions-container with the new question
            $("#questions-container").html(questionHtml);
        }

        // Initialize the first question
        renderQuestion();

        // Handle the Next button click to add a new question
        $("#next-question").click(function () {
            const questionText = $(`#question_text_${questionCount}`).val();
            const questionType = $(`#question_type_${questionCount}`).val();

            if (questionText === '') {
                alert('Please fill in the current question before adding a new one.');
                return;
            }

            // Store the current question if not already in the array
            questions[questionCount - 1] = {
                question_number: questionCount,
                question_text: questionText,
                question_type: questionType
            };

            // Increment the question count
            questionCount++;

            // Remove the current question block and render the next question
            renderQuestion();

            // Show the Back button if we are beyond the first question
            if (questionCount > 1) {
                $("#back-question").show();
            }
        });

        // Handle the Back button click to go to the previous question
        $("#back-question").click(function () {
            if (questionCount > 1) {
                const questionText = $(`#question_text_${questionCount}`).val();
                const questionType = $(`#question_type_${questionCount}`).val();

                // Save the current question
                questions[questionCount - 1] = {
                    question_number: questionCount,
                    question_text: questionText,
                    question_type: questionType
                };

                // Decrease the question count to move to the previous question
                questionCount--;

                // Render the previous question
                renderQuestion();

                // Hide the Back button if we are on the first question
                if (questionCount === 1) {
                    $("#back-question").hide();
                }
            }
        });

        // Handle the form submission
        $("#create-survey").submit(function (e) {
            e.preventDefault();

            // Get the last question entered
            const questionText = $(`#question_text_${questionCount}`).val();
            const questionType = $(`#question_type_${questionCount}`).val();

            if (questionText !== '') {
                questions[questionCount - 1] = {
                    question_number: questionCount,
                    question_text: questionText,
                    question_type: questionType
                };
            }

            // Send the entire form, including questions, via AJAX
            $.ajax({
                url: "process/create_survey.php",
                type: "POST",
                data: {
                    office: $("#office").val(),
                    survey_title: $("#survey_title").val(),
                    objective: $("#objective").val(),
                    anonymous: $("input[name='anonymous']:checked").val(),
                    publish: $("input[name='publish']:checked").val(),
                    start_date: $("#start_date").val(),
                    end_date: $("#end_date").val(),
                    questions: JSON.stringify(questions)  // Send questions as a JSON array
                },
                success: function (data) {
                    alert(data);
                }
            });
        });

        // Initially hide the Back button since we're on the first question
        $("#back-question").hide();
    });
</script>