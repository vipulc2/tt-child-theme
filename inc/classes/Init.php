<?php

namespace TwentyChild;

include_once( 'User.php' );
include_once( 'Products.php' );
include_once( 'Assets.php' );
include_once( 'Shortcode.php' );
include_once( 'JSONAPI.php' );

/**
 * Used to initialize 
 */

 class Init {

    public static function start() {

        $user = new User;
        $products = new Products;
        $assets = new Assets;
        $shortcode = new Shortcode;
        $json = new JSONAPI;

    }


 }