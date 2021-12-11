<?php

include 'db.php';

session_start();

if(isset($_POST['register'])){


    $sql = 'SELECT userID FROM users WHERE username= ?';
    $stmt = mysqli_stmt_init($connection);
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "s", $_SESSION['username']);
    mysqli_stmt_execute($stmt) or die(mysqli_stmt_error($stmt));
    mysqli_stmt_bind_result($stmt, $userID);
    mysqli_stmt_fetch($stmt);


    //Upload file:
    $target_dir = "images/";
    $target_file = $target_dir . basename($_FILES["userImage"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    
    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["userImage"]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["userImage"]["size"] > 100000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
    } else {
        $imagedata = file_get_contents($_FILES['userImage']['tmp_name']);//store the contents of the files in memory in preparation for upload
        $sql = "UPDATE userImages SET contentType=?, image=? WHERE userID= '".$userID."'";
        $stmt = mysqli_stmt_init($connection); //init prepared statement object
        mysqli_stmt_prepare($stmt, $sql); // register the query 
        $null =NULL;
        mysqli_stmt_bind_param($stmt, "sb", $imageFileType, $null); 
        mysqli_stmt_send_long_data($stmt, 1, $imagedata); 
        mysqli_stmt_execute($stmt) or die(mysqli_stmt_error($stmt));
        mysqli_stmt_close($stmt);
        
        Header("Location: account_settings.php");
    }

    
    mysqli_close($connection);
}


?>
