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

$cat = '';
foreach ( $terms as $term ){
    $cat .= $term->name.', ';
}
$cat = rtrim($cat,', ');

global $yolo_bestruct_options;
$disable_link = false;
if(isset($yolo_bestruct_options['portfolio_disable_link_detail']) && $yolo_bestruct_options['portfolio_disable_link_detail']=='1' ) {
    $disable_link = true;
}

?>
<div class="entry-thumbnail title-category-link <?php echo $overlay_effect; ?>">
    <img width="<?php echo esc_attr($width) ?>" height="<?php echo esc_attr($height) ?>" src="<?php echo esc_url($thumbnail_url) ?>" alt="<?php echo get_the_title() ?>"/>
    <div class="entry-thumbnail-hover p-bg-rgba-color">
        <div class="entry-hover-wrapper">
            <div class="entry-hover-inner">
                <div class="hover-content">
                    <span class="link-button">
                         <?php if (!$disable_link){?>
                             <a class="link p-color-hover"  href="<?php echo get_permalink(get_the_ID()) ?>" title="<?php echo get_the_title() ?>">
                                 <i class="fa fa-link"></i>
                             </a>
                         <?php } ?>
                    </span>
                    <?php if ($disable_link){?>
                        <div class="title line-height-1"><?php the_title() ?></div>
                    <?php } else {?>
                        <a href="<?php echo get_permalink(get_the_ID()) ?>" class="line-height-1"><div class="title fc-white"><?php the_title() ?></div> </a>
                    <?php }?>
                    <span class="category line-height-1"><?php echo wp_kses_post($cat) ?></span>
                </div>
               
            </div>
        </div>
    </div>

</div>