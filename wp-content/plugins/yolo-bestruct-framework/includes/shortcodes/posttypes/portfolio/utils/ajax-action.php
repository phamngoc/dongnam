<?php
/**
 * Created by GDragon.
 * User: Administrator
 * Date: 6/1/2016
 * Time: 10:25 AM
 */

add_action("wp_ajax_nopriv_yoloframework_portfolio_load_more", "yoloframework_portfolio_load_more");
add_action("wp_ajax_yoloframework_portfolio_load_more", "yoloframework_portfolio_load_more");
function yoloframework_portfolio_load_more() {
    // var_dump($_REQUEST);die;
    $current_page        = $_REQUEST['current_page'];
    $overlay_style       = $_REQUEST['overlay_style'];
    $overlay_effect      = $_REQUEST['overlay_effect'];
    $hover_dir           = $_REQUEST['hover_dir'];
    $portfolio_title     = $_REQUEST['portfolio_title'];
    $offset              = $_REQUEST['offset'];
    $category            = $_REQUEST['category'];
    $portfolioIds        = $_REQUEST['portfolioIds'];
    $dataSource          = $_REQUEST['data_source'];
    $posts_per_page      = $_REQUEST['postsPerPage'];
    $portfolio_thumbnail = $_REQUEST['thumbnail'];
    $portfolio_tag       = $_REQUEST['tag'];
    $column              = $_REQUEST['columns'];
    $padding             = $_REQUEST['colPadding'];
    $order               = $_REQUEST['order'];
    $short_code          = sprintf('[yolo_portfolio portfolio_thumbnail="%s" portfolio_title="%s" portfolio_tag="%s" show_category="" column="%s" column_masonry="%s" item="%s" show_pagging="1" overlay_style="%s" overlay_effect="%s" padding="%s" current_page="%s" order="%s" data_source="%s" category="%s" portfolio_ids ="%s" item="%s"]',$portfolio_thumbnail, $portfolio_title, $portfolio_tag, $column, $column, $posts_per_page, $overlay_style, $overlay_effect, $padding, $current_page, $order, $dataSource, $category, $portfolioIds, $posts_per_page);
    echo do_shortcode($short_code);
    die();
}

// add_action("wp_ajax_nopriv_yolo_framework_portfolio_search", "yolo_framework_portfolio_search");
// add_action("wp_ajax_yolo_framework_portfolio_search", "yolo_framework_portfolio_search");

// function yolo_framework_portfolio_search(){

//     function yolo_framework_portfolio_search_title_filter( $where, &$wp_query ) {
//         global $wpdb;
//         if ( $keyword = $wp_query->get( 'search_prod_title' ) ) {
//             $where .= ' AND ((' . $wpdb->posts . '.post_title LIKE \'%' . $wpdb->esc_like($keyword ) . '%\'))';
//         }
//         return $where;
//     }
//     $keyword = $_REQUEST['keyword'];
//     if ( $keyword ) {
//         $search_query = array(
//             'search_prod_title' => $keyword,
//             'order'             => 'DESC',
//             'orderby'           => 'date',
//             'post_status'       => 'publish',
//             'post_type'         => array('yolo_portfolio'),
//             'nopaging'          => true,
//         );
//         add_filter( 'posts_where', 'yolo_framework_portfolio_search_title_filter', 10, 2 );
//         $search = new WP_Query( $search_query );
//         remove_filter( 'posts_where', 'yolo_framework_portfolio_search_title_filter', 10, 2 );

//         $new_data = array();
//         if ($search && isset($search->post) && count($search->post) > 0) {
//             foreach ( $search->posts as $post ) {
//                 $new_data[] = array(
//                     'id'        => $post->ID,
//                     'title'     => $post->post_title,
//                     'date'      => mysql2date( 'M d Y', $post->post_date )
//                 );
//             }
//         }
//         else {
//             $new_data[] = array(
//                 'id'        => -1,
//                 'title'     => esc_html__('Sorry, but nothing matched your search terms. Please try again with different keywords.','yolo-bestruct'),
//                 'date'      => null
//             );
//         }
//         wp_reset_postdata();
//         echo json_encode( $new_data );
//     }
//     die(); // this is required to return a proper result
// }
