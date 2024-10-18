<div class="modal fade" id="createSurveyModal" tabindex="-1" role="dialog" aria-labelledby="createSurveyModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createSurveyModalLabel">Create Survey</h5>
                <a class="btn close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color: red;">&times;</span>
                </a>
            </div>
            <div class="modal-body">
                <form id="createSurveyForm">
                    <div class="form-group">
                        <label for="office">Select Office</label>
                        <?php
                        $query = "SELECT * FROM department";
                        $result = mysqli_query($conn, $query);
                        ?>
                        <select class="form-control" id="office" name="office">
                            <?php
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='" . htmlspecialchars($row['office_name'], ENT_QUOTES, 'UTF-8') . "'>" . htmlspecialchars($row['office_name'], ENT_QUOTES, 'UTF-8') . "</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="survey_title">Survey Title</label>
                        <input type="text" class="form-control" id="survey_title" name="survey_title" required>
                    </div>

                    <div class="form-group">
                        <label for="objective">Objective</label>
                        <textarea class="form-control" id="objective" name="objective" rows="3" required></textarea>
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
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" id="createSurveyBtn">Create Survey</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>