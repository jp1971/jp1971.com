<?php
/**
 * The template for displaying the archive pages
 */

$context = Timber::get_context();

$context['wp_content'] = content_url();

$post = new TimberPost();
$context['post'] = $post;

Timber::render( 'single-doc.twig', $context );