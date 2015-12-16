<?php
	include "surveyHeader.php";
	include "../db/dbconnect.php";
	include "utils/authenticationIncludes.php";
?> 
<style type="text/css">
	div
	{
		width: 30%;
		text-align: center;
		margin: 0 auto;
	}
	button
	{
		width: 20%;
	}
</style>

<?php
	// initialize error variable
	$errorMsg = "";
	
	// get boolean value from postSurveyAvail
	// value specifies if the post survey button should be visible
	// depends on whether the teacher has taken a PreSurvey
	
	if(isset($_GET["postSurveyAvail"])) $postSurveyAvail = $_GET["postSurveyAvail"];




?>


<div class="row">
	<span>  <?php  print $errorMsg  ?>  </span>
	<h2 style="margin:2">Select a type of survey: </h2>
	<form action="PreSurveyLanding.php" method="post" name="PreSurveyChoice">
		<button name="btnPreSurvey">PreSurvey</button>
	</form>
	<br>
	<?php if($postSurveyAvail) print <<<postSurveyForm
	<form action="PostSurveyLanding.php" method="post" name="PostSurveyChoice">
		<button name="btnPostSurvey">PostSurvey</button>
	</form>
postSurveyForm
	?>

</div>



<?php
	include "surveyFooter.php";
?>