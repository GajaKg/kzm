
<?php session_start(); ?>
<?php require_once('../include/dbconnection.php'); ?> 
<?php require_once('../include/function.php'); ?> 
<?php require_once('../include/function_admin.php'); ?> 

<?php 
$errors = array();
if(isset($_POST['submit'])){
    
    if(isset($_POST['username']) && !empty($_POST['username'])){
        $username = $_POST['username'];
    } else {
        $username= null;
        $errors[] = "Нисте унели корисничко име.";
    }
    
    if(isset($_POST['password']) && !empty($_POST['password']) && strlen($_POST['password']) > 7){
        $password = $_POST['password'];
    } else {
        $password = null;
        $errors[] = "Нисте унели шифру.";
    } 
     
    if(empty($errors)){
        
        $found_admin = attempt_login($username, $password);
        
        if($found_admin){
            $_SESSION['username'] = $found_admin['username'];
            $_SESSION['admin_id'] = $found_admin['id'];
            redirect_to('admin.php');
        } else {
            $_SESSION['message'] = "Корисничко име или лозинка нису исправни!";
        }
    } 
 
}


?>
<?php echo errors($errors); ?>
<?php echo message(); ?>
<form action="login.php" method="post">
<table style="margin: 200px auto;">
    <tr>
        <td> Корисничко име: </td><td><input type="text" name="username" value="" style="width: 200px;" /></td>
    </tr>
    <tr>
        <td> Шифра:</td><td><input type="password" name="password" value="" style="width: 200px;" /></td>
    </tr>
    <tr>
        <td colspan="2" style="text-align: right; padding: 5px;"><input type="submit" name="submit" value="Улогуј се!" style="width: 170px;" /></td>
    </tr>
</table>
</form>