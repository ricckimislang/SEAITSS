<?php include 'includes/header.php';

?>

<link rel="stylesheet" href="../css/index-card-admin.css">
<div class="container mt-5">
    <div class="row justify-content-center">
        <form id="login-form">
            <div class="e-card playing">
                <div class="background-image" style="background-image: url(../assets/image/seait.jpg)">
                </div>
                <!-- Waves and content -->
                <div class="wave"></div>
                <div class="wave"></div>

                <!-- Info overlay -->
                <div class="infotop">
                    <img class="seait-logo" src="../assets/image/logo.png" alt="SEAIT Logo"><br>
                    WELCOME TO SEAIT SATISFACTION SURVEY
                    <br>
                    <div class="name">SOUTH EAST ASIAN INSTITUTE OF TECHNOLOGY</div>
                    <br>
                    <div class="form-groupoffice">
                        <label for="office">Username</label>
                        <input type="text" class="form-controloffice" id="username" name="username">
                    </div>
                    <label for="office">&nbsp;Password</label>
                    <input type="password" class="form-controloffice" id="password" name="password">
                    <br>
                    <button type="submit" class="btn btn-login btn-primary">Login</button>
                </div>

            </div>
        </form>
    </div>
</div>




<?php include 'includes/footer.php'; ?>

<script>
    $(document).ready(function () {
        $('#login-form').submit(function (e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '../process/login_process.php',
                data: $(this).serialize(),
                success: function (data) {
                    console.log(data); // This will print the response to the browser's console
                    if (data == '1') {
                        window.location.href = 'newhome.php';
                    } else {
                        alert('Invalid username or password');
                    }
                }

            });
        });
    });
</script>