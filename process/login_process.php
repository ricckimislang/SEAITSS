<?php
session_start();
include '../includes/dbconn.php';

if (isset($_POST['username']) && isset($_POST['password'])) {

    $username = $_POST['username'];
    $password = md5($_POST['password']);

    // Update survey statuses to closed if the end date has passed
    $updateStatus = "UPDATE surveys SET is_complete = 1 WHERE end_date < NOW() AND is_complete = 0";
    if (!mysqli_query($conn, $updateStatus)) {
        // Error handling if the update query fails
        echo 'Error updating survey status: ' . mysqli_error($conn);
        exit();
    }

    // Prepare the user query
    $user = "SELECT * FROM users WHERE username = ? AND password = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $user)) {
        echo 'SQL error: ' . mysqli_error($conn);
        exit();
    }

    // Bind parameters and execute
    mysqli_stmt_bind_param($stmt, "ss", $username, $password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

    // Check if a user was found
    if ($row) {
        $_SESSION['username'] = $username;
        echo '1'; // Successful login
        exit();
    } else {
        echo '0'; // Invalid username/password
        exit();
    }
}
