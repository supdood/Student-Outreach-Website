<?php
	include "header.php";
    require_once "inc/util.php";
    require_once "mail/mail.class.php";
    require_once "inc/dbconnect.php";
?>

<?php
			
//initializing variables to be used
$fn = "";
$ln = "";
$em = "";
$emc = "";
$pw = "";
$pwc = "";
$terms = "";
$msg = "";
$fnre = "*";
$lnre = "*";
$emre="*";
$emcre = "*";
$pwre = "*";
$pwcre = "*";
$emMatch = false;
$pwMatch = false;
$are = "*";
$act = "no";
$ere = "*";
$sre = "*";
$e = "";
$s = "";
$b = "";
            
//A variable that verifies if all fields are filled in correctly.  Defaults to true but becomes false if any pass fails.
$fields = true;
			
			
//runs if the enter button is pressed
if (isset($_POST['submit']))
{

	
//checking to make sure the email is valid before setting $em to the email value input by the user. If it isn't valid, we turn the asterisk red. 
    if (!filter_input(INPUT_POST, 'email',FILTER_VALIDATE_EMAIL))
        $emre = '<span style="color:red">*</span>';
    else if ($_POST['email'] == $_POST['emailConfirm']) {
        $emMatch = true;
        $em = trim($_POST['email']);
    }
				
    //checking to make sure the password matches with what is entered into the "Confirm Password" field. If it is, set $pwMatch to true.
    if ($_POST['password'] == $_POST['passwordConfirm']) {
        $pwMatch = true;
    }
				
    //checking to make sure a value is input for each field before trying to set the variable to equal that value.
    if (isset($_POST['firstName']))
        $fn = trim($_POST['firstName']);
    if (isset($_POST['lastName']))
        $ln = trim($_POST['lastName']);
    if (isset($_POST['password']))
        $pw = trim($_POST['password']);
    if (isset($_POST['school']))
        $s = trim($_POST['school']);
    if (isset($_POST['edulvl']))	
        $e = trim($_POST['edulvl']);
    if (isset($_POST['background']))
        $b = trim($_POST['background']);
				
				
    //various checks to make sure a value has been put into each field.
				
    if ($fn== "")
        $fnre = '<span style="color:red">*</span>';
				
    if ($ln== "")
        $lnre = '<span style="color:red">*</span>';
                
    if ($pw== "")
        $pwre = '<span style="color:red">*</span>';

    if ($e== "")
        $ere = '<span style="color:red">*</span>';
    
    if ($s== "")
        $sre = '<span style="color:red">*</span>';
				


    //various error messages for each field.  The user will only be directed to the next page if all fields pass these test.
    if ($fnre != "*") {
        $msg = $msg . "<br /><b>Please fill the First Name field.</b>";
        $fields = false;
    }
    if ($lnre != "*") {
        $msg = $msg . "<br /><b>Please fill the Last Name field.</b>";
        $fields = false;
    }
    if ($emre != "*") {
        $msg = $msg . "<br /><b>Please fill the Email field.</b>";
        $fields = false;
    }
    if ($pwre != "*") {
        $msg = $msg . "<br /><b>Please fill the Password field.</b>";
        $fields = false;
    }
    if ($sre != "*") {
        $msg = $msg . "<br /><b>Please fill the School field.</b>";
        $fields = false;
    }
    if ($ere != "*") {
        $msg = $msg . "<br /><b>Please fill the Education field.</b>";
        $fields = false;
    }
    else if (!pwdValidate($pw)) {
        $msg = $msg . "<br /><b>Your Password must be at least 10 characters in length and contain both numbers and letters.</b>";
        
        $fields = false;
    }
    if ($are != "*") {
        $msg = $msg . "<br /><b>Please agree to the terms and conditions.</b>";
        $fields = false;
    }
    else if (!$emMatch) {
        $msg = $msg . "<br /><b>Please enter matching emails.</b>";
        $fields = false;
    }
    else if (!$pwMatch) {
        $msg = $msg . "<br /><b>Please enter matching passwords.</b>";
        $fields = false;
    }
    else if ($fields == true) {
                            
        //This is used to prevent sql injections.
        $em = mysqli_real_escape_string($con, $em);
        $pw = mysqli_real_escape_string($con, $pw);
        $pw = password_hash($pw, PASSWORD_BCRYPT);
                    
        //first check if the email already exists in the database
        //$sql = "select count(*) as c from K12_TEACHER where Email = '" . $em. "'";
        $sql = "call K12_TEACHER_COUNTFORREGISTRATION('".$em."');";  // use stored procedure

        //$sql = "call K12_TEACHER_COUNTFORREGISTRATION($em)";    // use stored procedure

                    
                    
        $result = mysqli_query($con, $sql) or die("Error in the consult.." . mysqli_error($con)); //send the query to the database or quit if cannot connect
        $count = 0;
        $field = mysqli_fetch_object($result); //the query results are objects, in this case, one object
        $count = $field->c;
        
        $result->close();
        $con->next_result();
        
        if ($count != 0)
        {	
            Header ("Location:login.php") ;				
        }
        else //the email doesn't exist yet
        {	
            $code = randomCodeGenerator(50);

            //$sql = "insert into K12_TEACHER values('', '".$em."', '".$fn."', '".$ln."', '".$s."', '".$e."', '".$b."', '".$pw."', 'no', '".$code."', '3')";  

            $sql = "call K12_TEACHER_INSERTNEWTEACHER('".$em."', '".$fn."', '".$ln."', '".$s."', '".$e."', '".$b."', '".$pw."', 'no', '".$code."');"; // stored procedure
            $result= mysqli_query($con, $sql) or die(mysqli_error($con)); //a non-select statement query will return a result indicating if the 
                        
            if ($result) $msg = "<b>Your information is entered into the database. </b>";
            //direct to the next page if necessary
                    
                     
                     
                        
            //If all fields are valid, a random code is generated and emailed to the user's given email.
                    
            $subject = "Email Activation";
            $body = "Your code is " . $code . "<br /><br />Please finish registration by inputting your code at http://corsair.cs.iupui.edu:20741/studentOutreach/activation.php?c=".$code;
            $mailer = new Mail();
                    
            if (($mailer->sendMail($em, $fn, $subject, $body))==true){
														
                //This essentially logs the user in by telling the session the email of the user.
                            
                $_SESSION['email'] = $em;
                
                $sql = "select AccessLevel From K12_TEACHER WHERE Email = '" .$_SESSION['email']."'";
                $result = mysqli_query($con, $sql) or die(mysqli_error($con)); //send the query to the database or quit if cannot connect
                $access = mysqli_fetch_array($result);
                $_SESSION['access'] = $access[0];
                
                $sql = "SELECT ID FROM K12_TEACHER WHERE Email = '".$em."'";
                $result = mysqli_query($con, $sql) or die(mysqli_error($con)); //send the query to the database or quit if cannot connect
                $tID = mysqli_fetch_array($result);
                $_SESSION['teacherID'] = $tID[0];
                            
                //direct to another file to the confirmation page using query strings
                Header ("Location:confirmation.php");
                    
                        }
            else {
                $msg = "Email not sent. " .' '. $fn.' '. $subject.' '. $body;
            }
                        
                        
                        
                        
        }
    }
}
?>

<?php

    echo $msg;

?>



	<form id="login_form" action="signup.php" method="post">
		<div>
			<label for="firstName">First Name <?php print $fnre; ?></label>
			<input type="text" name="firstName"/>
		</div>
		<div>
			<label for="lastName">Last Name <?php print $lnre; ?></label>
			<input type="text" name="lastName"/>
		</div>
		<div>
			<label for="school">School <?php print $sre; ?></label>
			<input type="text" name="school"/>
		</div>
		<div>
			<label for="edulvl">Education Level <?php print $ere; ?></label>
			<select name="edulvl">
            			<option value="bs" selected="selected">B.S.</option>
            			<option value="ms">M.S.</option>
            			<option value="phd">Ph.D</option>
        		</select>
		</div>
		<div id="signup_background">
			<label for="background">Background</label>
			<textarea type="paragraph_text" rows="5" cols="25" name="background"></textarea>
		</div>
        <div>
			<label for="email">Email <?php print $emre; ?></label>
			<input type="text" name="email"/>
		</div>
        <div>
			<label for="email">Confirm Email <?php print $emcre; ?></label>
			<input type="text" name="emailConfirm"/>
		</div>
		<div>
			<label for="email">Password <?php print $pwre; ?></label>
			<input type="password" name="password"/>
		</div>
        <div>
			<label for="email">Confirm Password <?php print $pwcre; ?></label>
			<input type="password" name="passwordConfirm"/>
		</div>
		<div>
        		<button type="submit" name="submit">submit</button>
    		</div>
	</form>
<?php
    include "footer.php";
?>
<html>
