<?php
include 'includes/header.php';
include 'includes/navtop.php';

// Query to fetch surveys
$query = "SELECT * FROM surveys WHERE is_complete = '1'";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

?>

<!-- Include Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="../css/completed_surveys.css">

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="CompletedSurveys_table" class="display">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Office</th>
                                    <th>Survey Title</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Total Responses</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($completerow = mysqli_fetch_array($result)) { ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($completerow['office']); ?></td>
                                        <td><?php echo htmlspecialchars($completerow['title']); ?></td>
                                        <td><?php echo htmlspecialchars($completerow['start_date']); ?></td>
                                        <td><?php echo htmlspecialchars($completerow['end_date']); ?></td>
                                        <td>
                                            <?php
                                            // Initialize an array to store response IDs
                                            $response_ids = array();

                                            // Query to get responses for the current survey
                                            $totalrespo = "SELECT response_id FROM surveyresponses WHERE survey_id = ?";
                                            $stmtrespo = $conn->prepare($totalrespo);
                                            $stmtrespo->bind_param("i", $completerow['survey_id']);
                                            $stmtrespo->execute();
                                            $totalresporesult = $stmtrespo->get_result();

                                            // Loop through the responses and store each response_id in the array
                                            while ($responserow = $totalresporesult->fetch_assoc()) {
                                                $response_ids[] = $responserow['response_id'];
                                            }

                                            // Display total number of responses
                                            echo count($response_ids);
                                            ?>
                                        </td>
                                        <td>
                                            <!-- Pass response IDs array to JavaScript when the button is clicked -->
                                            <button type="button" class="btn btn-sm btn-primary view-results-btn"
                                                onclick="openResultModal(<?php echo json_encode($response_ids); ?>, '<?php echo $completerow['survey_id']; ?>')">
                                                <i class="fas fa-eye"></i>&nbsp;View Results
                                            </button>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'modal/view_survey_result.php'; ?>
<?php include 'includes/footer.php'; ?>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="js/view_result.js"></script>