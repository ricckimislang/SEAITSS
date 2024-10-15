<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<?php
include 'includes/header.php';
include 'includes/navtop.php';

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection check
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8");

$username = $_SESSION['username'];
$check = "SELECT * FROM users WHERE username = ?";
$stmt = mysqli_prepare($conn, $check);
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$checkresult = mysqli_stmt_get_result($stmt);
$checkrow = mysqli_fetch_assoc($checkresult);
$_SESSION['user_id'] = $checkrow['user_id'];

//survey table query
$depTable = "SELECT * FROM department";

if ($stmt = mysqli_prepare($conn, $depTable)) {
    mysqli_stmt_execute($stmt);
    $depResult = mysqli_stmt_get_result($stmt);

    mysqli_stmt_close($stmt);
} else {
    echo "Failed to prepare statement: " . mysqli_error($conn);
}

?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<link rel="stylesheet" href="../css/departments.css">
<style>
    .card {
        display: flex !important;
        flex-direction: column !important;
        justify-content: space-between !important;
        height: auto !important;
    }

    .btn-group {
        display: flex !important;
        justify-content: center !important;
        margin-top: auto !important;
    }
</style>

<div class="container-fluid mt-5">
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Add Department</div>
                            <form id="addDepartmentForm">
                                <div class="form-group">
                                    <label for="departmentName">Department Name</label>
                                    <input type="text" class="form-control" id="departmentName" name="departmentName"
                                        required style="text-transform: uppercase;"
                                        oninput="this.value = this.value.toUpperCase()">
                                </div>
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-success">Add Department</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-9 col-md-6 mb-4">
            <div class="card border-left-warning shadow py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Departments</div>
                            <table id="departmentTable" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Department Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="departmentBody">
                                    <?php while ($depRow = mysqli_fetch_assoc($depResult)) { ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($depRow['office_name']); ?></td>
                                            <td>
                                                <div class="btn">
                                                    <button type="button" class="btn btn-warning" data-toggle="modal"
                                                        data-target="#updateDepartmentModal"
                                                        onclick="updateDepartment('<?php echo $depRow['department_id']; ?>')">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-danger"
                                                        onclick="deleteDepartment('<?php echo $depRow['department_id']; ?>')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
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

    <?php include 'modal/update_department_modal.php'; ?>
    <?php include 'includes/footer.php'; ?>

    <script>
        $(document).ready(function () {
            $('#departmentTable').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });

            // Load departments into the DataTable


            // Handle department addition
            $("#addDepartmentForm").submit(function (e) {
                e.preventDefault();
                $.ajax({
                    url: "process/add_department.php",
                    type: "POST",
                    data: {
                        departmentName: $("#departmentName").val(),
                    },
                    dataType: "json",
                    success: function (data) {
                        if (data.status === 'success') {
                            $.jGrowl("Department added successfully!", {
                                theme: "alert alert-success",
                                life: 2000
                            });
                            setTimeout(function () {
                                window.location.href = "departments.php";
                            })
                        } else if (data.status === 'duplicate') {
                            $.jGrowl("Error: Department already exists!", {
                                theme: "alert alert-danger",
                                life: 2000
                            });
                        } else {
                            $.jGrowl("Error: Unable to add department.", {
                                theme: "alert alert-danger",
                                life: 2000
                            });
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("AJAX Error: ", status, error);
                        $.jGrowl("Error: An unexpected error occurred.", {
                            theme: "alert alert-danger",
                            life: 2000
                        });
                    }
                });
            });
        });
    </script>