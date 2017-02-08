<?php
	   
define('DBHOST', 'localhost');
define('DBUSER', 'vladamaja');
define('DBPASS', 'rekovackzm2016');
define('DBNAME', 'kzmrekovac');

$c = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
     mysqli_query( $c, 'SET NAMES "utf8" COLLATE "utf8_general_ci"' ); // za sprsku cirilicu
     
if (!$c){
    die('Database connection failed: ' . mysqli_errno());
}    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
?>