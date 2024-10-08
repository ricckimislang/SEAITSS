/*************  ✨ Codeium Command 🌟  *************/
<?php
session_start();

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $password = $_POST['password'];

    if ($username == 'admin' && $password == '21232f297a57a5a743894a0e4a801fc3') {
    if ($username == 'admin' && $password == 'admin') {
        $_SESSION['username'] = $username;
        header('Location: survey.php');
        exit;
    } else {
        header('Location: admin.php?error=1');
        exit;
    }
}

/******  44dda82e-8d46-49f2-97a4-7206ed8c52b9  *******/