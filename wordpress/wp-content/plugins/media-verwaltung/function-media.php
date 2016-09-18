<?php
     
    //AUSWAHL DER REGION
	If (isset($_POST['region'])){
		$region = $_POST['region'];
	}
    
     
    //Unterscheidung Server oder Localhost
    $whitelist = array('127.0.0.1', "::1");
     
/*
*	===================
*	Funktionsweiche: Aufruf erfolgt aus der JS-Datei media-verwaltung.js
*	===================
*/
    
	//DB-Abfrage gibt alle Results zum selektierten Unternemen zurück
    if (isset($_POST['type']) && $_POST['type'] == 'anzeige-region') {
		anzeige_region();
    }
     
    //DB-Abfrage gibt alle Results zum selektierten Unternemen zurück
    if (isset($_POST['type']) && $_POST['type'] == 'anzeige-media') {
		anzeige_media();
    }
     
    //	DB-Abfrage nach allen Bilder des gewählten Ordners und deren Darstellung.
    if (isset($_POST['type']) && $_POST['type'] == 'update-media'){
		update_media();
    }
	
	//	DB-Abfrage nach allen Bilder des gewählten Ordners und deren Darstellung.
    if (isset($_POST['type']) && $_POST['type'] == 'delete-media'){
		delete_media();
    }
     
    //Triggert die Funktion an, dass alle Ordner durchsucht und in der Datenbank angelegt werden.
    if (isset($_POST['type']) && $_POST['type'] == 'check-all-media'){
		check_all_media();
    }
     
	
		
	
	
/*   
*	====================	
*	FUNKTIONEN  
*	====================
*/

function getDocRoot(){
    //Prüfung ob Server oder Localhost
    $whitelist = array('127.0.0.1', "::1");
     
    if(in_array($_SERVER['REMOTE_ADDR'], $whitelist)){
    $docRoot = $_SERVER['DOCUMENT_ROOT'] . "/mew/wordpress/";
    
    } else {
    $docRoot = $_SERVER['DOCUMENT_ROOT']. "/";
    }
    return $docRoot;
}

function getServerRoot(){
    //Prüfung ob Server oder Localhost
    $whitelist = array('127.0.0.1', "::1");
     
    if(in_array($_SERVER['REMOTE_ADDR'], $whitelist)){
	$base_url = "http://" . $_SERVER['SERVER_NAME']	. "/mew/wordpress/";
    } else {
	$base_url = "http://" . $_SERVER['SERVER_NAME']. "/";
    }
    return $base_url;
}


function anzeige_region(){
	//AUSWAHL DER REGION
    $mein_pfad =    getDocRoot();
    $mein_pfad .=   "wp-load.php";

    include_once($mein_pfad);

    global $region;
    global $wpdb;

    
	if ($region == ""){
		return;
	}

    $table_name = $wpdb->prefix . 'mediaverwaltung';
    
    //Holt sich alle Unternehmen welche Bilder in der DB haben. Distinct auf slug bewirkt, dass bei mehreren Einträgen(Bildern) das Unternehmen nur einmal vorkommt.
    $resultset = $wpdb->get_results( $wpdb->prepare('SELECT DISTINCT slug FROM '.$table_name.' WHERE region = %s ', $region) );

    foreach($resultset as $result){
    echo "<option value='" . $result->slug . "'>" . $result->slug ."</option>";
	}

}



//	DB-Abfrage nach allen Bilder des gewählten Ordners und deren Darstellung.
function anzeige_media(){

	$mein_pfad =    getDocRoot();
    $mein_pfad .=   "wp-load.php";
    
    include_once($mein_pfad);
     
    global $wpdb;
     
    $table_name = $wpdb->prefix . 'mediaverwaltung';
    //$sql = 'SELECT * FROM '.$table_name.' WHERE slug = %s';
    $resultset = $wpdb->get_results( $wpdb->prepare('SELECT slugname, permalink, description, imagename FROM '.$table_name.' WHERE slug = %s', $_POST['ordner']) );
     
	$media_html =''; 
	 
    if(empty($resultset)){
    	$aktion = "Keine Bilder im Ordner vorhanden oder noch nicht in die Datenbank eingelesen.";
		echo json_encode(array("media"=>$media_html,"aktion"=>$aktion));
		return;
    }else
		$aktion = "";
     
  
    foreach ($resultset as $result) {
		$imagelink = $result->permalink . "/" . $result->imagename;
		 
		$media_html .= "<div class='admin-media-box float-left'>";
		$media_html .= "<div class='float-left'>";
		$media_html .= "<label class=''>Beschreibung:</label><input type='text' name='description' class='description admin-media-desc' value='" . $result->description . "' >";
		$media_html .= "<br /><button class='f-update-media button margin-right' value='". $result->slugname . "'>Speichern</button><button class='f-delete-media button' value='". $result->slugname . "'>Bild aus DB löschen</button>";
		$media_html .= "</div><div class='float-left'>";
		$media_html .= "<img src='" . $imagelink . "' alt='" . $result->imagename . "' class='admin-media-thumbs' />";
		$media_html .= "</div>";
		$media_html .= "</div>"; 
    }
    $media_html .= "<div class='clear-both>'";
	 
	 echo json_encode(array("media"=>$media_html,"aktion"=>$aktion, "result" => $resultset));
	 
 }    

function update_media(){
	
	$mein_pfad =    getDocRoot();
    $mein_pfad .=   "wp-load.php";
    
    include_once($mein_pfad);
     
    global $wpdb;
     
    $table_name = $wpdb->prefix . 'mediaverwaltung';
	
	//Bloß keine ID bei autoincrement mitgeben!!!

	$suc = $wpdb->update( 
		'wp_mediaverwaltung', 
		array( 
			
            'description' => $_POST['describtion'],
             
		), 
		array( 'slugname' => $_POST['slugname'] ), 
		array( 
				
			'%s'
			
		), 
		array( '%s' ) 
	);
	
	if ($suc != false && $suc > 0){
		echo "Erfolgreich gespeichert, Bro!"; 
	}else
	echo "Keine Aktualisierung möglich!" ;
}

function delete_media(){
	$mein_pfad =    getDocRoot();
    $mein_pfad .=   "wp-load.php";
    
    include_once($mein_pfad);
     
    global $wpdb;
     
    $table_name = $wpdb->prefix . 'mediaverwaltung';
	
	//Bloß keine ID bei autoincrement mitgeben!!!

	$suc = $wpdb->delete( 
		'wp_mediaverwaltung', 
		 
		array( 'slugname' => $_POST['slugname'] ),  
		array( '%s' ) 
	);
	
	if ($suc != false && $suc > 0){
		echo "Eintrag aus Datenbank gelöscht!"; 
	}else
	echo "Löschvorgang nicht möglich!" ;
}



	 
//Durchläuft den Ordner anhand der $Region und schreibt einen DB Eintrag pro Bild im Ordner. 

//DIE UPDATE FUNKTION MUSS ÜBERDACHT WERDEN. Aktuell ON DUBLICATE KEY slugname=slugname.

function check_all_media(){
	 
    global $whitelist;
	global $region;
	
	if($region == ""){
		return;
	}
	
	
     
    $mein_pfad  =   getDocRoot();
    $filePfad   =   $mein_pfad . "wp-content/uploads/" . $region;
    $load_pfad .=   $mein_pfad . "wp-load.php";
    
    
    $mediaPfad  =   getServerRoot();
    $mediaPfad  =   $mediaPfad . "wp-content/uploads/" . $region;
    
    include_once($load_pfad);
     
    global $wpdb;
     
    $ordner = get_media_folder($filePfad);
    $slug = '';
     
    //Liest das mehrdim. Array aus.
    foreach ($ordner as $key => $value){
		$slug = $key;
		foreach ($value as $key2 => $value2){
			//Ordner+Imagename: Kundennummer_Kuchen.jpg
			$slugname = $slug . $value2;
			//Pfad zum Onlinebild
			$permalink = $mediaPfad . "/" . $slug;
			//
			$description = substr($value2, 0, -4);
			//Name des Bilds: bild.jpg
			$imagename = $value2;
			 
			$sql = "INSERT INTO {$wpdb->prefix}mediaverwaltung (slugname,slug,permalink,description,imagename,region) VALUES (%s,%s,%s,%s,%s,%s) ON DUPLICATE KEY UPDATE
			slugname = %s";
			 
			// var_dump($sql); // debug
			 
			$sql = $wpdb->prepare($sql,$slugname,$slug,$permalink,$description,$imagename,$region,$slugname);
			// var_dump($sql); // debug
			 
			$wpdb->query($sql);	
		}
    }
}

//Funktion die den Ordner rekursiv ausliest. Gibt ein multidim. Array zurück.
//Slug -> Bild.jpg
function get_media_folder($sPath){
    $aRes = array();
    foreach(new DirectoryIterator($sPath) as $oItem){
		if($oItem->isDir()) {
			(!$oItem->isDot() ? $aRes[$oItem->getFilename()] = get_media_folder($oItem->getPathname()):0);
			continue;
		}
		$aRes[] = $oItem->getFilename();
	} return $aRes;
}    
	
?>
