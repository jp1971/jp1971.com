<?php
/**
 * The template for displaying docs archive pages
 */

$context = Timber::get_context();

$context['wp_content'] = content_url();

$args = 'post_type=docs&numberposts=-1&orderby=title&order=asc';

$context['posts'] = Timber::get_posts( $args );

Timber::render( 'archive-docs.twig', $context );