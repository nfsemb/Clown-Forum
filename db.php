<?php

$host = "localhost"; //  cosc360.ok.ubc.ca
$database = "lab9"; //lab9
$user = "root";
$password = "";

$connection = mysqli_connect($host, $user, $password, $database);

$error = mysqli_connect_error();
if($error != null)
{
  $output = "<p>Unable to connect to database!</p>";
  exit($output);
}

//on every php page include: 

//include 'db.php';
//mysqli_close($connection);

?>