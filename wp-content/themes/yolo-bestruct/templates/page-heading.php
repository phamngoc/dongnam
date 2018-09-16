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
global $yolo_bestruct_options;
global $post;
$prefix                         = 'yolo_';
$show_page_title                = get_post_meta(get_the_ID(), $prefix . 'show_page_title', true);
$inherit_single_product_title   = isset($yolo_bestruct_options['inherit_single_product_title']) ? $yolo_bestruct_options['inherit_single_product_title'] : 0;
$inherit_single_portfolio_title = isset($yolo_bestruct_options['inherit_single_portfolio_title']) ? $yolo_bestruct_options['inherit_single_portfolio_title'] : 1;
$inherit_single_blog_title      = isset($yolo_bestruct_options['inherit_single_blog_title']) ? $yolo_bestruct_options['inherit_single_blog_title'] : 0;

/*-----Show page title-------*/
if ($show_page_title == '0') {
    return;
}

if (($show_page_title == -1) || ($show_page_title == '')) {
    $show_page_title = $yolo_bestruct_options['show_page_title'];

    if (is_singular('product')) {
        if ($inherit_single_product_title != 1) {
            $show_page_title = $yolo_bestruct_options['show_single_product_title'];
        }
    } elseif (is_singular('yolo_portfolio')) {
        if ($inherit_single_portfolio_title != 1) {
            $show_page_title = $yolo_bestruct_options['show_portfolio_title'];
        }
    } elseif (is_singular('post')) {
        if ($inherit_single_blog_title != 1) {
            $show_page_title = $yolo_bestruct_options['show_single_blog_title'];
        }
    }

    if ($show_page_title == '') {
        $show_page_title = 1;
    }
}

/*----- Custom Page Title-------*/

$page_title = get_the_title();
if (is_singular('post')) {
    if ($inherit_single_blog_title != 1) {
        $page_title = isset($yolo_bestruct_options['custom_single_blog_title']) && !empty($yolo_bestruct_options['custom_single_blog_title']) ? $yolo_bestruct_options['custom_single_blog_title'] : get_the_title();
    }
}
if (is_singular('product')) {
    if ($inherit_single_product_title != 1) {
        $page_title = isset($yolo_bestruct_options['custom_single_product_title']) && !empty($yolo_bestruct_options['custom_single_product_title']) ? $yolo_bestruct_options['custom_single_product_title'] : get_the_title();
    }
}


if (is_404()) {
    $page_title = $yolo_bestruct_options['page_title_404'];
}

$page_sub_title = get_post_meta(get_the_ID(), $prefix . 'page_subtitle_custom', true);

if (is_404()) {
    $page_sub_title = $yolo_bestruct_options['sub_page_title_404'];
}
/*-----Custom page title bg image-------*/
$enable_custom_page_title_bg_image = get_post_meta(get_the_ID(), $prefix . 'enable_custom_page_title_bg_image', true);
$page_title_bg_image_url           = '';

if ($enable_custom_page_title_bg_image == 1) {
    $page_title_bg_image = get_post_meta(get_the_ID(), $prefix . 'page_title_bg_image', true);

    if ($page_title_bg_image) {
        $page_title_bg_image     = wp_get_attachment_url($page_title_bg_image);
        $page_title_bg_image_url = $page_title_bg_image;
    }
} else {
    $page_title_bg_image = $yolo_bestruct_options['page_title_bg_image'];

    if (is_singular('product')) {
        if ($inherit_single_product_title != 1) {
            $page_title_bg_image = $yolo_bestruct_options['single_product_title_bg_image'];
        }
    } elseif (is_singular('yolo_portfolio')) {
        if ($inherit_single_portfolio_title != 1) {
            $page_title_bg_image = $yolo_bestruct_options['portfolio_title_bg_image'];
        }
    } elseif (is_singular('post')) {
        if ($inherit_single_blog_title != 1) {
            $page_title_bg_image = $yolo_bestruct_options['single_blog_title_bg_image'];
        }
    }

    if (is_404()) {
        $page_title_bg_image = $yolo_bestruct_options['page_404_bg_image'];
    }

    if (isset($page_title_bg_image) && $page_title_bg_image['url'] != '') {
        $page_title_bg_image_url = $page_title_bg_image['url'];
    } else {
        $page_title_bg_image_url = get_template_directory_uri() . '/assets/images/bg-page-title.png';
    }
}
/* ------Breadcrumbs-----*/
$breadcrumbs_in_page_title = get_post_meta(get_the_ID(), $prefix . 'breadcrumbs_in_page_title', true);

if (($breadcrumbs_in_page_title == -1) || ($breadcrumbs_in_page_title == '')) {
    $breadcrumbs_in_page_title = isset($yolo_bestruct_options['breadcrumbs_in_page_title']) ? $yolo_bestruct_options['breadcrumbs_in_page_title'] : 1;
    if (is_singular('product')) {
        if ($inherit_single_product_title != 1) {
            $breadcrumbs_in_page_title = $yolo_bestruct_options['breadcrumbs_in_single_product_title'];
        }
    } elseif (is_singular('yolo_portfolio')) {
        if ($inherit_single_portfolio_title != 1) {
            $breadcrumbs_in_page_title = $yolo_bestruct_options['breadcrumbs_in_portfolio_title'];
        }
    }
}

if (is_404()) {
    $breadcrumbs_in_page_title = 0;
}
/*---------- Add class and css attribute default----------*/
$page_title_warp_class    = array('yolo-page-title-wrap');
$section_page_title_class = array('yolo-page-title-section');

$breadcrumb_class = array('yolo-breadcrumb-wrap s-color');
/*------- Add css Custom <section> -----------*/
$custom_styles = array();
$custom_style  = '';
/*----- Page title height-------*/
$page_title_height = get_post_meta(get_the_ID(), $prefix . 'page_title_height', true);

if (empty($page_title_height)) {
    $page_title_height = $yolo_bestruct_options['page_title_height'];

    if (is_singular('post')) {
        if ($inherit_single_blog_title != 1) {
            $page_title_height = $yolo_bestruct_options['single_blog_title_height'];
        }
    }
    if (is_singular('product')) {
        if ($inherit_single_product_title != 1) {
            $page_title_height = $yolo_bestruct_options['single_product_title_height'];
        }
    }
    if (is_singular('yolo_portfolio')) {
        if ($inherit_single_portfolio_title != 1) {
            $page_title_height = $yolo_bestruct_options['portfolio_title_height'];
        }
    }
    $custom_styles[] = 'height:' . $page_title_height . 'px';
}

if ($page_title_bg_image_url != '') {
    $page_title_warp_class[] = 'page-title-wrap-bg';
    $custom_styles[]         = 'background-image: url(' . $page_title_bg_image_url . ')';
}

if ($custom_styles) {
    $custom_style = 'style="' . join(';', $custom_styles) . '"';
}

/*-------- Page title Paralax--------*/
$page_title_parallax = get_post_meta(get_the_ID(), $prefix . 'page_title_parallax', true);

if (!isset($page_title_parallax) || ($page_title_parallax == '') || ($page_title_parallax == '-1')) {
    $page_title_parallax = $yolo_bestruct_options['page_title_parallax'];

    if (is_singular('product')) {
        if ($inherit_single_product_title != 1) {
            $page_title_parallax = $yolo_bestruct_options['single_product_title_parallax'];
        }
    } elseif (is_singular('yolo_portfolio')) {
        if ($inherit_single_portfolio_title != 1) {
            $page_title_parallax = $yolo_bestruct_options['portfolio_title_parallax'];
        }
    } elseif (is_singular('post')) {
        if ($inherit_single_blog_title != 1) {
            $page_title_parallax = $yolo_bestruct_options['single_blog_title_parallax'];
        }
    }
}

if (!empty($page_title_bg_image_url) && ($page_title_parallax == 1)) {
    wp_enqueue_script('stellar');
    $custom_style .= ' data-stellar-background-ratio="0.5"';
    $page_title_warp_class[] = 'page-title-parallax';
}
/*---------------Page title style--------------*/
$page_title_style = isset($yolo_bestruct_options['page_title_style']) ? $yolo_bestruct_options['page_title_style'] : 'page-title-style-1';
/*------- Page title layout--------*/

$page_title_layout = isset($yolo_bestruct_options['page_title_layout']) ? $yolo_bestruct_options['page_title_layout'] : 'container-fluid';

if (in_array($page_title_layout, array('container', 'container-fluid'))) {
    $section_page_title_class[] = $page_title_layout;
}
?>
<?php if ($show_page_title == 1) : ?>
    <div class="<?php echo join(' ',$section_page_title_class) ?> <?php echo esc_attr($page_title_style);?>">
    <?php if ($show_page_title == 1) : ?>
        <section  class="<?php echo join(' ', $page_title_warp_class); ?>" <?php echo wp_kses_post($custom_style); ?>>
            <div class="yolo-page-title-overlay"></div>
            <div class="content-page-title">
                <div class="container">
                    <div class="page-title-inner block-center">
                        <div class="block-inner">
                            <h1><?php echo esc_html($page_title); ?></h1>
                            <?php if ($page_sub_title != '') : ?>
                                <span class="page-sub-title"><?php echo esc_html($page_sub_title) ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php if ($breadcrumbs_in_page_title == 1) : ?>
                        <div class="<?php echo join(' ',$breadcrumb_class) ?>">
                            <?php yolo_the_breadcrumb(); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>
    </div>
<?php endif; ?>
