<?php include 'includes/header.php'; ?>
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
                                <input style="width:10%" label='Yes' type='radio' name='anonymous' value='1'
                                    required><br>
                                <input style="width:10%" label='No' type='radio' name='anonymous' value='0' required>
                            </div>
                            <div class="form-group row radio">
                                <label class="col-sm-3 col-form-label" for="publish">Is Published</label>
                                <input style="width:10%" label='Yes' type='radio' name='publish' value='1' required><br>
                                <input style="width:10%" label='No' type='radio' name='publish' value='0' required>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label" for="start_date">Start Date</label>
                                <input class="col-sm-3 form-control" type='date' name="start_date" id="start_date"
                                    required>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label" for="end_date">End Date</label>
                                <input class="col-sm-3 form-control" type='date' name="end_date" id="end_date" required>
                            </div>
                        </div>



                        <!---question--->
                        <div class="col">
                            <div class=" row">
                                <label for="question_number" id="question_number" class="col-sm-3 ">Number 1</label>
                            </div>

                            <div class="form-group row">
                                <label for="question_text" class="col-sm-3 col-form-label">Question Text</label>
                                <textarea class="form-control" id="question_text" required></textarea>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label" for="question_type">Select Type</label>
                                <select class="form-controloffice" id="question_type">
                                    <option value="input">Input</option>
                                    <option value="rating">Rating</option>
                                </select>
                            </div>

                            <div class="form-group buttons">
                                <button type="button" class="btn btn-primary">Back</button>
                                <button type="button" class="btn btn-primary">Next</button>
                            </div>

                            <button type="submit" class="btn btn-success float-right" id="submit">Submit</button>

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
        $("#create-survey").submit(function (e) {
            e.preventDefault();
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
                    question_number: $("#question_number").val(),
                    question_text: $("#question_text").val(),
                    question_type: $("#question_type").val()
                },
                success: function (data) {
                    alert(data);
                }
            });
        });
    });
</script>