<?php
/**
 *  
 * @package    YoloTheme/Yolo Bestruct
 * @version    1.0.0
 * @author     Administrator <yolotheme@vietbrain.com>
 * @copyright  Copyright (c) 2016, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
*/

$image_src = wp_get_attachment_image_src($image, 'full');
?>
<div class="banner-shortcode-wrap <?php echo $layout_type; ?>">
	<div class="banner-content">
        <?php if ( strlen( $link ) > 0 && strlen( $url['url'] ) > 0 ) : ?>
            <a href="<?php echo esc_url($url['url']); ?>">
        <?php endif; ?>
            <?php if( $image_src != '' ) : ?>
                <div class="image-banner" <?php if($border_color!=''): ?> style="color:<?php echo esc_attr($border_color); ?>"<?php endif ?>>
                    <img width="<?php echo esc_attr($image_src[1]) ?>" height="<?php echo esc_attr($image_src[2]) ?>" src="<?php echo esc_url($image_src[0]); ?>" alt="<?php echo $title; ?>">
                </div>
            <?php endif; ?>
        <?php if ( strlen( $link ) > 0 && strlen( $url['url'] ) > 0 ) : ?>
            </a>
        <?php endif; ?>
    </div>
</div>