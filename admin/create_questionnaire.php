<?php
include 'includes/newheader.php';

mysqli_set_charset($conn, "utf8");

$username = $_SESSION['username'];
$check = "SELECT * FROM users WHERE username = '$username'";
$checkresult = mysqli_query($conn, $check);
$checkrow = mysqli_fetch_assoc($checkresult);
$_SESSION['user_id'] = $checkrow['user_id'];



?>

<link rel="stylesheet" href="../css/newhome.css">
<link rel="stylesheet" href="../css/create_questionnaire.css">

<body>
    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">
        <div class="d-flex align-items-center justify-content-between">
            <a href="newhome.php" class="logo d-flex align-items-center">
                <img src="../assets/image/logo.png" alt="">
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
                    <div class="row">
                        <!-- Survey Table -->

                        <!-- Improved Questionnaire Creation Section -->
                        <div class="col-12">
                            <div class="card recent-sales overflow-auto">
                                <div class="card-body">
                                    <h5 class="card-title">Create Questionnaire</h5>

                                    <form id="questionnaireForm" method="POST" action="process/insert_questionnaire.php" class="needs-validation" novalidate>
                                        <div class="row g-3">
                                            <!-- Department Selection -->
                                            <div class="col-md-4">
                                                <div class="form-floating">
                                                    <select class="form-select" id="department_id" name="department_id" required>
                                                        <option value="">Select Department</option>
                                                        <?php
                                                        $query = "SELECT * FROM department";
                                                        $result = mysqli_query($conn, $query);
                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                            echo "<option value='" . htmlspecialchars($row['department_id'], ENT_QUOTES, 'UTF-8') . "'>"
                                                                . htmlspecialchars($row['office_name'], ENT_QUOTES, 'UTF-8') . "</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                    <label for="department_id">Department</label>
                                                    <div class="invalid-feedback">Please select a department</div>
                                                </div>
                                            </div>

                                            <!-- Questions Container -->
                                            <div class="col-12" id="questionsContainer">
                                                <!-- First Question Section -->
                                                <div class="question-section card mb-3 p-3 border shadow-none">
                                                    <div class="row g-3">
                                                        <!-- Question Number -->
                                                        <div class="col-md-8">
                                                            <label class="form-label">Question #1</label>
                                                        </div>

                                                        <!-- Question Type -->
                                                        <div class="col-md-4">
                                                            <div class="form-floating">
                                                                <select class="form-select question-type" name="question_type[]" required>
                                                                    <option value="rating">Rating (5 points)</option>
                                                                    <option value="recommendation">Recommendation</option>
                                                                    <option value="complaint">Complaint</option>
                                                                </select>
                                                                <label>Question Type</label>
                                                                <div class="invalid-feedback">Select question type</div>
                                                            </div>
                                                        </div>


                                                    </div>
                                                    <div class="row mt-2">
                                                        <!-- Question Description -->
                                                        <div class="col">
                                                            <div class="form-floating">
                                                                <textarea class="form-control question-description"
                                                                    name="question_text[]"
                                                                    placeholder="Enter Question Text"
                                                                    required></textarea>
                                                                <label>Question Text</label>
                                                                <div class="invalid-feedback">Enter Question Text</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Action Buttons -->
                                            <div class="col-12 d-flex justify-content-between">
                                                <button type="button" id="addQuestionBtn" class="btn btn-outline-primary">
                                                    <i class="bi bi-plus-circle me-1"></i>Add Question
                                                </button>
                                                <button type="submit" class="btn btn-success">
                                                    <i class="bi bi-save me-1"></i>Create Questionnaire
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>

                </div><!-- End Left side columns -->
        </section>

    </main><!-- End #main -->




    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <?php include 'includes/footer.php'; ?>
    <!-- Template Main JS File -->
    <script src="../js/main.js"></script>
    <script>
        $(document).ready(function() {
            $("#surveyTable").DataTable({
                paging: true, // Enable pagination
                searching: true, // Enable search functionality
                pageLength: 10, // Show 10 rows per page
                lengthChange: true, // Disable the option to change number of rows per page
                ordering: true, // Enable column sorting
                info: true, // Show table information
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add Question Functionality
            let questionCounter = 1;
            $('#addQuestionBtn').on('click', function() {
                questionCounter++;
                const newQuestionSection = `
                <div class="question-section card mb-3 p-3 border shadow-none">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label">
                                Question #${questionCounter}
                            </label>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating">
                                <select class="form-select question-type" name="question_type[]" required>
                                    <option value="rating">Rating (5 points)</option>
                                    <<option value="recommendation">Recommendation</option>
                                    <option value="complaint">Complaint</option>
                                </select>
                                <label>Question Type</label>
                                <div class="invalid-feedback">Select question type</div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col">
                            <div class="form-floating">
                                <textarea class="form-control question-description"
                                          name="question_text[]"
                                          placeholder="Enter Question Text"
                                          required></textarea>
                                <label>Question Text </label>
                                <div class="invalid-feedback">Enter Question Text</div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
                $('#questionsContainer').append(newQuestionSection);
            });

            // Handle form submission
            $('#questionnaireForm').on('submit', function(e) {
                e.preventDefault(); // Prevent the default form submission

                // Serialize form data
                const formData = $(this).serialize();

                // AJAX request
                $.ajax({
                    url: 'process/insert_questionnaire.php', // Change this to your PHP file
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            // Display success message
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: response.message,
                                timer: 2000,
                                timerProgressBar: true,
                                onClose: () => {
                                    // Optionally redirect or refresh
                                    window.location.href = response.redirectUrl;
                                }
                            });
                        } else {
                            // Display error message
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: response.message,
                            });
                        }
                    },
                    error: function(xhr) {
                        // Handle AJAX errors
                        const errorResponse = JSON.parse(xhr.responseText);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: errorResponse.message,
                        });
                    }
                });
            });
        });
    </script>
</body>

</html>