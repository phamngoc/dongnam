<?php
/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/mini-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see     http://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.3.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $yolo_bestruct_options;
$both_button = '';
if (isset($yolo_bestruct_options['header_shopping_cart_button'])
	&& ($yolo_bestruct_options['header_shopping_cart_button']['view-cart'] == '1')
	&& ($yolo_bestruct_options['header_shopping_cart_button']['checkout'] == '1')) {
	$both_button = 'both-buttons';
}

if (!isset($args) || !isset($args['list_class'])) {
	$args['list_class'] = '';
}
$cart_list_sub_class = array();
$cart_list_sub_class[] = 'cart_list_wrapper';
if ( sizeof( WC()->cart->get_cart() ) > 0 ) {
	$cart_list_sub_class[] = 'has-cart';
}
wp_enqueue_script('custom-scrollbar');
wp_enqueue_style('custom-scrollbar');
?>
<?php do_action( 'woocommerce_before_mini_cart' ); ?>
<div class="widget_shopping_cart_icon">
	<i class="wicon fa fa-shopping-bag"></i>
	<span class="total"><?php echo sizeof( WC()->cart->get_cart()); ?></span>
</div>
<div class="sub-total-text"><?php echo WC()->cart->get_cart_subtotal(); ?></div>
<div class="<?php yolo_the_attr_value($cart_list_sub_class) ?>">
	<ul class="woocommerce-mini-cart cart_list product_list_widget scrollbar-inner <?php echo esc_attr($args['list_class']); ?>">
		<?php if ( ! WC()->cart->is_empty() ) : ?>

			<?php
			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {

					$product_name  = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
					$thumbnail     = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
					$product_price = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
					$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );

					?>
					<li class="woocommerce-mini-cart-item">
						<div class="cart-left">
							<?php if ( ! $_product->is_visible() ) { ?>
								<?php echo str_replace( array( 'http:', 'https:' ), '', $thumbnail ); ?>
							<?php } else { ?>
								<a href="<?php echo esc_url($product_permalink); ?>">
									<?php echo str_replace( array( 'http:', 'https:' ), '', $thumbnail ) ?>
								</a>
							<?php } ?>
						</div>
						<div class="cart-right">
							<?php if ( ! $_product->is_visible() ) { ?>
								<?php echo esc_html($product_name); ?>
							<?php } else { ?>
								<a href="<?php echo esc_url($product_permalink); ?>">
									<?php echo esc_html($product_name); ?>
								</a>
							<?php } ?>
							<?php echo wc_get_formatted_cart_item_data( $cart_item ); ?>

							<?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="quantity">' . sprintf( '%s &times; %s', $cart_item['quantity'], $product_price ) . '</span>', $cart_item, $cart_item_key ); ?>

							<?php echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf('<a href="%s" class="mini-cart-remove remove remove_from_cart_button" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s">&times;</a>',
								esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
								esc_attr( $product_id ),
								esc_attr( $cart_item_key ),
								esc_attr( $_product->get_sku() )
								), $cart_item_key );?>
						</div>
					</li>
				<?php
				}
			}
			?>

		<?php else : ?>
			<li class="empty">
				<h4><?php esc_html_e( 'An empty cart', 'yolo-bestruct' ); ?></h4>
				<p><?php esc_html_e( 'You have no item in your shopping cart', 'yolo-bestruct' ); ?></p>
			</li>
		<?php endif; ?>

	</ul><!-- end product list -->

	<?php if ( sizeof( WC()->cart->get_cart() ) > 0 ) : ?>
		<div class="cart-total">
			<p class="total"><strong><?php esc_html_e( 'Total', 'yolo-bestruct' ); ?>:</strong> <?php echo WC()->cart->get_cart_subtotal(); ?></p>

			<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>

			<p class="buttons <?php echo esc_attr($both_button) ?>">
				<?php if (isset($yolo_bestruct_options['header_shopping_cart_button']) && ($yolo_bestruct_options['header_shopping_cart_button']['view-cart'] == '1')):?>
					<a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="button wc-forward"><?php esc_html_e( 'View Cart', 'yolo-bestruct' ); ?></a>
				<?php endif; ?>
				<?php if (isset($yolo_bestruct_options['header_shopping_cart_button']) && ($yolo_bestruct_options['header_shopping_cart_button']['checkout'] == '1')):?>
					<a href="<?php echo esc_url(wc_get_checkout_url()); ?>" class="button checkout wc-forward"><?php esc_html_e( 'Checkout', 'yolo-bestruct' ); ?></a>
				<?php endif; ?>
			</p>
		</div>
	<?php endif; ?>

	<?php do_action( 'woocommerce_after_mini_cart' ); ?>
</div>