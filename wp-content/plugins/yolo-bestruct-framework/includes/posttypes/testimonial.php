<?php
/**
 * Testimonial post type
 *  
 * @package    YoloTheme/Yolo Bestruct
 * @version    1.0.0
 * @author     Administrator <yolotheme@vietbrain.com>
 * @copyright  Copyright (c) 2016, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
*/

if ( !class_exists( 'Yolo_Testimonial_Post_Type' ) ) {
    class Yolo_Testimonial_Post_Type {

        protected $prefix;

        public function __construct() {
            $this->prefix = 'yolo_testimonial';

            add_action('init', array($this,'yolo_testimonial'));
            add_action('admin_init', array($this, 'yolo_register_meta_boxes'));

            if( is_admin() ) {
                add_action( 'do_meta_boxes', array( $this, 'remove_plugin_metaboxes' ) );
                // Add custom columns reference: http://code.tutsplus.com/articles/add-a-custom-column-in-posts-and-custom-post-types-admin-screen--wp-24934
                add_filter( 'manage_yolo_testimonial_posts_columns', array( $this, 'add_columns' ) );
                add_action( 'manage_yolo_testimonial_posts_custom_column', array( $this, 'set_columns_value'), 10, 2);
            }
        }

        function remove_plugin_metaboxes() {
            remove_meta_box('mymetabox_revslider_0', 'yolo_testimonial', 'normal');
            remove_meta_box('handlediv', 'yolo_testimonial', 'normal');
            remove_meta_box('commentsdiv', 'yolo_testimonial', 'normal');
        }

        function yolo_testimonial() {
            $labels = array(
                'name'               => esc_html__( 'Testimonials', 'yolo-bestruct' ),
                'singular_name'      => esc_html__( 'Testimonial', 'yolo-bestruct' ),
                'menu_name'          => esc_html__( 'Testimonials', 'yolo-bestruct' ),
                'add_new'            => esc_html__( 'Add New', 'yolo-bestruct' ) ,
                'add_new_item'       => esc_html__( 'Add New Testimonial', 'yolo-bestruct' ) ,
                'edit_item'          => esc_html__( 'Edit Testimonial', 'yolo-bestruct' ) ,
                'new_item'           => esc_html__( 'Add New Testimonial', 'yolo-bestruct' ) ,
                'view_item'          => esc_html__( 'View Testimonial', 'yolo-bestruct' ) ,
                'search_items'       => esc_html__( 'Search Testimonial', 'yolo-bestruct' ) ,
                'not_found'          => esc_html__( 'No Testimonial items found', 'yolo-bestruct' ) ,
                'not_found_in_trash' => esc_html__( 'No Testimonial items found in trash', 'yolo-bestruct' ) ,
                'parent_item_colon'  => '',
                'rewrite'           => array(
                    'slug'          => 'testimonial',
                    'with_front'    => false
                ) ,
            );

            $args = array(
                'labels'                => $labels,
                'description'           => esc_html__( 'Display client\'s testimonials', 'yolo-bestruct' ),
                'supports'              => array( 'title', 'editor', 'thumbnail' ),
                'hierarchical'          => false,
                'public'                => true,
                'show_ui'               => true,
                'show_in_menu'          => true,
                'menu_icon'             => 'dashicons-id',
                'menu_position'         => 5,
                'show_in_admin_bar'     => true,
                'show_in_nav_menus'     => true,
                'can_export'            => true,
                'has_archive'           => true,
                'exclude_from_search'   => false,
                'publicly_queryable'    => true,
                'capability_type'       => 'post',
            );

            register_post_type( 'yolo_testimonial', $args );

            // Register a taxonomy for Testimonials Categories.
            $category_labels = array(
                'name'                          => esc_html__( 'Testimonial Categories', 'yolo-bestruct' ) ,
                'singular_name'                 => esc_html__( 'Testimonial Category', 'yolo-bestruct') ,
                'menu_name'                     => esc_html__( 'Testimonial Categories', 'yolo-bestruct' ) ,
                'all_items'                     => esc_html__( 'All Testimonial Categories', 'yolo-bestruct' ) ,
                'edit_item'                     => esc_html__( 'Edit Testimonial Category', 'yolo-bestruct' ) ,
                'view_item'                     => esc_html__( 'View Testimonial Category', 'yolo-bestruct' ) ,
                'update_item'                   => esc_html__( 'Update Testimonial Category', 'yolo-bestruct' ) ,
                'add_new_item'                  => esc_html__( 'Add New Testimonial Category', 'yolo-bestruct' ) ,
                'new_item_name'                 => esc_html__( 'New Testimonial Category Name', 'yolo-bestruct' ) ,
                'parent_item'                   => esc_html__( 'Parent Testimonial Category', 'yolo-bestruct' ) ,
                'parent_item_colon'             => esc_html__( 'Parent Testimonial Category:', 'yolo-bestruct' ) ,
                'search_items'                  => esc_html__( 'Search Testimonial Categories', 'yolo-bestruct' ) ,
                'popular_items'                 => esc_html__( 'Popular Testimonial Categories', 'yolo-bestruct') ,
                'separate_items_with_commas'    => esc_html__( 'Separate Testimonial Categories with commas', 'yolo-bestruct' ) ,
                'add_or_remove_items'           => esc_html__( 'Add or remove Testimonial Categories', 'yolo-bestruct' ) ,
                'choose_from_most_used'         => esc_html__( 'Choose from the most used Testimonial Categories', 'yolo-bestruct' ) ,
                'not_found'                     => esc_html__( 'No Testimonial Categories found', 'yolo-bestruct' ) ,
            );

            $category_args = array(
                'labels'            => $category_labels,
                'public'            => false,
                'show_ui'           => true,
                'show_in_nav_menus' => false,
                'show_tagcloud'     => false,
                'show_admin_column' => false,
                'hierarchical'      => true,
                'query_var'         => true,
                'rewrite'           => array(
                    'slug'          => 'category',
                    'with_front'    => false
                ) ,
            );

            register_taxonomy('testimonial_category', array(
                'yolo_testimonial'
            ) , $category_args);
        }

        // Add columns to Testimonial
        function add_columns($columns) {
            unset(
                $columns['cb'],
                $columns['title'],
                $columns['date']
            );
            $cols = array_merge(array('cb' => ('')), $columns);
            $cols = array_merge($cols, array('title' => esc_html__( 'Name', 'yolo-bestruct' )));
            $cols = array_merge($cols, array('email' => esc_html__( 'Email', 'yolo-bestruct' )));
            $cols = array_merge($cols, array('thumbnail' => esc_html__( 'Picture', 'yolo-bestruct' )));
            $cols = array_merge($cols, array('date' => esc_html__( 'Date', 'yolo-bestruct' )));

            return $cols;
        }

        // Set values for columns
        function set_columns_value($column, $post_id) {
            $prefix = $this->prefix;
            
            switch ($column) {
                case 'id': {
                    echo wp_kses_post($post_id);
                    break;
                }
                case 'email': {
                    echo get_post_meta($post_id, "{$prefix}_email", true);
                    break;
                }
                case 'thumbnail': {
                    echo get_the_post_thumbnail($post_id, 'thumbnail');
                    break;
                }
            }
        }

        // Register metaboxies
        function yolo_register_meta_boxes() {
            $prefix       = $this->prefix;

            $meta_boxes   = array();
            $meta_boxes[] = array(
                'id'            => "{$prefix}_meta_boxes",
                'title'         => esc_html__( 'Testimonial Information:', 'yolo-bestruct' ),
                'post_types'    => array( 'yolo_testimonial' ),
                'fields'        => array(
                    array(
                        'id'    => "{$prefix}_email",
                        'name'  => esc_html__( 'Email', 'yolo-bestruct' ),
                        'type'  => 'text',
                    ),
                    array(
                        'id'    => "{$prefix}_position",
                        'name'  => esc_html__( 'Position', 'yolo-bestruct' ),
                        'type'  => 'text',
                    ),
                    array(
                        'id'    => "{$prefix}_url",
                        'name'  => esc_html__( 'URL', 'yolo-bestruct' ),
                        'type'  => 'text',
                    ),
                    // array(
                    //     'id'    => "{$prefix}_special",
                    //     'name'  => esc_html__( 'Special', 'yolo-bestruct' ),
                    //     'type'  => 'text',
                    // ),
                    // array(
                    //     'id'      => "{$prefix}_rating",
                    //     'name'  => esc_html__( 'Rating', 'yolo-bestruct' ),
                    //     'type'    => 'select',
                    //     'options' => array(
                    //         '-1'  => esc_html__( 'no rating', 'yolo-bestruct' ),
                    //         '0'   => esc_html__( '0 star', 'yolo-bestruct' ),
                    //         '0.5' => esc_html__( '0.5 star', 'yolo-bestruct' ),
                    //         '1'   => esc_html__( '1 star', 'yolo-bestruct' ),
                    //         '1.5' => esc_html__( '1.5 stars', 'yolo-bestruct' ),
                    //         '2'   => esc_html__( '2 stars', 'yolo-bestruct' ),
                    //         '2.5' => esc_html__( '2.5 stars', 'yolo-bestruct' ),
                    //         '3'   => esc_html__( '3 stars', 'yolo-bestruct' ),
                    //         '3.5' => esc_html__( '3.5 stars', 'yolo-bestruct' ),
                    //         '4'   => esc_html__( '4 stars', 'yolo-bestruct' ),
                    //         '4.5' => esc_html__( '4.5 stars', 'yolo-bestruct' ),
                    //         '5'   => esc_html__( '5 stars', 'yolo-bestruct' ),
                    //     )
                    // ),
                    array(
                        'id'    => "{$prefix}_background",
                        'name'  => esc_html__( 'Background Image', 'yolo-bestruct' ),
                        'type'  => 'image_advanced',
                    ),
                )
            );
            
            // Use RW Metaboxies fields
            if ( class_exists('RW_Meta_Box') ) {
                foreach ($meta_boxes as $meta_box) {
                    new RW_Meta_Box($meta_box);
                }
            }
        }
    }

    new Yolo_Testimonial_Post_Type;
}