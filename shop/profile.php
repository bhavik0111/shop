<?php
include('header.php');?>
<table width="100%"><tr>
<?php include('profile_left.php'); ?>

<td widht="80%" align="center" valign="top">
<table width="100%" border="1"><tr><td>
<?php if(isset($_SESSION['usr_email']) && isset($_SESSION['usr_id']))
{
if(isset($_GET['action']) && $_GET['action']=='edit'){
 	if(isset($_GET['id']) && $_GET['id']!=''){
 		$ord_id=$_GET['id'];
		$query = "select * from order_master where ord_id='".$_GET['id']."' "; 
		$result = mysqli_query($conn, $query);
		$row = mysqli_fetch_assoc($result);
 		$ord_fname=$row['ord_fname'];
 		$ord_lname=$row['ord_lname'];
 		$ord_address=$row['ord_address'];
 		$ord_city=$row['ord_city'];
 		$ord_pcode=$row['ord_pcode'];
 		$ord_contact=$row['ord_contact'];
 		$ord_email=$row['ord_email'];
 		$ord_note=$row['ord_note'];
 		$ord_status=$row['ord_status'];

 		
 	}else{
 		header("Location:".SITE_URL."profile.php"); 
 		exit;
 	}
 }
if(isset($_POST['bntsubmit']) && $_POST['bntsubmit']=='Submit'){
	$ord_fname=$_POST['ord_fname'];
	$ord_lname=$_POST['ord_lname'];
	$ord_address=$_POST['ord_address'];
	$ord_city=$_POST['ord_city'];
	$ord_pcode=$_POST['ord_pcode'];
	$ord_contact=$_POST['ord_contact'];
	$ord_email=$_POST['ord_email'];
	$ord_note=$_POST['ord_note'];
	$ord_status=$_POST['ord_status'];
	$qryupd = "UPDATE order_master set `ord_fname`='".$ord_fname."',`ord_lname`='".$ord_lname."',`ord_address`='".$ord_address."' ,`ord_city`='".$ord_city."' ,`ord_pcode`='".$ord_pcode."',`ord_contact`='".$ord_contact."' ,`ord_email`='".$ord_email."',`ord_note`='".$ord_note."',`ord_status`='".$ord_status."'  where `ord_id`='".$ord_id."'" ;
			//print_r($qryupd);
			//exit;
			mysqli_query($conn, $qryupd);
			header("Location:".SITE_URL."profile.php?k=edit"); 
				exit;
}
}
?>
<?php if(isset($_GET['action']) && $_GET['action']=='edit'){?>
<?php if($_GET['action']=='edit' && $_GET['id']!=''){?><h1>Edit Order</h1>
<form action="profile.php?action=edit&id=<?php echo $_GET['id'];?>" method="post" >
<?php } ?>
<table  width="100%" border="1" >
<table  width="100%" border="1" >
<?php  
if($ord_status==2){
$query="SELECT *,DATE(ord_createdate) AS ord_createdate FROM `order_master`  where `ord_id`='".$_GET['id']."' and ord_status=2";
		$record = mysqli_query($conn,$query);
		$trecord = mysqli_num_rows($record);
	if($trecord>0){
		$i=0;
		while($frow = mysqli_fetch_assoc($record)){?>
			<tr><td> 
				Order id:-</td><td><?php echo $frow["ord_id"];?>
			</td></tr>
			<tr><td> 
				First Name:-</td><td><?php echo $frow["ord_fname"];?>
			</td></tr>
			<tr><td> 
				Last name:-</td><td><?php echo $frow["ord_lname"];?>
			</td></tr>
			<tr><td> 
				Address:-</td><td><?php echo $frow["ord_address"];?>
			</td></tr>
			<tr><td> 
				City:-</td><td><?php echo $frow["ord_city"];?>
			</td></tr>
			<tr><td> 
				Pincode:-</td><td><?php echo $frow["ord_pcode"];?>
			</td></tr>
			<tr><td> 
				Contact number:-</td><td><?php echo $frow["ord_contact"];?>
			</td></tr>
			<tr><td> 
				Email id:-</td><td><?php echo $frow["ord_email"];?>
			</td></tr>
			<tr><td> 
				Order Note:-</td><td><?php echo $frow["ord_note"];?>
			</td></tr>
		<?php  $i++;  } } } else {?>

		<tr>
		<td width="20%">Enter First name:-</td>
		<td width="80%"><input type="text" name="ord_fname" id="ord_fname" value="<?php echo $ord_fname;?>"></td>
	</tr>
	<tr>
		<td>Enter Last name:-</td>
		<td><input type="text" name="ord_lname" id="ord_lname" value="<?php echo $ord_lname;?>"></td>
	</tr>
	<tr>
		<td>Enter Address:-</td>
		<td><textarea name="ord_address" row="5" col="200" id="ord_address"><?php echo $ord_address;?></textarea></td>
	</tr>
	<tr>
		<td>Enter Your Town/City:-</td>
		<td><input type="text" name="ord_city" id="ord_city" value="<?php echo $ord_city;?>"></td>
	</tr>
	<tr>
		<td>Enter Your Postcode/ZIP :-</td>
		<td><input type="text" name="ord_pcode" id="ord_pcode" value="<?php echo $ord_pcode;?>"></td>
	</tr>
	<tr>
		<td>Enter Contact Number:-</td>
		<td><input type="text" name="ord_contact" pattern="[0-9]+" title="number only" id="ord_contact" value="<?php echo $ord_contact;?>"></td>
	</tr>
	<tr>
		<td>Enter Email id:-</td>
		<td><input type="text" name="ord_email" id="ord_email"value="<?php echo $ord_email ; ?>"></td>
	</tr>
	<tr>
		<td>Enter Order notes :-</td>
		<td><textarea name="ord_note" row="5" col="200" id="ord_note"><?php echo $ord_note;?></textarea></td>
	</tr>
<?php } ?> 
		<tr><td colspan="2">
		<table  width="100%" border="1">
		<?php
				$fetchprod="select * from order_products where ord_id='".$ord_id."'";
				$count=0;
				$totalPrice=0;
				$resultrecord=mysqli_query($conn,$fetchprod);
				$rowcount=mysqli_num_rows($resultrecord);
				if($rowcount>0){
				while($ferow = mysqli_fetch_assoc($resultrecord)) {
				?>
				<tr>
				<td width="70%"><?php echo $ferow["prod_name"];?></td>
				<td width="20%"><?php echo $ferow["prod_qty"];?></td>
				<?php $total=$ferow["prod_price"] *$ferow["prod_qty"]; ?>
				<td width="10%" align="right"><?php echo $total;?></td>
				<?php $count++;
				$totalPrice=($totalPrice+$total);
				?></tr> 
				<?php }  } ?>
				<tr><td colspan="2" align="right">Total Price:-</td><td align="right" colspan="2"><?php echo $totalPrice; ?> </td> 	
				</tr>
		</table></td></tr>
	<tr>
	<?php if($ord_status!=2){?>
	<td>Please select order status:-</td>
	<td><select name="ord_status"> 
	<option value="1">Progress</option>
	<option value="3">Cancle</option>
	</select></td></tr>
	<?php }  else{?>
		<tr><td>Your Order Status is:-</td>
	<td>Completed</td></tr>
	<?php } 
	?>
	<tr><?php if($ord_status!=2){?>
		<td colspan="2" align="center">
		<input type="submit" name="bntsubmit" value="Submit">
		</td>
	</tr>
	<?php }  else{?>
		<tr><td colspan="2" align="center">
		<input type="button" onClick="location.href='profile.php'" value="Back">
	</td></tr>
	<?php } 
	?>
</table>
</form>
<?php }else{?>
<h2>View Order</h2>
<?php
if(isset($_GET['k']) && $_GET['k']!=''){
	if($_GET['k']=='edit'){
		echo '<font color="green"><h5>Record has been updated.</h5></font>';		
	}
}
?>
<table width="100%" border="1">
<thead>
<tr>
<th> Order id</th>
<th>Total Products</th>
<th>Total Price</th>
<th>Status</th>
<th>Order date</th>
<th>Edit</th>
</tr>
</thead>
<tbody>
<?php

 $sel_query="SELECT *,DATE(ord_createdate) AS order_date FROM `order_master`  where `usr_id`='".$_SESSION["usr_id"]."' order by `ord_createdate` DESC " ;
//print_r($sel_query);
//exit;
	$count=1;
	$result = mysqli_query($conn,$sel_query);
	$totalrec = mysqli_num_rows($result);
	if($totalrec==0)
	{?>
		<tr><td colspan="6" align="center">THERE IS NO RECORD TO DISPLAY.....</td></tr>
	<?php }
	else {
	while($row = mysqli_fetch_assoc($result)) { ?>
<tr><td align="center"><?php echo $row["ord_id"] ?></td>
<td align="center"><?php echo $row["ord_totalprod"]; ?></td>
<td align="center"><?php echo $row["ord_total"]; ?></td>
<td align="center"><?php if($row["ord_status"]==1){echo "Progress"; }else if($row["ord_status"]==2) { echo "Completed" ; } else { echo "Cancle" ; } ?></td>
<td align="center"><?php echo $row["order_date"]; ?></td>
<td align="center">
<a href="profile.php?action=edit&id=<?php echo $row["ord_id"]; ?>">Edit</a>
</td>
</tr>
<?php $count++; }} ?>
</tbody>
</table>

<?php } ?>
</td></tr></table>
</td></tr></table>
<?php include('footer.php'); ?>