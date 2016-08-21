<?php
//Pfad
$whitelist = array('127.0.0.1', "::1");
 
if(in_array($_SERVER['REMOTE_ADDR'], $whitelist)){
include_once($_SERVER['DOCUMENT_ROOT'].'/wordpress/wp-load.php' );
	
} else {
include_once($_SERVER['DOCUMENT_ROOT'].'wp-load.php' );
}

 	global $wpdb;

	$user	= get_current_user_id();
	$id  	= $_POST['id'];
	
	

//Bloß keine ID bei autoincrement mitgeben!!!

	$wpdb->delete( 
		'wp_guestlist', 
		array( 
			
           	'id' 		=> $id,
			'userID'	=> $user
            
		),  
		array( '%d','%d' ) 
	);


?>