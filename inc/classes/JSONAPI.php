<?php

namespace TwentyChild;

/**
 * JSON API
 */

 class JSONAPI {

    public function __construct() {
        add_action( 'rest_api_init', [ $this, 'register_product_api' ] );

    }

    public function register_product_api() {
        register_rest_route( 'ttc/v2', '/products/product-category/(?P<category>[a-zA-Z0-9-]+)', array(
            'methods' => 'GET',
            'callback' => [ $this, 'get_products_by_category' ],
        ) );
    }
     
    public function get_products_by_category( $request ) {
    
            $category = $request->get_param( 'category' );
        
            // Check if the category is a slug or ID
            if ( is_numeric( $category ) ) {
                $args = array(
                    'post_type' => 'products',
                    'posts_per_page' => -1,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'product_category',
                            'field' => 'term_id',
                            'terms' => $category,
                        ),
                    ),
                );
            } else {
                $args = array(
                    'post_type' => 'products',
                    'posts_per_page' => -1,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'product_category',
                            'field' => 'slug',
                            'terms' => $category,
                        ),
                    ),
                );
            }
        
            $products = get_posts( $args );
        
            $output = array();
            foreach ( $products as $product ) {
                $product_data = array(
                    'title' => $product->post_title,
                    'description' => $product->post_content,
                    'featured_image' => wp_get_attachment_url( get_post_thumbnail_id( $product->ID ) ),
                    'price' => get_post_meta( $product->ID, 'ttc-price-regular', true ),
                    'onsale' => get_post_meta( $product->ID, 'ttc-onsale', true ),
                    'sale' => get_post_meta( $product->ID, 'ttc-price-sale', true ),
                );
                $output[] = $product_data;
            }
        
            return rest_ensure_response( $output );

    }
}

