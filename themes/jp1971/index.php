<?php

get_header();

get_template_part( 'part', 'header' ); ?>
	 	
<div class="main">	 	
	<div class="container">
		<div class="content">
			<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
				<div class="row">
					<?php while ( have_posts() ) : the_post(); ?>
						<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
						<?php the_date(); ?>
						<?php the_excerpt(); ?>	
						<?php the_tags( '', ' | ' ); ?>
					<?php endwhile; // end of the loop. ?>
					<?php if( function_exists( 'wp_paginate' ) ) {
						wp_paginate();
					} ?>
				</div>
			</div>	
			<div class="sidebar col-xs-8 col-sm-4 col-md-4 col-lg-4">			
				<?php get_template_part( 'template-parts/part', 'twitter' ); ?>
				<h4><i class="fa fa-instagram"></i>Instagram</h4>
				<h4><i class="fa fa-github-square"></i>Github</h4>
				<?php $feed = fetch_feed( 'http://github.com/jp1971.atom' ) ; ?>
				<?php
					$html = '';
					$i = 0;
					foreach ($feed->get_items() as $item) {
						if ($i == 3) {
							break;
						}
						$content = $item->data['child']['http://www.w3.org/2005/Atom']['content'][0]['data'];
						$html .= '<div class="github-activity-item">'.$content.'</div>';
						$i++;
					}
					echo $html;
				?>
			</div>
		</div>
	</div>
</div>

<?php 

get_template_part( 'part', 'footer' ); 

get_footer();

?>