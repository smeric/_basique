<?php /* force UTF-8 : éàè */
/**
 * @package WordPress
 * @subpackage _basique
 */

/**
 * Ce fichier de pagination est destiné à être inclus dans l'un des partiels suivants :
 *  _basique/partials/loop-list.php
 *  _basique/partials/loops/list.php
 *  _basique/partials/loops/list-news.php
 *  _basique/partials/loops/list-search-results.php
 *
 * Pour l'inclure, utiliser le filtre correspondant présent dans chacun de ces fichiers depuis le fichier functions.php
 * du thème enfant : _basique-enfant/functions.php
 *
 * Par exemple, pour inclure la présente pagination dans le partiel _basique/partials/loops/list.php, il faudra ajouter
 * au fichier _basique-enfant/functions.php le filtre suivant :
 *
 * add_filter( '_basique_list_navigation', '_basique_list_navigation' );
 * function _basique_list_navigation() {
 *     return 'pagination';
 * }
 */

_basique_paginate_links();
