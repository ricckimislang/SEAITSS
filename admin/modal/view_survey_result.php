<div class="modal fade" id="completeSurveyModal" tabindex="-1" role="dialog" aria-labelledby="completeSurveyModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="completeSurveyModalLabel">Survey Results</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="viewSurveyForm">
                    <input type="hidden" name="responseID" id="responseID">
                    <input type="hidden" name="responseID" id="surveyID">

                    <p><strong>Total Responses:</strong> <span id="modalTotalResponses"></span></p>
                    <p><strong>Overall Satisfaction:</strong>
                        <span id="modalSatisfaction"></span>
                        <i class="fas fa-star" data-star="1"></i>
                        <i class="fas fa-star" data-star="2"></i>
                        <i class="fas fa-star" data-star="3"></i>
                        <i class="fas fa-star" data-star="4"></i>
                        <i class="fas fa-star" data-star="5"></i>
                    </p>

                    <div class="table-responsive">
                        <table class="table table-bordered" id="surveyResponseTable" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Question</th>
                                    <th>Feedback</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>