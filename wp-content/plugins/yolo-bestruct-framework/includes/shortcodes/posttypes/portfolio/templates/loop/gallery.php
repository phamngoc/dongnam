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
<div style="display: none">
    <?php
    $meta_values = get_post_meta(get_the_ID(), 'yolo_portfolio_data_format_gallery', false);
    if (count($meta_values) > 0) :
        foreach ($meta_values as $image) :
            $urls = wp_get_attachment_image_src($image, 'full');
            $gallery_img = '';
            if (count($urls) > 0 && is_array($urls))
                $gallery_img = $urls[0];
            ?>
            <div>
                <a href="<?php echo esc_url($gallery_img) ?>"
                   data-rel="prettyPhoto[pp_gal_<?php echo get_the_ID() ?>]"
                   title="<?php echo "<a href='" . $permalink . "'>" . $title_post . "</a>" ?>"></a>
            </div>
        <?php
        endforeach;
    endif;
    ?>
</div>