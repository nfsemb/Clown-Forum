<?php

  include 'db.php';

  session_start();



  if(isset($_POST['username']) && isset($_POST['password'])){

    $username= $_POST['username'];
    $password= $_POST['password'];
    $passHash = md5($password);

    $sql = ( "SELECT username FROM users WHERE username = ? AND password = ? LIMIT 1");
    $stmt = mysqli_stmt_init($connection); 
    mysqli_stmt_prepare($stmt,$sql);
    mysqli_stmt_bind_param($stmt,"ss",$username,$passHash);
    mysqli_stmt_execute($stmt) or die(mysqli_stmt_error($stmt));
    mysqli_stmt_bind_result($stmt, $resUsername);

    //if fetch return true, there exits an account with this username and password
    if(mysqli_stmt_fetch($stmt)){
        $_SESSION['username']=$username;
        $_SESSION['loggedin']=true;

        header("Location: account_settings.php");

        //header("Location: home.php"); //put our page
    }else {
        header("Location: login.html");
        $_SESSION['loggedin'] = false;
    }

    mysqli_stmt_close($stmt);
  }

  mysqli_close($connection);
?>