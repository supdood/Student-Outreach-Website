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
	td
	{
		border: 1px solid black;
	}

	button
	{
		display: block;
		margin: auto;
	}
	select
	{
		text-align: center;
	}

	option
	{
		width: 25%;
	}

</style>

<?php

	//initialize local variables
	$q = "";
	$errorMsg = "";

	// get the teacherID from session
	$teacherID = "";
	$teacherID = $_SESSION["teacherID"];

	// initialize lastQuestionAnswered session variable
	$_SESSION["lastQuestionAnswered"] = 1;

	// get teachers existing classes
	
	$getTeacherClassesSql = "Select tc.ClassID, c.Name FROM K12_TEACHER_CLASS as tc, K12_CLASS as c Where tc.ClassID = c.ID AND tc.TeacherID = ".$teacherID;
	$getTeacherClassesResult = mysqli_query($conn, $getTeacherClassesSql);

	if($getTeacherClassesResult)
	{
		$dropDown = "<select name='existingClasses' id='existingClasses'>";
		while($val = mysqli_fetch_array($getTeacherClassesResult))
		{
			$dropDown .= "<option id='".$val[0]."'value='".$val[0]."'>".$val[1]."</option>";
		}
		$dropDown .= "</select>";
	}


?>

<script>

// pass classID to PrePickSurvey.php
function getDropdownValue(classID)
{
	var link = "PrePickSurvey.php?classID="+classID;
	window.location.assign(link);


}
</script>



<div class="row">
	<span>  <?php  print $errorMsg  ?>  </span>
	<table>
		<tr>
			<td>
				<form action="CreateNewClass.php" method="post">
					<label for="className">Class Name: </lable>
					<input type="text" id="className" name="className" class="textBox" maxlength="50"/>
					<label for="classDescription">Class Description: </lable>
					<input type="text" id="classDescription" name="classDescription" class="textBox" maxlength="140"/>
					<button name="btnCreateNewClass">Create New Class</button>
				</form>
			</td>
			<td>
				<label>Take Survey For Existing Class: </label>
				<span> <?php  print $dropDown  ?> </span>
				<button name="btnExistingSurvey" onclick="getDropdownValue(existingClasses.value)">Continue Survey</button>  
			</td>
		</tr>
	</table>

</div>







<?php
	include "surveyFooter.php";
?>