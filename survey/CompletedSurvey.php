<?php
	include "surveyHeader.php";
	include "../db/dbconnect.php";
	include "utils/authenticationIncludes.php";
?> 

<?php

	$errorMsg = "";
	$surveyTypeName = "";

	if($_SESSION["surveyType"] == 1)
	{
		$surveyTypeName = "Pre";
	}
	elseif($_SESSION["surveyType"] == 2)
	{
		$surveyTypeName = "Post";
	}

?>




<div class="row">
	<span>  <?php  print $errorMsg  ?>  </span>
	<h2 style="text-align:center">Thank you for completing this <?php print $surveyTypeName ?>Survey!</h2>

</div>
















<?php
	include "surveyFooter.php";
?>