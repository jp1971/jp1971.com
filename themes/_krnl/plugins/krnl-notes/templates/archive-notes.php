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

if ( current_user_can( 'edit_others_posts' ) ) :
?> 	
	<div id="main">	 	
		<div class="container">
			<div id="content">
				<h1><?php echo get_bloginfo( 'name' ); ?> Notes</h1>
				<?php while ( have_posts() ) : the_post(); ?>
					<?php the_date(); ?> - 
					<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>		
				<?php endwhile; // end of the loop. ?>			
			</div>
		</div>
	</div>
<?php 
else:

wp_safe_redirect( home_url() );

endif;

get_footer(); 
?>