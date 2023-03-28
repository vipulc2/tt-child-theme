<?php
namespace TwentyChild;
/**
 * 
 * Shortcode Class
 */

class Shortcode {

    public function __construct() {
        add_shortcode( 'product', [ $this, 'product_shortcode' ] );
    }

    public function product_shortcode( $atts ) {
        ob_start();
     
        extract( shortcode_atts( array(
           'id' => '',
           'bgcolor' => ''
        ), $atts ) );

        $product = get_post( $id );
        $bgcolor = sanitize_hex_color( $bgcolor );
        $bgcolor = ( ! empty ( $bgcolor ) ) ? $bgcolor : '#ccc' ;
        $post_meta   = get_post_meta( $product->ID );

        if ( empty ( $post_meta ) && ! is_numeric( $id ) ) {
            return;
        }

        ?>

        <div style="background-color:<?php echo $bgcolor; ?>; padding: 20px;">
            <img src="<?php echo get_the_post_thumbnail_url( $product->ID ); ?>">
           <h2><?php echo $product->post_title; ?></h2>
           <div>
                <?php echo esc_attr( $post_meta['ttc-onsale'][0] == 'true' ) ? 'Price $' . $post_meta['ttc-price-sale'][0] : 'Price $' . $post_meta['ttc-price-regular'][0]; ?>
            </div>
        </div>
        <?php
     
        return ob_get_clean();
     }
}