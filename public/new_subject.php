<?php session_start(); ?>
<?php require_once('../include/dbconnection.php'); ?> 
<?php require_once('../include/function.php'); ?> 
<?php require_once('../include/function_admin.php'); ?> 
<?php loged_in(); ?>
<?php require_once('../include/function_post.php'); ?> 
<?php require_once('../include/function_subject.php'); ?> 
<?php include('../include/hf/header.php'); ?>
<?php selected_subject(); ?>
<?php
$errors = array();	// inicijacija gresaka
if(isset($_POST['submit'])){
    // proveravanje ispravnosti unosa
    if(isset($_POST['menu_name']) && !empty($_POST['menu_name'])){
        $menu_name = mysqli_real_escape_string($c, trim($_POST['menu_name']));
    } else {
        $menu_name = null;
        $errors[] = "Морате унети назив менија.";
    }
    
    if(isset($_POST['position'])){
        $position = (INT)$_POST['position'];
    } else {
        $position = null;
        $errors[] = "Морате изабрати позицију.";
    }
    
    if(isset($_POST['visible'])){
        $visible = (INT)$_POST['visible'];
    } else {
        $visible = null;
        $errors[] = "Морате изабрати видљивост.";
    }
    
    if(isset($_POST['subject_content'])){
        $subject_content = mysqli_real_escape_string($c, $_POST['subject_content']);
    } else {
        $subject_content = ""; // nije obavezan sadrzaj
    }
    
    if(isset($_FILES['subject_image']) && !empty($_FILES['subject_image'])){
        $subject_image = addslashes($_FILES['subject_image']['name']);
        $location = "images/subject/" . $_FILES['subject_image']['name'];
        move_uploaded_file($_FILES['subject_image']['tmp_name'], $location);
    } else {
        $subject_image = ""; // nije obavezna slika
    }

    if(empty($errors)){
        $q  = "INSERT INTO subjects ( ";
        $q .= "menu_name, position, visible, subject_content, subject_image ";
        $q .= ") VALUES ( ";
        $q .= "'$menu_name', $position, $visible, '$subject_content', '$subject_image' ";
        $q .= ") ";
        $r  = mysqli_query($c, $q);
        confirm_query($r);
        
        if($r && mysqli_affected_rows($c) == 1){ //ukoliko je uspesno uneto u bazu
            $_SESSION['message'] = "Успешно сте додали мени.";
            redirect_to('manage_content.php');
        }
        
    }  
}    
    
    
    
    
?>
<div id="header">Добродошли, <?php echo $_SESSION['username']; ?>!&nbsp;&nbsp;<a href="logout.php">-*- излогуј се -*-</a>
	<div id="navigation">
<?php  echo navigation(); ?>   
	</div><!-- end navigation -->
    <div id="logo">
    
    </div><!-- end logo -->
</div><!-- end header -->

<div id="breadcrumb1">
<a href="admin.php">-*- Врати се на админ страну -*-</a>&nbsp; &nbsp;
<a href="new_subject.php">-*- Додај мени -*-</a> 
</div><!-- end breadcrumb1 -->
<div id="breadcrumb2">

</div><!-- end breadcrumb2 -->
<div id="content">
<?php echo errors($errors); ?>
<form action="new_subject.php" method="post" enctype="multipart/form-data">
<table>
<tr>
	<td style=" width: 200px; ">Назив менија:</td>
	<td><input type="text" name="menu_name" value="" /></td>
</tr>
<tr>
	<td>Позиција:</td>
	<td><select name="position">
<?php  // iscitavanje broja unosa iz baze i kreiranje <select>      
    $count_subjects = mysqli_num_rows(find_all_subjects());
    for($count = 1; $count <= $count_subjects +1; $count++){
        echo "<option value=\"";
        echo $count . "\"";
        if($count == $count_subjects + 1){ //za prikaz prve slobodne pozicije(tj zadnji broj)
            echo " selected ";
        } 
        echo " >" . $count;
        echo "</option>";
    }
    
?>    
    </select></td>
</tr>
<tr>
	<td>Видљивост:</td>
	<td>Да<input type="radio" name="visible" value="1" />&nbsp;&nbsp;
        Не<input type="radio" name="visible" value="0" /></td>
</tr>
<tr>
	<td>Садржај:</td>
	<td><textarea name="subject_content" rows="20" cols="90"></textarea></td>
</tr>
<tr>
	<td>Слика:</td>
	<td><input type="file" name="subject_image" value="" /></td>
</tr>
<tr>
	<td colspan="2" style="text-align: right;"><input type="submit" name="submit" value="Додај" style="width: 100px; height: 30px;" /></td>
</tr>
</table>
</form><hr />
<a href="manage_content.php">Поништи</a>
</div><!-- end content -->


<?php include('../include/hf/footer.php'); ?>