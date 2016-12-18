<?php
@include("../configdb.php");
	$conn = mysql_connect( "$host", "$user", "$pass");
	mysql_select_db("t-shirt");
	$strSQL = "SELECT * FROM picture WHERE product_id = '".$_GET["id"]."'";
	$objQuery = mysql_query($strSQL,$conn);
	$objResult = mysql_fetch_array($objQuery);

	echo $objResult["pic_picture"];
?>
