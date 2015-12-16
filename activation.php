<!-- Include the header -->
<?php
include "header.php";
require_once "inc/dbconnect.php";
?>


    
<div class="row">

    
    				<h3>Complete Registration.</h3>
			
				
                <?php
    
                    //Looks to see if there is a get set in the url for the confirmation code, if so, it sets a session variable to
                    //remember the code as long as the user is logged in.  Else, it sets the code to an empty string for the 
                    //time being. 

                    $code = "";
                    if (isset($_GET['c'])) {
                        $code = trim($_GET['c']);
                        $_SESSION["code"] = $code;
                    }
                    else if (!isset($_SESSION["code"]))
                        $_SESSION["code"] = "";
                        
                    $em = "";
                    $pw = "";
                    $msg = "Please type in your login information and the activation code to complete registration.";
                    
                
                    //This only runs if the submit button has been clicked.

                    if (isset($_POST['enter'])) {
                        
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

                       $sql = "call K12_TEACHER_VERIFYREGISTRATIONCODE('".$em."', '".$_SESSION['code']."')"; // using stored procedure
					   
                        //TODO: replace $sql below with stored procedure call
                        
                        $result = mysqli_query($con, $sql) or die(mysqli_error($con)); //send the query to the database or quit if cannot connect
                        $field = mysqli_fetch_object($result); //the query results are objects, in this case, one object
                        $count = $field->c;
                        
                        //Prepare the db for the next query.
                        $result->close();
                        $con->next_result();
					
                        //Check to see if there are any teachers matching that email and registration code.
                        
					   if ($count > 0) {

                           $sql = "call K12_TEACHER_AUTHENTICATE('".$em."', '".$_SESSION['code']."')";    // using stored procedure
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
                    
                Activation Code: <input type="text" maxlength = "50" value="<?php print $_SESSION["code"]; ?>" name="code" id="code"   />
                
                <input name="enter" class="btn" type="submit" value="Submit" />
			
                </form>
    
    
</div>





<!-- Include the footer.  This includes the javascript. -->
<?php
include "footer.php";
?>
