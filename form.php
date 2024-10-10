<?php include 'includes/header.php'; ?>
<link rel="stylesheet" href="css/form.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<div class="container mt-5">
    <div class="row justify-content-center">
        <form method="POST" action="survey.php">
            <div class="e-card">
                <div class="form-container">
                    <p class="instruction">Please be assured that your responses will be handled anonymously and
                        confidentially. We value your privacy, and your input will be used solely for the purpose of
                        improving our services.</p>
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
                            <option value="1">1st Year</option>
                            <option value="2">2nd Year</option>
                            <option value="3">3rd Year</option>
                            <option value="4">4th Year</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="gender">4. Gender</label><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="male" value="Male" required>
                            <label class="form-check-label" for="male">Male</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="female" value="Female"
                                required>
                            <label class="form-check-label" for="female">Female</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="other" value="Other"
                                required>
                            <label class="form-check-label" for="other">Other</label>
                        </div>
                        <div id="other-gender" style="display: none;">
                            <input type="text" class="form-control" id="other-gender-txt" name="other-gender"
                                placeholder="Please specify">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">5. Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Next</button>
                    </div>
                </div>
            </div>
        </form>

    </div>
</div>
<?php include 'includes/footer.php'; ?>