<?php get_header(); ?>


	<div id="primary" class="container">
		<main id="main" class="site-main" role="main">
		<h2>Single.php</h2>
		<?php
		// Start the loop.
		while ( have_posts() ) : the_post();
		
		the_content();

		// End the loop.
		endwhile;
		?>

		</main><!-- .site-main -->
	

<?php get_footer(); ?>