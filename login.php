<!--
Ethan Fetsko
Lab 4
Log in Page
File: login.php
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



$msg = "";

if (isset($_SESSION['email'])) {
    unset($_SESSION['email']);
    session_destroy();
    $msg = "You have been successfully logged out. <br />";
}

include "header.php";
require_once "inc/util.php";
require_once "inc/dbconnect.php";


?>
	<div id="contents">
		<div>
			<div class="body"  id="gallery">
				
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
			if (isset($_POST['enter']))
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
                    both numbers and digits.</b><br />";
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
                    $_SESSION['email'] = $em;

				    $sql = "select count(*) as c from ACCOUNT_INFO where Email = '" . $em. "' and Password = '" .$pw. "'";
				    //print $sql. ' ' . $_SESSION['email'];
				    $result = mysqli_query($con, $sql) or die(mysqli_error($con)); //send the query to the database or quit if cannot connect
				    $field = mysqli_fetch_object($result); //the query results are objects, in this case, one object
				    $count = $field->c;
					
				    if ($count > 0) {
						  
                        $sql = "select Activation From ACCOUNT_INFO WHERE Email = '" .$em. "' and Password = '".$pw. "'";
                        $result = mysqli_query($con, $sql) or die(mysqli_error($con)); //send the query to the database or quit if cannot connect
                        $activated = mysqli_fetch_array($result);
                        if ($activated[0] == 'yes')
                           Header ("Location:account.php") ;
                        else Header ("Location:activation.php") ;
                    }
				    else $msg = "The information entered does not match with the records in our database.";
                    
                    
                    
                }
            }
		?>

		<form action="login.php" method="post">
			<h1>Sign In</h1>
			<?php
				print $msg;
			?>
			<br />
			Email:
				<input type="text" maxlength = "50" value="<?php print $em; ?>" name="email" id="email"   />  <br />	
			Password:
						<input type="password" maxlength = "50" value="<?php print $pw; ?>" name="password" id="password"   />  <br />
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