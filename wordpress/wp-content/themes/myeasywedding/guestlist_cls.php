<?php
    
class Guestlist {
	
	var $zusage = 0;
	var $absage = 0;
	var $offen = 0;
	var $gesamtGaeste = 0;
	var $normal = 0;
	var $normal_small = 0;
	var $vegi = 0;
	var $vegi_small = 0;
	var $vega = 0;
	var $vega_small = 0;
	var $halal = 0;
	var $halal_small = 0;
	var $db_result;
	var $berechnung_gaeste_offen;
	var $berechnung_gaeste_zusage;
	var $berechnung_gaeste_absage;
	
	
	
	// Die Schleifen zählen alle Einträge im Array und wie oft dieser Wert vorkommt.
	
	function __construct($userID){
		
		$arr = $this->get_db_by_user($userID);
		
					
		$this->berechnung_gaeste = array();
				
			foreach ($arr as $key => $value){
			    foreach ($value as $key2 => $value2){
			        $index = $value2;
			        if (array_key_exists($index, $this->berechnung_gaeste)){
			            $this->berechnung_gaeste[$index]++;
			        } else {
			            $this->berechnung_gaeste[$index] = 1;
			        }
			    }
				$this->gesamtGaeste++;
			}
			
//		print_r($arr);
		
		$this->berechnung_gaeste_zusage = array();
		
			foreach ($arr as $key => $value){
				if(isset($value->status) && $value->status == 'zusage'){	
			    	foreach ($value as $key2 => $value2){
			        	$index = $value2;
			        	if (array_key_exists($index, $this->berechnung_gaeste_zusage)){
			        	    $this->berechnung_gaeste_zusage[$index]++;
			        	} else {
			        	    $this->berechnung_gaeste_zusage[$index] = 1;
			        	}
			   	 }
				$this->zusage++;
				}
			}
			
		$this->berechnung_gaeste_absage = array();
		
			foreach ($arr as $key => $value){
				if(isset($value->status) && $value->status == 'absage'){	
			    	foreach ($value as $key2 => $value2){
			        	$index = $value2;
			        	if (array_key_exists($index, $this->berechnung_gaeste_absage)){
			        	    $this->berechnung_gaeste_absage[$index]++;
			        	} else {
			        	    $this->berechnung_gaeste_absage[$index] = 1;
			        	}
			   	 }
				$this->absage++;
				}
			}	
		

		$this->berechnung_gaeste_offen = array();
		
			foreach ($arr as $key => $value){
				if(isset($value->status) && $value->status == 'offen'){	
			    	foreach ($value as $key2 => $value2){
			        	$index = $value2;
			        	if (array_key_exists($index, $this->berechnung_gaeste_offen)){
			        	    $this->berechnung_gaeste_offen[$index]++;
			        	} else {
			        	    $this->berechnung_gaeste_offen[$index] = 1;
			        	}
			   	 }
				$this->offen++;
				}
			}
		
		$this->berechne_essen($arr);
	}

	
	
/*
* Holt sich die Gästeliste des angemeldeten Users.
*/
	function get_db_by_user( $userID )
	{
		global $wpdb;

		$table_name = $wpdb->prefix . 'guestlist';

		$result = $wpdb->get_results( $wpdb->prepare('SELECT id, userID, vorname, nachname, portion, essen, status FROM '.$table_name.' WHERE userID = %s', $userID) );
		
		$this->db_result = $result;
		
		return $result;
	}
	
	//Wenn noch keine Einträge vorhanden sind werden Dummy Werte gesetzt.
	function set_gaesteliste($liste){
		
		$this->db_result = $liste;
	}
		
	function berechne_essen($guestlist_array) {
		foreach($guestlist_array as $key => $value){
			if(isset($value->status) && $value->status == 'zusage'){
					
				if($value->essen == 'Standard'){
					if($value->portion == 'Erwachsener'){
						$this->normal++;
					} else $this->normal_small++; 
				}
				
				if($value->essen == 'Vegetarisch'){
					if($value->portion == 'Erwachsener'){
						$this->vegi++;
					} else $this->vegi_small++; 
				}  
				
				if($value->essen == 'Halal'){
					if($value->portion == 'Erwachsener'){
						$this->halal++;
					} else $this->halal_small++; 
				}				
			}	
		
		}
	}

	function gib_gaeste($headline){
			
		$gaeste_div = '	<h1>'. $headline .'</h1>
						<div class="col-md-4">'
						. $this->zusage .
						'</div>
						<div class="col-md-4">'
						. $this->absage .
						'</div>
						<div class="col-md-4">'
						. $this->offen .
						'</div>';
		
		return $gaeste_div;
	}	

	function gib_essen($headline){
		$essen_div = '	<h1>'. $headline .'</h1>
						<div class="col-md-4">'
						. $this->normal . " / " . $this->normal_small .
						'</div>
						<div class="col-md-4">'
						. $this->vegi . " / " . $this->vegi_small .
						'</div>
						<div class="col-md-4">'
						. $this->halal . " / " . $this->halal_small .
						'</div>';
		
		return $essen_div;
		
	}
	
	function gib_gaesteliste(){
		
			$ausgabe = '';
			
			$liste = $this->db_result;
			
			foreach ($liste as $key) {
			
			$status = $key->status;
			
			switch ($status) {
				case 'zusage':
					$status = "bg-zusage";
					break;
				case 'absage':
					$status = "bg-absage";
					break;
				default:
					$status = "bg-offen";
					break;
			}
			
//HereDoc Schreibweise
$ausgabe .= <<<DOC
<div class="gl-padding $status f-gaesteliste">
	<div id="{$key->id}" class="gaesteliste_id">
	</div>
	<div class="col-md-4 col-xs-12">
		
		<button type="button" class="btn btn-default gast-icon-status float-left f-zusage">
			<span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span>
		</button>
		<button type="button" class="btn btn-default gast-icon-status float-left f-absage">
			<span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span>
		</button>
		<button type="button" class="btn btn-default gast-icon-status float-left f-offen">
			<span class="glyphicon glyphicon-hourglass" aria-hidden="true"></span>
		</button>
		<div class="float-left" id="gaesteliste_nachname">
			<p class="text-middle">{$key->nachname}</p>
		</div>
		<div class='float-left'>
			<p>,&nbsp; </p>
		</div>
		<div class="float-left" id="gaesteliste_vorname">
			<p class="text-middle">{$key->vorname}</p>
		</div>
		
	</div>
	<div class="col-md-4 col-xs-12">
		<div class="float-left" id="gaesteliste_portion">
			<p class="text-middle">{$key->portion}</p>
		</div>
		<div class='float-left'>
			<p>&nbsp;&nbsp; - &nbsp;&nbsp;</p>
		</div>
		<div class="float-left" id="gaesteliste_essen">
			<p class="text-middle">{$key->essen}</p>
		</div>
	</div>
	<div class='col-md-4 col-xs-12'>
		<button type='button' class='btn btn-default gast-icon-delete float-right f-delete'>
			<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
		</button>
		
	</div>
	<div class="col-md-12 col-xs-12">
		<hr class="short-hr" />
	</div>
	<div class="clear-both"></div>
</div>
DOC;
								
		}

return $ausgabe;

}
	
	
} 


	if(isset($_POST['update']) && $_POST['update'] == 'gaeste'){
        
        //Pfad
$whitelist = array('127.0.0.1', "::1");
 
if(in_array($_SERVER['REMOTE_ADDR'], $whitelist)){
include_once($_SERVER['DOCUMENT_ROOT'].'/wordpress/wp-load.php' );
	
} else {
include_once($_SERVER['DOCUMENT_ROOT'].'wp-load.php' );
}

 	global $wpdb;
        
		$update = new Guestlist(get_current_user_id());
		
		echo $update->gib_gaeste("GÄSTE");
	}


   
    
?>