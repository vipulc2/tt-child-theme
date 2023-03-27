<?php
namespace TwentyChild;
/**
 * Assets Class
 */

class Assets {

    public function __construct() {

        add_action( 'admin_enqueue_scripts', [ $this, 'register_admin_scripts' ] );
        add_action( 'wp_enqueue_scripts', [ $this, 'register_frontend_scripts' ] );

    }

    /**
     * Register Admin Scripts CSS & JS
     */
    public function register_admin_scripts( $hook ) {

        $screen = get_current_screen();

        if ( 'products' != $screen->post_type ) {
            return;
        }

        wp_enqueue_script( 'ttc-admin-script', get_stylesheet_directory_uri() . '/assets/js/admin.js', array('jquery'), '1.0', true );
        wp_enqueue_style( 'ttc-admin-style', get_stylesheet_directory_uri() . '/assets/css/admin.css', array(), '1.0' );

    }

    /**
     * Register Scripts for the front
     */
    public function register_frontend_scripts() {

        wp_enqueue_style( 'front-style', get_stylesheet_directory_uri() . '/assets/css/front.css' );
    }


 }