<?php session_start();

require_once "../inc/dbconnect.php";

// get the q parameter from URL.  This is the text that the user typed into the text box.
$fn = $_REQUEST["fn"];
$ln = $_REQUEST["ln"];

$fn = mysqli_real_escape_string($con, $fn);
$ln = mysqli_real_escape_string($con, $ln);

$sql = "UPDATE K12_TEACHER SET FirstName = '" .$fn. "', LastName = '" .$ln. "' WHERE Email = '" .$_SESSION['email']. "'";
$result = mysqli_query($con, $sql) or die(mysqli_error($con)); //send the query to the database or quit if cannot connect

echo "pass";


?>