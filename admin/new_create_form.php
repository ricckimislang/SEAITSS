<?php
include 'includes/newheader.php';

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
                            <div class="filter">
                                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#createSurveyModal">Add</button>
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>

                                    <li><a class="dropdown-item" href="#">Today</a></li>
                                    <li><a class="dropdown-item" href="#">This Month</a></li>
                                    <li><a class="dropdown-item" href="#">This Year</a></li>
                                </ul>
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
                                            <th scope="col">Responses</th>
                                            <th scope="col">Status</th>
                                            <th scope="col-2">Action</th>
                                            <th></th>
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
                                                <td>
                                                    <?php
                                                    $surveyresponses = "SELECT * FROM surveyresponses WHERE survey_id = ?";
                                                    $stmt = $conn->prepare($surveyresponses);
                                                    $stmt->bind_param("i", $surveyrow['survey_id']);
                                                    $stmt->execute();
                                                    $surveyresponsesresult = $stmt->get_result();
                                                    $stmt->close();
                                                    echo mysqli_num_rows($surveyresponsesresult);
                                                    ?>
                                                </td>

                                                <td id="open_status_<?php echo $surveyrow['survey_id']; ?>">
                                                    <button data-survey-id="<?php echo $surveyrow['survey_id']; ?>"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        data-bs-original-title="Open/Close"
                                                        class="btn btn-sm btn-<?php echo $surveyrow['is_complete'] == 1 ? 'danger' : 'success'; ?>"
                                                        onclick="confirmChangeOpen(<?php echo $surveyrow['survey_id']; ?>, <?php echo $surveyrow['is_complete']; ?>)">
                                                        <?php echo $surveyrow['is_complete'] == 1 ? 'CLOSED' : 'OPEN'; ?>
                                                    </button>

                                                    <script>
                                                        function confirmChangeOpen(survey_id, current_is_closed) {
                                                            var confirmOpen = current_is_closed == 0
                                                                ? 'Are you sure you want to close this survey? Students won\'t be able to view this survey anymore.'
                                                                : 'Are you sure you want to open this survey?';

                                                            Swal.fire({
                                                                title: 'Confirmation',
                                                                text: confirmOpen,
                                                                icon: 'warning',
                                                                showCancelButton: true,
                                                                confirmButtonColor: '#3085d6',
                                                                cancelButtonColor: '#d33',
                                                                confirmButtonText: 'Yes, Confirm!'
                                                            }).then((result) => {
                                                                if (result.isConfirmed) {
                                                                    changeOpen(survey_id, current_is_closed);
                                                                }
                                                            });
                                                        }

                                                        function changeOpen(survey_id, current_is_closed) {
                                                            var new_is_closed = current_is_closed ? 0 : 1; // Toggle closure status
                                                            $.ajax({
                                                                url: "process/update_open.php",
                                                                method: "GET",
                                                                data: {
                                                                    survey_id: survey_id,
                                                                    is_closed: new_is_closed
                                                                },
                                                                dataType: "json",
                                                                success: function (response) {
                                                                    if (response.status === 'success') {
                                                                        $('#open_status_' + survey_id).html(
                                                                            `<button class="btn btn-sm btn-${response.is_closed == 1 ? 'danger' : 'success'}" onclick="confirmChangeOpen(${survey_id}, ${response.is_closed})">${response.is_closed == 1 ? 'CLOSED' : 'OPEN'}</button>`
                                                                        );
                                                                        Swal.fire(
                                                                            'Success',
                                                                            'Closure status updated successfully!',
                                                                            'success'
                                                                        );
                                                                    } else {
                                                                        console.error("Unexpected response:", response);
                                                                    }
                                                                },
                                                                error: function (xhr, status, error) {
                                                                    console.error("AJAX Error:", error);
                                                                }
                                                            });
                                                        }
                                                    </script>
                                                </td>

                                                <td id="published_status_<?php echo $surveyrow['survey_id']; ?>">
                                                    <button data-survey-id="<?php echo $surveyrow['survey_id']; ?>"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        data-bs-original-title="publish/unpublish"
                                                        class="btn btn-sm btn-<?php echo $surveyrow['is_published'] == 1 ? 'success' : 'danger'; ?>"
                                                        onclick="changePublished(<?php echo $surveyrow['survey_id']; ?>, <?php echo $surveyrow['is_published']; ?>)">
                                                        <?php echo $surveyrow['is_published'] == 1 ? 'Published' : 'Not published'; ?>
                                                    </button>

                                                    <script>
                                                        function changePublished(survey_id, current_is_published) {
                                                            var new_is_published = current_is_published ? 0 : 1;
                                                            $.ajax({
                                                                url: "process/update_publish.php",
                                                                method: "GET",
                                                                data: {
                                                                    survey_id: survey_id,
                                                                    is_published: new_is_published
                                                                },
                                                                dataType: "json",
                                                                success: function (response) {
                                                                    if (response.is_published !== undefined) {
                                                                        $('#published_status_' + survey_id).html(
                                                                            `<button class="btn btn-sm btn-${response.is_published == 1 ? 'success' : 'danger'}" onclick="changePublished(${survey_id}, ${response.is_published})">${response.is_published == 1 ? 'Published' : 'Not Published'}</button>`
                                                                        );
                                                                    } else {
                                                                        console.error("Unexpected response:", response);
                                                                    }
                                                                },
                                                                error: function (xhr, status, error) {
                                                                    console.error("AJAX Error:", error);
                                                                }
                                                            });
                                                        }
                                                    </script>
                                                </td>

                                                <td>
                                                    <button href="#" class="btn btn-sm btn-primary" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" data-bs-original-title="Edit"
                                                        onclick="openEditModal(<?php echo $surveyrow['survey_id']; ?>, '<?php echo addslashes($surveyrow['office']); ?>', '<?php echo addslashes($surveyrow['title']); ?>', '<?php echo addslashes($surveyrow['objective']); ?>', '<?php echo $surveyrow['start_date']; ?>', '<?php echo $surveyrow['end_date']; ?>')"><i
                                                            class="bi bi-tools"></i></button>

                                                    <button class="btn btn-sm btn-danger deleteSurveyBtn"
                                                        data-survey-id="<?php echo $surveyrow['survey_id']; ?>"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        data-bs-original-title="Delete">
                                                        <i class="bi bi-trash"></i>
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
            </div><!-- End Left side columns -->
        </section>

    </main><!-- End #main -->


    <!-- modal -->
    <?php include 'modal/create_survey_modal.php'; ?>
    

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="../assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/vendor/chart.js/chart.umd.js"></script>
    <script src="../assets/vendor/echarts/echarts.min.js"></script>
    <script src="../assets/vendor/quill/quill.js"></script>
    <script src="../assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="../assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="../assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="../js/main.js"></script>





</body>

</html>