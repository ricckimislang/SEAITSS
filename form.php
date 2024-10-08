<?php include 'includes/header.php'; ?>
<link rel="stylesheet" href="css/form.css">
<div class="container mt-5">
    <div class="row justify-content-center">
        <form>
            <div class="e-card">
                <div class="form-container">
                    <p class="instruction" >Please be assured that your responses will be handled anonymously and confidentially. We value
                        your privacy, and your input will be used solely for the purpose of improving our services.</p>
                    <div class="form-group">
                        <label for="name">1. Name of Respondent</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="course">2. Course</label>
                        <select class="form-control" id="course" name="course" required>
                            <option value="">-- Select Course --</option>
                            <option value="INFORMATION TECHNOLOGY">INFORMATION TECHNOLOGY</option>
                            <option value="ACCOUNTING INFORMATION SYSTEM">ACCOUNTING INFORMATION SYSTEM</option>
                            <option value="CRIM">CRIM</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="year-level">3. Year Level</label>
                        <select class="form-control" id="year-level" name="year-level" required>
                            <option value="">-- Select Year Level --</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="gender">4. Gender</label>
                        <input type="text" class="form-control" id="gender" name="gender" required>
                    </div>
                    <div class="form-group">
                        <label for="email">5. Email Address</label>
                        <input type="text" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Back</button>
                       <a href="survey.php"> <button type="button" class="btn btn-primary">Next</button></a>
                    </div>
                </div>
            </div>
        </form>

    </div>
</div>
<?php include 'includes/footer.php'; ?>