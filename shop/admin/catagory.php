<?php
include('header.php');

 $require="";
 $dataexist="";
 $cat_id="";
 $cat_name="";
 $cat_desc="";
 $cat_status="";
 if(isset($_GET['action']) && $_GET['action']=='delete'){
 	if(isset($_GET['id']) && $_GET['id']!='')
 		{
 		$delete="DELETE FROM category_master where cat_id='".$_GET['id']."'";
		$resdel = mysqli_query( $conn, $delete );
		header("Location:".SITE_URL."admin/catagory.php?k=delete"); 
		exit;
        }
	else
	{
		header("Location:".SITE_URL."admin/catagory.php"); 
		exit;
	} 
    }
 
 if(isset($_GET['action']) && $_GET['action']=='edit'){
 	if(isset($_GET['id']) && $_GET['id']!=''){
 		$cat_id=$_GET['id'];
		$query = "select * from category_master where cat_id='".$_GET['id']."' "; 
		$result = mysqli_query($conn, $query);
		$row = mysqli_fetch_assoc($result);
 		$cat_name=$row['cat_name'];
 		$cat_desc=$row['cat_desc'];
 		$cat_status=$row['cat_status'];	

 	}else{
 		header("Location:".SITE_URL."admin/catagory.php"); 
 		exit;
 	}
 }
if(isset($_POST['submit']) && ($_POST['submit']=='Add' || $_POST['submit']=='Edit')){
	$cat_name=$_POST['cat_name'];	
	$cat_desc=$_POST['cat_desc'];
	if(isset($_POST['cat_status'])){
		$cat_status=$_POST['cat_status'];
	}
	/* if($cat_name==''){
		$require="All fields are required";	
	}
	else if($cat_desc==''){
		$require="All fields are required";	
	}
	else if($cat_status==''){
		$require="All fields are required";	
	}
	else{*/

	if($cat_id!=''){
			$query = "select * from category_master where cat_name='".$cat_name."' and cat_id!='".$cat_id."'"; 
		}else{
			$query = "select * from category_master where cat_name='".$cat_name."'"; 
		}
		$result = mysqli_query($conn, $query);
		$total = mysqli_num_rows($result);
		if($total>0){
			$dataexist="Category is already Exists";
		}else{
			if($_POST['submit']=='Add'){
				$sql = "INSERT INTO category_master (`cat_name`,`cat_desc`,`cat_status`) VALUES ('".$cat_name."','".$cat_desc."','".$cat_status."')";
			mysqli_query($conn, $sql);
			header("Location:".SITE_URL."admin/catagory.php?k=add"); 
				exit;
			}
		
			else {
	     		$require="Error: " . $sql . "<br>" . mysqli_error($conn);
			}
		
		if($_POST['submit']=='Edit'){
			$qryupd = "UPDATE category_master set `cat_name`='".$cat_name."',`cat_desc`='".$cat_desc."',`cat_status`='".$cat_status."' where `cat_id`='".$cat_id."'" ;
			mysqli_query($conn, $qryupd);
			header("Location:".SITE_URL."admin/catagory.php?k=edit"); 
				exit;
			} 
			else {
	     		$require="Error: " . $qryupd . "<br>" . mysqli_error($conn);
			}
		}
	//}
	
}
?>
<script type="text/javascript">
function validform()
{
	$("#error_cat_name").hide('1000');
	$("#error_cat_desc").hide('1000');
	$("#error_cat_status").hide('1000');
	//$("#error_cat_status1").hide('1000');

	var isFormValid = true;
	var cat_name=$("#cat_name").val();
	var cat_desc=$("#cat_desc").val();
	var cat_status=$("#cat_status").prop("checked");
	var cat_status1=$("#cat_status1").prop("checked");
	
	if(cat_name==''){
  		$("#error_cat_name").show('1000');
  		$("#error_cat_name").html('Please Enter Category.');
  		isFormValid=false;
    }
    if(cat_desc==''){
		$("#error_cat_desc").show('1000');
  		$("#error_cat_desc").html('Please Enter Category Description.');
  		isFormValid=false;
	}
	if(cat_status==false && cat_status1==false){
		$("#error_cat_status").show('1000');
  		$("#error_cat_status").html('Please select catagory status.');
  		isFormValid=false;
	}
	
	
	/*var isFormValid = true;
	var cat_name=document.getElementById("cat_name").value;
	var cat_desc=document.getElementById("cat_desc").value;
	var cat_status=document.getElementById("cat_status").checked;
	var cat_status1=document.getElementById("cat_status1").checked;
	if(cat_name==''){
		alert('Please enter Category name.');
		document.getElementById("cat_name").focus();
		isFormValid=false;
	}
	else if(cat_desc==''){
		alert('Please enter Category description.');
		document.getElementById("cat_desc").focus();
		isFormValid=false;
	}
	else if(cat_status==false && cat_status1==false ){
		alert('Please select status.');
		document.getElementById("cat_status").focus();
		isFormValid=false;
	}*/
	return isFormValid;
}
</script>
<div class="form">
<?php
if(isset($_GET['action']) && ($_GET['action']=='add' || $_GET['action']=='edit')){?>
<?php if($_GET['action']=='edit' && $_GET['id']!=''){?><h1>Edit Category</h1>
<form action="catagory.php?action=edit&id=<?php echo $_GET['id'];?>" method="post" onsubmit="return validform()" >
<?php }else{?><h1>Add Category</h1>
<form action="catagory.php?action=add" method="post" onsubmit="return validform()">
<?php }?>
<table>
<tr><td colspan="2" style="color: red;"><?php echo $require;?><?php echo $dataexist;?></td></tr>
<tr><td><b>Enter Category name:</b></td><td><input type="text" id="cat_name" name="cat_name" value="<?php echo $cat_name;?>">
<span class="error" style="color: red;" id="error_cat_name"></span>
</td></tr>
<tr><td><b>Enter Category description:</b></td><td><textarea  id="cat_desc" name="cat_desc" row="5" col="200" ><?php echo $cat_desc;?></textarea>
<span class="error" style="color: red;" id="error_cat_desc"></span>
</td></tr>
<tr><td><b>Enter Category status:</b></td><td><input type="radio"  id="cat_status" name="cat_status" <?php if($cat_status=='1'){ echo 'checked="checked"'; }?> value="1">Active<input type="radio"   id="cat_status1" name="cat_status" value="0" <?php if($cat_status=='0'){ echo 'checked="checked"'; }?> >Deactive
<span class="error" style="color: red;" id="error_cat_status"></span>
</td></tr>
<tr><td colspan="2"><center><input type="submit" name="submit" <?php if($_GET['action']=='edit'){ echo 'value="Edit"'; }else { echo 'value="Add"'; }?> ></center></td></tr>
</table>
</form>
<?php }else{?>
<h2>View Category</h2>
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
<a href="catagory.php?action=add">ADD</a>
<form action="catagory.php?action=search" method="get"><input type="text" name="search" value="<?php echo $search ;?>"><input type="submit" name="button" value="Search"></form><br>
<table width="100%" border="1">
<thead>
<tr>
<th> Category id</th>
<th> Category Name</th>
<th> Category Description</th>
<th> Category status</th>
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
	$sel_query="SELECT * FROM `category_master` WHERE `cat_name` LIKE '%".$search."%' order by `cat_createddate` DESC LIMIT ".$start_from.", ".$limit." ";
}else{
	$sel_query="select * from category_master order by cat_createddate DESC LIMIT ".$start_from.", ".$limit.";";
}
	$count=1;

	$result = mysqli_query($conn,$sel_query);
	$totalrec = mysqli_num_rows($result);
	if($totalrec>0){
	while($row = mysqli_fetch_assoc($result)) { ?>
<tr><td align="center"><?php echo $count; ?></td>
<td align="center"><?php echo $row["cat_name"]; ?></td> 
<td align="center"><?php echo $row["cat_desc"]; ?></td>
<td align="center"><?php echo ($row["cat_status"]=='1'?'Active':'Deactive'); ?></td>
<td align="center">
<a href="catagory.php?action=edit&id=<?php echo $row["cat_id"]; ?>">Edit</a>
</td>
<td align="center">
<a href="catagory.php?action=delete&id=<?php echo $row["cat_id"]; ?>" onclick="return confirm('Are you sure you want to delete??');">Delete</a>
</td>
</tr>
<?php $count++; }} ?>
</tbody>
</table>
<ul class="pagination"> 
      <?php 
      if($search!=''){
      	$viewrecord = "SELECT COUNT(*) FROM category_master WHERE `cat_name` LIKE '%".$search."%'";   
      }else{
      	$viewrecord = "SELECT COUNT(*) FROM category_master";   
      }	
        $qryresult = mysqli_query($conn,$viewrecord);   
        $qryrec = mysqli_fetch_row($qryresult);   
        $total_records = $qryrec[0];   
        $total_pages = ceil($total_records / $limit);   
        $page = "";                         
        for ($i=1; $i<=$total_pages; $i++) { 
      			if($search!=''){
      		$page .= "<li class='active'><a href='catagory.php?page=".$i."&search=".$search."'>".$i."</a></li>"; 		
      	}else{
      		$page .= "<li class='active'><a href='catagory.php?page=".$i."'>".$i."</a></li>"; 
      	}
              
            };   
        echo $page;
        

      ?> 
      </ul> 

<?php } ?>
<a href="catagory.php">Back to Category page</a>
</div><br/><br/><br/>
<?php include('footer.php');
?>
