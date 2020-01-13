<?php /* force UTF-8 : éàè */
/**
 * @package WordPress
 * @subpackage _basique
 *
 * Template Name: Extrait des pages enfants
 */
get_header();
?>
	<div id="main-wrapper" class="wrapper">
		<main id="main" class="container" role="main" aria-label="<?php _e( 'Main page content', '_basique' ) ?>">
            <?php the_post() ?>
            <section id="page-<?php the_ID() ?>" <?php post_class( 'container' ) ?>>
                <?php _basique_page_title( array(
                    'before' => '<h1 class="entry-header section-header entry-title section-title">',
                )) ?>
                <div class="entry-content section-content">
                    <?php the_content() ?>
<?php
                    /* Requête personnalisée */
                    $args = apply_filters( '_basique_subpages_list_page_template_query_args', array(
                        'post_type' => 'page',
                        'orderby' => 'menu_order',
                        'order' => 'ASC',
                        'post_parent' => $post->ID,
                        'post_status' => 'publish',
                        'posts_per_page' => -1,
                    ));
                    $wp_query = new WP_Query( $args );
?>
                    <ul class="pages-list section-content wrapper">
<?php
                        if ( have_posts() ) :
                            while ( have_posts() ) :
                                the_post(); 
?>
                        <li id="post-<?php the_ID() ?>" <?php post_class( 'container' ) ?>>
                            <h2 class="entry-header entry-title">
                                <a href="<?php the_permalink() ?>"><?php the_title() ?></a>
                            </h2>
                            <div class="entry-content">
<?php
                                if ( has_post_thumbnail() ) {
                                    ?><a href="<?php the_permalink() ?>"><?php
                                        /**
                                         * Filtre appliqué à la taille de la vignette affichée à côté de l'extrait de la page.
                                         *
                                         * @since 0.1.0
                                         *
                                         * @param string La taille de la vignette.
                                         **/
                                        the_post_thumbnail( apply_filters( '_basique_subpages_list_thumbnail_size', 'medium' ), array( 'class' => 'alignleft' ) );
                                    ?></a><?php
                                }
                                the_excerpt();
?>
                                <p class="read-more"><a href="<?php the_permalink() ?>"><?php _e( 'Read more <span class="meta-nav">&raquo;</span>', '_basique' ) ?></a></p>
                            </div>
                        </li>
<?php
                            endwhile;

                        /* liste vide */
                        else :
?>
                        <li id="post-0" class="not-found last first post-0 page type-page status-publish format-standard hentry">
                            <h2 class="entry-header entry-title">
                                <?php _e( 'Not Found', '_basique' ) ?>
                            </h2>
                            <p class="entry-content"><?php _e( 'No subpages to display.', '_basique' ) ?></p>
                        </li>
<?php
                        endif;
?>
                    </ul>
<?php
                    /* Retour à la requête WordPress originale */
                    wp_reset_query();
?>
                </div><!-- .entry-content -->
            </section><!-- #page-<?php the_ID() ?> -->
		</main><!-- #main -->
	</div><!-- #main-wrapper -->
<?php
get_template_part( 'partials/sidebars/primary' );
get_template_part( 'partials/sidebars/secondary' );

get_footer()
?>
