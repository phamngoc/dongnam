<?php
/**
 * Portfolio post type
 *  
 * @package    YoloTheme/Yolo Bestruct
 * @version    1.0.0
 * @author     Administrator <yolotheme@vietbrain.com>
 * @copyright  Copyright (c) 2016, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
*/

if ( !defined('ABSPATH') ) die('-1');

include_once( plugin_dir_path(__FILE__) . 'metaboxes/spec.php' ); // Add new metabox

if ( ! class_exists( 'Yolo_Portfolio_Post_Type' ) ) {
    class Yolo_Portfolio_Post_Type {

        protected $prefix;

        public function __construct() {
            $this->prefix = 'yolo_portfolio';

            add_action('init', array($this,'yolo_portfolio'), 5); // Must hook register post type and taxonomies with hight piority go make get_term() working
            add_action('admin_init', array($this, 'yolo_register_meta_boxes'));

            if ( is_admin() ) {
                add_action( 'do_meta_boxes', array( $this, 'remove_plugin_metaboxes' ) );
                // Add custom columns reference: http://code.tutsplus.com/articles/add-a-custom-column-in-posts-and-custom-post-types-admin-screen--wp-24934
                add_filter( 'manage_yolo_portfolio_posts_columns', array( $this, 'add_columns' ) );
                add_action( 'manage_yolo_portfolio_posts_custom_column', array( $this, 'set_columns_value'), 10, 2);
            }
        }

        function remove_plugin_metaboxes() {
            remove_meta_box('mymetabox_revslider_0', 'yolo_portfolio', 'normal');
            remove_meta_box('handlediv', 'yolo_portfolio', 'normal');
            remove_meta_box('commentsdiv', 'yolo_portfolio', 'normal');
        }

        function yolo_portfolio() {
            $prefix = $this->prefix;

            $labels = array(
                'menu_name'          => esc_html__( 'Portfolio', 'yolo-bestruct' ),
                'singular_name'      => esc_html__( 'Single Portfolio', 'yolo-bestruct' ),
                'name'               => esc_html__( 'Portfolio', 'yolo-bestruct' ),
                'add_new'            => esc_html__( 'Add New', 'yolo-bestruct' ) ,
                'add_new_item'       => esc_html__( 'Add New Portfolio', 'yolo-bestruct' ) ,
                'edit_item'          => esc_html__( 'Edit Portfolio', 'yolo-bestruct' ) ,
                'new_item'           => esc_html__( 'Add New Portfolio', 'yolo-bestruct' ) ,
                'view_item'          => esc_html__( 'View Portfolio', 'yolo-bestruct' ) ,
                'search_items'       => esc_html__( 'Search Portfolio', 'yolo-bestruct' ) ,
                'not_found'          => esc_html__( 'No Portfolio items found', 'yolo-bestruct' ) ,
                'not_found_in_trash' => esc_html__( 'No Portfolio items found in trash', 'yolo-bestruct' ) ,
                'parent_item_colon'  => ''
            );

            $args = array(
                'labels'                => $labels,
                'description'           => esc_html__( 'Display portfolio', 'yolo-bestruct' ),
                'hierarchical'          => false,
                'public'                => true,
                'show_ui'               => true,
                'show_in_menu'          => true,
                'menu_icon'             => 'dashicons-screenoptions',
                'menu_position'         => 5,
                'show_in_admin_bar'     => true,
                'show_in_nav_menus'     => true,
                'can_export'            => true,
                'has_archive'           => true,
                'exclude_from_search'   => false,
                'publicly_queryable'    => true,
                'capability_type'       => 'post',
                'supports'              => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
                'rewrite'           => array(
                    'slug'          => 'portfolio',
                    'with_front'    => false
                ) ,
            );
            register_post_type( 'yolo_portfolio', $args );

            // Register a taxonomy for Project Categories.
            $category_labels = array(
                'name'                          => esc_html__( 'Portfolio Categories', 'yolo-bestruct' ) ,
                'singular_name'                 => esc_html__( 'Portfolio Category', 'yolo-bestruct' ) ,
                'menu_name'                     => esc_html__( 'Portfolio Categories', 'yolo-bestruct' ) ,
                'all_items'                     => esc_html__( 'All Portfolio Categories', 'yolo-bestruct' ) ,
                'edit_item'                     => esc_html__( 'Edit Portfolio Category', 'yolo-bestruct' ) ,
                'view_item'                     => esc_html__( 'View Portfolio Category', 'yolo-bestruct' ) ,
                'update_item'                   => esc_html__( 'Update Portfolio Category', 'yolo-bestruct' ) ,
                'add_new_item'                  => esc_html__( 'Add New Portfolio Category', 'yolo-bestruct' ) ,
                'new_item_name'                 => esc_html__( 'New Portfolio Category Name', 'yolo-bestruct' ) ,
                'parent_item'                   => esc_html__( 'Parent Portfolio Category', 'yolo-bestruct' ) ,
                'parent_item_colon'             => esc_html__( 'Parent Portfolio Category:', 'yolo-bestruct' ) ,
                'search_items'                  => esc_html__( 'Search Portfolio Categories', 'yolo-bestruct' ) ,
                'popular_items'                 => esc_html__( 'Popular Portfolio Categories', 'yolo-bestruct' ) ,
                'separate_items_with_commas'    => esc_html__( 'Separate Portfolio Categories with commas', 'yolo-bestruct' ) ,
                'add_or_remove_items'           => esc_html__( 'Add or remove Portfolio Categories', 'yolo-bestruct' ) ,
                'choose_from_most_used'         => esc_html__( 'Choose from the most used Portfolio Categories', 'yolo-bestruct' ) ,
                'not_found'                     => esc_html__( 'No Portfolio Categories found', 'yolo-bestruct' ) ,
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

            register_taxonomy('portfolio_category', array(
                'yolo_portfolio'
            ) , $category_args);

             // Register a taxonomy for Project Tags.
            $tag_labels = array(
                'name'              => esc_html__( 'Portfolio Tags', 'taxonomy general name', 'yolo-bestruct' ),
                'singular_name'     => esc_html__( 'Tag', 'taxonomy singular name', 'yolo-bestruct' ),
                'search_items'      => esc_html__( 'Search Types', 'yolo-bestruct' ),
                'all_items'         => esc_html__( 'All Tags', 'yolo-bestruct' ),
                'parent_item'       => esc_html__( 'Parent Tag', 'yolo-bestruct' ),
                'parent_item_colon' => esc_html__( 'Parent Tag:', 'yolo-bestruct' ),
                'edit_item'         => esc_html__( 'Edit Tags', 'yolo-bestruct' ),
                'update_item'       => esc_html__( 'Update Tag', 'yolo-bestruct' ),
                'add_new_item'      => esc_html__( 'Add New Portfolio Tag', 'yolo-bestruct' ),
                'new_item_name'     => esc_html__( 'New Tag Name', 'yolo-bestruct' ),
            );

            $tag_args = array(
                'labels'       => $tag_labels,
                'public'       => true,
                'hierarchical' => true,
                'show_ui'      => true,
                'query_var'    => true,
                'rewrite'      => array( 
                    'slug'       => 'portfolio-tag',
                    'with_front' => false
                ),
            );

            // Custom taxonomy for Project Tags
            register_taxonomy('portfolio_tag', array(
                'yolo_portfolio'
            ), $tag_args);
        }

        // Add columns to Team Members
        function add_columns($columns) {
            unset(
                $columns['cb'],
                $columns['post-format'],
                $columns['title'],
                $columns['date']
            );
            $cols = array_merge(array('cb' => ('')), $columns);
            $cols = array_merge($cols, array('title' => esc_html__( 'Title', 'yolo-bestruct' )));
            $cols = array_merge($cols, array('category' => esc_html__( 'Category', 'yolo-bestruct' )));
            $cols = array_merge($cols, array('media_type' => esc_html__( 'Media Type', 'yolo-bestruct' )));
            $cols = array_merge($cols, array('thumbnail' => esc_html__( 'Thumbnail', 'yolo-bestruct' )));
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
                case 'media_type': {
                    $media_type = get_post_meta($post_id, "{$prefix}_media_type", true);
                    switch( $media_type ) {
                        case 'image':
                            echo '<label for="post-format-image" class="post-format-icon post-format-image"></label>';
                            break; 
                        case 'video':
                            echo '<label for="post-format-video" class="post-format-icon post-format-video"></label>';
                            break;
                        case 'link':
                            echo '<label for="post-format-link" class="post-format-icon post-format-link"></label>';
                            break;
                        case 'gallery':
                            echo '<label for="post-format-gallery" class="post-format-icon post-format-gallery"></label>';
                            break;
                        default:

                            break;
                    }
                    break;
                }
                case 'thumbnail': {
                    echo get_the_post_thumbnail($post_id, 'thumbnail');
                    break;
                }
                case 'category': {
                    $terms = get_the_terms( $post_id, 'portfolio_category' ); 
                    foreach($terms as $term) {
                        echo $term->name;
                    }
                    break;
                }

            }
        }

        // Register metaboxies
        function yolo_register_meta_boxes() {
            $prefix = $this->prefix;

            $meta_boxes   = array();
            $meta_boxes[] = array(
                'id'          => "{$prefix}_meta_box_media_type",
                'title'       => esc_html__( 'Media Type', 'yolo-bestruct' ),
                'context'     => 'side',
                'post_types'  => array('yolo_portfolio'),
                'priority'    => 'high',
                'description' => esc_html__( 'Choose the media type for this Portfolio Item.', 'yolo-bestruct' ),
                'fields'      => array(
                    array(
                        'id'    => "{$prefix}_media_type",
                        'type'  => 'radio',
                        'std'   => 'image',
                        'class' => 'yolo-portfolio-post-type',
                        'options' => array(
                            'image'   => esc_html__( 'Image', 'yolo-bestruct' ),
                            'link'    => esc_html__( 'Link', 'yolo-bestruct' ),
                            'gallery' => esc_html__( 'Gallery', 'yolo-bestruct' ),
                            'video'   => esc_html__( 'Video', 'yolo-bestruct' ),
                        ),
                    ),
                    array(
                        'name'    => esc_html__( 'Thumbnail size', 'yolo-bestruct' ),
                        'id'      => "{$prefix}_thumbnail_size",
                        'type'    => 'select',
                        'class'   => 'yolo-portfolio-thumbnail-size',
                        'options' => array(
                            ''              => esc_html__( 'Default', 'yolo-bestruct' ),
                            'small_squared' => esc_html__( 'Small Squared', 'yolo-bestruct' ),
                            'big_squared'   => esc_html__( 'Big Squared', 'yolo-bestruct' ),
                            'landscape'     => esc_html__( 'Landscape', 'yolo-bestruct' ),
                            'portrait'      => esc_html__( 'Portrait', 'yolo-bestruct' ),
                        ),
                        'multiple' => false,
                        'std'      => '',
                    ),
                    array(
                        'name'    => esc_html__( 'View Detail Style', 'yolo-bestruct' ),
                        'id'      => 'portfolio_detail_style',
                        'type'    => 'select',
                        'class'   => 'yolo-portfolio-view-detail',
                        'options' => array(
                            'none'      => esc_html__( 'Inherit from theme options','yolo-bestruct' ),
                            'detail-01' => esc_html__( 'Fullwidth slide', 'yolo-bestruct' ),
                            'detail-02' => esc_html__( 'Vertical images', 'yolo-bestruct' ),
                            'detail-03' => esc_html__( 'Small slide', 'yolo-bestruct' ),
                            'detail-04' => esc_html__( 'Grid images 2 Columns', 'yolo-bestruct' ),
                            'detail-05' => esc_html__( 'Grid images 1 Columns', 'yolo-bestruct' )
                        ),
                        'multiple'    => false,
                        'std'         => 'none',
                    )
                ),
            );

            // PORTFOLIO FORMAT: Gallery
            //--------------------------------------------------
            $meta_boxes[] = array(
                'title'      => esc_html__( 'Post Format: Gallery', 'yolo-bestruct' ),
                'id'         => $prefix . 'meta_box_post_format_gallery',
                'post_types' => array('yolo_portfolio'),
                'fields'     => array(
                    array(
                        'name' => esc_html__('Images', 'yolo-bestruct'),
                        'id'   => $prefix . '_data_format_gallery',
                        'type' => 'image_advanced',
                        'desc' => esc_html__('Select images gallery for post','yolo-bestruct')
                    ),
                ),
            );

            // PORTFOLIO FORMAT: Video
            //--------------------------------------------------
            $meta_boxes[] = array(
                'title'      => esc_html__( 'Post Format: Video', 'yolo-bestruct' ),
                'id'         => $prefix . 'meta_box_post_format_video',
                'post_types' => array('yolo_portfolio'),
                'fields'     => array(
                    array(
                        'name' => esc_html__( 'Video URL or Embeded Code', 'yolo-bestruct' ),
                        'id'   => $prefix . '_data_format_video',
                        'type' => 'textarea',
                    ),
                ),
            );

            // PORTFOLIO FORMAT: Audio
            //--------------------------------------------------
            $meta_boxes[] = array(
                'title'      => esc_html__( 'Post Format: Audio', 'yolo-bestruct' ),
                'id'         => $prefix . 'meta_box_post_format_audio',
                'post_types' => array('yolo_portfolio'),
                'fields'     => array(
                    array(
                        'name' => esc_html__( 'Audio URL or Embeded Code', 'yolo-bestruct' ),
                        'id'   => $prefix . '_data_format_audio',
                        'type' => 'textarea',
                    ),
                ),
            );

            // PORTFOLIO FORMAT: QUOTE
            //--------------------------------------------------
            $meta_boxes[] = array(
                'title'      => esc_html__( 'Post Format: Quote', 'yolo-bestruct' ),
                'id'         => $prefix . 'meta_box_post_format_quote',
                'post_types' => array('yolo_portfolio'),
                'fields'     => array(
                    array(
                        'name' => esc_html__( 'Quote', 'yolo-bestruct' ),
                        'id'   => $prefix . '_data_format_quote',
                        'type' => 'textarea',
                    ),
                    array(
                        'name' => esc_html__( 'Author', 'yolo-bestruct' ),
                        'id'   => $prefix . '_data_format_quote_author',
                        'type' => 'text',
                    ),
                    array(
                        'name' => esc_html__( 'Author Url', 'yolo-bestruct' ),
                        'id'   => $prefix . '_data_format_quote_author_url',
                        'type' => 'url',
                    ),
                ),
            );
            // POST FORMAT: LINK
            //--------------------------------------------------
            $meta_boxes[] = array(
                'title'      => esc_html__( 'Post Format: Link', 'yolo-bestruct' ),
                'id'         => $prefix . 'meta_box_post_format_link',
                'post_types' => array('yolo_portfolio'),
                'fields'     => array(
                    array(
                        'name' => esc_html__( 'Url', 'yolo-bestruct' ),
                        'id'   => $prefix . '_data_format_link_url',
                        'type' => 'url',
                    ),
                    array(
                        'name' => esc_html__( 'Text', 'yolo-bestruct' ),
                        'id'   => $prefix . '_data_format_link_text',
                        'type' => 'text',
                    ),
                ),
            );

            // Use RW Metaboxies fields
            if ( class_exists('RW_Meta_Box') ) {
                foreach ($meta_boxes as $meta_box) {
                    new RW_Meta_Box($meta_box);
                }
            }
        }
    }

    new Yolo_Portfolio_Post_Type;
}

