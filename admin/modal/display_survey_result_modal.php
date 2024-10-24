<div class="modal fade" id="completeSurveyModal" role="dialog" aria-labelledby="completeSurveyModalLabel" tabindex="-1"
  aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="completeSurveyModalLabel">Survey Results</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" style="color: red;">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="viewSurveyForm">
          <input type="hidden" name="responseID" id="responseID">
          <input type="hidden" name="surveyID" id="surveyID">

          <p><strong>Total Responses:</strong> <span id="modalTotalResponses"></span></p>
          <div id="scoreDisplay">
            <p></p><strong>Total Score Gained:</strong><span id="totalScoreGained"></span> /<span
              id="totalPossibleScore"></span></p>
          </div>

          <p><strong>Overall Satisfaction:</strong>
            <span id="modalSatisfaction"></span>
            <i class="fas fa-star" data-star="1"></i>
            <i class="fas fa-star" data-star="2"></i>
            <i class="fas fa-star" data-star="3"></i>
            <i class="fas fa-star" data-star="4"></i>
            <i class="fas fa-star" data-star="5"></i>
          </p>

          <div class="row">

            <div class="col">
              <div class="table-responsive">
                <table class="table table-bordered" id="questionResponseTable" style="width:100%">
                  <thead>
                    <tr>
                      <th>Question</th>
                      <th>Average Rating</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="col">
              <div class="table-responsive">
                <table class="table table-bordered" id="surveyResponseTable" style="width:100%">
                  <thead>
                    <tr>
                      <th>Question</th>
                      <th>Recommendation</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="col">
              <div class="table-responsive">
                <table class="table table-bordered" id="complainTable" style="width:100%">
                  <thead>
                    <tr>
                      <th>Question</th>
                      <th>Complaints</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div><!-- End Extra Large Modal-->