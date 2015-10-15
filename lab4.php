<!--
Ethan Fetsko
Sign Up/Registration Page
File: lab4.php
Date: October 11, 2015
-->


<?php if(!isset($_SESSION)){session_start();
                           $_SESSION['discard_after'] = time() + 3600;}

$now = time();
if (isset($_SESSION['discard_after']) && $now > $_SESSION['discard_after']) {
    // this session has worn out its welcome; kill it and start a brand new one
    session_unset();
    session_destroy();
    session_start();
}

include "header.php";
require_once "inc/util.php";
require_once "mail/mail.class.php";
require_once "inc/dbconnect.php";


?>
	<div id="contents">
		<div>
			<div class="body"  id="gallery">
				
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
            
            //A variable that verifies if all fields are filled in correctly.  Defaults to true but becomes false if any pass fails.
            $fields = true;

			
			
			//runs if the enter button is pressed
			if (isset($_POST['enter']))
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
				if (isset($_POST['gender']))
					$gender = trim($_POST['gender']);
				if (isset($_POST['status']))	
					$stat = trim($_POST['status']);
				if (isset($_POST['department']))
					$dep = trim($_POST['department']);
				if (isset($_POST['agree']))	
					$terms = trim($_POST['agree']);
				
				
				//various checks to make sure a value has been put into each field.
				
                if ($fn== "")
					$fnre = '<span style="color:red">*</span>';

				if ($ln== "")
					$lnre = '<span style="color:red">*</span>';
                
                if ($pw== "")
					$pwre = '<span style="color:red">*</span>';

				if ($terms== "")
					$are = '<span style="color:red">*</span>';
				

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
                else if (!pwdValidate($pw)) {
                    $msg = $msg . "<br /><b>Your Password must be at least 10 characters in length and contain
                    both numbers and digits.</b>";
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
					$pwd = mysqli_real_escape_string($con, $pw);
                    
                    //first check if the username already exists in the database
					$sql = "select count(*) as c from ACCOUNT_INFO where Email = '" . $em. "'";
					print $sql;
                    
                    
                    $result = mysqli_query($con, $sql) or die("Error in the consult.." . mysqli_error($con)); //send the query to the database or quit if cannot connect
					$count = 0;
					$field = mysqli_fetch_object($result); //the query results are objects, in this case, one object
					$count = $field->c;
					if ($count != 0)
					{	Header ("Location:login.php?l=r") ;
						//print "count is ".	$count;					
					}
					else //the username doesn't exist yet
					{	
                        $code = randomCodeGenerator(50);
                        $sql = "insert into ACCOUNT_INFO values('".$fn."', '".$ln."', '".$em."', '".$pw."', '".$code."', '".$act."')";  
						print $sql;
						$result= mysqli_query($con, $sql) or die(mysqli_error($con)); //a non-select statement query will return a result indicating if the 
                        
						if ($result) $msg = "<b>Your information is entered into the database. </b>";
						//direct to the next page if necessary
                    
                     
                     
                        
                        //If all fields are valid, a random code is generated and emailed to the user's given email.
                    
                        $subject = "Email Activation";
                        $body = "Your code is " . $code . "<br /><br />Please finish registration by inputting your code at http://corsair.cs.iupui.edu:20741/lab4/activation.php";
                        $mailer = new Mail();
                    
                        if (($mailer->sendMail($em, $fn, $subject, $body))==true){
														
                            //This essentially logs the user in by telling the session the email of the user.
                            
                            $_SESSION['email'] = $em;
                            
					       //direct to another file to the confirmation page using query strings
					       Header ("Location:confirmation.php");
                    
                        }
					   else {
                            $msg = "Email not sent. " . $uname.' '. $fn.' '. $subject.' '. $body;
                        }
                        
                        
                        
                        
                    }
				}
			}
		?>

		<form action="lab4.php" method="post">
			<h1>User Registration</h1>
			
			<?php
				print $msg;
			?>
			<br />
			<br />
            First Name: <?php print $fnre; ?>
				 <input type="text" maxlength = "50" value="<?php print $fn; ?>" name="firstName" id="firstName"   /> <br />	
			Last Name: <?php print $lnre; ?>
				<input type="text" maxlength = "50" value="<?php print $ln; ?>" name="lastName" id="lastName"   />  <br />
			Email: <?php print $emre; ?>
				<input type="text" maxlength = "50" value="<?php print $em; ?>" name="email" id="email"   />  <br />	
			Confirm Email: <?php print $emcre; ?>
				<input type="text" maxlength = "50" value="<?php print $emc; ?>" name="emailConfirm" id="emailConfirm"   />  <br />
			Password: <?php print $pwre; ?>
						<input type="password" maxlength = "50" value="<?php print $pw; ?>" name="password" id="password"   />  <br />
			Confirm Password: <?php print $pwcre; ?>
				<input type="password" maxlength = "50" value="<?php print $pwc; ?>" name="passwordConfirm" id="passwordConfirm"   />  <br />
			<?php print $are; ?> <input type="checkbox" name = "agree" value = "y" />
			I agree to the terms and conditions.

			<input name="enter" class="btn" type="submit" value="Submit" />
		</form>


				
				
				
		
			</div>
		</div>
	</div>
	<div id="footer">
		<div>
			<div id="links">
				<div class="showroom">
					<h4>Visit our Showroom</h4>
					<a href="gallery.html"><img src="images/show-room.png" alt="Img"></a>
					<p>
						4885 Wilson Street<br> Victorville, CA 92392<br><br> 760-962-9541<br><br> <a href="index.html">info@carvedcreations.com</a>
					</p>
				</div>
				<div>
					<h4>Recent Blog Posts</h4>
					<ul class="posts">
						<li>
							<span class="time">Apr 16</span>
							<p>
								<a href="blog.html">The Carving Master &amp; Owner</a> Maybe you’re looking for something diferent, something special.
							</p>
						</li>
						<li>
							<span class="time">Apr 15</span>
							<p>
								<a href="blog.html">5 Star Hotels We Supply</a> And we love the challenge of doing something diferent and something special.
							</p>
						</li>
						<li>
							<span class="time">Apr 14</span>
							<p>
								<a href="blog.html">How To Pick The Right Furniture For You</a> What’s more, they’re absolutely free! You can do a lot with them.
							</p>
						</li>
					</ul>
				</div>
				<div>
					<form action="#" method="post" id="newsletter">
						<h4>Join Our Newsletter</h4>
						<input type="text" value="Enter Email Address Here For Updates" onBlur="javascript:if(this.value==''){this.value=this.defaultValue;}" onFocus="javascript:if(this.value==this.defaultValue){this.value='';}">
						<input type="submit" value="Sign up" class="btn2">
					</form>
					<div id="connect">
						<h4>Social Media</h4>
						<a href="http://freewebsitetemplates.com/go/facebook/" target="_blank" class="facebook"></a> <a href="http://freewebsitetemplates.com/go/googleplus/" target="_blank" class="googleplus"></a> <a href="http://freewebsitetemplates.com/go/twitter/" target="_blank" class="twitter"></a>
					</div>
				</div>
			</div>
			<ul class="navigation">
				<li>
					<a href="index.html">Home</a>
				</li>
				<li>
					<a href="about.html">About</a>
				</li>
				<li>
					<a href="gallery.html">Gallery</a>
				</li>
				<li>
					<a href="blog.html">Blog</a>
				</li>
				<li>
					<a href="contact.html">Contact</a>
				</li>
			</ul>
			<p id="footnote">
				© Copyright 2023. All Rights Reserved.
			</p>
		</div>
	</div>
</body>
</html>