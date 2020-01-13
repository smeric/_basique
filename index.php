<?php /* force UTF-8 : éàè */
/**
 * @package WordPress
 * @subpackage _basique
 **/

get_header()
?>
	<div id="main-wrapper" class="wrapper">
		<main id="main" class="container" role="main" aria-label="<?php _e( 'Main page content', '_basique' ) ?>">
<?php
			if ( is_404() ) {
				get_template_part( 'partials/loops/not-found' );
			}
			elseif ( is_singular() ) {
				if ( have_posts() ) :
					// Inclu le contenu spécifique au type de post (post type).
					get_template_part( 'partials/loops/single', get_post_type() );
				else :
					get_template_part( 'partials/loops/not-found' );
				endif;
			}
			else {
				if ( is_search() ) :
					// Inclu le contenu spécifique à une liste de résultats de recherche.
					get_template_part( 'partials/loops/list', 'search-results' );
				else :
					// Inclu le contenu par défaut d'une liste de type de post (post type).
					get_template_part( 'partials/loops/list', apply_filters( '_basique_default_post_type_list', '' ) );
				endif;
			}
?>
		</main><!-- #main -->
	</div><!-- #main-wrapper -->
<?php
get_template_part( 'partials/sidebars/primary' );
get_template_part( 'partials/sidebars/secondary' );

get_footer()
?>
