<?php

namespace TwentyChild;

include_once( 'User.php' );
include_once( 'Products.php' );
include_once( 'Assets.php' );

/**
 * Used to initialize 
 */

 class Init {

    public static function start() {

        $user = new User;
        $products = new Products;
        $assets = new Assets;

    }


 }