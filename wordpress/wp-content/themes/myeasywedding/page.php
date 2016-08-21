<?php
get_header(); ?>

	<div id="primary" class="container">
		
hallo
		<?php
		// Start the loop.
		while ( have_posts() ) : the_post();

			// Include the page content template.
			//get_template_part( 'content', 'page' );
			?>
		
		
			<div class="row">
				<div class="col-md-12">
				<h1>
				<?php the_title(); ?>
				</h1>
		<?php
			
			the_content();

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		// End the loop.
		endwhile;
		?>
				</div>
			</div>
	

<?php get_footer(); ?>
