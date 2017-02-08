<?php session_start(); ?>
<?php require_once('../include/dbconnection.php'); ?> 
<?php require_once('../include/function.php'); ?> 
<?php require_once('../include/function_admin.php'); ?> 
<?php loged_in(); ?>
<?php require_once('../include/function_post.php'); ?> 
<?php require_once('../include/function_subject.php'); ?> 
<?php include('../include/hf/header.php'); ?>


<div id="header"> Добродошли, <?php echo $_SESSION['username']; ?>!<br />&nbsp;&nbsp;&lArr;<a href="logout.php">  излогуј се </a> 
	<div id="navigation">
  
	</div><!-- end navigation -->
    <div id="logo">
    
    </div><!-- end logo -->
</div><!-- end header -->

<div id="breadcrumb1">

</div><!-- end breadcrumb1 -->
<div id="breadcrumb2">

</div><!-- end breadcrumb2 -->
<div id="content">
    <p style="text-align: center; font-size: 25px; font-weight: bolder;">
        <a href="manage_content.php">-*- УПРАВЉАЈ САДРЖАЈЕМ -*-</a><br /><br />
        <a href="manage_admins.php">-*- УПРАВЉАЈ АДМИНИСТРАТОРИМА -*-</a> <br /><br />
        <a href="logout.php">-*- ИЗЛОГУЈ СЕ -*-</a> 
    </p>
</div><!-- end content -->
<?php include('../include/hf/footer.php'); ?>