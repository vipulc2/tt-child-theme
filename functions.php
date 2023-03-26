<?php

include_once( 'inc/classes/Init.php' );
/**
 * Functions.
 *
 * @package Twenty Twenty Child
 */

 defined( 'ABSPATH' ) || die( "Can't access directly" );

/**
 * Enqueue scripts & styles.
 */
function enqueue_parent_styles() {
   wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
}
add_action( 'wp_enqueue_scripts', 'enqueue_parent_styles' );

function initialize_theme() {
   TwentyChild\Init::start();
}
initialize_theme();