<?php session_start();

require_once "../inc/dbconnect.php";

// get the q parameter from URL.  This is the text that the user typed into the text box.
$d = $_REQUEST["d"];

$d = mysqli_real_escape_string($con, $d);

$sql = "select AccessLevel From K12_TEACHER WHERE Email = '" .$d."'";
$result = mysqli_query($con, $sql) or die(mysqli_error($con)); //send the query to the database or quit if cannot connect
$access = mysqli_fetch_array($result);

if ($access[0] == 2) {
    $sql = "UPDATE K12_TEACHER SET AccessLevel = 3 WHERE Email = '" .$d. "'";
    $result = mysqli_query($con, $sql) or die(mysqli_error($con)); //send the query to the database or quit if cannot connect
    echo "pass";
}
else if ($access[0] == 3)
    echo "fail";
else if ($access[0] == 1)
    echo "deny";
else
    echo "none";


?>