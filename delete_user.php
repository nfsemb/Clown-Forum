
<?php

include "db.php";

if (isset($_POST['del-btn']))
{
    echo "you are in delete.php";
    $username = $_POST['uname'];
    

    
    $sql = "DELETE FROM users WHERE username = '".$username."'";
    
    if (mysqli_query($connection, $sql))
    {
        echo '<script type="text/javascript"> 
                        alert("User successfully deleted")
                        window.location.replace("searchUsers.php");
                        </script>';
    }
    else 
    {
        echo "user not deleted successfully";
        //header("Location: admin_users_button.php");
    }
}



mysqli_close($connection);

?>