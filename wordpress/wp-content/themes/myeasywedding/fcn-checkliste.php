<?php
//Wechselt den Pfad zwischen Local und WEB:
include_once("whitelist.php");

 	global $wpdb;

	$user 		= get_current_user_id();
	
	if($user == 0){
		echo "Anmeldefehler";	
		return;
	}


/*
*       SWITCH-BLOCK zur Steuerung der richtigen Funktion
*/
if (isset($_POST['fcn'])){
    $uebergabeparameter = $_POST['fcn'];
}else $uebergabeparameter = "ERROR";


switch ($uebergabeparameter) {
    case "check_insert_anzeige":
        $rueckgabe = true;
        insertChecklist($user, $rueckgabe);
        break;
        
    case "check_delete_anzeige":
        $rueckgabe = true;
        deleteCheckliste($user, $rueckgabe);
        break;
        
    default:
        break;
}
    


/*
*       SEITEN-FUNKTIONEN
*/

function gibTermineAuszug(){
//Funktionsaufruf zur Checklistabfrage aus der DB.    
$checklist= get_checklist_by_user(get_current_user_id());   

    
//print_r($checklist);    
    
    
// Prüft ob die Checkliste leer ist und befüllt dann initial.	
if(empty($checklist)){
	$checklist[0]= (object)array("id" => "1", "beschreibung"=> "Hier könnte dein toDo stehen..", "prio"=> "Dringend", "datum"=> "23.06.2016", "status" => "offen");
}
    

usort($checklist, "sortFunction");

//Zeige nur die X ersten Einträge
$checklist_ex = array_slice($checklist, 0, 4);

print_r($json_array);
    
    
$zm = true;
$auszug='';
                
            foreach ($checklist_ex as $key) {
                //Zeilen im Wechsel farbig abheben:
                if($zm){
                    $marker = "zeilenmarker";
                    $zm = false;
                }else{
                    $marker = '';
                    $zm = true;
                } 
                
                $prio= $key->prio;
                
                if($key->prio != '' ) {
                  $prio = '<span class="glyphicon glyphicon-fire" aria-hidden="true"></span>';
                }

                
                
//HereDOC Schreibweise:			
$auszug .= <<<DOC
<div class="col-md-offset-2 col-md-8 col-xs-12 prev-termin-zeile {$marker}">
		<div class="col-sm-3 col-xs-12 cr1"><span class="glyphicon glyphicon-time margin-right  hl-rosa" aria-hidden="true"></span>
			{$key->datum}
		</div>
		<div class="col-sm-6 col-xs-12 cr2">
			{$key->beschreibung}
		</div>
        <div class="col-sm-3 col-xs-12 cr3 hl-rosa">
			{$prio}
		</div>
		
		<div class="clear-both">
		</div>
</div>
DOC;
            }
    
    return  $auszug;   
} 

function gibTermineAlle(){
    
//Funktionsaufruf zur Checklistabfrage aus der DB.    
$checklist= get_checklist_by_user(get_current_user_id());   

    
//print_r($checklist);    
    
    
// Prüft ob die Checkliste leer ist und befüllt dann initial.	
if(empty($checklist)){
	$checklist[0]= (object)array("id" => "1", "beschreibung"=> "Hier könnte dein toDo stehen..", "prio"=> "Dringend", "datum"=> "23.06.2016", "status" => "offen");
}
    

usort($checklist, "sortFunction");
    
                $zm = true;
		foreach ($checklist as $key) {
            //Zeilen im Wechsel farbig abheben: 
            if($zm){
                    $marker = "zeilenmarker";
                    $zm = false;
                }else{
                    $marker = '';
                    $zm = true;
                }
            
            if($key->prio != ''){
                $prio = '<span class="glyphicon glyphicon-fire" aria-hidden="true"></span>';
            }else $prio = '';
			
//HereDOC Schreibweise:
$termine .= <<<DOC
<div class="col-md-12 f-checklist text-center prev-termin-zeile {$marker}">
							<div id="{$key->id}" class='checkliste_id'></div>
							<div class="col-md-2 col-sm-3 col-xs-12 f-liste-datum cr1"><span class="glyphicon glyphicon-time margin-right" aria-hidden="true"></span>
							{$key->datum}
							</div>
							<div class="col-md-8 col-sm-5 col-xs-12 f-liste-beschreibung cr2">
							{$key->beschreibung}
							</div>
							<div class="col-md-1 col-sm-2 col-xs-12 f-liste-prio cr3">
							{$prio}
							</div>
							
							<div class="col-md-1 col-sm-2 col-xs-12 cr4"><button type="button" class="checklist-erledigt text-center f-delete">
				  				<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
				  			</button></div>
				  			<div class="clear-both"></div>
				  		</div>
DOC;
								
		}
    
    return $termine;
}

function sortFunction( $a, $b ) {
//Sortiert das Array nach dem Datum. Timestamp geht nur bis 2038.
    return strtotime($a->datum) - strtotime($b->datum);
}





/*
*       DATENBANK-ABFRAGEN
*/

function insertChecklist($user, $rueckgabe){
    
    global $wpdb;
    
    $prio 			= $_POST['prio'];
	$beschreibung 	= $_POST['beschreibung'];
	$datum 			= $_POST['datum'];
	$status			= $_POST['status'];
    
    //Bloß keine ID bei autoincrement mitgeben!!!

	$wpdb->insert( 
		'wp_checklist', 
		array( 
			
            'userID' 		=> $user,
            'beschreibung' 	=> $beschreibung,
            'prio' 			=> $prio,
            'datum' 		=> $datum,
            'status' 		=> $status,
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
			'%s'
		) 

	);

    //Gibt die ID zurück an JS.     
   // return $wpdb->insert_id;
   
    if($rueckgabe){
        //Gibt die Termine mit echo aus damit sie via Ajax ausgespielt werden können.    
        echo gibTermineAlle();  
    }
    
    
    
}

function updateCheckliste(){
    global $wpdb;

	$user	= get_current_user_id();
	$id  	= $_POST['id'];
	$status = $_POST['status'];
	

//Bloß keine ID bei autoincrement mitgeben!!!

	$wpdb->update( 
		'wp_guestlist', 
		array( 
			
           	'status' 		=> $status
            
		), 
		array( 
			'ID' 		=> $id,
			'userID'	=> $user
		), 
		array( 
				
			'%s'
		), 
		array( '%s','%s' ) 
	);
    
}

function deleteCheckliste($user, $rueckgabe){

    global $wpdb;

	$id  	= $_POST['id'];

//Bloß keine ID bei autoincrement mitgeben!!!

	$wpdb->delete( 
		'wp_checklist', 
		array( 
			
           	'id' 		=> $id,
			'userID'	=> $user
            
		),  
		array( '%d','%d' ) 
	);
    
    if($rueckgabe){
        //Gibt die Termine mit echo aus damit sie via Ajax ausgespielt werden können.    
        echo gibTermineAlle();  
    }
}

function get_checklist_by_user( $userID){
    global $wpdb;

    $table_name = $wpdb->prefix . 'checklist';

	$result = $wpdb->get_results( $wpdb->prepare('SELECT id, userID, beschreibung, prio, datum, status FROM '.$table_name.' WHERE userID = %s', $userID));
		
	return $result;
}


?>