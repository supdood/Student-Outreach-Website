<?php
	include "header.php";
	include "../db/dbconnect.php";
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

	//initialize local variables
	$q = "";
	$errorMsg = "";

	// get the teacherID from session
	$teacherID = "";
	$teacherID = $_SESSION["teacherID"];


?>



<div>
	<span>  <?php  print $errorMsg  ?>  </span>
	<form action="CreateNewClass.php" method="post">
		<label for="className">Class Name: </lable>
		<input type="text" id="className" name="className" class="textBox" maxlength="50"/>
		<label for="classDescription">Class Description: </lable>
		<input type="text" id="classDescription" name="classDescription" class="textBox" maxlength="140"/>
		<button name="btnCreateNewClass">Create Class</button>
	</form>

</div>







<?php
	include "footer.php";
?>