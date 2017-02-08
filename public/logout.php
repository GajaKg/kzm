<?php session_start(); ?>
<?php require_once('../include/dbconnection.php'); ?> 
<?php require_once('../include/function.php'); ?> 
<?php require_once('../include/function_admin.php'); ?> 

<?php
	
$_SESSION['username'] = null;
$_SESSION['admin_id'] = null;  

redirect_to('login.php');
    
?>