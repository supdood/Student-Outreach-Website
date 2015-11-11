<?php
/**
 * This file defines database connection. This file is included in any files that needs database connection
 * 
  */





include ("adodb.inc.php");
include ("adodb-exceptions.inc.php");

$DB = NewADOConnection("mysql");

$DB->Connect("localhost", "nelson8", "nelson8","nelson8_db");

?>
