<?php
$pid=$_POST['pid'];
$content=$_POST['content'];
$did=$_POST['did'];


   require_once("./inc/db.php");
	
	$sql = "UPDATE drawings
             SET comment = '$content',
			     comdate = CURDATE()
             WHERE  id='$did'";
    
	$result = mysql_query($sql) or die('MySQL query error');

require_once("./inc/toDrawings.php");
?>
