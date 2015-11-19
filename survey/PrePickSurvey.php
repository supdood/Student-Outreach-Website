<?php
	session_start();
	include "../db/dbconnect.php";
	include "utils/authenticationIncludes.php";
?>

<?php

	// grab classID
	if(isset($_GET["classID"]))
	{
		$_SESSION["classID"] = $_GET["classID"];
	}

	// Next check to see if a Pre survey has been yet taken for this classID,
	// if no Pre survey taken, teacher is not allowed to take post survey (until pre survey for class has been submitted)
	
	$preSurveyTakenForClassIDSql = "SELECT count(*) as c FROM K12_SURVEY WHERE ClassID = '".$_SESSION["classID"]."' AND SurveyTypeID = '1'";
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

	mysqli_free_result($preSurveyTakenForClassIDResult);
	$conn->next_result();


	Header("location:PickSurveyType.php?postSurveyAvail=".$postSurveyAvail);

?>