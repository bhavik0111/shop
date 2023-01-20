<?php
$extracatvar='';
$error='';
$error="Nothing to display";
if($ps!=''){
	$extracatvar="&ps=".$ps;
	} 
if($pe!='')
	{
	$extracatvar.="&pe=".$pe;
	}
if($title!='')
	{
	$extracatvar.="&title=".$title;
	}
if($prodfor!='')
	{
	$extracatvar.="&prodfor=".$prodfor;
	}
if($psage!='')
	{
	$extracatvar.="&psage=".$psage;
	}
if($peage!='')
	{
	$extracatvar.="&peage=".$peage;
	}
?>
<td widht="20%" align="center" valign="top">
<table width="100%" border="1">
			<tr><th><center>Categories</center></th></tr>
			<?php 
			$sel_query="SELECT * FROM `category_master` where cat_status=1";
			$count=1;
			$result = mysqli_query($conn,$sel_query);
			$totalrec = mysqli_num_rows($result);
			if($totalrec>0){
			while($row = mysqli_fetch_assoc($result)) { ?>
			<tr><td align="center"><a href="index.php?cat=<?php echo $row["cat_id"].$extracatvar; ?>"><?php echo $row["cat_name"];?></a></td></tr>
			<?php $count++; }}
			else if($totalrec==0){
				echo $error;
			}
		 ?>
</table>
<table width="100%" border="0">
	<form action="index.php" method="GET" >
		<tr><td>Title</td>
		<td colspan="4"><input type="text" name="title" value="<?php echo $title;?>"></td></tr>
		<tr><td>Price</td>
			<td>from:<input type="number" name="ps" value="<?php echo $ps;?>"></td><td colspan="2">to:<input type="number" name="pe" value="<?php echo $pe ;?>"></td></tr>
			<tr><td>Product for</td>
			<td colspan="3"><select name="prodfor">
			   <option value="">Select For</option>
			   <option  <?php if($prodfor=='1'){ echo 'selected="selected"'; }?> value="1">Men</option>
			   <option <?php if($prodfor=='0'){ echo 'selected="selected"'; }?>value="0">Women</option>
			</select></td></tr>
			<tr><td>Start age</td>
			<td ><select name="psage" >
				<option value="">Select start age</option>
				<?php for($k=11;$k<=60;$k++)
				{
					?>
					<option value="<?php echo $k;?>" <?php echo ($psage==$k?'selected="selected"':'');?> ><?php echo $k;?></option>
					<?php 
				}
				?></select></td>
			<td>End age</td>
			<td ><select name="peage">
				<option value="">Select end age</option>
				<?php for($i=11;$i<=60;$i++)
				{
					?>
					<option value="<?php echo $i;?>" <?php echo ($peage==$i?'selected="selected"':''); ?> ><?php echo $i;?></option>
					<?php
				}
				?>
			</select></td></tr>
			<tr><td colspan="2" align="center"><input type="submit" name="button" value="Search"></td></tr>
	</form>
</table>
</td>