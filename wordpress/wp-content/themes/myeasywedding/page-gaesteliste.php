<?php get_header(); ?>

<?php
/*
 * Script ist bereits in der functions.php registriert.
 */	
	wp_enqueue_script('bootstrap_select');
	wp_enqueue_script('gaesteliste');

// BENUTZERVERWALTUNG		
 	$current_user = get_current_user_id();
	include_once('class/guestlist.php');
//	echo $test_user;
?>	


<div class="my-row banner-flieder">
	
	<div class="container margin-normal">
			
			<div class="text-center">
				<h1>Gästeliste</h1>
				<h3>Einladungen & Essen verwalten</h3>
			</div>
		
		</div>
		<img class="trenner-solo" src="<?php bloginfo( 'template_url' ); ?>/img/trenner-herz.png " alt="Pfeil">
</div>


<?php 

// Instanzierung der Klasse im Class Ordner. Alle dynamischen Ausgaben sind hier hinterlegt und müssen dort angepasst werden.
$gl = NEW Guestlist($current_user);	

?>

<!-- Div Container zur Berechnung von Personen und Essen -->

<div class="my-row">
	<div class="container margin-big text-center">
		<div class="col-md-6 f-gaeste">
            <!-- HTML Gerüst in der Klasse gepflegt. Parameter = Überschrift -->
			<?php echo $gl->gib_gaeste("GÄSTE"); ?>
		</div>
		<div class="col-md-6 f-essen">
            <!-- HTML Gerüst in der Klasse gepflegt. Parameter = Überschrift -->
			<?php echo $gl->gib_essen("ESSEN"); ?>
		</div>
	</div>
</div>

<div class="my-row banner-braun">
		<div class="text-center">
			<h1 class="hl-rosa">Neuer Gast</h1>
			<h3>Was? Wieviel? Warum?</h3>
		</div>
		<img class="banner-pfeile" src="<?php bloginfo( 'template_url' ); ?>/img/banner_pfeil_braun.png " alt="Pfeil">
</div>

<!-- BENUTZEREINGABE -->		
<div class="my-row">
	<div class="container margin-top">
		<div class="col-md-3 col-xs-12 liste-margin">
			<input type="text" id="vorname" class="form-control checklist-input" placeholder="Vorname" aria-describedby="basic-addon1">
		</div>
		<div class="col-md-3 col-xs-12 liste-margin">
			<input type="text" id="nachname" class="form-control checklist-input" placeholder="Nachname" aria-describedby="basic-addon1">
		</div>
		
		<div class="col-md-3 col-xs-12 liste-margin">
		  	
			<div id="kind" class="portion all-gaeste portion-kind"></div>
				  	
		</div>
		  
		<div class="col-md-2 col-xs-9 liste-margin">
			<div class="small-padding">
						<select id="essen" class="selectpicker" data-width="100%">
							<option value="Standard">Standard</option>
							<option value="Vegetarisch">Vegetarisch</option>
							<option value="Halal">Halal</option>
						</select>
			</div>
			    	  	
		</div>
		   <div class="col-md-1 col-xs-3 liste-margin">
			<button type='button' id="add-gaesteliste" class='btn btn-default float-right big-button'>
				<span class='glyphicon glyphicon-plus' aria-hidden='true'></span>
			</button>
		  </div>
	</div><!-- end container -->		
</div><!-- end row -->

<!-- BENUTZEREINGABE ENDE -->	

<!-- GÄSTELISTE -->
	<div class="my-row">
		<div id="gaesteliste-panel" class="container margin-normal">

<?php




//Prüft ob die Gästeliste leer ist. Wenn ja werden Dummy Werte gesetzt. Muss als Object übergeben werden.
if(empty($gl->db_result)){
	$guestlist[0]= (object)array("id"=>"1", "nachname"=> "Mustermann","vorname"=> "Max", "portion"=> "Erwachsener", "essen"=> "Standard", "status"=> "offen");
	
    //Übergibt die Dummy-Werte an die Klassenvariable.
	$gl->set_gaesteliste($guestlist);
}
	
	//Komplettes HTML Gerüst wird in der Klasse hinterlegt
	echo $gl->gib_gaesteliste();

//  TESTAUSGABEN	
//  print_r($gl);
//  print_r($guestlist);        
            
?>		
		
		</div>
	</div>

	
<?php get_footer(); ?>