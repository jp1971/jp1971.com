<?php

get_header();

get_template_part( 'part', 'header' ); ?>
	 	
<div id="main">	 	
	<div class="container">
		<div id="content">
			<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
				<div class="row">
					<?php while ( have_posts() ) : the_post(); ?>
						<h3><?php the_title(); ?></h3>
						<?php the_date(); ?>
						<?php the_content(); ?>			
					<?php endwhile; // end of the loop. ?>		
				</div>
			</div>	
			<div class="col-xs-8 col-sm-4 col-md-4 col-lg-4">
				<div class="row">
				</div>
			</div>
		</div>
	</div>
</div>

<?php 

get_template_part( 'part', 'footer' ); 

get_footer();

?>