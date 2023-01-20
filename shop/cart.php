
<?php include("header.php");
//echo $_COOKIE['prodid_'.$_SESSION['usr_id']];
$prodid="";

if(isset($_GET['editcart']) && $_GET['editcart']=='Update'){
	$prodid=$_GET['prodid'];
	$qty=$_GET['qty'];	
$checkproductcookie=explode('#',$_COOKIE['prodid_'.$_SESSION['usr_id']]);
$recreatecookie='';
	foreach($checkproductcookie as $value){
		$getprodid=explode('$',$value);
		if($getprodid['0']!='' && $getprodid['1']!=''){
		
		if($getprodid['0']==$prodid){
			$recreatecookie.=$getprodid['0'].'$'.$qty.'#';
		}else{
			$recreatecookie.=$getprodid['0'].'$'.$getprodid['1'].'#';
			}

		}
	}
	setcookie('prodid_'.$_SESSION['usr_id'], $recreatecookie);
	header("Location:".SITE_URL."cart.php?msg=u");
	exit;

}
/*if(isset($_GET['qty']) && $_GET['qty']!=''){
	$productqty=$_GET['qty'];
}
else{
	$productqty='1';
	}*/	
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
?>
<table><tr>
<?php include("left_panel.php");?>

<td widht="80%" align="center" valign="top" style="width: 100%;">
	<table border="0" width="100%" valign="top" align="center">
			<tr><th width="100%" align="center">Cart</th></tr>
			<tr>
			<table border="1" width="100%" valign="top" align="center">
				
			<?php
			if(isset($_SESSION['usr_email']) && isset($_SESSION['usr_id']))
			{

				if(isset($_COOKIE['prodid_'.$_SESSION['usr_id']]) && $_COOKIE['prodid_'.$_SESSION['usr_id']]!='')
				{
				
				$checkproductcookie=explode('#',$_COOKIE['prodid_'.$_SESSION['usr_id']]);
				foreach($checkproductcookie as  $value)
				{
				$getprodid=explode('$',$value);
				if($getprodid['0']!=0)
				{
				$prosel="SELECT * FROM `product_master` where prod_status=1 and prod_id='".$getprodid['0']."' " ;
				
				$proresult = mysqli_query($conn,$prosel);
				$prorec = mysqli_num_rows($proresult);
				if($prorec>0)
				{
					$count=0;
					while($row = mysqli_fetch_assoc($proresult)) 
				{
				?>
				<tr><td><?php
				if($row["prod_image"]!='')
				{
				$imgbasepath=$_SERVER['DOCUMENT_ROOT'].'/test/khyati/shop/prodimg/'.$row["prod_image"];
				if(file_exists($imgbasepath))
				{
				$imagepath=SITE_URL.'prodimg/'.$row["prod_image"];
				echo ' <img src="'.$imagepath.'" width="100" height="100">';
				}
				}
				?>
				</td><td><?php echo $row["prod_name"];?></td>
				<td>
				<form action="cart.php" method="GET">
					<input type="hidden" name="prodid" value="<?php echo $row['prod_id']?>">
						Quantity:-<input type="number" name="qty" value=<?php echo $getprodid['1']; ?> >
					<input type="submit" name="editcart" value="Update">
				</form></td>
			</tr>

					<?php 
					$count++; } }
						}
					 }

					 ?>
					 <tr><td colspan="3" align="right"><a href="checkout.php">Proceed to checkout</a></td></tr></table>

					<?php }else{
					echo '<tr><td width="100%" colspan="3" align="center"> <center>Your Cart is empty...<center></td></tr>';

					 } }else{   ?>
					 <tr><td width="100%" colspan="3" align="center">Your Cart is empty...</td></tr>
					 <?php } ?>

	</table>
</td>

</tr></table>
  

<?php include("footer.php");?>