<?php session_start(); ?>
<?php require_once('../include/dbconnection.php'); ?> 
<?php require_once('../include/function.php'); ?> 
<?php require_once('../include/function_admin.php'); ?> 
<?php loged_in(); ?>
<?php require_once('../include/function_post.php'); ?> 
<?php require_once('../include/function_subject.php'); ?> 
<?php include('../include/hf/header.php'); ?>
<?php selected_subject(); selected_post(); ?>

<div id="header">Добродошли, <?php echo $_SESSION['username']; ?>!&nbsp;&nbsp;<a href="logout.php">-*- излогуј се -*-</a>
	<div id="navigation">
<?php  echo navigation(); ?>   
	</div><!-- end navigation -->
    <div id="logo">
    
    </div><!-- end logo -->
</div><!-- end header -->

<div id="breadcrumb1">
<a href="admin.php">-*- Врати се на админ страну -*-</a>&nbsp; &nbsp;
<a href="new_subject.php">-*- Додај категорију -*-</a> 
</div><!-- end breadcrumb1 -->
<div id="breadcrumb2">
<?php echo message(); ?>
</div><!-- end breadcrumb2 -->
<div id="content">
 
<?php if($current_subject){// ispisivanje sadrzaja trenutnog menija(subject) ?>
        
       Назив категорије:<b> <?php echo $current_subject['menu_name']; ?> </b> <br />
       Позиција:<b> <?php echo $current_subject['position']; ?> </b> <br />
       Видљивост: <b><?php if($current_subject['visible'] == 1) { echo " Да"; } else { echo "Не";} ?></b> <br /> 
       Слика: <b><?php if(!empty($current_subject['subject_image'])){ echo "Да";} else { echo "Не";} ?></b><br />
       Садржај:<br />
       <b> <?php echo nl2br($current_subject['subject_content']); ?></b><br /><br />
       
       <p><b>
       <a href="new_post.php?subject=<?php echo urlencode($current_subject['menu_name']); ?>">+ Додај вест за категорију</a>&nbsp; &nbsp;
       <a href="edit_subject.php?subject=<?php echo urlencode($current_subject['menu_name']); ?>">Измени</a>&nbsp; &nbsp;
       <a href="delete_subject.php?subject=<?php echo urlencode($current_subject['menu_name']); ?>">Избриши</a>&nbsp;&nbsp;
       <a href="manage_content.php">Поништи</a>
       </b></p>
       <hr />
<?php echo show_all_post_for_subject($current_subject); ?>       
      

<?php } elseif ($current_post){ ?>


<?php echo show_post($current_post); ?>

       <a href="edit_post.php?post=<?php echo urlencode($current_post['post_title']); ?>">Измени</a>&nbsp; &nbsp;
       <a href="delete_post.php?post=<?php echo urlencode($current_post['post_title']); ?>">Избриши</a>&nbsp;&nbsp;
       <a href="manage_content.php?subject=<?php echo urlencode($current_post['menu_name']); ?>">Поништи</a>



<?php } else {  }?>

</div><!-- end content -->
<?php include('../include/hf/footer.php'); ?>