<?php
/**
 * The template for displaying Single Product pages
 */

get_header();
?>

<main id="site-content">

	<?php

	if ( have_posts() ) {

		while ( have_posts() ) {
			the_post();
            $post_meta = get_post_meta( get_the_ID() );
            $post_category = get_the_terms( get_the_ID(), 'product_category' );
			?>

            <div class="ttc-product-container">

                <div class="ttc-column-image">
                    <div class="ttc-featured-image">
                        <img src="<?php echo get_the_post_thumbnail_url( get_the_ID(), 'full' ); ?>" alt="">
                    </div>

                    <?php if( isset( $post_meta['ttc-image-url'][0] ) && ! empty( $post_meta['ttc-image-url'][0] ) ) { ?>
                    <div class="ttc-gallery-image">
                        <?php
                        $image_urls = $post_meta['ttc-image-url'][0];
                        $image_urls = explode( ',', $image_urls );
                        foreach ( $image_urls as $image_url ) { ?>
                            <img src="<?php echo esc_url( $image_url ); ?>">
                            <?php
                        }

                        ?>
                    </div>
                    <?php } ?>
                </div>
                <div class="ttc-column-content">
                    <div class="ttc-product-title">
                        <?php echo esc_html( get_the_title() ); ?>
                    </div>
                    <div class="ttc-product-price">
                        <?php echo esc_attr( $post_meta['ttc-onsale'][0] == 'true' ) ? 'Price $' . $post_meta['ttc-price-sale'][0] : 'Price $' . $post_meta['ttc-price-regular'][0]; ?>
                    </div>
                
                </div>

                <div class="ttc-product-description">
                    <h2><?php echo __( 'Description', 'twenty-twenty-child' ) ?></h2>
                    <?php echo get_the_content(); ?>

                    <?php if( isset( $post_meta['ttc-yt-url'][0] ) && ! empty( $post_meta['ttc-yt-url'][0] ) ) { ?>
                <p class="ttc-product-video">

                <?php
                
                $url_parts = parse_url( $post_meta['ttc-yt-url'][0] );
  
                if (isset($url_parts['query'])) {
                  parse_str($url_parts['query'], $query_params);
                  if (isset($query_params['v'])) {
                    $youtube_id = $query_params['v'];
                  }
                } else if (isset($url_parts['path'])) {
                  $path_parts = explode('/', trim($url_parts['path'], '/'));
                  if (count($path_parts) > 0) {
                    $youtube_id = $path_parts[count($path_parts) - 1];
                  }
                }
              
                if ($youtube_id !== '') {
                  $yt_url_embed =  "https://www.youtube.com/embed/$youtube_id";
                }
                
                ?>

                <iframe width="420" height="315" src="<?php echo esc_url( $yt_url_embed ); ?>">

                </iframe>
                </p>
                <?php } ?>
                </div>

            </div>
            <?php
		}
	}

    $terms = get_the_terms( $post->ID, 'product_category' );
 
    if ( $terms && ! is_wp_error( $terms ) ) {
        $term_ids = array();
        foreach ( $terms as $term ) {
            $term_ids[] = $term->term_id;
        }
     
        // Query related posts
        $related_args = array(
            'post_type' => 'products',
            'posts_per_page' => 3, // You can change the number of posts to display here
            'post_status' => 'publish',
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_category',
                    'field' => 'id',
                    'terms' => $term_ids,
                    'operator' => 'IN',
                )
            ),
            'post__not_in' => array( $post->ID ),
            'orderby' => 'rand',
        );
     
        $related_posts = new WP_Query( $related_args );
     
        // Display related posts
        if ( $related_posts->have_posts() ) {
            echo '<h3>Related Posts</h3><div class="ttc-product-grid-container">';
     
            while ( $related_posts->have_posts() ) {
                $related_posts->the_post(); ?>

            <div class="ttc-product-box">
				<a href="<?php echo esc_url( get_the_permalink() ); ?>">
					<div class="ttc-product-thumbnail">

						<?php if( get_post_meta( get_the_ID(), 'ttc-onsale', true ) === 'true' ) {
						
						?>
						<span class="ttc-product-onsale"><?php echo __( 'SALE!!!', 'twenty-twenty-child' ); ?></span>

						<?php } ?>

						<img src="<?php echo esc_url( get_the_post_thumbnail_url() ); ?>" alt="">
					</div>

				<div class="ttc-product-title">
					<?php echo esc_html( get_the_title() ); ?>
				</div>
				</a>
		</div>
     
     
            <?php }
            echo '</div>';
        }
     
        wp_reset_postdata();
    }

	?>

</main>
<?php 
add_filter( 'ttc_product_shortcode_values', 'callback_function' );
function callback_function( $values ) {
    $values['image_url'] = 'asdasd';
    $values['bgcolor'] = '#333';
    $values['title'] = 'kokokokok';
    $values['price'] = '12121';

}
?>
<?php
get_footer();