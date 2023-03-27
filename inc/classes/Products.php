<?php
namespace TwentyChild;
/**
 * Products Class
 */

class Products {

    public $post_meta;


    public function __construct() {

        add_action( 'init', [ $this, 'register_products' ] );
        add_action( 'init', [$this, 'register_product_category'] );
        add_action( 'add_meta_boxes', [ $this, 'register_metaboxes' ] );
        add_action( 'save_post', [$this, 'save_post_data'] );
    }

    /**
     * Registers Products CPT
     */
    public function register_products() {

        $labels = array(
            'name'                  => _x( 'Products', 'Post type general name', 'twenty-twenty-child' ),
            'singular_name'         => _x( 'Product', 'Post type singular name', 'twenty-twenty-child' ),
            'menu_name'             => _x( 'Products', 'Admin Menu text', 'twenty-twenty-child' ),
            'name_admin_bar'        => _x( 'Product', 'Add New on Toolbar', 'twenty-twenty-child' ),
            'add_new'               => __( 'Add New', 'twenty-twenty-child' ),
            'add_new_item'          => __( 'Add New Product', 'twenty-twenty-child' ),
            'new_item'              => __( 'New Product', 'twenty-twenty-child' ),
            'edit_item'             => __( 'Edit Product', 'twenty-twenty-child' ),
            'view_item'             => __( 'View Product', 'twenty-twenty-child' ),
            'all_items'             => __( 'All Products', 'twenty-twenty-child' ),
            'search_items'          => __( 'Search Products', 'twenty-twenty-child' ),
            'parent_item_colon'     => __( 'Parent Products:', 'twenty-twenty-child' ),
            'not_found'             => __( 'No Products found.', 'twenty-twenty-child' ),
            'not_found_in_trash'    => __( 'No Products found in Trash.', 'twenty-twenty-child' ),
            'featured_image'        => _x( 'Product Main Image', 'Overrides the “Featured Image” phrase for this post type.', 'twenty-twenty-child' ),
            'set_featured_image'    => _x( 'Set product image', null, 'twenty-twenty-child' ),
            'remove_featured_image' => _x( 'Remove product image', null, 'twenty-twenty-child' ),
            'use_featured_image'    => _x( 'Use as product image', null, 'twenty-twenty-child' ),
            'archives'              => _x( 'Product archives', null, 'twenty-twenty-child' ),
        );
    
        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array( 'slug' => 'product' ),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            'show_in_rest'       => true,   
            'supports'           => array( 'title', 'editor', 'thumbnail', ),
        );

        register_post_type( 'products', $args );

    }

    /**
     * Register All Metaboxes
     */
    public function register_metaboxes() {

        $metaboxes = array(
            'product_gallery'   => __( 'Product Gallery', 'twenty-twenty-child' ),
            'product_price'     => __( 'Product Price', 'twenty-twenty-child' ),
            'yt_video'          => __( 'YouTube Video URL', 'twenty-twenty-child' ),
        );

        foreach ( $metaboxes as $key => $metabox ) {

            add_meta_box( $key, $metabox, [ $this, 'metabox_' . $key ], 'products' );
        } 
    }

    /**
     * Register Product Category
     */
    public function register_product_category() {
        $labels = array(
            'name'              => __( 'Product Categories', 'twenty-twenty-child' ),
            'singular_name'     => __( 'Product Category', 'twenty-twenty-child' ),
            'search_items'      => __( 'Search Product Categories', 'twenty-twenty-child' ),
            'all_items'         => __( 'All Product Categories', 'twenty-twenty-child' ),
            'parent_item'       => __( 'Parent Product Category', 'twenty-twenty-child' ),
            'parent_item_colon' => __( 'Parent Product Category:', 'twenty-twenty-child' ),
            'edit_item'         => __( 'Edit Product Category', 'twenty-twenty-child' ), 
            'update_item'       => __( 'Update Product Category', 'twenty-twenty-child' ),
            'add_new_item'      => __( 'Add New Product Category', 'twenty-twenty-child' ),
            'new_item_name'     => __( 'New Product Category Name', 'twenty-twenty-child' ),
            'menu_name'         => __( 'Product Categories', 'twenty-twenty-child' ),
            'not_found'         => __( 'No categories found.', 'twenty-twenty-child' ),
          ); 	
        
          register_taxonomy('product_category',array('products'), array(
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'show_in_rest'      => true,
            'rewrite'           => array( 'slug' => 'product_category' ),
          ));
    }
    
    /**
     *  Saved post data
     */
    public function save_post_data( $post_id ) {

        $post_value_fields = array(
            'ttc-image-url',
            'ttc-price-regular',
            'ttc-price-sale',
            'ttc-onsale',
            'ttc-yt-url',
        );

        foreach ( $post_value_fields as $post_value ) {

            if ( isset( $_POST[$post_value] ) ) {
                
                update_post_meta( $post_id, $post_value, $_POST[$post_value] );
            }
        }
    }

    /**
     * Metabox: Product Gallery
     */
    public function metabox_product_gallery( $post ) {

        ?>
        <div class="ttc-metabox">

        <div class="ttc-metabox__field">
            <input type="button" value="<?php echo __( 'Product Gallery', 'twenty-twenty-child' ); ?>" class="ttc-upload-image-gallery">
            <input type="hidden" class="ttc-hidden-image-url" name="ttc-image-url">
        </div>
            <div class="ttc-image-boxes">

            <?php

          //  if ( isset( $_POST['ttc-image-url'] ) && ! empty( $_POST['ttc-image-url'] ) ) {

            //} else {//

                $image_urls = get_post_meta( $post->ID, 'ttc-image-url', true );
                $image_urls = explode( ',', $image_urls );
                foreach( $image_urls as $image_url ) {
                ?>

                    <div class="ttc-image-box">
                        <img src="<?php echo esc_url( $image_url ); ?>">
                    </div>

            <?php
                }
           // }
            ?>
            </div>
        </div>
        <?php
    }
    /**
     * Metabox: Product Price
     */
    public function metabox_product_price( $post ) {

        $post_meta = get_post_meta( $post->ID );

        ?>

            <div class="ttc-metabox">
                <div class="ttc-metabox__field">
                    <label for="ttc-price-regular"><?php _e( 'Regular Price' , 'twenty-twenty-child' ) ?></label>
                    <input type="number" name="ttc-price-regular" value="<?php echo esc_attr( $post_meta['ttc-price-regular'][0] ); ?>">

                </div>

                <?php
                $on_sale = $post_meta['ttc-onsale'][0] == 'true' ? true : false;
                
                ?>

                <div class="ttc-metabox__field">
                    <label for="ttc-onsale"><?php _e( 'Is on Sale?' , 'twenty-twenty-child' ) ?></label>
                    <select name="ttc-onsale">
                        
                        <option value="true" <?php echo ($on_sale) ? 'selected' : ''; ?> > <?php _e( 'On Sale' , 'twenty-twenty-child' ) ?>
                        </option>

                        <option value="false" <?php echo ($on_sale) ? '' : 'selected'; ?> ><?php _e( 'Not on Sale' , 'twenty-twenty-child' ) ?>
                        </option>
                    </select>
                </div>

                <div class="ttc-metabox__field">
                    <label for="ttc-price-sale"><?php _e( 'Sale Price' , 'twenty-twenty-child' ) ?></label>
                    <input type="number" name="ttc-price-sale" value="<?php echo esc_attr( $post_meta['ttc-price-sale'][0] ); ?>">
                </div>
            </div>

        <?php

    }

    /**
     * Metabox: YoutTube Video URL
     */
    public function metabox_yt_video( $post ) {

        $post_meta = get_post_meta( $post->ID );

        $yt_url = isset( $post_meta['ttc-yt-url'][0] ) ? $post_meta['ttc-yt-url'][0] : '';

        ?>
        <div class="ttc-metabox">
            <div class="ttc-metabox__field"> 
                <label for="ttc-yt-url"><?php _e( 'YouTube URL' , 'twenty-twenty-child' ) ?></label>
                <input type="url" name="ttc-yt-url" value="<?php echo esc_url( $yt_url ); ?>">
            </div>
        </div>

    <?php
    }



}