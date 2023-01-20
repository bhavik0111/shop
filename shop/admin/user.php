 <?php
include('header.php');

 $require="";
 $dataexist="";
 $usr_id="";
 $usr_disname="";
 $usr_img="";
 $usr_name="";
 $usr_email="";
 $usr_pass="";
 $usr_status="";
 $usr_age="";
 if(isset($_GET['action']) && $_GET['action']=='delete'){
 	if(isset($_GET['id']) && $_GET['id']!='')
 		{

 		$imgbasepath=SITE_ROOT_URL.'userimg/';
		$imgget = "select usr_img from user_master where usr_id='".$_GET['id']."'";
		$imgresult = mysqli_query($conn, $imgget);
		$rowimg = mysqli_fetch_assoc($imgresult);
 		$delimg=$imgbasepath.$rowimg['usr_img'];

 		if($delimg!=''){
 			if(file_exists($delimg)){
 				unlink($delimg);
 			}
 		}
 		$delete="DELETE FROM user_master where usr_id='".$_GET['id']."'";
		$resdel = mysqli_query( $conn, $delete );
		header("Location:".SITE_URL."admin/user.php?k=delete"); 
		exit;
        }
	else
	{
		header("Location:".SITE_URL."admin/user.php"); 
		exit;
	} 
    }
 
 if(isset($_GET['action']) && $_GET['action']=='edit'){
 	if(isset($_GET['id']) && $_GET['id']!=''){
 		$usr_id=$_GET['id'];
		$query = "select * from user_master where usr_id='".$_GET['id']."' "; 
		$result = mysqli_query($conn, $query);
		$row = mysqli_fetch_assoc($result);
 		$usr_disname=$row['usr_disname'];
 		$usr_img=$row['usr_img'];
 		$usr_name=$row['usr_name'];
 		$usr_email=$row['usr_email'];
 		$usr_pass=$row['usr_pass'];
 		$usr_status=$row['usr_status'];
 		$usr_age=$row['usr_age'];
 		
 	}else{
 		header("Location:".SITE_URL."admin/user.php"); 
 		exit;
 	}
 }
if(isset($_POST['submit']) && ($_POST['submit']=='Add' || $_POST['submit']=='Edit')){
	$usr_disname=$_POST['usr_disname'];
	$usr_img=$_FILES['usr_img'];	
	$usr_name=$_POST['usr_name'];	
	$usr_email=$_POST['usr_email'];	
	$usr_pass=$_POST['usr_pass'];	
	$usr_age=$_POST['usr_age'];	
	//print_r($_POST);
	//print_r($_FILES);

	if(isset($_POST['usr_status'])){
		$usr_status=$_POST['usr_status'];
	}
	if($usr_id!=''){
			$query = "select * from user_master where usr_name='".$usr_name."' and usr_email='".$usr_email."' and usr_id!='".$usr_id."'"; 
		}else{
			$query = "select * from user_master where usr_name='".$usr_name."'"; 
		}
		$result = mysqli_query($conn, $query);
		$total = mysqli_num_rows($result);
		if($total>0){
			$dataexist="User is already Exists";
		}else{
			if($_POST['submit']=='Add'){

				$sql = "INSERT INTO `user_master` (`usr_disname`, `usr_name`, `usr_email`, `usr_pass`,`usr_age`, `usr_status` ,`usr_role`) VALUES ('".$usr_disname."','".$usr_name."','".$usr_email."','".$usr_pass."','".$usr_age."','".$usr_status."' ,'". 2 ."' )";
				$returnsql=mysqli_query($conn, $sql);
				$usr_id=mysqli_insert_id($conn);
				if($usr_id!='' && $_FILES['usr_img']!=''){
					$imgbasepath=SITE_ROOT_URL."userimg/";
					$storeimagename=$_FILES['usr_img']['name'];
					move_uploaded_file($_FILES['usr_img']['tmp_name'], $imgbasepath.$storeimagename);
					$qryupd = "UPDATE user_master set `usr_img`='".$storeimagename."' where `usr_id`='".$usr_id."' " ;
					mysqli_query($conn, $qryupd);
					
				}
				
			header("Location:".SITE_URL."admin/user.php?k=add"); 
				exit;
			}
		
		if($_POST['submit']=='Edit'){
			$qryupd = "UPDATE user_master set `usr_disname`='".$usr_disname."',`usr_name`='".$usr_name."',`usr_email`='".$usr_email."' ,`usr_pass`='".$usr_pass."' ,`usr_age`='".$usr_age."',`usr_status`='".$usr_status."' where `usr_id`='".$usr_id."'" ;
			//print_r($qryupd);
			//exit;
			  if($usr_id!='' && $_FILES['usr_img']['name']!=''){
					$imgbasepath=SITE_ROOT_URL.'userimg/';
					$storeimagename=$_FILES['usr_img']['name'];
					
					// get file name 
					$querygetfilename = "select usr_img from user_master where usr_id='".$usr_id."'"; 
					$resultfilename = mysqli_query($conn, $querygetfilename);
					$rowfilename = mysqli_fetch_assoc($resultfilename);
 					$deleprodimage=$rowfilename['usr_img'];
 					

					if($deleprodimage!=''){
 						if(file_exists($imgbasepath.$deleprodimage)){
 							unlink($imgbasepath.$deleprodimage);
 						}
 					}

						
					move_uploaded_file($_FILES['usr_img']['tmp_name'], $imgbasepath.$storeimagename);
					$qryupd = "UPDATE user_master set `usr_img`='".$storeimagename."' where `usr_id`='".$usr_id."'" ;
					mysqli_query($conn, $qryupd);
				}
				header("Location:".SITE_URL."admin/user.php?k=edit"); 
				exit;
			} 
			else {
	     		$require="Error: " . $qryupd . "<br>" . mysqli_error($conn);
			}
		}
	}
	

?>
<script language="javascript" type="text/javascript">
function validform()
{
	var isFormValid = true;
	var usr_disname=document.getElementById("usr_disname").value;
	var usr_img=document.getElementById("usr_img").value;
	var usr_name=document.getElementById("usr_name").value;
	var usr_email=document.getElementById("usr_email").value;
	var usr_pass=document.getElementById("usr_pass").value;
	var usr_age=document.getElementById("usr_age").value;
	var usr_status=document.getElementById("usr_status").checked;
	var usr_status1=document.getElementById("usr_status1").checked;
	if(usr_disname==''){
		alert('Please enter user  display name.');
		document.getElementById("usr_disname").focus();
		isFormValid=false;
	}
	else if(usr_img=='' && hidimg==''){
		alert('Please select user image.');
		document.getElementById("usr_img").focus();
		isFormValid=false;
	}
	else if(usr_name==''){
		alert('Please enter user name.');
		document.getElementById("usr_name").focus();
		isFormValid=false;
	}
	else if(usr_email==''){

		alert('Please enter email .');
		document.getElementById("usr_email").focus();
		isFormValid=false;
	}
	else if(usr_pass==''){
		alert('Please enter password.');
		document.getElementById("usr_pass").focus();
		isFormValid=false;
	}
	else if(usr_age==''){
		alert('Please Select Age.');
		document.getElementById("usr_age").focus();
		isFormValid=false;
	}
	else if(usr_status==false && usr_status1==false ){
		alert('Please select status.');
		document.getElementById("usr_status1").focus();
		isFormValid=false;
	}
	else {
		if(usr_name!=''){
			if(isName(usr_name)==false){
			alert('Please enter valid name .');
			document.getElementById("usr_name").focus();
			isFormValid=false;
			}
		}
		if(usr_email!='' && isFormValid==true){
			if(isEmail(usr_email)==false){
				alert('Please enter valid email .');
				document.getElementById("usr_email").focus();
				isFormValid=false;
			}
		}

 		if(usr_pass!='' && isFormValid==true){
			if(isPassword(usr_pass)==false){
				alert('Please enter minimum 6 character and 1 number 1 special character and alphabates for valid password .');
				document.getElementById("usr_pass").focus();
				isFormValid=false;
			}
		}
	}
	return isFormValid;
}  

function isName(usr_name){
        var validateName = function(usr_name) {
      	return  /^[A-Za-z]+$/.test(usr_name);
    	}
    return validateName(usr_name); // False
} 

function isEmail(usr_email){
         var validateEmail = function(usr_email) {
      	return  /^\S+@\S+\.\S+$/.test(usr_email);
    	}
    return validateEmail(usr_email); // False
} 
function isPassword(usr_pass){
    var validatePass = function(usr_pass) {
    return /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{6,16}$/.test(usr_pass);
    }
   return validatePass(usr_pass); // False

}

</script>
<div class="form">
<?php
if(isset($_GET['action']) && ($_GET['action']=='add' || $_GET['action']=='edit')){?>
<?php if($_GET['action']=='edit' && $_GET['id']!=''){?><h1>Edit User</h1>
<form action="user.php?action=edit&id=<?php echo $_GET['id'];?>" method="post" onsubmit="return validform()" enctype="multipart/form-data">
<?php }else{?><h1>Add User</h1>
<form action="user.php?action=add" method="post" onsubmit="return validform()" enctype="multipart/form-data">
<?php }?>
<table>
<tr><td colspan="2" style="color: red;"><?php echo $require;?><?php echo $dataexist;?></td></tr>
<tr><td><b>Enter User Display name:</b></td><td><input type="text" id="usr_disname" name="usr_disname" value="<?php echo $usr_disname;?>"></td></tr>

<tr><td><b>  Select image to upload:</b></td><td><input type="file" id="usr_img" name="usr_img"></td></tr>
<tr><td><b>Image:</b></td><td>
	<?php 
	if($usr_id!=''){
	$getimg="select usr_img from user_master where usr_id='".$usr_id."'";
	$resultimg=mysqli_query($conn,$getimg);
	$viewimg=mysqli_fetch_assoc($resultimg);
	$imagepath=SITE_URL.'userimg/'.$viewimg["usr_img"];
	echo ' <img src="'.$imagepath.'" width="100" height="100">';
	}?>
	<input type="hidden" id="hidimg" name="hidimg"
	 value="<?php echo $usr_img;?>">
</td></tr>

<tr><td><b>Enter User name:</b></td><td><input type="text" id="usr_name" name="usr_name" value="<?php echo $usr_name;?>"></td></tr>
<tr><td><b>Enter User Email id:</b></td><td><input type="text" id="usr_email" name="usr_email"  value="<?php echo $usr_email;?>"></td></tr>
<tr><td><b>Enter User Password:</b></td><td><input type="password" id="usr_pass" name="usr_pass" value="<?php echo $usr_pass;?>"></td></tr>
<tr><td><b>Select User Age:</b></td>
<td><select name="usr_age" id ="usr_age" >
<?php
    for ($usr_age=1; $usr_age<=50; $usr_age++)
    {
        ?>
            <option value="<?php echo $usr_age;?>"><?php echo $usr_age;?></option>
        <?php
    }	
?>
</select></td></tr>
<tr><td><b>Enter User status:</b></td><td><input type="radio"  id="usr_status" name="usr_status" <?php if($usr_status=='1'){ echo 'checked="checked"'; }?> value="1">Active<input type="radio"   id="usr_status1" name="usr_status" value="0" <?php if($usr_status=='0'){ echo 'checked="checked"'; }?> >Deactive</td></tr>
<tr><td colspan="2"><center><input type="submit" name="submit" <?php if($_GET['action']=='edit'){ echo 'value="Edit"'; }else { echo 'value="Add"'; }?> ></center></td></tr>
</table>
</form>
<?php }else{?>
<h2>View User</h2>
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
<a href="user.php?action=add">ADD</a>
<form action="user.php?action=search" method="get"><input type="text" name="search" value="<?php echo $search ;?>"><input type="submit" name="button" value="Search"></form><br>
<table width="100%" border="1">
<thead>
<tr>
<th> User id</th>
<th> User Display Name</th>
<th> User Profile Photo</th>
<th> User Name</th>
<th> User Email id</th>
<th> User Age</th>
<th> User status</th>
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
	$sel_query="SELECT * FROM `user_master` WHERE `usr_role` = 2 and `usr_name` LIKE '%".$search."%' order by `usr_createddate` DESC LIMIT ".$start_from.", ".$limit." ";
}else{
	$sel_query="select * from user_master where `usr_role` = 2 order by usr_createddate DESC LIMIT ".$start_from.", ".$limit.";";
}
	$count=1;

	$result = mysqli_query($conn,$sel_query);
	$totalrec = mysqli_num_rows($result);
	if($totalrec>0){
	while($row = mysqli_fetch_assoc($result)) { ?>
<tr><td align="center"><?php echo $count; ?></td>
<td align="center"><?php echo $row["usr_disname"]; ?></td>

<td align="center"><?php
if($row["usr_img"]!=''){
	$imgbasepath=SITE_ROOT_URL.'userimg/'.$row["usr_img"];
	if(file_exists($imgbasepath)){
		$imagepath=SITE_URL.'userimg/'.$row["usr_img"];
		echo ' <img src="'.$imagepath.'" width="100" height="100">';
	}
}
?></td>

<td align="center"><?php echo $row["usr_name"]; ?></td>
<td align="center"><?php echo $row["usr_email"]; ?></td>
<td align="center"><?php echo $row["usr_age"]; ?></td>
<td align="center"><?php echo ($row["usr_status"]=='1'?'Active':'Deactive'); ?></td>
<td align="center">
<a href="user.php?action=edit&id=<?php echo $row["usr_id"]; ?>">Edit</a>
</td>
<td align="center">
<a href="user.php?action=delete&id=<?php echo $row["usr_id"]; ?>" onclick="return confirm('Are you sure you want to delete??');">Delete</a>
</td>
</tr>
<?php $count++; }} ?>
</tbody>
</table>
<ul class="pagination"> 
      <?php 
      if($search!=''){
      	$viewrecord = "SELECT COUNT(*) FROM user_master WHERE `usr_name` LIKE '%".$search."%'";   
      }else{
      	$viewrecord = "SELECT COUNT(*) FROM user_master";   
      }	
        $qryresult = mysqli_query($conn,$viewrecord);   
        $qryrec = mysqli_fetch_row($qryresult);   
        $total_records = $qryrec[0];   
        $total_pages = ceil($total_records / $limit);   
        $page = "";                         
        for ($i=1; $i<=$total_pages; $i++) { 
      			if($search!=''){
      		$page .= "<li class='active'><a href='user.php?page=".$i."&search=".$search."'>".$i."</a></li>"; 		
      	}else{
      		$page .= "<li class='active'><a href='user.php?page=".$i."'>".$i."</a></li>"; 
      	}
              
            };   
        echo $page;
        

      ?> 
      </ul> 

<?php } ?>
<a href="user.php">Back to User page</a>
</div><br/><br/><br/>
<?php include('footer.php'); ?>