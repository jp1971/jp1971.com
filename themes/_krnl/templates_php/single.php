<?php
/**
 * The template for displaying all single pages.
 */

get_header();

get_template_part( 'part', 'header' ); 

?>
	 	
<div id="main">	 	
	<div class="container">
		<div id="content">
			<?php 
			while ( have_posts() ) : the_post(); 
				if ( get_post_type() ) {
					get_template_part( 'part', get_post_type() ); 
				} else {
					the_content(); 
				}
			endwhile;
			?>
		</div>
	</div>
</div>

<?php 

get_template_part( 'part', 'footer' ); 

get_footer();

?>