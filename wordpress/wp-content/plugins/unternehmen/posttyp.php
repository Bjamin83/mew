<?php

add_action('init','post_typ_unternehmen');


function post_typ_unternehmen(){
	register_post_type(
		'unternehmen',
		array(
			'labels' 	=> array(
				'name' 			=> 'MEW Unternehmen',
				'singular_name' => 'Unternehmen',
				'add_new_item'	=> 'Neues Unternhemen anlegen'
			),
			'taxonomies' => array('category'),
			'public' 	=> true,
			'show_ui' 	=> true,
			
			
			'supports' 	=> array(
				'title', 'excerpt', 'editor', 'thumbnail', 'custom-fields', 'comments'
			
			)
		)
	
	);
}


?>