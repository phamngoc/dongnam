<?php
/**
 *  
 * @package    YoloTheme
 * @version    1.0.0
 * @created    25/12/2015
 * @author     Administrator <admin@yolotheme.com>
 * @copyright  Copyright (c) 2015, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
*/

// @TODO: Do not check it
global $yolo_bestruct_options;

?>
<?php if (isset($yolo_bestruct_options['search_box_type']) && ($yolo_bestruct_options['search_box_type'] == 'ajax')) : ?>
	<div id="yolo-modal-search" tabindex="-1" role="dialog" aria-hidden="false" class="modal fade">
		<div class="modal-backdrop fade in"></div>
		<div class="yolo-modal-dialog yolo-modal-search fade in">
			<div data-dismiss="modal" class="yolo-dismiss-modal"><i class="wicon fa fa-close"></i></div>
			<div class = "yolo-search-result">
				<div class="yolo-search-wrapper">
					<input id="search-ajax" type="search" placeholder="<?php echo esc_html__( 'Enter keyword to search', 'yolo-bestruct' ) ?>">
					<button><i class="ajax-search-icon fa fa-search"></i></button>
				</div>
				<div class="ajax-search-result"></div>
			</div>
		</div>
	</div>
<?php else: ?>
	<div id="yolo_search_popup_wrapper" class="dialog animated">
		<div class="dialog__overlay"></div>
		<div class="dialog__content">
			<div class="dialog-inner">
				<form  method="get" action="<?php echo esc_url(site_url()); ?>" class="search-popup-inner">
					<input type="text" name="s" placeholder="<?php esc_html_e( 'Search...', 'yolo-bestruct' ); ?>">
					<button type="submit"><i class="fa fa-search"></i><?php //esc_html_e( 'Search', 'yolo-bestruct' ); ?></button>
				</form>
				<div><button class="action" data-dialog-close="close" type="button"><i class="fa fa-close"></i></button></div>
			</div>
		</div>
	</div>
<?php endif; ?>