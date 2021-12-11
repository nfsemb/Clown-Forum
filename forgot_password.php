<?php

/*include 'db.php';

session_start();

if(isset($_POST["forgotPass"])){
    $email = $_POST["email"];  //$connection->real_escape_string($_POST["email"]);


    $sql = 'SELECT password FROM users WHERE email= ?';
    $stmt = mysqli_stmt_init($connection);
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt) or die(mysqli_stmt_error($stmt));
    mysqli_stmt_bind_result($stmt, $hashpassword);


    if(mysqli_stmt_fetch($stmt)){
        //how to recover password?
        $_SESSION["email"] = 
        Header("Location:reset_password.html");
        
        /*echo '<script type="text/javascript"> 
                alert("Reset email sent.  Go to your ")
                window.location.replace("login.php");
                </script>';*/


/*
    }else{
        echo '<script type="text/javascript">alert("No valid email found. Please try again.");</script>';
    }
}

session_destroy();
mysqli_close($connection);
*/
?>

<!DOCTYPE html>
<html>

  <head lang="en">

  </head>

  <body>

<main>
<div class = "content-body">

  <h1 class = "loginandreg">Reset Your Password</h1>

<form action="reset_password.php" method="post">
    <input type="text" name="email" placeholder="email">
    <button type="submit" name="forgotPass" class="btn log-btn">Submit</button></br>
</form>


</main>

</body>
</html>