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
?>

<div class="<?php echo $layout_type; ?> icon-box-shortcode-wrap">
    <div class="icon-box-container">
        <?php if($image !='') : ?>
            <div class="icon-wrap" <?php if($bg_color!=''): ?> style="background-color:<?php echo esc_attr($bg_color); ?>"<?php endif ?>>
                <img src="<?php echo wp_get_attachment_image_url( $image, 'medium' ) ?>" <?php if (wp_get_attachment_image_srcset( $image, 'medium' ) != false) { echo 'srcset="'.wp_get_attachment_image_srcset( $image, 'medium' ).'" sizes="'.wp_get_attachment_image_sizes( $image, 'medium' ).'"'; } ?> class="img-responsive" alt="<?php echo $title?>" />
            </div>  
        <?php else : ?> 
             <div class="icon-wrap" <?php if($bg_color!=''): ?> style="background-color:<?php echo esc_attr($bg_color); ?>"<?php endif ?>>
                <span class="<?php echo $iconClass; ?>" style="color:<?php echo $icon_color; ?>"></span>
            </div>    
        <?php endif; ?>
        <div class="icon-content">
            <h2 class="icon-title">
                <?php if ( strlen( $link ) > 0 && strlen( $url['url'] ) > 0 ) : ?>
                    <a href="<?php echo esc_attr( $url['url'] ) ?>" title="<?php echo esc_attr( $url['title'] ); ?>" target="<?php echo ( strlen( $url['target'] ) > 0 ? esc_attr( $url['target'] ) : '_self' ) ?>">
                <?php endif; ?>
                <?php echo $title; ?>
                <?php if ( strlen( $link ) > 0 && strlen( $url['url'] ) > 0 ) : ?>
                    </a>
                <?php endif; ?>
            </h2>
            <p class="icon-description"><?php echo $description; ?></p>
        </div>
    </div>
</div>