<?php
/**
 *  
 * @package    YoloTheme/Yolo Bestruct
 * @version    1.0.0
 * @author     Administrator <yolotheme@vietbrain.com>
 * @copyright  Copyright (c) 2016, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
*/

if (!defined('ABSPATH')) {
    exit;
}
if (!class_exists('yolo_acf_widget_fields')) {
    class yolo_acf_widget_fields {
        
        function __construct($widget, $value) {
            $this->widget = $widget;
            $this->id = $this->widget->settings['id'];
            $this->field = array_key_exists('fields', $this->widget->settings) ? $this->widget->settings['fields'] : '';
            $this->extra = array_key_exists('extra', $this->widget->settings) ? $this->widget->settings['extra'] : '';
            $this->value = $value;
            $this->enqueue();
        }

        public function render() {
            $data_section_wrap = uniqid();
            $fields = $this->field;
            $extras = $this->extra;
            $field_values = is_array($this->value) && array_key_exists('fields', $this->value) ? $this->value['fields'] : '';
            $extra_values = is_array($this->value) && array_key_exists('extra', $this->value) ? $this->value['extra'] : '';
            $x = 0;
            $plugin_path = untrailingslashit(plugin_dir_path(__FILE__));
            $is_edit_mode = (isset($field_values) && is_array($field_values) && count($field_values) > 0) || (isset($extra_values) && is_array($extra_values) && count($extra_values) > 0);
            if ($is_edit_mode) {
                include($plugin_path . '/templates/edit.php');
            } else {
                include($plugin_path . '/templates/new.php');
            }
        }

        public function enqueue() {
            global $yolo_bestruct_options;

            $min_suffix = (isset($yolo_bestruct_options['enable_minifile_js']) && $yolo_bestruct_options['enable_minifile_js'] == 1) ? '.min' : '';
            wp_enqueue_style('yolo-widget-rows-css', plugins_url() . '/yolo-bestruct-framework/includes/widgets/fields/assets/style.css', array(), false);
            wp_enqueue_script('yolo-widget-rows-js', plugins_url() . '/yolo-bestruct-framework/includes/widgets/fields/assets/main'.$min_suffix.'.js', false, true);
        }
    }
}