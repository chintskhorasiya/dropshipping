<?php 
session_start();
unset($_SESSION['ADMIN_ID']);
unset($_SESSION['ADMIN_USERNAME']);
unset($_SESSION['ADMIN_EMAIL']);

header('location:index.php');
exit;
?>
