<?php
/**
 * The template for displaying docs detail pages.
 */

get_header(); ?>
	 	
<div id="main">	 	
	<div class="container">
		<div id="content">
			<?php while ( have_posts() ) : the_post(); ?>
				<h1><?php the_title(); ?></h1>
				<?php the_content(); ?>
				<a href="<?php echo home_url( 'docs' ); ?>">
					<i class="fa fa-reply"></i>
					Return to <?php echo get_bloginfo( 'name' ); ?> Notes Index
				</a>
			<?php endwhile; ?>
		</div>
	</div>
</div>

<?php get_footer(); ?>