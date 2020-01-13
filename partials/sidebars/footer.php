<?php /* force UTF-8 : éàè */
/**
 * @package WordPress
 * @subpackage _basique
 **/

?>
	<div id="footer-wrapper" class="wrapper">
		<footer id="footer" class="container widget-area" role="contentinfo">
<?php
			if ( is_registered_sidebar( 'footer' ) ):
				if ( is_active_sidebar( 'footer' ) ):
					dynamic_sidebar( 'footer' );
				else:
					if ( current_user_can( 'edit_theme_options' ) ):
	?>
			<div id="footer-private-message" class="private-message">
				<a href="<?php echo admin_url( 'widgets.php' ); ?>"><?php _e( 'Add some widgets to the footer.', '_basique' ); ?></a>
			</div>
	<?php
					endif;
				endif;
			endif;

			wp_nav_menu( apply_filters( '_basique_footer_menu', array(
				'theme_location'  => 'footer',
				'container'       => 'nav',
				'container_id'    => 'footer-menu-wrapper',
				'container_class' => 'wrapper site-navigation',
				'menu_id'         => 'footer-menu',
				'menu_class'      => 'container menu',
				'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
				// Pas de sous menus dans le pied de page...
				'depth'           => 1,
				'fallback_cb'     => false,
			)));

			/**
			 * Permet l'ajout d'éléments dans le pied de page.
			 *
			 * @since 0.1.0
			 **/
			do_action( '_basique_footer_content' );
?>
		</footer><!-- #footer -->
	</div><!-- #footer-wrapper -->
