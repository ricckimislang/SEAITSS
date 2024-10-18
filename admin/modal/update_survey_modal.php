<div class="modal fade" id="updateSurveyModal" tabindex="-1" role="dialog" aria-labelledby="updateSurveyModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateSurveyModalLabel">Update Survey</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color: red;">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="updateSurveyForm">
                    <!-- Hidden input for user_id and survey_id -->
                    <input type="hidden" name="user_id" id="user_id" value="<?php echo $_SESSION['user_id']; ?>">
                    <input type="hidden" name="survey_id" id="survey_id"> <!-- row id -->

                    <div class="form-group">
                        <label for="office">Select Office</label>
                        <?php
                        $query1 = "SELECT * FROM department";
                        $result1 = mysqli_query($conn, $query1);
                        ?>
                        <select class="form-control" id="office" name="office" required>
                            <?php
                            while ($row1 = mysqli_fetch_assoc($result1)) {
                                echo "<option value='" . $row1['office_name'] . "'>" . $row1['office_name'] . "</option>";
                            }
                            ?>
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
                    <!-- NOTWORKING
                    <div class="form-group">
                        <label for="publish">Publish</label>
                        <select class="form-control" id="publish" name="publish" required>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                        -->

                    <div class="form-group">
                        <label for="start_date">Start Date</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" required>
                    </div>

                    <div class="form-group">
                        <label for="end_date">End Date</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" required>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" id="updateSurveyBtn">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>