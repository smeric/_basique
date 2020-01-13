<?php /* force UTF-8 : éàè */
/**
 * Modèle pour l'entête (header) commune à toutes les pages du site
 *
 * @package WordPress
 * @subpackage _basique
 **/

/* Déclaration dans l'entête HTTP de l'encodage des caractères de la page */
header( 'header-type: text/html; charset=' . get_bloginfo( 'charset' ) );

?><!DOCTYPE html>
<?php echo apply_filters( '_basique_html_tag', '<html class="no-js" ' . get_language_attributes() . '>' ) ?>

	<head>
		<meta charset="<?php bloginfo( 'charset' ) ?>">

		<!--
		Eviter le FOUC v3.0
		@see http://www.paulirish.com/2009/avoiding-the-fouc-v3/
		-->
		<script>(function(e){e.className=e.className.replace(/\bno-js\b/,'js')})(document.documentElement)</script>

		<?php wp_head() ?>

		<meta name="copyright" content="<?php printf( __( 'Copyright © %1s %2s. All Rights Reserved.', '_basique' ), date( 'Y' ), get_bloginfo( 'name' ) ) ?>">
	</head>

	<body id="top" <?php body_class() ?>>
        <?php wp_body_open() ?>
		<div id="site-wrapper" class="wrapper">
			<div id="site" class="container">
				<div id="content-wrapper" class="wrapper">
					<div id="content" class="container">
