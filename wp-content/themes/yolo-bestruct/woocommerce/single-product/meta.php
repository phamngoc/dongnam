<?php
/**
 * Single Product Meta
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product;

$cat_count = sizeof( get_the_terms( $post->ID, 'product_cat' ) );
$tag_count = sizeof( get_the_terms( $post->ID, 'product_tag' ) );

$weight = $product->get_weight();

$availability      = $product->get_availability();
if (empty($availability['availability'])) {
    $availability['availability'] = esc_html__( 'In stock', 'yolo-bestruct' );
    $availability['class'] = 'in-stock';
}
$availability_html = '<span class="product-stock-status ' . esc_attr( $availability['class'] ) . '">' . esc_html( $availability['availability'] ) . '</span>';

?>
<div class="product_meta">


    <?php do_action( 'woocommerce_product_meta_start' ); ?>
    <?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>

        <span class="sku_wrapper"><label><?php esc_html_e( 'SKU:', 'yolo-bestruct' ); ?></label> <span class="sku" itemprop="sku"><?php echo ( $sku = $product->get_sku() ) ? $sku : esc_html__( 'N/A', 'yolo-bestruct' ); ?></span>.</span>

    <?php endif; ?>

    <span class="product-stock-status-wrapper"><label><?php esc_html_e('Availability:','yolo-bestruct') ?></label> <?php echo apply_filters( 'woocommerce_stock_html', $availability_html, $availability['availability'], $product ); ?></span>

    <?php if (!empty($weight)) : ?>
        <span><label><?php esc_html_e("Shipping Weight:",'yolo-bestruct'); ?></label><span> <?php echo esc_html($weight) . ' ' .get_option( 'woocommerce_weight_unit' ) ?></span></span>
    <?php endif; ?>

    <?php echo  wc_get_product_category_list( $product->get_id(), '/ ', '<span class="posted_in">' . _n( '<label>Category:</label>', '<label>Categories:</label>', $cat_count, 'yolo-bestruct' ) . ' ', '.</span>' ); ?>

    <?php echo  wc_get_product_tag_list( $product->get_id(), ' / ', '<span class="tagged_as">' . _n( '<label>Tag:</label>', '<label>Tags:</label>', $tag_count, 'yolo-bestruct' ) . ' ', '.</span>' ); ?>

    <?php do_action( 'woocommerce_product_meta_end' ); ?>


</div>
