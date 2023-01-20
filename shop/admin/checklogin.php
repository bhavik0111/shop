<?php
if(isset($_SESSION["usr_email"]) && isset($_SESSION["usr_id"]) && isset($_SESSION["usr_role"]))
{
	if($_SESSION["usr_role"]!=1){
       
        header("Location:".SITE_URL);
        exit; 
        }
}
else{
	 header("Location:".SITE_URL);
        exit;
}
?>