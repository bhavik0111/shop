<?php
session_start();
require('shopdb.php');
require('function.php');
require('checklogin.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Welcome Page</title>
	<script src="js/jquery-3.4.1.js"></script>
</head>
<body>
	<table width="100%">
		<tr>
			<td width="100%">
				<table width="100%" align="cente">
					<tr><td width="100%" colspan="7" align="center" style="text-align: center;"><h1>Welcome to Khyati Shop</h1></td></tr>
					<?php if(isset($_SESSION["usr_email"]) && $_SESSION["usr_email"]!='' && $_SESSION["usr_role"]!='' && $_SESSION["usr_name"]!=''){
							echo "<tr><td width='100%' align='center' colspan='7' style='text-align: center;'>
						<a href='logout.php'>Logout</a></td></tr>" ;}?>
					<tr><td width="2%"><a href="user.php">Users</a></td>
						<td width="2%"><a href="catagory.php">Category</a></td>
						<td width="2%"><a href="product.php">Product</a></td>
						<td width="2%"><a href="order.php">Orders</a></td>
						<td width="2%"><a href="selectcat.php">Select</a></td>
						<td width="2%"><a href="catjquery.php">Catjquery</a></td>
						<td width="88%">&nbsp;</td>
					</tr>
				</table>
</td></tr>
<tr><td width="100%">