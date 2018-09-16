<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author      WooThemes
 * @package     WooCommerce/Templates
 * @version     3.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

global $woocommerce_loop,$yolo_woocommerce_loop;
global $yolo_bestruct_options;

/* Get style for shop page*/
$archive_product_style = isset($yolo_bestruct_options['archive_product_style']) ? $yolo_bestruct_options['archive_product_style'] : 'style_2';
$archive_product_display = isset($yolo_bestruct_options['archive_product_display']) ? $yolo_bestruct_options['archive_product_display'] :'fitRows';
$layout_style = isset($yolo_bestruct_options['archive_product_layout']) ? $yolo_bestruct_options['archive_product_layout'] : 'container';
$sidebar = $yolo_bestruct_options['archive_product_sidebar'];
$sidebar_width = $yolo_bestruct_options['archive_product_sidebar_width'];
$left_sidebar   = $yolo_bestruct_options['archive_product_left_sidebar'];
$right_sidebar  = $yolo_bestruct_options['archive_product_right_sidebar'];
$archive_display_columns = isset($yolo_bestruct_options['product_display_columns']) ? $yolo_bestruct_options['product_display_columns'] : '4';
$yolo_woocommerce_loop['columns'] = $archive_display_columns;
$product_rating = $yolo_bestruct_options['product_show_rating'];
$yolo_woocommerce_loop['rating'] = $product_rating;

$sidebar_col = 'col-md-3';
if ($sidebar_width == 'large') {
    $sidebar_col = 'col-md-4';
}
if ( $archive_product_style == 'style_1' ) {
    $sidebar_col = 'col-md-12';
}
$content_col_number = 12;
if ( $archive_product_style == 'style_2' ) {
    if (is_active_sidebar( $left_sidebar ) && (($sidebar == 'both') || ($sidebar == 'left'))) {
        if ($sidebar_width == 'large') {
            $content_col_number -= 4;
        }
        else {
            $content_col_number -= 3;
        }
    }
    if (is_active_sidebar( $right_sidebar ) && (($sidebar == 'both') || ($sidebar == 'right'))) {
        if ($sidebar_width == 'large') {
            $content_col_number -= 4;
        }
        else {
            $content_col_number -= 3;
        }
    }
}
$content_col = 'col-md-' . $content_col_number;
if (($content_col_number == 12) && ($layout_style == 'full')) {
    $content_col = '';
}
$archive_class = array('archive-product-wrap','clearfix');
$archive_class[] = 'layout-' . $layout_style;
$product_filter_class          = array();
$product_show_result_count     = isset($yolo_bestruct_options['product_show_result_count']) ? $yolo_bestruct_options['product_show_result_count'] : true;
$product_show_catalog_ordering = $yolo_bestruct_options['product_show_catalog_ordering'];
if (($product_show_result_count == false) && ($product_show_catalog_ordering == false) ) {
    $product_filter_class[] = 'catalog-filter-invisible';
} else {
    if ($product_show_result_count == false) {
        $product_filter_class[] = 'result-count-invisible';
    }
    if ($product_show_catalog_ordering == false) {
        $product_filter_class[] = 'catalog-ordering-invisible';
    }
}
$show_category = isset($yolo_bestruct_options['show_categories']) ? $yolo_bestruct_options['show_categories'] : true;
$show_search = isset($yolo_bestruct_options['show_search']) ? $yolo_bestruct_options['show_search'] : true;
$show_filters = isset($yolo_bestruct_options['show_filters']) ? $yolo_bestruct_options['show_filters'] :true;
if(isset($_REQUEST['shop_load']) && 'product' != $_REQUEST['shop_load']){
    wc_get_template( 'woocommerce/content-product-ajax.php');
}else {

get_header( 'shop' ); ?>
    <script type="text/javascript">
        var yolo_ajax_filter    = '<?php echo esc_js($yolo_bestruct_options['yolo_ajax_filter']);?>';
        /* When show all products*/
        var yolo_all_products   = '<?php echo esc_html__("All products loaded", "yolo-bestruct");?>';
        var yolo_style          = '<?php echo esc_js($yolo_bestruct_options["archive_product_style"]);?>';
    </script>
<?php
    wp_enqueue_script('isotope');
    wp_enqueue_script('yolo_shop_filters');
/**
 * @hooked - yolo_archive_product_heading - 5
 **/
do_action('yolo_before_archive_product');
?>
<main  class="site-content-archive-product" data-product-style = "<?php echo esc_attr($archive_product_display);?>">
    <?php
    /**
     * @hooked - yolo_shop_page_content - 5
     **/
    do_action('yolo_before_archive_product_listing');
    ?>
    <div class="content-archive-product">
    <?php if ($layout_style != 'full') : ?>
        <div class="<?php echo esc_attr($layout_style) ?> clearfix">
    <?php endif;?>

            <?php if (($content_col_number != 12) || ($layout_style != 'full')): ?>
                <div class="row clearfix">
            <?php endif;?>

                    <?php if (is_active_sidebar( $left_sidebar ) && $archive_product_style == 'style_2' && (($sidebar == 'left') || ($sidebar == 'both'))) : ?>
                        <div class="sidebar woocommerce-sidebar <?php echo esc_attr($sidebar_col) ?> sidebar-<?php echo esc_attr($sidebar_width); ?>">
                            <?php dynamic_sidebar( $left_sidebar ); ?>
                        </div>
                    <?php endif;?>
                    <div class="<?php echo esc_attr($content_col) ?> col-xs-12">
                        <?php if( $product_show_result_count == 1 || $product_show_catalog_ordering == 1 ) : ?>
                        <div class="<?php echo join(' ',$product_filter_class); ?> clearfix">

                            <?php
                            if ( $archive_product_style == 'style_1' ):
                                if ( $show_category == true ) {
                                    echo yolo_category_menu();
                                }
                            ?>
                            <ul class="yolo-filter-search">
                                <?php if ( $show_filters ):?>
                                    <li data-panel="filter" class="yolo-filter">
                                        <a href="#filter" class="invert-color"><?php esc_html_e( 'Filter', 'yolo-bestruct' ); ?></a>
                                    </li>
                                <?php endif;?>
                            <?php if ( $show_search ):?>
                                <li class="yolo-shop-search-btn-wrap yolo-search" data-panel="search">
                                    <?php if ($show_filters):?>
                                        <span>&frasl;</span>
                                    <?php endif;?>
                                    <a href="#search" id="yolo-shop-search-btn" class="invert-color"><?php esc_html_e( 'Search', 'yolo-bestruct' ); ?></a>
                                    <i class="yolo-font yolo-font-search-alt flip"></i>
                                </li>
                            <?php endif;?>
                            </ul>
                            <?php endif;?>
                            <?php
                            if ( $archive_product_style == 'style_2' && $product_show_result_count == true ) {
                                echo '<div class="catalog-filter clearfix">';
                                /**
                                 * woocommerce_before_shop_loop hook
                                 *
                                 * @hooked woocommerce_result_count - 20
                                 * @uooked woocommerce_catalog_ordering - 30
                                 */
                                do_action( 'yolo_before_shop_loop' );
                                echo '</div>';
                            }
                            ?>
                        </div>
                        <?php endif; ?>
                        <?php if ( $show_search && $archive_product_style == 'style_1'):?>
                        <div class="yolo-search-field">
                            <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/'));?>">
                                <input type="text" class="search-field" placeholder="<?php echo esc_html__( 'Search Products', 'yolo-bestruct' ); ?>" value="" name="s" title="Search for:">
                                <button type="submit"><i class="fa fa-search"></i></button>
                                <input type="hidden" name="post_type" value="product">
                            </form>
                            <div class = "search-message"></div>
                        </div>
                        <div class="clearfix"></div>
                        <?php endif;?>
                        <div class="<?php echo join(' ',$archive_class); ?>">
                            <?php if ( $archive_product_style == 'style_1' ):?>
                                <div class="sidebar woocommerce-sidebar yolo-ajax-filter <?php echo esc_attr($sidebar_col) ?> sidebar-<?php echo esc_attr($sidebar_width); ?>">
                                    <?php dynamic_sidebar( 'woocommerce_filter' ); ?>
                                </div>
                                <div class="clearfix"></div>
                            <?php wc_get_template_part( 'content', 'product_reset' );?>
                            <?php endif;?>

                            <?php if ( have_posts() ) : ?>
                                <?php
                                /**
                                 * woocommerce_before_shop_loop hook
                                 *
                                 * @hooked woocommerce_result_count - 20
                                 * @hooked woocommerce_catalog_ordering - 30
                                 */
                                do_action( 'woocommerce_before_shop_loop' );
                                ?>
                                <?php woocommerce_product_loop_start(); 
                                if ( wc_get_loop_prop( 'total' ) ) {
                                    while ( have_posts() ) {
                                        the_post();

                                        /**
                                         * Hook: woocommerce_shop_loop.
                                         *
                                         * @hooked WC_Structured_Data::generate_product_data() - 10
                                         */
                                        do_action( 'woocommerce_shop_loop' );

                                        wc_get_template_part( 'content', 'product' );
                                    }
                                }
                                woocommerce_product_loop_end(); ?>
                                <?php
                                /**
                                 * woocommerce_after_shop_loop hook
                                 *
                                 * @hooked woocommerce_pagination - 10
                                 */
                                do_action( 'woocommerce_after_shop_loop' );
                                ?>
                            <?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>
                                <?php wc_get_template( 'loop/no-products-found.php' ); ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if (is_active_sidebar( $right_sidebar ) && $archive_product_style == 'style_2' && (($sidebar == 'right') || ($sidebar == 'both'))) : ?>
                        <div class="sidebar woocommerce-sidebar <?php echo esc_attr($sidebar_col) ?> sidebar-<?php echo esc_attr($sidebar_width); ?>">
                            <?php dynamic_sidebar( $right_sidebar );?>
                        </div>
                    <?php endif;?>
            <?php if (($content_col_number != 12) || ($layout_style != 'full')) : ?>
                </div>
            <?php endif;?>

    <?php if ($layout_style != 'full') : ?>
        </div>
    <?php endif; ?>
    </div>
    <?php
        /**
         * @hooked - yolo_shop_page_content - 5
         **/
        do_action('yolo_after_archive_product_listing');
    ?>
</main>
<?php get_footer( 'shop' ); }?>
