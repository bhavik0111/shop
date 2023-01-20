<?php
require('shopdb.php');
//print_r($_GET);

$cat_id="";
if(isset($_GET['catid']) && $_GET['catid']!=''){
	$cat_id=$_GET['catid'];	
}
$prodfor="";
if(isset($_GET['prodfor']) && $_GET['prodfor']!=''){
	$prodfor=$_GET['prodfor'];	
}
$search="";
if(isset($_GET['search']) && $_GET['search']!=''){
	$search=$_GET['search'];
}
$prod_price="";
if(isset($_GET['prod_price']) && $_GET['prod_price']!=''){
	$prod_price=$_GET['prod_price'];
}
//print_r($cat_id);
if($cat_id!="" || $prodfor!="" || $search!="" || $prod_price!=""){
?>
<table width="100%" border="1" align="center">
	<tr><th>Product Name</th>
		<th>Product Price</th>
		<th>Product Image</th></tr>
<?php 
$wheredata='';
if($search!=''){
$wheredata.="`prod_name` LIKE '%".$search."%' AND ";
}
if($cat_id!=''){
$wheredata.="`cat_id`='".$cat_id."' AND ";
}
if($prodfor !=''){
$wheredata.="`prod_cat`='".$prodfor."' AND ";	
}
if($prod_price !=''){
$wheredata.="`prod_price`='".$prod_price."' AND ";	
}
$getproduct="SELECT * FROM `product_master` where" .$wheredata. "prod_status=1";
$resultdata=mysqli_query($conn,$getproduct);
$countrow=mysqli_num_rows($resultdata);
if($countrow>0){
$count=0;
while( $rows = mysqli_fetch_assoc($resultdata) ) { ?>
	<tr><td align="center" width="30%"><?php echo $rows["prod_name"]; ?></td> 
	<td align="center" width="20%"><?php echo $rows["prod_price"]; ?></td> 
	<td align="center" width="50%"><?php
	if($rows["prod_image"]!=''){
	$imgbasepath=SITE_ROOT_URL.'prodimg/'.$rows["prod_image"];
	if(file_exists($imgbasepath)){
		$imagepath=SITE_URL.'prodimg/'.$rows["prod_image"];
		echo ' <img src="'.$imagepath.'" width="100" height="90">';
	}
	}
	?></td></tr>
	<?php 
		$count++;  } ?>
</table>
<?php    
} else{   ?>
<tr><td colspan="3" align="center">No Products to Display...</td></tr>
<?php
}
}else{
	echo "Nothing to display.....";
}
?>
