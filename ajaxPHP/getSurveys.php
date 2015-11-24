<?php

//Ethan Fetsko
//getSurveys
//November 19, 2015

require_once "../ajax/dbconnect.php";
header('Content-Type: application/json');

// get the q parameter from URL.  This is the text that the user typed into the text box.
$q = $_REQUEST["q"];

$q = mysqli_real_escape_string($con, $q);

$match = false;
$sql = "select ID From K12_TEACHER where Email = '".$q."'";
$result = $DB->GetAll($sql);
$id = $result[0][0];

$sql = "select ID From K12_SURVEY where TeacherID = '".$id."'";
$result = $DB->GetAll($sql);
$sID = $result[0][0];

$surveys = array();

foreach ($result as $row) {
    $surveys[] = $row['ID'];
}


//The $surveys array is then echoed back to lab5.php via json.
echo json_encode($surveys);

?>