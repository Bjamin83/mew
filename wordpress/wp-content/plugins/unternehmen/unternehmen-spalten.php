<?php

//Erweitert die Spalten des Post-Types Unternehmen im Backend
add_filter('manage_unternehmen_posts_columns', 'my_columns');

function my_columns($columns) {
    		
        $columns['region'] = 'Region';
		$columns['status'] = 'Status';
		$columns['thumb'] = 'Bild';
		$columns['website'] = 'Website';

        return $columns;
    }

//Fügt die Inhalte den neuen Spalten des Post-Types Unternehmen im Backend hinzu
// in $name befinden sich auch die Werte aus my_columns():
add_action('manage_unternehmen_posts_custom_column',  'my_show_columns');

function my_show_columns($name) {
        global $post;
        switch ($name) {
            case 'region':
                $region = get_post_meta($post->ID, '_Region', true);
				echo $region;
				break;
			case 'status':
				$status = get_post_meta($post->ID, '_Unternehmens_status', true);
				echo $status;
				$status = get_post_meta($post->ID);
				break;
			case 'website':
				$website = get_post_meta($post->ID, '_Unternehmens_website', true);
				echo $website;
				$website = get_post_meta($post->ID);
				break;	
			case 'thumb':
				$thumbID = get_post_meta($post->ID, '_thumbnail_id', true);
				if ( has_post_thumbnail() ){
	    			$thumb = wp_get_attachment_image_src( $thumbID, 'thumbnail');
				echo '<img class="img-u-liste"  src="' . $thumb[0] .'" alt="Generic placeholder image">';	
				} else echo "Kein Bild verknüpft.";
				break;
        }
    }
 	
add_action( 'restrict_manage_posts', 'mew_unternehmen_filter' );
/**
 * Create a drop-down to filter posts by city
 * 
 */
function mew_unternehmen_filter(){
 
	 //If post_type isn't set, default to 'post'
	 $type = 'post';
	 if (isset($_GET['post_type'])) {
	 	$type = $_GET['post_type'];
	 }
	 
	 //add the filter only for the unternehmen post type
	 if("unternehmen" == $type){
	 
		 global $wpdb;
		 $results = $wpdb->get_results("SELECT meta_value FROM `wp_postmeta` WHERE meta_key = '_Region'"); 
		 
		 //assemble an array of all cities, along with the # of occurrences of each
		 $values = array(); 
		 foreach($results as $result){ 
		 
			 if(!isset($values[$result->meta_value]))
			 	$values[$result->meta_value] = 1;
			 else
			 	$values[$result->meta_value] = intval($values[$result->meta_value]) + 1;// an array like 'Heilbronn' => 1, 'Ludwigsburg' => 5
			 
		 }
	
		 ksort($values); 	 
		// print_r($values); 
		 
		 ?><select name="Regionenfilter"><option value="">Alle Regionen</option>
		 <?php 
		
		 $current_v = isset($_GET['Regionenfilter'])? $_GET['Regionenfilter']:'';
		 foreach ($values as $region => $num_occ) {
			 printf
			 (
			 '<option value="%s" %s="">%s</option>',
			 $region,
			 $region == $current_v? ' selected="selected"':'',
		//	 $region.' ('.$num_occ.')'    //Setzt die Anzahl in Klammer dahinter.
			$region
			 );
		 } 
 		?>
 		</select>
 
 		<?php 
 
 		$results = $wpdb->get_results("SELECT meta_value FROM `wp_postmeta` WHERE meta_key = '_Unternehmens_status'"); 
 
		 //assemble an array of all cities, along with the # of occurrences of each
		 $values = array(); 
		 foreach($results as $result){ 
		 
		 	if(!isset($values[$result->meta_value]))
		 		$values[$result->meta_value] = 1;
		 	else
				$values[$result->meta_value] = intval($values[$result->meta_value]) + 1;// an array like 'Normal' => 1, 'Partner' => 5
		 	
		 }

 		ksort($values); 	 
		//print_r($values); 
	 
		?><select name="Statusfilter"><option value="">Alle Status</option>
		<?php 

		 $current_v = isset($_GET['Statusfilter'])? $_GET['Statusfilter']:'';
		 foreach ($values as $status => $num_occ) {
			 printf
			 (
			 '<option value="%s" %s="">%s</option>',
			 $status,
			 $status == $current_v? ' selected="selected"':'',
		//	 $status.' ('.$num_occ.')'
			 $status
			 );
		 } 
		 ?>
		 </select>
 
 		<?php  
 
 	}
}

add_filter( 'parse_query', 'mew_filter_unternehmen_region' );
/**
 * Parse Query hängt sich in den aktuellen query ein. Ueber query_vars konnte keine Verkettung der beiden Filter Region und Status erzeugt werden, 
 * da beide auf nur ein Feld für meta key und meta value zeigen. 
 * Deshalb mussten die Arrays über meta_query in die aktuelle query eingefuegt werden.
 * Das ging allerdings nur ueber set()! Werden die Arrays einfach direkt in meta_query eingekippt hat das keine Auswirkungen auf die Ausgabe der gefilterten Unternehmen.
 */
function mew_filter_unternehmen_region( $query ){
    global $pagenow;
    $type = 'post';
	$meta_daten = array();
    if (isset($_GET['post_type'])) {
        $type = $_GET['post_type'];
    }
	
	if ( 'unternehmen' == $type && is_admin() && $pagenow=='edit.php' && isset($_GET['Regionenfilter']) && $_GET['Regionenfilter'] != '') {
        $meta_daten[] = array (
			'key'     => '_Region',
            'value'   => $_GET['Regionenfilter'],
            'compare' => '=');
        
    }
	if ( 'unternehmen' == $type && is_admin() && $pagenow=='edit.php' && isset($_GET['Statusfilter']) && $_GET['Statusfilter'] != '') {
        $meta_daten[] = array (
			'key'     => '_Unternehmens_status',
            'value'   => $_GET['Statusfilter'],
            'compare' => '=');
        
    }
	
	 $query->set( 'meta_query', $meta_daten );
	
	
//	print_r($query);
}





?>