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
                                        <th>Status</th>
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
                                            <td id="anonymous_status_<?php echo $surveyrow['survey_id']; ?>">
                                                <button
                                                    class="btn btn-sm btn-<?php echo $surveyrow['is_anonymous'] == 1 ? 'success' : 'danger'; ?>"
                                                    onclick="changeAnonymous(<?php echo $surveyrow['survey_id']; ?>, <?php echo $surveyrow['is_anonymous']; ?>)">
                                                    <?php echo $surveyrow['is_anonymous'] == 1 ? 'Anonymous' : 'Not Anonymous'; ?>
                                                </button>

                                                <script>
                                                    function changeAnonymous(survey_id, current_is_anonymous) {
                                                        var new_is_anonymous = current_is_anonymous ? 0 : 1;
                                                        $.ajax({
                                                            url: "process/update_anonymous.php",
                                                            method: "GET",
                                                            data: {
                                                                survey_id: survey_id,
                                                                is_anonymous: new_is_anonymous
                                                            },
                                                            dataType: "json",
                                                            success: function (response) {
                                                                if (response.is_anonymous !== undefined) {
                                                                    $('#anonymous_status_' + survey_id).html(
                                                                        `<button class="btn btn-sm btn-${response.is_anonymous == 1 ? 'success' : 'danger'}" onclick="changeAnonymous(${survey_id}, ${response.is_anonymous})">${response.is_anonymous == 1 ? 'Anonymous' : 'Not Anonymous'}</button>`
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
                                                <button
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
                                                <button
                                                    class="btn btn-sm btn-<?php echo $surveyrow['end_date'] < date('Y-m-d') ? 'danger' : 'success'; ?>"
                                                    onclick="changeOpen(<?php echo $surveyrow['survey_id']; ?>, <?php echo $surveyrow['end_date'] < date('Y-m-d') ? 1 : 0; ?>)">
                                                    <?php echo $surveyrow['end_date'] < date('Y-m-d') ? 'CLOSED' : 'OPEN'; ?>
                                                </button>
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
</div>

<?php include 'modal/update_survey_modal.php'; ?>

<?php include 'includes/footer.php'; ?>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<script src="js/fetch_question.js"></script>