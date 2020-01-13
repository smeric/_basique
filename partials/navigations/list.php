<?php /* force UTF-8 : éàè */
/**
 * @package WordPress
 * @subpackage _basique
 */

$prev_text = __( '<span class="meta-nav">&laquo;</span> Previous', '_basique' );
$next_text = __( 'Next <span class="meta-nav">&raquo;</span>', '_basique' );

if ( is_search() ) {
	$prev_text = __( '<span class="meta-nav">&laquo;</span> Previous results', '_basique' );
	$next_text = __( 'Next results <span class="meta-nav">&raquo;</span>', '_basique' );
}

$prev_link = get_previous_posts_link( $prev_text );
$next_link = get_next_posts_link( $next_text );

if ( $prev_link || $next_link ) :
?>
							<div class="container previous-next-navigation" role="navigation" aria-label="<?php _e( 'Previous and next entries', '_basique' ) ?>">
<?php if ( $prev_link ) : ?>
								<div class="previous">
<?php     echo $prev_link ?>
								</div>
<?php endif ?>
<?php if ( $next_link ) : ?>
								<div class="next">
<?php     echo $next_link ?>
								</div>
<?php endif ?>
							</div>
<?php
endif
?>
