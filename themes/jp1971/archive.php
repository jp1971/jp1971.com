<?php
/**
 * The default archive template.
 */

$context = Timber::get_context();
$context['posts'] = Timber::get_posts();
$context['title'] = single_tag_title('', false);
$context['pagination'] = Timber::get_pagination();

Timber::render( 'archive.twig', $context );