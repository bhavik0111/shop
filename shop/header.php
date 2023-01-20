<?php
require('admin/shopdb.php');
include('admin/function.php');
session_start();
?><!DOCTYPE html><html><head><title>Welcome Page</title></head><body><table width="100%"><tr><td width="100%"><table width="100%">
					<tr><td width="100%" colspan="4" style="text-align: center;"><h1>Welcome to Khyati Shop</h1></td></tr>
					<tr><td width='100%' colspan='4' style='text-align: center;'>
					<?php if(isset($_SESSION["usr_email"]) && $_SESSION["usr_email"]!='' && $_SESSION["usr_role"]!='' && $_SESSION["usr_name"]!=''){
							echo "<a href='logout.php'>Logout</a>" ;?>
							&nbsp;
							<?php
							echo "<a href='userprofile.php'>Profile</a>" ;
						}
						else{
						echo "<a href='login.php'>Login</a>";}
						?>
						&nbsp;<a href="index.php">Home</a>
						&nbsp;<a href="cart.php">Cart</a>
						</td></tr>
					<?php
					if(isset($_GET["msg"]) && $_GET["msg"]=='alladded'){
						echo '<tr><td style="color:red;">Product already added in your cart.</td></tr>'	;
					}
					if(isset($_GET["msg"]) && $_GET["msg"]=='add'){
						echo '<tr><td style="color:red;">Product Quantity added in your cart.</td></tr>'	;
					}
					if(isset($_GET["msg"]) && $_GET["msg"]=='added'){
						echo '<tr><td style="color:red;">Product added in your cart.</td></tr>'	;
					}
					if(isset($_GET["error"]) && $_GET["error"]=='login'){
						echo '<tr><td style="color:red;">Please login before add product in your cart.</td></tr>'	;
					}	
					if(isset($_GET["err"]) && $_GET["err"]=='login'){
						echo '<tr><td style="color:red;">Please login before see product in your cart.</td></tr>'	;
					}	
					?>
					
				</table>
			</td>	
		</tr>
<tr><td width="100%">