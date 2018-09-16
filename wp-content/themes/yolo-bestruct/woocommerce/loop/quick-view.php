<?php
/**
 * Created by GDragon.
 * User: Administrator
 * Date: 28/12/2015
 * Time: 10:35 AM
 */
global $yolo_bestruct_options;
$product_quick_view = $yolo_bestruct_options['product_quick_view'];
if ($product_quick_view == 0) {
    return;
}
wp_enqueue_style('owl-carousel');
wp_enqueue_script('owl-carousel');
?>
<a data-toggle="" data-placement="top" title="<?php esc_html_e( 'Quick view', 'yolo-bestruct' ) ?>" class="product-quick-view" data-product_id="<?php the_ID(); ?>" href="<?php the_permalink(); ?>"><i class="fa fa-search"></i><?php esc_html_e( 'Quick view', 'yolo-bestruct' ) ?></a>