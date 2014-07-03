<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
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