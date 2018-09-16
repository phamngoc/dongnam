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

$yolo_header_layout = yolo_get_header_layout();
global $yolo_bestruct_options;
$prefix = 'yolo_';
$logo_url = '';
if(is_page()){
	$logo_meta = get_post_meta(get_the_ID(), $prefix . 'custom_logo', true);
	if ($logo_meta) {
		$logo_url = wp_get_attachment_url($logo_meta);
	}
}

if ( '' == $logo_url) {
	if (isset($yolo_bestruct_options['logo']['url']) && !empty($yolo_bestruct_options['logo']['url'])) {
		$logo_url = $yolo_bestruct_options['logo']['url'];
	}else{
		$logo_url = get_template_directory_uri() . '/assets/images/theme-options/logo.png';
	}
}

$logo_sticky = '';

if (!in_array($yolo_header_layout, array('header-1', 'header-2', 'header-4', 'header-5','header-sidebar'))) {
	$logo_sticky_meta = get_post_meta(get_the_ID(), $prefix . 'sticky_logo', true);

	if ($logo_sticky_meta) {
		$logo_sticky = wp_get_attachment_url($logo_sticky_meta);
	}

	if (empty($logo_sticky)) {
		if (isset($yolo_bestruct_options['sticky_logo']) && isset($yolo_bestruct_options['sticky_logo']['url'])) {
			$logo_sticky = $yolo_bestruct_options['sticky_logo']['url'];
		}else if($logo_url) {
			$logo_sticky = $logo_url;
		}
	}
}

$header_logo_class = array('header-logo');

if (!empty($logo_sticky) && ($logo_sticky != $logo_url)) {
	$header_logo_class[] = 'has-logo-sticky';
}
?>
<div class="<?php echo join(' ', $header_logo_class) ?>">
	<a  href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?> - <?php bloginfo( 'description' ); ?>">
		<img src="<?php echo esc_url($logo_url); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?> - <?php bloginfo( 'description' ); ?>" />
	</a>
</div>
<?php if (!empty($logo_sticky) && ($logo_sticky != $logo_url)) : ?>
	<div class="logo-sticky">
		<a  href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?> - <?php bloginfo( 'description' ); ?>">
			<img src="<?php echo esc_url($logo_sticky); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?> - <?php bloginfo( 'description' ); ?>" />
		</a>
	</div>
<?php endif;?>