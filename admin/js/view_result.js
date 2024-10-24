$(document).ready(function () {
  // Initialize DataTable for the CompletedSurveys_table
  $("#CompletedSurveys_table").DataTable();
});

// Function to open result modal and display the survey response
function openResultModal(surveyId, responseIds, totalresponses) {
  // Set the survey ID in the modal form
  $("#viewSurveyForm #surveyID").val(surveyId);
  $("#viewSurveyForm #responseID").val(responseIds);

  // Clear the previous table data
  $("#surveyResponseTable tbody").empty();
  $("#questionResponseTable tbody").empty();
  $("#complainTable tbody").empty();

  // Destroy the existing DataTable instance if it exists
  if ($.fn.DataTable.isDataTable("#questionResponseTable")) {
    $("#questionResponseTable").DataTable().clear().destroy();
  }
  if ($.fn.DataTable.isDataTable("#surveyResponseTable")) {
    $("#surveyResponseTable").DataTable().clear().destroy();
  }
  if ($.fn.DataTable.isDataTable("#complainTable")) {
    $("#complainTable").DataTable().clear().destroy();
  }

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
        totalResponses = totalresponses;
        overallSatisfaction += responseData.overallSatisfaction;

        // Loop through the survey questions and populate the "Survey Response Table"
        responseData.survey_questions.forEach(function (question) {
          $("#surveyResponseTable tbody").append(`
        <tr>
          <td>${question.description}</td>
          <td>${question.response}</td>
        </tr>
      `);
        });

        // Loop through the complain questions and populate the "Complain Table"
        responseData.complain_questions.forEach(function (question) {
          $("#complainTable tbody").append(`
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

      // Re-initialize the DataTable after data is loaded into the table
      $("#surveyResponseTable").DataTable({
        pageLength: 5,
        // You can add any options here to customize the DataTable (e.g., pagination, searching)
        searching: true, // Enable searching
        paging: true, // Enable pagination
        info: true, // Show table information
        lengthChange: false, // Disable the option to change number of rows per page
      });
      // Re-initialize the DataTable after data is loaded into the table
      $("#questionResponseTable").DataTable({
        pageLength: 5,
        // You can add any options here to customize the DataTable (e.g., pagination, searching)
        searching: true, // Enable searching
        paging: true, // Enable pagination
        info: true, // Show table information
        lengthChange: false,
      });

      // Re-initialize the DataTable after data is loaded into the table
      $("#complainTable").DataTable({
        pageLength: 5,
        // You can add any options here to customize the DataTable (e.g., pagination, searching)
        searching: true, // Enable searching
        paging: true, // Enable pagination
        info: true, // Show table information
        lengthChange: false,
      });

      // Show the modal after data is loaded
      $("#completeSurveyModal").modal("show");
    })
    .catch(() => {
      alert("Failed to load survey response data. Please try again.");
    });

  function fetchAllQuestions(surveyId) {
    // Make an AJAX request to fetch all questions for the survey
    $.ajax({
      url: "process/fetch_average_questions.php", // Adjust the URL to your backend script
      type: "GET",
      data: { survey_id: surveyId }, // Send the survey ID as a parameter
      success: function (data) {
        const questionsData = JSON.parse(data); // Parse the JSON response from the server

        // Loop through the questions and populate the table
        questionsData.forEach(function (question) {
          const averageRating = question.average_rating
            ? question.average_rating.toFixed(2)
            : "N/A"; // Handle cases with no rating
          $("#questionResponseTable tbody").append(`
              <tr>
                <td>${question.question_text}</td>
                <td>${averageRating}</td>
              </tr>
            `);
        });
      },
      error: function (error) {
        console.error("Error fetching questions: ", error);
      },
    });
  }

  fetchAllQuestions(surveyId);

  function fetchTotalScores(surveyId) {
    $.ajax({
      url: "process/fetch_total_score_gained.php", // URL to the PHP script
      type: "GET",
      data: { survey_id: surveyId }, // Send the survey ID as a parameter
      success: function (data) {
        const scoresData = JSON.parse(data); // Parse the JSON response from the server

        if (scoresData.total_score_gained && scoresData.total_possible_score) {
          // Display the total score gained and total possible score
          $("#totalScoreGained").text(` ${scoresData.total_score_gained}`);
          $("#totalPossibleScore").text(` ${scoresData.total_possible_score}`);
        } else {
          // Handle case when scores are not available
          $("#totalScoreGained").text("N/A");
          $("#totalPossibleScore").text("N/A");
        }
      },
      error: function (error) {
        console.error("Error fetching total scores: ", error);
      },
    });
  }

  // Example of calling the function when the document is ready or when you want to fetch the scores
  fetchTotalScores(surveyId);
}
// AJAX function to fetch the total score gained for each question in the survey

function updateStarRating(rating) {
  // Clear existing star ratings
  $(".fas.fa-star").removeClass("filled half-filled"); // Assuming "filled" and "half-filled" are CSS classes to fill the star

  // Round down to nearest whole number for star filling
  let fullStars = Math.floor(rating);

  // Loop through stars and apply the 'filled' class to the correct ones
  for (let i = 1; i <= 5; i++) {
    if (i <= fullStars) {
      $(`.fas.fa-star[data-star='${i}']`).addClass("filled");
    } else if (i === fullStars + 1 && rating % 1 !== 0) {
      $(`.fas.fa-star[data-star='${i}']`).addClass("half-filled");
    }
  }
}
