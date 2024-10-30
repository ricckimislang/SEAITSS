<?php
include 'includes/header.php';
include 'includes/dbconn.php';

$scanQR = $_GET['scannedQRCode'] ?? null;
if (is_null($scanQR)) {
    echo '<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>';
    echo '<script>
        swal({
            title: "Please Scan The QR CODE again",
            text: "Please Scan The QR CODE to take the survey",
            icon: "error",
            button: "OK",
        }).then(function() {
            window.location.href = "index.php";
        });
    </script>';
    exit;
}

// Prepare the query to fetch surveys
$query = "SELECT * FROM surveys WHERE is_published = 1 AND is_complete = 0";

// Execute the query
$result = $conn->query($query);

// Check for errors
if ($result === false) {
    die("Error: " . $conn->error);
}

// Fetch all published surveys
$surveys = $result->fetch_all(MYSQLI_ASSOC);
?>

<link rel="stylesheet" href="css/index-card.css">
<link rel="stylesheet" href="css/homepage.css">
<div class="container mt-5">
    <div class="row justify-content-center">
        <form>
            <div class="e-card playing">
                <div class="background-image" style="background-image: url(assets/image/seait.jpg)"></div>
                <h2 class="text-center" style="color: white;">Available Surveys</h2>
                <div class="survey-list" style="margin: 20px; margin-bottom: 30px; overflow-y: auto;">
                    <ul class="list-group">
                        <?php if (empty($surveys)): ?>
                            <h1 class="text-center" style="color:white;">No surveys available today.</h1>
                        <?php else: ?>
                            <?php foreach ($surveys as $survey): ?> <!-- Loop through each survey -->
                                <li class="list-group-item transparent-card">
                                    <h3><?php echo htmlspecialchars($survey['title']); ?></h3>
                                    <div class="divider"></div>
                                    <br>

                                    <?php
                                    $survey_id = $survey['survey_id']; // Use your survey ID variable
                                    $qrcode = $_GET['scannedQRCode'] ?? null;


                                    // Query to check if the respondent has taken the survey within the last week
                                    $response_check_query = "SELECT COUNT(*) as count FROM surveyresponses 
                                                              WHERE student_id = ? AND survey_id = ? 
                                                              AND submitted_at >= NOW() - INTERVAL 7 DAY";

                                    $stmt = mysqli_stmt_init($conn);
                                    if (!mysqli_stmt_prepare($stmt, $response_check_query)) {
                                        echo 'Error preparing statement';
                                        exit;
                                    }

                                    mysqli_stmt_bind_param($stmt, "si", $qrcode, $survey_id); // Use $mac here
                                    mysqli_stmt_execute($stmt);
                                    $result = mysqli_stmt_get_result($stmt);
                                    $response_count = mysqli_fetch_assoc($result)['count'];

                                    // Check if the respondent has already taken the survey
                                    if ($response_count > 0) {
                                        // Respondent has taken the survey within the week
                                        echo '<p>You have already completed this survey in the past week.</p>';
                                        // Hide the objective since the survey is already taken
                                    } else {
                                        // Respondent can take the survey
                                        echo '<p>' . htmlspecialchars($survey['objective']) . '</p>'; // Show the objective
                                        ?>
                                        <a class="pushable float-right"
                                            href="<?php echo $survey['is_anonymous'] == 1 ? 'survey.php?scannedQRCode=' . $scanQR . '&survey_id=' . $survey['survey_id'] : 'form.php'; ?>">
                                            <span class="shadow"></span>
                                            <span class="edge"></span>
                                            <span class="front"> Take Survey </span>
                                        </a>
                                        <?php
                                    }
                                    ?>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>