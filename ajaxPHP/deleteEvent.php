<?php session_start();

require_once "../inc/dbconnect.php";

// get the q parameter from URL.  This is the text that the user typed into the text box.
$e = $_REQUEST["e"];

$e = mysqli_real_escape_string($con, $e);

$sql = "DELETE FROM K12_EVENTS WHERE EventID = '" .$e. "'";
$result = mysqli_query($con, $sql) or die(mysqli_error($con)); //send the query to the database or quit if cannot connect

echo "pass";


?>