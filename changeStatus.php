<?php
$pid=$_POST['pid'];
$status=$_POST['status'];
$did=$_POST['did'];

 require_once("./inc/db.php");
	
	$sql = "UPDATE drawings
             SET status = '$status',
			 repdate = CURDATE()
             WHERE  id='$did'";
    
	$result = mysql_query($sql) or die('MySQL query error');

	echo '<script language="javascript">
		location = "drawings.php?pid='.$pid.'";
		</script>';
?>