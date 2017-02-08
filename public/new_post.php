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
    if(isset($_POST['post_title']) && !empty($_POST['post_title'])){
        $post_title = mysqli_real_escape_string($c, trim(ucfirst($_POST['post_title'])));
    } else {
        $post_title = null;
        $errors[] = "Наслов не сме бити празан.";
    }
    
    if(isset($_POST['post_author']) && !empty($_POST['post_author'])){
        $post_author = mysqli_real_escape_string($c, trim($_POST['post_author']));
    } else {
        $post_author = null;
        $errors[] = "Морате попунити име аутора.";
    }
    
    if(isset($_POST['post_keywords']) && !empty($_POST['post_keywords'])){
        $post_keywords = mysqli_real_escape_string($c, $_POST['post_keywords']);
    } else {
        $post_keywords = "";
    }
    
    if(isset($_POST['post_visible'])){
        $post_visible = (INT)$_POST['post_visible'];
    } else {
        $post_visible = null;
        $errors[] = "Морате изабрати видљивост вести.";
    }
    
    if(isset($_POST['post_featured'])){
        $post_featured = (INT)$_POST['post_featured'];
    } else {
        $post_featured = null;
        $errors[] = "Морате изабрати да ли ће вест биди видљива и на насловној страни.";
    }
    
    if(isset($_POST['post_content']) && !empty($_POST['post_content'])){
        $post_content = mysqli_real_escape_string($c, $_POST['post_content']);
    } else {
        $post_content = null;
        $errors[] = "Морате унети садржај.";
    }
    
    if(isset($_FILES['post_image']) && !empty($_FILES['post_image'])){
        $post_image = addslashes($_FILES['post_image']['name']);
        $location = "images/vesti/" . $post_image;
        move_uploaded_file($_FILES['post_image']['tmp_name'], $location);
    } else {
        $post_image = "";
    }
    
    $post_date = date('Y-m-d H:i');
    
    $menu_name = $current_subject['menu_name'];
    
    if(empty($errors)){
        $q  = "INSERT INTO posts ( ";
        $q .= "menu_name, post_title,  post_author, post_keywords, post_visible, post_featured, post_content, post_image, post_date ";
        $q .= ") VALUES( ";
        $q .= "'$menu_name', '$post_title', '$post_author', '$post_keywords', $post_visible, $post_featured, '$post_content', '$post_image', '$post_date'";
        $q .= " )";
        $r  = mysqli_query($c, $q);
        confirm_query($r);
        
        if($r && mysqli_affected_rows($c) == 1){ //ukoliko je uspesno uneto u bazu
            $_SESSION['message'] = "Успешно сте додали вест за категорију - $menu_name";
            redirect_to("manage_content.php?subject={$current_subject['menu_name']}");
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
<form action="new_post.php?subject=<?php echo urlencode($current_subject['menu_name']); ?>" method="post" enctype="multipart/form-data">
<p>Поља обележена звездицом се морају попунити!</p>

<table>
<tr>
	<td style=" width: 200px; "> * Наслов:</td>
	<td><input type="text" name="post_title" value="" style="width:320px;" /></td>
</tr>
<tr>
	<td> * Аутор:</td>
	<td><input type="text" name="post_author" value="" style="width:200px;" /></td>
</tr>
<tr>
	<td>Кључне речи:</td>
	<td><input type="text" name="post_keywords" value="" style="width:200px;" /></td>
</tr>
<tr>
	<td> * Видљивост:</td>
	<td>Да<input type="radio" name="post_visible" value="1" />&nbsp;&nbsp;
        Не<input type="radio" name="post_visible" value="0" /></td>
</tr>
<tr>
	<td> * Поставити на насловној страни:</td>
	<td>Да<input type="radio" name="post_featured" value="1" />&nbsp;&nbsp;
        Не<input type="radio" name="post_featured" value="0" /></td>
</tr>
<tr>
	<td> * Садржај:</td>
	<td><textarea name="post_content" rows="20" cols="90"></textarea></td>
</tr>
<tr>
	<td>Слика:</td>
	<td><input type="file" name="post_image" value="" /></td>
</tr>
<tr>
	<td colspan="2" style="text-align: right;"><input type="submit" name="submit" value="Додај страну" style="width: 100px; height: 30px;" /></td>
</tr>
</table>
</form><hr />
<a href="manage_content.php">Поништи</a>
</div><!-- end content -->


<?php include('../include/hf/footer.php'); ?>