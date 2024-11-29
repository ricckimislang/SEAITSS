<?php
include 'includes/newheader.php';

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
mysqli_set_charset($conn, "utf8");

$username = $_SESSION['username'];
$check = "SELECT * FROM users WHERE username = '$username'";
$checkresult = mysqli_query($conn, $check);
$checkrow = mysqli_fetch_assoc($checkresult);
$_SESSION['user_id'] = $checkrow['user_id'];


//survey table query
$surveytable = "SELECT * FROM surveys";

if ($stmt = mysqli_prepare($conn, $surveytable)) {
    mysqli_stmt_execute($stmt);
    $surveyresult = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
} else {
    echo "Failed to prepare statement: " . mysqli_error($conn);
}
?>

<link rel="stylesheet" href="../css/newhome.css">
<link rel="stylesheet" href="../css/new_create_form.css">

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
                            <div class="filter" style="margin-right: 20px;">
                                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#createSurveyModal" style="font-size: 1.1em;"><i
                                        class="bi bi-plus-circle-fill"></i>
                                    Add</button>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title">Survey Table</h5>

                                <table id="surveyTable" class="table datatable" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th scope="col">Office Name</th>
                                            <th scope="col">Title</th>
                                            <th scope="col">Objective</th>
                                            <th scope="col">Start Date</th>
                                            <th scope="col">End Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($surveyrow = mysqli_fetch_assoc($surveyresult)) { ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($surveyrow['office'], ENT_QUOTES, 'UTF-8'); ?>
                                                </td>
                                                <td><?php echo htmlspecialchars($surveyrow['title'], ENT_QUOTES, 'UTF-8'); ?>
                                                </td>
                                                <td><?php echo htmlspecialchars($surveyrow['objective'], ENT_QUOTES, 'UTF-8'); ?>
                                                </td>
                                                <td><?php echo htmlspecialchars($surveyrow['start_date'], ENT_QUOTES, 'UTF-8'); ?>
                                                </td>
                                                <td><?php echo htmlspecialchars($surveyrow['end_date'], ENT_QUOTES, 'UTF-8'); ?>
                                                </td>
                                            </tr>
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
    <?php include 'modal/create_survey_modal.php'; ?>


    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <?php include 'includes/footer.php'; ?>
    <!-- Template Main JS File -->
    <script src="../js/main.js"></script>
    <script src="js/fetch_question.js"></script>





</body>

</html>