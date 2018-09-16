<?php
/**
 * The template for the panel header area.
 * Override this template by specifying the path where it is stored (templates_path) in your Redux config.
 *
 * @author      Redux Framework
 * @package     ReduxFramework/Templates
 * @version:    3.5.4.18
 */

$tip_title = esc_html__('Developer Mode Enabled', 'yolo-bestruct');

if ($this->parent->dev_mode_forced) {
    $is_debug     = false;
    $is_localhost = false;

    $debug_bit = '';
    if (Redux_Helpers::isWpDebug()) {
        $is_debug  = true;
        $debug_bit = esc_html__('WP_DEBUG is enabled', 'yolo-bestruct');
    }

    $localhost_bit = '';
    if (Redux_Helpers::isLocalHost()) {
        $is_localhost  = true;
        $localhost_bit = esc_html__('you are working in a localhost environment', 'yolo-bestruct');
    }

    $conjunction_bit = '';
    if ($is_localhost && $is_debug) {
        $conjunction_bit = ' ' . esc_html__('and', 'yolo-bestruct') . ' ';
    }

    $tip_msg = esc_html__('This has been automatically enabled because', 'yolo-bestruct') . ' ' . $debug_bit . $conjunction_bit . $localhost_bit . '.';
} else {
    $tip_msg = esc_html__('If you are not a developer, your theme/plugin author shipped with developer mode enabled. Contact them directly to fix it.', 'yolo-bestruct');
}

?>
    <div id="redux-header">
        <?php if (!empty($this->parent->args['display_name'])) {?>
        <div class="display_header">
              <h2 class="top_logo"><?php echo esc_html__('BeStruct', 'yolo-bestruct') ?></h2>
            <div id="redux-sticky">
                <div id="info_bar">

                    <div class="redux-action_bar">
                        <span class="spinner"></span>
                        <?php if (false === $this->parent->args['hide_save']) {?>
                        <?php submit_button(esc_html__('Save Changes', 'yolo-bestruct'), 'primary', 'redux_save', false);?>
                        <?php }?>
                        <?php if (false === $this->parent->args['hide_reset']): ?>
                            <?php submit_button(esc_html__('Reset All', 'yolo-bestruct'), 'secondary reset_all_btn', $this->parent->args['opt_name'] . '[defaults]', false);?>
                        <?php endif;?>
                    </div>
                    <div class="redux-ajax-loading" alt="<?php esc_html_e('Working...', 'yolo-bestruct')?>">&nbsp;</div>
                    <div class="clear"></div>
                </div>

                <!-- Notification bar -->
                <div id="redux_notification_bar">
                    <?php $this->notification_bar();?>
                </div>


            </div>

            <?php if (!empty($this->parent->args['display_version'])) {?>
            <span><?php echo wp_kses_post($this->parent->args['display_version']); ?></span>
            <?php }?>

        </div>
        <?php }?>

        <div class="clear"></div>
    </div>