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

<?php

$opw = "";
$npw = "";
$msg = "";

//Greet the user

$sql = "select FirstName, LastName from K12_TEACHER where Email = '" .$_SESSION['email']. "'";
$result = mysqli_query($con, $sql) or die(mysqli_error($con)); //send the query to the database or quit if cannot connect
$field = mysqli_fetch_array($result); //the query results are objects, in this case, one object
$msg = "Welcome " . $field[0] . " " . $field[1] . "!<br/><br/>";
?>


<div class="row">


    <h3>Account Management</h3>
    
    <?php
    echo $msg;
    ?>
    
    <h4><a href="changepw.php">Change Password</a></h4>
    
        

</div>





<!-- Include the footer.  This includes the javascript. -->
<?php
include "footer.php";
?>
