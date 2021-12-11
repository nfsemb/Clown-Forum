<?php
include 'db.php';

if	($_SERVER["REQUEST_METHOD"]	==	"POST")	{
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    if (isset($firstname) && isset($lastname) && isset($username) && isset($email) && isset($password)){
        
        //check if user already exist:
        $sql = "SELECT * FROM users;";
        $results = mysqli_query($connection, $sql);

        while ($row = mysqli_fetch_assoc($results))
        {
            if ($firstname== $row['firstName'] && $lastname==$row['lastname'] || $email==$row['email']){
                echo '<p>User already exists with this name and/or email</p><br>';
                exit();
            }
        }
        mysqli_free_result($results);

        //insert new user
        $hashPass = md5($password);
        $sql = "INSERT INTO users(username, firstName, lastName, email, password) VALUES ('$username', '$firstname', '$lastname', '$email', '$hashPass');";
        if(mysqli_query($connection, $sql)){
            echo '<p>An account for the user ' . $firstname . ' has been created <br>';
        }
        else {
            echo "<p>Something went wrong </p>";
            exit();
        }


        //get userID
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
            $sql = "INSERT INTO userImages (userID, contentType, image) VALUES(?,?,?)";// create a new statement to insert the image into the table.  Recall// that the ? is a placeholder to variable data.
            $stmt = mysqli_stmt_init($connection); //init prepared statement object
            mysqli_stmt_prepare($stmt, $sql); // register the query 
            $null =NULL;
            mysqli_stmt_bind_param($stmt, "isb", $userID, $imageFileType, $null); 
            mysqli_stmt_send_long_data($stmt, 2, $imagedata); 
            mysqli_stmt_execute($stmt) or die(mysqli_stmt_error($stmt));
            mysqli_stmt_close($stmt);

            if (true){//move_uploaded_file($_FILES["userImage"]["tmp_name"], $target_file)) {
                echo "The file ". htmlspecialchars( basename( $_FILES["userImage"]["name"])). " has been uploaded to local drive.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }
}

//close connection
mysqli_close($connection);

?>
