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

        $image_url = get_the_post_thumbnail_url( $product->ID );
        $title = $product->post_title;
        $price = esc_attr( $post_meta['ttc-onsale'][0] == 'true' ) ? $post_meta['ttc-price-sale'][0] : $post_meta['ttc-price-regular'][0];

        $values = apply_filters( 'ttc_product_shortcode_values', array(
            'image_url' => $image_url,
            'title' => $title,
            'price' => $price,
            'bgcolor' => $bgcolor
        ) );        ?>

        <div style="background-color:<?php echo $values['bgcolor']; ?>; padding: 20px;">
            <img src="<?php echo $values['image_url']; ?>">
           <h2><?php echo $values['title']; ?></h2>
           <div>
                <?php echo "Price $ " . $values['price']; ?>
            </div>
        </div>
        <?php
     
        return ob_get_clean();
     }
}