<?php
	include "surveyHeader.php";
	include "../db/dbconnect.php";
	include "utils/authenticationIncludes.php";
?> 
<style type="text/css">
	.table{
		width: auto;
		text-align: center;
		border: 1px solid black;
	}
	div
	{
		width: 50%;
		text-align: center;
		margin: 0 auto;
	}
	select
	{
		width: auto;
	}
</style>


<?php
	
	// string to generate dropDown to select survey
	$dropDown = "<select name='existingSurvey' id='existingSurvey'>";
	
	$countOfIncompletes = count($_SESSION["incompleteSurveys"]);
	
	for ($i = 0; $i < $countOfIncompletes; $i++) 
	{
	
		$val = $_SESSION["incompleteSurveys"][$i];
	
		// populate the dropdown box options
		// $val[0] is SurveyID
		// $val[1] is ClassID
		$dropDown .= "<option id='".$val[0]."'value='".$val[1]."'>". $val[4] . " - ".$val[3]. "</option>";
	}

?>

<script>
// Capture dropdown box value
// pass to ExistingSurveyLanding.php
function getDropdownValue(classID)
{
	
	var dropDownBox = document.getElementById("existingSurvey");
	
	var surveyID = dropDownBox.options[dropDownBox.selectedIndex].id;
	
	var link = "ExistingSurveyLanding.php?surSelect="+surveyID+"&classID="+classID;
	window.location.assign(link);


}
</script>



<div>
	<!-- <form action="ExistingSurveyLanding.php" method="post"> -->
	<table>
		<tr>
			<td>Select ClassID from your incomplete surveys: </td>
			<td>  <?php  print $dropDown  ?>  </td>
			<!-- <td id="selectedSurvey" /> -->
			<td>  <button name="btnExistingSurvey" onclick="getDropdownValue(existingSurvey.value)">Continue Survey</button>  </td>
		</tr>
	</table>
	<!-- </form> -->
	

</div>





<?php
	include "surveyFooter.php";
?>