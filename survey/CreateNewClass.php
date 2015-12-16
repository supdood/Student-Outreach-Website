<?php
	session_start();
	include "../db/dbconnect.php";
	include "utils/authenticationIncludes.php";

$errorStr = "";

// grab Post variables
$className = trim($_POST["className"]);
$classDescription = trim($_POST["classDescription"]);

// clean inputs
$className = mysqli_real_escape_string($conn, $className);
$classDescription = mysqli_real_escape_string($conn, $classDescription);

$errorStr .= "<br>" . $className . "<br>" . $classDescription;


$sqlNewClass = "call K12_CLASS_CREATENEWCLASS('".$className."', '".$classDescription."')";


// insert new class, if successful get the new classID
// and store value in session variable
if(mysqli_query($conn, $sqlNewClass))
{
	$errorStr .= "<br>after new class insert";
	$sqlGetNewClassID = "Select ID FROM K12_CLASS WHERE Name ='". $className . "'";
	
	$resultClassID = mysqli_query($conn, $sqlGetNewClassID);
	
	if(count($resultClassID != 0))
	{
		
		// initialize classID session variable
		$_SESSION["classID"] = "";

		// fetch value for session variable
		$field = mysqli_fetch_array($resultClassID);
		
		// populate classID session variable
		$_SESSION["classID"] = $field[0];
		print $field[0]."<br>";

		// add class to TEACHER_CLASS mapping table
		$sqlInsertToTeacherClass = "INSERT INTO `nelson8_db`.`K12_TEACHER_CLASS` (`TeacherID`, `ClassID`) VALUES ('".$_SESSION["teacherID"]."', '".$_SESSION["classID"]."')";
		if(mysqli_query($conn, $sqlInsertToTeacherClass))
		{
			$errorStr .=   "<br>" . $resultInsertToTeacherClass;

			// initialize lastQuestionAnswered session variable
			$_SESSION["lastQuestionAnswered"] = 1;	// value initialized to one since this is a new survey and the
													// question ID's start at 1
													
			// Next check to see if a Pre survey has been yet taken for this classID,
			// if no Pre survey taken, teacher is not allowed to take post survey (until pre survey for class has been submitted)
			
			$preSurveyTakenForClassIDSql = "SELECT count(*) FROM K12_SURVEY WHERE ClassID = '".$_SESSION["classID"]."' AND SurveyTypeID = '1'";
			$preSurveyTakenForClassIDResult = mysqli_query($conn, $preSurveyTakenForClassIDSql);
			$preSurveyTakenField = mysqli_fetch_array($preSurveyTakenForClassIDResult);
			// initialize count variable
			$count = 0;
			$count = $preSurveyTakenField[0];
			// if count does not equal zero, teacher has taken pre survey thusly the post survey option will be available
			// initialize $postSurveyAvail
			$postSurveyAvail = false;
			if($count != 0)
			{
				$postSurveyAvail = true;
			}
			
			
			

			Header("location:PickSurveyType.php?postSurveyAvail=".$postSurveyAvail);
		}
		else
		{
			$errorStr .= "<br>Sorry, something went wrong. Please try again.";
			Header("location:StartSurvey.php?q=".$errorStr);
		}
	}	
}
else
{
	$errorStr .= "<br>Sorry, something went wrong. Please try again.";
	Header("location:StartSurvey.php?q=".$errorStr);
}

?>