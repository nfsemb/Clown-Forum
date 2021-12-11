<?php

    include 'db.php';

    session_start();

    $oldpassword = $_POST['oldpassword'];
    $hasholdpw = md5($oldpassword);
    $newpassword = $_POST['newpassword'];
    $newpasswordconfrim = $_POST['confirmnewpassword'];
    $newpasswordhash = md5($newpassword);

    $sql = 'SELECT password FROM users WHERE username=?';

    $stmt = mysqli_stmt_init($connection);
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "s", $_SESSION["username"]);
    mysqli_stmt_execute($stmt) or die(mysqli_stmt_error($stmt));
    mysqli_stmt_bind_result($stmt, $currentpw);

    if(mysqli_stmt_fetch($stmt)){
        if($currentpw == $hasholdpw){
            if($newpassword == $newpasswordconfrim){


                $sql = "UPDATE users SET password=? WHERE username= '".$_SESSION['username']."'";
                $stmt = mysqli_stmt_init($connection);
                mysqli_stmt_prepare($stmt, $sql);
                mysqli_stmt_bind_param($stmt, "s", $newpasswordhash);


                if (mysqli_stmt_execute($stmt)) {

                        //header("location: accountsettings.php");
                        echo '<script type="text/javascript"> 
                        alert("You have now changed password")
                        window.location.replace("account_settings.php");
                        </script>';

                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_connect_error();
                }

            } else {
                echo '<script type="text/javascript">alert("Passwords do not match");</script>';
            }
        } else {
        echo '<script type="text/javascript">alert("Current password is incorrect");</script>';
        }
    }

    session_destroy();
    mysqli_close($connection);
?>