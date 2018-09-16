<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;
if ( ! class_exists( 'ReduxFramework_color_alpha' ) ) :
class ReduxFramework_color_alpha {
    function __construct( $field = array(), $value = '', $parent ) {
        $this->parent = $parent;
        $this->field  = $field;
        $this->value  = $value;
        if ( is_array($value) ) {
            if ( isset($value['rgba']) ) {
                $this->value = $value['rgba'];
            } else {
                $this->value = '';
            }
        }
        if ( empty( $this->extension_dir ) ) {
            $this->extension_dir = trailingslashit( str_replace( '\\', '/', dirname( __FILE__ ) ) );
            $this->extension_url = site_url( str_replace( trailingslashit( str_replace( '\\', '/', ABSPATH ) ), '', $this->extension_dir ) );
        }
    }
    public function render() {
        $palette = 'true';
        if ( isset($this->field['palette']) ) {
            if ( is_array($this->field['palette']) ) {
                $palette = implode('|', $this->field['palette']);
            } else {
                $palette = (false === $this->field['palette'] || 'false' === $this->field['palette']) ? 'false' : 'true';
            }
        }
        echo sprintf('<input data-id="%s" name="%s" id="%s-color" class="alpha-color-control redux-color %s" type="text" value="%s" data-palette="%s" data-oldcolor="" data-default-color="%s" />',
            $this->field['id'],
            $this->field['name'].$this->field['name_suffix'],
            $this->field['id'],
            $this->field['class'],
            $this->value,
            $palette,
            ( isset( $this->field['default'] ) ? $this->field['default'] : "" ));
        echo '<input type="hidden" class="redux-saved-color" id="' . $this->field['id'] . '-saved-color' . '" value="">';

        if ( ! isset( $this->field['transparent'] ) || $this->field['transparent'] !== false ) {
            $tChecked = "";
            if ( $this->value == "transparent" ) {
                $tChecked = ' checked="checked"';
            }
            echo '<label for="' . $this->field['id'] . '-transparency" class="color-transparency-check"><input type="checkbox" class="checkbox color-transparency ' . $this->field['class'] . '" id="' . $this->field['id'] . '-transparency" data-id="' . $this->field['id'] . '-color" value="1"' . $tChecked . '> ' . esc_html__( 'Transparent', 'yolo-bestruct' ) . '</label>';
        }
    }
    public function enqueue() {
        if ($this->parent->args['dev_mode']) {
            wp_enqueue_style( 'redux-color-picker-css' );
        }
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_script(
            'redux-alpha-color-picker-js',
            $this->extension_url . 'alpha-color-picker.js',
            array('jquery', 'wp-color-picker'),
            null,
            true
        );
        wp_enqueue_style(
            'redux-alpha-color-picker-css',
            $this->extension_url . 'alpha-color-picker.css',
            array('wp-color-picker'),
            null
        );
        wp_enqueue_script(
            'redux-field-color-alpha-custom-js',
            $this->extension_url . 'field_color_alpha.js',
            array('jquery', 'wp-color-picker'),
            null,
            true
        );
    }
    public function output() {
        $style = '';
        if ( ! empty( $this->value ) ) {
            $mode = ( isset( $this->field['mode'] ) && ! empty( $this->field['mode'] ) ? $this->field['mode'] : 'color' );
            $style .= $mode . ':' . $this->value . ';';
            if ( ! empty( $this->field['output'] ) && is_array( $this->field['output'] ) ) {
                $css = Redux_Functions::parseCSS( $this->field['output'], $style, $this->value );
                $this->parent->outputCSS .= $css;
            }
            if ( ! empty( $this->field['compiler'] ) && is_array( $this->field['compiler'] ) ) {
                $css = Redux_Functions::parseCSS( $this->field['compiler'], $style, $this->value );
                $this->parent->compilerCSS .= $css;
            }
        }
    }
}
endif;