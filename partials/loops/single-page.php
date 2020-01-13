<?php /* force UTF-8 : éàè */
/**
 * @package WordPress
 * @subpackage _basique
 **/

the_post()
?>
	<section id="page-<?php the_ID() ?>" <?php post_class( 'container' ) ?>>
		<?php _basique_page_title( array(
			'before' => '<h1 class="entry-header section-header entry-title section-title">',
		)) ?>
		<div class="entry-content section-content">
			<?php the_content() ?>
		</div><!-- .entry-content -->
		<footer class="entry-footer section-footer">
<?php
			wp_link_pages( apply_filters( '_basique_entry_pagination', array(
				'before'           => '<div class="pagination container"><span class="label">' . __( 'Pages : ', '_basique' ) . '</span>',
				'after'            => '</div>' . PHP_EOL,
				'link_before'      => '<span class="page-number">',
				'link_after'       => '</span>',
				'nextpagelink'     => '<span class="next-page">' . __( 'Next page <span class="meta-nav">&raquo;</span>', '_basique' ) . '</span>',
				'previouspagelink' => '<span class="previous-page">' . __( '<span class="meta-nav">&laquo;</span> Previous page', '_basique' ) . '</span>',
			)));
?>
		</footer><!-- .entry-footer -->
	</section><!-- #page-<?php the_ID() ?> -->
