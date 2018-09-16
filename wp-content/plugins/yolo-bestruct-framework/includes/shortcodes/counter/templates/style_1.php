<?php
/**
 * Created by GDragon.
 * User: Administrator
 * Date: 21/4/2016
 * Time: 5:40 PM
 */
$image_src = wp_get_attachment_image_src($image, 'full');
?>
<div class="gr-counter gr-animated <?php echo esc_attr($layout_type); ?> ">
  <div class="content-inner">
    <?php if( $image_src != '' ) : ?>
        <div class="icon-img" >
            <img width="<?php echo esc_attr($image_src[1]) ?>" height="<?php echo esc_attr($image_src[2]) ?>" src="<?php echo esc_url($image_src[0]); ?>" alt="<?php echo $title; ?>">
        </div>
    <?php endif; ?>
    <div data-from="0" data-to="<?php echo esc_attr($number); ?>" class="gr-number-counter">
      <?php echo esc_attr($number); ?>
    </div>
    <?php if($sub_text):?>
        <span><?php echo esc_html($sub_text);?></span>
    <?php endif;?>
    <div class="gr-text-defaul"><?php echo esc_html($title); ?></div>
  </div>
</div>
