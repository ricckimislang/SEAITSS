<?php include 'includes/header.php'; ?>
<link rel="stylesheet" href="css/form.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<?php

// Get survey id from database
$query = "SELECT survey_id FROM surveys WHERE office = ? LIMIT 1";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $_GET['office']);
$stmt->execute();
$stmt->bind_result($survey_id);
$survey_id = $stmt->fetch();
$stmt->close();
?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <form id="respondentInfo">
            <div class="e-card">
                <div class="form-container">
                    <p class="instruction">Please be assured that your responses will be handled anonymously and
                        confidentially. We value your privacy, and your input will be used solely for the purpose of
                        improving our services.</p>
                    <div class="form-group">
                        <input type="hidden" name="surveyID" id="surveyID" value="<?php echo $survey_id; ?>">
                        <label for="eAddress">1. Email Address</label>
                        <input type="email" class="form-control" id="eAddress" name="eAddress" required>
                    </div>
                    <div class="form-group justify-content-center d-flex">
                        <button type="submit" class="btn btn-primary">Next</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

<script>
    $(document).ready(function () {
        // PHP echo to JavaScript variable

        $("#respondentInfo").submit(function (e) {
            e.preventDefault();

            var eAddress = $("#eAddress").val(); // Get the email address from form input
            var surveyId = $("#surveyID").val(); // Get the survey ID from the input field

            // Redirect to survey page with email and survey_id in URL
            window.location.href = "survey.php?survey_id=" + surveyId + "&eAddress=" + encodeURIComponent(eAddress);
        });
    });
</script>