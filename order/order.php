<?php
ob_start();
session_start();
@include("../configdb.php");
$id=$_POST["id"];
$quantity=$_POST["quantity"];
$size=$_POST["size"];

mysql_connect("$host","$user","$pass");
mysql_select_db("t-shirt");
$strSQL = "SELECT * FROM stock join products on stock.product_id=products.product_id WHERE products.product_id = '".$id."' and  stock_size ='".$size."'";
$objQuery = mysql_query($strSQL)  or die(mysql_error());
$objResult = mysql_fetch_array($objQuery);
$stock_id=$objResult["stock_id"];

if($quantity>$objResult["stock_amount"])
{
  header("location:../product/detailproduct.php?id=$id&over=true");
}
else
{

if(!isset($_SESSION["intLine"]))
{

	 $_SESSION["intLine"] = 1;
	 $_SESSION["strProductID"][1] = $stock_id;
	 $_SESSION["strQty"][1] = $quantity;
   $_SESSION["count"] = 1;

	 header("location:show.php");
}
else
{

	$key = array_search($stock_id, $_SESSION["strProductID"]);
	if((string)$key != "")
	{
		 $_SESSION["strQty"][$key] = $_SESSION["strQty"][$key] + $quantity;
	}
	else
	{
     $_SESSION["count"] = $_SESSION["count"] + 1;
		 $_SESSION["intLine"] = $_SESSION["intLine"] + 1;
		 $intNewLine = $_SESSION["intLine"];
		 $_SESSION["strProductID"][$intNewLine] = $stock_id;
		 $_SESSION["strQty"][$intNewLine] = $quantity;
	}

	 header("location:show.php");

}
}
?>
