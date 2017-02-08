<?php
	
    
function find_post_for_subject($subject_name, $public = false){
    global $c;
    $safe_menu_name = mysqli_real_escape_string($c, $subject_name);
    
    $q  = "SELECT * FROM posts ";
    $q .= "WHERE menu_name = '$safe_menu_name' ";
    if($public){
        $q .= "AND post_visible = 1 ";
    }
    $q .= "ORDER BY post_date DESC";
    $r  = mysqli_query($c, $q);
    confirm_query($r);
    
    return $r;
} //find post fot subject

function find_post_by_title($title){
    global $c;
    $post_title = mysqli_real_escape_string($c, $title);
    
    $q = "SELECT * FROM posts WHERE post_title = '$post_title'";
    $r = mysqli_query($c, $q);
    confirm_query($r);
    
    if($post_set = mysqli_fetch_assoc($r)){
        return $post_set;
    } else {
        return null;
    }
}

function selected_post(){
    global $current_post;
    
    if(isset($_GET['post'])){
        $current_post = find_post_by_title($_GET['post']);
    } else {
        $current_post = null;
    }
}
    
function show_all_post_for_subject($current_subject, $public=false){
    $output = "";
    
    if($current_subject){
        $post_set = find_post_for_subject($current_subject['menu_name']);
        while($post = mysqli_fetch_assoc($post_set)){
            $output .= "<table id=\"news\">";
            $output .= "<tr><td class=\"title\" colspan=\"2\" >" . htmlentities($post['post_title']) . "</td></tr>";
            $output .= "<tr><td class=\"author\" colspan=\"2\">Аутор: " . htmlentities($post['post_author']);
            $output .= " / Датум: " . htmlentities($post['post_date']) . "</td></tr>";
            $output .= "<tr><td class=\"content\" colspan=\"2\" >" . substr(nl2br(htmlentities($post['post_content'])), 0, 200) . "</td><tr>";
            $output .= "<tr><td colspan=\"2\" class=\"readmore\">"; 
            if($public){ // ukoliko je public, onda ispisati opsirnije
                $output .= "<a href=\"index.php?post=" . urlencode($post['post_title']) . "\">Опширније</a></td></tr>";
            } else { // ukoliko je private onda ispisati pogledaj i izmeni
                $output .= "<a href=\"manage_content.php?post=" . urlencode($post['post_title']) . "\">Погледај и измени вест</a></td></tr>";
            }            
            $output .= "</table>";
        }
    }   
    return $output;
    mysqli_free_result($post_set);
}   
 
function show_all_post_for_subject_public($current_subject, $public=true){
    $output = "";
    
    if($current_subject){
        $post_set = find_post_for_subject($current_subject['menu_name'], true);
        while($post = mysqli_fetch_assoc($post_set)){
            $output .= "<table id=\"news\">";
            $output .= "<tr><td class=\"title\" colspan=\"2\" >" . htmlentities($post['post_title']) . "</td></tr>";
            $output .= "<tr><td class=\"author\" colspan=\"2\">Аутор: " . htmlentities($post['post_author']);
            $output .= " / Датум: " . htmlentities($post['post_date']) . "</td></tr>";
            $output .= "<tr><td class=\"content\" colspan=\"2\" >" . substr(nl2br(htmlentities($post['post_content'])), 0, 700) . "...</td><tr>";
            $output .= "<tr><td colspan=\"2\" class=\"readmore\">"; 
            $output .= "<a href=\"index.php?post=" . urlencode($post['post_title']) . "\">Опширније</a></td></tr>";        
            $output .= "</table>";
            
        } // end of while($post = mysqli_fetch_assoc($post_set))
      
    }// end of if($current_subject)   
    return $output;
    mysqli_free_result($post_set);
}  
    
function show_post($current_post){
    $output = "";
    
    if($current_post){
        $output .= "<table id=\"news\">";
        $output .= "<tr><td class=\"title\" colspan=\"2\" >" . htmlentities($current_post['post_title']) . "</td></tr>";
        $output .= "<tr><td class=\"author\" colspan=\"2\">Аутор: " . htmlentities($current_post['post_author']);  
        $output .= " / Датум: " . htmlentities($current_post['post_date']) . "</td></tr>";
        $output .= "<tr><td class=\"author\" colspan=\"2\" >Категорија: " . htmlentities($current_post['menu_name']) . "</td></tr>";
        $output .= "<tr><td class=\"content\" colspan=\"2\" ><p>";
        if(isset($current_post['post_image']) && !empty($current_post['post_image'])){
            $output .= "<img src=\"images/vesti/{$current_post['post_image']}\" height=\"250\" id=\"image\" />";
        }
        $output .= nl2br(htmlentities($current_post['post_content'])) . "</p></td><tr>";
        $output .= "</table>";
    }
    return $output;
}

function find_post_featured(){
    global $c;
    
    $q  = "SELECT * FROM posts ";
    $q .= "WHERE post_featured = 1 ";
    $q .= "AND post_visible = 1 ";
    $q .= "ORDER BY post_date DESC";
    $r  = mysqli_query($c, $q);
    confirm_query($r);    
    return $r;
}

function show_post_featured(){
    $display = 2;
    $posts_featured = find_post_featured();
    if(isset($_GET['p']) && is_numeric($_GET['p'])){
        $pages = $_GET['p'];
    } else {
        $count_records = mysqli_num_rows($posts_featured); //5
        
        if($count_records < $display){
            $pages = 1;
        } else {
            $pages = ceil($count_records/$display);
        }      
    }

    if(isset($_GET['s']) && is_numeric($_GET['s'])){
        $start = $_GET['s'];
    } else {
        $start = 0;
    }
    global $c;
    $q  = "SELECT * FROM posts ";
    $q .= "WHERE post_featured = 1 ";
    $q .= "AND post_visible = 1 ";
    $q .= "ORDER BY post_date DESC ";
    $q .= "LIMIT $start, $display ";
    $result_set = mysqli_query($c, $q);
    
    $output = "";
    while($post = mysqli_fetch_assoc($result_set)){
        $output .= "<table id=\"news\">";
        $output .= "<tr><td class=\"title\" colspan=\"2\" >" . htmlentities($post['post_title']) . "</td></tr>";
        $output .= "<tr><td class=\"author\" colspan=\"2\">Аутор: " . htmlentities($post['post_author']);
        $output .= " / Датум: " . htmlentities($post['post_date']) . "</td></tr>";
        $output .= "<tr><td class=\"content\" colspan=\"2\" >" . substr(nl2br(htmlentities($post['post_content'])), 0, 700) . "</td><tr>";
        $output .= "<tr><td colspan=\"2\" class=\"readmore\">"; 
        $output .= "<a href=\"index.php?post=" . urlencode($post['post_title']) . "\">Опширније</a></td></tr>";           
        $output .= "</table>";     
    }
    // paginacijaaaaa
    if($pages > 1){
        $output .= "<br/><p>";
        
        // utvrdjivanje do koje je strane skript stigao
        $current = ($start/$display) + 1;
        
        //ako nije na prvoj napraviti link za prethodnu
        if(!$current != 1){
            $output .= "<a href='index.php?s=" . urlencode(($start-$display)) . "&p=" . urlencode($pages) . "'><<</a>";
        }
        
        for($i=1; $i <= $pages; $i++){
            if($i != $current){
                $output .= "<a href='index.php?s=" . urlencode(($display * ($i-1))) . "&p=" . urlencode($pages) . "'>" . $i . "</a>";
            } else {
                $output .= $i . " ";
            }
        }
        
        //ako nije poslednja napraviti link za sledecu
        if($current != $pages){
            $output .= "<a href='index.php?s=" . urlencode($start+$display) . "&p=" . urlencode($pages) . "'>>></a>";
        }
        $output .= "</p>";
    }
    return $output;
    mysqli_free_result($post_set);
}  


/*
function show_post_featured(){
    $output = "";
    
    $post_set = find_post_featured();
    while($post = mysqli_fetch_assoc($post_set)){
        $output .= "<table id=\"news\">";
        $output .= "<tr><td class=\"title\" colspan=\"2\" >" . htmlentities($post['post_title']) . "</td></tr>";
        $output .= "<tr><td class=\"author\" colspan=\"2\">Аутор: " . htmlentities($post['post_author']);
        $output .= " / Датум: " . htmlentities($post['post_date']) . "</td></tr>";
        $output .= "<tr><td class=\"content\" colspan=\"2\" >" . substr(nl2br(htmlentities($post['post_content'])), 0, 700) . "</td><tr>";
        $output .= "<tr><td colspan=\"2\" class=\"readmore\">"; 
        $output .= "<a href=\"index.php?post=" . urlencode($post['post_title']) . "\">Опширније</a></td></tr>";           
        $output .= "</table>";
    }
    
    //$display = 5;
    return $output;
    mysqli_free_result($post_set);
}   
*/
    


	    
    
    
    
?>