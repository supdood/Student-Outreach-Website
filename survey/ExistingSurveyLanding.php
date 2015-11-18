<?php
	include "surveyHeader.php";
	include "../db/dbconnect.php";
	include "utils/authenticationIncludes.php";
?> 
<style type="text/css">
/*	input[type="text"]
	{
		width: 30%;
	}*/
	div
	{
		width: 30%;
		text-align: center;
		margin: 0 auto;
	}
</style>

<?php
	// initialize error variable
	$errorMsg = "";

	// pass dropdown selection value to session variable
	// surSelect is the selected dropdown option's value -- which is the SurveyID of the selected survey
	$_SESSION["surveyID"] = $_GET["surSelect"];
	$_SESSION["classID"] = $_GET["classID"];

	// print $_SESSION["surveyID"];
	// print $_SESSION["classID"];
?>


<div class="row">
	<span>  <?php  print $errorMsg  ?>  </span>
	<h2>To continue with this survey, click the Start button.</h2>
	<h3>The survey should take 5-150 mins.</h3>
	<form action="NextQuestion.php" method="post">
		<button name="btnExistingSurvey">Start</button>
	</form>

</div>



<?php
	include "surveyFooter.php";
?>