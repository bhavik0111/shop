<?php
$servername = "localhost";
$username = "root";
$password = "";
$db = "test_khyatishop";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $db);

// Check connection
if ($conn)
	{
		
	}

define("SITE_URL", "http://192.168.0.11/test/khyati/shop/");
define("SITE_ROOT_URL", $_SERVER['DOCUMENT_ROOT']."/test/khyati/shop/");

?>