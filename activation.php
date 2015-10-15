<!--
Ethan Fetsko
Activation Page
File: activation.php
Date: October 11, 2015
-->

<?php session_start();

include "header.php";
require_once "inc/dbconnect.php";

?>
	<div id="contents">
		<div>
			<div class="body"  id="gallery">
			
				<h1>Complete Registration.</h1>
			
				
                <?php

                    $code = "";
                    $em = "";
                    $pw = "";
                    $msg = "Please type in your login information and the activation code to complete registration.";
                    
                
                    //This only runs if the submit button has been clicked.

                    if (isset($_POST['enter'])) {
                        
                        if (isset($_POST['code']))
                        {
                            $code = trim($_POST['code']);
                        }
                        if (isset($_POST['email']))
                        {
                            $em = trim($_POST['email']);
                        }
                        if (isset($_POST['password']))
                        {
                            $pw = trim($_POST['password']);
                        }
                        
                        //Authentication
                        
                        $code = mysqli_real_escape_string($con, $code);
                        $em = mysqli_real_escape_string($con, $em);

					   $sql = "select count(*) as c from ACCOUNT_INFO where Email = '" . $em. "' and AccNumber = '".$code. "'";
					   $result = mysqli_query($con, $sql) or die(mysqli_error($con)); //send the query to the database or quit if cannot connect
					   $field = mysqli_fetch_object($result); //the query results are objects, in this case, one object
					   $count = $field->c;
					
					   if ($count > 0) {
						  
                           $sql = "UPDATE ACCOUNT_INFO SET Activation = 'yes' WHERE Email = '" .$em. "' and AccNumber = '".$code. "'";
                           $result = mysqli_query($con, $sql) or die(mysqli_error($con)); //send the query to the database or quit if cannot connect
                           
                           Header ("Location:account.php") ;
                       }
					   else $msg = "The information entered does not match with the records in our database.";
                        
                        
                        
                    }
                
                
                
                
                    
                ?>
			
                <?php 
                    
                    print $msg;

                ?>
                
                <br />
                <br />
                
                <form action="activation.php" method="post">
                
                Email: <input type="text" maxlength = "50" value="<?php print $em; ?>" name="email" id="email"   /> <br />   
                    
                Activation Code: <input type="text" maxlength = "50" value="<?php print $code; ?>" name="code" id="code"   />
                
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