<?php
//Wechselt den Pfad zwischen Local und WEB:
include_once("whitelist.php");

 	global $wpdb;

	$user 		= get_current_user_id();
	
	if($user == 0){
		echo "Anmeldefehler";	
		return;
	}
	
	$vorname 	= $_POST['vorname'];
	$nachname 	= $_POST['nachname'];
	$portion 	= $_POST['portion'];
	$essen 		= $_POST['essen'];

//Bloß keine ID bei autoincrement mitgeben!!!

	$wpdb->insert( 
		'wp_guestlist', 
		array( 
			
            'userID' 		=> $user,
            'userName' 		=> '',
            'vorname' 		=> $vorname,
            'nachname' 		=> $nachname,
            'portion' 		=> $portion,
            'essen' 		=> $essen,
            'status' 		=> 'offen',
            'property11' 	=> '',
            'property12' 	=> '',
			'property13' 	=> '',
			'property14' 	=> '',
			'property15' 	=> ''   
		), 
		array( 
				
			'%s',
			'%s',
			'%s',
			'%s',
			'%s',
			'%s',
			'%s',
			'%s',
			'%s',
			'%s',
			'%s',
			'%s'
		) 

	);

	echo $wpdb->insert_id;


?>