<?php
/**
 *  
 * @package    YoloTheme
 * @version    1.0.0
 * @created    23/12/2015
 * @author     Administrator <admin@yolotheme.com>
 * @copyright  Copyright (c) 2015, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
*/
global $yolo_bestruct_options;
$prefix = 'yolo_';
$page_title_warp_class = array();
$section_page_title_class = array('yolo-page-title-section archive-title-margin');
$inherit_archive_title = isset($yolo_bestruct_options['inherit_archive_title'])?$yolo_bestruct_options['inherit_archive_title']:1;
$on_front = get_option('show_on_front'); // core in redux
$page_sub_title = strip_tags(term_description());
$page_title = $page_title_bg_image_url = '';
if (!have_posts()) {
    $page_title = esc_html__( "Nothing Found", 'yolo-bestruct' );
} elseif (is_home()) {
    if (($on_front == 'page' && get_queried_object_id() == get_post(get_option('page_for_posts'))->ID) || ($on_front == 'posts')) {
        $page_title = esc_html__( "Blog", 'yolo-bestruct' );
    } else {
        $page_title = '';
    }
} elseif (is_category()) {
    $page_title = single_cat_title('', false);
} elseif (is_tag()) {
    $page_title = single_tag_title(esc_html__( "Tags: ", 'yolo-bestruct' ), false);
} elseif (is_author()) {
    $page_title = sprintf(esc_html__( 'Author: %s', 'yolo-bestruct' ), get_the_author());
} elseif (is_day()) {
    $page_title = sprintf(esc_html__( 'Daily Archives: %s', 'yolo-bestruct' ), get_the_date());
} elseif (is_month()) {
    $page_title = sprintf(esc_html__( 'Monthly Archives: %s', 'yolo-bestruct' ), get_the_date(_x('F Y', 'monthly archives date format', 'yolo-bestruct')));
} elseif (is_year()) {
    $page_title = sprintf(esc_html__( 'Yearly Archives: %s', 'yolo-bestruct' ), get_the_date(_x('Y', 'yearly archives date format', 'yolo-bestruct')));
} elseif (is_search()) {
    $page_title = sprintf(esc_html__( 'Search Results for: %s', 'yolo-bestruct' ), get_search_query());
} elseif (is_tax('post_format', 'post-format-aside')) {
    $page_title = esc_html__( 'Asides', 'yolo-bestruct' );
} elseif (is_tax('post_format', 'post-format-gallery')) {
    $page_title = esc_html__( 'Galleries', 'yolo-bestruct' );
} elseif (is_tax('post_format', 'post-format-image')) {
    $page_title = esc_html__( 'Images', 'yolo-bestruct' );
} elseif (is_tax('post_format', 'post-format-video')) {
    $page_title = esc_html__( 'Videos', 'yolo-bestruct' );
} elseif (is_tax('post_format', 'post-format-quote')) {
    $page_title = esc_html__( 'Quotes', 'yolo-bestruct' );
} elseif (is_tax('post_format', 'post-format-link')) {
    $page_title = esc_html__( 'Links', 'yolo-bestruct' );
} elseif (is_tax('post_format', 'post-format-status')) {
    $page_title = esc_html__( 'Statuses', 'yolo-bestruct' );
} elseif (is_tax('post_format', 'post-format-audio')) {
    $page_title = esc_html__( 'Audios', 'yolo-bestruct' );
} elseif (is_tax('post_format', 'post-format-chat')) {
    $page_title = esc_html__( "Chats", 'yolo-bestruct' );
} else {
    $page_title = esc_html__( "Archives", 'yolo-bestruct' );
}
if($inherit_archive_title == 1){
    $show_page_title = isset($yolo_bestruct_options['show_page_title'])? $yolo_bestruct_options['show_page_title'] :1;
    if($show_page_title == 1){
        $page_title_layout = isset($yolo_bestruct_options['page_title_layout']) ? $yolo_bestruct_options['page_title_layout'] : '';
        $page_title_margin = $yolo_bestruct_options['page_title_margin'];
        if(is_array($page_title_margin) && isset($page_title_margin['margin-top'])){
            $page_title_margin_top = $page_title_margin['margin-top'];
        }
        if(is_array($page_title_margin) && isset($page_title_margin['margin-bottom'])){
            $page_title_margin_bottom = $page_title_margin['margin-bottom'];
        }
        $page_title_text_align = isset($yolo_bestruct_options['page_title_style']) ? $yolo_bestruct_options['page_title_style'] :'page-title-style-1';
        $page_title_parallax = $yolo_bestruct_options['page_title_parallax'];
        $page_title_height = $yolo_bestruct_options['page_title_height'];
        $page_title_bg_image = $yolo_bestruct_options['page_title_bg_image'];
        
        if (isset($page_title_bg_image) && $page_title_bg_image['url'] != '') {
            $page_title_bg_image_url = $page_title_bg_image['url'];
        }else{
            $page_title_bg_image_url = get_template_directory_uri() . '/assets/images/bg-page-title.jpg';
        }
        $breadcrumbs_in_page_title = isset($yolo_bestruct_options['breadcrumbs_in_page_title']) ? $yolo_bestruct_options['breadcrumbs_in_page_title'] : 1;
    }
}else{
    $show_page_title = isset($yolo_bestruct_options['show_archive_title']) ? $yolo_bestruct_options['show_archive_title'] : 1;
    if($show_page_title == 1){
        $archive_title_margin = $yolo_bestruct_options['archive_title_margin'];
        if(is_array($archive_title_margin) && isset($archive_title_margin['margin-top'])){
            $page_title_margin_top = $archive_title_margin['margin-top'];
        }
        if(is_array($archive_title_margin) && isset($archive_title_margin['margin-bottom'])){
            $page_title_margin_bottom = $archive_title_margin['margin-bottom'];
        }
        $page_title_layout = $yolo_bestruct_options['archive_title_layout'];
        $page_title_text_align = isset($yolo_bestruct_options['archive_title_style']) ? $yolo_bestruct_options['archive_title_style'] : 'page-title-style-1';
        $page_title_parallax = $yolo_bestruct_options['archive_title_parallax'];
        $page_title_height = $yolo_bestruct_options['archive_title_height'];
        $archive_title_bg_image = $yolo_bestruct_options['archive_title_bg_image'];
        if (isset($archive_title_bg_image) && $archive_title_bg_image['url'] != '') {
            $page_title_bg_image_url = $archive_title_bg_image['url'];
        }else{
            $page_title_bg_image_url = get_template_directory_uri() . '/assets/images/bg-page-title.png';
        }
        $breadcrumbs_in_page_title = isset($yolo_bestruct_options['breadcrumbs_in_archive_title']) ? $yolo_bestruct_options['breadcrumbs_in_archive_title'] : 1;
    }
}
$cat = get_queried_object();
if ($cat && property_exists( $cat, 'term_id' )) {
    $cat_title_bg_image = get_tax_meta($cat,$prefix.'page_title_background');
    if(is_array($cat_title_bg_image) && isset($cat_title_bg_image['url'])){
        $page_title_bg_image_url = $cat_title_bg_image['url'];
    }
    $page_title_height = get_tax_meta($cat,$prefix.'page_title_height');
}
/*-------------- Margin-----------------*/
$margins = array();
$margin = '';
if(!empty($page_title_margin_top)){
    $margins[] = 'margin-top:'.$page_title_margin_top;
}
if(!empty($page_title_margin_bottom)){
    $margins[] = 'margin-bottom:'.$page_title_margin_bottom;
}else{
    $margins[] = 'margin-bottom:50px';
}
if(!empty($margins)){
    $margin = 'style='. join(';',$margins);
}
/*------------ Add style--------------*/
$custom_styles = array();
$custom_style= '';
if ($page_title_bg_image_url != '') {
    $page_title_warp_class[] = 'page-title-wrap-bg';
    $custom_styles[] = 'background-image: url('. $page_title_bg_image_url .')';
}
if ( is_array($page_title_height) && ($page_title_height['height'] > 0)) {
    $custom_styles[] = 'height:'.$page_title_height['height'];
}
if ($custom_styles) {
    $custom_style = 'style="'. join(';',$custom_styles).'"';
}
/*------------ Parallax-------------*/
if (!empty($page_title_bg_image_url) && ($page_title_parallax == '1')) {
    wp_enqueue_script('stellar');
    $custom_style.= ' data-stellar-background-ratio="0.5"';
    $page_title_warp_class[] = 'page-title-parallax';
}
$section_page_title_class[] = $page_title_text_align;
/*------------ Add class--------------*/
$page_title_warp_class[] = 'yolo-page-title-wrap archive-title-height';
/*------------ Layout------------------*/
if (in_array($page_title_layout,array('container','container-fluid'))) {
    $section_page_title_class[] = $page_title_layout;
}
?>
<?php if ($show_page_title == 1) : ?>
    <div class="<?php echo join(' ',$section_page_title_class) ?>" <?php echo esc_attr($margin);?>>
        <?php if ($show_page_title == 1) : ?>
            <section class="<?php echo join(' ',$page_title_warp_class); ?>" <?php echo wp_kses_post($custom_style); ?>>
                <div class="yolo-page-title-overlay"></div>
                <div class="content-page-title">
                    <div class="container">
                        <div class="page-title-inner">
                            <div class="block-inner">
                                <h1><?php echo esc_html($page_title); ?></h1>
                                <?php if ($page_sub_title != '') : ?>
                                    <span class="page-sub-title"><?php echo esc_html($page_sub_title) ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php if($breadcrumbs_in_page_title == 1) : ?>
                            <div class="yolo-breadcrumb-wrap">
                                <?php yolo_the_breadcrumb(); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>
    </div>
<?php endif; ?>


