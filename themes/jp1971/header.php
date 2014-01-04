<!DOCTYPE html>
<html lang="en">
  <head>
    <link href='http://fonts.googleapis.com/css?family=Anonymous+Pro:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <meta charset="utf-8">
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="JP1971">

  	<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
      <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
      <![endif]-->

    <!-- Fav and touch icons -->
  	<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.ico">

  	<?php wp_head(); ?>	
    
  </head>
  <body <?php body_class(); ?>>
  <?php get_template_part( 'part', 'analytics' ); ?>