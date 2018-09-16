<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $number
 * @var $text
 */
?> 
<div class="yl-button-play yolo-container" style="height: <?php echo esc_attr( $yolo_height ); ?>px;">
    <div class="container-text container">
        <p data-height="<?php echo esc_attr( $yolo_height ); ?>" data-video="<?php echo esc_attr( $yolo_video_link ); ?>" data-id ="<?php echo esc_attr( $video_id ); ?>" class="play-button">
            <i <?php if(isset($icon_color) && $icon_color!=''):?> style="color:<?php echo esc_attr($icon_color); ?>"<?php endif;?> class="fa fa-play-circle-o"></i>
        </p>
        <?php if($yolo_title!=''):?>
        <h1 class="yl-introduction" <?php if(isset($title_color) && $title_color!=''):?> style="color:<?php echo esc_attr($title_color); ?>"<?php 
        endif;?>><?php echo esc_html( $yolo_title ); ?></h1>
        <?php endif;?>
        <?php if($des_color!=''):?>
        <div class="yl-description" <?php if(isset($des_color) && $des_color!=''):?>style="color:<?php echo esc_attr($des_color); ?>"<?php endif;?>>
        <?php echo esc_html( $yolo_description ); ?></div>
        <?php endif;?>
    </div>  
</div>