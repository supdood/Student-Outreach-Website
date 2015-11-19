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


    <h3>Account Management</h3>
    
    <?php
    echo $msg;
    ?>
    
    <p>
    
        <?php
        
        echo "<b>Name: &nbsp;&nbsp;</b><span id='firstName'>" . $fn . "</span> <span id='lastName'>" . $ln . "</span>&nbsp;&nbsp;<span id='nameArea'><span id='updateName'>Update Name</span></span><br/>";
        echo "<b>School: &nbsp;&nbsp;</b><span id='school'>" . $school . "</span>&nbsp;&nbsp;<span id='schoolArea'><span id='updateSchool'>Update School</span></span><br/>";
        echo "<b>Education Level: &nbsp;&nbsp;</b><span id='education'>" . $eduLevel . "</span>&nbsp;&nbsp;<span id='eduArea'><span id='updateEdu'>Update Education Level</span></span><br/>";
        
        ?>
    
    </p>
    <h4><a href="changepw.php">Change Password</a></h4>
    
        

</div>





<!-- Include the footer.  This includes the javascript. -->
<?php
include "footer.php";
?>
