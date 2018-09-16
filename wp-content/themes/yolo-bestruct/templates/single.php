<?php
/**
 *  
 * @package    YoloTheme
 * @version    1.0.0
 * @created    25/12/2015
 * @author     Administrator <admin@yolotheme.com>
 * @copyright  Copyright (c) 2016, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
*/

global $yolo_archive_loop;
global $yolo_bestruct_options;

$prefix = 'yolo_';
$layout_style = get_post_meta(get_the_ID(), $prefix.'page_layout',true);
if (($layout_style == '') || ($layout_style == '-1')) {
    $layout_style = isset($yolo_bestruct_options['single_blog_layout']) ? $yolo_bestruct_options['single_blog_layout'] : 'container';
}

$sidebar = get_post_meta(get_the_ID(), $prefix.'page_sidebar',true);
if (($sidebar == '') || ($sidebar == '-1')) {
    $sidebar = isset($yolo_bestruct_options['single_blog_sidebar']) ? $yolo_bestruct_options['single_blog_sidebar'] : 'right';
}
$left_sidebar = get_post_meta(get_the_ID(), $prefix.'page_left_sidebar',true);
if (($left_sidebar == '') || ($left_sidebar == '-1')) {
    $left_sidebar = isset($yolo_bestruct_options['single_blog_left_sidebar']) ? $yolo_bestruct_options['single_blog_left_sidebar'] : 'sidebar-1';
}
$right_sidebar = get_post_meta(get_the_ID(), $prefix.'page_right_sidebar',true);
if (($right_sidebar == '') || ($right_sidebar == '-1')) {
    $right_sidebar = isset($yolo_bestruct_options['single_blog_right_sidebar']) ? $yolo_bestruct_options['single_blog_right_sidebar'] : 'sidebar-1';
}
$sidebar_width = get_post_meta(get_the_ID(), $prefix.'sidebar_width',true);
if (($sidebar_width == '') || ($sidebar_width == '-1')) {
    $sidebar_width = $yolo_bestruct_options['single_blog_sidebar_width'];
}
// Calculate sidebar column & content column
$sidebar_col = 'col-md-3';
if ($sidebar_width == 'large') {
    $sidebar_col = 'col-md-4';
}
$content_col_number = 12;
if (is_active_sidebar($left_sidebar) && (($sidebar == 'both') || ($sidebar == 'left'))) {
    if ($sidebar_width == 'large') {
        $content_col_number -= 4;
    } else {
        $content_col_number -= 3;
    }
}
if (is_active_sidebar($right_sidebar) && (($sidebar == 'both') || ($sidebar == 'right'))) {
    if ($sidebar_width == 'large') {
        $content_col_number -= 4;
    } else {
        $content_col_number -= 3;
    }
}
$content_col = 'col-md-' . $content_col_number;
if (($content_col_number == 12) && ($layout_style == 'full')) {
    $content_col = '';
}
$yolo_archive_loop['image-size'] = 'blog-large-image-full-width';
$main_class = array('site-content-single-post');
if ($content_col_number < 12) {
    $main_class[] = 'has-sidebar';
    $yolo_archive_loop['image-size'] = 'blog-large-image-sidebar';
}
?>
<?php
/**
 * @hooked - yolo_page_heading - 5
 **/
do_action('yolo_before_page');
?>
<main class="<?php echo join(' ',$main_class) ?>">
    <!-- Footer preview -->
    <?php if(is_singular('yolo_footer')):?>
        <div class = "footer-preview">
            <?php
                if ( have_posts() ) :
                    // Start the Loop.
                    while ( have_posts() ) : the_post();
                        /*
                         * Include the post format-specific template for the content. If you want to
                         * use this in a child theme, then include a file called called content-___.php
                         * (where ___ is the post format) and that will be used instead.
                         */
                        yolo_get_template( 'footer-preview' , get_post_format() );
                    endwhile;
                    yolo_archive_loop_reset();
                else :
                    // If no content, include the "No posts found" template.
                    yolo_get_template( 'archive/content-none');
                endif;
                ?>
        </div>
    <?php else:?>
        <?php if ($layout_style != 'full'): ?>
        <div class="<?php echo esc_attr($layout_style) ?> clearfix">
        <?php endif;?>
            <?php if (($content_col_number != 12) || ($layout_style != 'full')): ?>
            <div class="row clearfix">
                <?php endif;?>
                    <!-- Post type other -->
                    <?php if (is_active_sidebar( $left_sidebar ) && (($sidebar == 'left') || ($sidebar == 'both'))): ?>
                        <div class="sidebar left-sidebar <?php echo esc_attr($sidebar_col) ?> col-sm-12 col-xs-12">
                            <?php dynamic_sidebar( $left_sidebar );?>
                        </div>
                    <?php endif;?>
                    <div class="site-content-archive-inner <?php echo esc_attr($content_col) ?>">
                        <div class="blog-wrap">
                            <div class="blog-inner clearfix">
                                <?php
                                if ( have_posts() ) :
                                    // Start the Loop.
                                    while ( have_posts() ) : the_post();
                                        /*
                                         * Include the post format-specific template for the content. If you want to
                                         * use this in a child theme, then include a file called called content-___.php
                                         * (where ___ is the post format) and that will be used instead.
                                         */
                                        yolo_get_template( 'single-blog/content' , get_post_format() );
                                    endwhile;
                                    yolo_archive_loop_reset();
                                else :
                                    // If no content, include the "No posts found" template.
                                    yolo_get_template( 'archive/content-none');
                                endif;
                                ?>
                            </div>
                            <?php comments_template(); ?>
                        </div>
                    </div>
                    <?php if (is_active_sidebar( $right_sidebar ) && (($sidebar == 'right') || ($sidebar == 'both'))): ?>
                        <div class="sidebar right-sidebar <?php echo esc_attr($sidebar_col) ?> col-sm-12 col-xs-12">
                            <?php dynamic_sidebar( $right_sidebar );?>
                        </div>
                    <?php endif; ?>
            <?php if (($content_col_number != 12) || ($layout_style != 'full')) : ?>
            </div>
            <?php endif;?>
        <?php if ($layout_style != 'full'): ?>
        </div>
        <?php endif;?>
    <?php endif;?><!-- endif footer preview -->
</main>
