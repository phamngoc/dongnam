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

global $yolo_bestruct_options;
$disable_link = false;
if( isset($yolo_bestruct_options['portfolio_disable_link_detail']) && $yolo_bestruct_options['portfolio_disable_link_detail'] == '1' ) {
    $disable_link = true;
}

// Lightbox render
switch ($portfolio_type) {
    case 'image':
        $data_rel = $url_origin;
        break;
    case 'gallery':
        $data_rel = $url_origin;
        break;
    case 'link':
        $data_rel = get_post_meta(get_the_ID(), 'yolo_portfolio_data_format_link_url', true);
        break;
    case 'video':
        $data_rel = get_post_meta(get_the_ID(), 'yolo_portfolio_data_format_video', true);
        break;
    
    default:
        $data_rel = $url_origin;
        break;
}

?>
<div class="entry-thumbnail icon-only <?php echo $overlay_effect; ?>">
    <img width="<?php echo esc_attr($width) ?>" height="<?php echo esc_attr($height) ?>" src="<?php echo esc_url($thumbnail_url) ?>" alt="<?php echo get_the_title() ?>"/>
    <div class="entry-thumbnail-hover p-bg-rgba-color">
        <div class="entry-hover-wrapper">
            <div class="entry-hover-inner">
                <?php if ($disable_link) : ?>
                    <i class="fa fa-search"></i>
                <?php else : ?>
                    <?php 

                    switch ($portfolio_type) {
                        case 'image':
                            echo sprintf('<a href="%s" data-rel="prettyPhoto[pp_gal_%u]" title="%s">', esc_url($data_rel), esc_attr(get_the_ID()), esc_attr(get_the_title()) );
                            break;
                        case 'gallery':
                            echo sprintf('<a href="%s" data-rel="prettyPhoto[pp_gal_%u]" title="%s">', esc_url($data_rel), esc_attr(get_the_ID()), esc_attr(get_the_title()) );
                            break;
                        case 'link':
                            echo sprintf('<a href="%s" title="%s">', esc_url($data_rel), esc_attr(get_the_title()) );
                            break;
                        case 'video':
                            echo sprintf('<a href="%s" data-rel="prettyPhoto" title="%s">', esc_url($data_rel), esc_attr(get_the_title()) );
                            break;
                        
                        default:
                            echo sprintf('<a href="%s" data-rel="prettyPhoto[pp_gal_%u]" title="%s">', $data_rel, get_the_ID(), get_the_title() );
                            break;
                    }
                    ?>
                        <?php
                            switch ($portfolio_type) {
                                case 'image':
                                    echo '<i class="fa fa-search"></i>';
                                    break;
                                case 'gallery':
                                    echo '<i class="fa fa-expand"></i>';
                                    break;
                                case 'link':
                                    echo '<i class="fa fa-link"></i>';
                                    break;
                                case 'video':
                                    echo '<i class="fa fa-play-circle"></i>';
                                    break;
                                 
                                default:
                                    echo '<i class="fa fa-search"></i>';
                                    break;
                            } 
                            
                        ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

</div>
