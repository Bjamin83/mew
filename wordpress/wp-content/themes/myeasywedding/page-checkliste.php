<?php get_header(); ?>

<?php 
/*
 * Script ist bereits in der functions.php registriert.
 */		
		wp_enqueue_script('bootstrap_select');
		wp_enqueue_script('checkliste');
        wp_enqueue_script('jquery_ui');

include_once("fcn-checkliste.php");
?>		

<div class="my-row bg-rotbraun">
	
	<div class="container margin-top-normal">
			
			<div class="text-center">
				
				<h1 class='margin-small title-rotbraun flex-font1'>Checkliste</h1>
				<h3 class='margin-small hl-white flex-font3'>Aufgaben planen & verwalten</h3>
				
			</div>
		
		</div>
    <div class="trenner-wrapper bg-rotbraun">
		<img class="trenner-liste" src="<?php bloginfo( 'template_url' ); ?>/img/checklist_icon.png " alt="Pfeil">
    </div>
</div>
<div class="my-row">
		<div class="text-center margin-big">
			<h2 class="hl-rosa">Nächsten Termine</h2>
			<div class="container f-termine-auszug">
			
			<?php
			echo gibTermineAuszug();
			?>
			
			</div>
			
		</div>
		<img class="banner-pfeile" src="<?php bloginfo( 'template_url' ); ?>/img/banner_pfeil.png " alt="Pfeil">
</div>
<div class="my-row bg-hellgrau">
		<div class="text-center margin-big">
			<h2 class="hl-rosa">Neue Aufgabe</h2>
			<h3>Was? Wann?</h3>
		</div>
		<img class="banner-pfeile" src="<?php bloginfo( 'template_url' ); ?>/img/banner_pfeil_braun.png " alt="Pfeil">
</div>
<div class="my-row bg-rosa">
	<div class="container margin-big">
        
		<div class="col-xs-12 col-sm-12 liste-margin">
			<input type="text" id="f-checkliste-beschreibung" class="form-control checklist-input" placeholder="Notizen und Beschreibung der Aufgabe" aria-describedby="basic-addon1">
		</div>
		<div class="col-xs-12 col-sm-4 liste-margin">
				<button type='button' id="f-checkliste-prio" class='checklist-dringend text-center'>
<!-- span class wird über js eingefügt-->					
					Dringend <span id="f-prio-check" class="" aria-hidden="true"></span>
					<input type="hidden" id="f-prio-hidden" value="" />
				</button>
				
				
		</div>
		<div class="col-xs-12 col-sm-4 liste-margin">
					<div class="datecover-wrapper">
						<div class="datecover"></div>
					</div>
					<input type="text" id="f-checkliste-date" class="form-control checklist-input" placeholder="Fällig bis (Datum)" aria-describedby="basic-addon2">
				    <!-- Image kommt über JS   -->		
				
					
		</div>
		<div class="col-xs-12 col-sm-4 liste-margin">
				<button type='button' id="f-add-checkliste" class='checklist-submit text-center'>
					<span aria-hidden='true'> Aufgabe hinzufügen</span>
					
				</button>
				
		</div>
			
			
	</div>
		<img class="banner-pfeile" src="<?php bloginfo( 'template_url' ); ?>/img/banner_pfeil_rosa.png " alt="Pfeil">
</div>	   

<div class="my-row">
		<div class="text-center margin-big">
			<h2 class="hl-rosa">Aufgaben</h2>
			<h3>Deine Termine in der Übersicht</h3>
		</div>
</div>		
	
<div class="my-row">	  
	<div class="container margin-big"  id="checkliste-panel">
<?php

 echo gibTermineAlle();


	
?>
		</div>
  	</div>    
 			
		
<?php get_footer(); ?>