<?php include 'includes/header.php'; ?>
<link rel="stylesheet" href="css/index-card.css">
<div class="container mt-5">
    <div class="row justify-content-center">
        <form>
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
                        <label for="office">Username</label>
                        <input type="text" class="form-controloffice" id="username" >
                    </div>
                    <label for="office">&nbsp;Password</label>
                    <input type="text" class="form-controloffice" id="Password" >
                    <br>
                    <a href="form.php"> <button type="button" class="btn btn-next btn-primary">start now</button></a>
                </div>

            </div>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>