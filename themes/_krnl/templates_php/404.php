<?php
/**
 * The template for displaying 404 pages (Not Found).
 */

get_header();

get_template_part( 'part', 'header' ); ?>
	 	
<div id="main">	 	
	<div class="container">
		<div id="content">
			<h1>404 Page Not Found</h1>
			<p>Please visit our <a href="<?php echo get_option( 'home' ); ?>">Homepage</a></p>		
		</div>
	</div>
</div>

<?php 

get_template_part( 'part', 'footer' ); 

get_footer();

?>