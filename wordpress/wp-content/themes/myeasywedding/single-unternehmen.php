<?php 
/**
* Template Name: Einzelnes Unternehmen
*/
get_header();
wp_enqueue_script('slider'); 
wp_enqueue_script('jquery_mob');
wp_enqueue_script('single_unternehmen');
wp_enqueue_script('fb');
?>

<?php
	setup_postdata(get_post(get_the_ID()));
	
	//Für die Navigation "zurück" muss hier die richtige übergeordnete Kategorie gesetzt werden:
	$aktueller_post = get_post();
	$post_categories = wp_get_post_categories( $aktueller_post->ID );
	$aktuelle_cat = $post_categories[0]; 
   
?>





<div class="my-row banner-flieder">
	
		<div class="container text-center margin-bottom">
			<div class="back">
				<a href="<?php  echo get_category_link( $aktuelle_cat );  ?>"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span></a>
			</div>
			<div class="kopfzeile">
				<?php			
				echo "<h1 class='margin-small'>" . get_cat_name($aktuelle_cat) . "</h1>";
				echo "<h3>" . $aktueller_post->post_title . "</h3>";
				
                //print_r($meta);
				
				?>
            </div>        
		
		</div>
            <?php
                get_bewertung();
            ?>
        
</div>

<div class="my-row banner-braun">
    <div class="container margin-big text-center">
        
        <?php
                
                //Holt sich die Metadaten
                $meta = get_post_meta( get_the_ID() );
                $anzahl_meta = 0;
                
                //Prüft ob Tel, Mail oder Web gepflegt sind
                if(isset($meta['_Unternehmens_telefonnummer'][0]) AND $meta['_Unternehmens_telefonnummer'][0] != ''){
                    $tel = $meta['_Unternehmens_telefonnummer'][0];
                    $anzahl_meta++;
                }
                if(isset($meta['_Unternehmens_email'][0]) AND $meta['_Unternehmens_email'][0] != ''){
                    $email = $meta['_Unternehmens_email'][0];
                    $anzahl_meta++;
                }          
                if(isset($meta['_Unternehmens_website'][0]) AND $meta['_Unternehmens_website'][0] != ''){
                    $web = $meta['_Unternehmens_website'][0];
                    $anzahl_meta++;
                }        
               
                //Passt die Spaltenbreite anhand der gepflegt Metadaten an.
                switch($anzahl_meta){
                    case(2):
                        $metaspalten = "col-sm-6";
                        break;
                    case(3):
                        $metaspalten = "col-sm-4";
                        break;
                    default:
                        $metaspalten = "";
                        break; 
                }
        
            
                //Ausgabe der zuvor geprüften Metadaten. Nicht gepflegte Spalten werden nicht ausgegeben.        
                $ausgabe = '';        

                if(isset($tel) && $tel != ''){
                    $ausgabe .= '<div class="'. $metaspalten .' col-xs-12 margin-small">
                        <div class="action-kreise banner-flieder glyphicon glyphicon-earphone">
                        </div>
                        <div class="u-meta-text">'.
                        $tel.'
                        </div>
                    </div>';
                }        
                if(isset($email) && $email != ''){
                $ausgabe .= '<div class="'. $metaspalten .' col-xs-12 margin-small">
                    <div class="action-kreise banner-flieder glyphicon glyphicon-envelope">
                    </div>
                    <div class="u-meta-text">'.
                    $email .'
                    </div>
                </div>';
                } 
                if(isset($web) && $web != ''){
                $ausgabe .= '<div class="'. $metaspalten .' col-xs-12 margin-small">
                    <div class="action-kreise banner-flieder glyphicon glyphicon-globe">
                    </div>
                    <div class="u-meta-text">'.
                    $web .'
                    </div>
                </div>';
                }             

                //Ausgabe des ganzen Blocks.
                echo $ausgabe;

        ?>            
    </div>
</div>


<div class="my-row">
		<div class="text-center">
			<h1 class="hl-rosa">Experten</h1>
			<h3>Die dich unterstützen</h3>
		</div>
		<img class="banner-pfeile" src="<?php bloginfo( 'template_url' ); ?>/img/banner_pfeil.png" alt="Pfeil" />
</div>


<div class="my-row">

	<div class="container margin-bottom">	
		
	<div class="col-md-6 col-md-offset-3">
		
                    
                        
                        
        <?php
        $kundennummer=get_post_meta($aktueller_post->ID, $key="_Unternehmens_kundennummer", $single=true );

        get_gallery($kundennummer);

        ?>
                              
                         
                
	</div>
	</div>
</div> <!-- Ende div row -->

<!-- Bewertungen  -->
<div id="testausgabe"></div>

<div class="my-row">
    <div class="container text-center">
        
        <input type="hidden" id="rating-unternehmen" value="<?php echo get_the_ID(); ?>" />
        <h2>Deine Bewertung:</h2>
        <?php
        /* Abfrage ob angemeldeter Benutzer  */
        $user 		= get_current_user_id();

        if($user == 0){
            echo "Zum Bewerten musst du angemeldet sein.";

        } else {
            get_user_bewertung();

        }
        ?>

        	
    </div>

    <div id="feedbutton" class="fb-like"
  data-share="true"
  data-width="450"
  data-show-faces="true">
</div>
    
</div>


<!--  FUNKTIONEN  -->

<?php
/*
* 
* Tablename und Spaltenname müssen mit der DB überinstimmen.
*/
	function get_gallery( $unternehmen ){
			
		$blogurl = get_bloginfo( "template_url" );
		
	    global $wpdb;
	     
	    $table_name = $wpdb->prefix . 'mediaverwaltung';
	    //$sql = 'SELECT * FROM '.$table_name.' WHERE slug = %s';
	    $resultset = $wpdb->get_results( $wpdb->prepare('SELECT permalink, description, imagename FROM '.$table_name.' WHERE slug = %s', $unternehmen) );
		

        //testausgabe
		//echo $resultset[0]->permalink.'/'. $resultset[0]->imagename;
        //echo $unternehmen;


		
		if (count($resultset)== 1){

			echo '<div id="MainDiv">
					<img src="' . $resultset[0]->permalink.'/'. $resultset[0]->imagename . '" alt="About Us" id="MainImage"/>
              	</div>';	
			
			
		}elseif (count($resultset)>1){
			$breite= 100 / count($resultset);
			echo '<div id="MainDiv">
					<img src="' . $resultset[0]->permalink.'/'. $resultset[0]->imagename . '" alt="About Us" id="MainImage"/>
                	<div id="child">
                    		<img id="Next" src="'. $blogurl .'/img/RightArrow.png" class="img-responsive NextButton"/>
                    		<img id="Previous" src="' . $blogurl .'/img/LeftArrow.png" class="img-responsive PreButton"/>
                	</div>
              	</div>';	
			
			
			echo '<div id="slider">';
			foreach ($resultset as $result) {
							
				echo '<div class="NoPaddingMarging slide" style="width:'. $breite .'% ; max-width:20%">
	                	<img src="' . $result->permalink.'/'. $result->imagename . '" alt="About Us"/>
	            	</div>';
			}
			echo '</div>';
		}else{
			echo '<div id="MainDiv">
					<img src="' . $blogurl . '/img/default.jpg" alt="About Us" id="MainImage"/>
              	</div>';	
		}
	}

/*
*   Zieht sich die Gesamtbewertung aus der DB.
*/
    function get_bewertung(){
        
        $blogurl = get_bloginfo( "template_url" );
		
	    global $wpdb;
        
        $out='';
        $partner='';
        
        $unternehmen_ID = get_the_ID();
        
        $premium = get_post_meta(get_the_ID());

			
        if(isset($premium['_Unternehmens_status'][0]) && $premium['_Unternehmens_status'][0] == 'Partner'){ 
			$partner = true;
			} else $partner = false;
        
        
        $table_name = $wpdb->prefix . 'rating';
       
        $resultset = $wpdb->get_results( $wpdb->prepare('SELECT COUNT(*) AS Anzahl,SUM(bewertung) AS Summe FROM '.$table_name.' WHERE unternehmensID = %s', $unternehmen_ID) );
        
        if((isset($resultset[0]->Summe)) AND $partner){
            
            $anzahl = $resultset[0]->Anzahl;
            
            //Anzahl der Bewertungen als Label für die Icons
            $out = '<div class="bewertung-label text-center"><p>'. $anzahl .' Bewertung(en) </p>
                    </div>';
            
            $schnitt = ($resultset[0]->Summe)/($anzahl);
            
            //Vor der Schleife den Container hinzufügen und nach der Schleife wieder schließen!
            $out .= '<div class="bewertung-top">';
            
            for($i= 0; $i<5; $i++){
                $wert = $schnitt - $i;
                
                switch(true){
                        
                        case($wert <= 0.25 ):
                            $out .= '<img class="bewertung-icon" src="'. $blogurl .'/img/trenner-herz-grau.png" alt="Pfeil"></img>';
                            break;
                        case($wert > 0.25 AND $wert < 0.75):
                            $out .= '<img class="bewertung-icon" src="'. $blogurl .'/img/trenner-herz-halb.png" alt="Pfeil"></img>';
                            break;
                        case($wert >= 0.75):
                            $out .= '<img class="bewertung-icon" src="'. $blogurl .'/img/trenner-herz.png" alt="Pfeil"></img>';
                            break;
                        
                }
                
            }
            
        }else {
            
            $out = '<img class="trenner-solo" src="'. $blogurl .'/img/trenner-herz.png" alt="Pfeil"></img>';
            
        }
        
        //Clear Div hinzufügen und den Container schließen
        $out .= '<div class="clear-both"></div>
                </div>';
        
        //print_r($resultset);
              
        
        echo $out;
       // echo $schnitt;
    }

/*
*   Zieht sich die Einzelbewertung aus der DB.
*/
    function get_user_bewertung(){
        
        $blogurl = get_bloginfo( "template_url" );
		
	    global $wpdb;
        
        $table_name = $wpdb->prefix . 'rating';
        
        $unternehmen_ID = get_the_ID();
        $userID = get_current_user_id();
        
        $out = '';
       
        $resultset = $wpdb->get_results( $wpdb->prepare('SELECT bewertung FROM '.$table_name.' WHERE unternehmensID = %s AND userID = %s' , $unternehmen_ID, $userID) );
        
        if(isset($resultset[0]->bewertung)){
            
            $bewertung = $resultset[0]->bewertung;
            
            $out .= '<ul id="rating" class="'.$bewertung.'">';
            
            for($i = 1; $i < 6; $i++){
                
                if($i <= $bewertung){
                    $out .= '<li id="li_'.$i .'" class="f-rate star_on" value="'.$i.'"><div id="herz_'.$i.'" class="herz-rating" ></div></li>';
            
                }else {
                    $out .= '<li id="li_'.$i .'" class="f-rate star_off" value="'.$i.'"><div id="herz_'.$i.'" class="herz-rating" ></div></li>';
                }
                
            }
            
            $out .= '</ul>';
            
        } else {
            $bewertung = 0;
            
            $out .= '<ul id="rating" class="'.$bewertung.'">';
            
            for($i = 1; $i < 6; $i++){
                
                if($i <= $bewertung){
                    $out .= '<li id="li_'.$i .'" class="f-rate star_on" value="'.$i.'"><div id="herz_'.$i.'" class="herz-rating" ></div></li>';
            
                }else {
                    $out .= '<li id="li_'.$i .'" class="f-rate star_off" value="'.$i.'"><div id="herz_'.$i.'" class="herz-rating" ></div></li>';
                }
                
            }
            
            $out .= '</ul>';
            
        }
            
              
        echo $out;
        echo "$unternehmen_ID, $userID";
    }

?>


<?php get_footer(); ?>
