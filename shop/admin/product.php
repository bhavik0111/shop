<?php
include('header.php');

 $require="";
 $dataexist="";
 $cat_id="";
 $prod_id="";
 $prod_name="";
 $prod_price="";
 $prod_image="";
 $prod_desc="";
 $prod_cat="";
 $prod_sage="";
 $prod_eage="";
 $prod_qty="";
 $prod_status="";
 if(isset($_GET['action']) && $_GET['action']=='delete'){
 	if(isset($_GET['id']) && $_GET['id']!=''){
		$imgbasepath=SITE_ROOT_URL."prodimg/";
		$imgget = "select prod_image from product_master where prod_id='".$_GET['id']."'";
		$imgresult = mysqli_query($conn, $imgget);
		$rowimg = mysqli_fetch_assoc($imgresult);
 		$delimg=$imgbasepath.$rowimg['prod_image'];

 		if($delimg!=''){
 			if(file_exists($delimg)){
 			unlink($delimg);
 			}
 		}

 		$delete="DELETE FROM product_master where prod_id='".$_GET['id']."'";
		$resdel = mysqli_query( $conn, $delete );

		header("Location:".SITE_URL."admin/product.php?k=delete"); 
		exit;
        }
	else
	{
		header("Location:".SITE_URL."admin/product.php"); 
		exit;
	} 
    }
 
 if(isset($_GET['action']) && $_GET['action']=='edit'){
 	if(isset($_GET['id']) && $_GET['id']!=''){
 		$prod_id=$_GET['id'];
		$query = "select * from product_master where prod_id='".$_GET['id']."' "; 
		$result = mysqli_query($conn, $query);
		$row = mysqli_fetch_assoc($result);
 		$cat_id=$row['cat_id'];
 		$prod_name=$row['prod_name'];
 		$prod_price=$row['prod_price'];
 		$prod_image=$row['prod_image'];
		$prod_desc=$row['prod_desc'];
		$prod_cat=$row['prod_cat'];
		$prod_sage=$row['prod_sage'];
		$prod_eage=$row['prod_eage'];
		$prod_qty=$row['prod_qty'];

 		$prod_status=$row['prod_status'];	

 	}else{
 		header("Location:".SITE_URL."admin/product.php"); 
 		exit;
 	}
 }
if(isset($_POST['submit']) && ($_POST['submit']=='Add' || $_POST['submit']=='Edit')){
	print_r($_FILES);exit;
	$cat_id=$_POST['cat_id'];
	$prod_name=$_POST['prod_name'];	
	$prod_price=$_POST['prod_price'];	
	$prod_image=$_FILES['prod_image'];
	$prod_desc=$_POST['prod_desc'];
	$prod_cat=$_POST['prod_cat'];
	$prod_sage=$_POST['prod_sage'];
	$prod_eage=$_POST['prod_eage'];
	$prod_qty=$_POST['prod_qty'];
	if(isset($_POST['prod_status'])){
		$prod_status=$_POST['prod_status'];
	}
	/*if($cat_id==''){
		$require="All fields are required";	
	}
	else if($prod_name==''){
		$require="All fields are required";	
	}
	else if($prod_desc==''){
		$require="All fields are required";	
	}
	else if($prod_image==''){
		$require="All fields are required";	
	}
	else if($prod_status==''){
		$require="All fields are required";	
	}
	else{*/
		
	if($prod_id!=''){
			$query = "select * from product_master where prod_name='".$prod_name."' and prod_id!='".$prod_id."'"; 
		}else{
			$query = "select * from product_master where prod_name='".$prod_name."'"; 
		}
		$result = mysqli_query($conn, $query);
		$total = mysqli_num_rows($result);
		if($total>0){
			$dataexist="Product is already Exists";
		}else{
			if($_POST['submit']=='Add'){
				$sql = "INSERT INTO product_master (`cat_id`,`prod_name`,`prod_price`,`prod_desc`,`prod_qty`,`prod_cat`,`prod_sage`,`prod_eage`,`prod_status`) VALUES ('".$cat_id."','".$prod_name."', '".$prod_price."','".$prod_desc."','".$prod_qty."','".$prod_cat."','".$prod_sage."','".$prod_eage."','".$prod_status."') ";
			
				$returnsql=mysqli_query($conn, $sql);
				$prod_id=mysqli_insert_id($conn);
				
				if($prod_id!='' && $_FILES['prod_image']!=''){
					$imgbasepath=SITE_ROOT_URL.'prodimg/';
					$storeimagename=$_FILES['prod_image']['name'];
					move_uploaded_file($_FILES['prod_image']['tmp_name'], $imgbasepath.$storeimagename);

					$qryupd = "UPDATE product_master set `prod_image`='".$storeimagename."' where `prod_id`='".$prod_id."'" ;
					mysqli_query($conn, $qryupd);
				}
				header("Location:".SITE_URL."admin/product.php?k=add"); 
				exit;
			}
		
		if($_POST['submit']=='Edit'){
			
				 $qryupd = "UPDATE product_master set `cat_id`='".$cat_id."',`prod_name`='".$prod_name."',`prod_price`='".$prod_price."',`prod_desc`='".$prod_desc."',`prod_qty`='".$prod_qty."',`prod_cat`='".$prod_cat."',`prod_sage`='".$prod_sage."',`prod_eage`='".$prod_eage."',`prod_status`='".$prod_status."' where `prod_id`='".$prod_id."'" ;
				mysqli_query($conn, $qryupd);
				if($prod_id!='' && $_FILES['prod_image']['name']!=''){
					$imgbasepath=$_SERVER['DOCUMENT_ROOT'].'/test/khyati/shop/prodimg/';
					$storeimagename=$_FILES['prod_image']['name'];
					
					// get file name 
					$querygetfilename = "select prod_image from product_master where prod_id='".$prod_id."'"; 
					$resultfilename = mysqli_query($conn, $querygetfilename);
					$rowfilename = mysqli_fetch_assoc($resultfilename);
 					$deleprodimage=$rowfilename['prod_image'];
 					//echo $deleprodimage;
					if($deleprodimage!=''){
 						if(file_exists($imgbasepath.$deleprodimage)){
 							unlink($imgbasepath.$deleprodimage);
 						}
 					}

					
					move_uploaded_file($_FILES['prod_image']['tmp_name'], $imgbasepath.$storeimagename);
					$qryupd = "UPDATE product_master set `prod_image`='".$storeimagename."' where `prod_id`='".$prod_id."'" ;
					mysqli_query($conn, $qryupd);
				}
			header("Location:".SITE_URL."product.php?k=edit"); 
				exit;
			} 
			else {
	     		$require="Error: " . $qryupd . "<br>" . mysqli_error($conn);
			}
		}
	//}
	
}
?>
<script language="javascript" type="text/javascript">
function validform()
{
	var isFormValid = true;
	var prod_name=document.getElementById("prod_name").value;
	var prod_price=document.getElementById("prod_price").value;
	var cat_id=document.getElementById("cat_id").value;
	var prod_image=document.getElementById("prod_image").value;
	var hiddenimg=document.getElementById("hiddenimg").value;
	var prod_desc=document.getElementById("prod_desc").value;
	var prod_qty=document.getElementById("prod_qty").value;
	var prod_cat=document.getElementById("prod_cat").value;
	var prod_sage=document.getElementById("prod_sage").value;
	var prod_eage=document.getElementById("prod_eage").value;
	var prod_status=document.getElementById("prod_status").checked;
	var prod_status1=document.getElementById("prod_status1").checked;
	//alert(prod_status);
	//alert(prod_status1);
	if(cat_id==''){
		alert('Please select category.');
		document.getElementById("cat_id").focus();
		isFormValid=false;
	}
	else if(prod_name==''){
		alert('Please enter product name.');
		document.getElementById("prod_name").focus();
		isFormValid=false;
	}
	else if(prod_price=='' ){
		alert('Please enter numeric product price.');
		document.getElementById("prod_price").focus();
		isFormValid=false;
	}


	else if(prod_image=='' && hiddenimg==''){
		alert('Please select product image.');
		document.getElementById("prod_image").focus();
		isFormValid=false;
	}
	else if(prod_desc==''){
		alert('Please enter product description.');
		document.getElementById("prod_desc").focus();
		isFormValid=false;
	}
	else if(prod_qty==''){
		alert('Please enter product quantity.');
		document.getElementById("prod_qty").focus();
		isFormValid=false;
	}
	else if(prod_cat==''){
		alert('Please select product made for.');
		document.getElementById("prod_cat").focus();
		isFormValid=false;
	}
	else if(prod_sage==''){
		alert('Please select starting age.');
		document.getElementById("prod_sage").focus();
		isFormValid=false;
	}
	else if(prod_eage==''){
		alert('Please select ending age.');
		document.getElementById("prod_eage").focus();
		isFormValid=false;
	}
	
	else if(prod_status==false && prod_status1==false ){
		alert('Please select status.');
		document.getElementById("prod_status").focus();
		//document.getElementById("prod_status1").focus();
		isFormValid=false;
	}
	else{

		if(prod_price!='' ){
			if(isNumberKey(prod_price)==false){
				alert('Please enter valide product price.');
				document.getElementById("prod_price").focus();
				isFormValid=false;
			}
		}
		
	}

	return isFormValid;
}   
function isNumberKey(prod_price){
         var validatePrice = function(prod_price) {
      	return /^(?:\d+|\d{1,3}(?:,\d{3})+)(?:\.\d+)?$/.test(prod_price);
    	}
    return validatePrice(prod_price); // False

}
</script>
<div class="form">
<?php
if(isset($_GET['action']) && ($_GET['action']=='add' || $_GET['action']=='edit')){?>

<?php if($_GET['action']=='edit' && $_GET['id']!='' ){?><h1>Edit Product</h1>
<form action="product.php?action=edit&id=<?php echo $_GET['id'];?>" method="post" enctype="multipart/form-data" onsubmit="return validform();"  >
<?php }else{?><h1>Add Product</h1>
<form action="product.php?action=add" method="post" enctype="multipart/form-data" onsubmit="return validform();">
<?php }?>
<table>
<tr><td colspan="2" style="color: red;"><?php echo $dataexist;?></td></tr>
<tr><td><b>Select Category name:</b></td><td><select name="cat_id" id="cat_id"><option value="">Select Category</option><?php
$getcat = "SELECT cat_id,cat_name FROM category_master where cat_status=1";
     $catrow = mysqli_query($conn,$getcat);
     while($resultcat = mysqli_fetch_assoc($catrow) ) :
     	
     	?>
     	<option <?php echo ($cat_id==$resultcat['cat_id']?'selected=selected':'');?> value="<?php echo $resultcat['cat_id'];?>"><?php echo $resultcat['cat_name'];?>
     	</option>
	<?php endwhile; ?>
	</select></td></tr>
<tr><td><b>Enter Product name:</b></td><td><input type="text" name="prod_name" id="prod_name" value="<?php echo $prod_name;?>"></td></tr>
<tr><td><b>Enter Product price:</b></td><td><input type="text" name="prod_price" id="prod_price" value="<?php echo $prod_price;?>"></td></tr>

<tr><td><b>  Select image to upload:</b></td><td><input type="file" id="prod_image" name="prod_image"></td></tr>
<tr><td><b>Image:</b></td><td>
	<?php 
	if($prod_id!=''){
	$getimg="select prod_image from product_master where prod_id='".$prod_id."'";
	$resultimg=mysqli_query($conn,$getimg);
	$viewimg=mysqli_fetch_assoc($resultimg);
	$imagepath=SITE_URL.'prodimg/'.$viewimg["prod_image"];
	echo ' <img src="'.$imagepath.'" width="100" height="100">';
	}?>
	<input type="hidden" id="hiddenimg" name="hiddenimg"
	 value="<?php echo $prod_image;?>">
</td></tr>
<tr><td><b>Enter Product description:</b></td><td><textarea id="prod_desc" name="prod_desc" row="5" col="200" ><?php echo $prod_desc;?></textarea></td></tr>
<tr><td><b>Enter Product Quantity:</b></td><td><input type="number" name="prod_qty" id="prod_qty" value="<?php echo $prod_qty;?>"></td></tr>
<tr><td><b>Select Product made for:</b></td><td><select name="prod_cat" id="prod_cat">
   <option  <?php if($prod_cat=='1'){ echo 'selected="selected"'; }?> value="1">Men</option>
   <option <?php if($prod_cat=='0'){ echo 'selected="selected"'; }?>value="0">Women</option>
</select></td></tr>

<tr><td><b>Start age:</b></td><td><select name="prod_sage" id="prod_sage">
	<?php for($k=11;$k<=60;$k++)
	{
		?>
		<option value="<?php echo $k;?>"  <?php echo ($prod_sage==$k?'selected="selected"':'');?> ><?php echo $k;?></option>
		<?php 
	}
	?>
</select></td></tr><tr> 
<td><b>End age:</b></td><td><select name="prod_eage" id="prod_eage">
	<?php for($i=11;$i<=60;$i++)
	{
		?>
		<option value="<?php echo $i;?>" <?php echo ($prod_eage==$i?'selected="selected"':'');?> ><?php echo $i;?></option>
		<?php 
	}
	?>
</select></td>
</tr>
<tr><td><b>Enter Product status:</b></td><td><input type="radio" id="prod_status" name="prod_status" <?php if($prod_status=='1'){ echo 'checked="checked"'; }?> value="1">Active<input id="prod_status1"type="radio" name="prod_status" value="0" <?php if($prod_status=='0'){ echo 'checked="checked"'; }?> >Deactive</td></tr>
<tr><td colspan="2"><center><input type="submit" name="submit" <?php if($_GET['action']=='edit'){ echo 'value="Edit"'; }else { echo 'value="Add"'; }?> ></center></td></tr>
</table>
</form>
<?php }else{?>
<h2>View Product</h2>
<?php
if(isset($_GET['k']) && $_GET['k']!=''){
	if($_GET['k']=='edit'){
		echo '<h5>Record has been updated.</h5>';		
	}
	elseif($_GET['k']=='add'){
		echo '<h5>Record has been added.</h5>';		
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
<a href="product.php?action=add">ADD</a>
<form action="product.php?action=search" method="get"><input type="text" name="search" value="<?php echo $search;?>"> <input type="submit" name="button" value="Search"></form><br>
<table width="100%" border="1">
<thead>
<tr>
<th> Product id</th>
<th> Category Name</th>
<th> Product Name</th>
<th> Product Price</th>
<th> Product Image</th>
<th> Product Description</th>
<th> Product Quantity</th>
<th> Product Made For</th>
<th> Product Starting Age</th>
<th> Product Ending Age</th>
<th> Product status</th>
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
	$sel_query="SELECT * FROM `product_master`  WHERE  `prod_name` LIKE '%".$search."%' order by `prod_createddate` DESC LIMIT ".$start_from.", ".$limit." ";
}else{
	$sel_query="select * from product_master order by prod_createddate DESC LIMIT ".$start_from.", ".$limit.";";
}
	$count=1;
	$result = mysqli_query($conn,$sel_query);
	$totalrec = mysqli_num_rows($result);
	if($totalrec>0){
	while($row = mysqli_fetch_assoc($result)) { ?>
<tr><td align="center"><?php echo $count; ?></td>
<td align="center"><?php echo get_catname ($row["cat_id"],$conn); ?></td> 
<td align="center"><?php echo $row["prod_name"]; ?></td> 
<td align="center"><?php echo $row["prod_price"]; ?></td> 
<td align="center"><?php
if($row["prod_image"]!=''){
	$imgbasepath=SITE_ROOT_URL.'prodimg/'.$row["prod_image"];
	if(file_exists($imgbasepath)){
		$imagepath=SITE_URL.'prodimg/'.$row["prod_image"];
		echo ' <img src="'.$imagepath.'" width="100" height="100">';
	}
}
?></td>
<td align="center"><?php echo $row["prod_desc"]; ?></td>
<td align="center"><?php echo $row["prod_qty"]; ?></td>
<td align="center"><?php echo ($row["prod_cat"] == '1'? 'Men':'Women');?></td>
<td align="center"><?php echo $row["prod_sage"]; ?></td>
<td align="center"><?php echo $row["prod_eage"]; ?></td>
<td align="center"><?php echo ($row["prod_status"]=='1'?'Active':'Deactive'); ?></td>
<td align="center">
<a href="product.php?action=edit&id=<?php echo $row["prod_id"]; ?>">Edit</a>
</td>
<td align="center">
<a href="product.php?action=delete&id=<?php echo $row["prod_id"]; ?>" onclick="return confirm('Are you sure you want to delete??');">Delete</a>
</td>
</tr>
<?php $count++; }} ?>
</tbody>
</table>
<ul class="pagination"> 
      <?php 
      if($search!=''){
      	$recordview = "SELECT COUNT(*) FROM product_master WHERE `prod_name` LIKE '%".$search."%'";   
      }else{
      	$recordview = "SELECT COUNT(*) FROM product_master";   
      }	
        $qryresult = mysqli_query($conn,$recordview);   
        $qryrec = mysqli_fetch_row($qryresult);   
        $total_records = $qryrec[0];   
        $total_pages = ceil($total_records / $limit);   
        $page = "";                         
        for ($i=1; $i<=$total_pages; $i++) { 
      			if($search!=''){
      		$page .= "<li class='active'><a href='product.php?page=".$i."&search=".$search."'>".$i."</a></li>"; 		
      	}else{
      		$page .= "<li class='active'><a href='product.php?page=".$i."'>".$i."</a></li>"; 
      	}
        };   
        echo $page;
        ?> 
      </ul> 
<?php } ?>
<a href="product.php">Back to Product page</a>
</div><br/><br/><br/>
<?php include('footer.php');?>
