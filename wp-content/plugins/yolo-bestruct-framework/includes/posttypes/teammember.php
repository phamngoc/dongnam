<?php
/**
 * Team member post type
 *  
 * @package    YoloTheme/Yolo Bestruct
 * @version    1.0.0
 * @author     Administrator <yolotheme@vietbrain.com>
 * @copyright  Copyright (c) 2016, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
*/

if ( ! class_exists( 'Yolo_Teammember_Post_Type' ) ) {
    class Yolo_Teammember_Post_Type {

        protected $prefix;

        public function __construct() {
            $this->prefix = 'yolo_teammember';

            add_action('init', array($this,'yolo_teammember'));
            add_action('admin_init', array($this, 'yolo_register_meta_boxes'));

            if ( is_admin() ) {
                add_action( 'do_meta_boxes', array( $this, 'remove_plugin_metaboxes' ) );
                // Add custom columns reference: http://code.tutsplus.com/articles/add-a-custom-column-in-posts-and-custom-post-types-admin-screen--wp-24934
                add_filter( 'manage_yolo_teammember_posts_columns', array( $this, 'add_columns' ) );
                add_action( 'manage_yolo_teammember_posts_custom_column', array( $this, 'set_columns_value'), 10, 2);
            }
        }

        function remove_plugin_metaboxes() {
            remove_meta_box('mymetabox_revslider_0', 'yolo_teammember', 'normal');
            remove_meta_box('handlediv', 'yolo_teammember', 'normal');
            remove_meta_box('commentsdiv', 'yolo_teammember', 'normal');
        }

        function yolo_teammember() {
            $prefix = $this->prefix;

            $labels = array(
                'menu_name'          => esc_html__( 'Team members', 'yolo-bestruct' ),
                'singular_name'      => esc_html__( 'Team member', 'yolo-bestruct' ),
                'name'               => esc_html__( 'Team members', 'yolo-bestruct' ),
                'add_new'            => esc_html__( 'Add New', 'yolo-bestruct' ) ,
                'add_new_item'       => esc_html__( 'Add New Team Member', 'yolo-bestruct' ) ,
                'edit_item'          => esc_html__( 'Edit Team Member', 'yolo-bestruct' ) ,
                'new_item'           => esc_html__( 'Add New Team Member', 'yolo-bestruct' ) ,
                'view_item'          => esc_html__( 'View Team Member', 'yolo-bestruct' ) ,
                'search_items'       => esc_html__( 'Search Team Member', 'yolo-bestruct' ) ,
                'not_found'          => esc_html__( 'No Team Member items found', 'yolo-bestruct' ) ,
                'not_found_in_trash' => esc_html__( 'No Team Member items found in trash', 'yolo-bestruct' ) ,
                'parent_item_colon'  => ''
            );

            $args = array(
                'labels'                => $labels,
                'description'           => esc_html__( 'Display members of team work', 'yolo-bestruct' ),
                'hierarchical'          => false,
                'public'                => true,
                'show_ui'               => true,
                'show_in_menu'          => true,
                'menu_icon'             => 'dashicons-groups',
                'menu_position'         => 5,
                'show_in_admin_bar'     => true,
                'show_in_nav_menus'     => true,
                'can_export'            => true,
                'has_archive'           => true,
                'exclude_from_search'   => false,
                'publicly_queryable'    => true,
                'capability_type'       => 'post',
                'supports'              => array( 'title', 'thumbnail'),
                'rewrite'           => array(
                    'slug'          => 'teammember',
                    'with_front'    => false
                ) ,
            );
            register_post_type( 'yolo_teammember', $args );

            // Register a taxonomy for Project Categories.
            $category_labels = array(
                'name'                          => esc_html__( 'Team Categories', 'yolo-bestruct' ) ,
                'singular_name'                 => esc_html__( 'Team Category', 'yolo-bestruct' ) ,
                'menu_name'                     => esc_html__( 'Team Categories', 'yolo-bestruct' ) ,
                'all_items'                     => esc_html__( 'All Team Categories', 'yolo-bestruct' ) ,
                'edit_item'                     => esc_html__( 'Edit Team Category', 'yolo-bestruct' ) ,
                'view_item'                     => esc_html__( 'View Team Category', 'yolo-bestruct' ) ,
                'update_item'                   => esc_html__( 'Update Team Category', 'yolo-bestruct' ) ,
                'add_new_item'                  => esc_html__( 'Add New Team Category', 'yolo-bestruct' ) ,
                'new_item_name'                 => esc_html__( 'New Team Category Name', 'yolo-bestruct' ) ,
                'parent_item'                   => esc_html__( 'Parent Team Category', 'yolo-bestruct' ) ,
                'parent_item_colon'             => esc_html__( 'Parent Team Category:', 'yolo-bestruct' ) ,
                'search_items'                  => esc_html__( 'Search Team Categories', 'yolo-bestruct' ) ,
                'popular_items'                 => esc_html__( 'Popular Team Categories', 'yolo-bestruct' ) ,
                'separate_items_with_commas'    => esc_html__( 'Separate Team Categories with commas', 'yolo-bestruct' ) ,
                'add_or_remove_items'           => esc_html__( 'Add or remove Team Categories', 'yolo-bestruct') ,
                'choose_from_most_used'         => esc_html__( 'Choose from the most used Team Categories', 'yolo-bestruct' ) ,
                'not_found'                     => esc_html__( 'No Team Categories found', 'yolo-bestruct' ) ,
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

            register_taxonomy('team_category', array(
                'yolo_teammember'
            ) , $category_args);
        }

        // Add columns to Team Members
        function add_columns($columns) {
            unset(
                $columns['cb'],
                $columns['title'],
                $columns['date']
            );
            $cols = array_merge(array('cb' => ('')), $columns);
            $cols = array_merge($cols, array('title' => esc_html__( 'Name', 'yolo-bestruct' )));
            $cols = array_merge($cols, array('position' => esc_html__( 'Position', 'yolo-bestruct' )));
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
                case 'position': {
                    echo get_post_meta($post_id, "{$prefix}_position", true);
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
            $prefix = $this->prefix;

            $meta_boxes   = array();
            $meta_boxes[] = array(
                'id'            => "{$prefix}_meta_boxes",
                'title'         => esc_html__( 'Team Member Information:', 'yolo-bestruct' ),
                'post_types'    => array( 'yolo_teammember' ),
                'fields'        => array(
                    array(
                        'id'    => "{$prefix}_name",
                        'name'  => esc_html__( 'Name', 'yolo-bestruct' ),
                        'type'  => 'text',
                    ),
                    array(
                        'id'    => "{$prefix}_position",
                        'name'  => esc_html__( 'Position', 'yolo-bestruct' ),
                        'type'  => 'text',
                    ),
                    array(
                        'id'    => "{$prefix}_phone",
                        'name'  => esc_html__( 'Phone', 'yolo-bestruct' ),
                        'type'  => 'text',
                    ),
                    array(
                        'id'    => "{$prefix}_email",
                        'name'  => esc_html__( 'Email', 'yolo-bestruct' ),
                        'type'  => 'text',
                    ),
                    array(
                        'id'    => "{$prefix}_url",
                        'name'  => esc_html__( 'URL', 'yolo-bestruct' ),
                        'type'  => 'text',
                    ),
                    array(
                        'id'    => "{$prefix}_experience",
                        'name'  => esc_html__( 'Experience', 'yolo-bestruct' ),
                        'type'  => 'text',
                    ),

                )
            );
            // @TODO: can add custom field in rw metabox to add social
            $meta_boxes[] = array(
                'id'            => "{$prefix}_meta_box_team_social",
                'title'         => esc_html__( 'Social Profiles', 'yolo-bestruct' ),
                'post_types'    => array( 'yolo_teammember' ),
                'fields'        => array(
                    array(
                        'id'    => "{$prefix}_facebook",
                        'name'  => esc_html__( 'Facebook', 'yolo-bestruct' ),
                        'type'  => 'text',
                    ),
                    array(
                        'id'    => "{$prefix}_twitter",
                        'name'  => esc_html__( 'Twitter', 'yolo-bestruct' ),
                        'type'  => 'text',
                    ),
                    array(
                        'id'    => "{$prefix}_google",
                        'name'  => esc_html__( 'Google +', 'yolo-bestruct' ),
                        'type'  => 'text',
                    ),
                    array(
                        'id'    => "{$prefix}_instagram",
                        'name'  => esc_html__( 'Instagram', 'yolo-bestruct' ),
                        'type'  => 'text',
                    ),
                    array(
                        'id'    => "{$prefix}_linkedin",
                        'name'  => esc_html__( 'Linkedin', 'yolo-bestruct' ),
                        'type'  => 'text',
                    ),
                    array(
                        'id'    => "{$prefix}_flickr",
                        'name'  => esc_html__( 'Flickr', 'yolo-bestruct' ),
                        'type'  => 'text',
                    ),
                    array(
                        'id'    => "{$prefix}_pinterest",
                        'name'  => esc_html__( 'Pinterest', 'yolo-bestruct' ),
                        'type'  => 'text',
                    ),
                    
                    array(
                        'id'    => "{$prefix}_tumblr",
                        'name'  => esc_html__( 'Tumblr', 'yolo-bestruct' ),
                        'type'  => 'text',
                    )
                )
            );
            $meta_boxes[] = array(
                'id'            => "{$prefix}_meta_box_specialty",
                'title'         => esc_html__( 'Specialty', 'yolo-bestruct' ),
                'post_types'    => array( 'yolo_teammember' ),
                'fields'        => array(
                    array(
                        'id'        => "{$prefix}_sp_description",
                        'name'      => esc_html__( 'Description', 'yolo-bestruct' ),
                        'type'      => 'textarea',
                    ),
                )
            );
            $meta_boxes[] = array(
                'id'            => "{$prefix}_meta_box_certificates",
                'title'         => esc_html__( 'Certificates', 'yolo-bestruct' ),
                'post_types'    => array( 'yolo_teammember' ),
                'fields'        => array(
                    array(
                        'id'    => "{$prefix}_certificates_description",
                        'name'  => esc_html__( 'Description', 'yolo-bestruct' ),
                        'type'  => 'textarea',
                    )
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

    new Yolo_Teammember_Post_Type;
}

