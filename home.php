<?php include 'includes/header.php';
include 'includes/navtop.php';

$username = $_SESSION['username'];

$check = "SELECT * FROM users WHERE username = '$username'";
$checkresult = mysqli_query($conn, $check);
$checkrow = mysqli_fetch_assoc($checkresult);
$_SESSION['user_id'] = $checkrow['user_id'];

?>
<link rel="stylesheet" href="css/home.css">
<link rel="stylesheet" href="css/radio-button.css">
<div class="container mt-5">
    <div class="row justify-content-center">
       
    </div>
</div>
<?php include 'includes/footer.php'; ?>
