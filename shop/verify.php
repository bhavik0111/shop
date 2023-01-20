<?php
include('header.php');
if(isset($_GET['submit']) && $_GET['submit']=='Verify'){
	//print_r($_GET);
	$checkcode=$_GET['code'];
	if($checkcode!=''){
	$checkcodequery="select * from `verify_email` where `usr_code`='".$checkcode."' ";
	//print_r($checkcodequery);
	//exit;
	$checkcoderesult=mysqli_query($conn, $checkcodequery);
	$checkcoderow = mysqli_num_rows($checkcoderesult);	
	$row=mysqli_fetch_assoc($checkcoderesult);
	//print_r($checkcoderow);
	//exit;
		if($checkcoderow==1){
			$userid='';
			// here add code for update email.
			$userid=$row['usr_id'];
			$usr_email=$row['usr_email'];
			//print_r($userid);
			//exit;
			$updateemail="UPDATE `user_master` set `usr_email`='".$usr_email."' where `usr_id`='".$userid."'" ;
			if(mysqli_query($conn,$updateemail)){
				$deleteverify="delete from `verify_email` where `usr_id`='".$userid."'";
				$deletecoderesult=mysqli_query($conn, $deleteverify);
				unset($_SESSION["usr_email"]);
				unset($_SESSION["usr_id"]);
				unset($_SESSION["usr_name"]);
				unset($_SESSION["usr_role"]);
				session_destroy();
				header("Location:".SITE_URL."index.php");
				exit;
			}
		}
	}
	exit;
}	
$displayform='false';
if(isset($_GET['code']) && $_GET['code']!=''){
	$checkcode=$_GET['code'];
	//print_r($_GET['code']);
	//exit;
	if($checkcode!=''){
		//
	$checkcodequery="select * from `verify_email` where `usr_code`='".$checkcode."' ";
	//print_r($checkcodequery);
	//exit;
	$checkcoderesult=mysqli_query($conn, $checkcodequery);
	$checkcoderow = mysqli_num_rows($checkcoderesult);	
	$row=mysqli_fetch_assoc($checkcoderesult);
	//print_r($checkcoderow);
	//exit;
		if($checkcoderow==1){
			$displayform='true';
		
		}
	}
	}

if($displayform=='true'){
?>
<form action="verify.php" method="get">
<table>
<tr><td width="100%" align="center" style="text-align: center;;">
	<p>Please click on below button for verify Email.</p>
	<input type="submit" name="submit" value="Verify">
	<input type="hidden" name="code" value="<?php echo $checkcode;?>">
	</td></tr>
</table>
</form>
	<?php
}
	//Check code in database
//}/*else{
	//header("Location:".SITE_URL.);
	//exit;
//}*/
include('footer.php'); ?>
