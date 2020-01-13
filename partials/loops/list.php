<?php /* force UTF-8 : éàè */
/**
 * @package WordPress
 * @subpackage _basique
 **/

?>
	<section id="page-list" class="container">
		<?php _basique_page_title() ?>
		<ul class="post-types-list section-content">
<?php
			if ( have_posts() ) :
				while ( have_posts() ) :
					the_post(); 
?>
			<li id="<?php echo $post->post_type ?>-<?php the_ID() ?>" <?php post_class() ?>>
				<h2 class="entry-header entry-title">
					<a href="<?php the_permalink() ?>"><?php the_title() ?></a>
				</h2>
				<div class="entry-content">
					<?php the_content( __( 'Read more <span class="meta-nav">&raquo;</span>', '_basique' ) ) ?>
				</div>
			</li>
<?php
				endwhile;

			/* Liste vide */
			else :
?>
			<li id="page-0" class="not-found last first page-0 page type-page status-publish format-standard hentry">
				<h2 class="entry-header entry-title">
					<?php _e( 'Not Found', '_basique' ) ?>
				</h2>
				<p class="entry-content"><?php _e( 'Sorry, but you are looking for something that isn&#8217;t here.', '_basique' ) ?></p>
			</li>
<?php
			endif;
?>
		</ul>
		<footer class="section-footer">
<?php
			// Pagination lorsque la liste est trop longue pour tenir sur une seule page.
			get_template_part( 'partials/navigations/list', apply_filters( '_basique_list_navigation', '' ) );
?>
		</footer>
	</section><!-- #page-list -->
