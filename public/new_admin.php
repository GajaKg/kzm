<?php session_start(); ?>
<?php require_once('../include/dbconnection.php'); ?> 
<?php require_once('../include/function.php'); ?> 
<?php require_once('../include/function_admin.php'); ?> 
<?php loged_in(); ?>
<?php include('../include/hf/header.php'); ?>
<?php
	
$errors = array();

if(isset($_POST['submit'])){
    
    if(isset($_POST['username']) && !empty($_POST['username'])){
        $username = mysqli_real_escape_string($c, $_POST['username']);
    } else {
        $username= null;
        $errors[] = "Нисте унели корисничко име.";
    }
    
    if(isset($_POST['password']) && !empty($_POST['password']) && strlen($_POST['password']) > 7){
        $hashed_password = password_encrypt($_POST['password']);
    } else {
        $hashed_password = null;
        $errors[] = "Нисте унели шифру.";
    }
    
    $found_admin = find_admin_by_username($username);
    if(!$found_admin){
        
        if(empty($errors)){

            $q  = "INSERT INTO admins (" ;
            $q .= "username, hashed_password ";
            $q .= ") VALUES ( ";
            $q .= "'$username', '$hashed_password' ";
            $q .= ")";
            $r  = mysqli_query($c, $q);

            if($r && mysqli_affected_rows($c) == 1){
                $_SESSION['message'] = "Успешно додат администратор.";
                redirect_to('manage_admins.php');
            }
        }        
    } else {
        echo "<script>alert('Admin sa tim imenom vec postoji!');</script>";
    }

}    
    
    
    
?>

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
<?php echo errors($errors); ?>
<form action="new_admin.php" method="post">
<table>
    <tr>
        <td> Корисничко име: </td><td><input type="text" name="username" value="" style="width: 200px;" /></td>
    </tr>
    <tr>
        <td> Шифра (минимум 8 карактера):</td><td><input type="password" name="password" value="" style="width: 200px;" /></td>
    </tr>
    <tr>
        <td colspan="2" style="text-align: right; padding: 5px;"><input type="submit" name="submit" value="Додај администратора" style="width: 170px;" /></td>
    </tr>
</table>
</form>
<a href="manage_admins.php">Поништи</a>
</div><!-- end content -->
<?php include('../include/hf/footer.php'); ?>