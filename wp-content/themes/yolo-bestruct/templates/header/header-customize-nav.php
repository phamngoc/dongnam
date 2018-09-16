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

global $yolo_header_customize_current;
$yolo_header_layout = yolo_get_header_layout();
global $yolo_bestruct_options;
$prefix = 'yolo_';
$yolo_header_customize_current = 'nav';

$header_customize_class = array('header-customize header-customize-nav');
$header_customize = array();

if ('header-1' == $yolo_header_layout) {
    if (isset($yolo_bestruct_options['header_1_customize_nav']) && isset($yolo_bestruct_options['header_1_customize_nav']['enabled']) && is_array($yolo_bestruct_options['header_1_customize_nav']['enabled'])) {
        foreach ($yolo_bestruct_options['header_1_customize_nav']['enabled'] as $key => $value) {
            $header_customize[] = $key;
        }
    }
}

if ('header-2' == $yolo_header_layout) {
    if (isset($yolo_bestruct_options['header_2_customize_nav']) && isset($yolo_bestruct_options['header_2_customize_nav']['enabled']) && is_array($yolo_bestruct_options['header_2_customize_nav']['enabled'])) {
        foreach ($yolo_bestruct_options['header_2_customize_nav']['enabled'] as $key => $value) {
            $header_customize[] = $key;
        }
    }
}

if ('header-3' == $yolo_header_layout) {
    if (isset($yolo_bestruct_options['header_3_customize_nav']) && isset($yolo_bestruct_options['header_3_customize_nav']['enabled']) && is_array($yolo_bestruct_options['header_3_customize_nav']['enabled'])) {
        foreach ($yolo_bestruct_options['header_3_customize_nav']['enabled'] as $key => $value) {
            $header_customize[] = $key;
        }
    }
}

if ('header-4' == $yolo_header_layout) {
    if (isset($yolo_bestruct_options['header_4_customize_nav']) && isset($yolo_bestruct_options['header_4_customize_nav']['enabled']) && is_array($yolo_bestruct_options['header_4_customize_nav']['enabled'])) {
        foreach ($yolo_bestruct_options['header_4_customize_nav']['enabled'] as $key => $value) {
            $header_customize[] = $key;
        }
    }
}

if ('header-5' == $yolo_header_layout) {
    if (isset($yolo_bestruct_options['header_5_customize_nav']) && isset($yolo_bestruct_options['header_5_customize_nav']['enabled']) && is_array($yolo_bestruct_options['header_5_customize_nav']['enabled'])) {
        foreach ($yolo_bestruct_options['header_5_customize_nav']['enabled'] as $key => $value) {
            $header_customize[] = $key;
        }
    }
}

if ('header-6' == $yolo_header_layout) {
    if (isset($yolo_bestruct_options['header_6_customize_nav']) && isset($yolo_bestruct_options['header_6_customize_nav']['enabled']) && is_array($yolo_bestruct_options['header_6_customize_nav']['enabled'])) {
        foreach ($yolo_bestruct_options['header_6_customize_nav']['enabled'] as $key => $value) {
            $header_customize[] = $key;
        }
    }
}

if ('header-sidebar' == $yolo_header_layout) {
    if (isset($yolo_bestruct_options['headersidebar_customize_nav']) && isset($yolo_bestruct_options['headersidebar_customize_nav']['enabled']) && is_array($yolo_bestruct_options['headersidebar_customize_nav']['enabled'])) {
        foreach ($yolo_bestruct_options['headersidebar_customize_nav']['enabled'] as $key => $value) {
            $header_customize[] = $key;
        }
    }
}
?>
<?php if (count($header_customize) > 1): ?>
	<div class="<?php echo join(' ', $header_customize_class) ?>">
		<?php foreach ($header_customize as $key) {
			switch ($key) {
				case 'search-button':
					yolo_get_template('header/search-button');
					break;
				case 'search-box':
					yolo_get_template('header/search-box');
					break;
				case 'search-with-category':
					yolo_get_template('header/search-with-category');
					break;
				case 'shopping-cart':
					if (class_exists( 'WooCommerce' )) {
						yolo_get_template('header/mini-cart');
					}
					break;
				case 'wishlist':
					if (class_exists( 'WooCommerce' ) && class_exists('YITH_WCWL')) {
						yolo_get_template('header/wishlist');
					}
					break;
				case 'shopping-cart-price':
					if (class_exists( 'WooCommerce' )) {
						yolo_get_template('header/mini-cart-price');
					}
					break;
				case 'social-profile':
					yolo_get_template('header/social-profile');
					break;
				case 'custom-text':
					yolo_get_template('header/custom-text');
					break;
				case 'canvas-menu':
					yolo_get_template('header/canvas-menu');
					break;
				// case 'sidebar':
				// 	yolo_get_template('header/sidebar');
				// 	break;
			}
		} ?>
	</div>
<?php endif;?>