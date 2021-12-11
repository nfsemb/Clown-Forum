<?php

session_start();

if(isset($_SESSION['loggedin'])){
    header("Location: account_settings.php");
    exit();
}
header("Location: login.html");

session_destroy();

?>