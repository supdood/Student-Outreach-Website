<?php 
	include "dbconnect.php";
	include "header.php";
	if (isset($_POST['sbmt'])) {
			}
?>
	<form id="login_form" action="login.php" method="post">
		<div>
			<label for="email">email</label>
			<input type="text" name="email"/>
		</div>
		<div>
			<label for="code">Activation Code</label>
			<input type="password" name="code"/>
		</div>
		<div>
        		<button type="submit" name="sbmt">submit</button>
    		</div>
	</form>	
<?php

?>
