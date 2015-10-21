<?php
	include "header.php";
	if (!isset($_SESSION['count'])) {
		$_SESSION['count'] = 3;
	}
	if (isset($_POST['sbmt'])) {
		/*$db = new mysqli('localhost', 'whitdac', 'whitdac', 'whitdac_db');
		$q = "SELECT password FROM * WHERE username='".$_POST['uname']."'";
		$result = $db->query($q)->fetch_row();
		*/
		if ($result[0] == $_POST['password']) {
			$_SESSION['username'] = $_POST['uname'];
			Header("Location: index.php");
		} elseif ($_SESSION['count'] > 1 && $_SESSION['count'] <= 3) {
			$_SESSION['count']--;
			echo "Login failed. ".$_SESSION['count']." attempts remaining.";
		} elseif ($_SESSION['count'] == 1) {
	                Header("Location:locked.php");
		}
	}    
?>
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
