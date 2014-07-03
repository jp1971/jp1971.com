<?php
// Get excerpy by ID
function krnl_excerpt_by_id( $id=false ) {
    global $post;

    $old_post = $post;
    if ( $id != $post->ID ) {
        $post = get_page( $id ) ;
    }

    if ( !$excerpt = trim( $post->post_excerpt ) ) {
        $excerpt = $post->post_content;
        $excerpt = strip_shortcodes(  $excerpt );
        $excerpt = apply_filters( 'the_content', $excerpt ) ;
        $excerpt = str_replace( ']]>', ']]&gt;', $excerpt );
        $excerpt = strip_tags( $excerpt ) ;
        $excerpt_length = apply_filters( 'excerpt_length', 45 );
        $excerpt_more = apply_filters( 'excerpt_more', ' ' . '...' );

        $words = preg_split( "/[\n\r\t ]+/", $excerpt, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY );
        if ( count( $words ) > $excerpt_length ) {
            array_pop( $words );
            $excerpt = implode( ' ', $words );
            $excerpt = $excerpt . $excerpt_more;
        } else {
            $excerpt = implode( ' ', $words );
        }
    }

    $post = $old_post;

    return $excerpt;
}