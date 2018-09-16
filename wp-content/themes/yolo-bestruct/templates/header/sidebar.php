<?php
/**
 *  
 * @package    YoloTheme
 * @version    1.0.0
 * @author     Administrator <admin@yolotheme.com>
 * @copyright  Copyright (c) 2016, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
*/

global $yolo_header_customize_current;
global $yolo_bestruct_options;
$prefix = 'yolo_';

// $icon_shopping_wishlist_class[] = ''; process more options
?>
<div class="header-widget header-customize-item <?php //echo join(' ', $icon_shopping_wishlist_class); ?>">
	<div class="widget_header_content">
		<?php
		if( $yolo_header_customize_current == 'left' ) {
			// @TODO: later
		}
		dynamic_sidebar( $item->megamenu_widgetarea ); 
		?>
	</div>
</div>