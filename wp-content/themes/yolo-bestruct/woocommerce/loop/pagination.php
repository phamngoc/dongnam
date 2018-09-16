<?php
/**
 * Pagination - Show numbered pagination for catalog pages.
 *
 * @author        WooThemes
 * @package    WooCommerce/Templates
 * @version     3.3.1
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

global $wp_query;
global $yolo_bestruct_options;

$total   = isset( $total ) ? $total : wc_get_loop_prop( 'total_pages' );
$current = isset( $current ) ? $current : wc_get_loop_prop( 'current_page' );
$base    = isset( $base ) ? $base : esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) );
$format  = isset( $format ) ? $format : '';
if ( $total <= 1 ) {
	return;
}

$data_page = apply_filters('woocommerce_pagination_args', array(
	'base' => $base,
	'format' => $format,
	'add_args' => '',
	'current' => max( 1, $current ),
	'total' => $total,
	'prev_text' => '<i class="fa fa-angle-left"></i>',
	'next_text' => '<i class="fa fa-angle-right"></i>',
	'type' => 'array',
	'end_size' => 3,
	'mid_size' => 3
));
$page_links = paginate_links($data_page);

$load_more = str_replace( '%#%', 2, $data_page['base'] );
$archive_product_style = isset($yolo_bestruct_options['archive_product_style']) ? $yolo_bestruct_options['archive_product_style'] :'style_2';
if (count($page_links) == 0) return;
$links = "<ul class='pagination'>\n\t<li>";
$links .= join("</li>\n\t<li>", $page_links);
$links .= "</li>\n</ul>\n";
$load_more = isset($_POST['pagination']) ? isset($_POST['pagination']) : '';
if ( $load_more != 'load_more' ):

?>
<div class="woocommerce-pagination">
	<?php
	if ( $archive_product_style == 'style_2' || ( $archive_product_style == 'style_1' && !$yolo_bestruct_options['yolo_ajax_filter'] ) ) {
		echo wp_kses_post($links);
	} else {
		echo '<a class="yolo-shop-loadmore" href="' . $load_more . '" data-page="2" data-link="' . $data_page['base'] . '" data-totalpage="' . $data_page['total'] . '">'. esc_html__( 'Load more', 'yolo-bestruct' ) .'</a>';
	}

	?>

</div>
<?php endif;?>



