<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 */

get_header();

get_template_part( 'part', 'header' ); ?>
	 	
<div id="main">	 	
	<div class="container">
		<div id="content">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php the_content(); ?>			
			<?php endwhile; // end of the loop. ?>			
		</div>
	</div>
</div>

<?php 

get_template_part( 'part', 'footer' ); 

get_footer();

?>