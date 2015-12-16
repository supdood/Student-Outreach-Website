<!-- Include the header -->
<?php
include "header.php";
require_once "inc/dbconnect.php";

if (!isset($_SESSION['email'])) {
    header ('Location: login.php');
}
else {

    //$sql = "select Authenticated From K12_TEACHER WHERE Email = '" .$_SESSION['email']."'";

    $sql = "call K12_TEACHER_AUTHENTICATED('" .$_SESSION['email']."')"; // if the embedded session variable creates
                                                                    // an error, may have to concatenate instead
    $result = mysqli_query($con, $sql) or die(mysqli_error($con)); //send the query to the database or quit if cannot connect
    $activated = mysqli_fetch_array($result);
    
    //Prepare the db for the next query.
    $result->close();
    $con->next_result();
    
    
    if ($activated[0] == 'no')
    Header ("Location:activation.php") ;
}

?>

<script src="js/account.js"></script>

<?php

//initialize the variables

$opw = "";
$npw = "";
$msg = "";
$eduLevel="";
$fn = "";
$ln = "";
$school = "";

//Greet the user

//$sql = "select FirstName, LastName, School, Education, CSBackground from K12_TEACHER where Email = '" .$_SESSION['email']. "'";
$sql = "call K12_TEACHER_GETFULLNAME('" .$_SESSION['email']. "')";  // if the embedded session variable creates
                                                           // an error, may have to concatenate instead
//$sql = "select FirstName, LastName from REGISTRATION where UserName = 'ejapohfepah@gmail.com'";
$result = mysqli_query($con, $sql) or die(mysqli_error($con)); //send the query to the database or quit if cannot connect
$field = mysqli_fetch_array($result); //the query results are objects, in this case, one object

$fn = $field[0];
$ln = $field[1];
$msg = "Welcome <span id='greeting'>" . $fn . " " . $ln . "</span>!<br/><br/>";

//Prepare the db for the next query.
$result->close();
$con->next_result();

$sql = "call K12_TEACHER_GETSCHOOLEDUBACK('" .$_SESSION['email']. "')";
$result = mysqli_query($con, $sql) or die(mysqli_error($con)); //send the query to the database or quit if cannot connect
$field = mysqli_fetch_array($result); //the query results are objects, in this case, an array

//Prepare the db for the next query.
$result->close();
$con->next_result();

//convert the database pulls to a more professional format.

switch ($field[1]) {
        
    case "phd":
        $eduLevel = "Ph.D.";
        break;
    case "ms":
        $eduLevel = "M.S.";
        break;
    default:
        $eduLevel = "B.S.";
        break;
}

$school = $field[0];


?>


<div class="row">
    
    <h3>Dashboard</h3>
    
    <ul class='nav nav-tabs'>
        <li class='active'><a href='#account'>Account Information</a></li>
        <li><a href='#events'>Manage Your Events</a></li>
    </ul>
    
    
    <p>
        
        <div class='tab-content'>
            
            <div id='account' class='tab-pane fade in active'>
    
        <?php
                
        echo $msg;
        
        echo "<b>Name: &nbsp;&nbsp;</b><span id='firstName'>" . $fn . "</span> <span id='lastName'>" . $ln . "</span>&nbsp;&nbsp;<span id='nameArea'><span id='updateName'>Update Name</span></span><br/>";
        echo "<b>School: &nbsp;&nbsp;</b><span id='school'>" . $school . "</span>&nbsp;&nbsp;<span id='schoolArea'><span id='updateSchool'>Update School</span></span><br/>";
        echo "<b>Education Level: &nbsp;&nbsp;</b><span id='education'>" . $eduLevel . "</span>&nbsp;&nbsp;<span id='eduArea'><span id='updateEdu'>Update Education Level</span></span><br/>";
        
        ?>
    
    </p>
    <h4><a href="changepw.php">Change Password</a></h4>
    
            </div>
    
            <div id='events' class='tab-pane fade'>
        
                <?php
                
                //Pull all events from the database for the event manager
                
                $sql = "select * From K12_EVENTS WHERE TeacherID = '".$_SESSION["teacherID"] ."'";
                $result = mysqli_query($con, $sql) or die(mysqli_error($con)); //send the query to the database or quit if cannot connect
                $areResults = false;
                
                //Format and display all the events into a readable format

                while($row = mysqli_fetch_array($result))
                {
                    $areResults = true;
                    $t = $row['Title'];
                    $sd = $row['StartDate'];
                    $ed = $row['EndDate'];
                    $des = $row['Description'];
                    $eID = $row['EventID'];
                    if ($des == "") {
                        
                        $des = "No details available.";
                        
                    }
                    
                    //Convert the numeric values to a more readable format.  The start and end time will be seperated into date,
                    //start time, and end time.
                    
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
                    if ($hour[0] == 0)
                        $hour = substr($hour, 1, 1);
                    $ampm = "A.M.";
                    if ($hour > 12) {
                        $hour -= 12;
                        $ampm = "P.M.";
                    }
                    $mins = substr($sd, 14, 2);
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
                    
                    echo "<div id='".$eID."'>
                    <table>
                        <tr>
                            <td><label><b>Event Name: </b></label></td>
                            <td>".$t."</td>
                        </tr>
                        <tr>
                            <td><label><b>Date: </b></label></td>
                            <td>".$date."</td>
                        </tr>
                        <tr>
                            <td><label><b>Start Time: </b></label></td>
                            <td>".$startTime."</td>
                        </tr>
                        <tr>
                            <td><label><b>End Time: </b></label></td>
                            <td>".$endTime."</td>
                        </tr>
                        <tr>
                            <td><label><b>Description: </b></label></td>
                            <td>".$des."</td>
                        </tr>
                    </table> <button id='bName' value='".$eID."' onclick='deleteEvent(this.value)'>Delete Event</button> <br/><br/>
                    </div>";
                    
                    
                
                }
                
                if ($areResults == false)
                    echo "<b>You have no events to display.</b>"
                
                
                ?>
                
                
            </div>
        
    </div>
    

</div>

<script>
    
    //initialize the tabs from bootstrap.
    
    $(document).ready(function(){
        $('.nav-tabs a').click(function(){
            $(this).tab('show');
        });
    });
    
    
</script>





<!-- Include the footer.  This includes the javascript. -->
<?php
include "footer.php";
?>
