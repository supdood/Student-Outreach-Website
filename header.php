<?php session_start();
require_once "lib/password.php";
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
    
    <!-- Include jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>

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
        
		<!--
                    <div id="toggles">
    <div class="row pad">
        <a class="button right-off-canvas-toggle hide-for-large-up" href="#">Menu</a>
        <a class="button search-toggle" href="http://www.iupui.edu/search/" title="Search">Search</a>
    </div>
</div>
-->


        <div id="search" class="search-box" role="search"></div>
        
        <!-- Including the IUPUI structure for navigation links in the header -->
    
        <div class="inner-wrap">
	
	   <nav class="navbar navbar-default">
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="sr-only"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
          </div>
          <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li><a href="index.php">Home</a></li>
                <li><a href="calendar.php" class="">Event Calendar</a></li>
                <?php if (isset($_SESSION['email'])) {
            echo '<li><a href="addEvent.php" class="">Add Event</a></li>';
            echo '<li><a href="survey/StartSurvey.php" class="">Survey</a></li>';
            echo '<li><a href="account.php" class="">Dashboard</a></li>';
            if (isset($_SESSION['access'])) { 
                if ($_SESSION['access'] == 1 || $_SESSION['access'] == 2) {
                    echo '<li><a href="admin.php" class="">Admin</a></li>';
                    echo '<li><a href="dataDownloads.php" class="">Data</a></li>';
                }
            }
            echo '<li><a href="logout.php" class="">Log Out</a></li>';
		} else {
 			echo '<li><a href="signup.php" class="">Sign Up</a></li>';
            echo '<li><a href="login.php" class="">Log In</a></li>';
		} ?>
                </ul>
              </li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </nav>
    
    
        
    </div>