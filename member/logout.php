<?php
@session_start();

$_SESSION['id']="";

echo '<script type="text/javascript">';
echo "window.location='../index.php'";
echo '</script>';
?>
