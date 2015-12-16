<!-- Include the header -->
<?php
include "header.php";
require_once "inc/util.php";
require_once "inc/dbconnect.php";
?>


    
<div class="row">

    
    				<h3>Reset Password.</h3>
			
				
                <?php

                    $code = "";
                    $code = $_GET['u'];
                    $pw = "";
                    $pwc = "";
                    $msg = "";
                    $passMatch = false;
                    $passFields = true;
                    
                    $finished = false;
                    
                
                    //This only runs if the submit button has been clicked.

                    if (isset($_POST['enter'])) {
                        
                        if (isset($_POST['pw']))
                        {
                            $pw = trim($_POST['pw']);
                        }
                        if (isset($_POST['pwc']))
                        {
                            $pwc = trim($_POST['pwc']);
                        }
                        
                        //Ensure all the fields are filled out in the correct format
                        
                        if (!pwdValidate($pw)) {
                            $msg = $msg . "<b>Your new Password must be at least 10 characters in length and contain
                            both numbers and letters.</b><br /><br/>";
                            $passFields = false;
                         }
                        if ($pw == $pwc) {
                            $passMatch = true;
                        }
                        else
                            $msg = $msg . "<b>Your passwords must match.</b><br /><br/>";
                        
                        if ($passFields && $passMatch) {
                            
                            
                            //Change the pw
                        
                            $pw = mysqli_real_escape_string($con, $pw);
                            
                            //Hash the password before sending it to the database.
                            
                            $pw = password_hash($pw, PASSWORD_BCRYPT);

                            $sql = "UPDATE K12_TEACHER SET Password = '" .$pw. "' WHERE Password = '" .$code. "'";
                        
                            $result = mysqli_query($con, $sql) or die(mysqli_error($con)); //send the query to the database or quit if cannot connect
                            
                            $msg = "<b>Your password has been successfully changed.";
                            $finished = true;
                            
                            
                        }
                        
                        
                    }
                
                
                
                
                    
                ?>
			
                <?php 
                    
                    print $msg;

                ?>
                
                <br />
                <br />
                
                <?php 
                    
                if ($finished == false) {
                    echo '<form action="resetPass.php?u='.$code.'" method="post">
                    New Password: <input type="password" maxlength = "50" name="pw" id="pw"   /> <br />   
                    
                    Confirm New: <input type="password" maxlength = "50" name="pwc" id="pwc"   />
                
                    <input name="enter" class="btn" type="submit" value="Submit" />
			
                    </form>';
                }

                ?>
                
    
</div>





<!-- Include the footer.  This includes the javascript. -->
<?php
include "footer.php";
?>
