<?php /* force UTF-8 : éàè */
/**
 * @package WordPress
 * @subpackage _basique
 **/

?>
	<div id="header-wrapper" class="wrapper">
		<header id="header" class="container widget-area" role="banner">
<?php
			if ( is_registered_sidebar( 'header' ) ):
				if ( is_active_sidebar( 'header' ) ):
					dynamic_sidebar( 'header' );
				else:
					if ( current_user_can( 'edit_theme_options' ) ):
	?>
			<div id="header-private-message" class="private-message">
				<a href="<?php echo admin_url( 'widgets.php' ); ?>"><?php _e( 'Add some widgets to the header.', '_basique' ); ?></a>
			</div>
	<?php
					endif;
				endif;
			endif;

			if ( display_header_text() ) :
?>
			<div id="site-branding" class="container">
				<h1 id="site-title"><a href="<?php echo esc_url( home_url( '/' ) ) ?>" rel="home"><?php bloginfo( 'name' ) ?></a></h1>
				<h2 id="site-description"><?php bloginfo( 'description' ) ?></h2>
			</div><!-- #site-branding -->
<?php
			endif;

			wp_nav_menu( apply_filters( '_basique_header_menu', array(
				'theme_location'  => 'header',
				'container'       => 'nav',
				'container_id'    => 'header-menu-wrapper',
				'container_class' => 'wrapper site-navigation',
				'menu_id'         => 'header-menu',
				'menu_class'      => 'menu',
				'items_wrap'      => '<buton id="header-menu-toggle" aria-controls="header-menu" aria-expanded="false"><span class="screen-reader-text">' . __( 'Menu', '_basique' ) . '</span></buton>' . PHP_EOL . '<ul id="%1$s" class="%2$s">%3$s</ul>',
				// Deux niveaux de profondeur seulement pour éviter les sous-sous menus...
				'depth'           => 2,
				'fallback_cb'     => false,
			)));

			/**
			 * Permet l'ajout d'éléments dans l'en-tête.
			 *
			 * @since 0.1.0
			 **/
			do_action( '_basique_header_content' );
?>
		</header><!-- #header -->
	</div><!-- #header-wrapper -->


