<?php
include 'includes/header.php';
include 'includes/dbconn.php';

$office_id = $_GET['office'] ?? '';

// Prepare the query to fetch surveys
$query = "SELECT * FROM surveys WHERE is_published = 1";

// Execute the query
$result = $conn->query($query);

// Check for errorss
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
                <div class="background-image" style="background-image: url(assets/image/seait.jpg)">
                </div>
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
                                    <p><?php echo htmlspecialchars($survey['objective']); ?></p>
                                    <!-- Redirect based on the is_anonymous field -->
                                    <a class="pushable float-right"
                                        href="<?php echo $survey['is_anonymous'] == 1 ? 'survey.php?survey_id=' . $survey['survey_id'] : 'form.php'; ?>">
                                        <span class="shadow"></span>
                                        <span class="edge"></span>
                                        <span class="front"> Take Survey </span>
                                    </a>
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