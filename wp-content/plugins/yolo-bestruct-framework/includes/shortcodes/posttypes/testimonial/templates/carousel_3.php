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

$testimonial_id = uniqid();
?>
<div id="yolo-testimonial" class="yolo-testimonial testimonial-carousel-3">
    <ul id="testimonial-list-<?php echo $testimonial_id; ?>" class="testimonials testimonial-list owl-carousel"
        data-owl="3"
        data-margin="20"
        data-loop="true"
        data-nav="true"
        data-duration="<?php echo esc_attr($slide_duration)?>"
        data-autoplay="<?php echo esc_attr($autoplay);?>"
        data-rtl="<?php echo esc_attr($rtl);?>"
    >
        <?php while( $testimonials->have_posts() ) : $testimonials->the_post(); 
                $background_id  = yolo_get_post_meta( get_the_ID(), 'yolo_testimonial_background',true );
                $background_url = wp_get_attachment_url( $background_id );
                $url = yolo_get_post_meta( get_the_ID(), 'yolo_testimonial_url',true );
        ?>
        <li class="testimonial-item" <?php if ($background_url):?> style="background-image:url(<?php echo esc_url($background_url);?>)"<?php endif;?>>
            <div class="testimonial-thumb">
                <?php if($url):?>
                        <a href="<?php echo esc_url($url);?>">
                <?php endif;?>
                <?php the_post_thumbnail(); ?>
                <?php if($url):?>
                    </a>
                <?php endif;?>
            </div>
            <div class="testimonial-content"><?php the_content();?> </div>
            <div class="info-testimonial">
                <?php if($url):?>
                    <a href="<?php echo esc_url($url);?>">
                <?php endif;?>
                <h3 class="testimonial-title"><?php the_title(); ?></h3>
                <?php if($url):?>
                    </a>
                <?php endif;?>
                <h4 class="testimonial-position"><?php echo yolo_get_post_meta( get_the_ID(), 'yolo_testimonial_position',true); ?></h4>
            </div>
        </li>
        <?php endwhile; ?>
    </ul>
</div>
