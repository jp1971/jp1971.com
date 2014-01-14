<?php
/**
 * The template for displaying all single pages.
 */

get_header();

get_template_part( 'part', 'header' ); 

?>
	 	
<div class="main">	 	
	<div class="container">
		<div class="content">
			<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
				<div class="row">
					<?php while ( have_posts() ) : the_post(); ?>
						<?php the_date(); ?>
						<h1><?php the_title(); ?></h1>
						<?php the_content(); ?>	
						<div class="tags">
						Posted in:&nbsp;<?php the_tags( '', ' | ' ); ?>
						</div>
					<?php endwhile; ?>
				</div>
			</div>
			<div class="sidebar col-xs-8 col-sm-4 col-md-4 col-lg-4">
				<?php get_template_part( 'template-parts/part', 'twitter' ); ?>
				<h4><i class="fa fa-instagram"></i>Instagram</h4>
				<?php get_template_part( 'template-parts/part', 'github' ); ?>
			</div>
		</div>
	</div>
</div>

<?php 

get_template_part( 'part', 'footer' ); 

get_footer();

?>