<?php include 'includes/header.php'; ?>
<?php include 'includes/dbconn.php'; ?>

<?php
// Fetch questions from the database
$query = "SELECT * FROM surveyquestions";
$result = mysqli_query($conn, $query);
?>

<link rel="stylesheet" href="css/survey.css">
<link rel="stylesheet" href="css/radio-button.css">

<div class="container mt-5">
    <div class="row justify-content-center">
        <form method="POST" action="submit_survey.php">
            <div class="e-card">
                <div class="form-title">Office Satisfaction Survey</div> <!-- OFFICE NAME -->
                <div class="form-container">
                    <?php while ($row = mysqli_fetch_assoc($result)) {
                        $question_text = $row['question_text'];
                        $question_id = $row['question_id'];
                        $question_type = $row['question_type']; ?>

                        <div class="form-group">
                            <label for="question_<?php echo $question_id; ?>"><?php echo $question_text; ?></label>

                            <?php
                            if ($question_type == 'input') {
                                // Show a text input
                                echo "<input type='text' class='form-control' id='question_$question_id' name='answer[$question_id]' required>";
                            } elseif ($question_type == 'radio') {
                                // Show radio button options 1-4
                                echo "<div class='form-check radio'>";
                                echo "<input label='1' checked='' type='radio' name='answer[$question_id]' value='1' required><br>";
                                echo "<input label='2' checked='' type='radio' name='answer[$question_id]' value='2' required><br>";
                                echo "<input label='3' checked='' type='radio' name='answer[$question_id]' value='3' required><br>";
                                echo "<input label='4' checked='' type='radio' name='answer[$question_id]' value='4' required><br>";
                                echo "<input label='5' checked='' type='radio' name='answer[$question_id]' value='5' required><br>";
                                echo "</div>";
                            }
                            ?>
                        </div>
                    <?php } ?>

                    <div class="form-group buttons">
                        <a href="form.php"><button type="button" class="btn btn-primary">Back</button></a>
                        <button type="submit" class="btn btn-primary">Next</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>