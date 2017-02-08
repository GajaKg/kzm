<?php session_start(); ?>
<?php require_once('../include/dbconnection.php'); ?> 
<?php require_once('../include/function.php'); ?> 
<?php require_once('../include/function_post.php'); ?> 
<?php require_once('../include/function_subject.php'); ?>

<?php selected_subject(); ?>


<?php
global $c;
$menu_name = $current_subject['menu_name'];

$q = "DELETE FROM subjects WHERE menu_name = '$menu_name' LIMIT 1";
$r = mysqli_query($c, $q);

if($r && mysqli_affected_rows($c) == 1){
    $q = "ALTER TABLE subjects AUTO_INCREMENT = 1"; // resetovanje AI da ne ode u kurac
    $_SESSION['message'] = "Успешно избрисан мени";
    redirect_to('manage_content.php');
}	
?>