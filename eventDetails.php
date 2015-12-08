<?php

	include "header.php";
	include "db/dbconnect.php";
?>

<?php

// first get the EventID passed from Calander page
$eventID = $_GET["q"];
// testing EventID
// $eventID = "XQ1N34ARUVWEJNOGKLSHFUNJW";

$sql = "select * From K12_EVENTS WHERE EventID='" . $eventID . "'";
//$sql = "call K12_EVENTS_GETEVENTS()";   // use stored procedure
$result = mysqli_query($conn, $sql) or die(mysqli_error($conn)); //send the query to the database or quit if cannot connect

// reteive row (which is an event)
$row = mysqli_fetch_array($result);


// populate local variables with event data
$eventName = $row['Title'];
$startDate = $row['StartDate'];
if($row['EndDate'] != '')
    $endDate = $row['EndDate'];
else
    $endDate = "Not Specfied.";
if($row['Description'] = '')
	$description = $row['Description'];
else
	$description = "No details available."

?>

<div class="row">

	<table>
		<tr>
			<td><label>Event Name: </label></td>
			<td>  <?php  echo $eventName ;  ?>  </td>
		</tr>

		<tr>
			<td><label>Start Date: </label></td>
			<td>  <?php  echo $startDate ;  ?>  </td>
		</tr>
		<tr>
			<td><label>End Date: </label></td>
			<td>  <?php  echo $endDate ;  ?>  </td>
		</tr>
		<tr>
			<td><label>Description: </label></td>
			<td>  <?php  echo $description ;  ?>  </td>
		</tr>

	</table>


</div>



<?php
	include "footer.php";
?>