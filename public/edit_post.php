<?php session_start(); ?>
<?php require_once('../include/dbconnection.php'); ?> 
<?php require_once('../include/function.php'); ?> 
<?php require_once('../include/function_admin.php'); ?> 
<?php loged_in(); ?>
<?php require_once('../include/function_post.php'); ?> 
<?php require_once('../include/function_subject.php'); ?> 
<?php include('../include/hf/header.php'); ?>
<?php selected_subject(); selected_post(); ?>
<?php
$errors = array();	// inicijacija gresaka
if(isset($_POST['submit'])){
    // proveravanje ispravnosti unosa
    if(isset($_POST['post_title']) && !empty($_POST['post_title'])){
        $post_title = mysqli_real_escape_string($c, trim($_POST['post_title']));
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
    
    $post_visible = (INT)$_POST['post_visible']; // vec cekirano pa nema potrebe za proverm
    $post_featured = (INT)$_POST['post_featured']; //              -||-

    
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
        $post_image = $current_post['post_image']; // ako je vec uneta slika        
    }
    
    $post_date = date('Y-m-d H:i:s');
    
    $menu_name = $current_post['menu_name'];
    
    if(empty($errors)){
        $q  = "UPDATE posts SET ";
        $q .= "post_title = '$post_title', ";
        $q .= "post_author = '$post_author', ";
        $q .= "post_keywords = '$post_keywords', ";
        $q .= "post_visible = $post_visible, ";
        $q .= "post_featured = $post_featured, ";
        $q .= "post_content = '$post_content', ";
        $q .= "post_image = '$post_image', ";
        $q .= "post_date = '$post_date' ";
        $q .= "WHERE menu_name = '$menu_name' ";
        $q .= "LIMIT 1";
        $r  = mysqli_query($c, $q);
        confirm_query($r);
        
        if($r && mysqli_affected_rows($c) == 1){ //ukoliko je uspesno uneto u bazu
            $_SESSION['message'] = "Успешно сте изменили вест за категорију - $menu_name";
            redirect_to("manage_content.php?post={$current_post['post_title']}");
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
<form action="edit_post.php?post=<?php echo urlencode($current_post['post_title']); ?>" method="post" enctype="multipart/form-data">
<p>Поља обележена звездицом се морају попунити!</p>

<table>
<tr>
	<td style=" width: 200px; "> * Наслов:</td>
	<td><input type="text" name="post_title" value="<?php echo htmlentities($current_post['post_title']); ?>" style="width:320px;" /></td>
</tr>
<tr>
	<td> * Аутор:</td>
	<td><input type="text" name="post_author" value="<?php echo htmlentities($current_post['post_author']); ?>" style="width:200px;" /></td>
</tr>
<tr>
	<td>Кључне речи:</td>
	<td><input type="text" name="post_keywords" value="<?php echo htmlentities($current_post['post_keywords']); ?>" style="width:200px;" /></td>
</tr>
<tr>
	<td> * Видљивост:</td>
	<td>Да<input type="radio" name="post_visible" value="1" <?php if($current_post['post_visible'] == 1){ echo "checked";} ?> />&nbsp;&nbsp;
        Не<input type="radio" name="post_visible" value="0" <?php if($current_post['post_visible'] == 0){ echo "checked";} ?> /></td>
</tr>
<tr>
	<td> * Поставити на насловној страни:</td>
	<td>Да<input type="radio" name="post_featured" value="1" <?php if($current_post['post_featured'] == 1){ echo "checked";} ?> />&nbsp;&nbsp;
        Не<input type="radio" name="post_featured" value="0" <?php if($current_post['post_featured'] == 0){ echo "checked";} ?> /></td>
</tr>
<tr>
	<td> * Садржај:</td>
	<td><textarea name="post_content" rows="20" cols="90"><?php echo htmlentities($current_post['post_content']); ?></textarea></td>
</tr>
<tr>
	<td>Слика:</td>
	<td><input type="file" name="post_image" value="<?php echo $current_post['post_image']; ?>" /></td>
</tr>
<tr>
	<td colspan="2" style="text-align: right;"><input type="submit" name="submit" value="Измени вест" style="width: 100px; height: 30px;" /></td>
</tr>
</table>
</form><hr />
<a href="manage_content.php?post=<?php echo urlencode($current_post['post_title']); ?> ">Поништи</a>
</div><!-- end content -->


<?php include('../include/hf/footer.php'); ?>