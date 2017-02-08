<?php
	
    
function find_all_admins(){
    global $c;
    
    $q = "SELECT * FROM admins ORDER BY username ASC";
    $r = mysqli_query($c, $q);
    confirm_query($r);
    return $r;
}    
    
function find_admin_by_id($admin_id){
    global $c;
    $safe_id = mysqli_real_escape_string($c, $admin_id);
    
    $q = "SELECT * FROM admins WHERE admin_id = $safe_id";
    $r = mysqli_query($c, $q);
    
    if($admin = mysqli_fetch_assoc($r)){
        return $admin;
    } else {
        return null;
    }
}        

function find_admin_by_username($username){
    global $c;
    $safe_name = mysqli_real_escape_string($c, $username);
    
    $q = "SELECT * FROM admins WHERE username = '$safe_name' ";
    $r = mysqli_query($c, $q);
    if($admin = mysqli_fetch_assoc($r)){
        return $admin;
    } else {
        return null;
    }
}
   
function selected_admin(){
    global $current_admin;
    
    if(isset($_GET['admin_id'])){
        $current_admin = find_admin_by_id($_GET['admin_id']);
    } else {
        $current_admin = null;
    }
}    



function attempt_login($username, $password){
    $admin = find_admin_by_username($username);
    if ($admin){
        if (password_check($password, $admin['hashed_password'])){
            return $admin;
        } else {
            return false;
        }
    } else {
        return false;
    }
} 
     
function loged_in(){
    if(!isset($_SESSION['username']) && !isset($_SESSION['admin_id'])){
        redirect_to('login.php');
    }
}    
    
// *-*-*-*-*-*-*-*-*-*-*-*-*-* PASSWORDS *-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*///     
function password_encrypt($password) {
  	$hash_format = "$2y$10$";   // Tells PHP to use Blowfish with a "cost" of 10
	  $salt_length = 22; 					// Blowfish salts should be 22-characters or more
	  $salt = generate_salt($salt_length);
	  $format_and_salt = $hash_format . $salt;
	  $hash = crypt($password, $format_and_salt);
		return $hash;
	}
	
	function generate_salt($length) {
	  // Not 100% unique, not 100% random, but good enough for a salt
	  // MD5 returns 32 characters
	  $unique_random_string = md5(uniqid(mt_rand(), true));
	  
		// Valid characters for a salt are [a-zA-Z0-9./]
	  $base64_string = base64_encode($unique_random_string);
	  
		// But not '+' which is valid in base64 encoding
	  $modified_base64_string = str_replace('+', '.', $base64_string);
	  
		// Truncate string to the correct length
	  $salt = substr($modified_base64_string, 0, $length);
	  
		return $salt;
	}
	
	function password_check($password, $existing_hash) {
		// existing hash contains format and salt at start
	  $hash = crypt($password, $existing_hash);
	  if ($hash === $existing_hash) {
	    return true;
	  } else {
	    return false;
	  }
	}
// *-*-*-END*-*-*-*-*-*-*-*-*-*-* PASSWORDS *-*-*-*-*-*-*-*-END-*-*-*-*-*-*-*-*-*-*///     
    
    
?>