<?php
namespace TwentyChild;

/**
 * User Class File
 */

class User {


    public function __construct() {

        add_action( 'after_setup_theme', [ $this, 'create_editor_user' ] );
        add_action( 'after_setup_theme', [ $this, 'disable_adminbar' ] );

    }

    /**
     * Create Editor User
     */
    public function create_editor_user() {

        $user_data = array(
        'user_login' => 'wp-test',
        'user_email' => 'wptest@elementor.com',
        'user_pass' => '123456789',
        'role' => 'editor',
        );
    
        if ( ! username_exists( 'wp-test' ) && ! email_exists( 'wptest@elementor.com' ) ) {
            wp_insert_user($user_data);
        }
    }
    /**
     * Disale Admin Bar for the wp-test user
     */
    public function disable_adminbar() {

        add_filter( 'show_admin_bar', function( $show ) {
        $current_user = wp_get_current_user();
        if ( $current_user->user_email == 'wptest@elementor.com' ) {
            return false;
        }
        return $show;
        } );
    
    }
}



