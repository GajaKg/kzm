<?php session_start(); ?>
<?php require_once('../include/dbconnection.php'); ?> 
<?php require_once('../include/function.php'); ?> 
<?php require_once('../include/function_admin.php'); ?> 
<?php loged_in(); ?>
<?php include('../include/hf/header.php'); ?>


<div id="header">Добродошли, <?php echo $_SESSION['username']; ?>!&nbsp;&nbsp;<a href="logout.php">-*- излогуј се -*-</a>
	<div id="navigation"><br /><br />
        <a href="new_admin.php">+ Додај администратора</a>
	</div><!-- end navigation -->
    <div id="logo">
    
    </div><!-- end logo -->
</div><!-- end header -->

<div id="breadcrumb1">
<a href="admin.php">-*- Врати се на админ страну -*-</a>&nbsp; &nbsp;
</div><!-- end breadcrumb1 -->
<div id="breadcrumb2">

</div><!-- end breadcrumb2 -->
<div id="content" style="">
<?php echo message(); ?>
<table style="border: 1px solid red;">
<th style="width: 200px;">Администратор</th><th colspan="2" style="width: 200px; ">Акција</th>
<?php 
    $admin_set = find_all_admins();
    while($admin = mysqli_fetch_assoc($admin_set)){ ?>       
      <tr>
      <td><?php echo htmlentities($admin['username']); ?></td>
      <td style="text-align: center; "><a href="edit_admin.php?admin_id=<?php echo urlencode($admin['admin_id']); ?>">Измени</a></td>
      <td style="text-align: center; "><a href="delete_admin.php?admin_id=<?php echo urlencode($admin['admin_id']); ?>">Избриши</a></td>
      </tr>          
<?php } mysqli_free_result($admin_set); ?>



</table>

</div><!-- end content -->
<?php include('../include/hf/footer.php'); ?>