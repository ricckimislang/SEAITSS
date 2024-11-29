<?php
include 'includes/newheader.php';

mysqli_set_charset($conn, "utf8");

if (!isset($_SESSION['username'])) {
    // Handle the error, e.g., redirect to login
    header("Location: login.php");
    exit();
}
$username = $_SESSION['username'];
$check = "SELECT * FROM users WHERE username = ?";
$stmt = mysqli_prepare($conn, $check);
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$checkresult = mysqli_stmt_get_result($stmt);
$checkrow = mysqli_fetch_assoc($checkresult);
$_SESSION['user_id'] = $checkrow['user_id'];

// Survey table query
$depTable = "SELECT * FROM department";

if ($stmt = mysqli_prepare($conn, $depTable)) {
    mysqli_stmt_execute($stmt);
    $depResult = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
} else {
    echo "Failed to prepare statement: " . mysqli_error($conn);
}
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
    <?php include ('includes/newsidebar.php'); ?>
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
                <div class="row">

                    <!-- Department Table -->
                    <div class="col-9">
                        <div class="card recent-sales">
                            <div class="card-body">
                                <h5 class="card-title">Department Management</h5>
                                <div class="table-responsive">
                                    <table id="departmentTable" class="datatable display">
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
                                                        <div class="btn-group">
                                                             <?php /* <button type="button" class="btn btn-warning me-2" data-toggle="modal"
                                                                onclick="updateDepartmentmodal('<?php echo $depRow['department_id']; ?>', '<?php echo htmlspecialchars($depRow['office_name']); ?>')">
                                                                <i class="fas fa-edit"></i> Edit
                                                            </button> */ ?>

                                                            <button type="button" class="btn btn-danger"
                                                                onclick="deleteDepartment('<?php echo $depRow['department_id']; ?>')">
                                                                <i class="fas fa-trash"></i> Delete
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
                    <!-- Add Department Card -->
                    <div class="col-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Add New Department</h5>
                                <form id="addDepartmentForm">
                                    <div class="form-group">
                                        <label for="departmentName">
                                            <i class="fas fa-building me-2"></i>Department Name
                                        </label>
                                        <input type="text" class="form-control" id="departmentName"
                                            name="departmentName" required 
                                            placeholder="Enter department name"
                                            style="text-transform: uppercase;"
                                            oninput="this.value = this.value.toUpperCase()">
                                    </div>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-plus me-2"></i>Add Department
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- End Left side columns -->
        </section>

    </main><!-- End #main -->

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="color: red;">&times;</span>
                    </button>
                </div>
                <form id="deleteForm">
                    <input type="hidden" id="department_delete_id" name="department_delete_id">
                    <div class="modal-body">
                        Are you sure you want to delete this department?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger" id="confirmDelete">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include 'modal/update_department_modal.php'; ?>

    <!-- modal -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>
    <!-- Template Main JS File -->
    <script src="../js/main.js"></script>
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
        });
    </script>
    <script>
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
                            theme: "alert alert-error",
                            life: 2000
                        });
                        setTimeout(function () {
                            location.reload();
                        }, 2000); // Notice the comma goes after the function, not inside it.

                    } else if (data.status === 'duplicate') {
                        $.jGrowl("Error: Department already exists!", {
                            theme: "alert alert-error",
                            life: 2000
                        });
                        $("button[type='submit']").attr("disabled", false);
                    } else {
                        $.jGrowl("Error: Unable to add department.", {
                            theme: "alert alert-error",
                            life: 2000
                        });
                        // Enable the button again if there is an error
                        $("button[type='submit']").attr("disabled", false);
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error: ", status, error);
                    $.jGrowl("Error: An unexpected error occurred.", {
                        theme: "alert alert-success",
                        life: 2000
                    });
                    // Enable the button again in case of AJAX error
                    $("button[type='submit']").attr("disabled", false);
                }
            });
        });

    </script>
    <script>
        /* Handle department update modal opening
        function updateDepartmentmodal(departmentId, departmentName) {
            $('#department_update_id').val(departmentId);
            $('#department_update_name').val(departmentName);
            $('#updateDepartment').modal('show');
        };
        // Handle department update
        $("#updateDepartmentForm").submit(function (e) {
            e.preventDefault();
            $.ajax({
                url: "process/update_department.php",
                type: "POST",
                data: {
                    department_update_name: $("#department_update_name").val(),
                    department_update_id: $("#department_update_id").val(),
                },
                dataType: "json",
                success: function (data) {
                    if (data.status === 'success') {
                        $.jGrowl("Department updated successfully!", {
                            theme: "alert alert-success",
                            life: 2000
                        });
                        setTimeout(function () {
                            window.location.href = "new_department.php";
                        }, 2000)
                    } else if (data.status === 'duplicate') {
                        $.jGrowl("Error: Department already exists!", {
                            theme: "alert alert-success",
                            life: 2000
                        });
                    } else {
                        $.jGrowl("Error: Unable to update department.", {
                            theme: "alert alert-success",
                            life: 2000
                        });
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error: ", status, error);
                    $.jGrowl("Error: An unexpected error occurred.", {
                        theme: "alert-danger",
                        life: 2000
                    });
                }
            });
        }); */
    </script>
    <script>
        function deleteDepartment(departmentId) {
            $('#department_delete_id').val(departmentId);
            $('#deleteModal').modal('show');
        }
        $("#deleteForm").submit(function (e) {
            e.preventDefault();
            $.ajax({
                url: "process/delete_department.php",
                type: "POST",
                data: {
                    department_delete_id: $("#department_delete_id").val(),
                },
                dataType: "json",
                success: function (data) {
                    if (data.status === 'success') {
                        $.jGrowl("Department deleted successfully!", {
                            theme: "alert alert-success",
                            life: 1000
                        });
                        setTimeout(function () {
                            window.location.href = "new_department.php";
                        }, 1000);
                    }
                    else {
                        $.jGrowl("Error: Unable to delete department.", {
                            theme: "alert alert-success",
                            life: 1000
                        });
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error: ", status, error);
                    $.jGrowl("Error: An unexpected error occurred.", {
                        theme: "alert alert-success",
                        life: 2000
                    });
                }

            });
        });
    </script>
</body>

</html>
