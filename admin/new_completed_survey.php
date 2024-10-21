<?php
include 'includes/newheader.php';

mysqli_set_charset($conn, "utf8");

$username = $_SESSION['username'];
$check = "SELECT * FROM users WHERE username = '$username'";
$checkresult = mysqli_query($conn, $check);
$checkrow = mysqli_fetch_assoc($checkresult);
$_SESSION['user_id'] = $checkrow['user_id'];



// Query to fetch surveys
$query = "SELECT * FROM surveys WHERE is_complete = '1'";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Initialize an array to hold response IDs
$response_ids = [];

?>
<!-- Include Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="../css/newhome.css">
<link rel="stylesheet" href="../css/new_create_form.css">
<style>
    .breadcrumb {
        background-color: transparent;
    }
</style>

<body>
    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">
        <div class="d-flex align-items-center justify-content-between">
            <a href="index.html" class="logo d-flex align-items-center">
                <img src="assets/img/logo.png" alt="">
                <span class="d-none d-lg-block">SEAITSS</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->
        <?php include 'includes/new-nav-top.php'; ?>
    </header><!-- End Header -->
    <!-- ======= Sidebar ======= -->
    <?php include 'includes/newsidebar.php'; ?>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Dashboard</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">
                <!-- Left side columns -->
                <div class="col-lg-12">
                    <!-- Survey Table -->
                    <div class="col-12">
                        <div class="card recent-sales overflow-auto">
                            <div class="card-body">
                                <h5 class="card-title">Survey Table</h5>

                                <table id="CompletedSurveys_table" class="datatable display">
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
                                                    $totalrespo = "SELECT * FROM surveyresponses WHERE survey_id = ?";
                                                    $stmtrespo = $conn->prepare($totalrespo);
                                                    $stmtrespo->bind_param("i", $completerow['survey_id']);
                                                    $stmtrespo->execute();
                                                    $totalresporesult = $stmtrespo->get_result();

                                                    // Fetch all response IDs and store them in the array
                                                    while ($responserow = $totalresporesult->fetch_assoc()) {
                                                        $response_ids[] = $responserow['response_id'];
                                                    }
                                                    $totalresponses = mysqli_num_rows($totalresporesult);
                                                    echo $totalresponses;
                                                    ?>
                                                </td>
                                                <td>
                                                    <button type="button" href="#"
                                                        class="btn btn-sm btn-primary view-results-btn"
                                                        onclick="openResultModal('<?php echo addslashes($completerow['survey_id']); ?>', [<?php echo implode(',', $response_ids); ?>], '<?php echo addslashes($totalresponses); ?>')"><i
                                                            class="fas fa-eye"></i>&nbsp;View
                                                        Results</button>

                                                </td>
                                            </tr>
                                            <?php
                                            // Reset the response_ids array for the next survey
                                            $response_ids = [];
                                            ?>
                                        <?php } ?>
                                    </tbody>
                                </table>

                            </div>

                        </div>
                    </div>
                </div>
            </div><!-- End Left side columns -->
        </section>

    </main><!-- End #main -->


    <!-- modal -->
    <?php include 'modal/display_survey_result_modal.php'; ?>


    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>



    <!-- Template Main JS File -->
    <script src="../js/main.js"></script>
    <script src="js/view_result.js"></script>



    <?php include 'includes/footer.php'; ?>

</body>

</html>