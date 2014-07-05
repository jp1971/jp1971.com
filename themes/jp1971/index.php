<?php
/**
 * The main template file
 */

$context = Timber::get_context();
$context['posts'] = Timber::get_posts();
$context['pagination'] = Timber::get_pagination();

$templates = array( 'index.twig' );

if ( is_home() ){
	array_unshift( $templates, 'home.twig' );
}

Timber::render( $templates, $context );