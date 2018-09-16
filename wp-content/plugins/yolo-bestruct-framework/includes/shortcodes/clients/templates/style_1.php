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
$clients = (array)vc_param_group_parse_atts( $clients );
$clients_id = uniqid();

?>
<div class="<?php echo $layout_type; ?> clients-shortcode-wrap <?php echo $style; ?>">
    <div class="clients-list <?php if($style=='slider') :?>
 owl-carousel <?php else: echo $columns; ?> <?php endif?>" 
    <?php if($style=='slider'):?>
        data-owl="<?php echo esc_attr($logo_per_slide)?>"
        data-autoplay="<?php echo esc_attr($autoplay)?>"
        data-duration="<?php echo esc_attr($slide_duration)?>"
        data-margin="80"
        data-rtl="<?php echo esc_attr($rtl)?>"
        data-nav="true"
        data-loop="true"
    <?php endif;?>
    >
        <?php foreach( $clients as $client ) :  ?>
            <div class="client-item">
            <?php if( isset($client['url']) ) : // Show if have url in $client array ?> 
            <a href="<?php echo esc_url($client['url']); ?>">
            <?php endif; ?>
            <?php if(isset($client['logo'])) :?>
                    <?php $image_src = wp_get_attachment_url($client['logo']); ?>
                    <img src="<?php echo esc_url($image_src); ?>" alt="<?php echo $client['name']; ?>">
                <?php else : echo esc_html__('Please select logo!','yolo-bestruct');?>   
            <?php endif; ?>  
            <?php if( isset($client['url']) ) : // Show if have url in $client array ?> 
            </a>
            <?php endif; ?>
            </div>
            
        <?php endforeach; ?>
        
    </div>
</div>
