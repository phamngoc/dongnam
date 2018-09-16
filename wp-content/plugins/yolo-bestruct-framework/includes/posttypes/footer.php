<?php
/**
 * Footer post type
 *  
 * @package    YoloTheme/Yolo Bestruct
 * @version    1.0.0
 * @author     Administrator <yolotheme@vietbrain.com>
 * @copyright  Copyright (c) 2016, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
*/

if ( !class_exists( 'Yolo_Footer_Post_Type' ) ) {
    class Yolo_Footer_Post_Type {
        protected $prefix;

        public function __construct(){
            $this->prefix = 'yolo_footer';

            add_action('init', array($this, 'yolo_footer'));
        }
        function yolo_footer() {
            $labels = array(
                'menu_name'          => esc_html__( 'Footer Blocks', 'yolo-bestruct' ),
                'singular_name'      => esc_html__( 'Footer', 'yolo-bestruct' ),
                'name'               => esc_html__( 'All footer', 'yolo-bestruct' ),
                'add_new'            => esc_html__( 'Add New', 'yolo-bestruct' ) ,
                'add_new_item'       => esc_html__( 'Add New Footer', 'yolo-bestruct' ) ,
                'edit_item'          => esc_html__( 'Edit Footer', 'yolo-bestruct' ) ,
                'new_item'           => esc_html__( 'Add New Footer', 'yolo-bestruct' ) ,
                'view_item'          => esc_html__( 'View Footer', 'yolo-bestruct' ) ,
                'search_items'       => esc_html__( 'Search Footer', 'yolo-bestruct' ) ,
                'not_found'          => esc_html__( 'No Footer items found', 'yolo-bestruct' ) ,
                'not_found_in_trash' => esc_html__( 'No Footer items found in trash', 'yolo-bestruct' ) ,
                'parent_item_colon'  => ''
            );

            $args = array(
                'labels'                => $labels,
                'description'           => esc_html__( 'Display footer of site', 'yolo-bestruct' ),
                'supports'              => array( ),
                'hierarchical'          => false,
                'public'                => true,
                'show_ui'               => true,
                'show_in_menu'          => 'yolo-options',
                'menu_icon'             => 'dashicons-menu',
                'menu_position'         => 5,
                'show_in_admin_bar'     => true,
                'show_in_nav_menus'     => true,
                'can_export'            => true,
                'has_archive'           => true,
                'exclude_from_search'   => false,
                'publicly_queryable'    => true,
                'capability_type'       => 'page',
            );

            register_post_type( 'yolo_footer', $args );
        }
    }

    new Yolo_Footer_Post_Type;
}