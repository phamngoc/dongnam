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
<div id="yolo-testimonial-<?php echo esc_attr($testimonial_id);?>" class="yolo-testimonial testimonial-carousel"
    data-autoplay="<?php echo esc_attr($autoplay)?>"
    data-rtl="<?php echo esc_attr($rtl)?>"
>
    <ul id="sync2" class="testimonials testimonial-sync2 owl-carousel">
         <?php while( $testimonials->have_posts() ) : $testimonials->the_post();
                $background_id  = yolo_get_post_meta( get_the_ID(), 'yolo_testimonial_background',true );
                $background_url = wp_get_attachment_url( $background_id );
                $url = yolo_get_post_meta( get_the_ID(), 'yolo_testimonial_url',true );
        ?>
        <li class="testimonial-thumb" <?php if ($background_url):?> style="background-image:url(<?php echo esc_url($background_url);?>)"<?php endif;?>>
           <?php if($url):?>
                    <a href="<?php echo esc_url($url);?>">
            <?php endif;?>
           <?php the_post_thumbnail(); ?>
           <?php if($url):?>
                    </a>
            <?php endif;?>
        </li>
        <?php endwhile; ?>
    </ul>
    <ul id="sync1" class="testimonials testimonial-sync1 owl-carousel">
        <?php while( $testimonials->have_posts() ) : $testimonials->the_post(); 
            $testimonial_position = yolo_get_post_meta( get_the_ID(), 'yolo_testimonial_position',true );
        ?>
        <li class="testimonial-item">
            <?php if($url):?>
                    <a href="<?php echo esc_url($url);?>">
            <?php endif;?>
            <h3 class="testimonial-title"><?php the_title(); ?></h3>
            <?php if($url):?>
                    </a>
            <?php endif;?>
            <?php if( !empty($testimonial_position) ) : ?>
            <p class="testimonial-position"><?php echo esc_html($testimonial_position); ?></p>
            <?php endif; ?>
            <div class="testimonial-content"><?php the_content(); ?> </div>
        </li>
        <?php endwhile; ?>
       
    </ul>
   
</div>
