<?php
/**
 * Loop Rating
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;
global $yolo_bestruct_options;
if ( get_option( 'woocommerce_enable_review_rating' ) === 'no' )
	return;

$product_show_rating = $yolo_bestruct_options['product_show_rating'];
if ($product_show_rating == 0) {
    return;
}
?>

<?php if ( $rating_html = wc_get_rating_html( $product->get_average_rating() )) : ?>
	<?php echo ($rating_html); ?>
<?php endif; ?>
