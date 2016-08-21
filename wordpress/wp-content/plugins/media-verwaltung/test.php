<?php

?>
<div class="wrap">
<h2>
<ul class="subsubsub">
<form id="posts-filter" method="get">ev
<p class="search-box">
<input type="hidden" id="_wpnonce" name="_wpnonce" value="57a9097ce7"/>
<div class="tablenav top">

</div>	
	
<table class="wp-list-table widefat fixed striped posts">
<div class="tablenav bottom">
</form>


?>








<?php
	wp_enqueue_script('media-verwaltung');
?>

<h2> Angelegte Unternehmen </h2>

	
	<div id="anzeige-unternehmen" class="float-left">
		<button class="f-zeige-Unternehmen">Anzeigen</button>
		
		<select name="angelegte-unternehmen" id="angelegte-unternehmen" size="10" class="float-left">
		<?php 	
		$alleOrdner = get_ordner();
		
		foreach($alleOrdner as $key => $value){
			echo "<option value='" . $value . "'>" . $key ."</option>";
			
		}
		
		?>
		</select>		
	</div>
	<div id="anzeige-media" class="float-left">
	</div>
<button class="f-check-all-media">Alle Ordner einlesen</button>



<?php 

//Liefert alle Ordner samt Pfad in einem Array zur�ck.
// Ueber einen Parameter könnte die Region mitgegeben werden ???
function get_ordner() {
	
	//AUSWAHL DER REGION: später dynamisch
	$region = "Heilbronn";
	

	//Prüfung ob Server oder Localhost
	$whitelist = array('127.0.0.1', "::1");

					if(in_array($_SERVER['REMOTE_ADDR'], $whitelist)){
						$mein_pfad = $_SERVER['DOCUMENT_ROOT'] . "/wordpress/wp-content/uploads/" . $region;
					} else {
						$mein_pfad = $_SERVER['DOCUMENT_ROOT'] . "wp-content/uploads/" . $region;   
					}      				
	 
	//Url zum Bild
	$base_url = get_bloginfo("url") . "/wp-content/uploads/" . $region;	

	// Ordner auslesen und Array in Variable speichern
	$alledateien = scandir($mein_pfad); // Sortierung A-Z
	// Sortierung Z-A mit scandir($ordner, 1)

	$ordner = array();
	 
	foreach ($alledateien as $datei) {
		
		
		$dateiinfo = pathinfo($mein_pfad . "/" . $datei);
		
		if(!isset($dateiinfo['extension'])){
			
			$ordner[ $dateiinfo['basename'] ] = $base_url ."/".$dateiinfo['basename'];
			
		}
		

	}	
	return $ordner;	
}


?>