<?php session_start(); ?>
<?php require_once('../include/dbconnection.php'); ?> 
<?php require_once('../include/function.php'); ?> 
<?php require_once('../include/function_post.php'); ?> 
<?php require_once('../include/function_subject.php'); ?> 
<?php selected_subject(); selected_post(); ?>

<?php $post_title = $current_post['post_title']; ?>

<?php

global $c;	
    
$q = "DELETE FROM posts WHERE post_title = '$post_title' LIMIT 1";
$r = mysqli_query($c, $q);    

if($r && mysqli_affected_rows($c) == 1){
    $q = "ALTER TABLE subjects AUTO_INCREMENT = 1"; // resetovanje AI da ne ode u kurac
    $_SESSION['message'] = "Успешно избрисана вест.";
    redirect_to('manage_content.php');
}    
    
?>