<!DOCTYPE html>
<html lang="en">
<?php session_start();
include_once 'includes/dbconn.php';

$username = $_SESSION['username'];

if (!isset($_SESSION['username'])) {
    header("location: ../index.php");
}
$check = "SELECT * FROM users WHERE username = '$username'";
$checkresult = mysqli_query($conn, $check);
$checkrow = mysqli_fetch_assoc($checkresult);
$_SESSION['user_id'] = $checkrow['user_id'];

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SEAIT SATISFACTION SURVERY</title>
</head>

<link rel="stylesheet" href="css/bootstrap.min.css">

<body>