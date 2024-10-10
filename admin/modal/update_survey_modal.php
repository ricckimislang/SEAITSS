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
                    <!-- Hidden input for user_id and survey_id -->
                    <input type="hidden" name="user_id" id="user_id" value="<?php echo $_SESSION['user_id']; ?>">
                    <input type="hidden" name="survey_id" id="survey_id"> <!-- row id -->
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



                    <?php
                    $query = "SELECT * FROM surveyquestions WHERE survey_id = ?";
                    if ($stmt = mysqli_prepare($conn, $query)) {
                        mysqli_stmt_bind_param($stmt, "i", $survey_id);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);

                        while ($row = mysqli_fetch_assoc($result)) {
                            $question_id = $row['question_id'];
                            $question_text = $row['question_text'];
                            $question_type = $row['question_type'];
                            echo "
                            <div class='form-group'>
                                <label for='question_text_$question_id'>Question $question_id</label>
                                <input type='text' class='form-control' id='question_text_$question_id' name='questions[$question_id][question_text]' value='$question_text' required>
                            </div>

                            <div class='form-group'>
                                <label for='question_type_$question_id'>Question Type</label>
                                <select class='form-control' id='question_type_$question_id' name='questions[$question_id][question_type]' required>
                                    <option value='input' " . ($question_type == 'input' ? 'selected' : '') . ">Input</option>
                                    <option value='rating' " . ($question_type == 'rating' ? 'selected' : '') . ">Rating</option>
                                </select>
                            </div>
                            ";
                        }

                        mysqli_stmt_close($stmt);
                    } else {
                        echo 'SQL error: Failed to prepare question statement';
                    }
                    ?>

                    <!-- questions -->
                    <div class="form-group">
                        <label for="question_number">Question Number</label>
                        <input type="number" class="form-control" id="question_number" name="question_number" required>
                    </div>

                    <div class="form-group">
                        <label for="question_text">Question Text</label>
                        <textarea class="form-control" id="question_text" name="question_text" rows="3"
                            required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="question_type">Select Type</label>
                        <select class="form-control" id="question_type" name="question_type" required>
                            <option value="input">Input</option>
                            <option value="rating">Rating</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <button type="button" class="btn btn-info btn-sm" id="prevQuestionBtn"><i
                                class="fa fa-arrow-left"></i> Back</button>
                        <button type="button" class="btn btn-info btn-sm" id="nextQuestionBtn">Next <i
                                class="fa fa-arrow-right"></i></button>
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