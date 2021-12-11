<?php

    session_start();

    unset($_SESSION['loggedin']);
    unset($_SESSION['username']);
    unset($_SESSION['admin_loggedin']);

    session_destroy();

    header("Location: login.html");

?>
