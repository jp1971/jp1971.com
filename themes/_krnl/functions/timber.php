<?php 

class KrnlTimberPost extends TimberPost {

    var $_author;

    /**
     * Gets the ID of the current post if one is not provided
     * and returns array of corresponding guest author data.
     *
     * @param int $post_id
     * @return array
     */

    public function get_coauthor( $post_id = 0 ) {

        if ( empty( $post_id ) ) {
            $post_id = get_the_ID();
        }

        if ( function_exists( 'get_coauthors' ) ) {
            $_author = array_shift( get_coauthors( $post_id ) );
        } else {
            $_post = get_post( $post_id );
            $_author = get_userdata( get_the_author_meta( 'ID', $_post->post_author ) );
        }

        return $_author;
    }

    /**
     * Gets the ID of the current post if one is not provided
     * and returns corresponding guest author display name.
     *
     * This function will be deprecated in a future release of _krnl
     *
     * @param int $post_id
     * @return string
     */

    public function get_coauthor_name( $post_id = 0 ) {

        if ( empty( $post_id ) ) {
            $post_id = get_the_ID();
        }

        if ( function_exists( 'get_coauthors' ) ) {
            $_author = array_shift( get_coauthors( $post_id ) );
        } else {
            $_post = get_post( $post_id );
            $_author = get_userdata( get_the_author_meta( 'ID', $_post->post_author ) );
        }

        return $_author->display_name;
    }

    /**
     * Gets the ID of the current post if one is not provided
     * and returns the corresponding guest author post thumbnail URL.
     *
     * @param int $post_id
     * @return string
     */

    public function get_coauthor_thumbnail( $post_id = 0 ) {

        if ( empty( $post_id ) ) {
            $post_id = get_the_ID();
        }

        if ( function_exists( 'get_coauthors' ) ) {
            $_author = array_shift( get_coauthors( $post_id ) );
        } else {
            $_post = get_post( $post_id );
            $_author = get_userdata( get_the_author_meta( 'ID', $_post->post_author ) );
        }

        if ( has_post_thumbnail( $_author->ID ) ) {
            return get_the_post_thumbnail( $_author->ID );
        } else {
            return;
        }
    }
}