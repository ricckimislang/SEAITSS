<?php include 'includes/header.php'; ?>
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

                    <img class="seait-logo" src="assets/image/logo.png" alt="SEAIT Logo"><br>
                    WELCOME TO SEAIT SATISFACTION SURVEY
                    <br>
                    <div class="name">SOUTH EAST ASIAN INSTITUTE OF TECHNOLOGY</div>
                    <br>
                    <div class="form-groupoffice">
                        <label for="office">Select Office</label>
                        <select class="form-controloffice" id="office" name="office"> <!-- Added name attribute -->
                            <option value="IT" <?php if (isset($_GET['office']) && $_GET['office'] == 'IT')
                                echo 'selected'; ?>>IT OFFICE</option>
                            <option value="SAO" <?php if (isset($_GET['office']) && $_GET['office'] == 'SAO')
                                echo 'selected'; ?>>SAO OFFICE</option>
                            <option value="EDUC" <?php if (isset($_GET['office']) && $_GET['office'] == 'EDUC')
                                echo 'selected'; ?>>EDUCATION OFFICE</option>
                        </select>
                    </div>
                    <button type="button" class="btn btn-next btn-primary" id="proceedButton">Proceed</button>
                    <!-- Removed <a> tag -->
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('proceedButton').addEventListener('click', function () {
        var selectedOffice = document.getElementById('office').value; // Get the selected office value
        window.location.href = 'homepage.php?office=' + encodeURIComponent(selectedOffice); // Redirect with the selected office in the URL
    });
</script>

<?php include 'includes/footer.php'; ?>