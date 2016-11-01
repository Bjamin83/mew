<?php get_header(); ?>

<?php 
	wp_enqueue_script('single_unternehmen');

	//Für die Navigation "zurück" muss hier die richtige übergeordnete Kategorie gesetzt werden:
	$cat_overview = get_cat_ID( 'Geschäfte'); 
?>

<div class="my-row color-banner-main">
	<div class="container kat-back">

			<a href="<?php  echo get_category_link( $cat_overview );   ?>">
                 <span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>
                 <p><?php echo get_cat_name(get_query_var( 'cat' )); ?></p>
            </a>




	</div>
</div>



<!--   Anfang Schleife Unternehmenskacheln   -->
<div class="my-row color-row-main">
    <div class="container unternehmensliste">


    <?php
				
            // Holt sich alle Beiträge vom Typ Unternehmen aus der Kategorie der aktuellen Seite.
            $thecategory = intval(get_query_var('cat'));

            $args = array(

                'category'     	   => $thecategory,
                'orderby'          => 'date',
                'order'            => 'DESC',
                'post_type'        => 'unternehmen'

            );
            $posts_array = get_posts( $args );


            foreach($posts_array as $post) {

            //Helps to format custom query results for using Template tags
            setup_postdata($post);

            //Abfrage der eigenen Metaboxen.
            $premium = get_post_meta(get_the_ID());

            // Testausgabe
            //echo $post->post_type;
            //echo print_r($post);


			if(isset($premium['_Unternehmens_status'][0]) && $premium['_Unternehmens_status'][0] == 'Partner'){ 
			$partner = true;
			} else $partner = false;


    ?>

        		<div class="col-xs-12 col-sm-6 col-md-3">
                    <div class="kat-kachel">
                        <div>
                            <h2 class="margin-tiny"><?php the_title(); ?></h2>

                        </div>
                    <?php
                                if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
                                        $url = wp_get_attachment_url( get_post_thumbnail_id() );

                //**************************Platzhalterbild muss noch eingefügt werden!!!!
                                }else $url = "Pfad zum Platzhalter";
                    ?>
                                <img class="center-block unternehmensliste-img" src="<?php echo $url; ?>" alt="Generic placeholder image">
                                <div class="kat-kachel-excerpt">
                                    <?php
                                        $auszug = get_the_excerpt();
                                        if((strlen ($auszug))>120){
                                            $auszug = substr($auszug, 0, 120) . " [...]";
                                        }



                                    ?>
                                    <p><?php echo $auszug; ?> </p>
                                </div>

                    <?php

                                //Holt sich die Metadaten
                                $meta = get_post_meta( get_the_ID() );
                                $anzahl_meta = 0;
                                $tele = '-';
                                $mail = '-';
                                $web  = '-';

                                //Prüft ob Tel, Mail oder Web gepflegt sind
                                if(isset($meta['_Unternehmens_telefonnummer'][0]) AND $meta['_Unternehmens_telefonnummer'][0] != ''){
                                    $tel = $meta['_Unternehmens_telefonnummer'][0];
                                }
                                if(isset($meta['_Unternehmens_email'][0]) AND $meta['_Unternehmens_email'][0] != ''){
                                    $mail = $meta['_Unternehmens_email'][0];
                                }
                                if(isset($meta['_Unternehmens_website'][0]) AND $meta['_Unternehmens_website'][0] != ''){
                                    $web = $meta['_Unternehmens_website'][0];
                                }
                    ?>

                        <?php
                            echo '<p class="partner-link"><a class="btn kat-kachel-btn" href="'. get_permalink(get_the_ID()) .'">Details!</a></p>';
                        ?>

                    <!-- Über JS werden die TABs gesteuert. Achtung beim Anpassen von Knoten und Klassen!  -->

                                <hr class="margin-small kat-kachel-hr"/>

                                <div class="kat-icons-wrap">
                                    <div class="tel-kat kat-icons-div f-kat-active">
                                        <div class="glyphicon glyphicon-earphone kat-icon  f-cat-icon">

                                        </div>
                                    </div>
                                    <div class="email-kat kat-icons-div">
                                        <div class="glyphicon glyphicon-envelope kat-icon f-cat-icon">

                                        </div>
                                    </div>
                                    <div class="web-kat kat-icons-div">
                                        <div class="glyphicon glyphicon-globe kat-icon f-cat-icon">

                                        </div>
                                    </div>
                                </div>

                                <div class="cat-ausgabe">
                                    <p class="cat-ausgabe-tel f-cat-tel">
                                        <?php echo $tel; ?>
                                    </p>
                                    <p class="cat-ausgabe-email f-cat-email unsichtbar">
                                        <?php echo $mail; ?>
                                    </p>
                                    <p class="cat-ausgabe-web f-cat-web unsichtbar">
                                        <?php echo $web; ?>
                                    </p>
                                </div>


                    </div>
                </div>




			

<?php
}
wp_reset_query();

?>

    </div>
</div> <!-- Ende Schleife Unternehmenskacheln -->

<?php get_footer(); ?>
