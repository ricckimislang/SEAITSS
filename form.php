<?php include 'includes/header.php'; ?>
<link rel="stylesheet" href="css/form.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<?php
$scanQr = $_GET['scannedQRCode'] ?? NULL;
$surveyId = $_GET['survey_id'] ?? NULL;


// Get survey id from the database
$query = "SELECT survey_id FROM surveys WHERE office = ? LIMIT 1";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $office);
$stmt->execute();
$stmt->bind_result($survey_id);
if ($stmt->fetch()) {
    // Successfully fetched survey_id
} else {
    $survey_id = NULL;
}
$stmt->close();

?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="e-card">
            <div class="content-container">
                <div class="header-section">
                    <img src="assets/image/logo.png" alt="SEAIT Logo" class="seait-logo">
                    <h2>Welcome to SEAIT Survey System</h2>
                </div>
                
                <div class="instruction-section">
                    <h3>Before You Begin</h3>
                    <div class="instruction-points">
                        <div class="point">
                            <i class="fas fa-shield-alt"></i>
                            <p>Your responses will be handled with complete anonymity and confidentiality.</p>
                        </div>
                        <div class="point">
                            <i class="fas fa-chart-bar"></i>
                            <p>Your feedback helps us improve our services and educational experience.</p>
                        </div>
                        <div class="point">
                            <i class="fas fa-clock"></i>
                            <p>The survey takes approximately 5-10 minutes to complete.</p>
                        </div>
                        <div class="point">
                            <i class="fas fa-check-circle"></i>
                            <p>Please answer all questions honestly and to the best of your ability.</p>
                        </div>
                    </div>
                </div>

                <div class="action-section">
                    <a href="survey.php?scannedQRCode=<?php echo urlencode($scanQr); ?>&survey_id=<?php echo $surveyId; ?>" class="proceed-btn" style="text-decoration: none;">
                        Proceed to Survey
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>