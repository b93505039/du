
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>

<?php
	$pid =$_POST['pid'];
	$did=$_POST['did'];
	$filename=$_POST['filename'];
	$big5filename=iconv("utf-8", "big5",$filename);

	$route="./upload/".$pid."/";
	$deleteroute="./upload/".$pid."/delete/";
	$datetime = date ("Y-m-d-H-i-s" , mktime(date('H')+8, date('i'), date('s'), date('m'), date('d'), date('Y'))) ; 
	
	require_once("./inc/db.php");
	
	if(!is_dir($deleteroute))
				mkdir($deleteroute,0755,true);
	
	rename($route.$big5filename, $deleteroute.$datetime.$big5filename);
	
	if(!file_exists($route.$big5filename)){
     	$sql = "UPDATE drawings
			SET del = 1
			WHERE  id='$did'";
    
	$result = mysql_query($sql) or die('MySQL query error');

	}
			
				

?>

<form name="backtofile" method="post" action="drawings.php">
   	<input type="hidden" name="pid" value="<?php echo $pid?>">
</form>

<script language="javascript">
	document.backtofile.submit();
</script>
