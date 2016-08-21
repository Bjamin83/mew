function add_initialeintraege_db($userID) {

include_once($_SERVER['DOCUMENT_ROOT'].'wp-load.php' );
 	global $wpdb;

//Bloß keine Table-ID bei autoincrement mitgeben!!!

    $wpdb->insert( 
        'wp_gaesteliste', 
        array( 
            
            'userID' => $userID,
            'gaesteliste' => $gaesteliste,
            'property11' => '',
            'property12' => '',
			'property13' => '',
			'property14' => '',
			'property15' => '' 
        ), 
        array( 
            	
			'%s',
			'%s',
			'%s',
			'%s',
			'%s',
			'%s',
			'%s' 
        ) 
    );
