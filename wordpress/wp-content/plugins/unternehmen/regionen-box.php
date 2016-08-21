<?php

add_action('add_meta_boxes','unternehmen_add_metaboxes');
add_action('save_post','unternehmen_savedata', 10);
//Benötigt einen spätere Prio (20) damit erst die Metafelder gespeichert werden. Siehe function unternehmen_savedata($post_id)
add_action('save_post','add_unternehmen_folder', 20);

function unternehmen_add_metaboxes(){
	add_meta_box(
		'unternehmen_metabox',
		'Regionseinstellungen',
		'unternehmen_regionenbox',
		'unternehmen',
		'side',
		'high'
	
	);
	
}

function unternehmen_regionenbox(){
		
	//hidden field zur Absicherung
	wp_nonce_field('unternehmen_action','unternehmen_name');
	
	//Befüllt die DropDowns
	$regionen = array('-','Heilbronn','Ludwigsburg','Stuttgart');
	$status = array('-','Offline','Normal', 'Partner');
	
	
	echo '<label for="Region">Region &nbsp; </label>
		<select name="Region">'; 
	
	//Über die Schleife wird der gespeicherte Wert selektiert. 
	foreach ($regionen as $region) {
    echo '<option value="' . $region . '"' . (get_post_meta(get_the_ID(),'_Region',true) === $region ? ' selected="selected"' : '') . '>' . $region . '</option>';  //XHTML!
	} 		
			 
	echo '</select>
		<br />
		<label for="unternehmens_status">Status &nbsp;&nbsp; </label>
		<select name="Unternehmens_status">';
	
	//Über die Schleife wird der gescpeicherte Wert selektiert. 
	foreach ($status as $stat) {
    echo '<option value="' . $stat . '"' . (get_post_meta(get_the_ID(),'_Unternehmens_status',true) === $stat ? ' selected="selected"' : '') . '>' . $stat . '</option>';  //XHTML!
	}	
			
	echo '</select>';
	
	//Telefonnummer
	echo '<br />
		<label for="Unternehmens_telefonnummer">Telefon</label>
		<input type="text" name="Unternehmens_telefonnummer" value="'. get_post_meta(get_the_ID(),'_Unternehmens_telefonnummer',true) .'">';
	
    //E-Mail
	echo '<br />
		<label for="Unternehmens_email">E-Mail</label>
		<input type="text" name="Unternehmens_email" value="'. get_post_meta(get_the_ID(),'_Unternehmens_email',true) .'">';
    
    //Website-Adresse
	echo '<br />
		<label for="unternehmens_website">Website</label>
		<input type="text" name="Unternehmens_website" value="'. get_post_meta(get_the_ID(),'_Unternehmens_website',true) .'">';
	
		//Generierte Kundennummer
	echo '<br />
		<label for="unternehmens_kn">K-Nr.</label>
		<input type="text" name="Unternehmens_kn" value="'. get_post_meta(get_the_ID(),'_Unternehmens_kundennummer',true) .'" disabled="disabled" >';
	
	
	
}

function unternehmen_savedata($post_id){
	
	//Sicherung des Speichervorgangs
	if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return false;
	
	if( !current_user_can('edit_post', $post_id)) return false;
	
	if(isset($_POST['unternehmen_name'])){
		if( !wp_verify_nonce($_POST['unternehmen_name'],'unternehmen_action') ) return false;
		
		//speichert die Auswahl in den DropDowns
		update_post_meta($_POST['post_ID'],'_Region',$_POST['Region'], false);
        update_post_meta($_POST['post_ID'],'_Unternehmens_telefonnummer',$_POST['Unternehmens_telefonnummer'], false);
        update_post_meta($_POST['post_ID'],'_Unternehmens_email',$_POST['Unternehmens_email'], false);
		update_post_meta($_POST['post_ID'],'_Unternehmens_status',$_POST['Unternehmens_status'], false);
		update_post_meta($_POST['post_ID'],'_Unternehmens_website',$_POST['Unternehmens_website'], false);	
	}
}



//Legt zu jedem neuen "MEW Unternehmen" einen Ordner für die Media Dateien mit ausgewählter Region an.
//Fügt eine KUNDENNUMMER hinzu.
function add_unternehmen_folder($post_ID){
	
			$aktueller_post = get_post($post_ID);
			
			//Abfrage ob der neue Post ein Unternehmen ist
			
			if(($aktueller_post->post_type) == 'unternehmen' ) {
				$premium = get_post_meta($post_ID);
				
				$region = $premium['_Region'][0];
                
				
				$title_short = substr(the_title('','',false), 0, 2);
			
				
				//Fügt eine Kundennummer hinzu.
				$knr = "MEW" . strtoupper($title_short) . date('dmy') . "_" . $post_ID;
				
				add_post_meta($post_ID, '_Unternehmens_kundennummer', $knr, true);
				
                //Wenn keine Region ausgewählt ist wird kein Ordner erstellt.
                if(!isset($region)){
                    return;
                }
                
				$whitelist = array('127.0.0.1', "::1");
                
				//$premium['_Region'][0] fügt die ausgewählte Region hinzu.
				//..wp-content/uploads/heilbronn/unternehmen
				if(in_array($_SERVER['REMOTE_ADDR'], $whitelist)){
					$mein_pfad = $_SERVER['DOCUMENT_ROOT'] . "/mew/wordpress/wp-content/uploads/" . $region . "/" . $knr;
				} else $mein_pfad = $_SERVER['DOCUMENT_ROOT'] . "wp-content/uploads/" . $region . "/" . $knr;
				
				
				if (!is_dir($mein_pfad)) {
					wp_mkdir_p($mein_pfad);

				}
				
			} else return;
			

}

?>