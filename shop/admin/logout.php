<?php
include('header.php');
unset($_SESSION["usr_email"]);
unset($_SESSION["usr_name"]);
unset($_SESSION["usr_role"]);
session_destroy();
header("Location:".SITE_URL."index.php");
?>