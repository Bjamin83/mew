<?php
    wp_enqueue_script('media-verwaltung');
    ?>
     
    <h2> Media Verwaltung der Unternehmen</h2>
	<div id="mew-feedback"></div> 
    <div class="tablenav top">
     
    <?php	
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
     
    ?><select id="Regionenfilter" name="Regionenfilter"><option value="">Region wählen</option>
    <?php
     
    $current_v = isset($_GET['Regionenfilter'])? $_GET['Regionenfilter']:'';
    foreach ($values as $region => $num_occ) {
    printf
    (
    '<option value="%s" %s>%s</option>',
    $region,
    $region == $current_v ? ' selected="selected"':'',
    $region
    );
    }
    ?>
    </select>
    <button class="f-zeige-region button">Region anzeigen</button>
    <button class="f-zeige-media button">Medien anzeigen</button>
    <label>Ordner und DB aktualisieren:</label>
    <button class="f-check-all-media button">Alle Ordner einlesen</button>
     
    <hr />
    </div>
     
     
    <div id="anzeige-unternehmen" class="float-left">
     
    <select name="angelegte-unternehmen" id="angelegte-unternehmen" size="10" class="float-left">
		<!-- 	Input ueber js + function-media.php  -->
    </select>
    </div>
    <div id="anzeige-media" class="float-left">
     
     
     
    </div>