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
$areResults = true;
$t = $row['Title'];
$sd = $row['StartDate'];
$ed = $row['EndDate'];
$des = $row['Description'];
$eID = $row['EventID'];
if ($des == "") {
    
    $des = "No details available.";
                        
}

//Convert all the data to a more user-readable format.

$month = substr($sd, 5, 2);
switch($month) {
    case "01":
        $month = "January";
        break;
    case "02":
        $month = "February";
        break;
    case "03":
        $month = "March";
        break;
    case "04":
        $month = "April";
        break;
    case "05":
        $month = "May";
        break;
    case "06":
        $month = "June";
        break;
    case "07":
        $month = "July";
        break;
    case "08":
        $month = "August";
        break;
    case "09":
        $month = "September";
        break;
    case "10":
        $month = "October";
        break;
    case "11":
        $month = "November";
        break;
    default:
        $month = "December";
        break;
}
                    
$day = substr($sd, 8, 2);
$year = substr($sd, 0, 4);
$date = $month . " " . $day . ", " . $year;
$hour = substr($sd, 11, 2);

//Removes the zero in front of the hour if the hour is only a single digit.
if ($hour[0] == 0)
    $hour = substr($hour, 1, 1);

$ampm = "A.M.";

//Checks to see if the hour should be AM or PM.
if ($hour > 12) {
    $hour -= 12;
    $ampm = "P.M.";
}
$mins = substr($sd, 14, 2);

//Concatenates the variables into a readable time.
$startTime = $hour . ":" . $mins . " " . $ampm;                    
$eHour = substr($ed, 11, 2);
if ($eHour[0] == 0)
    $eHour = substr($eHour, 1, 1);
$eAMPM = "A.M.";                    

if ($eHour > 12) {
    $eHour -= 12;
    $eAMPM = "P.M.";
}
$eMins = substr($ed, 14, 2);
$endTime = $eHour . ":" . $eMins . " " . $eAMPM;

?>

<div class="row">

	<table>
        <tr>
            <td><label><b>Event Name: </b></label></td>
            <td><?php echo $t ?></td>
        </tr>
        <tr>
            <td><label><b>Date: </b></label></td>
            <td><?php echo $date ?></td>
        </tr>
        <tr>
            <td><label><b>Start Time: </b></label></td>
            <td><?php echo $startTime ?></td>
        </tr>
        <tr>
            <td><label><b>End Time: </b></label></td>
            <td><?php echo $endTime ?></td>
        </tr>
        <tr>
            <td><label><b>Description: </b></label></td>
            <td><?php echo $des ?></td>
        </tr>
    </table>


</div>



<?php
	include "footer.php";
?>