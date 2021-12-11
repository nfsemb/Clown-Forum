<?php

  include 'db.php';
  session_start();

  if ($_SESSION['admin_loggedin'] == true){
    header("Location: admin_page.php"); 
  }

  if(isset($_POST['username']) && isset($_POST['password'])){

    $username= $_POST['username'];
    $password= $_POST['password'];
    $passHash = md5($password);

    $sql = ( "SELECT username FROM admin WHERE username = ? AND password = ? LIMIT 1");
    $stmt = mysqli_stmt_init($connection); 
    mysqli_stmt_prepare($stmt,$sql);
    mysqli_stmt_bind_param($stmt,"ss",$username,$passHash);
    mysqli_stmt_execute($stmt) or die(mysqli_stmt_error($stmt));
    mysqli_stmt_bind_result($stmt, $result);

    if(mysqli_stmt_fetch($stmt)){
        $_SESSION['username']=$username;
        $_SESSION['admin_loggedin']=true;

        echo "logged in!";

        //header("Location: home.php"); //put our page
    }else {
        echo '<script type="text/javascript">alert("Invalid inputs. Please try again.");</script>';
        $_SESSION['admin_loggedin'] = false;
    }

    mysqli_stmt_close($stmt);
  }

  mysqli_close($connection);
?>