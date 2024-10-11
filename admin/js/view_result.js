$(document).ready(function () {
  $("#CompletedSurveys_table").DataTable();
});
$(document).ready(function () {
  $("#surveyResponseTable").DataTable();
});

function openResultModal(surveyId, responseId) {
  // Set the values in the modal form
  $("#viewSurveyForm #surveyID").val(surveyId);
  $("#viewSurveyForm #responseID").val(responseId);
  // Show the modal
  $("#completeSurveyModal").modal("show");
}
