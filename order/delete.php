<?php
	ob_start();
	session_start();

	$Line = $_GET["Line"];
	echo $Line."<br>";
	$_SESSION["strProductID"][$Line] = "";
	$_SESSION["strQty"][$Line] = "";
	$_SESSION["count"]--;

	//session_destroy();

	header("location:show.php");
?>
