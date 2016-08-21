<?php
//Pfad
$whitelist = array('127.0.0.1', "::1");
 
if(in_array($_SERVER['REMOTE_ADDR'], $whitelist)){
include_once($_SERVER['DOCUMENT_ROOT'].'/mew/wordpress/wp-load.php' );
	
} else {
include_once($_SERVER['DOCUMENT_ROOT'].'wp-load.php' );
}

 	global $wpdb;


	$user 		= get_current_user_id();
	
	if($user == 0){
		echo "Anmeldefehler";	
		return;
	}

	$unternehmen   = $_POST['unternehmen'];
	$rating        = $_POST['rating'];

	

//Bloß keine ID bei autoincrement mitgeben!!!
    
    $check_sql= "Select id FROM {$wpdb->prefix}rating WHERE unternehmensID = %s AND userID = %d";
    
    $check_sql = $wpdb->prepare($check_sql,$unternehmen,$user);
    $result = $wpdb->query($check_sql);

  //  print_r($result);

    if ($result==1){
        
        $wpdb->update( 
            'wp_rating', 
            array( 

                'bewertung' 	=> $rating,
                  
            ), 
            array( 'unternehmensID'=> $unternehmen, 'userID'=> $user ), 
            array( 
                
                '%d'
            ), 
            array( '%s','%s' ) 
        ); 
        
          
    }else {
        $wpdb->insert( 
            'wp_rating', 
            array( 

                'unternehmensID'=> $unternehmen,
                'userID' 		=> $user,
                'bewertung' 	=> $rating,
                'property11' 	=> '',
                'property12' 	=> '',
                'property13' 	=> '',
                'property14' 	=> '',
                'property15' 	=> ''   
            ), 
            array( 

                '%s',
                '%d',
                '%d',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s'
            ) 

	   );

	       
    }


?>