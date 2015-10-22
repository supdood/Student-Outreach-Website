<!-- Include the header -->
<?php
include "header.php";
require_once "inc/util.php";
require_once "inc/dbconnect.php";

if (!isset($_SESSION['username'])) {
    header ('Location: login.php');
}

?>

<?php

$em = "";
$opw = "";
$npw = "";
$msg = "";
$passFields = true;

if (isset($_POST['enter'])) {
                        
    if (!filter_input(INPUT_POST, 'email',FILTER_VALIDATE_EMAIL)) {
        $msg = '<b>Please enter a valid email.</b>';
        $passFields = false;
    }
    else {
        $em = trim($_POST['email']);
    }
    if (isset($_POST['oldpw'])) {
    $opw = trim($_POST['oldpw']);
    }                    
    if (isset($_POST['newpw']))
    {
        $npw = trim($_POST['newpw']);
    }
    if (!pwdValidate($npw)) {
        $msg = $msg . "<br /><b>Your new Password must be at least 10 characters in length and contain
        both numbers and digits.</b>";
        $passFields = false;
    }
                        
    if ($passFields == true) {
                        
        //Authentication
                        
        $em = mysqli_real_escape_string($con, $em);
        $opw = mysqli_real_escape_string($con, $opw);
        $npw = mysqli_real_escape_string($con, $npw);

        $sql = "select Password from REGISTRATION where UserName = '" . $em. "' and Password = '".$opw. "'";
        //print $sql. ' ' . $_SESSION['email'];
        $result = mysqli_query($con, $sql) or die(mysqli_error($con)); //send the query to the database or quit if cannot connect
        $field = mysqli_fetch_array($result); //the query results are objects, in this case, one object
					
        if ($opw == $field[0]) {
						  
            $sql = "UPDATE REGISTRATION SET Password = '" .$npw. "' WHERE UserName = '" .$em. "' and Password = '".$opw. "'";
            $result = mysqli_query($con, $sql) or die(mysqli_error($con)); //send the query to the database or quit if cannot connect
            $msg = "Your password has been successfully changed. <br/><br/>";
            //Header ("Location:account.php") ;
        }
        else $msg = "The information entered does not match with the records in our database. <br/><br/>";
                        
                        
                        
    }                
}
?>


<div class="row">


    <h3>Change Password</h3>
    
    <?php
    echo $msg;
    ?>
    
    <form action="changepw.php" method="post">
                
        Email: <input type="text" maxlength = "50" value="<?php print $em; ?>" name="email" id="email"   /> <br />       
                    
        Old Password: <input type="password" maxlength = "50" value="<?php print $opw; ?>" name="oldpw" id="oldpw"   /> <br />   
                    
        New Password: <input type="password" maxlength = "50" value="<?php print $npw; ?>" name="newpw" id="newpw"   />
                
        <input name="enter" class="btn" type="submit" value="Submit" />
			
    </form>
    
    

</div>





<!-- Include the footer.  This includes the javascript. -->
<?php
include "footer.php";
?>
