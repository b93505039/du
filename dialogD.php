<?php
require_once("./inc/headDrawings.php");
session_cache_limiter('private, must-revalidate');
session_start(); 
require_once("./inc/sessionAdmin.php");

$pid =$_POST['pid'];
if(!empty($_POST['sid'])){
	$sid =$_POST['sid'];
}
else{
	$sid=0;
}

$number=1;

require_once("./inc/db.php");
	
$sql = "select *
        from drawings d
		where d.pro_id='$pid' and d.del=0
		order by d.note,d.udate";
    
$result = mysql_query($sql) or die('MySQL query error');
$count = 1;
?>

<body>
<div id="login" class="centercontainer">
<div class="whitebox1024">

<h2>ALL Drawings</h2>

<?php 
if($_SESSION['type']==1){   //only owner can upload
?>
	<div class="emptyline"></div>
	<form name="form" method="post" action="uploadlist.php" enctype="multipart/form-data">
		Upload
			<select name="num">
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
			</select> new file(s).</br>
		<input type="hidden" name="pid" value="<?php echo $pid?>">
		<input type="hidden" name="pname" value="<?php echo $pname?>">
		<input type="submit" name="Submit" value="Upload">
	</form>
<?php
}
?>

<a href="document.php?s=<?php echo $sid?>">Return to Poject List</a>
<div class="emptyline"></div>
<div class="emptyline"></div>
<img src="image/r.png"></img> = Active
<img src="image/y.png"></img> = Action Required 
<img src="image/g.png"></img> = Completed

<?php
while($row = mysql_fetch_array($result)){
?>
<div class="emptyline"></div>
<table style="border:3px solid rgb(109, 2, 107); width:1024px; height:60; word-break:break-all" frame="border" rules="all" cellpadding="2">
	<tr bgcolor="#f6f6f0">
	<td align=center width="4%"><div class="tabletitle">No.</div></td>
	<td align=center width="30%"><div class="tabletitle">File</div>
<?php
	if($_SESSION['type']==3){
?>
    	<form name="form" method="post" action="deletefilesql.php">
			<input type="submit" name="Submit" value="Delete">
			<input type="hidden" name="pid" value="<?php echo $pid?>">
			<input type="hidden" name="did" value="<?php echo $row['id']?>">
			<input type="hidden" name="filename" value="<?php echo $row['filename']?>">
		</form>
<?php
	}
?>
    </td>
	<td align=center width="16%"><div class="tabletitle">UploadDate</div></td>
	<td align=center width="44%"><div class="tabletitle">Discription</div></td>
	<td align=center width="6%"><div class="tabletitle">Status</div></td>
    </tr>

<?php
	$did=$row['id'];

	echo '<tr class="list">';
	echo "<td align=center> <font color = hotpink >".$count."</font></td>
		<td><a href=./upload/".$pid."/".$row['filename'].">";
		echo $row['filename']."</a></td>
		<td align=center>".$row['udate']."</td>
        <td>".$row['note']."</td>";
?>
		<td align="center">
<?php
		if($_SESSION['type']==3){
			if($row['status']==0){
?>
				<form method="post" name="dialogD" action="dialogD.php">
				<input type="image" src="./image/r.png" onClick="document.dialogD.submit();">
				<input type="hidden" name="pid" value="<?php echo $pid?>">
				<input type="hidden" name="status" value="0">
				<input type="hidden" name="chdid" value="<?php echo $did?>">
				</form>
<?php
			}
			else if($row['status']==1){
?>
				<form method="post" name="dialogD" action="dialogD.php">
				<input type="image" src="./image/y.png" onClick="document.dialogD.submit();">
				<input type="hidden" name="pid" value="<?php echo $pid?>">
				<input type="hidden" name="status" value="1" />
				<input type="hidden" name="chdid" value="<?php echo $did?>">
				</form>
<?php
			}
			else if($row['status']==2){
?>
				<form method="post" name="dialogD" action="dialogD.php">
				<input type="image" src="./image/g.png" onClick="document.dialogD.submit();">
				<input type="hidden" name="pid" value="<?php echo $pid?>">
				<input type="hidden" name="status" value="2" />
				<input type="hidden" name="chdid" value="<?php echo $did?>">
				</form>
<?php 
			}
		}
		else if($_SESSION['type']==1){
			if($row['status']==0){
					echo '<img src="image/r.png"></img>';
				}
			else if($row['status']==1){
					echo '<img src="image/y.png"></img>';
				}
			else if($row['status']==2){
					echo '<img src="image/g.png"></img>';
				}
		}
?>
		</td></tr>
<?php
	if($chdid==$did){
?>
        <tr class="list">
        	<td colspan="3"></td>
            <td colspan="2" bgcolor="B0E0E6">
			&nbsp;更改進度： 
			<form method="post" name="dialog0" action="changeStatus.php">
				<input type="hidden" name="pid" value="<?php echo $pid?>">
                <input type="hidden" name="did" value="<?php echo $did?>">
				<input type="hidden" name="status" value="0">
				&nbsp;<input type="image" src="image/r.png" alt="Active" onClick="document.dialog0.submit();"> Active
			</form>
			<form method="post" name="dialog1" action="changeStatus.php">
				<input type="hidden" name="pid" value="<?php echo $pid?>">
                <input type="hidden" name="did" value="<?php echo $did?>">
				<input type="hidden" name="status" value="1">
				&nbsp;<input type="image" src="image/y.png" alt="Action Required" onClick="document.dialog1.submit();"> Action Required
			</form>
			<form method="post" name="dialog2" action="changeStatus.php">
				<input type="hidden" name="pid" value="<?php echo $pid?>">
                <input type="hidden" name="did" value="<?php echo $did?>">
				<input type="hidden" name="status" value="2">
				&nbsp;<input type="image" src="image/g.png" alt="Completed" onClick="document.dialog2.submit();"> Completed
			</form>
	        <form name="form" method="post" action="drawings.php">
            	<input type="hidden" name="pid" value="<?php echo $pid?>">
				<input type="submit" name="Submit" value="取消">
			</form>
            </td>
        </tr>
<?php
	}
?>
        <tr bgcolor="#f6f6f0">
			<td align="center" colspan="3"><div class="tabletitle">Comments
<?php
	if($_SESSION['type']==3){
?>
            	<form name="form" method="post" action="comment.php">
					<input type="submit" name="Submit" value="Comment">
					<input type="hidden" name="pid" value="<?php echo $pid;?>">
					<input type="hidden" name="did" value="<?php echo $row['id']?>">
				</form>
<?php
	}
?>
            </div></td>
			<td align="center" colspan="2"><div class="tabletitle">Reply
<?php
	if($_SESSION['type']==1){
?>
				<form name="form" method="post" action="reply.php">
					<input type="submit" name="Submit" value="Reply">
					<input type="hidden" name="pid" value="<?php echo $pid;?>">
					<input type="hidden" name="did" value="<?php echo $row['id'];?>">
				</form>	
<?php
	}
?>
			</div></td>
	    </tr>
	<tr class="list">
		<td colspan="3" width="512" height="60">
			<textarea name="content" rows="4" cols="60" maxlength="100" readonly style="resize:none;"><?php echo $row['comment']?></textarea>
		<td colspan="2" width="512" height="60">
			<textarea align=left name="content" rows="4" cols="60" maxlength="100" readonly style="resize:none;"><?php echo $row['reply']?></textarea>
		</td>
	</tr>
    </table>
<?php
    $count++;
	}
?>

</div>
</div>
</body>