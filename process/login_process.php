<?php
session_start();
include '../includes/dbconn.php';

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);



    $user = "SELECT * FROM users WHERE username = ? AND password = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $user)) {
        echo 'sqlerror';
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ss", $username, $password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

    if ($row) {
        $_SESSION['username'] = $username;
        echo '1';
        exit();
    } else {
        echo '0';
        exit();
    }


}



