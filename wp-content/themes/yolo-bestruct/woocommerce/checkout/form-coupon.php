<?php
/**
 * Checkout coupon form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! wc_coupons_enabled() ) {
	return;
}

$info_message = apply_filters( 'woocommerce_checkout_coupon_message', esc_html__( 'Have a coupon?', 'yolo-bestruct' ) . ' <a href="#" class="showcoupon">' . esc_html__( 'Click here to enter your code', 'yolo-bestruct' ) . '</a>' );
//wc_print_notice( $info_message, 'notice' );
if ( empty( WC()->cart->applied_coupons ) ) {
?>
<div class="woocommerce-checkout-info">
	<?php echo wp_kses_post($info_message); ?>
</div>
<?php }?>
<form class="checkout_coupon" method="post" style="display:none">

	<p class="form-row form-row-first">
		<input type="text" name="coupon_code" class="input-text" placeholder="<?php esc_attr_e( 'Coupon code', 'yolo-bestruct' ); ?>" id="coupon_code" value="" />
	</p>

	<p class="form-row form-row-last">
		<input type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e( 'Apply Coupon', 'yolo-bestruct' ); ?>" />
	</p>

	<div class="clear"></div>
</form>
