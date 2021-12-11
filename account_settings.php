<?php

include 'db.php';
session_start();

if (isset($_SESSION["username"])){
    
    //fetch data from user
    $sql = 'SELECT username, firstName, lastName, userID, password FROM users WHERE username= ?';
    $stmt = mysqli_stmt_init($connection);
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "s", $_SESSION["username"]);
    mysqli_stmt_execute($stmt) or die(mysqli_stmt_error($stmt));
    mysqli_stmt_bind_result($stmt, $username, $firstName, $lastName, $userID, $password);
} else{
    Header("Location: login.html");
}


//<h3><?php if(mysqli_stmt_fetch($stmt)){echo $password;}</h2>
?>

<!DOCTYPE html>
<html>
<head lang="en">


</head>
<body>
<header>


</header>

<main>

<h1>Account Settings</h1>
<h2><?php echo $_SESSION['username']?></h2>
<div>
    <?php

        //get userID
        $sql = 'SELECT userID FROM users WHERE username= ?';
        $stmt = mysqli_stmt_init($connection);
        mysqli_stmt_prepare($stmt, $sql);
        mysqli_stmt_bind_param($stmt, "s", $_SESSION['username']);
        mysqli_stmt_execute($stmt) or die(mysqli_stmt_error($stmt));
        mysqli_stmt_bind_result($stmt, $userID);
        mysqli_stmt_fetch($stmt);

        //find picture
        $sql = "SELECT contentType, image FROM userImages where userID=?";// build the prepared statement SELECTing on the userID for the user
        $stmt = mysqli_stmt_init($connection);  //init prepared statement object
        mysqli_stmt_prepare($stmt, $sql); // bindthe queryto the statement
        mysqli_stmt_bind_param($stmt, "i", $userID);// bind in the variable data (ie userID)
        $resultUser = mysqli_stmt_execute($stmt) or die(mysqli_stmt_error($stmt));// Run the query.  run spot run!  
        mysqli_stmt_bind_result($stmt, $type, $image); //bind in results//Binds the columns in the resultset to variables
        mysqli_stmt_fetch($stmt);// Fetches the blob and places it in the variable $image for use as well // as the image type (which is stored in $type) 
    
        //showing the picture:
        echo '<img src="data:image/'.$type.';base64,'.base64_encode($image).'"/>';
    
        mysqli_stmt_close($stmt);
    ?>
</div>


<table id="changes">
    <tr>
    <td width="50%">
    <h2>Change Password</h2>
    <form name = "regiForm" class="form" action="change_password.php" method="POST">
        <input type="password" placeholder="Old Password" name="oldpassword" autocomplete="new-password" required /></br>
        <input type="password" placeholder="New Password" name="newpassword" autocomplete="new-password" required /></br>
        <input type="password" placeholder="Confirm New Password" name="confirmnewpassword" autocomplete="new-password" required /></br>

    <input type="submit" value="Submit" name="Sumbit" class="regi-btn" />
    </form>
    </td>


    <td width="50%">

    <h2>Change Profile Picture</h2>

    <form name = "regiForm" class="form" action="change_user_image.php" method="POST" enctype="multipart/form-data">
    <div class="userImage">
        <label>Select your Profile Picture: </label>
        <input type="file" name="userImage" accept="image/*" required /></br>

        <input type="submit" value="Submit" name="register" class="regi-btn" />
    </div>
    </form>


</td>
    </tr>


</table>




</main>


</body>
</html>

<?php
mysqli_close($connection);
?>