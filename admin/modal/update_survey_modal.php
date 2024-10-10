<div class="modal fade" id="updateSurveyModal" tabindex="-1" role="dialog" aria-labelledby="updateSurveyModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateSurveyModalLabel">Update Survey</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="updateSurveyForm">
                    <input type="hidden" name="user_id" id="user_id" value="<?php echo $_SESSION['user_id']; ?>">
                    <input type="hidden" name="survey_id" id="survey_id">

                    <div class="form-group">
                        <label for="office">Select Office</label>
                        <select class="form-control" id="office" name="office">
                            <option value="CICT">CICT OFFICE</option>
                            <option value="SAO">SAO OFFICE</option>
                            <option value="EDUC">EDUCATION OFFICE</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="title">Survey Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>

                    <div class="form-group">
                        <label for="objective">Objective</label>
                        <textarea class="form-control" id="objective" name="objective" rows="3" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="anonymous">Anonymous</label>
                        <select class="form-control" id="anonymous" name="anonymous" required>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="publish">Publish</label>
                        <select class="form-control" id="publish" name="publish" required>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="start_date">Start Date</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" required>
                    </div>

                    <div class="form-group">
                        <label for="end_date">End Date</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" required>
                    </div>

                    <!-- Questions Section -->
                    <div id="questionsContainer"></div>

                    <!-- Navigation buttons -->
                    <div class="form-group">
                        <button type="button" class="btn btn-info btn-sm" id="prevQuestionBtn" style="display:none;">
                            <i class="fa fa-arrow-left"></i> Back
                        </button>
                        <button type="button" class="btn btn-info btn-sm" id="nextQuestionBtn">Next
                            <i class="fa fa-arrow-right"></i>
                        </button>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" id="updateSurveyBtn">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    let questions = [];
    let currentQuestionIndex = 0;

    // Function to load questions into the modal
    function loadQuestions(surveyId) {
        $.ajax({
            type: 'GET',
            url: 'process/get_questions.php', // PHP script to fetch questions
            data: { survey_id: surveyId },
            dataType: 'json',
            success: function (data) {
                questions = data;
                renderQuestion(currentQuestionIndex);
            },
            error: function () {
                alert('Failed to load questions.');
            }
        });
    }

    // Function to render the current question
    function renderQuestion(index) {
        const questionContainer = $('#questionsContainer');
        questionContainer.empty(); // Clear previous questions

        if (questions.length > 0) {
            const question = questions[index];

            questionContainer.append(`
                <div class='form-group'>
                    <label for='question_text_${question.question_id}'>Question ${index + 1}</label>
                    <input type='text' class='form-control' id='question_text_${question.question_id}' name='questions[${question.question_id}][question_text]' value='${question.question_text}' required>
                </div>
                <div class='form-group'>
                    <label for='question_type_${question.question_id}'>Question Type</label>
                    <select class='form-control' id='question_type_${question.question_id}' name='questions[${question.question_id}][question_type]' required>
                        <option value='input' ${question.question_type === 'input' ? 'selected' : ''}>Input</option>
                        <option value='rating' ${question.question_type === 'rating' ? 'selected' : ''}>Rating</option>
                    </select>
                </div>
            `);
        }

        // Toggle navigation buttons
        $('#prevQuestionBtn').toggle(index > 0);
        $('#nextQuestionBtn').toggle(index < questions.length - 1);
    }

    // Next button click
    $('#nextQuestionBtn').on('click', function () {
        if (currentQuestionIndex < questions.length - 1) {
            currentQuestionIndex++;
            renderQuestion(currentQuestionIndex);
        }
    });

    // Previous button click
    $('#prevQuestionBtn').on('click', function () {
        if (currentQuestionIndex > 0) {
            currentQuestionIndex--;
            renderQuestion(currentQuestionIndex);
        }
    });

    // Form submission handling
    $('#updateSurveyForm').on('submit', function (event) {
        event.preventDefault();

        // Use AJAX to send form data to the PHP update script
        $.ajax({
            type: 'POST',
            url: 'process/update_survey.php', // PHP script to handle the update
            data: $(this).serialize(), // Serialize form data
            success: function (response) {
                $('#updateSurveyModal').modal('hide'); // Hide the modal
                location.reload(); // Reload the page to reflect the updates
            },
            error: function (error) {
                alert('Error updating survey. Please try again.');
            }
        });
    });

    // Call this function to load questions when the modal is opened
    $('#updateSurveyModal').on('show.bs.modal', function (event) {
        const surveyId = $(event.relatedTarget).data('survey-id'); // Get survey ID from the button that triggered the modal
        currentQuestionIndex = 0; // Reset index
        loadQuestions(surveyId); // Load questions
    });
</script>
