<?php
/**
 *  
 * @package    YoloTheme
 * @version    1.0.0
 * @created    25/12/2015
 * @author     Administrator <admin@yolotheme.com>
 * @copyright  Copyright (c) 2015, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
*/

/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 */
global $yolo_archive_loop,$yolo_bestruct_options;
if (isset($yolo_archive_loop['image-size'])) {
    $size = $yolo_archive_loop['image-size'];
} else {
    $size = 'full';
}

$class = array();
$class[]= "clearfix";
wp_enqueue_style('prettyPhoto');
wp_enqueue_script('prettyPhoto');
?>
<article id="post-<?php the_ID(); ?>" <?php post_class($class); ?>>  
    <?php
    $thumbnail = yolo_post_thumbnail($size);?>
        <div class="entry-thumbnail-wrap">
            <?php //the_post_thumbnail('full');
            echo wp_kses_post($thumbnail); ?>
        </div>
    <div class="entry-post-meta-wrap">
        <?php yolo_single_post_meta(); ?>
    </div>
    <div class="entry-content-wrap">
        <div class="entry-content clearfix">
            <?php the_content(); ?>
        </div>

        <?php
        /**
         * @hooked - yolo_link_pages - 5
         * @hooked - yolo_post_tags - 10
         * @hooked - yolo_share - 15
         *
         **/
        do_action('yolo_after_single_post_content');
        ?>

    </div>
    <?php
    /**
     * @hooked - yolo_post_nav - 20
     * @hooked - yolo_post_author_info - 25
     *
     **/
    ?>
</article>
<?php $related_display = isset($yolo_bestruct_options['related_post']) ? $yolo_bestruct_options['related_post'] : '';
        if($related_display == 1){
            yolo_get_template( 'single-blog/related');
        }
?>
<?php do_action('yolo_after_single_post');?>
