<?php
	
function find_all_subjects($public = false){
    global $c;
    
    $q  = "SELECT * FROM subjects "; 
    if($public){ //ukoliko je public (index.php) onda izabiramo samo kategorije koje vidljive
        $q .= "WHERE visible = 1 ";
    }
    $q .= "ORDER BY position ASC";
    $r  = mysqli_query($c, $q);
    confirm_query($r);
    return $r;
}    

function find_subject_by_name($name){
    global $c;
    $safe_name = mysqli_real_escape_string($c, $name);
    
    $q  = "SELECT * FROM subjects ";
    $q .= "WHERE menu_name = '$safe_name'";
    $r  = mysqli_query($c, $q);
    
    if($subject_set = mysqli_fetch_assoc($r)){
        return $subject_set;
    } else {
        $subject_set = null;
    }
}

function selected_subject(){
    global $current_subject;
    
    if(isset($_GET['subject'])){
        $current_subject = find_subject_by_name($_GET['subject']);
    } else {
        $current_subject = null;
    }    
}


function navigation(){
    $output = "";
    $output .= "<ul id=\"menu\">";
    $subject_set = find_all_subjects();
    while($subject = mysqli_fetch_assoc($subject_set)){    
            $output .= "<li><a href=\"manage_content.php?subject=";
            $output .= urlencode($subject['menu_name']) . "\">";
            $output .= htmlentities($subject['menu_name']) . "</a></li>";    
    }
    $output .= "</ul>";  
    return $output;
    mysqli_free_result($subject_set);
}    

function navigation_public($public){
    $output = "";
    $output .= "<ul id=\"menu\">";
    $subject_set = find_all_subjects($public);
    while($subject = mysqli_fetch_assoc($subject_set)){    
            $output .= "<li><a href=\"index.php?subject=";
            $output .= urlencode($subject['menu_name']) . "\">";
            $output .= htmlentities($subject['menu_name']) . "</a></li>";    
    }
    $output .= "<li><a href=\"kontakt.php\">Контакт</a></li>";
    $output .= "</ul>";  
    return $output;
    mysqli_free_result($subject_set);
}
    
function show_subject($current_subject){
    $output = "";
    if(!empty($current_subject['subject_content'])){
        //ukoliko ima slika ispisati jedan layout 
        if(isset($current_subject['subject_image']) && !empty($current_subject['subject_image'])){
            $output .= "<p class=\"content\" ><img src=\"images/subject/{$current_subject['subject_image']}\" height=\"250\" id=\"image\" />";
            $output .= nl2br(htmlentities($current_subject['subject_content'])) . "</p>";
        } else { // ukoliko nema slike ispisati drugi layout
            $output .= "<p class=\"content\">" . nl2br(htmlentities($current_subject['subject_content'])) . "</p>";
        }  
    }   
    return $output;
}    

    
    
    
    
    
    
    
    
    
?>