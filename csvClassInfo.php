<?php
	include "db/dbconnect.php";
?>


<?php

	// name file and open it
	$fileName = "classInfo.csv";
	$fp = fopen('php://output', "w");

	header('Content-type: application/csv');
	header('Content-Disposition: attachment; filename="'.$fileName.'"');

	// structure and get query from database
	$sql = "call K12_CLASS_GETALL()";
	$result = mysqli_query($conn, $sql) or die(mysql_error());
	// print_r($result);

	while($row = mysqli_fetch_row($result))
	{
		// print_r($row);
		fputcsv($fp, $row);
	}
?>