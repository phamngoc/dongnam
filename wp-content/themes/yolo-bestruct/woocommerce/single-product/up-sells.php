<?php
/**
 * Single Product Up-Sells
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $woocommerce_loop;

$upsells = $product->get_upsell_ids();

if ( sizeof( $upsells ) == 0 ) {
	return;
}

$meta_query = WC()->query->get_meta_query();

$args = array(
	'post_type'           => 'product',
	'ignore_sticky_posts' => 1,
	'no_found_rows'       => 1,
	'posts_per_page'      => $posts_per_page,
	'orderby'             => $orderby,
	'post__in'            => $upsells,
	'post__not_in'        => array( $product->get_id() ),
	'meta_query'          => $meta_query
);

$products = new WP_Query( $args );


global $yolo_woocommerce_loop;
global $yolo_bestruct_options;
$related_product_display_columns = isset($yolo_bestruct_options['related_product_display_columns'])?$yolo_bestruct_options['related_product_display_columns']:4;
$yolo_woocommerce_loop['rating'] = 0;
$yolo_woocommerce_loop['columns'] = $related_product_display_columns;
$yolo_woocommerce_loop['layout'] = 'slider';


if ( $products->have_posts() ) : ?>

	<div class="upsells products">

        <h4 class="widget-title"><span><?php esc_html_e( 'You may also like&hellip;', 'yolo-bestruct' ) ?></span></h4>

		<?php woocommerce_product_loop_start(); ?>

			<?php while ( $products->have_posts() ) : $products->the_post(); ?>

				<?php wc_get_template_part( 'content', 'product' ); ?>

			<?php endwhile; // end of the loop. ?>

		<?php woocommerce_product_loop_end(); ?>

	</div>

<?php endif;

wp_reset_postdata();
