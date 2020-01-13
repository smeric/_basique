<?php /* force UTF-8 : éàè */
/**
 * @package WordPress
 * @subpackage _basique
 *
 * Template Name: Redirige vers la 1ère page enfant
 */

if ( have_posts() ) :
    while ( have_posts() ) : the_post();
        $pagekids = get_pages( 'child_of=' . $post->ID . '&sort_column=menu_order' );
        if ( isset( $pagekids ) && is_array( $pagekids ) && !empty( $pagekids ) ) :
            // redirect to the first child page if the current page have children pages
            $firstchild = $pagekids[0];
            wp_redirect( get_permalink( $firstchild->ID ), 301 );
            exit;
        else :
            die( __( 'The "Redirect To First Child" page template must be associated with the parent page of a pages hierarchical tree.', '_basique' ) );
        endif;
    endwhile;
endif;
?>
