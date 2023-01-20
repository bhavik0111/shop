<?php
include('header.php');
?>
<script type="text/javascript">
function retrievedata()
{
  $("#error_cat_id").hide('1000');
  $("#error_prodfor").hide('1000');
  $("#error_search").hide('1000');
  $("#error_prod_price").hide('1000');
  var isFormValid = true;
  var catid=$("#cat_id").val();
  var prodfor=$("#prodfor").val();
  var search=$("#search").val();
  var prod_price=$("#prod_price").val();
  if(catid==''){
  	$("#error_cat_id").show('1000');
  	$("#error_cat_id").html('Please select Category.');
    }
  if(prodfor==''){
    $("#error_prodfor").show('1000');
    $("#error_prodfor").html('Please select Product made for.');
    }
   if(search==''){
    $("#error_search").show('1000');
    $("#error_search").html('Please enter product name that u want to search.');
    }
   if(prod_price==''){
    $("#error_prod_price").show('1000');
    $("#error_prod_price").html('Please enter product price that u want to search.');
    }
  if(catid!='' && prodfor!='' && search!='' && prod_price!='' ){
	  $.ajax({
	    type: "GET",
	    url: 'getproductlist.php',
	    data: {'catid': catid, 'prodfor': prodfor, 'search': search, 'prod_price': prod_price},
	    success: function(data){
	        $("#ajax-content").html(data);
         // alert(data); 
	    }
		});
	}//else{
		//alert('Please enter any one field......');
    
	//} 
	return false;
}

 /* if(catid=='' && prodfor=='' && search=='' && prod_price=='' ){
    alert('Please enter any one field......');
    isFormValid=false;
  }
  return isFormValid;
}*/

</script>
<form action="catjquery.php" method="post" onsubmit="return retrievedata();">
<table width="100%" border="1" align="center">
<tr><td width="50%" align="center"><b>Select Category name:</b></td>
<td width="50%"><select name="cat_id" id="cat_id">
<option value="" selected="selected">Select Category</option>
<?php
$getcat = "SELECT cat_id,cat_name FROM category_master where cat_status=1";
$catrow = mysqli_query($conn,$getcat);
while($resultcat = mysqli_fetch_assoc($catrow) ) :  ?>
<option value="<?php echo $resultcat['cat_id'];?>"><?php echo $resultcat['cat_name'];?>
</option>
<?php endwhile; ?></select>
<span class="error" style="color: red;" id="error_cat_id"></span>
</td></tr>
<tr><td width="50%" align="center"><b>Product for:</b></td>
<td width="50%"><select name="prodfor" id="prodfor">
<option value="" selected="selected">Select For</option>
<option value="1">Men</option>
<option value="0">Women</option>
</select>
<span class="error" style="color: red;" id="error_prodfor"></span>
</td></tr>
<tr><td align="center"><b>Product name:</b></td><td><input type="text" name="search" id="search">
<span class="error" style="color: red;" id="error_search"></span>
</td></tr>
<tr><td align="center"><b>Product price:</b></td><td><input type="text" name="prod_price" id="prod_price">
<span class="error" style="color: red;" id="error_prod_price"></span>
</td></tr>
<tr><td colspan="2" align="center"><input type="submit" name="btnsubmit" value="Submit" id="btnsubmit"></td></tr>

</table>
</form>
<br>
  <div id="ajax-content"></div>
<br/>
<?php include('footer.php'); ?>