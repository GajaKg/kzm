<?php session_start(); ?>
<?php require_once('../include/dbconnection.php'); ?> 
<?php require_once('../include/function.php'); ?> 
<?php require_once('../include/function_post.php'); ?> 
<?php require_once('../include/function_subject.php'); ?> 
<?php include('../include/hf/header.php'); ?>
<?php selected_subject(); selected_post(); ?>
<?php
$errors = array();
if(isset($_POST['submit'])){
    
    $admin = "skolabelusic@yahoo.com"; //mail na koji se salje
    
    if(isset($_POST['email']) && !empty($_POST['email'])){
        $email = mysqli_real_escape_string($c, $_POST['email']);
    } else {
        $email = null;
        $errors[] = "Морате унети ваш мејл.";
    }
    
    if(isset($_POST['subject']) && !empty($_POST['subject'])){
        $subject = mysqli_real_escape_string($c, $_POST['subject']);
    } else {
        $subject = "";
    }
    
    if(isset($_POST['comment']) && !empty($_POST['comment'])){
        $comment = mysqli_real_escape_string($c, $_POST['comment']);
    } else {
        $comment = null;
        $errors[] = "Морате оставити коментар!";
    }
    
    if(empty($errors)){
        mail($admin, $subject, $comment, "From $email"); //slanje mejla mail(to,subject,message,headers,parameters)
        $_SESSION['message'] = "Хвала Вам што сте нас контактирали.";
    }
}
 
?>
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
<?php echo errors($errors); ?>
<table>
    <tr>
        <td style=" width: 60px;"><img src="images/sajt/Contacts.png"  height="48" /></td><td style=" width: 350px;">Марија Милојевић</td>
        <td rowspan="3" > 
          <form method="post" action="kontakt.php">
              Ваш мејл:<br /> <input name="email" type="text" /><br /><br />
              Наслов:<br /> <input name="subject" type="text" /><br /><br />
              Порука:<br />
              <textarea name="comment" rows="8" cols="65"></textarea><br />
              <input type="submit" name="submit" value="Пошаљи!" />
          </form>
        </td>
    </tr>
    <tr><td><img src="images/sajt/Callback-64.png" height="48" /></td><td>063/***666</td></tr>
    <tr><td><img src="images/sajt/Forward Message-50.png"  height="48" /></td><td>kzmrekovac@yahoo.com</td></tr>
</table>

</div><!-- end content -->
<?php include('../include/hf/footer.php'); ?>