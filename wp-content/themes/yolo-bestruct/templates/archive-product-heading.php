<?php
/**
 *  
 * @package    YoloTheme
 * @version    1.0.0
 * @created    28/12/2015
 * @author     Administrator <admin@yolotheme.com>
 * @copyright  Copyright (c) 2015, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
*/
global $yolo_bestruct_options;
$prefix = 'yolo_';
$section_page_title_class = array('yolo-page-title-section archive-product-title-margin');
$inherit_archive_title = isset($yolo_bestruct_options['inherit_archive_product_title'])?$yolo_bestruct_options['inherit_archive_product_title']:1;
$page_title_bg_image_url = $page_title_height = $page_title_text_align = $page_title_layout = '';
$page_title_warp_class   = array();
if( 1 == $inherit_archive_title){
    $show_page_title = isset($yolo_bestruct_options['show_page_title'])? $yolo_bestruct_options['show_page_title'] :1;
    if( 1 == $show_page_title){
        $page_title_layout = isset($yolo_bestruct_options['page_title_layout']) ? $yolo_bestruct_options['page_title_layout'] : 'container-fluid';
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
            $page_title_bg_image_url = get_template_directory_uri() . '/assets/images/bg-page-title.png';
        }
        $breadcrumbs_in_page_title = isset($yolo_bestruct_options['breadcrumbs_in_page_title']) ? $yolo_bestruct_options['breadcrumbs_in_page_title'] : 1;
    }
}else{
    $show_page_title = isset($yolo_bestruct_options['show_archive_product_title']) ? $yolo_bestruct_options['show_archive_product_title'] : 1;
    if( 1 == $show_page_title){
        $page_title_layout = $yolo_bestruct_options['archive_product_title_layout'];
        $archive_title_margin = $yolo_bestruct_options['archive_product_title_margin'];
        if(is_array($archive_title_margin) && isset($archive_title_margin['margin-top'])){
            $page_title_margin_top = $archive_title_margin['margin-top'];
        }
        if(is_array($archive_title_margin) && isset($archive_title_margin['margin-bottom'])){
            $page_title_margin_bottom = $archive_title_margin['margin-bottom'];
        }
        $page_title_text_align = isset($yolo_bestruct_options['archive_product_title_style']) ? $yolo_bestruct_options['archive_product_title_style'] : 'page-title-style-1';
        $page_title_parallax = $yolo_bestruct_options['archive_product_title_parallax'];
        $page_title_height = $yolo_bestruct_options['archive_product_title_height'];
        $archive_title_bg_image = $yolo_bestruct_options['archive_product_title_bg_image'];
        if (isset($archive_title_bg_image) && $archive_title_bg_image['url'] != '') {
            $page_title_bg_image_url = $archive_title_bg_image['url'];
        }else{
            $page_title_bg_image_url = get_template_directory_uri() . '/assets/images/bg-page-title.png';
        }
        $breadcrumbs_in_page_title = isset($yolo_bestruct_options['breadcrumbs_in_archive_product_title']) ? $yolo_bestruct_options['breadcrumbs_in_archive_product_title'] : 1;
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
/*------------ Margin ---------------*/
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
$page_sub_title = strip_tags(term_description());
/*------------ Archive product title Margin --------------*/
$section_page_title_class[] = $page_title_text_align;
/*-----------Breadcrumbs----------------*/
$page_title_warp_class[] = 'yolo-page-title-wrap archive-product-title-height';
/*------------ Layout------------------*/
if (in_array($page_title_layout,array('container','container-fluid'))) {
    $section_page_title_class[] = $page_title_layout;
}
?>
<?php if ($show_page_title == 1) : ?>
    <div class="<?php echo join(' ',$section_page_title_class) ?>"  <?php echo esc_attr($margin);?>>
        <?php if ($show_page_title == 1) : ?>
            <section class="<?php echo join(' ',$page_title_warp_class); ?>" <?php echo wp_kses_post($custom_style); ?>>
                <div class="yolo-page-title-overlay"></div>
                <div class="content-page-title">
                    <div class="container">
                        <div class="page-title-inner">
                            <div class="block-inner">
                                <h1><?php woocommerce_page_title(); ?></h1>
                                <?php if ($page_sub_title != '') : ?>
                                    <span class="page-sub-title"><?php echo esc_html($page_sub_title) ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php if ($breadcrumbs_in_page_title == 1) : ?>
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


