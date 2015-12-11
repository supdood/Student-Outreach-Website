<?php
include "header.php";
require_once "inc/dbconnect.php";

if (!isset($_SESSION['email']) || $_SESSION["access"] > 2) 
{
    header ('Location: index.php');
}
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
		text-align: center;
	}
</style>

<div>
	<table>
		<form action="csvTeacherInfo.php" method="post">
			<tr>
				<td style="text-align:center"><label>Download Teacher Info</label></td>
				<td style="text-align:center"><button name="btnCSVTeacherInfo">Download</button></td>
			</tr>
		</form>
		<form action="csvClassInfo.php" method="post">
			<tr>
				<td style="text-align:center"><label>Download Class Info</label></td>
				<td style="text-align:center"><button name="btnCSVClassInfo">Download</button></td>
			</tr>
		</form>
</div>







<?php
	include "footer.php";
?>