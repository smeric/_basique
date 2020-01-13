<?php /* force UTF-8 : éàè */
/**
 * @package WordPress
 * @subpackage _basique
 *
 * Loop Name: Posts List
 *
 * Utilisé par le plugin SiteOrigin Page Builder pour créer une boucle personnalisée.
 * @see https://siteorigin.com/premium-documentation/plugin-addons/custom-post-type-builder/display-content-using-widgets/
 **/

?>
	<section id="post-type-list" class="container siteorigin-post-loop-container">
		<ul class="post-types-list section-content siteorigin-post-loop loop-list">
<?php
			if ( have_posts() ) :
				while ( have_posts() ) :
					the_post(); 
?>
			<li id="<?php echo $post->post_type ?>-<?php the_ID() ?>" <?php post_class() ?>>
				<h2 class="entry-header entry-title">
					<a href="<?php the_permalink() ?>"><?php the_title() ?></a>
				</h2>
				<div class="entry-excerpt">
<?php
						if ( has_post_thumbnail() ) {
							?><a href="<?php the_permalink() ?>"><?php
                            /**
                             * Filtre appliqué à la taille de la vignette affichée à côté de l'extrait de la page.
                             *
                             * @since 0.1.0
                             *
                             * @param string La taille de la vignette.
                             **/
                            the_post_thumbnail(
                                apply_filters( '_basique_posts_list_thumbnail_size', 'medium' ),
                                apply_filters( '_basique_paginated_posts_list_thumbnail_args', array( 'class' => 'alignleft' ) )
                            );?></a><?php
						}
						the_excerpt();
?>
					<p class="read-more"><a href="<?php the_permalink() ?>"><?php _e( 'Read more <span class="meta-nav">&raquo;</span>', '_basique' ) ?></a></p>
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
	</section><!-- #page-list -->
