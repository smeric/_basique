<?php /* force UTF-8 : éàè */
/**
 * Le formulaire de recherche
 *
 * @package WordPress
 * @subpackage _basique
 **/

?>
	<form method="get" action="<?php echo esc_url( home_url() ) ?>/" role="search" aria-label="<?php _e( 'Search form', '_basique' ) ?>" target="_self" class="search-form">
		<label class="screen-reader-text">
			<?php _e( 'Search for : ', '_basique' ) ?>
		</label>
		<input type="search" name="s" placeholder="<?php _e( 'Search...', '_basique' ) ?>" value="<?php if ( get_search_query() ) echo esc_html( get_search_query() ) ?>" class="search-field" required>
		<input type="submit" value="<?php _e( 'OK', '_basique' ) ?>" class="search-submit">
	</form>

