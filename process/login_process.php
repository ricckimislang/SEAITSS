<?php
session_start();

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);



    $user = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $user);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    if ($row) {
        $_SESSION['username'] = $username;
        header('Location: survey.php');
        exit;
    } else {
        header('Location: admin.php?error=1');
        exit;
    }
}

