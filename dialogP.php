<?php
require_once("./inc/headDocument.php");
 
session_cache_limiter('private, must-revalidate');
session_start(); 
require_once("./inc/sessionAdmin.php");

if(!empty($_GET['s']))
	$s=$_GET['s'];
else
	$s=0;

if($_SESSION['type']==3||$_SESSION['type']==4){ 
	$where="status =".$s;
	if($s==1) $where=1;
}
else if($_SESSION['type']==1){
	$aid=$_SESSION['id'];
	$where="p.acc_id=".$aid." and status =".$s;
	if($s==1) $where="p.acc_id=".$aid;
}

else if($_SESSION['type']==2){
	$aid=$_SESSION['id'];
	$where="p.owe_id=".$aid." and status =".$s;
	if($s==1) $where="p.owe_id=".$aid;
}

require_once("./inc/db.php");
$sql = "select * ,p.id pid ,a.name aname, a.id aid
        from project p
		where $where
		order by p.Name";

$result = mysql_query($sql) or die('MySQL query error');
$count = 1;
?>

<body>
<div id="login" class="centercontainer">
<div class="whitebox1024">

<h2>ALL Pojects</h2>

<form>
	<select name="choice" onChange="jump(this.form)">
		<option value="document.php?s=0" <?php if($s==0) echo "selected" ?>>Active</option>
		<option value="">=============</option>
		<option value="document.php?s=1" <?php if($s==1) echo "selected" ?>>All</option>
		<option value="document.php?s=2" <?php if($s==2) echo "selected" ?>>Completed</option>
	</select>
</form>

<?php
if($_SESSION['type']==3){
?>
	<div class="emptyline"></div>
	<form method=post action="./acc/accountManage.php">
	<input type="submit" name="Submit" value="Account Manage">
	</form>
<?php
}
?>
<a href ="logout.php">登出</a>
<div class="emptyline"></div>
<img src="image/r.png"></img> = Active
<img src="image/g.png"></img> = Completed
<div class="emptyline"></div>

<table style="border:3px solid rgb(109, 2, 107); width:1024px; word-break:break-all" frame="border" rules="all" cellpadding="2">
	<tr>
	<td align=center width="3%"><div class="tabletitle"></div></td>
	<td align=center width="28%"><div class="tabletitle">Project Name</div></td>
	<td align=center width="28%"><div class="tabletitle">Shipyard</div></td>
	<td align=center width="6%"><div class="tabletitle">status</div></td>
	<td align=center width="29%"><div class="tabletitle">remark</div></td>
	<td align=center width="6%"><div class="tabletitle"></div></td>
    </tr>
<?php
	while($row = mysql_fetch_array($result)){

	//$Date_explode_1=explode("-",$row['E_date']);
    //$DueDate=mktime(0,0,0,$Date_explode_1[1],$Date_explode_1[2],$Date_explode_1[0]);
	//$today=mktime(0,0,0,date("m") ,date("d"),date("Y"));
	//$Owner=rawurlencode($row['Owner']);

	$pid=$row['pid'];
	$pro=$_POST['pro'];
?>
	<tr class=list>
		<td align=center><font color=hotpink><?php echo $count?></font></td>
		<td><?php echo $row['Name']?></td>
        <td><?php echo $row['aname']?></td>
		<td align=center>
<?php
		if($_SESSION['type']==3){
			if($row['status']==0){
?>		   	
			<form method="post" name="dialogP" action="<?php echo "dialogP.php?s=$s"?>">
				<input type="image" src="./image/r.png" onClick="document.dialogP.submit();">
				<input type="hidden" name="pro" value="<?php echo $pid?>">
				<input type="hidden" name="status" value="0">
				<input type="hidden" name="s" value="<?php echo $s?>">
			</form>

<?php	
			}
			else if($row['status']==2){
?>			
			<form method="post" name="dialogP" action="<?php echo "dialogP.php?s=$s"?>">
				<input type="image" src="./image/g.png" align="center" onClick="document.dialogP.submit();">
				<input type="hidden" name="pro" value="<?php echo $pid?>">
				<input type="hidden" name="status" value="2">
				<input type="hidden" name="s" value="<?php echo $s?>">
			</form>
<?php
			}
		}
		else if($_SESSION['type']==1){
			if($row['status']==0){
					echo '<img src="image/r.png"></img>';
				}
			else if($row['status']==2){
					echo '<img src="image/g.png"></img>';
				}
		}
?>
	    </td>
		<td><?php echo $row['remark']?></td>
		<td align=center>
		<form name="form" method="post" action="drawings.php">
			<input type="submit" name="Submit" value="進入">
			<input type="hidden" name="pid" value="<?php echo $pid?>">
			<input type="hidden" name="sid" value="<?php echo $s?>">
		</form>
		</td>
	</tr>
<?php
	if($pro == $row['pid']){
?>
	<tr class="list">
	<td colspan="3"></td>
	<td colspan="3" bgcolor="B0E0E6">
		&nbsp;更改進度： 
		<form method="post" name="dialog0" action="<?php echo "changeStatusP.php?s=$s"?>">
			<input type="hidden" name="pro" value="<?php echo $pid?>">
			<input type="hidden" name="status" value="0">
			&nbsp;<input type="image" src="image/r.png" alt="Active" onClick="document.dialog0.submit();"> Active
		</form>
		<form method="post" name="dialog2" action="<?php echo "changeStatusP.php?s=$s"?>">
			<input type="hidden" name="pro" value="<?php echo $pid?>">
			<input type="hidden" name="status" value="2">
			&nbsp;<input type="image" src="image/g.png" alt="Completed" onClick="document.dialog2.submit();"> Completed
		</form>
        <form name="form" method="post" action="<?php echo "document.php?s=$s"?>">
			<input type="submit" name="Submit" value="取消">
		</form>
	</td>
	</tr>
<?php
	}
		$count++;
	}
?>
</table>

</div>
</div>
</body>

