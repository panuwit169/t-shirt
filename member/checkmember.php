<?php
@session_start();
@include("../configdb.php");

$email = $_POST['email'];
$password = $_POST['password'];

$conn = mysql_connect( "$host", "$user", "$pass");
mysql_select_db("t-shirt");
$strSQL = "select * from member where member_email='$email'";
mysql_query("SET NAMES UTF8");
$objParse = mysql_query($strSQL, $conn);
$objResult = mysql_fetch_array($objParse);

  if(isset($objResult['member_email']))
  {
    if($password==$objResult['member_password'])
    {
      $_SESSION['id']=$objResult['member_id'];
      echo '<script type="text/javascript">';
			echo "window.location='../index.php'";
			echo '</script>';
    }
    else{
      echo '<script type="text/javascript">';
      echo "window.location='login.php?login=fail'";
      echo '</script>';
    }
  }
  else {
    echo '<script type="text/javascript">';
    echo "window.location='login.php?login=fail'";
    echo '</script>';
  }

?>
