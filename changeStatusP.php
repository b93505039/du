<?php
$pid=$_POST['pro'];
$status=$_POST['status'];
$s=$_GET['s'];
require_once("./inc/db.php");
	
	$sql = "UPDATE project
			SET status = '$status',
			cdate = CURDATE()
			WHERE  id='$pid'";
    
	$result = mysql_query($sql) or die('MySQL query error');

	echo '<script language="javascript">
		location = "document.php?s='.$s.'";
		</script>';
?>