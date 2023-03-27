<?php
/**
 * Front Page file
 */

get_header();
?>

<main id="site-content">

<?php

$args = array(
    'post_type'      => 'products',
    'posts_per_page' => -1,
);

$products_query = new WP_Query( $args );

if ( $products_query->have_posts() ) {

	echo '<div class="ttc-product-grid-container">';

	while ( $products_query->have_posts() ) {
		
		$products_query->the_post(); ?>

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
		<?php
	}
	echo '</div>';
}
?>
</main>

<?php
get_footer();
