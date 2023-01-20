<?php
include('admin/shopdb.php');
session_start();

$error="";
$prodid="";

if(isset($_GET['prodid']) && $_GET['prodid']!=''){
	$prodid=$_GET['prodid'];	
}

if(isset($_SESSION['usr_email']) && isset($_SESSION['usr_id']))
{
	$domain = '';
	$prodid=$_GET['prodid'];
	
	if(isset($_GET['qty']) && $_GET['qty']!=''){
		$productqty=$_GET['qty'];
	}
	else{
		$productqty='1';
		//print_r($productqty);
	//exit;
	}
	 if($prodid!='' && !isset($_COOKIE['prodid_'.$_SESSION['usr_id']])){
		
		setcookie('prodid_'.$_SESSION['usr_id'], $prodid."$".$productqty."#", time() + 48 * 3600, '/', $domain);
		 
	}

	else{
		if($prodid!='' && $productqty!='')
		{

			$checkproductcookie=explode('#',$_COOKIE['prodid_'.$_SESSION['usr_id']]);
			$validetoadd='true';

			foreach($checkproductcookie as $value)
			{
				$getprodid=explode('$',$value);
				if($getprodid['0']==$prodid)
				{
						$validetoadd='false';
						break;
				}
			}

			if($validetoadd=='true')
			{
				$getcookie=$_COOKIE['prodid_'.$_SESSION['usr_id']].$prodid.'$'.$productqty.'#';
				setcookie('prodid_'.$_SESSION['usr_id'], $getcookie);
				if(isset($_GET['returnprod']) && $_GET['returnprod']=='1')
				{
						header("Location:".SITE_URL."productdetail.php?prodid=".$prodid."&qty=".$productqty."&msg=add");
						exit;
				}
				else
				{
					header("Location:".SITE_URL."index.php?msg=added");
					exit;
				}
			}
			else
			{
				// here start
				if(isset($_GET['returnprod']) && $_GET['returnprod']=='1')
				{
					$recreatecookie='';
					foreach($checkproductcookie as $value)
					{
						$getprodid=explode('$',$value);
						if($getprodid['0']==$prodid)
						{
							$recreatecookie.=$getprodid['0'].'$'.$productqty.'#';
						}
						else
						{
							$recreatecookie.=$getprodid['0'].'$'.$getprodid['1'].'#';
						}
					}
					setcookie('prodid_'.$_SESSION['usr_id'], $recreatecookie);
					header("Location:".SITE_URL."productdetail.php?prodid=".$prodid."&qty=".$productqty."&msg=add");
							exit;
				}
				else
				{
				// here end
				header("Location:".SITE_URL."index.php?msg=alladded");
				exit;
				}
			}
		}
		
	}

	// 1$1#2$1#3$6
	header("Location:".SITE_URL."index.php");
}
else{
	$error ="Please Login";
	header("Location:".SITE_URL."index.php?error=login");
	}

?>