<?php get_header(); ?>
    
	<div class="startseite">
	
	</div>
	<div class="my-row">
		<div class="text-center">
		<h1 class="hl-rosa">Prinzessin findet Traumprinz </h1>
		<h3>Plant jetzt eure Traumhochzeit</h3>
		</div>
		<img class="banner-pfeile" src="<?php bloginfo( 'template_url' ); ?>/img/banner_pfeil.png " alt="Pfeil">
	</div>
	

    <!-- Marketing messaging and featurettes
    ================================================== -->
    <!-- Wrap the rest of the page in another container to center all the content. -->

    <div class="">

      <!-- Three columns of text below the carousel -->
      <div class="my-row banner-braun">
	<div class="container margin-big">
      	<hr class="banner-linie" />
<?php
    
        
    //TESTAUSGABE
       
        
        
    $args = array(
        'category_name'    => 'highlights-startseite',
        'orderby'          => 'date',
        'order'            => 'ASC'
    );
    $posts = get_posts( $args );

    foreach ($posts as $post ) : setup_postdata( $post );
?>
	    
<?php 
	if ( has_post_thumbnail() ){
        $thumb = wp_get_attachment_image_src( get_post_thumbnail_id(), 'thumbnail');
    }; 
?>
          
        
        <div class="col-xs-12 col-sm-4 no-padding">
		<div class="text-center kreise banner-braun margin-small">
		<a href="#">
          	<h2 class=""><?php the_title(); ?></h2>
		</a>          
		</div>
        </div><!-- /.col-lg-4 -->
        
        
        
        
<?php
endforeach;
wp_reset_postdata();
?>      	

       </div> 
      </div><!-- /.row -->


      <!-- START THE FEATURETTES -->

	<div class="my-row">
		<div class="text-center">
		<img class="banner-pfeile" src="<?php bloginfo( 'template_url' ); ?>/img/banner_love.png " alt="Pfeil"></img>
		<h2 class="hl-rosa">Genieße den schönsten Moment.</h2>
		
		</div>
	</div>

      <!-- /END THE FEATURETTES -->

<?php get_footer(); ?>