<?php
include('header.php');
?>
<script type="text/javascript">
    function showCustomer() {
  var xhttp;
  //catid=
  //forprod=
  var catid=document.getElementById("cat_id").value;
  var prodfor=document.getElementById("prodfor").value;
  var search=document.getElementById("search").value;
  var prod_price=document.getElementById("prod_price").value;
  var paramenters='';
  if (catid != "" && prodfor!='' && search != "" && prod_price!="") {
   	paramenters='?catid='+catid+'&prodfor='+prodfor+'&search='+search+'&prod_price='+prod_price;
  }
  else if (catid != "" && prodfor == "" && search != "" && prod_price!="") {
   		paramenters='?catid='+catid+'&search='+search+'&prod_price='+prod_price;
  	}
  	else if (catid == "" && prodfor != "" && search != "" && prod_price!="") {
   		paramenters='?prodfor='+prodfor+'&search='+search+'&prod_price='+prod_price;
  	}	
    else if(catid == "" && prodfor == "" && search != "" && prod_price!=""){
      paramenters='?search='+search+'&prod_price='+prod_price;
    }
    else if(catid != "" && prodfor == "" && search == "" && prod_price!="" ){
      paramenters='?catid='+catid+'&prod_price='+prod_price;
    }
    else if(catid == "" && prodfor != "" && search == "" && prod_price!=""){
      paramenters='?prodfor='+prodfor+'&prod_price='+prod_price;
    }
    else if(catid != "" && prodfor != "" && search == "" && prod_price!=""){
      paramenters='?catid='+catid+'&prodfor='+prodfor+'&prod_price='+prod_price;
    }
    else if (catid != "" && prodfor!='' && search != "" && prod_price=="") {
    paramenters='?catid='+catid+'&prodfor='+prodfor+'&search='+search;
    }
    else if (catid != "" && prodfor == "" && search != "" && prod_price=="") {
      paramenters='?catid='+catid+'&search='+search;
    }
    else if (catid == "" && prodfor != "" && search != "" && prod_price=="") {
      paramenters='?prodfor='+prodfor+'&search='+search;
    } 
    else if(catid == "" && prodfor == "" && search != "" && prod_price==""){
      paramenters='?search='+search;
    }
    else if(catid != "" && prodfor == "" && search == "" && prod_price=="" ){
      paramenters='?catid='+catid;
    }
    else if(catid == "" && prodfor != "" && search == "" && prod_price==""){
      paramenters='?prodfor='+prodfor;
    }
    else if(catid != "" && prodfor != "" && search == "" && prod_price==""){
      paramenters='?catid='+catid+'&prodfor='+prodfor;
    }
    else if (catid == "" && prodfor=='' && search == "" && prod_price!="") {
    paramenters='?prod_price='+prod_price;
  }
  //alert(paramenters);

  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {

    if (this.readyState == 4 && this.status == 200) {
    document.getElementById("ajax-content").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", "getproductlist.php"+paramenters, true);
  xhttp.send();
}

	

</script>

<table width="100%" border="1" align="center">
<tr><td width="50%" align="center"><b>Select Category name:</b></td>
	<td width="50%"><select name="cat_id" id="cat_id" onchange="showCustomer()">
    <option value="" selected="selected">Select Category</option>
    <?php
    $getcat = "SELECT cat_id,cat_name FROM category_master where cat_status=1";
    $catrow = mysqli_query($conn,$getcat);
    while($resultcat = mysqli_fetch_assoc($catrow) ) :  ?>
    <option value="<?php echo $resultcat['cat_id'];?>"><?php echo $resultcat['cat_name'];?>
    </option>
	  <?php endwhile; ?>
	</select>
</td></tr>
<tr><td width="50%" align="center"><b>Product for:</b></td>
      <td width="50%"><select name="prodfor" id="prodfor" onchange="showCustomer()">
         <option value="" selected="selected">Select For</option>
        <option value="1">Men</option>
        <option value="0">Women</option>
      </select></td></tr>
      <tr><td align="center"><b>Product name:</b></td><td><input type="text" name="search" id="search" onkeyup="showCustomer()"></td></tr>
      <tr><td align="center"><b>Product price:</b></td><td><input type="text" name="prod_price" id="prod_price" onkeyup="showCustomer()"></td></tr>
</table>
	
  <div id="ajax-content"></div>

<br/>
<?php include('footer.php'); ?>