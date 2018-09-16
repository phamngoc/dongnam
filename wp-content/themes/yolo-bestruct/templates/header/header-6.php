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

$prefix = 'yolo_';

$header_class = array('yolo-main-header', 'header-6', 'header-desktop-wrapper');
$header_nav_wrapper = array('yolo-header-nav-wrapper');
$header_sticky_effect = '';
// @TODO: need process page_enable_header_customize from header.php
$header_layout_float = $yolo_bestruct_options['header_6_nav_layout_float'];

if ( 1 == $header_layout_float ) {
	$header_class[] = 'header-float';
}

$header_sticky = $yolo_bestruct_options['header_sticky'];

if ( 1 == $header_sticky ) {
	wp_enqueue_script( 'sticky-header' );
	$header_nav_wrapper[] = 'header-sticky';
    $header_nav_wrapper[] = 'animate';
    $header_sticky_effect = isset($yolo_bestruct_options['header_sticky_effect']) ? $yolo_bestruct_options['header_sticky_effect'] : 'slideDown,slideUp';
    $header_sticky_scheme = isset($yolo_bestruct_options['header_sticky_scheme']) ? $yolo_bestruct_options['header_sticky_scheme'] : 'inherit';
    $header_nav_wrapper[] = 'sticky-scheme-' . $header_sticky_scheme;
}

$page_menu 				= get_post_meta(get_the_ID(), $prefix . 'page_menu',true);
$header_nav_layout 		= isset($yolo_bestruct_options['header_6_nav_layout']) ? $yolo_bestruct_options['header_6_nav_layout'] : '';

if ( 'nav-fullwith' == $header_nav_layout ) {
	$header_nav_wrapper[] = $header_nav_layout;
}
?>
<header id="yolo-header" class="<?php echo join(' ', $header_class) ?>">
	<div class="<?php echo join(' ', $header_nav_wrapper) ?>" data-effect ="<?php echo esc_attr($header_sticky_effect);?>">
		<div class="container">
			<div class="yolo-header-wrapper">
				<div class="header-left-offcanvas">
					<?php yolo_get_template('header/header-customize-left' ); ?>
				</div>
				<div class="header-left">
					<?php yolo_get_template('header/header-logo' ); ?>
				</div>
				<div class="header-center">
						<?php if (has_nav_menu('primary')) : ?>
							<div id="primary-menu" class="menu-wrapper">
								<?php
								$arg_menu = array(
									'menu_id'        => 'main-menu',
									'container'      => '',
									'theme_location' => 'primary',
									'menu_class'     => 'yolo-main-menu nav-collapse navbar-nav',
									'fallback_cb'    => 'please_set_menu',
									'walker'         => new Yolo_MegaMenu_Walker()
								);
								if (!empty($page_menu)) {
									$arg_menu['menu'] = $page_menu;
								}
								wp_nav_menu( $arg_menu );
								?>
							</div>
						<?php endif; ?>
						<?php yolo_get_template('header/header-customize-nav' ); ?>
				</div>
			</div>
		</div>
	</div>
</header>