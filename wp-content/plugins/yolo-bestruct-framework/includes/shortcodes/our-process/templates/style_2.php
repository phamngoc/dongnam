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
$our_process = (array)vc_param_group_parse_atts( $our_process );
?>
<div class="<?php echo $layout_type; ?> our-process-shortcode-wrap">
    <ul class="our-process-list">
        <?php foreach( $our_process as $client ) :?>
            <li class="our-process-item">
            <?php if( isset($client['url']) ) : // Show if have url in $client array ?> 
            <a href="<?php echo esc_url($client['url']); ?>">
            <?php endif; ?>
            <?php if(isset($client['icon'])) :?>
                    <div class="icon-wrap" <?php if($font_size!='') :?> style="font-size:<?php echo $font_size; ?>" <?php endif; ?>>
                        <i class="<?php echo $client['icon']; ?>" <?php if($icon_color!='') :?> style="color:<?php echo $icon_color; ?>" ?> <?php endif;?>></i>
                    </div> 
                <?php else : echo esc_html__('Please select Process!','yolo-bestruct');?>   
            <?php endif; ?>  
            <?php if(isset($client['name'])) :?>
                <div class="process-title">
                    <?php echo $client['name']; ?>
                </div>
            <?php endif; ?>  
            <?php if( isset($client['url']) ) : // Show if have url in $client array ?> 
            </a>
            <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
