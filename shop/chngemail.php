<?php
include('header.php');?>
<table width="100%"><tr>
<?php include('profile_left.php'); ?>
<td widht="80%" align="center" valign="top">
<table width="100%" border="1"><tr><td>
<?php
if(isset($_SESSION['usr_email']) && isset($_SESSION['usr_id'])){
	$usr_email="";
$usr_code="";
$usr_id="";
if(isset($_POST['btnsubmit']) && $_POST['btnsubmit']=='Submit'){
	$usr_id=$_SESSION['usr_id'];
	$usr_email=$_POST['usr_email'];
	$random_hash = substr(md5(uniqid(rand(), true)), 16, 16);
	if($_POST['btnsubmit']=='Submit'){
	$query="INSERT INTO `verify_email` (`usr_id`,`usr_email`,`usr_code`) VALUES ('".$usr_id."','".$usr_email."','".$random_hash ."')";
	if(mysqli_query($conn, $query)){
	$selectusrname="select `usr_disname` from `user_master` where `usr_id`='".$usr_id."' ";
	$resultusrname=mysqli_query($conn,$selectusrname);
	$row=mysqli_fetch_assoc($resultusrname);
	$username=$row['usr_disname'];
	$to=$usr_email;
	$subject ="For verify email - Khyati Shop";
	$txt = "Hi,";
	$txt.=$username;
	$txt .= "<br/><br/>Please click on below link for verify your email...<br/><br/>";
	$txt .= '<a href="'.SITE_URL.'verify.php?code='.$random_hash.' ">Verify</a>';
	$txt .= "<br/><br/>Thanks, Admin";
	$headers = "Content-type:text/html;charset=UTF-8" . "\r\n";
	$headers .= "From: Admin <info@gujjucoders.com>" . "\r\n" .
	"CC:khyatij.gc@gmail.com";
	mail($to,$subject,$txt,$headers);
	header("Location:".SITE_URL."chngemail.php?k=chngemail");
	exit;
}
}
}
}
?>
<script type="text/javascript" language="javascript">
function validform()
{
	var isFormValid = true;
	var usr_email=document.getElementById("usr_email").value;
	if(usr_email==''){

		alert('Please enter email .');
		document.getElementById("usr_email").focus();
		isFormValid=false;
	}
	else {
		if(usr_email!='' && isFormValid==true){
			if(isEmail(usr_email)==false){
				alert('Please enter valid email .');
				document.getElementById("usr_email").focus();
				isFormValid=false;
			}
		}
	}
	return isFormValid;
}  
function isEmail(usr_email){
         var validateEmail = function(usr_email) {
      	return  /^\S+@\S+\.\S+$/.test(usr_email);
    	}
    return validateEmail(usr_email); // False
} 
</script>
<?php if(isset($_GET['k']) && $_GET['k']!=''){
	if($_GET['k']=='chngemail'){
		echo '<font color="green"><h5>Email sent to verify.</h5></font>';		
	} }?>
<form action="chngemail.php" method="post"  onsubmit="return validform()">
	<table>
		<tr><td>Enter Email id:-</td><td><input type="text" name="usr_email" id="usr_email" value="<?php echo $usr_email;?>" ></td></tr>
		<tr><td colspan="2"><input type="submit" name="btnsubmit" value="Submit"></td></tr>
	</table>
</form>
</td></tr></table>
</td></tr></table>
<?php include('footer.php'); ?>