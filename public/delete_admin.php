<?php session_start(); ?>
<?php require_once('../include/dbconnection.php'); ?> 
<?php require_once('../include/function.php'); ?> 
<?php require_once('../include/function_admin.php'); ?> 

<?php selected_admin(); ?>

<?php

$id = $current_admin['admin_id'];

$admin_count = mysqli_num_rows(find_all_admins()); 

if($admin_count > 1){      // ukoliko ima samo jedan administrator onemogucavamo njegovo brisanje
  
    $q = "DELETE FROM admins WHERE admin_id = $id LIMIT 1";
    $r = mysqli_query($c, $q);
    
    if($r && mysqli_affected_rows($c) == 1){
        $q = "ALTER TABLE subjects AUTO_INCREMENT = 1"; // resetovanje AI da ne ode u kurac
        $_SESSION['message'] = "Успешно обрисан администратор!";
        redirect_to('manage_admins.php');
    } 
   
} else {
    $_SESSION['message'] = "Брисање није могуће, мора постојати минимум један администратор!";
    redirect_to('manage_admins.php');
}

   
    
?>