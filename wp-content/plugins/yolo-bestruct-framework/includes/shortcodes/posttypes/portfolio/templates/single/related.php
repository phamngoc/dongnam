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

$index        = 0;
$column       = '';
$image_size   = '600x400';
$show_pagging = '2';
$item         = 4;
global $yolo_bestruct_options;
$args = array(
    'post__not_in'           => array($post_id),
    'posts_per_page'         => -1,
    'orderby'                => 'rand',
    'post_type'              => 'yolo_portfolio',
    'portfolio_category__in' => $arrCatId,
    'post_status'            => 'publish'
);
$posts_array = new WP_Query( $args );
$total_post = $posts_array->found_posts;
$data_plugin_options = $owl_carousel_class = '';
$column = isset($yolo_bestruct_options['portfolio-related-column']) ? $yolo_bestruct_options['portfolio-related-column'] : '4';
if ($total_post / $item > 1) {
    $data_plugin_options = 'data-plugin-options='. $column;
    $owl_carousel_class = 'owl-carousel';
}
$overlay_style = 'icon';
$columns = 'bestruct-col-md-4';
if(isset($yolo_bestruct_options['portfolio-related-overlay']))
    $overlay_style = $yolo_bestruct_options['portfolio-related-overlay'];
if(isset($yolo_bestruct_options['portfolio-related-column']))
    $columns = 'bestruct-col-md-'.$yolo_bestruct_options['portfolio-related-column'];

// $layout = 'title';
$layout = 'default';
if(isset($yolo_bestruct_options['portfolio_related_style']) && $yolo_bestruct_options['portfolio_related_style']!='' )
    $layout = $yolo_bestruct_options['portfolio_related_style'];

$overlay_effect = 'effect_1';
if(isset($yolo_bestruct_options['portfolio_related_effect']) && $yolo_bestruct_options['portfolio_related_effect']!='' )
    $overlay_effect = $yolo_bestruct_options['portfolio_related_effect'];

if ($overlay_style == 'left-title-excerpt-link')
    $overlay_align = 'hover-align-left';
else
    $overlay_align = 'hover-align-center';

?>

<div class="container">
    <div class="portfolio-related-wrap">
        <div class="heading-wrap border-primary-color">
            <nav class="post-navigation">
                <div class="nav-links">
                    <?php
                    previous_post_link('<div class="nav-previous">%link</div>', _x('<div class="post-navigation-left"><i class="post-navigation-icon fa fa-long-arrow-left"></i> </div> <div class="post-navigation-content"> <div class="post-navigation-title">%title </div> </div> ', 'Previous post link', 'yolo-bestruct'));
                    echo '<i class="fa fa-th-large"></i>';
                    next_post_link('<div class="nav-next">%link</div>', _x('<div class="post-navigation-content"> <div class="post-navigation-title">%title</div></div> <div class="post-navigation-right"><i class="post-navigation-icon fa fa-long-arrow-right"></i> </div>', 'Next post link', 'yolo-bestruct'));
                    ?>
                </div>
                <!-- .nav-links -->
            </nav><!-- .navigation -->
            <div class="heading s-font">
                <?php echo esc_html__('Related Projects','yolo-bestruct'); ?>
                <div class="heading-icon">
                    <i class="fa fa-circle-o"></i>
                </div>
            </div>
        </div>
        <div class="portfolio-related portfolio-wrapper <?php echo sprintf('%s %s',$columns, $owl_carousel_class)?>" <?php echo wp_kses_post($data_plugin_options) ?>>
            <?php
            while ( $posts_array->have_posts() ) : $posts_array->the_post();
                $index++;
                $permalink   = get_permalink();
                $title_post  = get_the_title();
                $terms       = wp_get_post_terms( get_the_ID(), array( 'portfolio_category'));
                $filter_name = $filter_slug = '';
                foreach ( $terms as $term ){
                    $filter_slug .= preg_replace('/\s+/', '', $term->name) .' ';
                    $filter_name .= $term->name.', ';
                }
                $filter_name = rtrim($filter_name,', ');

                ?>
                <?php include(WP_PLUGIN_DIR.'/yolo-bestruct-framework/includes/shortcodes/posttypes/portfolio/templates/loop/'.$layout.'-item.php');
                ?>
            <?php
            endwhile;
            wp_reset_postdata();
            ?>
        </div>
    </div>
</div>

