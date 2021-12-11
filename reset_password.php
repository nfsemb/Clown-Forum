<?php

include 'db.php';
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
        $_SESSION['email'] = $email;


    }else{
        echo '<script type="text/javascript"> 
                alert("No valid email found. Please try again. ")
                window.location.replace("forgot_password.php");
                </script>';
    }
    mysqli_stmt_close($stmt);
}

if (isset($_POST['newpassword']) && isset($_POST['confirmnewpassword'])){
    $newpassword = $_POST['newpassword'];
    $newpasswordconfrim = $_POST['confirmnewpassword'];
    $newpasswordhash = md5($newpassword);

    if($newpassword == $newpasswordconfrim){
        

        $sql = "UPDATE users SET password=? WHERE email= '".$_SESSION['email']."'"; //".$_SESSION['email']."
        $stmt2 = mysqli_stmt_init($connection);
        mysqli_stmt_prepare($stmt2, $sql);
        mysqli_stmt_bind_param($stmt2, "s", $newpasswordhash);


        if (mysqli_stmt_execute($stmt2)) {

                //header("location: accountsettings.php");
                
                echo '<script type="text/javascript"> 
                alert("You have now reset password")
                window.location.replace("login.html");
                </script>';

        } else {
            echo "Error: " . $sql . "<br>" . mysqli_connect_error();
        }

    } else {
        echo '<script type="text/javascript">alert("Passwords do not match");
        window.location.replace("reset_password.php");
        </script>';
    }

    mysqli_stmt_close($stmt2);
}

mysqli_close($connection);

?>

<!DOCTYPE html>
<html>
<head lang="en">

</head>
<body>
    <h1> <?php echo $_SESSION['email']?> </h1>
    <h2>Change Password</h2>
    <form name = "regiForm" class="form" action="reset_password.php" method="POST">
        <input type="password" placeholder="New Password" name="newpassword" autocomplete="new-password" required /></br>
        <input type="password" placeholder="Confirm New Password" name="confirmnewpassword" autocomplete="new-password" required /></br>

        <button type="submit" name="Sumbit" class="regi-btn"> Reset password </button>
    </form>

</body>
</html>
