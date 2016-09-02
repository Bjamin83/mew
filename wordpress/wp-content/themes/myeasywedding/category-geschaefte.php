<?php get_header(); ?>

<div class="my-row banner-flieder">
		<div class="container">

		
		</div>
		<img class="trenner-solo" src="<?php bloginfo( 'template_url' ); ?>/img/trenner-herz.png " alt="Pfeil"></img>
        <div class="clear-both"></div>
</div>
	<div class="my-row">
		<div class="text-center">
			<h1 class="hl-rosa">Experten</h1>
			<h3>Die dich unterstützen</h3>
		</div>
		<img class="banner-pfeile" src="<?php bloginfo( 'template_url' ); ?>/img/banner_pfeil.png " alt="Pfeil"></img>
	</div>


<div class="my-row banner-braun">

    <div class="container margin-big">	

<?php 
    //Holt sich alle Unterkategorien von "geschaefte"
    $idObj = get_category_by_slug( 'geschaefte' );
    $geschaefte= $idObj->term_id;    
        
    $args = array(
        'type'                     => 'post',
        'child_of'                 => $geschaefte,
        'orderby'                  => 'name',
    ); 

    $categories = get_categories( $args );
    $i=0;
    $textspalte='';
    $bildspalte='';
    $url='';

    // Testausgabe
    //echo print_r($categories);

    //Es wird in der Schleife zu jeder aktuellen Kategorie der Link zum Kategorienamen angehängt.
    foreach ($categories as $categorie) {

?>	
              <div class="col-xs-6 col-sm-3 col-md-2">
                <div class="text-center bv-kreis-liste banner-braun">
                    <a href="<?php echo esc_url(get_category_link( $categorie->cat_ID )); ?>" class="">
                        <h4><?php 
                            preg_match("/\[(.*?)\]/", $categorie->description, $match);
                            if (isset($match[0])){
                                echo preg_replace("/[\[\]]/", "" ,$match[0]);	
                            }else echo $categorie->cat_name;

                            ?></h4>
                    </a> 
                </div>
              </div>
<?php

    } // Ende der foreach.
?>		

    </div> 


</div><!-- Ende div row -->

<div class="my-row">
<div class="container">
		<div class="text-center">
			<h1 class="hl-rosa">Experten</h1>
			<h3>Die dich unterstützen</h3>
		</div>
		
		<div class="col-xs-12 col-sm-6">
		     <p> Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. 
</p>
		</div>
		<div class="col-xs-12 col-sm-6">
		     <p> Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. 
</p>
		</div>
</div>	
<img class="banner-pfeile" src="<?php bloginfo( 'template_url' ); ?>/img/banner_pfeil.png " alt="Pfeil"></img>
</div>
	
<div class="my-row banner-green">
	<div class="container text-center">
		<h1 class="hl-green">Trends verpasst?</h1>
		<h3 class="hl-white">News.Trends.Styes.Unser Newsletter</h3>
	
	</div>
<img class="trenner-solo" src="<?php bloginfo( 'template_url' ); ?>/img/trenner-ringe.png " alt="Ringe"></img>	
</div>
	<div class="my-row">
		<div class="text-center margin-big">
		<img class="banner-pfeile" src="<?php bloginfo( 'template_url' ); ?>/img/banner_love.png " alt="Pfeil"></img>
		<h2 class="hl-rosa">Genieße den schönsten Moment.</h2>
		
		</div>
	</div>


<?php get_footer(); ?>
