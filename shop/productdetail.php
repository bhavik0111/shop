<?php 
include("header.php");
//setcookie('prodid', '', time() - 3600, '/');
//isset($_COOKIE['prodid_'.$_SESSION['usr_id']]);
$ps='';	
$pe='';	
$title='';
$prodfor='';
$psage='';
$peage='';
$productqty="";
$prodid="";
if(isset($_GET['prodid']) && $_GET['prodid']!=''){
	$prodid=$_GET['prodid'];	
}
$productqty='1';
if($prodid!='' && isset($_COOKIE['prodid_'.$_SESSION['usr_id']])){
	$checkproductcookie=explode('#',$_COOKIE['prodid_'.$_SESSION['usr_id']]);
	$validetoadd='true';
	foreach($checkproductcookie as $value){
		$getprodid=explode('$',$value);
		if($getprodid['0']==$prodid){
			$productqty=$getprodid['1'];
			break;
		}
	}
}

?>

	<table width="100%">
	<tr><td widht="25%" align="center" valign="top">
	<?php include("left_panel.php");?>
	</td>

	<td widht="75%" align="center" valign="top" >
	<table width="100%" >
	<tr><td widht="75%" align="center" valign="top">
		<table width="100%" >
			<tr><th><center>Product Details</center></th></tr>
		</table></td></tr>
		<tr><td widht="75%" align="center" valign="top" >
		<table border="1" width="100%">
			<?php
			$prosel="SELECT * FROM `product_master` where prod_status=1 and prod_id='".$prodid."' " ;
			$count=1;
			$proresult = mysqli_query($conn,$prosel);
			$prorec = mysqli_num_rows($proresult);
			if($prorec>0){
			while($row = mysqli_fetch_assoc($proresult)) {
			?>
			<tr>
			<td width="30%"><?php
			if($row["prod_image"]!=''){
			$imgbasepath=$_SERVER['DOCUMENT_ROOT'].'/test/khyati/shop/prodimg/'.$row["prod_image"];
			if(file_exists($imgbasepath)){
			$imagepath=SITE_URL.'prodimg/'.$row["prod_image"];
			echo ' <img src="'.$imagepath.'" width="200" height="200">';
			}
			}
			?></td>
			<td width="70%">
				<table><tr><td>Product Name:-<?php echo $row["prod_name"];?></td></tr><tr>
				<td>Category:-<?php echo get_catname($row["cat_id"],$conn);?></td></tr><tr>
				<td><b>Product Price:-<?php echo $row["prod_price"];?></b></td></tr>
				<tr><td>Product Description:-<?php echo $row["prod_desc"];?></td></tr>
				<tr><td>Product Quantity:-<?php echo $row["prod_qty"];?></td></tr>
				<tr><td>Product Made for:-<?php echo $row["prod_cat"] == '1'? 'Men':'Women';?></td></tr>
				
				<tr><td><form action="addtocart.php?qty" method="get">
					<input type="hidden" name="prodid" value="<?php echo $row['prod_id']?>">
					<input type="hidden" name="returnprod" value="1">
					Add Quantity:-<input type="number" name="qty" value="<?php echo $productqty ;?>">
					<input type="submit" name="addcart" value="Add"></form></td>
			</tr></table>
				<?php $count++; } } ?></td>
		</table>
	</td></tr>
	</table>
</td></tr></table>
<?php include('footer.php');?>
