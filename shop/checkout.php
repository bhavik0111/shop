<?php
include("header.php");
$cat_id="";
if(isset($_GET['cat']) && $_GET['cat']!=''){
	$cat_id=$_GET['cat'];	
}
$title="";
if(isset($_GET['title']) && $_GET['title']!=''){
	$title=$_GET['title'];	
}
$ps="";
$pe="";
if(isset($_GET['ps']) && $_GET['ps']!=''){
	$ps=$_GET['ps'];	
}
if(isset($_GET['pe']) && $_GET['pe']!=''){
	$pe=$_GET['pe'];	
}
$prodfor="";
if(isset($_GET['prodfor']) && $_GET['prodfor']!=''){
	$prodfor=$_GET['prodfor'];	
}
$psage="";
if(isset($_GET['psage']) && $_GET['psage']!=''){
	$psage=$_GET['psage'];	
}
$peage="";
if(isset($_GET['peage']) && $_GET['peage']!=''){
	$peage=$_GET['peage'];	
}
$prodid="";
if(isset($_GET['prodid']) && $_GET['prodid']!=''){
	$prodid=$_GET['prodid'];	
}
if(isset($_GET['qty']) && $_GET['qty']!=''){
		$productqty=$_GET['qty'];
	}
	else{
		$productqty='1';
	}
	
$require="";
$ord_fname="";
$ord_lname="";
$ord_address="";
$ord_city="";
$ord_pcode="";
$ord_contact="";
$ord_email="";
$ord_note="";
$ord_totalprod="";
$totalPrice="";
$prod_id="";
$prod_name="";
$prod_price="";

if(isset($_SESSION['usr_email']) && isset($_SESSION['usr_id']))
{
if(isset($_POST['bntsubmit']) && $_POST['bntsubmit']=='Submit')
{
	$ord_fname=$_POST['ord_fname'];
	$ord_lname=$_POST['ord_lname'];
	$ord_address=$_POST['ord_address'];
	$ord_city=$_POST['ord_city'];
	$ord_pcode=$_POST['ord_pcode'];
	$ord_contact=$_POST['ord_contact'];
	$ord_email=$_POST['ord_email'];
	$ord_note=$_POST['ord_note'];
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
	else{
	$sql = "INSERT INTO `order_master` (`usr_id`,`ord_fname`,`ord_lname`, `ord_address`, `ord_city`, `ord_pcode`, `ord_contact`, `ord_email`, `ord_note`,`ord_total`,`ord_totalprod`,`ord_status`) VALUES ('".$_SESSION['usr_id']."','".$ord_fname."','".$ord_lname."','".$ord_address."','".$ord_city."','".$ord_pcode."','".$ord_contact."','".$ord_email."','".$ord_note."','".$totalPrice."','".$ord_totalprod."','1')";
	if(mysqli_query($conn, $sql))
	{	
		$insord_id=mysqli_insert_id($conn);
		$addproductcookie=explode('#',$_COOKIE['prodid_'.$_SESSION['usr_id']]);
		foreach($addproductcookie as  $value){
				$getprodid=explode('$',$value);

				$fetch="SELECT * FROM `product_master` where prod_id='".$getprodid[0]."'";
				$presult= mysqli_query($conn,$fetch);
				$prorecord = mysqli_num_rows($presult);
				if($prorecord>0){
				$row = mysqli_fetch_assoc($presult);
			$query="INSERT INTO `order_products`(`ord_id`, `prod_id`, `prod_name`, `prod_price`, `prod_qty`,`total_qty`, `total_price`) VALUES ('".$insord_id."','".$row["prod_id"]."','".$row["prod_name"]."','".$row["prod_price"]."','".$getprodid[1]."','".$ord_totalprod."','".$totalPrice."')";
			$record=mysqli_query($conn,$query);
		} }
		setcookie('prodid_'.$_SESSION['usr_id'], '', time() - 3600);
		header("Location:".SITE_URL."index.php");
		exit; 
	}
}
}
}
?>
<table>
	<tr>
<?php include("left_panel.php"); 
?>
<script language="javascript" type="text/javascript">
function validform()
{
	var isFormValid = true;
	/*var ord_fname=document.getElementById("ord_fname").value;
	var ord_lname=document.getElementById("ord_lname").value;
	var ord_address=document.getElementById("ord_address").value;
	var ord_city=document.getElementById("ord_city").value;
	var ord_pcode=document.getElementById("ord_pcode").value;
	var ord_contact=document.getElementById("ord_contact").value;*/
	var ord_email=document.getElementById("ord_email").value;
	/*var ord_note=document.getElementById("ord_note").value;
	if(ord_fname==''){
		alert('Please enter your first name.');
		document.getElementById("ord_fname").focus();
		isFormValid=false;
	}
	else if(ord_lname==''){
		alert('Please enter your last name.');
		document.getElementById("ord_lname").focus();
		isFormValid=false;
	}
	else if(ord_address==''){
		alert('Please enter your address.');
		document.getElementById("ord_address").focus();
		isFormValid=false;
	}
	else if(ord_city==''){

		alert('Please enter your City .');
		document.getElementById("ord_city").focus();
		isFormValid=false;
	}
	else if(ord_pcode==''){

		alert('Please enter your Pin code .');
		document.getElementById("ord_pcode").focus();
		isFormValid=false;
	}
	else if(ord_contact==''){

		alert('Please enter your contact number .');
		document.getElementById("ord_contact").focus();
		isFormValid=false;
	}
	else if(ord_email==''){

		alert('Please enter your Email id .');
		document.getElementById("ord_email").focus();
		isFormValid=false;
	}
	else if(ord_note==''){

		alert('Please enter your Pin code .');
		document.getElementById("ord_note").focus();
		isFormValid=false;
	}
	
	else {*/
		if(ord_email!='' && isFormValid==true){
			if(isEmail(ord_email)==false){
				alert('Please enter valid email .');
				document.getElementById("ord_email").focus();
				isFormValid=false;
			}
		}

	}
	return isFormValid;
//}  
function isEmail(ord_email){
         var validateEmail = function(ord_email) {
      	return  /^\S+@\S+\.\S+$/.test(ord_email);
    	}
    return validateEmail(ord_email); // False
} 
</script>
<td widht="80%" align="center" valign="top" style="width: 100%" >
<div class="form">
<form action="checkout.php" method="post" onsubmit="return validform()" >
<font color="red"><?php echo $require;?></font>
<table width="100%" border="1" >
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
		<td><textarea name="ord_address" row="5" col="200" id="ord_address" value="<?php echo $ord_address;?>"></textarea></td>
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
		<td><input type="text" name="ord_email" id="ord_email" value="<?php echo $_SESSION["usr_email"];?>"></td>
	</tr>
	<tr>
		<td>Enter Order notes :-</td>
		<td><textarea name="ord_note" row="5" col="200" id="ord_note" value="<?php echo $ord_note;?>"></textarea></td>
	</tr>
	<tr>
		<td colspan="2">
		<table width="100%" border="0">
		<?php
			if(isset($_SESSION['usr_email']) && isset($_SESSION['usr_id']))
			{ 
				$i=0;
				$checkproductcookie=explode('#',$_COOKIE['prodid_'.$_SESSION['usr_id']]);
					$totalPrice=0;
				foreach($checkproductcookie as  $value){
					$i++;
				$getprodid=explode('$',$value);
				if($getprodid['0']!=0){
				echo $prosel="SELECT * FROM `product_master` where prod_status=1 and prod_id='".$getprodid['0']."' " ;
				$count=0;
				$proresult = mysqli_query($conn,$prosel);
				$prorec = mysqli_num_rows($proresult);
				if($prorec>0){
				while($row = mysqli_fetch_assoc($proresult)) {
				?>
				
				<tr>
				<td width="70%"><?php echo $row["prod_name"];?></td>
				<td width="20%"><?php echo $getprodid[1];?></td>
				<?php $total=$row["prod_price"]*$getprodid[1] ;?>
				<td width="10%" align="right"><?php echo $total;?></td>
				<?php $count++; 	
					$totalPrice=($totalPrice+$total);
				}  $ord_totalprod= $i;
				} } } }  ?></tr>
				<td colspan="2" align="right">Total Price:-</td><td align="right" colspan="2"><?php echo $totalPrice; ?> </td>
				
		</table>
	</td></tr>
	<tr>
		<td colspan="2" align="right">
<input type="hidden" name="ord_total" value="<?php echo $totalPrice; ?>">
<input type="hidden" name="ord_totalprod" value="<?php echo $ord_totalprod; ?>">
			<input type="submit" name="bntsubmit" value="Submit"></td>
	</tr>
</table>
</form>
</div>
</td></tr></table>
<br/>
<center><?php include("footer.php");?></center>