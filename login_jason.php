<?php 
	include "header.php";
	include "db/dbconnect.php";
?>

<?php

	if (!isset($_SESSION['count'])) {
		$_SESSION['count'] = 3;
	}
	// initialize variable
	if(!isset($errorMsg))$errorMsg = "";

	if (isset($_POST['sbmt'])) {
		$errorMsg = $_POST["errorMsg"];

		// email/username
		$email = $_POST["uname"];
		$email = mysqli_real_escape_string($conn, $email);
		print $email;
		// // get/escape password
		$pw = $_POST["password"];
		$pw = mysqli_real_escape_string($conn, $pw);
		print $pw;

		$usernameSql = "SELECT Email FROM K12_TEACHER WHERE Email LIKE '" . $email . "'";
		print $usernameSql;
    	$usernameResult = mysqli_query($conn, $usernameSql) or die(mysql_error());
    	$un = mysqli_fetch_array($usernameResult, MYSQLI_NUM);
    	print $un[0];

    	$passwordSql = "SELECT Password FROM K12_TEACHER WHERE Email LIKE '" . $pw . "'";
    	$passwordResult = mysqli_query($conn, $usernameSql) or die(mysql_error());

    	if($usernameResult == "" or $passwordResult == "")
    	{
    		$errorMsg = $errorMsg . "Please enter a username and password.<br>";
    	}

    	if($_SESSION["count"] > 3)
    	{
    		$errorMsg = $errorMsg . "You have exceeded your login attempt limit. Please try again later.<br>";
    	}
		if (($passwordResult == $pw) && ($usernameResult == $email)) 
		{
			$_SESSION['username'] = $email;
			// $loginStatusUpdateSql = "UPDATE K12_TEACHER SET LoginStatus = 1 WHERE Email LIKE $email";
   //  		$loginStatusResult = mysqli_query($conn, $loginStatusUpdateSql) or die(mysql_error());
    		if(!$loginStatusResult)
    		{
    			$errorMsg = $errorMsg . "Error updating login status.<br>";
    		}
			Header("Location:index.php");

		} 
		else
		{
			$errorMsg = $errorMsg . "Login failed. ".(3 - $_SESSION['count'])." attempts remaining.";
			Header("Location:login.php");
		}

	}    
?>
	<div class="row">
		<p name="errorMsg" value=<?php print $errorMsg?>/>
	</div>
	<form id="login_form" action="login.php" method="post">
		<div>
			<label for="name">Username</label>
			<input type="text" name="uname"/>
		</div>
		<div>
			<label for="password">Password</label>
			<input type="password" name="password"/>
		</div>
		<div>
        		<button type="submit" name="sbmt">submit</button>
    		</div>
	</form>

<?php

    include "footer.php";
?>
<html>
