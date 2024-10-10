<?php include 'includes/header.php';
include 'includes/navtop.php';

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
}



?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="../css/home.css">
<div class="container-fluid mt-5">
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Surveys</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php echo mysqli_num_rows($surveyresult); ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-poll fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer py-3">
                    <a href="" class="btn btn-primary btn-block">View</a>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Active Surveys
                            </div>
                            <?php
                            $activesurveys = "SELECT * FROM surveys WHERE end_date > NOW() OR is_published = 0";
                            if ($stmt = mysqli_prepare($conn, $activesurveys)) {
                                mysqli_stmt_execute($stmt);
                                $activesurveyresult = mysqli_stmt_get_result($stmt);
                                mysqli_stmt_close($stmt);
                            }
                            ?>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php echo mysqli_num_rows($activesurveyresult); ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-poll fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer py-3">
                    <a href="" class="btn btn-success btn-block">View</a>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Completed Surveys</div>
                            <?php
                            $completeurveys = "SELECT * FROM surveys WHERE end_date < NOW() AND is_published = 1";
                            if ($stmt = mysqli_prepare($conn, $completeurveys)) {
                                mysqli_stmt_execute($stmt);
                                $completeurveyresult = mysqli_stmt_get_result($stmt);
                                mysqli_stmt_close($stmt);
                            }
                            ?>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php echo mysqli_num_rows($completeurveyresult); ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-square fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer py-3">
                    <a href="" class="btn btn-info btn-block">View</a>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Responses</div>
                            <?php
                            $surveyresponses = "SELECT COUNT(*) AS total_responses FROM surveyresponses";
                            if ($stmt = mysqli_prepare($conn, $surveyresponses)) {
                                mysqli_stmt_execute($stmt);
                                $surveyresponsesresult = mysqli_stmt_get_result($stmt);
                                $surveyresponsesrow = mysqli_fetch_assoc($surveyresponsesresult);
                                mysqli_stmt_close($stmt);
                            }
                            ?>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php echo $surveyresponsesrow['total_responses']; ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer py-3">
                    <a href="" class="btn btn-warning btn-block">View</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center w-100">
                        <div class="col-12">
                            <!-- Table structure -->

                            <table id="surveyTable" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Office</th>
                                        <th>Title</th>
                                        <th>Objective</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Anonymous</th>
                                        <th>Published</th>
                                        <th>Responses</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php while ($surveyrow = mysqli_fetch_assoc($surveyresult)) { ?>
                                        <tr>
                                            <td><?php echo $surveyrow['office']; ?></td>
                                            <td><?php echo $surveyrow['title']; ?></td>
                                            <td><?php echo $surveyrow['objective']; ?></td>
                                            <td><?php echo $surveyrow['start_date']; ?></td>
                                            <td><?php echo $surveyrow['end_date']; ?></td>
                                            <td>
                                                <button
                                                    class="btn btn-sm btn-<?php echo $surveyrow['is_anonymous'] == 1 ? 'success' : 'danger'; ?>"
                                                    onclick="changeAnonymous(<?php echo $surveyrow['survey_id']; ?>, <?php echo $surveyrow['is_anonymous']; ?>)">
                                                    <?php echo $surveyrow['is_anonymous'] == 1 ? 'Anonymous' : 'Not Anonymous'; ?>
                                                </button>
                                            </td>
                                            <td>
                                                <button
                                                    class="btn btn-sm btn-<?php echo $surveyrow['is_published'] == 1 ? 'success' : 'danger'; ?>"
                                                    onclick="changePublished(<?php echo $surveyrow['survey_id']; ?>, <?php echo $surveyrow['is_published']; ?>)">
                                                    <?php echo $surveyrow['is_published'] == 1 ? 'Published' : 'Not published'; ?>
                                                </button>
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
                                            <td>
                                                <button href="#" class="btn btn-sm btn-primary"
                                                    onclick="openEditModal(<?php echo $surveyrow['survey_id']; ?>, '<?php echo addslashes($surveyrow['office']); ?>', '<?php echo addslashes($surveyrow['title']); ?>', '<?php echo addslashes($surveyrow['objective']); ?>', '<?php echo $surveyrow['start_date']; ?>', '<?php echo $surveyrow['end_date']; ?>')"><i
                                                        class="fas fa-edit"></i></button>

                                                <button class="btn btn-sm btn-danger"
                                                    onclick="deleteSurvey(<?php echo $surveyrow['survey_id']; ?>)"><i
                                                        class="fas fa-trash"></i></button>
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

    <?php include 'modal/update_survey_modal.php'; ?>

    <?php include 'includes/footer.php'; ?>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#surveyTable').DataTable({
                "paging": true,           // Enable pagination
                "searching": true,        // Enable search functionality
                "pageLength": 10,         // Show 10 rows per page
                "lengthChange": true,    // Disable the option to change number of rows per page
                "ordering": true,         // Enable column sorting
                "info": true              // Show table information
            });
        });

        function openEditModal(surveyId, office, title, objective, startDate, endDate) {
            // Set the values in the modal form
            $('#updateSurveyForm #survey_id').val(surveyId);
            $('#updateSurveyForm #office').val(office).trigger('change');
            $('#updateSurveyForm #title').val(title);
            $('#updateSurveyForm #objective').val(objective);
            $('#updateSurveyForm #start_date').val(startDate);
            $('#updateSurveyForm #end_date').val(endDate);

            // Show the modal
            $('#updateSurveyModal').modal('show');
        }

        // Submit form handling
        $('#updateSurveyBtn').on('click', function (event) {
            event.preventDefault();

            // Use AJAX to send form data to your PHP update script
            $.ajax({
                type: 'POST',
                url: 'process/update_survey.php', // Your PHP update script
                data: $('#updateSurveyForm').serialize(),
                success: function (response) {
                    // Handle success response (e.g., show a success message, refresh table)
                    $('#updateSurveyModal').modal('hide');
                    location.reload(); // Reload the page to see updates
                },
                error: function (error) {
                    // Handle error response
                    alert('Error updating survey. Please try again.');
                }
            });
        });

    </script>