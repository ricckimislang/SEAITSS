<?php include 'includes/header.php';
include 'includes/navtop.php';

$username = $_SESSION['username'];

$check = "SELECT * FROM users WHERE username = '$username'";
$checkresult = mysqli_query($conn, $check);
$checkrow = mysqli_fetch_assoc($checkresult);
$_SESSION['user_id'] = $checkrow['user_id'];

?>
<link rel="stylesheet" href="../css/create_form.css">
<link rel="stylesheet" href="../css/radio-button.css">
<div class="container-fluid d-flex">
    <?php include 'includes/sidebar.php'; ?>
    <div class="col">
        <div class="row mt-4 justify-content-center">
            <form id="create-survey">
                <div class="e-card">
                    <div class="form-title text-center">SEAIT SATISFACTION SURVEY</div> <!-- OFFICE NAME -->
                    <div class="form-container">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <input type="text" id="user_id" value="<?php echo $_SESSION['user_id']; ?>" hidden>
                                    <label class="col-lg-4 col-form-label" for="office">Select Office</label>
                                    <div class="col-lg-8">
                                        <?php
                                        $query1 = "SELECT * FROM department";
                                        $result1 = mysqli_query($conn, $query1);
                                        ?>
                                        <select class="form-control" id="office">
                                            <?php
                                            while ($row1 = mysqli_fetch_assoc($result1)) {
                                                echo "<option value='" . $row1['office_name'] . "'>" . $row1['office_name'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label" for="survey_title">Title</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" id="survey_title"
                                            placeholder="Survey Title" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label class="col-lg-2 col-form-label" for="objective">Objective</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="objective" placeholder="Survey Objective"
                                    required>
                            </div>
                        </div>

                        <!-- Published radio buttons -->
                        <div class="form-group row radio">
                            <label class="col-lg-4 col-form-label" for="publish">Is Published</label>
                            <input style="width:20%" label='Yes' type='radio' id="publish" name='publish' value='1'
                                required><br>
                            <input style="width:20%" label='No' type='radio' id="publish" name='publish' value='0'
                                required>
                        </div>

                        <!-- Start date -->
                        <div class="form-group row mb-3">
                            <label class="col-lg-2 col-form-label" for="start_date">Start Date</label>
                            <div class="col-lg-10">
                                <input class="form-control" type="date" name="start_date" id="start_date" required>
                            </div>
                        </div>

                        <!-- End date -->
                        <div class="form-group row mb-3">
                            <label class="col-lg-2 col-form-label" for="end_date">End Date</label>
                            <div class="col-lg-10">
                                <input class="form-control" type="date" name="end_date" id="end_date" required>
                            </div>
                        </div>

                        <script>
                            // Set today's date as the minimum for the start date input
                            document.addEventListener('DOMContentLoaded', function () {
                                const today = new Date();
                                const formattedDate = today.toISOString().split('T')[0]; // Format YYYY-MM-DD
                                document.getElementById('start_date').setAttribute('min', formattedDate);
                            });

                            document.getElementById('start_date').addEventListener('change', function () {
                                const startDate = new Date(this.value);
                                const endDateInput = document.getElementById('end_date');

                                // Set the min attribute of the end date input to the selected start date
                                endDateInput.min = this.value;

                                // If the selected end date is less than the start date, reset it
                                if (new Date(endDateInput.value) < startDate) {
                                    endDateInput.value = '';
                                }
                            });
                        </script>

                        <div class="row">
                            <div class="col">
                                <div id="questions-container">
                                    <!-- Container for dynamic questions -->
                                </div>
                                <div class="form-group buttons">
                                    <button type="submit" class="btn btn-success" id="submit">Create Survey</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>



<?php include 'includes/footer.php'; ?>

<script>
 
        /*
        let questions = [];
        let questionCount = 1;

        // Function to render a question block dynamically
        function renderQuestion() {
            let questionHtml = `
            <br>
                <div id="question-block-${questionCount}" class="question-block">
                    <div class="form-group row">
                        <label for="question_number_${questionCount}" class="col-lg-4">Question Number ${questionCount}</label>
                    </div>
                    <div class="form-group row">
                        <label for="question_text_${questionCount}" class="col-lg col-form-label">Question Text</label>
                        <textarea class="col-lg-12 form-control" id="question_text_${questionCount}" placeholder="Enter Question Description" required>${questions[questionCount - 1]?.question_text || ''}</textarea>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg col-form-label" for="question_type_${questionCount}">Select Type</label>
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
        */

        // Handle the form submission
        $("#create-survey").submit(function (e) {
            e.preventDefault();

            /* Get the last question entered
            const questionText = $(`#question_text_${questionCount}`).val();
            const questionType = $(`#question_type_${questionCount}`).val();

            if (questionText !== '') {
                questions[questionCount - 1] = {
                    question_number: questionCount,
                    question_text: questionText,
                    question_type: questionType
                };
            }

            */

            // Send the entire form, including questions, via AJAX
            $.ajax({
                url: "../process/create_surveyV2.php",
                type: "POST",
                data: {
                    office: $("#office").val(),
                    survey_title: $("#survey_title").val(),
                    objective: $("#objective").val(),
                    publish: $("#publish").val(),
                    start_date: $("#start_date").val(),
                    end_date: $("#end_date").val(),
                    //questions: JSON.stringify(questions)  // Send questions as a JSON array
                },
                success: function (data) {
                    if (data.status === 'success') {
                        $.jGrowl("Survey created successfully!", {
                            theme: "alert alert-success",
                            life: 2000
                        });
                        setTimeout(function () {
                            window.location.href = "home.php";
                        }, 2000);
                    } else if (data.status === 'duplicate') {
                        $.jGrowl("Error: Survey already exists in this Office!", {
                            theme: "alert alert-danger",
                            life: 2000
                        });
                    } else {
                        $.jGrowl("Error: Unable to create survey.", {
                            theme: "alert alert-danger",
                            life: 2000
                        });
                    }
                }

            });
        });

     
</script>