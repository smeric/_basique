<?php /* force UTF-8 : éàè */
/**
 * @package WordPress
 * @subpackage _basique
 **/

if ( is_registered_sidebar( 'primary' ) ):
	if ( is_active_sidebar( 'primary' ) ):
?>
	<div id="primary-sidebar-wrapper" class="wrapper">
		<aside id="primary-sidebar" class="container widget-area sidebar" role="complementary">
			<?php dynamic_sidebar( 'primary' ) ?>
		</aside><!-- #primary-sidebar -->
	</div><!-- #primary-sidebar-wrapper -->
<?php
	else:
		if ( current_user_can( 'edit_theme_options' ) ):
?>
	<div id="primary-sidebar-private-message" class="private-message">
		<a href="<?php echo admin_url( 'widgets.php' ); ?>"><?php _e( 'Add some widgets to the primary sidebar.', '_basique' ); ?></a>
	</div>
<?php
		endif;
	endif;
endif;
?>
