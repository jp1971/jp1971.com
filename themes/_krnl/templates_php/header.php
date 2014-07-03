<?php
/**
 * The header for our theme.
 */
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php bloginfo('name'); ?><?php wp_title('|'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="JP1971">

  	<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
      <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
      <![endif]-->

    <!-- Fav and touch icons -->
  	<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico">

  	<?php wp_head(); ?>	
    
  </head>
  <body <?php body_class(); ?>>