<?php
@include("../configdb.php");
$name = $_POST['name'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$password = $_POST['password'];

$conn = mysql_connect( "$host", "$user", "$pass");
mysql_select_db("t-shirt");
$strSQL = "select count(*) from member";
$objParse = mysql_query($strSQL, $conn);
$objResult = mysql_fetch_array($objParse);
$count=$objResult[0];
$count++;
$count=sprintf("%04d",$count);

$strSQL1 = "INSERT INTO member (member_id,member_name,member_lname,member_email,member_password) values ('".$count."','".$name."','".$lname."','".$email."','".$password."')";
mysql_query("SET NAMES UTF8");
$objParse1 = mysql_query($strSQL1, $conn);

?>
<script>
  window.location="login.php?regis=yes";
</script>
