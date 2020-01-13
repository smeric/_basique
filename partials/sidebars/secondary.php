<?php /* force UTF-8 : éàè */
/**
 * @package WordPress
 * @subpackage _basique
 **/

if ( is_registered_sidebar( 'secondary' ) ):
	if ( is_active_sidebar( 'secondary' ) ):
?>
	<div id="secondary-sidebar-wrapper" class="wrapper">
		<aside id="secondary-sidebar" class="container widget-area sidebar" role="complementary">
			<?php dynamic_sidebar( 'secondary' ) ?>
		</aside><!-- #secondary-sidebar -->
	</div><!-- #secondary-sidebar-wrapper -->
<?php
	else:
		if ( current_user_can( 'edit_theme_options' ) ):
?>
	<div id="secondary-sidebar-private-message" class="private-message">
		<a href="<?php echo admin_url( 'widgets.php' ); ?>"><?php _e( 'Add some widgets to the secondary sidebar.', '_basique' ); ?></a>
	</div>
<?php
		endif;
	endif;
endif;
?>
