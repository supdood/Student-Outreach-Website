<?php
	session_start();
	include "../db/dbconnect.php";
	include "utils/authenticationIncludes.php";


// grab Post variables
$className = trim($_POST["className"]);
$classDescription = trim($_POST["classDescription"]);

// clean inputs
$className = mysqli_real_escape_string($conn, $className);
$classDescription = mysqli_real_escape_string($conn, $classDescription);

print "Before new class insert<br>";
$sqlNewClass = "INSERT INTO  `nelson8_db`.`K12_CLASS` (`ID` ,`Name` ,`Description`) VALUES (NULL ,  '".$className."',  '".$classDescription."')";
print $sqlNewClass;
// $result = mysqli_query($conn, $sqlNewClass);

// print count($result);
// $field = mysqli_fetch_array($result);
// print $field[0];

// insert new class, if successful get the new classID
// and store value in session variable
if(mysqli_query($conn, $sqlNewClass))
{
	print "after new class insert<br>";
	$sqlGetNewClassID = "Select ID FROM K12_CLASS WHERE ClassName ='". $className . "'";
	print $sqlGetNewClassID;
	$resultClassID = mysqli_query($conn, $sqlGetNewClassID);
	print "after selecting new ClassID insert<br>";
	print count($resultClassID);
	if(count($resultClassID != 0))
	{
		print $resultClassID."<br>";
		// intialize classID session variable
		$_SESSION["classID"] = "";

		// fetch value for session variable
		$field = mysqli_fetch_array($resultClassID);
		// populate classID session variable
		$_SESSION["classID"] = $field[0];
		print $field[0]."<br>";

		// add class to TEACHER_CLASS mapping table
		$sqlInsertToTeacherClass = "INSERT INTO `nelson8_db`.`K12_TEACHER_CLASS` (`TeacherID`, `ClassID`) VALUES ('".$_SESSION["teacherID"]."', '".$_SESSION["classID"]."')";
		$resultInsertToTeacherClass = mysqli_query($conn, $sqlInsertToTeacherClass);
		//print $resultInsertToTeacherClass . "<br>";

		// initialize lastQuestionAnswered session variable
		$_SESSION["lastQuestionAnswered"] = 1;	// value initialized to one since this is a new survey and the
												// question ID's start at 1

		Header("location:PickSurveyType.php");
	}	
}
else
{
	$errorStr = "Sorry, something went wrong. Please try again.";
	Header("location:StartSurvey.php?q=".$errorStr);
}

?>