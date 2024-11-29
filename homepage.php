<?php
include 'includes/header.php';
include 'includes/dbconn.php';

// Improved error handling and security
$scanQR = filter_input(INPUT_GET, 'scannedQRCode');
if (!$scanQR) {
    displayError("Please Scan The QR CODE", "Please Scan The QR CODE to take the survey");
    exit;
}

// Improved database query with prepared statement
$query = "SELECT s.*, 
          (SELECT COUNT(*) FROM surveyresponses 
           WHERE survey_id = s.survey_id 
           AND student_id = ? 
           AND submitted_at >= NOW() - INTERVAL 7 DAY) as has_responded
          FROM surveys s 
          WHERE is_published = 1 AND is_complete = 0";

$stmt = $conn->prepare($query);
$stmt->bind_param("s", $scanQR);
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    displayError("Database Error", "Unable to fetch surveys. Please try again later.");
    exit;
}

$surveys = $result->fetch_all(MYSQLI_ASSOC);

function displayError($title, $message) {
    echo '<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>';
    echo "<script>
        swal({
            title: '" . htmlspecialchars($title) . "',
            text: '" . htmlspecialchars($message) . "',
            icon: 'error',
            button: 'OK',
        }).then(function() {
            window.location.href = 'index.php';
        });
    </script>";
}
?>

<link rel="stylesheet" href="css/index-card.css">
<link rel="stylesheet" href="css/homepage.css">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            <div class="e-card playing">
                <div class="background-image" style="background-image: url(assets/image/seait.jpg)"></div>
                <h2 class="mt-3 text-white text-center">Available Surveys</h2>
                
                <div class="survey-list">
                    <?php if (empty($surveys)): ?>
                        <div class="no-surveys">
                            <h3>No surveys available today.</h3>
                            <p>Please check back later for new surveys.</p>
                        </div>
                    <?php else: ?>
                        <div class="survey-grid">
                            <?php foreach ($surveys as $survey): ?>
                                <div class="survey-card <?php echo $survey['has_responded'] ? 'completed' : ''; ?>">
                                    <div class="survey-header">
                                        <h3><?php echo htmlspecialchars($survey['title']); ?></h3>
                                        <?php if ($survey['has_responded']): ?>
                                            <span class="status-badge">Completed</span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <div class="survey-content">
                                        <p><?php echo htmlspecialchars($survey['objective']); ?></p>
                                        
                                        <?php if (!$survey['has_responded']): ?>
                                            <a class="pushable " href="<?php 
                                                echo "form.php?scannedQRCode=" . urlencode($scanQR) . "&survey_id=" . $survey['survey_id']
                                            ?>"style="text-decoration: none; color: inherit;"> 
                                                <span class="shadow"></span>
                                                <span class="edge"></span>
                                                <span class="front">Take Survey</span>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
