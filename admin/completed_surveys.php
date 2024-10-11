<?php include 'includes/header.php';
include 'includes/navtop.php'; ?>
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
                    <form action="completed_survey_details.php" method="POST">
                        <div class="form-group text-center">
                            <h3 id="total_responses_text">Total Responses: <span id="total_responses">0</span></h3>
                        </div>
                        <div class="form-group text-center">
                            <h3 id="overall_satisfaction_text">Overall Satisfaction: <span
                                    id="overall_satisfaction"></span> <i class="fas fa-star"></i><i
                                    class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                    class="fas fa-star"></i></h3>
                        </div>
                        <div class="table-responsive">
                            <table id="completed_survey_table" class="table table-striped table-bordered">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Survey Title</th>
                                        <th>Office</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Total Responses</th>
                                        <th>View</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>