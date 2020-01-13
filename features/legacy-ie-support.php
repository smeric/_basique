<?php /* force UTF-8 : éàè */
/**
 * Support des anciennes version d'Internet Explorer.
 *
 * @package WordPress
 * @subpackage _basique
 **/

/**
 * Determines, whether the specific theme feature is actually supported. Place this in your plugin file.
 * 
 * @link https://github.com/zamoose/themehookalliance/blob/master/tha-theme-hooks.php
 * 
 * @param bool $bool true
 * @param array $args The hook type being checked
 * @param array $registered All registered hook types
 * 
 * @return bool
 */
add_filter( 'current_theme_supports-legacy-ie-support', '_basique_current_theme_supports', 10, 3 );
if( ! function_exists( '_basique_current_theme_supports' ) ) {
	function _basique_current_theme_supports( $bool, $args, $registered ) {
		if( isset( $args[0] ) && isset( $registered[0] ) ) {
			return in_array( $args[0], $registered[0] );
		}
		else {
			return false;
		}
	}
}


/**
 * HTML tag for legacy IE classes.
 * 
 * @param string $html_tag default HTML tag
 * 
 * @return string
 */
add_filter( '_basique_html_tag', '_basique_legacy_ie_html_tag' );

function _basique_legacy_ie_html_tag( $html_tag = '' ){

	if ( current_theme_supports( 'legacy-ie-support', 'ie7' ) ) {
		$html_tag  = '<!--[if lt IE 7]>      <html class="no-js lt-ie10 lt-ie9 lt-ie8 lt-ie7" ' . get_language_attributes() . '> <![endif]-->' . PHP_EOL
					. '<!--[if IE 7]>         <html class="no-js lt-ie10 lt-ie9 lt-ie8 ie7"    ' . get_language_attributes() . '> <![endif]-->' . PHP_EOL
					. '<!--[if IE 8]>         <html class="no-js lt-ie10 lt-ie9 ie8"           ' . get_language_attributes() . '> <![endif]-->' . PHP_EOL
					. '<!--[if IE 9]>         <html class="no-js lt-ie10 ie9"                  ' . get_language_attributes() . '> <![endif]-->' . PHP_EOL
					. '<!--[if gt IE 9]><!--> ' . $html_tag . ' <!--<![endif]-->' . PHP_EOL;
	}
	elseif ( current_theme_supports( 'legacy-ie-support', 'ie8' ) ) {
		$html_tag  = '<!--[if lt IE 8]>      <html class="no-js lt-ie10 lt-ie9 lt-ie8" ' . get_language_attributes() . '> <![endif]-->' . PHP_EOL
					. '<!--[if IE 8]>         <html class="no-js lt-ie10 lt-ie9 ie8"    ' . get_language_attributes() . '> <![endif]-->' . PHP_EOL
					. '<!--[if IE 9]>         <html class="no-js lt-ie10 ie9"           ' . get_language_attributes() . '> <![endif]-->' . PHP_EOL
					. '<!--[if gt IE 9]><!--> ' . $html_tag . ' <!--<![endif]-->' . PHP_EOL;
	}
	elseif ( current_theme_supports( 'legacy-ie-support', 'ie9' ) ) {
		$html_tag  = '<!--[if lt IE 9]>      <html class="no-js lt-ie10 lt-ie9" ' . get_language_attributes() . '> <![endif]-->' . PHP_EOL
					. '<!--[if IE 9]>         <html class="no-js lt-ie10 ie9"    ' . get_language_attributes() . '> <![endif]-->' . PHP_EOL
					. '<!--[if gt IE 9]><!--> ' . $html_tag . ' <!--<![endif]-->' . PHP_EOL;
	}
	elseif ( current_theme_supports( 'legacy-ie-support', 'ie10' ) ) {
		$html_tag  = '<!--[if lte IE 9]>     <html class="no-js lt-ie10" ' . get_language_attributes() . '> <![endif]-->' . PHP_EOL
					. '<!--[if gt IE 9]><!--> ' . $html_tag . ' <!--<![endif]-->' . PHP_EOL;
	}

	return $html_tag;
}

/**
 * Déclaration et utilisation de feuilles de styles spécifiques aux différentes version d'Internet Explorer
 *
 * @since _basique 0.1.0
 **/
add_action( '_basique_enqueue_styles', '_basique_legacy_ie_enqueue_styles' );

function _basique_legacy_ie_enqueue_styles( $no_cache = '' ) {
	global $wp_styles;

	// Si l'on se trouve dans un thème enfant, déclaration et utilisation des feuilles de styles du thème parent
	if ( is_child_theme() ) {
		// Feuilles de styles spécifiques aux anciennes versions d'Internet Explorer.
		if ( current_theme_supports( 'legacy-ie-support', 'ie' ) ) {
			wp_enqueue_style( '_basique-enfant-ieAll', trailingslashit( get_stylesheet_directory_uri() ) . 'assets/css/ie-style.css', false, $no_cache );
			$wp_styles->add_data( '_basique-enfant-ieAll', 'conditional', 'IE' );
		}
		if ( current_theme_supports( 'legacy-ie-support', 'ie7' ) ) {
			wp_enqueue_style( '_basique-enfant-ie7', trailingslashit( get_stylesheet_directory_uri() ) . 'assets/css/ie7-style.css', false, $no_cache );
			$wp_styles->add_data( '_basique-enfant-ie7', 'conditional', 'IE 7' );
		}
		if ( current_theme_supports( 'legacy-ie-support', 'ie8' ) ) {
			wp_enqueue_style( '_basique-enfant-ie8', trailingslashit( get_stylesheet_directory_uri() ) . 'assets/css/ie8-style.css', false, $no_cache );
			$wp_styles->add_data( '_basique-enfant-ie8', 'conditional', 'IE 8' );
		}
		if ( current_theme_supports( 'legacy-ie-support', 'ie9' ) ) {
			wp_enqueue_style( '_basique-enfant-ie9', trailingslashit( get_stylesheet_directory_uri() ) . 'assets/css/ie9-style.css', false, $no_cache );
			$wp_styles->add_data( '_basique-enfant-ie9', 'conditional', 'IE 9' );
		}
	}
}

