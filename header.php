<?php session_start();
      //Redirects to login if the current page is not the home, login, or signup page.
      if (!isset($_SESSION['username']) && basename($_SERVER['SCRIPT_NAME']) != "login.php"
		&& basename($_SERVER['SCRIPT_NAME']) != "index.php" && basename($_SERVER['SCRIPT_NAME']) != "signup.php") {
		Header("Location: login.php");
      }
?>

<!DOCTYPE html>

<!--
 Website: IUPUI Student Outreach
 Date: October 18, 2015
-->

<html lang="en">
<head>

	<meta charset="UTF-8">

	<title>IUPUI Student Outreach</title>
	
    <!-- Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet">
    
    <link href="https://fonts.iu.edu/style.css?family=BentonSans:regular,bold%7CBentonSansCond:regular%7CGeorgiaPro:regular" rel="stylesheet">
    <link href="https://assets.iu.edu/brand/2.x/brand.css" media="screen" rel="stylesheet" type="text/css">
    <link href="https://assets.iu.edu/search/2.x/search.css" media="screen" rel="stylesheet" type="text/css">
    <link href="http://www.iupui.edu/_assets/css/site.css" media="screen" rel="stylesheet" type="text/css">
    <link href="css/style.css" media="screen" rel="stylesheet" type="text/css">

</head>

<body>
    
    <!-- Including the IUPUI header and search bar -->   
    
    <div id="skipnav">
        <ul>
            <li><a href="#content">Skip to Content</a></li>
            <li><a href="#nav-main">Skip to Main Navigation</a></li>
            <li><a href="#search">Skip to Search</a></li>
        </ul>
        <hr>
    </div>

    <div class="off-canvas-wrap" data-offcanvas="">
    
        <div id="branding-bar" itemscope="itemscope" itemtype="http://schema.org/CollegeOrUniversity" role="complementary" aria-labelledby="iu-campus">
            <div class="row pad">
                <img src="images/trident-large.png" alt="IU" />
                <p id="iu-campus">
                    <a href="http://www.iupui.edu" title="Indiana University&ndash;Purdue University Indianapolis">
                        <span class="show-on-desktop" itemprop="name">Indiana University&ndash;Purdue University Indianapolis</span>
                        <span class="show-on-tablet" itemprop="name">Indiana University&ndash;Purdue University Indianapolis</span>
                        <span class="show-on-mobile" itemprop="name">IUPUI</span>
                    </a>
                </p>
            </div>
        </div>
        
                    <div id="toggles">
    <div class="row pad">
        <a class="button right-off-canvas-toggle hide-for-large-up" href="#">Menu</a>
        <a class="button search-toggle" href="http://www.iupui.edu/search/" title="Search">Search</a>
    </div>
</div>


        <div id="search" class="search-box" role="search"></div>
        
        <!-- Including the IUPUI structure for navigation links in the header -->
    
        <div class="inner-wrap">
    
    
        	
    <nav class="main hide-for-medium-down show-for-large-up" id="nav-main" role="navigation"><ul class="row pad">
                <li class="show-on-sticky trident"><a href="http://www.iupui.edu/index.html">Home</a></li>
                <a href="index.php">Home</a>
                <?php if (isset($_SESSION['username'])) {
			echo '<a href="logout.php" class="pull-right">Log Out</a>';
		} else {
			echo '<a href="login.php" class="pull-right">Log In</a>';
 			echo '<a href="signup.php" class="pull-right">Sign Up</a>';
		} ?>
        </span>
        </ul>
    </nav>
        </div>
    </div>
    
    <!------------------------------------------------------------------------------------------
------------------------------------------------------------------------------------------------
------------------------------------End of the IUPUI Header-------------------------------------
------------------------------------------------------------------------------------------------
------------------------------------------------------------------------------------------------>
