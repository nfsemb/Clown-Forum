<?php

include 'db.php';

session_start();

if ($_SERVER["REQUEST_METHOD"]	==	"POST")
{
    $search = $_POST['search'];

    if (isset($search)) {

        //search with firstname
        $sql = ( "SELECT username, firstName, lastName, email FROM users WHERE firstName=?");
        $stmt = mysqli_stmt_init($connection); 
        mysqli_stmt_prepare($stmt,$sql);
        mysqli_stmt_bind_param($stmt,"s",$search);
        mysqli_stmt_execute($stmt) or die(mysqli_stmt_error($stmt));
        mysqli_stmt_bind_result($stmt, $username, $firstname, $lastname, $email);
        mysqli_stmt_store_result($stmt);
        $users = "";
        
        if(mysqli_stmt_num_rows($stmt) > 0) { //mysqli_num_rows($res) > 0
            while(mysqli_stmt_fetch($stmt)){
        
                /*$username_ = $row['username'];
                $firstname_ = $row['firstName'];
                $lastname_ = $row['lastName'];
                $email_ = $row['email'];*/
                
                $users.= "<tr>
                            <td>".$username."</td>
                            <td>".$firstname."</td>
                            <td>".$lastname."</td>
                            <td>".$email."</td>
                            <td> <form  action = 'deleteUser.php' method = 'post'>
                                <input type = 'hidden' name = 'uname' value = '".$username."'>
                                <button type = 'submit' name = 'del-btn' class = 'delete-btn btn'>delete</button>
                                </form>
                            </td>
                        </tr>";
            }
        }
        
        mysqli_stmt_close($stmt);
    }
}

?>


<!DOCTYPE html>
<html>

  <head lang="en">
    <link rel="stylesheet" href="css/style.css">
  </head>

  <body>


    <main>
    <div class = "content-body">
        <h1 >ADMIN - Users</h1>

        <div class = "search-post">
            <form name="searchUser" method="post" action="search_users.php">
                <input type="textarea" placeholder = "Search for firstname" name = "search" class="required">
                <button type ="submit" name="search-btn" class = "btn">Search</button>
        </div>

        <table>
            <tr>
                <th width="30%">Username</th>
                <th width="30%">First Name</th>
                <th width="30%">Last Name</th>
                <th width="30%">Email</th>
                <th width="10%"></th>
            </tr>
            <?php echo $users; ?>
        
        </table>
    </div>
    </main>


    </body>
</html>


<?php

mysqli_close($connection);
session_destroy();

?>