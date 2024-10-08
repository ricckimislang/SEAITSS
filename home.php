<?php include 'includes/header.php'; ?>
<link rel="stylesheet" href="css/home.css">
<link rel="stylesheet" href="css/radio-button.css">
<div class="container mt-5">
    <div class="row justify-content-center">
        <form>
            <div class="e-card">
                <div class="form-title">Office Satisfaction Survey</div> <!-- OFFICE NAME -->
                <div class="form-container">

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="office">Select Office</label>
                        <select class="form-controloffice" id="office">
                            <option>CICT OFFICE</option>
                            <option>SAO OFFICE</option>
                            <option>EDUCATION OFFICE</option>
                        </select>
                    </div>
                    <div class="form-group row">
                        <label for="survey_title" class="col-sm-2 col-form-label">Title</label>
                        <input type="text" class="form-controloffice" id="survey_title">
                    </div>
                    <div class="form-group row">
                        <label for="objective" class="col-sm-2 col-form-label">Objective</label>
                        <input type="text" class="form-controloffice" id="objective">
                    </div>
                    <div class="form-group row radio">
                        <label class="col-sm-2 col-form-label" for="office">Is Anonymous</label>
                        <input style="width:10%" label='Yes' checked='' type='radio' name='answer[$question_id]'
                            value='yes' required><br>
                        <input style="width:10%" label='No' checked='' type='radio' name='answer[$question_id]'
                            value='no' required>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="office">Start Date</label>
                        <input class="col-sm-2 form-control" type='date' required>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="office">End Date</label>
                        <input class="col-sm-2 form-control" type='date' required>
                    </div>
                </div>
        </form>
    </div>
</div>
<?php include 'includes/footer.php'; ?>