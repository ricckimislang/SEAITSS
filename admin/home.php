<?php include 'includes/header.php';
include 'includes/navtop.php';

$username = $_SESSION['username'];
$check = "SELECT * FROM users WHERE username = '$username'";
$checkresult = mysqli_query($conn, $check);
$checkrow = mysqli_fetch_assoc($checkresult);
$_SESSION['user_id'] = $checkrow['user_id'];
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
                            <div class="h5 mb-0 font-weight-bold text-gray-800">5</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-poll fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer py-3">
                    <a href="users.php" class="btn btn-primary btn-block">View</a>
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
                            <div class="h5 mb-0 font-weight-bold text-gray-800">5</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-poll fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer py-3">
                    <a href="categories.php" class="btn btn-success btn-block">View</a>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Completed Surveys</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">5</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-square fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer py-3">
                    <a href="posts.php" class="btn btn-info btn-block">View</a>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Responses</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">5</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer py-3">
                    <a href="comments.php" class="btn btn-warning btn-block">View</a>
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
                                    <th>Survey ID</th>
                                    <th>Title</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Responses</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Example table data. You can dynamically populate this with PHP -->
                                <tr>
                                    <td>1</td>
                                    <td>Satisfaction Survey</td>
                                    <td>2024-01-15</td>
                                    <td>2024-02-15</td>
                                    <td>120</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Office Survey</td>
                                    <td>2024-01-20</td>
                                    <td>2024-02-20</td>
                                    <td>90</td>
                                </tr>
                                <!-- More rows as needed -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


    <?php include 'includes/footer.php'; ?>

    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#surveyTable').DataTable({
            "paging": true,           // Enable pagination
            "searching": true,        // Enable search functionality
            "pageLength": 10,         // Show 10 rows per page
            "lengthChange": true,    // Disable the option to change number of rows per page
            "ordering": true,         // Enable column sorting
            "info": true              // Show table information
        });
    });
</script>
