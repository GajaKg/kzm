<?php
	
function confirm_query($result){
    if(!$result){
        die('query failed!');
    }
}   
 
function redirect_to($location){
    header('Location: ' . $location);
    exit;
}    

function errors($errors){
    $output = "";
    if(!empty($errors)){
        $output = "<p style=\"color: darkred; font-weight: bold;\">Исправите следеће грешке: </p>";
        $output .= "<ul>";
        foreach($errors as $error){        
            $output .= "<li style=\"color: darkred; font-weight: bold;\">" . $error . "</li>";
        }
        $output .= "</ul>"; 
    }
    return $output;
}    
    
function message(){
    $output = "";
    if(isset($_SESSION['message'])){
        $output = "<p class=\"message\">" .$_SESSION['message'] . "</p>";
        $_SESSION['message'] = null;
    }
    return $output;
}    
    
    
    
    
    
    
?>