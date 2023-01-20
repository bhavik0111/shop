<?php
include('header.php');
if(isset($_GET['qty']) && $_GET['qty']!=''){
		$productqty=$_GET['qty'];
	}
	else{
		$productqty='1';
	}
$require="";
$ord_id="";
$ord_fname="";
$ord_lname="";
$ord_address="";
$ord_city="";
$ord_pcode="";
$ord_contact="";
$ord_email="";
$ord_note="";
$ord_status="";
if(isset($_GET['action']) && $_GET['action']=='delete')
{
 	if(isset($_GET['id']) && $_GET['id']!='')
 		{
 		$delete="DELETE FROM order_master where ord_id='".$_GET['id']."'";
		$resdel = mysqli_query( $conn, $delete );
		$quedelete="DELETE FROM order_products where ord_id='".$_GET['id']."'";
		$delres=mysqli_query( $conn, $quedelete );
		header("Location:".SITE_URL."admin/order.php"); 
		exit;
        }

    else
	{
		header("Location:".SITE_URL."admin/order.php"); 
		exit;
	} 
}
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
 		header("Location:".SITE_URL."admin/order.php"); 
 		exit;
 	}
 }
//if(isset($_SESSION['usr_email']) && isset($_SESSION['usr_id']))
//{
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
	$ord_totalprod=$_POST['ord_totalprod'];
	$totalPrice=$_POST['ord_total'];
	if($ord_fname==''){
		$require="All fields are required";	
	}
	else if($ord_lname==''){
		$require="All fields are required";	
	}
	else if($ord_address==''){
		$require="All fields are required";	
	}
	else if($ord_city==''){
		$require="All fields are required";	
	}
	else if($ord_pcode==''){
		$require="All fields are required";	
	}
	else if($ord_contact==''){
		$require="All fields are required";	
	}
	else if($ord_note==''){
		$require="All fields are required";	
	}
	else{
			$qryupd = "UPDATE order_master set `ord_fname`='".$ord_fname."',`ord_lname`='".$ord_lname."',`ord_address`='".$ord_address."' ,`ord_city`='".$ord_city."' ,`ord_pcode`='".$ord_pcode."',`ord_contact`='".$ord_contact."' ,`ord_email`='".$ord_email."',`ord_note`='".$ord_note."',`ord_status`='".$ord_status."'  where `ord_id`='".$ord_id."'" ;
			//print_r($qryupd);
			//exit;
			mysqli_query($conn, $qryupd);
			header("Location:".SITE_URL."admin/order.php?k=edit"); 
				exit;
			} 
}
//}
?>
<?php if(isset($_GET['action']) && $_GET['action']=='edit'){?>
<?php if($_GET['action']=='edit' && $_GET['id']!=''){?><h1>Edit Order</h1>
<form action="order.php?action=edit&id=<?php echo $_GET['id'];?>" method="post" onsubmit="return validform()" >
<?php } ?>
<font color="red"><?php echo $require;?></font>
<table  width="100%" border="1" >
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
		<td><input type="text" name="ord_email" id="ord_email" value="<?php echo $ord_email ; ?>"></td>
	</tr>
	<tr>
		<td>Enter Order notes :-</td>
		<td><textarea name="ord_note" row="5" col="200" id="ord_note"><?php echo $ord_note;?></textarea></td>
	</tr>
	<tr>
		<td>Please select order status:-</td>
		<td><select name="ord_status"> 
		<?php for($k=1;$k<=3;$k++)
			{
		?>
		<option value="<?php echo $k;?>"  <?php echo ($ord_status==$k?'selected="selected"':'');?> ><?php if($k==1){ echo "Progress" ; } else if($k==2){ echo "Completed" ;} else{ echo "Cancle" ;}?></option>
		<?php 
			}
		?>
	</select></td></tr>
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
				<?php $total=$ferow["prod_price"]*$ferow["prod_qty"]; ?>
				<td width="10%" align="right"><?php echo $total ;?></td>
				<?php $count++;
				$totalPrice=($totalPrice+$total);
				?></tr> 
				<?php }  } ?>

				<tr><td colspan="2" align="right">Total Price:-</td><td align="right" colspan="2"><?php echo $totalPrice; ?> </td> 	
				</tr>

		</table>
	</td></tr>
	<tr>
		<td colspan="2" align="right">
		<input type="submit" name="bntsubmit" value="Submit">
		</td>
	</tr>
</table>
</form>
<?php }else{?>
<h2>View Order</h2>
<?php
if(isset($_GET['k']) && $_GET['k']!=''){
	if($_GET['k']=='edit'){
		echo '<h5>Record has been updated.</h5>';		
	}
	elseif($_GET['k']=='delete'){
		echo '<h5>Record has been deleted.</h5>';		
	}
}
$limit = 5; 
if (isset($_GET["page"])) {  
     $pageno  = $_GET["page"];  
}else {  
      $pageno=1;  
};   
$start_from = ($pageno-1) * $limit;   

$search='';
if(isset($_GET['search'])){
	if($_GET['search']!=''){
		$search=$_GET['search'];		
	}
}
?>
<form action="order.php?action=search" method="get"><input type="text" name="search" value="<?php echo $search ;?>"><input type="submit" name="button" value="Search"></form><br>
<table width="100%" border="1">
<thead>
<tr>
<th> Order id</th>
<th> User id</th>
<th>Name</th>
<th> Address</th>
<th> City</th>
<th>Contact</th>
<th>Email id</th>
<th>Total Price</th>
<th>Total Product</th>
<th>Status</th>
<th>Order date</th>
<th>Edit</th>
<th>Delete</th>
</tr>
</thead>
<tbody>
<?php
$search='';
if(isset($_GET['button']) && isset($_GET['search'])){
	if($_GET['search']!=''){
		$search=$_GET['search'];		
	}
}
if($search!=''){
	$sel_query="SELECT *, DATE(ord_createdate) AS ord_createdate FROM `order_master` WHERE `ord_fname` LIKE '%".$search."%'  order by `ord_createdate` desc LIMIT ".$start_from.", ".$limit." ";
}else{
	$sel_query="SELECT *,DATE(ord_createdate) AS ord_createdate  FROM `order_master` order by `ord_createdate` desc LIMIT ".$start_from.", ".$limit." ";
}

	$count=1;
	$result = mysqli_query($conn,$sel_query);
	$totalrec = mysqli_num_rows($result);
	if($totalrec>0){
	while($row = mysqli_fetch_assoc($result)) { ?>
<tr><td align="center"><?php echo $row["ord_id"] ?></td>
<td align="center"><?php echo $row["usr_id"] ?></td>
<td align="center"><?php echo $row["ord_fname"]; ?>
<?php echo $row["ord_lname"]; ?></td>
<td align="center"><?php echo $row["ord_address"]; ?></td>
<td align="center"><?php echo $row["ord_city"]; ?></td>
<td align="center"><?php echo $row["ord_contact"]; ?></td>
<td align="center"><?php echo $row["ord_email"]; ?></td>
<td align="center"><?php echo $row["ord_total"]; ?></td>
<td align="center"><?php echo $row["ord_totalprod"]; ?></td>
<td align="center"><?php if($row["ord_status"]==1){echo "Progress"; }else if($row["ord_status"]==2) { echo "Completed" ; } else { echo "Cancle" ; } ?></td>
<td align="center"><?php echo $row["ord_createdate"]; ?></td>
<td align="center">
<a href="order.php?action=edit&id=<?php echo $row["ord_id"]; ?>">Edit</a>
</td>
<td align="center">
<a href="order.php?action=delete&id=<?php echo $row["ord_id"]; ?>" onclick="return confirm('Are you sure you want to delete??');">Delete</a>
</td>
</tr>
<?php $count++; }} ?>
</tbody>
</table>
<ul class="pagination"> 
      <?php 
      if($search!=''){
      	$viewrecord = "SELECT COUNT(*) FROM order_master WHERE `ord_fname` LIKE '%".$search."%'";   
      }else{
      	$viewrecord = "SELECT COUNT(*) FROM order_master";   
      }	
        $qryresult = mysqli_query($conn,$viewrecord);   
        $qryrec = mysqli_fetch_row($qryresult);   
        $total_records = $qryrec[0];   
        $total_pages = ceil($total_records / $limit);   
        $page = "";                         
        for ($i=1; $i<=$total_pages; $i++) { 
      			if($search!=''){
      		$page .= "<li class='active'><a href='order.php?page=".$i."&search=".$search."'>".$i."</a></li>"; 		
      	}else{
      		$page .= "<li class='active'><a href='order.php?page=".$i."'>".$i."</a></li>"; 
      	}
              
            };   
        echo $page;
        

      ?> 
      </ul> 

<?php } ?>
<a href="order.php">Back to Order page</a>
<?php include('footer.php'); ?>