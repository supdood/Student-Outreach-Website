<!DOCTYPE html>
<!-- Website template by freewebsitetemplates.com -->
<html>
<head>
	<meta charset="UTF-8">
	<title>Wood Working Website Template</title>
	<link rel="stylesheet" href="css/style.css" type="text/css">
</head>
<body>


	<div id="header">
		<div>
			<div id="logo">
				<a href="index.php"><img src="images/logo.png" alt="LOGO"></a>
			</div>
			<ul id="navigation">
				<li class="selected">
					<a href="index.php">Home</a>
				</li>
				<li>
					<a href="about.php">About</a>
				</li>
				<li>
					<a href="gallery.php">Gallery</a>
				</li>
				<li>
					<a href="contact.php">Contact</a>
				</li>
                
                <?php if(!isset($_SESSION)){session_start();}
                    
                    if (isset($_SESSION['email']))
                        print '<li><a href="login.php">Log Out</a></li>';
                    else
                        print '<li><a href="login.php">Log In</a></li>';


                ?>
                
				<li>
					<a href="lab4.php">Sign Up</a>
				</li>
                
                <?php if(!isset($_SESSION)){session_start();}
                    
                    if (isset($_SESSION['email']))
                        print '<li><a href="account.php">Account</a></li>';
                ?>
                
			</ul>
		</div>
	</div>