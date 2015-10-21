<?php
/**
 * This file defines database connection. This file is included in any files that needs database connection
 * 
  */



$conn = mysqli_connect("localhost", "nelson8", "nelson8", "nelson8_db") or die(mysql_error());
$select = mysqli_select_db($conn, "nelson8_db");


/*
include ("adodb5/adodb.inc.php");
include ("adodb5/adodb-exceptions.inc.php");

$DB = NewADOConnection("mysql");

$DB->Connect("localhost", "nelson8", "nelson8","nelson8_db");
*/

?>
