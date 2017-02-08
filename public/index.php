<?php session_start(); ?>
<?php require_once('../include/dbconnection.php'); ?> 
<?php require_once('../include/function.php'); ?> 
<?php require_once('../include/function_post.php'); ?> 
<?php require_once('../include/function_subject.php'); ?> 
<?php include('../include/hf/header.php'); ?>
<?php selected_subject(); selected_post(); ?>

<div id="header">
	<div id="navigation">
<?php  echo navigation_public(true); ?>   
	</div><!-- end navigation -->
    <div id="logo">
    
    </div><!-- end logo -->
</div><!-- end header -->

<div id="breadcrumb1">
</div><!-- end breadcrumb1 -->
<div id="breadcrumb2">
<?php echo message(); ?>
</div><!-- end breadcrumb2 -->
<div id="content">
 
<?php 
        if($current_subject['menu_name'] === "Почетна"){
            redirect_to('index.php');
                
        } elseif ($current_post){ // ispisivanje izabrane vesti 
            echo show_post($current_post); 
    
        } elseif ($current_subject){
             // ukoliko nije prazan sadrzaj kategorije ispisati ga, u suprotnom ispisati vest
            if(!empty($current_subject['subject_content'])){
                echo show_subject($current_subject);
            } else {
                echo show_all_post_for_subject_public($current_subject, true);
            }  

        } else {
            echo show_post_featured();
        }
?>
</div><!-- end content -->
<?php include('../include/hf/footer.php'); ?>