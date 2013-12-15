

<?php
	require_once("./inc/head.php");
	session_cache_limiter('private, must-revalidate');
	session_start(); 
	require_once("./inc/sessionCheck.php");

	$pid =$_POST['pid'];
	$count=$_POST['count'];
	$pname=$_POST['pname'];
 
	$route="./upload/".$pid."/";

	require_once("./inc/db.php");

	for($i=1;$i<=$count;$i++){
		if ($_FILES["file".$i]["error"] > 0){
			//echo "Error: " . $_FILES["file".$i]["error"];
?>
		<script type="text/javascript">
				alert("檔案上傳失敗");
			</script>
<?php		require_once("./inc/toDrawings.php");
		}
		else{
	    
			echo "檔案名稱: " . $_FILES["file".$i]["name"]."<br/>";
			echo "檔案類型: " . $_FILES["file".$i]["type"]."<br/>";
			echo "大小: " . ($_FILES["file".$i]["size"] / 1024)." Kb<br />";
			//echo "暫時名稱: " . $_FILES["file".$i]["tmp_name"]."<br/>";
		
			if(!is_dir($route))
				mkdir($route,0755,true);
			
			//$filetype=$_FILES["file".$i]["name"];
			///$s=str_split($_FILES["file".$i]["name"]);
			/*
			for($j=0;$j<sizeof($s);$j++){
				if($s[$j]==".")
					$dotpos=$j;
			}
			*/
		
			//$filetype=substr($_FILES["file".$i]["name"],$dotpos);
			//$filename=$_POST['name'.$i].$filetype;
			//$filename=iconv("utf-8", "big5", $_FILES["file".$i]["name"]);
			$filename=iconv("utf-8","big5",$_FILES["file".$i]["name"]);
			$note=$_POST['note'.$i];
			
			$s=str_split($filename);
			for($j=0;$j<sizeof($s);$j++){
				if($s[$j]==" "){
			    $filename=substr_replace($filename, '_', $j, 1);
				}
			}
			
	
			if(file_exists($route.$filename)){
			//if(file_exists(iconv("utf-8", "big5",$route.$filename))){
				//echo "檔案之檔名已經存在";
		?>

			
			<script type="text/javascript">
				alert("檔案之檔名已經存在");
			</script>
		<?php
			require_once("./inc/toDrawings.php");
    		}
			else{

				move_uploaded_file($_FILES["file".$i]["tmp_name"],$route.$filename);
    			//echo"success";
		?>
			<script type="text/javascript">
				alert("上傳成功");
			</script>
			
			<?php //本段寄信用
			if($_SESSION['type']==1){
				$to =" adm@geniusstar.com "; //收件者 
				$subject = "Geniusstar System Notice"; //信件標題 
				$msg = "There has been file(s) upload to Project number ".$pid." ";//信件內容 
				$headers = "From: adm@geniusstar.com"; //寄件者
 
				mail("$to", "$subject", "$msg", "$headers");
			}
			?>

		
		<?php
			if(file_exists($route.$filename)){
			    $big5filename=iconv("big5", "utf-8",$filename);
				$sql="insert into drawings(pro_id,filename,udate,note) values('$pid','$big5filename',CURDATE(),'$note')";
				$result = mysql_query($sql) or die('MySQL query error');
			}
		?>

		<?php
			
			
			require_once("./inc/toDrawings.php");
		}
	}
}


?>
