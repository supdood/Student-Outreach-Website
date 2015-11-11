<!-- Include the header -->
<?php
include "header.php";
require_once "inc/dbconnect.php";

if (!isset($_SESSION['email'])) {
    header ('Location: login.php');
}
else {
    $sql = "select Authenticated From K12_TEACHER WHERE Email = '" .$_SESSION['email']."'";
    $result = mysqli_query($con, $sql) or die(mysqli_error($con)); //send the query to the database or quit if cannot connect
    $activated = mysqli_fetch_array($result);
    if ($activated[0] == 'no')
    Header ("Location:activation.php") ;
     }

?>

<script src="js/account.js"></script>

<?php

$opw = "";
$npw = "";
$msg = "";
$eduLevel="";

//Greet the user

$sql = "select FirstName, LastName, School, Education, CSBackground from K12_TEACHER where Email = '" .$_SESSION['email']. "'";
$result = mysqli_query($con, $sql) or die(mysqli_error($con)); //send the query to the database or quit if cannot connect
$field = mysqli_fetch_array($result); //the query results are objects, in this case, one object
$msg = "Welcome <span id='greeting'>" . $field[0] . " " . $field[1] . "</span>!<br/><br/>";

switch ($field[3]) {
        
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

?>


<div class="row">


    <h3>Account Management</h3>
    
    <?php
    echo $msg;
    ?>
    
    <p>
    
        <?php
        
        echo "<b>Name: &nbsp;&nbsp;</b><span id='firstName'>" . $field[0] . "</span> <span id='lastName'>" . $field[1] . "</span>&nbsp;&nbsp;<span id='nameArea'><span id='updateName'>Update Name</span></span><br/>";
        echo "<b>School: &nbsp;&nbsp;</b><span id='school'>" . $field[2] . "</span>&nbsp;&nbsp;<span id='schoolArea'><span id='updateSchool'>Update School</span></span><br/>";
        echo "<b>Education Level: &nbsp;&nbsp;</b><span id='education'>" . $eduLevel . "</span>&nbsp;&nbsp;<span id='eduArea'><span id='updateEdu'>Update Education Level</span></span><br/>";
        
        ?>
    
    </p>
    <h4><a href="changepw.php">Change Password</a></h4>
    
        

</div>





<!-- Include the footer.  This includes the javascript. -->
<?php
include "footer.php";
?>
