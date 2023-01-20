<?php include("header.php");
//setcookie('prodid', '', time() - 3600, '/');
//echo $_COOKIE['prodid_'.$_SESSION['usr_id']];
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
<table>
<tr>
<?php include("left_panel.php");?>
<td widht="80%" align="center" valign="top">
	<table border="0" width="100%" valign="top" align="center">
			<tr><th width="100%">Products</th></tr>
			<tr><td width="100%">
			<table width="100%" border="1" align="center">
				<tr>
				<?php
				$limit =6; 
				if (isset($_GET["page"])) {  
     			$pageno  = $_GET["page"];  
				}else {  
      			$pageno=1;  
				};   
				$start_from = ($pageno-1) * $limit;
				$addquerydata='';
				$prodtitle='';
				$productprice='';
				$qryprodfor='';
				$qryprodage='';
				if($ps!='' && $pe!=''){
					$productprice="and prod_price>=".$ps." and prod_price<=".$pe." "; 
				}
				else if($ps!='')
				{
					$productprice="and prod_price>=".$ps." "; 
				} 
				else if($pe!='')
				{
					$productprice="and prod_price<=".$pe." ";
				}
				if($cat_id!=''){
					$addquerydata.=" and cat_id=".$cat_id."";
				}
				if($title!=''){
					 $prodtitle="and `prod_name` LIKE '%".$title."%' ";
				}
				if($prodfor!=''){
					$qryprodfor="and `prod_cat`=".$prodfor." ";
				}
				if($psage!='' && $peage!=''){
					$qryprodage="and prod_sage>=".$psage." and prod_eage<=".$peage." "; 
				}
				else if($psage!=''){
					$qryprodage="and prod_sage>=".$psage." "; 
				}
				else if($peage!=''){
					$qryprodage="and prod_eage<=".$peage." "; 
				}



			 $prosel="SELECT * FROM `product_master` where prod_status=1  " .$addquerydata." ".$prodtitle." ".$productprice." ".$qryprodfor." ".$qryprodage." LIMIT ".$start_from.",".$limit."" ;
			
			$count=0;
			$proresult = mysqli_query($conn,$prosel);
			$prorec = mysqli_num_rows($proresult);
			if($prorec>0){
			while($row = mysqli_fetch_assoc($proresult)) {
				if($count%3==0 && $count!=0){ echo "</tr><tr>";}
			?>
			<td>
				<?php
				if($row["prod_image"]!=''){
				$imgbasepath=SITE_ROOT_URL.'/prodimg/'.$row["prod_image"];
				if(file_exists($imgbasepath)){
				$imagepath=SITE_URL.'prodimg/'.$row["prod_image"];
				echo ' <img src="'.$imagepath.'" width="200" height="200">';
				}
				}
				?><br><b><a href="productdetail.php?prodid=<?php echo $row["prod_id"];?>"><?php echo $row["prod_name"];?><br/><?php echo $row["prod_price"];?><br/><?php echo $row["prod_cat"] == '1'? 'Men':'Women';?></a><br/>
					<a href="addtocart.php?prodid=<?php echo $row["prod_id"];?>">addtocart</a></b>
		 </td>
			<?php 
			$count++;
			
			} 
		} ?>   
		<?php if($prorec==0){
				echo $error;
			}
			?></tr>
		</table>
	</td></tr>
	<tr><td>
	<ul class="pagination"> 
      <?php
      	 $viewrecord = "SELECT COUNT(*) FROM product_master where prod_status=1 ".$prodtitle." ".$productprice." ".$addquerydata." ".$qryprodfor." ".$qryprodage." ";   
        $qryresult = mysqli_query($conn,$viewrecord);   
        $qryrec = mysqli_fetch_row($qryresult);   
        $total_records = $qryrec[0];   
        $total_pages = ceil($total_records / $limit);   
        $page = ""; 
        $srcdat="";
        $pricese="";
        $ptitle="";
        $pagprodfor="";
        $pageage="";
        if($cat_id!=''){
					$srcdat="&cat=".$cat_id."";
		}
		if($ps!='' && $pe!=''){
					$pricese.="&ps=".$ps."&pe=".$pe." "; 
		} 
		  
		if($title!=''){
					$ptitle="&title=".$title."";
		} 
		if($prodfor!=''){
					$pagprodfor="&prodfor=".$prodfor."";
		}
		if($psage!='' && $peage!=''){
					$pageage.="&psage=".$psage."&peage=".$peage." "; 
		}                       
        for ($i=1; $i<=$total_pages; $i++) { 
      		$page .= "<li class='active'><a href='index.php?page=".$i.$srcdat.$ptitle.$pricese.$pagprodfor.$pageage."'>".$i."</a></li>"; 
      	};   
        echo $page;
       ?> 
      </ul> </td></tr>
  </table></td>
</tr></table>

<?php include("footer.php");?>