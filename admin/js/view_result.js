$(document).ready(function () {
  $("#CompletedSurveys_table").DataTable();
});

$(document).ready(function () {
  $("#surveyResponseTable").DataTable();
});

// Update the function to accept an array of response IDs
function openResultModal(surveyId, responseIds, totalresponses) {
  // Set the survey ID in the modal form
  $("#viewSurveyForm #surveyID").val(surveyId);
  $("#viewSurveyForm #responseID").val(responseIds);

  // Clear the previous table data
  $("#surveyResponseTable tbody").empty();

  // Prepare a variable to hold total responses and overall satisfaction
  let totalResponses = 0;
  let overallSatisfaction = 0;

  // Create a promise array to handle multiple AJAX requests
  const ajaxRequests = responseIds.map((responseId) => {
    return $.ajax({
      url: "process/fetch_response_details.php", // Adjust this URL to your backend script
      type: "GET",
      data: { survey_id: surveyId, response_id: responseId }, // Send parameters
    });
  });

  // Execute all AJAX requests
  Promise.all(ajaxRequests)
    .then((responses) => {
      responses.forEach((data) => {
        const responseData = JSON.parse(data);

        // Accumulate total responses and overall satisfaction
        totalResponses = totalresponses
        overallSatisfaction += responseData.overallSatisfaction;

        // Populate DataTable with the fetched questions and responses
        responseData.questions.forEach(function (question) {
          $("#surveyResponseTable tbody").append(`
            <tr>
              <td>${question.description}</td>
              <td>${question.response}</td>
            </tr>
          `);
        });
      });

      // Set accumulated values in the modal
      $("#modalTotalResponses").text(totalResponses);
      $("#modalSatisfaction").text(
        Number(overallSatisfaction / responseIds.length).toFixed(2)
      ); // Average overall satisfaction with 2 decimal places

      // Update star rating display
      updateStarRating(
        Number(overallSatisfaction / responseIds.length).toFixed(2)
      );

      // Show the modal after data is loaded
      $("#completeSurveyModal").modal("show");
    })
    .catch(() => {
      alert("Failed to load survey response data. Please try again.");
    });
}

function updateStarRating(rating) {
  // Clear existing star ratings
  $(".fas.fa-star").removeClass("filled"); // Assuming "filled" is a CSS class to fill the star

  // Fill stars based on the rating
  for (let i = 1; i <= 5; i++) {
    if (i <= rating) {
      $(`.fas.fa-star[data-star='${i}']`).addClass("filled");
    }
  }
}
