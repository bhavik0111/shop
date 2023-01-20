<?php
include('header.php');?>
<table width="100%"><tr>
<?php include('profile_left.php'); ?>

<td widht="80%" align="center" valign="top">
<table width="100%" border="1"><tr><td>
<?php if(isset($_SESSION['usr_email']) && isset($_SESSION['usr_id']))
{
if(isset($_POST['btnsubmit']) && $_POST['btnsubmit']=='Submit'){
	$query="SELECT *from user_master WHERE usr_id='" . $_SESSION["usr_id"] . "'";
	$result = mysqli_query($conn,$query);
    $row = mysqli_fetch_array($result);
    if ($_POST["opwd"] == $row["usr_pass"]) {
    	$qryupd="UPDATE user_master set usr_pass='" . $_POST["npwd"] . "' WHERE usr_id='" . $_SESSION["usr_id"] . "'";
        $record=mysqli_query($conn,$qryupd);
        $message = "Password Changed";
    } else{
        $message = "Current Password is not correct";
    }
}
}
?>
<script type="text/javascript">
function valid()
{
	var isFormValid = true;
	var opwd=document.getElementById("opwd").value;
	var npwd=document.getElementById("npwd").value;
	var cpwd=document.getElementById("cpwd").value;
	if(opwd==''){
		alert('Please enter Current password.');
		document.getElementById("opwd").focus();
		isFormValid=false;
	}
	else if(npwd==''){
		alert('Please enter new password.');
		document.getElementById("npwd").focus();
		isFormValid=false;
	}
	else if(cpwd==''){
		alert('Please enter confirm password.');
		document.getElementById("cpwd").focus();
		isFormValid=false;
	}
	else{
	if(npwd!='' && isFormValid==true){
		if(isPassword(npwd)==false){
		alert('Please enter minimum 6 character and 1 number 1 special character and alphabates for valid password .');
		document.getElementById("npwd").focus();
		isFormValid=false;
		}
		}
	if(npwd!=cpwd && isFormValid==true){
		alert('Please enter same as new password .');
		document.getElementById("cpwd").focus();
		isFormValid=false;
		}
	if(cpwd!='' && isFormValid==true){
		if(isConPassword(cpwd)==false){
		alert('Please enter minimum 6 character and 1 number 1 special character and alphabates for valid password .');
		document.getElementById("cpwd").focus();
		isFormValid=false;
		}
		}


	}	
	return isFormValid;
}  
function isPassword(npwd){
    var validatePass = function(npwd) {
    return /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{6,16}$/.test(npwd);
    }
   return validatePass(npwd); // False

}
function isConPassword(cpwd){
    var validateConPass = function(cpwd) {
    return /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{6,16}$/.test(cpwd);
    }
   return validateConPass(cpwd); // False

}
</script>
<form action="chngpass.php" method="post" onsubmit="return valid()">
<div class="message"><font color="green"><?php if(isset($message)) { echo $message; } ?></font></div>
<table>
<tr><td>Current password</td><td><input type="password" name="opwd" id="opwd"></td></tr>
<tr><td>New password</td><td><input type="password" name="npwd" id="npwd"></td></tr>
<tr><td>Confirm password</td><td><input type="password" name="cpwd" id="cpwd"></td></tr>
<tr><td colspan="2" align="center"><input type="submit" name="btnsubmit" value="Submit"></td></tr>
</table>
</form>
</td></tr></table>
</td></tr></table>
<?php include('footer.php'); ?>