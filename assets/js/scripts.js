/**
 * Ensemble des scripts Javascript utilisés par le site
 * 
 * @package WordPress
 * @subpackage _basique
 **/

/** Definition d'une console minimum pour éviter des erreurs Javascript **/
window.console||(console={log:function(){},warn:function(){},error:function(){}});

/** *************************************************************************************** **/


// Incorporez ici les plugins jQuery dont vous avez besoin


/** *************************************************************************************** **/

(function($){
	'use strict';

	/** C'est parti ! **/
	$(function(){
		// Localisation des scripts : mise à jour de l'objet GLOBALS
		var GLOBALS_defaults = {
            "theme"            : "Theme",
            "site_url"         : "",
            "parent_theme_url" : "",
            "theme_url"        : "",
            "ajaxurl"          : "",
            'page_shortlink'   : "",
            /* Debug */
            "is_debug"         : false,
            "log"              : function(msg){
                                    if(!msg||!this.is_debug){return;}
                                    var prefix='['+this.theme+'] ';
                                    if(msg===null){console.log(prefix+'null');}
                                    else if('function'===typeof msg||'object'===typeof msg){console.log(msg);}
                                    else{console.log(prefix+msg);}
            },
            /* Viewport size */
            "viewport"         : {
                "width"  : Math.max(document.documentElement.clientWidth,window.innerWidth||0),
                "height" : Math.max(document.documentElement.clientHeight,window.innerHeight||0),
            },
			/* Traduction de chaines de caractères */
            "entering_debug"   : "",
            "viewport_size"    : "",
            "self_xss_title"   : "",
            "self_xss_text"    : "",
            "self_xss_link"    : "",
		};
		GLOBALS=$.extend({},GLOBALS_defaults,window.GLOBALS||{});
		GLOBALS.is_debug='1'===GLOBALS.is_debug?true:false;

        /* Avertissement self XSS */
		console.log("%c \r\n%s","color: red; font-size: xx-large;",GLOBALS.self_xss_title);
		console.log("%c%s","font-size: large;",GLOBALS.self_xss_text);
		console.log("%c%s\r\n ","font-style: italic;",GLOBALS.self_xss_link);

		GLOBALS.log(GLOBALS.entering_debug);
		GLOBALS.log('GLOBALS : ');
		GLOBALS.log(GLOBALS);

		// Mise en cache de variables utiles :
		var $w=$(window),$d=$(document),$html=$('html'),$body=$('body');

		// Récupère la taille du viewport
		$w.on('resize',function(){
			GLOBALS.viewport={
				"width"  : Math.max(document.documentElement.clientWidth,window.innerWidth||0),
				"height" : Math.max(document.documentElement.clientHeight,window.innerHeight||0)
			};
			GLOBALS.log(GLOBALS.viewport_size+GLOBALS.viewport.width+' x '+GLOBALS.viewport.height);
		});

		// Executez vos scripts Javascript ici...

	});
}(jQuery));
