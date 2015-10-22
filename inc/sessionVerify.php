<?php

	if (!isset($_SESSION['email'])) Header ("Location:logout.php") ;
	
	//session time out 10 minutes after login. The timeout variable is set in the login page
	//keep refreshing the process.php page to see the behavior
	 if(!isset($_SESSION['timeout']))  Header ("Location:logout.php") ;
  	else 
		if ($_SESSION['timeout'] + 1 * 600 < time())
				 Header ("Location:logout.php") ;
		else 	$_SESSION['timeout'] = time();	 


?>