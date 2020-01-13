<?php /* force UTF-8 : éàè */
/**
 * Partie de bas de page commune à toutes les pages du site.
 * Modèle pour l'affichage des zones à widgets placées en haut et en bas de chaque page du site.
 *
 * @package WordPress
 * @subpackage _basique
 **/

?>
					</div><!-- #content -->
				</div><!-- #content-wrapper -->
<?php
				get_template_part( 'partials/sidebars/header' );
				get_template_part( 'partials/sidebars/footer' );
?>
			</div><!-- #site -->
		</div><!-- #site-wrapper -->

		<?php wp_footer() ?>

	</body>
</html>
