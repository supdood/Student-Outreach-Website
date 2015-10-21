<?php
	include "header.php";

	if (isset($_POST['sbmt'])) {
		while (!filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL)) {
			echo "Please enter a valid email.";
		}
		/*
		try {
		$link = "";
		$_SESSION['uid'] = $_POST['uid'];
		$db = new mysqli('localhost', 'whitdac', 'whitdac', 'whitdac_db');
		$q = "INSERT INTO whitdac_db VALUES ('$_POST['firstName']', '$_POST['lastName']',
		     '$_POST['school']', '$_POST['email']', '$_POST['edulvl']', '$_POST['background']', 
		     '$_POST['uid']')"; 
		$db->query($q) or die($db->error);
		$db->close();
		*/
		mail($_POST['email'], "Confirmation", "Thank you for registering with the Student Outreach program! Please complete
			 your registraiton and submit the following confirmation code at: ".$link." code: ".rand(10000000, 99999999));
		Header("Location: index.php");
		/*
		} catch (PDOException $e) {
			print("Database could not connect".$e->getMessage()."<br/>");
		}
		*/
	}    
?>
	<form id="login_form" action="signup.php" method="post">
		<div>
			<label for="firstName">First Name</label>
			<input type="text" name="firstName"/>
		</div>
		<div>
			<label for="lastName">Last Name</label>
			<input type="text" name="lastName"/>
		</div>
		<div>
			<label for="school">School</label>
			<input type="text" name="school"/>
		</div>
		<div>
			<label for="email">Email</label>
			<input type="text" name="email"/>
		</div>
		<div>
			<label for="edulvl">Education Level</label>
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
			<label for="uid">Username</label>
			<input type="text" name="uid"/>
		</div>
		<div>
        		<button type="submit" name="sbmt">submit</button>
    		</div>
	</form>
<?php
    include "footer.php";
?>
<html>
