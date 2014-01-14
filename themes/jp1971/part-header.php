<?php
/*
 * Template for displaying the default site header.
*/
?>

<header>
	<div class="container header">
		<nav class="navbar" role="navigation">
			<div class="row">
				<div class="navbar-brand">
					<a href="<?php echo home_url(); ?>">
						<h2>
							<span>JP1971</span>
							<br />
							<small>thinking | making</small>
						</h2>
						<span aria-hidden="true" class="jp1971-icomoon-logo"></span>
					</a>
				</div>
				<ul class="link-list">
					<l1>
						<a href="mailto:jameson@jp1971.com">Contact</a>
					</li>
						|
					<l1>
						<a href="<?php bloginfo( 'rss2_url' ); ?>">
							RSS
						</a>
					</li>
				</ul>
			</div>
		</nav>
		<hr>
	</div>
</header>