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

global $yolo_bestruct_options;

$prefix = 'yolo_';

$header_class = array('yolo-main-header', 'header-sidebar', 'header-desktop-wrapper');
$page_menu = get_post_meta(get_the_ID(), $prefix . 'page_menu',true);

?>
<header id="yolo-header" class="<?php echo join(' ', $header_class) ?>">
	<div class="vertical-header-wrapper">
		<!-- Top custom navigation (left) -->
		<div class="header-top">
			<?php yolo_get_template('header/header-logo' ); ?>
		</div>
		<!-- Bottom custom navigation (right) -->
		<div class="fb">
			<?php yolo_get_template('header/header-customize-right' ); ?>
		</div>
		<div class="header-bottom">
			<?php if (has_nav_menu('primary')) : ?>
				<div id="primary-menu" class="menu-wrapper">
					<?php
					$arg_menu = array(
						'menu_id'        => 'main-menu',
						'container'      => '',
						'theme_location' => 'primary',
						'menu_class'     => 'yolo-main-menu nav-collapse navbar-nav vertical-megamenu',
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
</header>