<?php
	include "header.php";
	include "../db/dbconnect.php";
?> 
<style type="text/css">
/*	input[type="text"]
	{
		width: 30%;
	}*/
	div
	{
		width: 30%;
		text-align: center;
		margin: 0 auto;
	}
</style>

<?php
	// initialize error variable
	$errorMsg = "";




?>


<div>
	<span>  <?php  print $errorMsg  ?>  </span>


</div>



<?php
	include "footer.php";
?>