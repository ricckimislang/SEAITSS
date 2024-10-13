<?php include 'includes/header.php';
$office_id = $_GET['office'] ?? '';

?>
<link rel="stylesheet" href="css/index-card.css">
<div class="container mt-5">
    <div class="row justify-content-center">
        <form id="officeForm"> <!-- Give the form an ID -->
            <div class="e-card playing">
                <div class="background-image" style="background-image: url(assets/image/seait.jpg)">

                </div>
                <!-- Waves and content -->
                <div class="wave"></div>
                <div class="wave"></div>

                <!-- Info overlay -->
                <div class="infotop">
                    <input type="hidden" value="<?php echo $office_id; ?>" name="officeID" id="officeID">
                    <img class="seait-logo" src="assets/image/logo.png" alt="SEAIT Logo"><br>
                    WELCOME TO SEAIT SATISFACTION SURVEY
                    <br>
                    <div class="name">SOUTH EAST ASIAN INSTITUTE OF TECHNOLOGY</div>
                    <br>

                    <button type="button" class="btn btn-next btn-primary" id="proceedButton">Proceed</button>
                    <!-- Removed <a> tag -->
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    document.getElementById('proceedButton').addEventListener('click', function () {
        // Get the selected office value from the dropdown
        const selectedOffice = document.getElementById('officeID').value;

        // Redirect to a new URL with the office ID as a parameter
        window.location.href = 'homepage.php?office=' + selectedOffice;
    });
</script>
<?php include 'includes/footer.php'; ?>