<?php

require_once "../inc/dbconnect.php";

if(!isset($_SESSION["email"]))
{
	Header("location:../login.php");
}
else {
   //$sql = "select Authenticated From K12_TEACHER WHERE Email = '" .$_SESSION['email']."'";
    $sql = "call K12_TEACHER_AUTHENTICATED('" .$_SESSION['email']."')"; 
    $result = mysqli_query($con, $sql) or die(mysqli_error($con)); //send the query to the database or quit if cannot connect
    $activated = mysqli_fetch_array($result);
    
    //Prepare the db for the next query.
    $result->close();
    $con->next_result();
    
    if ($activated[0] == 'no')
    Header ("Location:../activation.php") ;
}




?>