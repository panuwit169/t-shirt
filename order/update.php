<?php
ob_start();
session_start();
@include("../configdb.php");
  for($i=0;$i<=(int)$_SESSION["intLine"];$i++)
  {
	  if($_SESSION["strProductID"][$i] != "")
	  {
      $conn=mysql_connect("$host","$user","$pass");
      mysql_select_db("t-shirt");
      $strSQL = "SELECT * FROM stock WHERE stock_id = '".$_SESSION["strProductID"][$i]."'";
      $objQuery = mysql_query($strSQL)  or die(mysql_error());
      $objResult = mysql_fetch_array($objQuery);
      if($_POST["quantity".$i]>$objResult["stock_amount"])
      {
        mysql_close($conn);
        $error="true";
      }
      else
      {
			  $_SESSION["strQty"][$i] = $_POST["quantity".$i];
        mysql_close($conn);
      }
	  }
  }
  if($error=="true"){
    header("location:show.php?error=true");
  }
  else{
    header("location:show.php");
  }

?>
