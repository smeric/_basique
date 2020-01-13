<?php /* force UTF-8 : éàè */
/**
 * @package WordPress
 * @subpackage _basique
 *
 * Template Name: Page sans sidebar
 **/

get_header()
?>
	<div id="main-wrapper" class="wrapper">
		<main id="main" class="container" role="main" aria-label="<?php _e( 'Main page content', '_basique' ) ?>">
<?php
			get_template_part( 'partials/loops/single', 'page' );
?>
		</main><!-- #main -->
	</div><!-- #main-wrapper -->
<?php
get_footer()
?>
