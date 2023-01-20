<?php
include('header.php');?>
<table width="100%"><tr>
<?php include('profile_left.php'); ?>
<td widht="80%" align="center" valign="top">
<table width="100%" border="1"><tr><td>
<?php
if(isset($_SESSION['usr_email']) && isset($_SESSION['usr_id']))
{ 
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
$query = "select * from user_master where usr_id ='".$_SESSION['usr_id']."' ";
		//print_r($query);
		//exit; 
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
 $usr_disname=$row['usr_disname'];
 $usr_img=$row['usr_img'];
 $usr_name=$row['usr_name'];
 $usr_status=$row['usr_status'];
 $usr_age=$row['usr_age'];
if(isset($_POST['submit']) && $_POST['submit']=='Save'){
	$usr_disname=$_POST['usr_disname'];
	$usr_img=$_FILES['usr_img'];	
	$usr_name=$_POST['usr_name'];	
	$usr_age=$_POST['usr_age'];	
	//print_r($_POST);
	//print_r($_FILES);
	if($usr_id!=''){
			$query = "select * from user_master where usr_name='".$usr_name."' and usr_email='".$usr_email."' and usr_id!='".$_SESSION['usr_id']."'"; 
		}
		$result = mysqli_query($conn, $query);
		$total = mysqli_num_rows($result);
		if($total>0){
			$dataexist="User is already Exists";
		}else{
		
		if($_POST['submit']=='Save'){
			$qryupd = "UPDATE user_master set `usr_disname`='".$usr_disname."',`usr_name`='".$usr_name."',`usr_age`='".$usr_age."' where `usr_id`='".$_SESSION['usr_id']."'" ;
			//print_r($qryupd);
			//exit;
			mysqli_query($conn, $qryupd);
			  if($usr_id!='' && $_FILES['usr_img']['name']!=''){
					$imgbasepath=$_SERVER['DOCUMENT_ROOT'].'/test/khyati/shop/userimg/';
					$storeimagename=$_FILES['usr_img']['name'];
					
					// get file name 
					$querygetfilename = "select usr_img from user_master where usr_id='".$_SESSION['usr_id']."'"; 
					$resultfilename = mysqli_query($conn, $querygetfilename);
					$rowfilename = mysqli_fetch_assoc($resultfilename);
 					$deleprodimage=$rowfilename['usr_img'];
 					

					if($deleprodimage!=''){
 						if(file_exists($imgbasepath.$deleprodimage)){
 							unlink($imgbasepath.$deleprodimage);
 						}
 					}
					move_uploaded_file($_FILES['usr_img']['tmp_name'], $imgbasepath.$storeimagename);
					$qryupdate = "UPDATE user_master set `usr_img`='".$storeimagename."' where `usr_id`='".$_SESSION['usr_id']."'" ;
					//print_r($qryupdate);
					//exit;
					mysqli_query($conn, $qryupdate);
				}
			header("Location:".SITE_URL."userprofile.php?k=save"); 
				exit;
			} 
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
<?php if(isset($_GET['k']) && $_GET['k']!=''){
	if($_GET['k']=='save'){
		echo '<font color="green"><h5>Record has been updated.</h5></font>';		
	} }?>
<form action="userprofile.php" method="post" onsubmit="return validform()" enctype="multipart/form-data">
<table>
<tr><td colspan="2" style="color: red;"><?php echo $require;?><?php echo $dataexist;?></td></tr>
<tr><td><b>Enter User Display name:</b></td><td><input type="text" id="usr_disname" name="usr_disname" value="<?php echo $usr_disname;?>"></td></tr>

<tr><td><b>  Select image to upload:</b></td><td><input type="file" id="usr_img" name="usr_img"></td></tr>
<tr><td><b>Image:</b></td><td>
	<?php 
	if($_SESSION['usr_id']!=''){
	$getimg="select usr_img from user_master where usr_id='".$_SESSION['usr_id']."'";
	//print_r($getimg);
	//exit;
	$resultimg=mysqli_query($conn,$getimg);
	$viewimg=mysqli_fetch_assoc($resultimg);
	$imagepath=SITE_URL.'userimg/'.$viewimg["usr_img"];
	echo ' <img src="'.$imagepath.'" width="100" height="100">';
	}?>
	<input type="hidden" id="hidimg" name="hidimg"
	 value="<?php echo $usr_img;?>">
</td></tr>

<tr><td><b>Enter User name:</b></td><td><input type="text" id="usr_name" name="usr_name" value="<?php echo $usr_name;?>"></td></tr>
<tr><td><b>Select User Age:</b></td>
<td><select name="usr_age" id ="usr_age" >
				<?php for($k=1;$k<=50;$k++)
				{
					?>
					<option value="<?php echo $k;?>" <?php echo ($usr_age==$k?'selected="selected"':'');?> ><?php echo $k;?></option>
					<?php 
				}
				?>
</select></td></tr>
<tr><td colspan="2" align="center"><input type="submit" name="submit" value="Save"></td></tr>
</table>
</form>
</td></tr></table></td></tr></table>
<?php include('footer.php'); ?>