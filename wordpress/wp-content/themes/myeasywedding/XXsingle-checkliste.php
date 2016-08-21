<?php get_header(); ?>



<?php
	//Script einbinden
	wp_enqueue_script('bootstrap_select');
	
	// Ruft den Inhalt der Seite ab.
	if (have_posts()){
	 while (have_posts()) : the_post();
		the_title( '<h3>', '</h3>' );
	 	
	 	the_content();
	 endwhile;
	} 
	
?>

<div id="primary" class="container"> <!-- Schließt im Footer -->

	<div class="row">
		<form action="<?php echo get_permalink(); ?>" method="post">
		<div class="col-md-2">
			<label for="testuser">Test-User </label>
		</div>
		<div class="col-md-8">
		
		
		
			<select id="testuser" name="testuser" class="selectpicker" data-width="100%">
		       <option value="Max123" <?php if(isset($_POST["testuser"]) && ($_POST["testuser"]== "Max123")) echo 'selected="selected"';    ?> >Max123</option>
		       <option value="Demel" <?php if(isset($_POST["testuser"]) && ($_POST["testuser"]== "Demel")) echo 'selected="selected"';    ?>  >Demel</option>
		       <option value="Ruedinger" <?php if(isset($_POST["testuser"]) && ($_POST["testuser"]== "Ruedinger")) echo 'selected="selected"';  ?> >Rüdinger</option>
		    </select>
		</div>
		<div class="col-md-2">		    	
			<input type="submit" name="sava_data" class="btn btn-default" value="ok" />
		</div>
		</form>			    	
	</div>
	<hr />
	
	<div id="test-ausgabe"></div>
	
	<div class="row">
		  <div class="col-md-4">
		  		
		    	<div class="input-group br-width-a">
					  <span class="input-group-addon br-width">Nachname</span>
					  <input type="text" id="nachname" class="form-control " placeholder="Nachname" aria-describedby="basic-addon1">
				</div>
		    	  		
		  </div>
		  <div class="col-md-3">
		  		
		    	<div class="input-group br-width-a">
					  <span class="input-group-addon br-width">Vorname</span>
					  <input type="text" id="vorname" class="form-control " placeholder="Vorname" aria-describedby="basic-addon1">
				</div>	  	
		  </div>
		  <div class="col-md-2">
		  		<div class="input-group br-width-a">
					Button Erwachsener - Button Kind
				</div>	
		  </div>
		  <div class="col-md-2">
		  
			    <select id="prio" class="selectpicker" data-width="100%">
		                <option value="1">Standard</option>
		                <option value="2">Vegan</option>
		                <option value="3">Halal</option>
		    	</select>	  	
		  </div>
		   <div class="col-md-1"> 
			    <div class="input-group">
					  <button type="button" id="test" class="btn btn-default"><span class="glyphicon glyphicon-pencil" aria-hidden="true"> </span></button>
				</div>	  	
		  </div>
	</div><!-- end row --> 
	
	<hr />

	<!-- Aufbau Gästeliste -->
	<div class="panel panel-default">
		<div class="row"  id="checkliste-panel">

<?php
	//	print_r($_POST);
//	print_r($_REQUEST);
	
	
	if (isset($_POST["testuser"])){
		$test_user = $_POST["testuser"];
	} else $test_user = "Max123";
	
	//echo $test_user;
	
		// Liest die DB aus und gibt die Checkliste je Benutzer aus.	
		$json_array= get_gaesteliste_by_userID($test_user);
		
		//Sortiert das Multidim-Array nach der ersten Spalte in dem Fall Prio
		array_multisort($json_array);
		
		foreach ($json_array as $key) {
			
			echo 	"<div class='col-md-12 panel-body'>" .
							"<div class='col-md-1 col-xs-1' id='checkliste_prio'>".
							$key['nachname'] .
							"</div>".
							"<div class='col-md-8 col-xs-11' id='checkliste_todo'>".
							$key['vorname'].
							"</div>".
							"<div class='col-md-2 col-xs-6' id='checkliste_datum'>".
							$key['typ'].
							"</div>".
							
							"<div class='col-md-1 col-xs-6'><button type='button' class='btn btn-default float-right delete'>".
				  				"<span class='glyphicon glyphicon-trash' aria-hidden='true'></span>".
				  			"</button></div>".
				  		"</div>".		
						"<hr class='short-hr' />";
								
		}

?>		
		
		</div>
	</div>
		
		
<?php

	//Holt sich die Gästeliste des angemeldeten Users im JSON Format
	// Tablename und Spaltenname müssen mit der DB überinstimmen.
	function get_gaesteliste_by_userID( $userID)
	{
		global $wpdb;

		$table_name = $wpdb->prefix . 'gaesteliste';

		$row = $wpdb->get_row( $wpdb->prepare('SELECT * FROM '.$table_name.' WHERE userID = %s', $userID) );
		
		$json = $row->gaesteliste;
		
		$json= stripslashes($json);
		
		$json_array = json_decode($json, true);
		
		return $json_array;
	}

?>	
	
<?php get_footer(); ?>