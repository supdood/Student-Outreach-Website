<?php session_start();

require_once "../inc/dbconnect.php";

// get the q parameter from URL.  This is the text that the user typed into the text box.
$s = $_REQUEST["s"];

$s = mysqli_real_escape_string($con, $s);

$sql = "UPDATE K12_TEACHER SET School = '" .$s. "' WHERE Email = '" .$_SESSION['email']. "'";
$result = mysqli_query($con, $sql) or die(mysqli_error($con)); //send the query to the database or quit if cannot connect

echo "pass";


?>