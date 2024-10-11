$(document).ready(function () {
  $("#surveyTable").DataTable({
    paging: true, // Enable pagination
    searching: true, // Enable search functionality
    pageLength: 10, // Show 10 rows per page
    lengthChange: true, // Disable the option to change number of rows per page
    ordering: true, // Enable column sorting
    info: true, // Show table information
  });
});

function openEditModal(surveyId, office, title, objective, startDate, endDate) {
  // Set the values in the modal form
  $("#updateSurveyForm #survey_id").val(surveyId);
  $("#updateSurveyForm #office").val(office).trigger("change");
  $("#updateSurveyForm #title").val(title);
  $("#updateSurveyForm #objective").val(objective);
  $("#updateSurveyForm #start_date").val(startDate);
  $("#updateSurveyForm #end_date").val(endDate);

  // Show the modal
  $("#updateSurveyModal").modal("show");
}

// Submit form handling
$("#updateSurveyBtn").on("click", function (event) {
  event.preventDefault();

  // Use AJAX to send form data to your PHP update script
  $.ajax({
    type: "POST",
    url: "process/update_survey.php", // Your PHP update script
    data: $("#updateSurveyForm").serialize(),
    success: function (response) {
      // Handle success response (e.g., show a success message, refresh table)
      $("#updateSurveyModal").modal("hide");
      location.reload(); // Reload the page to see updates
    },
    error: function (error) {
      // Handle error response
      alert("Error updating survey. Please try again.");
    },
  });
});

// Declare variables only once
let currentQuestionIndex = 0;
let questions = []; // Will hold the fetched questions
let editedQuestions = {}; // Will store edited questions

// Fetch questions when modal is opened
$("#updateSurveyModal").on("show.bs.modal", function (e) {
  let surveyId = $("#survey_id").val(); // Ensure this has the correct value
  if (surveyId) {
    console.log("Survey ID:", surveyId); // Log the survey ID to ensure it's correct
    fetchQuestions(surveyId);
  } else {
    console.error("Survey ID is missing or invalid");
  }
});

// AJAX call to fetch questions based on survey_id
function fetchQuestions(surveyId) {
  $.ajax({
    url: "process/fetch_questions.php", // Backend script to fetch questions
    method: "POST",
    data: { survey_id: surveyId },
    dataType: "json",
    success: function (data) {
      console.log("Response from server:", data); // Debugging step
      if (data.success) {
        questions = data.questions; // Store questions globally
        displayQuestion(0); // Display the first question
      } else {
        console.error("Failed to fetch questions:", data.error); // Log the error message
      }
    },
    error: function (xhr, status, error) {
      console.error("AJAX error:", error); // Log any AJAX errors
    },
  });
}

// Function to display a question dynamically in the modal
function displayQuestion(index) {
  if (index >= 0 && index < questions.length) {
    currentQuestionIndex = index;

    $("#questionId").text(`Question ID: ${questions[index].question_id}`);
    // Update the question label to show the correct question number
    $("#questionLabel").text(`Question Number ${index + 1}`);

    // Populate the text area and dropdown with the current question's text and type
    $("#question_text").val(questions[index].question_text);
    $("#question_type").val(questions[index].question_type);
  }
}

// "Next" button functionality
$("#nextQuestionBtn").on("click", function () {
  if (currentQuestionIndex < questions.length - 1) {
    storeEditedQuestion(); // Store the current question data before moving to the next
    displayQuestion(currentQuestionIndex + 1);
  }
});

// "Previous" button functionality
$("#prevQuestionBtn").on("click", function () {
  if (currentQuestionIndex > 0) {
    storeEditedQuestion(); // Store the current question data before moving to the previous
    displayQuestion(currentQuestionIndex - 1);
  }
});

// Store the currently edited question in an object
function storeEditedQuestion() {
  let questionId = questions[currentQuestionIndex].question_id;

  // Store the current question's updated text and type
  editedQuestions[questionId] = {
    question_text: $("#question_text").val(),
    question_type: $("#question_type").val(),
  };
}

// Handle form submission
$("#updateSurveyBtn").on("click", function (event) {
  event.preventDefault(); // Prevent default form submission

  storeEditedQuestion(); // Store the last edited question

  // Use AJAX to send form data along with edited questions to your PHP update script
  $.ajax({
    type: "POST",
    url: "process/update_survey.php", // Your PHP update script
    data: {
      survey_id: $("#survey_id").val(), // Send survey_id
      office: $("#office").val(),
      title: $("#title").val(),
      objective: $("#objective").val(),
      anonymous: $("#anonymous").val(),
      publish: $("#publish").val(),
      start_date: $("#start_date").val(),
      end_date: $("#end_date").val(),
      edited_questions: JSON.stringify(editedQuestions), // Send edited questions
    },
    success: function (response) {
      // Handle success response (e.g., show a success message, refresh table)
      console.log("Survey updated successfully:", response);
      $("#updateSurveyModal").modal("hide");
      location.reload(); // Reload the page to see updates
    },
    error: function (error) {
      // Handle error response
      alert("Error updating survey. Please try again.");
      console.error("Update error:", error);
    },
  });
});
