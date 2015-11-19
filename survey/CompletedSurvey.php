<?php
	include "surveyHeader.php";
	include "../db/dbconnect.php";
	include "utils/authenticationIncludes.php";
?> 

<style type="text/css">
	span
	{
		text-align: center;
		display: block;
		margin: auto;
	}


</style>

<?php

	$errorMsg = "";
	$surveyTypeName = "";

	// adjust completion message
	if($_SESSION["surveyType"] == 1)
	{
		$surveyTypeName = "Pre";
	}
	elseif($_SESSION["surveyType"] == 2)
	{
		$surveyTypeName = "Post";
	}

	// update survey to reflect survey completion
	$finshSurveySql = "Update K12_SURVEY SET EndTime = CURRENT_TIMESTAMP, Completed = 'yes' WHERE ID = '".$_SESSION["surveyID"]."'";
	if(mysqli_query($conn, $finshSurveySql))
	{
		$notification = "Your survey was successfully saved.";
	}
	
?>




<div class="row">
	<span>  <?php  print $errorMsg  ?>  </span>
	<h2 style="text-align:center">Thank you for completing this <?php print $surveyTypeName ?>Survey!</h2>
	<span style="color:green">  <?php  print $notification ?> </span>
</div>
















<?php
	include "surveyFooter.php";
?>