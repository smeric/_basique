<?php /* force UTF-8 : éàè */
/**
 * @package WordPress
 * @subpackage _basique
 **/

/**
 * Configuration et déclaration des fonctionnalités WordPress spécifiques du thème.
 *
 * @since _basique 0.1.0
 **/
if ( ! function_exists( '_basique_setup_theme' ) ) :
	add_action( 'after_setup_theme', '_basique_setup_theme' );

	function _basique_setup_theme() {
		/**
		 * Internationalisation du thème.
		 *
		 * Les fichiers de traduction peuvent être placés dans trois dossiers différents. Les trois
		 * emplacements seront examinés l'un après l'autre jusqu'à ce que l'un d'entre eux contienne
		 * le fichier recherché (traduction.mo). C'est donc le premier emplacement contenant ce fichier
		 * qui sera retenu et ce fichier de traduction qui sera utilisé. L'ordre est définit comme suit :
		 *
		 *  1 - wp-content/languages/themes/_basique/traduction.mo
		 *      L'ntéret principal de déposer les fichiers de traduction à cet endroit est de permettre
		 *      la mise à jour du thème "_basique" sans risquer d'écraser des traduction personnalisées.
		 *      En effet, les traductions placées dans le dossier "language" du thème sont mises à jour
		 *      en même temps que le thème.
		 *
		 *  2 - wp-content/themes/child-theme-name/languages/traduction.mo
		 *      Si un thème enfant de "_basique" existe, que c'est le thème que vous utilisez, et que le
		 *      fichier de traduction n'a pas déjà été trouvé ci-dessus, c'est logiquement dans le dossier
		 *      "language" de ce thème que sera ensuite cherché le fichier de traduction. Il est à noter
		 *      que si ce thème est mis à jour automatiquement, toutes les modifications de traduction
		 *      personnalisées seront perdu. Si c'est vous qui avez créé ce thème, c'est la place idéale
		 *      pour y déposer les fichiers de traduction de votre thème.
		 *
		 *  3 - wp-content/themes/_basique/languages/traduction.mo
		 *      Les fichiers de traduction originaux du thème "_basique" sont disponible ici. Ce sont les
		 *      fichiers qui seront utilisés par défaut si aucun n'est disponible dans les dossiers cités
		 *      aux points 1 et 2 ci-dessus.
		 *
		 * @since 0.1.1
		 *
		 * @see https://ulrich.pogson.ch/load-theme-plugin-translations
		 **/

		// 1 - Fichiers protégés contre les mises à jour : wp-content/languages/themes/_basique/traduction.mo
		load_theme_textdomain( '_basique', trailingslashit( WP_LANG_DIR ) . 'themes/_basique' );

		// 2 - Fichiers du thème enfant : wp-content/themes/_basique-child-theme/languages/parent-theme/traduction.mo
		load_theme_textdomain( '_basique', get_stylesheet_directory() . '/languages/parent-theme' );

		// 3 - Fichiers présents par défaut : wp-content/themes/_basique/languages/traduction.mo
		load_theme_textdomain( '_basique', get_template_directory() . '/languages' );

		// Force la taille des vignettes par défaut (hard crop)
		add_image_size( 'medium', get_option( 'medium_size_w' ), get_option( 'medium_size_h' ), true );
		add_image_size( 'large', get_option( 'large_size_w' ), get_option( 'large_size_h' ), true );

		// Utilisation du code HTML5 valide pour le formulaire de recherche.
		add_theme_support( 'html5', array(
			'search-form',
		));

		// Configuration de l'en-tête personnalisée.
		add_theme_support( 'custom-header', apply_filters( '_basique_custom_header_args', array(
			'default-text-color'     => '1a1a1a',
			'wp-head-callback'       => '_basique_custom_header_wp_head',
			'admin-head-callback'    => '_basique_custom_header_admin_head',
			'admin-preview-callback' => '_basique_custom_header_admin_preview',
		) ) );

		// Configuration de fond de page personnalisé.
		add_theme_support( 'custom-background', apply_filters( '_basique_custom_background_args', array(
			'default-color' => 'fff',
		)));

		// Gestion interne de la génération du titre de la page.
		add_theme_support( 'title-tag' );

		// Ce thème utilise des menus WordPress dans les deux barres latérales (sidebar)
		// de l'entête (header) et du pied de page (footer).
		register_nav_menus( array(
			'header' => __( 'Header menu', '_basique' ),
			'footer' => __( 'Footer menu', '_basique' ),
		) );

		/**
		 * Déclenché après l'initialisation du thème. Permet d'ajouter des fonctionnalités.
		 *
		 * @since 0.1.0
		 **/
		do_action( '_basique_setup_theme' );
	}
endif;


/**
 * Déclaration et utilisation de la librairie Javascript jQuery le plus tôt possible (priorité 1).
 *
 * Voir https://wordpress.org/plugins/wp-jquery-plus/
 *
 * @since _basique 0.1.0
 **/
if ( ! function_exists( '_basique_enqueue_jquery_scripts' ) ) :
	add_action( 'wp_enqueue_scripts', '_basique_enqueue_jquery_scripts', 1 );

	function _basique_enqueue_jquery_scripts() {
		global $wp_version;

		if ( ! is_admin() ) {
			wp_enqueue_script( 'jquery' );

			// On récupère les versions de jQuery et jQuery migrate utilisées par WordPress :
			// Le filtre est là pour permettre l'utilisation d'une autre version...
			// Versions disponibles :
			//     https://cdnjs.com/libraries/jquery
			//     https://developers.google.com/speed/libraries/#jquery
			$wp_jquery_ver = apply_filters( '_basique_jquery_version', $GLOBALS['wp_scripts']->registered['jquery-core']->ver );
			$wp_jquery_migrate_ver = apply_filters( '_basique_jquery_migrate_version', $GLOBALS['wp_scripts']->registered['jquery-migrate']->ver );

			// Si vous souhaitez charger les librairies depuis cdnjs au lieu de Google :
			// add_filter( '_basique_jquery_use_google_cdn', '__return_false' );
			$use_google = apply_filters( '_basique_jquery_use_google_cdn', true );

			// Librairie jQuery :
			if ( ! $use_google ) {
				$jquery_cdn_url = '//cdnjs.cloudflare.com/ajax/libs/jquery/'. $wp_jquery_ver .'/jquery.min.js';
			}
			else {
				$jquery_cdn_url = '//ajax.googleapis.com/ajax/libs/jquery/'. $wp_jquery_ver .'/jquery.min.js';
			}

			// Librairie jQuery compatible avec IE8 ou inferieur :
			$jquery_ie = version_compare( $wp_jquery_ver, '1.11.2' );
			if ( $jquery_ie ) {
				if ( ! $use_google ) {
					$jquery_ie_cdn_url = '//cdnjs.cloudflare.com/ajax/libs/jquery/1.11.2/jquery.min.js';
				}
				else {
					$jquery_ie_cdn_url = '//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js';
				}
			}

			// Librairie jQuery migrate :
			$jquery_migrate_cdn_url = '//cdnjs.cloudflare.com/ajax/libs/jquery-migrate/'. $wp_jquery_migrate_ver .'/jquery-migrate.min.js';

			// Supprime les versions courantes de jQuery et jQuery Migrate...
			wp_deregister_script( 'jquery-core' );
			wp_deregister_script( 'jquery-migrate' );

			// ... au profit de leurs versions hébergées sur CDN
			if ( $jquery_ie ) {
				wp_register_script( 'jquery-old', $jquery_ie_cdn_url, '', null, true );
				wp_enqueue_script( 'jquery-old' );
				wp_script_add_data( 'jquery-old', 'conditional', 'lt IE 9' );
			}
			wp_register_script( 'jquery-core', $jquery_cdn_url, ( $jquery_ie ? array( 'jquery-old' ) : '' ), null, true );
			wp_register_script( 'jquery-migrate', $jquery_migrate_cdn_url, array( 'jquery-core' ), null, true );

		}
	}
endif;


/**
 * Ajoute la librairie jQuery présente en locale si le CDN ne répond pas.
 *
 * Voir https://wordpress.org/plugins/wp-jquery-plus/
 *
 * @since _basique 0.1.0
 * 
 * @param  string $src
 * @param  string $handle
 * @return string
 */
if ( ! function_exists( '_basique_jquery_local_fallback' ) ) :
	add_filter('script_loader_src', '_basique_jquery_local_fallback', 10, 2 );

	function _basique_jquery_local_fallback( $src, $handle = null ) {
		global $wp_version;

		if ( ! is_admin() ){
			static $add_jquery_fallback         = false;
			static $add_jquery_migrate_fallback = false;
			static $add_jquery_ie_fallback      = false;

			$wp_jquery_ver = apply_filters( '_basique_jquery_version', $GLOBALS['wp_scripts']->registered['jquery-core']->ver );
			$jquery_ie = version_compare( $wp_jquery_ver, '1.11.2' );

			if ( $add_jquery_fallback ){
				echo ( $jquery_ie ? '<!--[if gte IE 9]><!-->' . PHP_EOL : '' ), '<script>window.jQuery || document.write(\'<script src="', includes_url( 'js/jquery/jquery.js' ), '"><\/script>\')</script>', ( $jquery_ie ? PHP_EOL . '<!--<![endif]-->' : '' ), PHP_EOL;
				$add_jquery_fallback = false;
			}
			elseif ( $add_jquery_ie_fallback && $jquery_ie ) {
				echo '<!--[if lt IE 9]>', PHP_EOL, '<script>window.jQuery || document.write(\'<script src="', trailingslashit( get_stylesheet_directory_uri() ), 'assets/js/jquery-1.11.2.min.js"><\/script>\')</script>', PHP_EOL, '<![endif]-->', PHP_EOL;
				$add_jquery_ie_fallback = false;
			}
			elseif ( $add_jquery_migrate_fallback ){
				echo '<script>window.jQuery.migrateMute || document.write(\'<script src="', includes_url( 'js/jquery/jquery-migrate.min.js' ), '"><\/script>\')</script>', PHP_EOL;
				$add_jquery_migrate_fallback = false;
			}

			if ( 'jquery-core' === $handle ){
				$add_jquery_fallback = true;
			}
			elseif ( 'jquery-old' === $handle ){
				$add_jquery_ie_fallback = true;
			}
			elseif ( 'jquery-migrate' === $handle ){
				$add_jquery_migrate_fallback = true;
			}
		}
		return $src;
	}
endif;


/**
 * On limite les versions récentes de jQuery à IE >= 9.
 *
 * @since _basique 0.1.0
 * 
 * @param  string $tag
 * @param  string $handle
 * @return string
 **/
if ( ! function_exists( '_basique_conditionaly_enqueue_jquery_script' ) ) :
	add_filter( 'script_loader_tag', '_basique_conditionaly_enqueue_jquery_script', 10, 2 );

	function _basique_conditionaly_enqueue_jquery_script( $tag, $handle = null ) {
		global $wp_version;

		$wp_jquery_ver = apply_filters( '_basique_jquery_version', $GLOBALS['wp_scripts']->registered['jquery-core']->ver );
		if ( 'jquery-core' === $handle && version_compare( $wp_jquery_ver, '1.11.2' ) ) {
			$tag = '<!--[if gte IE 9]><!-->' . PHP_EOL . $tag . '<!--<![endif]-->' . PHP_EOL;
		}
		return $tag;
	}
endif;


/**
 * Déclaration et utilisation des styles
 *
 * @since _basique 0.1.0
 **/
if ( ! function_exists( '_basique_enqueue_styles' ) ) :
	add_action( 'wp_enqueue_scripts', '_basique_enqueue_styles' );

	function _basique_enqueue_styles() {
		global $wp_styles;

		// Informations sur le thème courrant
		$current_theme = wp_get_theme( '_basique' );

		// Ajoutons un paramètre de valeur différente à chaque rechargement en mode débugage pour éviter les problèmes de cache
		$no_cache = is_debug_mode() ? time() : $current_theme->get( 'Version' );

		// Si l'on se trouve dans un thème enfant, déclaration et utilisation de la feuille de styles du thème parent
		if ( is_child_theme() ) {
			wp_enqueue_style( '_basique-parent-stylesheet', trailingslashit( get_template_directory_uri() ) . 'assets/css/style.css', false, $no_cache );
		}
		// Déclaration et utilisation de la feuille de styles du thème courant
		wp_enqueue_style( '_basique-stylesheet', trailingslashit( get_stylesheet_directory_uri() ) . 'assets/css/style.css', false, $no_cache );

		/**
		 * Déclanché après l'ajout du fichier Javascriot externe et des feuilles de style prévu par défaut dans ce thème.
		 *
		 * @since 0.1.0
		 **/
		do_action( '_basique_enqueue_styles' );
	}
endif;


/**
 * Déclaration et utilisation des scripts javascript
 *
 * @since _basique 0.1.0
 **/
if ( ! function_exists( '_basique_enqueue_scripts' ) ) :
	add_action( 'wp_enqueue_scripts', '_basique_enqueue_scripts' );

	function _basique_enqueue_scripts() {
		// Informations sur le thème courrant
		$current_theme = wp_get_theme();

		// Ajoutons un paramètre de valeur différente à chaque rechargement en mode débugage pour éviter les problèmes de cache
		$no_cache = is_debug_mode() ? time() : $current_theme->get( 'Version' );
		// Débugage des scripts
		$script_debug = is_debug_mode() && ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG || isset( $_GET['debug'] ) );
		// Utilisons les versions minifiées en production et les versions lisibles en mode débugage
		$js_suffix = $script_debug ? '.js' : '.min.js';

		// html5shiv permet la reconnaissance des balises HTML5 par les anciennes versions d'Internet Explorer (8 ou précédente).
		// https://github.com/afarkas/html5shiv
		wp_register_script( 'html5shiv', trailingslashit( get_template_directory_uri() ) . 'assets/js/html5shiv-printshiv' . $js_suffix, false, $no_cache );
		wp_enqueue_script( 'html5shiv' );
		wp_script_add_data( 'html5shiv', 'conditional', 'lt IE 9' );

		// css3-mediaqueries permet à IE 5+, Firefox 1+ et Safari 2 l'implémentation des Media Queries CSS3.
		// https://code.google.com/p/css3-mediaqueries-js/
		// see also : https://github.com/scottjehl/Respond
		wp_register_script( 'css3-mediaqueries', trailingslashit( get_template_directory_uri() ) . 'assets/js/css3-mediaqueries' . $js_suffix, false, $no_cache );
		wp_enqueue_script( 'css3-mediaqueries' );
		wp_script_add_data( 'css3-mediaqueries', 'conditional', 'lt IE 9' );

		// Déclaration et utilisation de scripts Javascript spécifiques au thème
		wp_register_script( '_basique-scripts', trailingslashit( get_template_directory_uri() ) . 'assets/js/scripts' . $js_suffix, array( 'jquery' ), $no_cache, true );
		wp_enqueue_script( '_basique-scripts' );

		// Localisation des scripts : permet le passage d'information accessibles via PHP vers Javascript
		$_basique_scripts = array(
            'theme'             => esc_js( $current_theme->get( 'Name' ) . ' ' . $current_theme->get( 'Version' ) ),
			'site_url'          => trailingslashit( home_url() ),
			'parent_theme_url'  => trailingslashit( get_template_directory_uri() ),
			'theme_url'         => trailingslashit( get_stylesheet_directory_uri() ),
			'ajaxurl'           => admin_url( 'admin-ajax.php' ),
			'page_shortlink'    => wp_get_shortlink(),
			'is_debug'          => is_debug_mode() ? true : false,
			// Traduction de chaines de caractères
			'entering_debug'    => esc_attr__( 'Entering debug mode...', '_basique' ),
			'viewport_size'     => esc_attr__( 'Viewport size : ', '_basique' ),
            'self_xss_title'    => esc_attr__( 'Wait! This area is meant for developers!', '_basique' ),
            'self_xss_text'     => esc_attr__( 'If someone told you to type or paste something into this area it could compromise the security of your personal informations. Do not do it unless you know exactly what you are doing !', '_basique' ),
            'self_xss_link'     => esc_attr__( 'More information : https://en.wikipedia.org/wiki/Self-XSS', '_basique' ),
		);
		wp_localize_script( '_basique-scripts', 'GLOBALS', $_basique_scripts );

		/**
		 * Déclanché après l'ajout du fichier Javascript externe et des feuilles de style prévu par défaut dans ce thème.
		 *
		 * @since 0.1.0
		 **/
		do_action( '_basique_enqueue_scripts' );
	}
endif;


/**
 * Ajout de déclarations dans le header
 *
 * @since _basique 0.1.0
 **/
if ( ! function_exists( '_basique_wp_head' ) ) :
	add_action( 'wp_head', '_basique_wp_head', 0 );
	function _basique_wp_head() {
		/**
		 * Déclaration basic de la favicon.
		 * @see http://www.alsacreations.com/outils/lire/1598-real-favicon-generator.html
		 *
		 * @since _basique 0.1.0
		 **/
		$favicon = PHP_EOL . "\t\t" . '<link rel="shortcut icon" href="' . get_stylesheet_directory_uri() . '/assets/images/favicon.ico">' . PHP_EOL;
		echo apply_filters( '_basique_favicon_links', $favicon );

		/**
		 * Adapte automatiquement la largeur de viewport à la valeur de device-width du terminal.
		 * Le zoom initial, minimal et maximal est fixé à 1.
		 * Le zoom est interdit.
		 * @see http://www.alsacreations.com/article/lire/1490-comprendre-le-viewport-dans-le-web-mobile.html
		 * @see http://media-queries.aliasdmc.fr/meta_viewport_et_viewport_css_mobile.php
		 *
		 * La balise <meta> autorise ces valeurs :
		 *
		 * width
		 *  Largeur de fenêtre viewport. La propriété width accepte comme valeur un entier
		 *  positif ou le mot clé device-width qui correspond à la largeur de l'appareil disponible.
		 * height
		 *  Hauteur de fenêtre viewport. La propriété height accepte comme valeur un entier
		 *  positif ou le mot clé device-height qui correspond à la hauteur de l'appareil disponible.
		 * initial-scale
		 *  Niveau de zoom initial (par exemple initial-scale="1.0"). 0.0 < initial-scale <= 10.0
		 * minimum-scale
		 *  Niveau de zoom minimal (par exemple minimum-scale="0.5"). 0.0 < minimum-scale <= 10.0
		 * maximum-scale
		 *  Niveau de zoom maximal (par exemple maximum-scale="3.0"). Attention, la valeur "1.0" interdit
		 *  le zoom et peut rendre vos pages inaccessibles. 0.0 < maximum-scale <= 10.0
		 * user-scalable
		 *  Possibilité à l'utilisateur de zoomer (par exemple user-scalable="yes"). Attention, la valeur
		 *  "no" interdit le zoom et peut rendre vos pages inaccessibles
		 * target-densitydpi
		 *  Choix de résolution, en dpi, de l'affichage général (spécifique Webkit et semble avoir été abandonné)
		 *  Valeurs possibles :
		 *  device-dpi : Indique que la densité de pixels d'origine de l'appareil doit être utilisée.
		 *               Mise à l'échelle par défaut ne se produit jamais.
		 *  high-dpi : Indique que le contenu est destiné aux écrans à haute densité.
		 *  medium-dpi : Indique que le contenu est destiné aux écrans de moyenne densité.
		 *  low-dpi : Indique que le contenu est destiné aux écrans à faible densité. 
		 *  Nombre entier positif : Indique une valeur dpi entre 70 et 400 pour l'utiliser comme cible dpi. 
		 *
		 * @since _basique 0.1.0
		 **/
		$meta_values = apply_filters( '_basique_viewport_values', array(
			'width'         => 'device-width',
			'initial-scale' => '1.0',
			'minimum-scale' => '1.0',
			'maximum-scale' => '1.0',
			'user-scalable' => 'no',
			'minimal-ui'    => '', // Réduit l’interface Safari mobile au minimum sous iOS 7.
		));
		$meta_value = array();
		foreach ( $meta_values as $key => $value ) {
			$meta_value[] = $key . ( '' !== $value ? '=' . $value : '' );
		}
		$meta = PHP_EOL . "\t\t" . '<meta name="viewport" content="' . implode( ', ', $meta_value ) . '">' . PHP_EOL;
		echo apply_filters( '_basique_viewport_meta', $meta );

		/**
		 * Force le moteur de rendu de la dernière version disponible d'Internet Explorer
		 * ou l'utilisation de Chrome Frame si installé sur le poste client.
		 * @see http://www.alsacreations.com/astuce/lire/1437-comment-interdire-le-mode-de-compatibilite-sur-ie.html
		 *
		 * @since _basique 0.1.0
		 **/
		$ie = PHP_EOL . "\t\t" . '<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">' . PHP_EOL;
		echo apply_filters( '_basique_ie_x_ua_compatible', $ie );
	}
endif;


/**
 * Enregistrement des zones à widgets.
 *
 * @since _basique 0.1.0
 *
 * Si vous utilisez ce thème comme "thème parent", voici la méthode pour
 * supprimer des barres lattérales (sidebars) dans votre "thème enfant" :
 *
 * add_action( 'widgets_init', '_basique_childtheme_unregister_sidebars', 11 );
 * function _basique_childtheme_unregister_sidebars() {
 *	 unregister_sidebar( 'primary' );
 * }
 **/
if ( ! function_exists( '_basique_register_sidebars' ) ) :
	add_action( 'widgets_init', '_basique_register_sidebars' );

	function _basique_register_sidebars() {
		register_sidebar(array(
			'name'			=> __( 'Header', '_basique' ),
			'id'			=> 'header',
			'description'	=> __( 'The header widget area.', '_basique' ),
			'before_widget'	=> '<div id="%1$s" class="widget %2$s">'.PHP_EOL,
			'after_widget'	=> '</div>'.PHP_EOL,
			'before_title'	=> '<h4 class="widget-title">',
			'after_title'	=> '</h4>'
		));
		register_sidebar(array(
			'name'			=> __( 'Primary', '_basique' ),
			'id'			=> 'primary',
			'description'	=> __( 'The primary sidebar.', '_basique' ),
			'before_widget'	=> '<div id="%1$s" class="widget %2$s">'.PHP_EOL,
			'after_widget'	=> '</div>'.PHP_EOL,
			'before_title'	=> '<h4 class="widget-title">',
			'after_title'	=> '</h4>'
		));
		register_sidebar(array(
			'name'			=> __( 'Seconary', '_basique' ),
			'id'			=> 'secondary',
			'description'	=> __( 'The secondary sidebar.', '_basique' ),
			'before_widget'	=> '<div id="%1$s" class="widget %2$s">'.PHP_EOL,
			'after_widget'	=> '</div>'.PHP_EOL,
			'before_title'	=> '<h4 class="widget-title">',
			'after_title'	=> '</h4>'
		));
		register_sidebar(array(
			'name'			=> __( 'Footer', '_basique' ),
			'id'			=> 'footer',
			'description'	=> __( 'The footer widget area.', '_basique' ),
			'before_widget'	=> '<div id="%1$s" class="widget %2$s">'.PHP_EOL,
			'after_widget'	=> '</div>'.PHP_EOL,
			'before_title'	=> '<h4 class="widget-title">',
			'after_title'	=> '</h4>'
		));

		/**
		 * Déclanché après l'enregistrement des 4 colonnes latérales prévu par défaut.
		 *
		 * @since 0.1.0
		 **/
		do_action( '_basique_register_sidebars' );
	}
endif;


/**
 * Création d'un élément "title" correctement formaté et spécifique
 * destiné à être présent dans l'entête (header) de chaque page.
 *
 * @see Twenty Twelve 1.0
 *
 * @since _basique 0.1.0
 *
 * @param string $title Titre par défaut associé à la page courante.
 * @param string $sep Separateur optionel.
 * @return string $title Titre mis à jour.
 **/
if ( ! function_exists( '_basique_wp_title' ) ) :
	add_filter( 'wp_title', '_basique_wp_title', 10, 2 );

	function _basique_wp_title( $title, $sep ) {
		global $paged, $page;

		if ( is_feed() ) {
			return $title;
		}

		// Ajout du nom du site.
		$title .= get_bloginfo( 'name' );

		// Ajout de la description du site à la page d'accueil.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) ) {
			$title = "$title $sep $site_description";
		}

		// Ajout de la pagination si nécessaire.
		if ( $paged >= 2 || $page >= 2 ) {
			$title = "$title $sep " . sprintf( __( 'Page %s', '_basique' ), max( $paged, $page ) );
		}

		/**
		 * Filtre appliqué au titre de chaque page (balise HTML "title").
		 *
		 * @since 0.1.0
		 *
		 * @param string $title Le titre de la page.
		 * @param string $sep Séparateur.
		 **/
		$title = apply_filters( '_basique_wp_title', $title, $sep );

		return $title;
	}
endif;


/**
 * Ajoute les information WAI ARIA aux menu de l'entête (header) et du pied de page (footer).
 *
 * @link http://www.lesintegristes.net/2008/12/09/introduction-a-wai-aria-traduction/
 *
 * @since _basique 0.1.0
 *
 * @param string $nav_menu Le contenu HTML du menu de navigation.
 * @param object $args Arguments de {@see wp_nav_menu()}.
 * @return string $nav_menu Contenu HTML du menu mis à jour.
 **/
if ( ! function_exists( '_basique_wp_nav_menu' ) ) :
	add_filter( 'wp_nav_menu', '_basique_wp_nav_menu', 10, 2 );

	function _basique_wp_nav_menu( $nav_menu, $args ) {
		$nav_menu = preg_replace( '/<nav/', '<nav role="navigation"', $nav_menu );
		if( 'header' === $args->theme_location ){
			$nav_menu = preg_replace( '/<nav/', '<nav aria-label="' . __( 'Primary navigation', '_basique' ) . '"', $nav_menu );
		}
		elseif( 'footer' === $args->theme_location ){
			$nav_menu = preg_replace( '/<nav/', '<nav aria-label="' . __( 'Secondary navigation', '_basique' ) . '"', $nav_menu );
		}

		/**
		 * Filtre appliqué au contenu HTM des menus de navigation.
		 *
		 * @since 0.1.0
		 *
		 * @param string $nav_menu Le contenu HTML du menu de navigation.
		 * @param object $args Arguments de {@see wp_nav_menu()}.
		 **/
		$nav_menu = apply_filters( '_basique_wp_nav_menu', $nav_menu, $args );

		return $nav_menu;
	}
endif;


/**
 * Remplace le traditionel "[...]" à la fin du résumé (excerpt) par "...".
 *
 * @since _basique 0.1.0
 *
 * @param string $more Le marqueur de cloture du résumé.
 * @return string $more Le nouveau marqueur de cloture du résumé.
 **/
if ( ! function_exists( '_basique_excerpt_more' ) ) :
	add_filter( 'excerpt_more', '_basique_excerpt_more' );

	function _basique_excerpt_more( $more ) {
		if( is_search() ) {
			$more = '...';
		}

		/**
		 * Filtre appliqué à l'élément qui vient cloturer le résumé.
		 *
		 * @since 0.1.0
		 *
		 * @param string $more Le marqueur de cloture du résumé.
		 **/
		$more = apply_filters( '_basique_excerpt_more', $more );

		return $more;
	}
endif;


/*** *** *** *** *** Gestion des commentaires *** *** *** *** ***/

/**
 * Supprime le lien vers le flux RSS des commentaires là où il n'a pas lieu d'apparaitre.
 *
 * @since _basique 0.1.0
 *
 * @param string $url L'url du flux RSS associé aux commentaires.
 * @return string $url L'url du flux RSS associé aux commentaires.
 **/
if ( ! function_exists( '_basique_remove_comments_rss' ) ) :
	add_filter( 'post_comments_feed_link', '_basique_remove_comments_rss' );

	function _basique_remove_comments_rss( $url ) {
		global $post;

		if ( !post_type_supports( $post->post_type, 'comments' ) ) {
			return '';
		}

		return $url;
	}
endif;


/**
 * Supprime le support des commentaires pour les types de post "page".
 *
 * @since _basique 0.1.0
 **/
if ( ! function_exists( '_basique_remove_page_comments_support' ) ) :
	//add_action( 'init', '_basique_remove_page_comments_support', 11 );

	function _basique_remove_page_comments_support() {
		remove_post_type_support( 'page', 'comments' );
	}
endif;


/**
 * Supprime de l'en-tête de chaque page du site les styles appliqués au widget
 * listant les commentaires récents
 *
 * @since _basique 0.1.0
 */
if ( ! function_exists( '_basique_remove_wp_widget_recent_comments_style' ) ) :
	add_action( 'widgets_init', '_basique_remove_wp_widget_recent_comments_style' );

	function _basique_remove_wp_widget_recent_comments_style() {
		global $wp_widget_factory;

		if ( isset( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'] ) )
			remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
	}
endif;


/**
 * Ajouter des classes au body.
 *
 * @since _basique 0.1.0
 *
 * @param   array  $classes  Les classes qui apparaissent dans la balise body.
 * @return  array  $classes
 */
if ( ! function_exists( '_basique_body_classes' ) ) :
	add_filter( 'body_class', '_basique_body_classes' );

	function _basique_body_classes( $classes ) {
		global $template;

		$current_page_template = is_page_template() ? basename( get_page_template() ) : '';

		$classes[] = $current_page_template ? str_replace( '.', '-', $current_page_template . '-template' ) : str_replace( '.', '-', basename( $template ) . '-template' );

		// En fonction de la présence ou non des sidebars
		if ( is_active_sidebar( 'header' ) ) {
			$classes[] = 'has-header-sidebar';
		}
		if ( 'full-page.php' !== $current_page_template && 'home-page.php' !== $current_page_template ) {
			if ( is_active_sidebar( 'primary' ) || 'primary-sidebar-page.php' === $current_page_template ) {
				$classes[] = 'has-primary-sidebar';
			}
			if ( is_active_sidebar( 'secondary' ) ) {
				$classes[] = 'has-secondary-sidebar';
			}
			if ( is_active_sidebar( 'secondary' ) && is_active_sidebar( 'primary' ) ) {
				$classes[] = 'has-both-sidebars';
			}
			if ( ! is_active_sidebar( 'secondary' ) && ! is_active_sidebar( 'primary' ) ) {
				$classes[] = 'full-width';
			}
		}
		else {
			$classes[] = 'full-width';
		}
		if ( is_active_sidebar( 'footer' ) ) {
			$classes[] = 'has-footer-sidebar';
		}

		// Lorsqu'on se trouve en mode debug
		if ( is_debug_mode() ) {
			$classes[] = 'debug';
		}

		// Thème courant et possible thème parent
		$current_theme = wp_get_theme();
		$classes[] = 'current-theme-' . $current_theme->get( 'Name' );
		if ( $parent_theme = $current_theme->get( 'Template' ) ) {
			$classes[] = 'parent-theme-' . $parent_theme;
		}

		/**
		 * Filtre appliqué à la liste des classes appliquées au tag body.
		 *
		 * @since 0.1.0
		 *
		 * @param array $classes Liste des classes appliquées au tag body.
		 **/
		$classes = apply_filters( '_basique_body_classes', $classes );

		return $classes;
	}
endif;


/*** *** *** *** *** Template tags *** *** *** *** ***/

/**
 * Titre affiché en en-tête de chaque page.
 *
 * @since _basique 0.1.0
 **/
if ( ! function_exists( '_basique_page_title' ) ) :
	function _basique_page_title( $args = array() ) {
		global $wp_query;

		$defaults = array(
			'before' => '<h1 class="section-header section-title">',
			'after'  => '</h1>',
			'echo'   => true,
		);
		$args = wp_parse_args( $args, $defaults );
        extract( $args );

		if( is_search() ) {
			$found = $wp_query->found_posts;
			$searched = esc_attr( get_search_query() );
			if ( !$found ) {
				$title = sprintf( __( 'No result found for <em>&ldquo;%s&rdquo;</em>', '_basique' ), $searched );
			}
			else {
				$title = sprintf( _n( 'One result for <em>&ldquo;%2$s&rdquo;</em>', '%1$s results for <em>&ldquo;%2$s&rdquo;</em>', $found, '_basique' ), number_format_i18n( $found ), $searched );
			}

			/**
			 * Filtre appliqué au titre de la page recherche.
			 *
			 * @since 0.1.0
			 *
			 * @param string $before . $title . $after Le titre de la page recherche.
			 * @param array $args Les paramètres reçu par la fonction.
			 * @param string $searched La chaine de caractères cherchés.
			 * @param number $found Le nombre de résultats.
			 **/
			$title = apply_filters( '_basique_search_page_title', $before . $title . $after, $args, $searched, $found );
		}
		elseif ( is_archive() ) {
			$title = __( 'Archives', '_basique' );

			/**
			 * Filtre appliqué au titre de toutes les pages d'archives.
			 *
			 * @since 0.1.0
			 *
			 * @param string $before . $title . $after Le titre par défaut d'une page d'archive.
			 * @param array $args Les paramètres reçu par la fonction.
			 **/
			$title = apply_filters( '_basique_default_archive_page_title', $before . $title . $after, $args );
		}
		elseif ( is_404() ) {
			$title = __( 'Not Found', '_basique' );

			/**
			 * Filtre appliqué au titre de la page d'erreur 404 : aucun contenu trouvé.
			 *
			 * @since 0.1.0
			 *
			 * @param string $before . $title . $after Le titre par défaut d'une page d'erreur 404.
			 * @param array $args Les paramètres reçu par la fonction.
			 **/
			$title = apply_filters( '_basique_404_page_title', $before . $title . $after, $args );
		}
		elseif ( is_single() ) {
			$title = get_the_title();

			/**
			 * Filtre appliqué au titre de tous les posts seuls.
			 *
			 * @since 0.1.0
			 *
			 * @param string $before . $title . $after Le titre par défaut d'une page d'article seul.
			 * @param array $args Les paramètres reçu par la fonction.
			 **/
			$title = apply_filters( '_basique_single_title', $before . $title . $after, $args );
		}
		elseif ( is_page() ) {
			$title = get_the_title();

            // Doit-on afficher le titre sur cette page ?
            $hide_title = intval( get_post_meta( get_the_ID(), '_basique_hide_page_title', true ) );

			/**
			 * Filtre appliqué au titre de toutes les posts de type page.
			 *
			 * @since 0.1.0
			 *
			 * @param string $before . $title . $after Le titre par défaut d'une page.
			 * @param array $args Les paramètres reçu par la fonction.
			 **/
			$title = apply_filters( '_basique_page_title', $hide_title ? '' : $before . $title . $after, $args );
		}
		elseif ( is_singular() ) {
			$title = get_the_title();

			/**
			 * Filtre appliqué au titre de toutes les pages de posts seuls (articles, pages...).
			 *
			 * @since 0.1.0
			 *
			 * @param string $before . $title . $after Le titre par défaut d'une page ou d'un article.
			 * @param array $args Les paramètres reçu par la fonction.
			 **/
			$title = apply_filters( '_basique_singular_title', $before . $title . $after, $args );
		}
		elseif ( is_home() ) {
            // ID de la page statique qui affiche la liste des derniers articles du blog
            $page_id = get_option( 'page_for_posts' );

			$title = get_the_title( $page_id );

            // Doit-on afficher son titre ?
            $hide_title = intval( get_post_meta( $page_id, '_basique_display_page_title', true ) );

			/**
			 * Filtre appliqué au titre de la page statique de liste des articles.
			 *
			 * @since 0.1.0
			 *
			 * @param string $before . $title . $after Le titre par défaut d'une page ou d'un article.
			 * @param array $args Les paramètres reçu par la fonction.
			 **/
			$title = apply_filters( '_basique_blog_post_list_title', $hide_title ? '' : $before . $title . $after, $args );
		}
		else {
			$title = '';

			/**
			 * Filtre appliqué au titre d'une page dans n'importe quel autre cas.
			 *
			 * @since 0.1.0
			 *
			 * @param string $before . $title . $after Le titre par défaut d'une page de liste.
			 * @param array $args Les paramètres reçu par la fonction.
			 **/
			$title = apply_filters( '_basique_default_page_title', $before . $title . $after, $args );
		}

		/**
		 * Filtre appliqué à tous les titres.
		 *
		 * @since 0.1.0
		 *
		 * @param string $title Le titre par défaut d'une page de liste.
		 * @param array $args Les paramètres reçu par la fonction.
		 **/
		$title = apply_filters( '_basique_all_titles', $title, $args );

		if ( $title ) {
			if ( $echo ) {
				echo $title;
			}
			else {
				return $title;
			}
		}
	}
endif;


/**
 * Pagination personnalisée avec les numéros des pages
 *
 * @since _basique 0.1.0
 *
 * @source http://wpengineer.com/2133/wordpress-pagination-again/
 */
if ( ! function_exists( '_basique_paginate_links' ) ) :
	function _basique_paginate_links() {
		global $wp_rewrite, $wp_query;

		$wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;
		$pages = $wp_query->max_num_pages ? $wp_query->max_num_pages : 1;

		if ( 1 != $pages ) {
			$pagination = array(
				'base'         => @add_query_arg('page','%#%'),
				'format'       => '',
				'total'        => $pages,
				'current'      => $current,

				/**
				 * Filtre appliqué au text du lien vers la page précédente.
				 *
				 * @since 0.1.0
				 *
				 * @param string Le texte par défaut.
				 **/
				'prev_text'    => apply_filters( '_basique_paginate_links_prev_text', __( '<span class="meta-nav">&laquo;</span> Previous', '_basique' ) ),

				/**
				 * Filtre appliqué au text du lien vers la page suivante.
				 *
				 * @since 0.1.0
				 *
				 * @param string Le texte par défaut.
				 **/
				'next_text'    => apply_filters( '_basique_paginate_links_next_text', __( 'Next <span class="meta-nav">&raquo;</span>', '_basique' ) ),

				'end_size'     => 1,
				'mid_size'     => 2,
				'show_all'     => false,
				'type'         => 'plain',
				'prev_next'    => true,
				'add_args'     => false, // array of query args to add
				'add_fragment' => '',
			);

			if ( $wp_rewrite->using_permalinks() )
				$pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg( 's', get_pagenum_link( 1 ) ) ) . 'page/%#%/', 'paged' );

			if ( ! empty( $wp_query->query_vars['s'] ) )
				$pagination['add_args'] = array( 's' => get_query_var( 's' ) );

			/**
			 * Filtre appliqué au text du label de la pagination.
			 *
			 * @since 0.1.0
			 *
			 * @param string Le texte par défaut.
			 **/
			$label = apply_filters( '_basique_paginate_links_label', __( 'Page %s of %s', '_basique' ) );

			echo '<div class="pagination"><span class="label">' . sprintf( $label, $current, $pages ) . '</span>' . paginate_links( $pagination ) . '</div>';
		}
	}
endif;

/**
 * Custom meta box pour l'affichage conditionnel des titres dans les pages
 *
 * @since  _basique 0.1.0
 *
 * @return void
 */
add_action( 'admin_menu', '_basique_hide_page_title' );
if ( ! function_exists( '_basique_hide_page_title' ) ) :
    function _basique_hide_page_title() {
        add_meta_box( '_basique_hide_page_title', __( 'Do not display page title', '_basique' ), '_basique_hide_page_title_input', 'page', 'side', 'low' );
    }
endif;

/**
 * Contenu de la custom meta box
 *
 * @since  _basique 0.1.0
 *
 * @global object Post object
 *
 * @return  void
 */
if ( ! function_exists( '_basique_hide_page_title_input' ) ) :
    function _basique_hide_page_title_input() {
        global $post;
        $cond = intval( get_post_meta( $post->ID, '_basique_hide_page_title', true ) );
        echo '<input type="hidden" name="_basique_hide_page_title_noncename" id="_basique_hide_page_title_noncename" value="' . wp_create_nonce( '_basique_hide_page_title' ) . '" />';
        echo '<input type="checkbox" name="_basique_hide_page_title" id="_basique_hide_page_title" ' . checked( $cond, 1, false ) . ' value="1" /><label class="description" for="_basique_hide_page_title">' . __( 'Check if you don\'t want this page\'s title to be displayed on top of this website page.', '_basique' ) . '</label>';
    }
endif;

/**
 * Sauvegarde du champ de la custom meta box
 *
 * @since  _basique 0.1.0
 *
 * @param  int   $post_id  The currently saved post id
 * @return void
 */
add_action( 'save_post', '_basique_save_display_page_title' );
if ( ! function_exists( '_basique_save_display_page_title' ) ) :
    function _basique_save_display_page_title( $post_id ) {
        if ( ! is_admin() ) {
            return;
        }
        $screen = get_current_screen();
        $post_type = $screen->post_type;
        if ( ! 'page' === $post_type || ! wp_verify_nonce( $_POST['_basique_hide_page_title_noncename'], '_basique_hide_page_title' ) || defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
            return $post_id;
        $_basique_hide_page_title = ( isset( $_POST['_basique_hide_page_title'] ) && 1 === intval( $_POST['_basique_hide_page_title'] ) ) ? 1 : 0;
        update_post_meta( $post_id, '_basique_hide_page_title', $_basique_hide_page_title );
    }
endif;


/*** *** *** *** *** Fonctionnalité WordPress : En-tête personnalisée (Custom Header) *** *** *** *** ***/

/**
 * Styles associés à l'en-tête en fonction des options fixées dans le panneau d'administration Apparence > En-tête côté site (front-office).
 *
 * @since _basique 0.1.0
 **/
if ( ! function_exists( '_basique_custom_header_wp_head' ) ) :
	function _basique_custom_header_wp_head() {
		$header_image = get_header_image();
		$display_text = display_header_text();
		$text_color   = get_header_textcolor();

		if ( !empty( $header_image ) || $display_text ) :
?>
		<style type="text/css" id="custom-header-css">
<?php
			// Si une image est associée à l'en-tête (header) elle est mise en fond de bloc
			if ( !empty( $header_image ) ) :
?>
			#header {
				background: url(<?php header_image() ?>) center top no-repeat;
				background-size: 980px auto;
				background-size: 98rem auto;
			}
<?php
			endif;
			// Le texte d'en-tête est modifiable dans Réglages > Général > Titre du site (nom de la marque) et Slogan (accroche, baseline...)
			if ( $display_text ) :
?>
			#site-title,
			#site-title a,
			#site-description {
				color: #<?php echo esc_attr( $text_color ) ?>;
			}
<?php
			endif;
?>
		</style>
<?php
		endif;
	}
endif;


/**
 * Styles associés à l'en-tête en fonction des options fixées dans le panneau d'administration Apparence > En-tête.
 *
 * @since _basique 0.1.0
 **/
if ( ! function_exists( '_basique_custom_header_admin_head' ) ) :
	function _basique_custom_header_admin_head() {
		$header_image = get_header_image();
		$text_color   = get_header_textcolor();

		// If we get this far, we have custom styles.
?>
		<style type="text/css">
		#header-wrapper {
			width: 980px;
			height: 192px; /* 16*12 */
			border: none;
			}
			#header {
				padding: 0 20px;
				height: 100%;
				overflow: hidden;
<?php
			if ( ! empty( $header_image ) ) :
?>
				background: url(<?php header_image() ?>) center top no-repeat;
				background-size: 980px auto;
<?php
			endif;
?>
				}
				#site-branding a,
				#desc {
					text-decoration: none;
					color: #<?php echo esc_attr( $text_color ) ?>;
		}
		</style>
		<script type="text/javascript">
			/* <![CDATA[ */
			(function($){
				function toggle_text_visibility() {
					var checked = $('#display-header-text').prop('checked');
					if ( ! checked ) {
						// Cache le texte d'en-tête lorsque la case est cochée
						$('#site-branding').hide();
					}
					else {
						// Montre le texte d'en-tête lorsque la case est décochée
						$('#site-branding').show();
					}
				}
				$(document).ready(function() {
					$('#display-header-text').click(toggle_text_visibility);
					toggle_text_visibility();
				});
			})(jQuery);
			/* ]]> */
		</script>
		<?php
	}
endif;


/**
 * Code HTML pour la prévisualisation de l'en-tête dans le panneau d'administration Apparence > En-tête.
 *
 * @since _basique 0.1.0
 **/
if ( ! function_exists( '_basique_custom_header_admin_preview' ) ) :
	function _basique_custom_header_admin_preview() {
?>
	<div id="header-wrapper">
		<header id="header">
			<div id="site-branding">
				<h1><a href="#" title="<?php printf( __( 'link to : %s', '_basique' ), esc_url( home_url( '/' ) ) ) ?>" id="name"><?php bloginfo( 'name' ) ?></a></h1>
				<h2 id="desc"><?php bloginfo( 'description' ) ?></h2>
			</div>
		</header>
	</div>
<?php
	}
endif;


/*** *** *** *** *** Rétro-compatibilité *** *** *** *** ***/

/**
 * Titre de page.
 *
 * @since _basique 0.1.0
 **/
if ( ! function_exists( '_wp_render_title_tag' ) ) :
	add_action( 'wp_head', '_basique_render_title' );
	function _basique_render_title() {
		echo '<title>' . wp_title( '|', true, 'right' ) . '</title>' . PHP_EOL;
	}
endif;


/*** *** *** *** *** Utilitaires *** *** *** *** ***/

/**
 * Remplace les virgules par des points dans les nombres à virgule
 *
 * @since _basique 0.1.0
 **/
if ( ! function_exists( 'get_float_value' ) ) :
	function get_float_value( $strValue ) {
		// ereg_replace is deprecated
		/* $floatValue = ereg_replace( '(^[0-9]*)(\\.|,)([0-9]*)(.*)', '\\1.\\3', $strValue );
		if ( !is_numeric( $floatValue ) ) $floatValue = ereg_replace( '(^[0-9]*)(.*)', '\\1', $strValue ); */
		$floatValue = preg_replace( '/(^[0-9]*)(\\.|,)([0-9]*)(.*)/', '\\1.\\3', $strValue );
		if ( !is_numeric( $floatValue ) ) $floatValue = preg_replace( '/(^[0-9]*)(.*)/', '\\1', $strValue );
		if ( !is_numeric( $floatValue ) ) $floatValue = 0;
		return $floatValue;
	}
endif;


/**
 * Permet se savoir si une barre lattérale est ou pas enregistrée avec register_sidebar
 *
 * @since _basique 0.1.0
 **/
if ( ! function_exists( 'is_registered_sidebar' ) ) :
	function is_registered_sidebar( $id ) {
		$registered_sidebars = $GLOBALS['wp_registered_sidebars'];
		$registered = false;
		foreach ( $registered_sidebars as $registered_sidebar_id => $params ) {
			if ( $id === $registered_sidebar_id ) {
				$registered = true;
				continue;
			}
		}
		return $registered;
	}
endif;


/*** *** *** *** *** Debug *** *** *** *** ***/

/**
 * Is it debug mode ?
 *
 * @since _basique 0.1.0
 **/
if ( ! function_exists( 'is_debug_mode' ) ) :
	function is_debug_mode() {
		return current_user_can( 'administrator' ) && ( defined( 'WP_DEBUG' ) && WP_DEBUG || isset( $_GET['debug'] ) );
	}
endif;

/**
 * Notifie l'administrateur lorsque le mode debugage est actif
 *
 * @since _basique 0.1.0
 **/
if ( ! function_exists( 'is_debug_mode' ) ) :
    if ( is_debug_mode() ) {
        add_action( 'admin_notices', '_basique_debugmode_admin_notice' );
    }
    function _basique_debugmode_admin_notice() {
?>
        <div class="notice notice-error">
            <p><?php _e( 'Debug mode is active. Please considere to desactivate it in wp-config.php before the site access becomes public.', '_basique' ) ?></p>
        </div>
<?php
    }
endif;

/**
 * Send debug infos to js console
 *
 * @since _basique 0.1.0
 *
 * @param  object  $data  Any object to be send to the console.
 * @param  string  $type  Type of message. Could be 'log' (default), 'warn' or 'error'.
 * @return void
 **/
if ( ! function_exists( 'console_log' ) ) :
    function console_log ( $data, $type = 'log' ) {
        $current_theme = wp_get_theme();
        $theme = esc_js( $current_theme->get( 'Name' ) . ' ' . $current_theme->get( 'Version' ) );
        echo '<script>window.console||(console={log:function(){},warn:function(){},error:function(){}});';
        $output = explode( "\n", print_r( $data, true ) );
        foreach ( $output as $line ) {
            if ( trim( $line ) ) {
                $line = addslashes( $line );
                echo "console.{$type}(\"[{$theme}] {$line}\");";
            }
        }
        echo "</script>\r\n";
    }
endif;

/**
 * Page request informations.
 *
 * @since _basique 0.1.0
 **/
if ( ! function_exists( '_basique_debug_page_request' ) ) :
	if ( is_debug_mode() ) {
		add_action( 'admin_head', '_basique_debug_page_request', 0 );
		add_action( 'wp_head', '_basique_debug_page_request', 0 );
	}
	function _basique_debug_page_request() {
		global $wp, $template;

        /*
		$tabs = "\t\t\t";
		echo PHP_EOL . "\t\t" . '<!--' . PHP_EOL;
		echo $tabs . __( 'Debug', '_basique' ) . PHP_EOL;
		echo $tabs . __( '-----', '_basique' ) . PHP_EOL . PHP_EOL;
		echo $tabs . __( 'Requested page : ', '_basique' ) . ( empty( $wp->request ) ? __( 'None', '_basique' ) : esc_html( $wp->request ) ) . PHP_EOL;
		echo $tabs . __( 'Matched rewrite rule : ', '_basique' ) . ( empty( $wp->matched_rule ) ? __( 'None', '_basique' ) : esc_html( $wp->matched_rule ) ) . PHP_EOL;
		echo $tabs . __( 'Matched rewrite query : ', '_basique' ) . ( empty( $wp->matched_query ) ? __( 'None', '_basique' ) : esc_html( $wp->matched_query ) ) . PHP_EOL;
		echo $tabs . __( 'Loaded template : ', '_basique' ) . basename( $template ) . PHP_EOL;
		echo "\t\t" . '-->' . PHP_EOL . PHP_EOL;
        */

		console_log( __( 'Debug', '_basique' ) );
		console_log( __( '-----', '_basique' ) );
		console_log( __( 'Requested page : ', '_basique' ) . ( empty( $wp->request ) ? __( 'None', '_basique' ) : esc_html( $wp->request ) ) );
		console_log( __( 'Matched rewrite rule : ', '_basique' ) . ( empty( $wp->matched_rule ) ? __( 'None', '_basique' ) : esc_html( $wp->matched_rule ) ) );
		console_log( __( 'Matched rewrite query : ', '_basique' ) . ( empty( $wp->matched_query ) ? __( 'None', '_basique' ) : esc_html( $wp->matched_query ) ) );
		console_log( __( 'Loaded template : ', '_basique' ) . basename( $template ) );
	}
endif;


/**
 * Template part request informations.
 *
 * @since _basique 0.1.0
 **/
if ( ! function_exists( '_basique_display_included_part' ) ) :
	if ( is_debug_mode() ) {
        add_action( 'get_template_part_partials/loops/not-found', '_basique_display_included_part', 10, 2 );
        add_action( 'get_template_part_partials/loops/single', '_basique_display_included_part', 10, 2 );
        add_action( 'get_template_part_partials/loops/list', '_basique_display_included_part', 10, 2 );
        add_action( 'get_template_part_partials/sidebars/primary', '_basique_display_included_part', 10, 2 );
        add_action( 'get_template_part_partials/sidebars/secondary', '_basique_display_included_part', 10, 2 );
    }
    function _basique_display_included_part ( $slug, $name = '' ) {
            /*
            */
            $tabs = "\t\t\t";
            echo PHP_EOL . "\t\t" . '<!--' . PHP_EOL;
            echo $tabs . __( 'Debug', '_basique' ) . PHP_EOL;
            echo $tabs . __( '-----', '_basique' ) . PHP_EOL . PHP_EOL;
            echo $tabs . __( 'Included template part : ', '_basique' ) . $slug . ( $name ? '-' . $name : '' ) . '.php' . PHP_EOL;
            echo "\t\t" . '-->' . PHP_EOL . PHP_EOL;

            console_log( __( 'Included template part : ', '_basique' ) . $slug . ( $name ? '-' . $name : '' ) . '.php' );
            }
endif;


/**
 * Charge du serveur indiquée dans le footer pour l'administrateur.
 *
 * @since _basique 0.1.0
 **/
if ( ! function_exists( '_basique_charge_serveur' ) ) :
	if ( is_debug_mode() ) {
		add_action( 'wp_footer', '_basique_charge_serveur', 9999 );
	}
	function _basique_charge_serveur(){
		global $wpdb;

		// Get the total page generation time
		$totaltime = get_float_value( timer_stop() );

		// Output the stats
		/*
        $tabs = "\t\t\t";
		echo PHP_EOL . "\t\t" . '<!--' . PHP_EOL;
		echo $tabs . __( 'Debug', '_basique' ) . PHP_EOL;
		echo $tabs . __( '-----', '_basique' ) . PHP_EOL . PHP_EOL;
		echo $tabs . __( 'Page infos :', '_basique' ) . PHP_EOL . PHP_EOL;
		echo $tabs . sprintf( __( 'Page generated by WordPress %1$s in %2$s seconds.', '_basique' ), get_bloginfo( 'version' ), $totaltime ) . PHP_EOL;
		*/
		console_log( __( 'Page infos :', '_basique' ) );
		console_log( sprintf( __( 'Page generated by WordPress %1$s in %2$s seconds.', '_basique' ), get_bloginfo( 'version' ), $totaltime ) );
		
		if ( defined( 'SAVEQUERIES' ) && SAVEQUERIES ) {
			// Calculate the time spent on MySQL queries by adding up the time spent on each query
			$mysqltime = 0;
			foreach ( $wpdb->queries as $query )
				$mysqltime = $mysqltime + $query[1];

			// The time spent on PHP is the remainder
			$phptime = $totaltime - $mysqltime;

			// Create the percentages
			$mysqlper = 0;
			$phpper   = 0;
			if ( $totaltime > 0 ) {
				$mysqlper = number_format_i18n( $mysqltime / $totaltime * 100, 2 );
				$phpper   = number_format_i18n( $phptime / $totaltime * 100, 2 );
			}

            /*
			echo $tabs . sprintf( __( 'Resources : %1$s%% PHP & %2$s%% MySQL.', '_basique' ), $phpper, $mysqlper ) . PHP_EOL;
			echo $tabs . sprintf( __( 'Number of database queries : %s.', '_basique' ), get_num_queries() ) . PHP_EOL;
			echo $tabs . sprintf( __( 'MySQL stats : %s.', '_basique' ), $wpdb->dbh->stat ) . PHP_EOL;
            */

			console_log( sprintf( __( 'Resources : %1$s%% PHP & %2$s%% MySQL.', '_basique' ), $phpper, $mysqlper ) );
			console_log( sprintf( __( 'Number of database queries : %s.', '_basique' ), get_num_queries() ) );
			console_log( sprintf( __( 'MySQL stats : %s.', '_basique' ), $wpdb->dbh->stat ) );
		}

        /*
		echo PHP_EOL . $tabs . __( 'Server infos :', '_basique' ) . PHP_EOL . PHP_EOL;
		echo $tabs . sprintf( __( 'MySQL version : %s.', '_basique' ), $wpdb->dbh->server_info ) . PHP_EOL;
		echo $tabs . sprintf( __( 'PHP Version : %s', '_basique' ), phpversion() ) . PHP_EOL;
        */

		console_log( __( 'Server infos :', '_basique' ) );
		console_log( sprintf( __( 'MySQL version : %s.', '_basique' ), $wpdb->dbh->server_info ) );
		console_log( sprintf( __( 'PHP Version : %s', '_basique' ), phpversion() ) );
		// Free space on server
		set_error_handler( function (){ throw new ErrorException(); }, E_WARNING );
		try {
			$bytes = disk_free_space( '.' );
		}
		catch( ErrorException $e ) {
			// Sometimes, free space on server can not be calculated...
			$bytes = 0;
			//echo $tabs . __( 'Warning : server free space could not be calculated...', '_basique' ) . PHP_EOL;
			console_log( __( 'Warning : server free space could not be calculated...', '_basique' ), 'warn' );
		}
		restore_error_handler();
		$si_prefix = array( 'B', 'KB', 'MB', 'GB', 'TB', 'EB', 'ZB', 'YB' );
		$base = 1024;
		$class = min( ( int ) log( $bytes , $base ) , count( $si_prefix ) - 1 );
		//echo $tabs . sprintf( __( 'Server free space : %s bytes = %1.2f %s', '_basique' ), $bytes, $bytes / pow( $base, $class ), $si_prefix[$class] ) . PHP_EOL;
		console_log( sprintf( __( 'Server free space : %s bytes = %1.2f %s', '_basique' ), $bytes, $bytes / pow( $base, $class ), $si_prefix[$class] ) );

		//echo $tabs . '-->' . PHP_EOL . PHP_EOL;
	}
endif;

/**
 * WP Trac #42573: Fix for theme template file caching.
 *
 * Flush the theme file cache on every load.
 *
 * @see https://core.trac.wordpress.org/ticket/42573
 * @see https://gist.github.com/westonruter/6c2ca0e5a4da233bf4bd88a1871dd950
 * @author Weston Ruter, XWP.
 *
 * @since  _basique 0.1.0
 *
 * @return void
 */
if ( ! function_exists( '_basique_charge_serveur' ) ) :
	if ( is_debug_mode() ) {
        add_action( 'init', 'fix_template_caching' );
    }
    function fix_template_caching() {
        $theme = wp_get_theme();
        if ( ! $theme ) {
            return;
        }
        $cache_hash = md5( $theme->get_theme_root() . '/' . $theme->get_stylesheet() );
        $label = sanitize_key( 'files_' . $cache_hash . '-' . $theme->get( 'Version' ) );
        $transient_key = substr( $label, 0, 29 ) . md5( $label );
        delete_transient( $transient_key );
    }
endif;

?>
