<?php
include "header.php";
require_once "inc/util.php";
require_once "inc/dbconnect.php";
require_once "mail/mail.class.php";

$msg = "";

if (isset($_SESSION['email'])) {
    unset($_SESSION['email']);
    session_destroy();
}

?>

<?php
			//initializing variables to be used
			$em = "";

            if (!isset($_SESSION["attempts"]))
                $_SESSION["attempts"] = 0;
            
            //A variable that verifies if all fields are filled in correctly.  Defaults to true but becomes false if any pass fails.
            $fields = true;

			
			
			//runs if the enter button is pressed
			if (isset($_POST['submit']))
			{	
                
                //The location of this is important.  It allows a message to be displayed on the first load of the page
                //but it is written over when the submit button is clicked.
                $msg = "";
				
                if (isset($_POST['email']))
					$em = trim($_POST['email']);

				

				//various error messages for each field.  The user will only be directed to the next page if all fields pass these test.
                //Also, the user is allowed to fail 3 times before he/she is locked out.  
                //Incorrect login info only counts towards this if it is in a valid format.
                if (!filter_input(INPUT_POST, 'email',FILTER_VALIDATE_EMAIL)) {
                    $msg = $msg . "<b>Please enter a valid email address.</b><br />";
                    $fields = false;
                }
				else if ($fields) {
                    
                    $sql = "call K12_TEACHER_COUNTFORREGISTRATION('".$em."');";  // use stored procedure
                    $result = mysqli_query($con, $sql) or die("Error in the consult.." . mysqli_error($con)); 
                    $count = 0;
                    $field = mysqli_fetch_object($result); //the query results are objects, in this case, one object
                    $count = $field->c;
                    
                    //Prepare the db for the next query.
                    $result->close();
                    $con->next_result();
        
                    if ($count > 0) {
                        
                        $em = mysqli_real_escape_string($con, $em);
                        
                        $sql = "call K12_TEACHER_GETPASSWORD('".$em."');";  // use stored procedure

                        $result = mysqli_query($con, $sql) or die(mysqli_error($con)); //send the query to the database or quit if cannot connect
                        $field = mysqli_fetch_array($result);
                    
                        $subject = "Reset Password";
                        $body = "Follow the link to reset your password <a href='http://corsair.cs.iupui.edu:20741/studentOutreach/resetPass.php?u=".$field[0]."'>Click here to reset password.</a>";
                        $mailer = new Mail();
                    
                        if (($mailer->sendMail($em, "", $subject, $body))==true){
														
                            $msg = "<b>Email Sent! Please follow the link in your email to reset your password.</b>";
                        }
                        else {
                            $msg = "Email not sent.";
                        }
                    }
                    else {
                        
                        $msg = "<b>There is no user account with this email.</b>";
                        
                    }

                }
                
            }
		?>

    <div class="row">
        <?php print $msg ?>
    </div>





	<form id="login_form" action="forgotPass.php" method="post">
		<div>
			<label for="name">Email</label>
			<input type="text" name="email"/>
		</div>
		<div>
        		<button type="submit" name="submit">submit</button>
    		</div>
	</form>
<?php
    include "footer.php";
?>
<html>
