<?php
/**
 *  
 * @package    YoloTheme
 * @version    1.0.0
 * @author     Administrator <admin@yolotheme.com>
 * @copyright  Copyright (c) 2016, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
 *
 */

/*---------------------------------------------------
/* SEARCH AJAX
/*---------------------------------------------------*/

if (!function_exists('yolo_result_search_callback')) {
    function yolo_result_search_callback() {
        ob_start();

        global $yolo_bestruct_options;
        $posts_per_page = 8;

        if (isset($yolo_bestruct_options['search_box_result_amount']) && !empty($yolo_bestruct_options['search_box_result_amount'])) {
            $posts_per_page = $yolo_bestruct_options['search_box_result_amount'];
        }

        $post_type = array();
        if (isset($yolo_bestruct_options['search_box_post_type']) && is_array($yolo_bestruct_options['search_box_post_type'])) {
            foreach($yolo_bestruct_options['search_box_post_type'] as $key => $value) {
                if ($value == 1) {
                    $post_type[] = $key;
                }
            }
        }

        $keyword = $_REQUEST['keyword'];

        if ( $keyword ) {
            $search_query = array(
                's'              => $keyword,
                'order'          => 'DESC',
                'orderby'        => 'date',
                'post_status'    => 'publish',
                'post_type'      => $post_type,
                'posts_per_page' => $posts_per_page + 1,
            );
            $search = new WP_Query( $search_query );

            $newdata = array();
            if ($search && count($search->post) > 0) {
                $count = 0;
                foreach ( $search->posts as $post ) {
                    if ($count == $posts_per_page) {
                        $newdata[] = array(
                            'id'        => -2,
                            'title'     => '<a href="' . site_url() .'?s=' . $keyword . '"><i class="wicon icon-outline-vector-icons-pack-94"></i> ' . esc_html__('View More','yolo-bestruct') . '</a>',
                            'guid'      => '',
                            'date'      => null,
                        );

                        break;
                    }
                    $newdata[] = array(
                        'id'        => $post->ID,
                        'title'     => $post->post_title,
                        'guid'      => get_permalink( $post->ID ),
                        'date'      => mysql2date( 'M d Y', $post->post_date ),
                    );
                    $count++;

                }
            }
            else {
                $newdata[] = array(
                    'id'        => -1,
                    'title'     => esc_html__( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'yolo-bestruct' ),
                    'guid'      => '',
                    'date'      => null,
                );
            }

            ob_end_clean();
            echo json_encode( $newdata );
        }
        die(); // this is required to return a proper result
    }
    add_action( 'wp_ajax_nopriv_result_search', 'yolo_result_search_callback' );
    add_action( 'wp_ajax_result_search', 'yolo_result_search_callback' );

}

if (!function_exists('yolo_result_search_product_callback')) {
	function yolo_result_search_product_callback() {
		ob_start();

		global $yolo_bestruct_options;
		$posts_per_page = 8;

		if (isset($yolo_bestruct_options['search_box_result_amount']) && !empty($yolo_bestruct_options['search_box_result_amount'])) {
			$posts_per_page = $yolo_bestruct_options['search_box_result_amount'];
		}

		$keyword = $_REQUEST['keyword'];
		$cate_id = isset($_REQUEST['cate_id']) ? $_REQUEST['cate_id'] : '-1';

		if ( $keyword ) {
			$search_query = array(
				's' => $keyword,
				'order'     	=> 'DESC',
				'orderby'   	=> 'date',
				'post_status'	=> 'publish',
				'post_type' 	=> array('product'),
				'posts_per_page'         => $posts_per_page + 1,
			);
			if (isset($cate_id) && ($cate_id != -1)) {
				$search_query ['tax_query'] = array(array(
                    'taxonomy'         => 'product_cat',
                    'terms'            => array($cate_id),
                    'include_children' => true,
				));
			}

			$search = new WP_Query( $search_query );

			$newdata = array();
			if ($search && count($search->post) > 0) {
				$count = 0;
				foreach ( $search->posts as $post ) {
					if ($count >= $posts_per_page) {

						$category = get_term_by('id', $cate_id, 'product_cat', 'ARRAY_A');
						$cate_slug = isset($category['slug']) ? '&amp;product_cate=' . $category['slug'] : '';
						$newdata[] = array(
							'id'        => -2,
							'title'     => '<a href="' . site_url() .'?s=' . $keyword . '&amp;post_type=product' . $cate_slug . '"><i class="wicon icon-outline-vector-icons-pack-94"></i> ' . esc_html__('View More','yolo-bestruct') . '</a>',
						);
						break;
					}
					$product = new WC_Product( $post->ID );
					$price = $product->get_price_html();

					$newdata[] = array(
						'id'        => $post->ID,
						'title'     => $post->post_title,
						'guid'      => get_permalink( $post->ID ),
						'thumb'		=> get_the_post_thumbnail( $post->ID, 'thumbnail' ),
						'price'		=> $price
					);
					$count++;

				}
			}
			else {
				$newdata[] = array(
					'id'        => -1,
					'title'     => esc_html__( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'yolo-bestruct'),
				);
			}

			ob_end_clean();
			echo json_encode( $newdata );
		}
		die(); // this is required to return a proper result
	}
	add_action( 'wp_ajax_nopriv_result_search_product', 'yolo_result_search_product_callback' );
	add_action( 'wp_ajax_result_search_product', 'yolo_result_search_product_callback' );
}
/*---------------------------------------------------
/* Product Quick View
/*---------------------------------------------------*/
if (!function_exists('yolo_product_quick_view_callback')) {
	function yolo_product_quick_view_callback() {
        $product_id = $_REQUEST['id'];
        global $post, $product, $woocommerce;
        $post       = get_post($product_id);
        setup_postdata($post);
        $product    = wc_get_product( $product_id );
        wc_get_template_part('content-product-quick-view');
        wp_reset_postdata();
		die();
	}
	add_action( 'wp_ajax_nopriv_product_quick_view', 'yolo_product_quick_view_callback' );
	add_action( 'wp_ajax_product_quick_view', 'yolo_product_quick_view_callback' );
}

/*
* Get products by category slug
*/
if ( !function_exists('yolo_get_data_by_category')) {
    function yolo_get_data_by_category(){
        $output = '';
        if ( isset($_POST) ) {
            $args = array(
                    'post_type'      => 'product',
                    'posts_per_page' => -1,
                    'post_status'    => 'publish',
                    'tax_query'      => array(
                    'relation'       => 'AND',
                    array(
                        'taxonomy'  => 'product_cat',
                        'field'     => 'slug',
                        'terms'     => $_POST['cat']
                    )
                ),
            );
            $the_query = new WP_Query( $args );
            while ( $the_query->have_posts() ) {
                $the_query->the_post();
                $output .= wc_get_template_part( 'content', 'product' );
            }
        }
        return $output;
    }
    add_action( 'wp_ajax_nopriv_yolo_get_data_by_category', 'yolo_get_data_by_category' );
    add_action( 'wp_ajax_yolo_get_data_by_category', 'yolo_get_data_by_category' );
}
/*---------------------------------------------------
/* Team member popup
/*---------------------------------------------------*/
/*---------------------------------------------------
/* Team member popup
/*---------------------------------------------------*/
add_action('wp_ajax_yolo_team_detail','yolo_team_detail');
add_action('wp_ajax_nopriv_yolo_team_detail','yolo_team_detail');
function yolo_team_detail(){
    ?>
    <div class="yolo-team-content clearfix">
        <button class="team-remove fa fa-close"></button>
        <?php
        $id = $_POST['id'];
        $args = array(
            'post_type'     =>  'yolo_teammember',
            'p'             =>  $id
            );
        $query = new WP_Query( $args );
        if( $query->have_posts() ):
            while( $query->have_posts() ):
                $query->the_post();
            $name        = get_post_meta(get_the_ID(),'yolo_teammember_name', true);
            $position    = get_post_meta(get_the_ID(),'yolo_teammember_position', true);

            $phone         = get_post_meta(get_the_ID(),'yolo_teammember_phone', true);
            $email         = get_post_meta(get_the_ID(),'yolo_teammember_email', true);
            $experience    = get_post_meta(get_the_ID(),'yolo_teammember_experience', true);

            $facebook    = get_post_meta(get_the_ID(),'yolo_teammember_facebook', true);
            $twitter     = get_post_meta(get_the_ID(),'yolo_teammember_twitter', true);
            $youtube     = get_post_meta(get_the_ID(),'yolo_teammember_youtube', true);
            $google      = get_post_meta(get_the_ID(),'yolo_teammember_google', true);
            $linkedin    = get_post_meta(get_the_ID(),'yolo_teammember_linkedin', true);
            $flickr      = get_post_meta(get_the_ID(),'yolo_teammember_flickr', true);
            $pinterest   = get_post_meta(get_the_ID(),'yolo_teammember_pinterest', true);
            $instagram   = get_post_meta(get_the_ID(),'yolo_teammember_instagram', true);
            $tumblr      = get_post_meta(get_the_ID(),'yolo_teammember_tumblr', true);
            $sp_description    = get_post_meta(get_the_ID(),'yolo_teammember_sp_description', true);
            $certificates      = get_post_meta(get_the_ID(),'yolo_teammember_certificates_description', true);

            ?>
            <div class="team-left">
                <?php if( has_post_thumbnail() ):?>
                    <div class="yolo-team-image">
                        <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full');?>
                            <img src = "<?php echo esc_url($image['0']);?>" atl = "<?php the_title();?>">
                    </div>
                <?php endif; ?>
                <div class="yolo-team-info">
                    
                    <?php if($name):?>
                        <h4 class="team_name"><?php echo esc_html($name); ?></h4>
                    <?php endif;?>
                    <?php if($position):?>
                        <span class="team_position"><?php echo esc_html($position); ?></span>
                    <?php endif;?>
                </div>
            </div>
            <div class="team-right">
                <div class="team-contact">
                    <h6 class="team-title"><?php echo esc_html__('Contact','yolo-bestruct'); ?></h6>
                    <ul>
                        <?php if($phone):?>
                            <li>
                                <i class="fa fa-phone"></i>
                                <span class="team-phone"><?php echo esc_html($phone); ?></span>
                            </li>
                        <?php endif;?>
                        <?php if($email):?>
                            <li>
                                <i class="fa fa-envelope"></i>
                                <a class="team-email"><?php echo esc_html($email); ?></a>
                            </li>
                        <?php endif;?>
                        <?php if($experience):?>
                            <li>
                                <i class="fa fa-suitcase"></i>
                                <?php echo esc_html($experience); ?>
                            </li>
                        <?php endif;?>
                    </ul>
                    <div class="team_socials">
                        <?php if( isset($twitter) && $twitter !='' ): ?>
                            <a href="<?php echo esc_url($twitter) ?>" class="fa fa-twitter"></a>
                        <?php endif; ?>
                        <?php if( isset($facebook) && $facebook !='' ): ?>
                            <a href="<?php echo esc_url($facebook) ?>" class="fa fa-facebook"></a>
                        <?php endif; ?>
                        <?php if( isset($youtube) && $youtube !='' ): ?>
                            <a href="<?php echo esc_url($youtube) ?>" class="fa fa-youtube"></a>
                        <?php endif; ?>
                        <?php if( isset($linkedin) && $linkedin !='' ): ?>
                            <a href="<?php echo esc_url($linkedin) ?>" class="fa fa-linkedin"></a>
                        <?php endif; ?>
                        <?php if( isset($flickr) && $flickr !='' ): ?>
                            <a href="<?php echo esc_url($flickr) ?>" class="fa fa-flickr"></a>
                        <?php endif; ?>
                        <?php if( isset($pinterest) && $pinterest !='' ): ?>
                            <a href="<?php echo esc_url($pinterest) ?>" class="fa fa-pinterest"></a>
                        <?php endif; ?>
                        <?php if( isset($instagram) && $instagram !='' ): ?>
                            <a href="<?php echo esc_url($instagram) ?>" class="fa fa-instagram"></a>
                        <?php endif; ?>
                        <?php if( isset($tumblr) && $tumblr !='' ): ?>
                            <a href="<?php echo esc_url($tumblr) ?>" class="fa fa-tumblr"></a>
                        <?php endif; ?>
                         <?php if( isset($google) && $google !='' ): ?>
                            <a href="<?php echo esc_url($google) ?>" class="fa fa-google-plus"></a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php if($sp_description):?>    
                <div class="team-specialty">
                    <h6 class="team-title"><?php echo esc_html__('Specialty','yolo-bestruct'); ?></h6>
                    <p>
                        <?php echo esc_html($sp_description); ?>
                    </p>
                </div>
            <?php endif;?>
            <?php if($certificates):?>
                <div class="team-certificates">
                    <h6 class="team-title"><?php echo esc_html__('Certificates','yolo-bestruct'); ?></h6>
                    <p>
                        <?php echo esc_html($certificates); ?>
                    </p>
                </div>
            <?php endif;?>
        </div>
        <?php
        endwhile;
        endif;
        wp_reset_postdata();
        ?>
    </div>
    <?php
    exit();
}
