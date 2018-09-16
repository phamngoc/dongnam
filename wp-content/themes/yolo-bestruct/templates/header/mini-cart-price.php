<?php
/**
 *  
 * @package    YoloTheme
 * @version    1.0.0
 * @author     Administrator <admin@yolotheme.com>
 * @copyright  Copyright (c) 2015, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
*/

global $yolo_bestruct_options;
$icon_shopping_cart_class = array('shopping-cart-wrapper', 'header-customize-item', 'with-price');
if ($yolo_bestruct_options['mobile_header_shopping_cart'] == '0') {
	$icon_shopping_cart_class[] = 'mobile-hide-shopping-cart';
}
?>
<div class="<?php echo join(' ', $icon_shopping_cart_class); ?>">
	<div class="widget_shopping_cart_content">
		<?php get_template_part('woocommerce/cart/mini-cart'); ?>
	</div>
</div>