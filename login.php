<?php
include "header.php";
require_once "inc/util.php";
require_once "inc/dbconnect.php";
$msg = "";
if (isset($_SESSION['email'])) {
    unset($_SESSION['email']);
    session_destroy();
    $msg = "You have been successfully logged out. <br />";
}
?>

<?php
			//initializing variables to be used
			$em = "";
			$pw = "";
            $userE = "";
            $userP = "";
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
                
				//checking to make sure a value is input for each field before trying to set the variable to equal that value.
				if (isset($_POST['password']))
					$pw = trim($_POST['password']);
				
                if (isset($_POST['email']))
					$em = trim($_POST['email']);
				
				//various error messages for each field.  The user will only be directed to the next page if all fields pass these test.
                //Also, the user is allowed to fail 3 times before he/she is locked out.  
                //Incorrect login info only counts towards this if it is in a valid format.
                if (!filter_input(INPUT_POST, 'email',FILTER_VALIDATE_EMAIL)) {
                    $msg = $msg . "<b>Please enter a valid email address.</b><br />";
                    $fields = false;
                }
                if (!pwdValidate($pw)) {
                    $msg = $msg . "<b>Your Password must be at least 10 characters in length and contain

                    both numbers and letters.</b><br />";
                    $fields = false;
                }
                else if ($_SESSION["attempts"] >= 4) {
                    //The number of incorrect attempts has exceded 3, the user is locked out.
                    $msg = "<b>You have made too many incorrect login attempts.</b><br />";
                }
                /*else if (($pw != $userP) || ($em != $userE)) {
                    $msg = $msg . "<b>Invalid email or password.</b><br />";
                    $fields = false;
                    $_SESSION["attempts"] += 1;
                    //A check on the 4th fail to alert the user that they are now locked out.  Otherwise they would have to attempt a 5th time to know.
                    if ($_SESSION["attempts"] >= 4)
                        $msg = "<b>You have made too many incorrect login attempts.</b><br />";
                }*/
				else if ($fields == true) {
                    
                    $em = mysqli_real_escape_string($con, $em);
                    $pw = mysqli_real_escape_string($con, $pw);
				    //$sql = "select Password From K12_TEACHER where Email = '" . $em. "'";
                    $sql = "call K12_TEACHER_GETPASSWORD('".$em."');";  // use stored procedure
				    $result = mysqli_query($con, $sql) or die(mysqli_error($con)); //send the query to the database or quit if cannot connect
				    $field = mysqli_fetch_array($result);
                    
                    //check to see if the password input matches the hashed pw in the db
                    $match = password_verify($pw, $field[0]);
                    
                    //Prepare the db for the next query.
                    $result->close();
                    $con->next_result();
				    
                    //$count = $field->c;
                    
				    if ($match == true) {
						  
                        $sql = "select Authenticated From K12_TEACHER WHERE Email = '" .$em. "'";
                        //$sql = "call K12_TEACHER_GETAUTHENTICATED_USERNAME_PASSWORD('".$em."', '".$pw."');"; // use stored procedure
                        $result = mysqli_query($con, $sql) or die(mysqli_error($con)); //send the query to the database or quit if cannot connect
                        $activated = mysqli_fetch_array($result);
                        if ($activated[0] == 'yes')
                           Header ("Location:account.php") ;
                        else 
                            Header ("Location:activation.php") ;
                        
                        $_SESSION['email'] = $em;
                        
                        $sql = "select AccessLevel From K12_TEACHER WHERE Email = '" .$_SESSION['email']."'";
                        $result = mysqli_query($con, $sql) or die(mysqli_error($con)); //send the query to the database or quit if cannot connect
                        $access = mysqli_fetch_array($result);
                        $_SESSION['access'] = $access[0];
                        
                        $sql = "SELECT ID FROM K12_TEACHER WHERE Email = '".$em."'";
                        $result = mysqli_query($con, $sql) or die(mysqli_error($con)); //send the query to the database or quit if cannot connect
                        $tID = mysqli_fetch_array($result);
                        $_SESSION['teacherID'] = $tID[0];
                        
                        
                    }
				    else $msg = "<br/><b>Login failed. Incorrect login information.</b>";
                }
            }
		?>

    <div class="row">
        <?php print $msg ?>
    </div>





	<form id="login_form" action="login.php" method="post">
		<div>
			<label for="name">Email</label>
			<input type="text" name="email"/>
		</div>
		<div>
			<label for="password">Password</label>
			<input type="password" name="password"/>
		</div>
        <a href="forgotPass.php">Forgot your password?</a><br/><br/>
		<div>
        		<button type="submit" name="submit">submit</button>
    		</div>
	</form>
<?php
    include "footer.php";
?>
<html>