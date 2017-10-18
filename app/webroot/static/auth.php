<?php 
session_start();
if($_SESSION['ADMIN_ID'] == '')
{
	header('location:index.php');
	exit;
}
?>