<!-- Include the header -->
<?php
include "header.php";
require_once "inc/dbconnect.php";
require_once "inc/util.php";

if (!isset($_SESSION['username'])) {
    header ('Location: login.php');
}

?>


<?php

$msg = "";
$t="";
$m="";
$d="";
$y="";
$date="";

//runs if the enter button is pressed
if (isset($_POST['addEvent']))
{	            
                
    //checking to make sure a value is input for each field before trying to set the variable to equal that value.
    if (isset($_POST['title']))
        $t = trim($_POST['title']);
    
    if (isset($_POST['month']))
        $m = trim($_POST['month']);
				
    if (isset($_POST['day']))
        $d = trim($_POST['day']);
    
    if (isset($_POST['year']))
        $y = trim($_POST['year']);
    
    $t = mysqli_real_escape_string($con, $t);
    $m = mysqli_real_escape_string($con, $m);
    $d = mysqli_real_escape_string($con, $d);
    $y = mysqli_real_escape_string($con, $y);
    
    $date = $y . "-" . $m . "-" . $d;

    $code = randomCodeGenerator(25);
    $sql = "insert into EVENTS values('".$t."', '".$date."', '0', '".$code."')";  
    $result= mysqli_query($con, $sql) or die(mysqli_error($con)); //a non-select statement query will return a result indicating if the 
    if ($result) $msg = "<b>Your information is entered into the database. </b>";
    
}

				








?>


<style>

    input[type="text"] {
        
        display:inline;
        
    }


</style>



    
<div class="row">
    
    <?php
    echo $msg;
    ?>


    <h3>Add Event to Calendar</h3>
    
    <form action="addEvent.php" method="post">
    <div class="form-group">
    
        Event Title:<input type="text" maxlength="50" name="title"><br/>
        Date:  
        <input type="text"  maxlength="2" name="month" value="mm" style="width:50px">/
        <input type="text"  maxlength="2" name="day" value="dd" style="width:50px">/
        <input type="text"  maxlength="4" name="year" value="yyyy" style="width:60px">
        <br/><button name="addEvent">Add Event</button>
    
    
    
    </div>
    </form>
    
    

</div>





<!-- Include the footer.  This includes the javascript. -->
<?php
include "footer.php";
?>
