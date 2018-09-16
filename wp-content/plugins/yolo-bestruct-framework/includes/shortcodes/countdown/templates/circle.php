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

$time_id = uniqid();
$diff = strtotime($datetime)-time();
wp_enqueue_script('redcountdown');
?>
<div id="countdown-<?php echo esc_attr($time_id);?>" class="countdown-shortcode-wrap circle-style" data-time="<?php echo esc_attr($diff)?>">
    <div class="countdown-content"></div>
</div>
