<?php get_header(); ?>

<?php
/*
 * Script ist bereits in der functions.php registriert.
 */	
	wp_enqueue_script('bootstrap_select');
	wp_enqueue_script('gaesteliste');

// BENUTZERVERWALTUNG		
 	$test_user = get_current_user_id();
//	echo $test_user;
include_once('class/guestlist.php');

?>	


<div class="my-row banner-flieder banner-head no-margin">
	
	<div class="container">
			
			<div class="mew-categorie">
				<h1 class='margin-small'>Gästeliste</h1>
				<h3>Einladungen & Essen verwalten</h3>
			</div>
		
		</div>
		<img class="trenner-herz" src="<?php bloginfo( 'template_url' ); ?>/img/trenner-herz.png " alt="Pfeil"></img>
</div>


<?php 

// FUNKTIONSAUFRUFE
	
// Liest die DB aus und gibt die Checkliste je Benutzer aus.	
	$json_array= get_gaesteliste_by_userID($test_user);
// Berechnung der Gästeliste
	berechne_gaesteliste($json_array);
	$gl = NEW Guestlist($json_array);


// TESTAUSGABEN	
	//print_r($berechnung_gaeste);
	//echo $test_user;
	//print_r(array_count_values($berechnung_gaeste));
	//print_r($json_array);
?>

<!-- Div Container zur Berechnung von Personen und Essen -->

<div class="my-row">
	<div class="container bv-wrapper">
		<div class="col-md-6">
			<h1>GÄSTE</h1>
			<div class="col-md-4">
				<?php echo $gl->zusage; ?>
			</div>
			<div class="col-md-4">
				<?php echo $gl->absage; ?>
			</div>
			<div class="col-md-4">
				<?php echo $gl->offen; ?>
				
			</div>
		</div>
		<div class="col-md-6">
			<h1>ESSEN</h1>
			<div class="col-md-4">
				<?php echo $gl->normal_small; ?>
			</div>
			<div class="col-md-4">
				b
			</div>
			<div class="col-md-4">
				c
			</div>
		</div>
	</div>
</div>

<div class="row">

	<div class="col-sm-5 col-xs-11 gast-border gast-color-b">
			<div class="hidden-sm hidden-md hidden-lg gast-horizontal gast-color-b"> 
				<h2 class="gast-horizontal-text gast-text-color-a">ESSEN</h2>
				
			</div>
			<div class="hidden-xs gast-vertikal gast-height float-left gast-color-b">
				<h2 class="gast-vertikal-text-a gast-text-color-a">ESSEN</h2>
				
			</div>
			<div class="gast-box gast-height gast-breite-a float-left gast-color-a gast-text-color-b">  
				STANDARD: <br />
				VEGETARISCH: <br />
				VEGAN: <br />
				HALAL: <br />
			</div>
			<div class="gast-box gast-height gast-breite-b gast-color-a gast-text-color-b">
								
				<?php 
				if(isset($berechnung_gaeste_zusage["Standard"])){
					$zusage = $berechnung_gaeste_zusage["Standard"];
				} else $zusage = 0; 
						
				if (isset( $berechnung_gaeste_offen["Standard"] )) {
					$offen = $berechnung_gaeste_offen["Standard"]; 
				} else $offen = 0;				
				
				echo $zusage . " ( ". $offen ." )";
				?><br />
				<?php 
				if(isset($berechnung_gaeste_zusage["Vegetarisch"])){
					$zusage = $berechnung_gaeste_zusage["Vegetarisch"];
				} else $zusage = 0; 
						
				if (isset( $berechnung_gaeste_offen["Vegetarisch"] )) {
					$offen = $berechnung_gaeste_offen["Vegetarisch"]; 
				} else $offen = 0;				
				
				echo $zusage . " ( ". $offen ." )";
				?><br />
				<?php 
				if(isset($berechnung_gaeste_zusage["Vegan"])){
					$zusage = $berechnung_gaeste_zusage["Vegan"];
				} else $zusage = 0; 
						
				if (isset( $berechnung_gaeste_offen["Vegan"] )) {
					$offen = $berechnung_gaeste_offen["Vegan"]; 
				} else $offen = 0;				
				
				echo $zusage . " ( ". $offen ." )";
				?><br />
				<?php 
				if(isset($berechnung_gaeste_zusage["Halal"])){
					$zusage = $berechnung_gaeste_zusage["Halal"];
				} else $zusage = 0; 
						
				if (isset( $berechnung_gaeste_offen["Halal"] )) {
					$offen = $berechnung_gaeste_offen["Halal"]; 
				} else $offen = 0;				
				
				echo $zusage . " ( ". $offen ." )";
				?><br />
				
			</div>
			<div class="gast-color-b clear-both">
				<p class="gast-small-hint"> ZUGESAGT (OFFEN) </p>
			</div>	
	</div>
</div>

<!-- Ende Berechnung-->

<!-- Progressbar Anfang -->	
	<div class="row">
		  <div class="col-xs-12">
						<h4>Übersicht <?php if(isset( $gaeste )){ echo " - ". $gaeste . " Einladung(en)" ; } ?></h4>
						<div class="progress">
					 	 <div class="progress-bar progress-bar-zusage" style="width: <?php echo $zusage_prozent ?>%">
						<?php if($zusage_prozent > 10) { 
						echo "<span class='glyphicon glyphicon-thumbs-up' aria-hidden='true'></span>";
						}
						?>
						
					  	</div>
					  	<div class="progress-bar progress-bar-absage" style="width: <?php echo $absage_prozent ?>%">
						<?php if($absage_prozent > 10) { 
						echo "<span class='glyphicon glyphicon-thumbs-down' aria-hidden='true'></span>";
						}
						?>
					 	 </div>
					 	 <div class="progress-bar progress-bar-offen progress-bar-striped" style="width: <?php echo $offen_prozent ?>%">
						offen
					  	</div>
					  
						
				</div>
				
		  </div>
	</div>

<!-- Progressbar Ende -->

	<hr />

<!-- TESTAUSGABE -->		
	<div id="test-ausgabe"></div>
<!-- TESTAUSGABE ENDE -->	

<!-- BENUTZEREINGABE -->		
<div class="row">
		  <div class="col-md-3 col-xs-12 liste-margin">
				<div class="panel panel-default">
					<div class="panel-heading">
						Vorname
					</div>
					<div class="panel-body small-padding">
						<input type="text" id="vorname" class="form-control " placeholder="Max" aria-describedby="basic-addon1">
					</div>
				</div>
			</div>
		  <div class="col-md-3 col-xs-12 liste-margin">
		  		<div class="panel panel-default">
					<div class="panel-heading">
						Nachname
					</div>
					<div class="panel-body small-padding">
						<input type="text" id="nachname" class="form-control " placeholder="Mustermann" aria-describedby="basic-addon1">
					</div>
				</div>	  	
		  </div>
		  <div class="col-md-3 col-xs-12 liste-margin">
				<div class="panel panel-default">
					<div id="portionsgroesse" class="panel-heading">
						Portion - Erwachsener
					</div>
					<div class="panel-body small-padding">
						<div id="erwachsen" class="portion all-gaeste portion-erwachsen"></div>	
						<div id="kind" class="portion all-gaeste portion-kind"></div>
						<div id="kleinkind" class="portion all-gaeste portion-kleinkind"></div>
					</div>
				</div>
			</div>
		  <div class="col-md-2 col-xs-9 liste-margin">
				<div class="panel panel-default">
					<div class="panel-heading">
						Essenstyp
					</div>
					<div class="panel-body small-padding">
						<select id="essen" class="selectpicker" data-width="100%">
							<option value="Standard">Standard</option>
							<option value="Vegetarisch">Vegetarisch</option>
							<option value="Vegan">Vegan</option>
							<option value="Halal">Halal</option>
						</select>
					</div>
				</div>
			    	  	
		  </div>
		   <div class="col-md-1 col-xs-3 liste-margin">
			<button type='button' id="add-gaesteliste" class='btn btn-default float-right big-button'>
				<span class='glyphicon glyphicon-plus' aria-hidden='true'></span>
			</button>
		  </div>
	</div><!-- end row -->

<!-- BENUTZEREINGABE ENDE -->	


	<hr />

<!-- GÄSTELISTE -->
	<div class="panel panel-default gl-overflow">
		<div class="row"  id="gaesteliste-panel">

<?php
// TESTAUSGABEN	
//	print_r($_POST);
//	print_r($_REQUEST);

//Prüft ob die Gästeliste leer ist.

if(empty($json_array)){
	$json_array[0]= array("nachname"=> "Mustermann","vorname"=> "Max", "portion"=> "Erwachsener", "essen"=> "Standard", "status"=> "offen");
}


//Sortiert das Multidim-Array nach der ersten Spalte Vorname
		array_multisort($json_array);

//var_dump($json_array);
		$status ="";
		if(isset($key['status'])) {
			$key_status = $key['status']; 
		} else $key_status = '';
		 
		foreach ($json_array as $key) {
			
			if(isset($key['status'])) {
				$key_status = $key['status']; 
			} else $key_status = '';
			
			switch ($key_status) {
				case 'zusage':
					$status = "bg-zusage";
					break;
				case 'absage':
					$status = "bg-absage";
					break;
				case 'offen':
					$status = "bg-offen";
					break;
			}
			
			echo 	"<div class='gl-padding ". $status ." f-gaesteliste'>" .
							"<div class='col-md-4 col-xs-12'>".
								"<div class='float-left' id='gaesteliste_nachname'>".
								"<p class='text-middle'>" . $key['nachname'] . "</p>" .
								"</div>".
								"<div class='float-left'>".
								"<p>,&nbsp; </p>" .
								"</div>".
								"<div class='float-left' id='gaesteliste_vorname'>".
								"<p>" . $key['vorname'] . "</p>" .
								"</div>".
							"</div>".
							"<div class='col-md-4 col-xs-12'>".
								"<div class='float-left' id='gaesteliste_portion'>".
								"<p>" . $key['portion'] . "</p>" .
								"</div>".
								"<div class='float-left'>".
								"<p>&nbsp;&nbsp; - &nbsp;&nbsp;</p>".
								"</div>".
								"<div class='float-left' id='gaesteliste_essen'>".
								"<p>" . $key['essen'] . "</p>" .
								"</div>".
							"</div>".
							"<div class='col-md-4 col-xs-12'>".	
							
								"<button type='button' class='btn btn-default float-right gast-icon-delete delete'>".
					  				"<span class='glyphicon glyphicon-trash' aria-hidden='true'></span>".
					  			"</button>".
					  			"<button type='button' class='btn btn-default gast-icon-status float-right absage'>".
					  				"<span class='glyphicon glyphicon-thumbs-down' aria-hidden='true'></span>".
					  			"</button>".
								"<button type='button' class='btn btn-default gast-icon-status float-right zusage'>".
					  				"<span class='glyphicon glyphicon-thumbs-up' aria-hidden='true'></span>".
					  			"</button>".
					  			
					  		"</div>".
							"<div class='col-md-12 col-xs-12'>".
							"<hr class='short-hr' />".
							"</div>".
				  			"<div class='clear-both'></div>".
				  		"</div>";
								
		}

?>		
		
		</div>
	</div>
</main><!-- .site-main -->	
		
<?php
/*
* Holt sich die Gästeliste des angemeldeten Users im JSON Format
* Tablename und Spaltenname müssen mit der DB überinstimmen.
*/
	function get_gaesteliste_by_userID( $userID )
	{
		global $wpdb;

		$table_name = $wpdb->prefix . 'gaesteliste';

		$row = $wpdb->get_row( $wpdb->prepare('SELECT * FROM '.$table_name.' WHERE userID = %s', $userID) );
		
		$json = $row->gaesteliste;
		
		$json= stripslashes($json);
		
		$json_array = json_decode($json, true);
		
		return $json_array;
	}
	

//Klasse einführen?	
	function berechne_gaesteliste( $json_array ) {
	
		global $gaeste;
		global $gaeste_zusage;
		global $gaeste_offen;
		global $berechnung_gaeste;
		global $berechnung_gaeste_zusage;
		global $berechnung_gaeste_offen;
		global $zusage_prozent;
		global $absage_prozent;
		global $offen_prozent;
		
		
		$gaeste = 0;
				
		$berechnung_gaeste = array();
		
		$arr = $json_array;
			foreach ($arr as $key => $value){
			    foreach ($value as $key2 => $value2){
			        $index = $value2;
			        if (array_key_exists($index, $berechnung_gaeste)){
			            $berechnung_gaeste[$index]++;
			        } else {
			            $berechnung_gaeste[$index] = 1;
			        }
			    }
				$gaeste++;
			}
			
//		print_r($arr);
		
		$gaeste_zusage = 0;
		
		$berechnung_gaeste_zusage = array();
			foreach ($arr as $key => $value){
				if(isset($value['status']) && $value['status'] == 'zusage'){	
			    	foreach ($value as $key2 => $value2){
			        	$index = $value2;
			        	if (array_key_exists($index, $berechnung_gaeste_zusage)){
			        	    $berechnung_gaeste_zusage[$index]++;
			        	} else {
			        	    $berechnung_gaeste_zusage[$index] = 1;
			        	}
			   	 }
				$gaeste_zusage++;
				}
			}
		
		$gaeste_offen = 0;
			
		$berechnung_gaeste_offen = array();
			foreach ($arr as $key => $value){
				if(isset($value['status']) && $value['status'] == 'offen'){	
			    	foreach ($value as $key2 => $value2){
			        	$index = $value2;
			        	if (array_key_exists($index, $berechnung_gaeste_offen)){
			        	    $berechnung_gaeste_offen[$index]++;
			        	} else {
			        	    $berechnung_gaeste_offen[$index] = 1;
			        	}
			   	 }
				$gaeste_offen++;
				}
			}	
		
//print_r($berechnung_gaeste_offen);		
		
		if($gaeste == 0){ $gaeste = 1; }

		if(isset($berechnung_gaeste["absage"])) {
			$gaeste_absage = $berechnung_gaeste["absage"];
		}else $gaeste_absage = 0;
		
		$zusage_prozent = 0;
		$absage_prozent = 0;
		$offen_prozent = 0;

		
	
		$zusage_prozent = ($gaeste_zusage/$gaeste)*100;
		$absage_prozent = ($gaeste_absage/$gaeste)*100;
		$offen_prozent = ($gaeste-($gaeste_zusage+$gaeste_absage))/$gaeste*100;	
	}
	
?>	
	
<?php get_footer(); ?>