<?php
/**
 * WordPress Export Administration Screen
 *
 * @package WordPress
 * @subpackage Administration
 */

/** Load WordPress Bootstrap */
global $wpdb, $wp_locale;
require_once(get_home_path() . 'wp-admin/admin.php' );


if ( !current_user_can('export') )
	wp_die(__('Sorry, you are not allowed to export the content of this site.'));

/** Load WordPress export API */
require_once( ABSPATH . 'wp-admin/includes/export.php' );
$title = __('Export');

/**
 * Display JavaScript on the page.
 *
 * @since 3.5.0
 */
function export_add_js() {
?>
<script type="text/javascript">
	jQuery(document).ready(function($){
 		var form = $('#export-filters'),
 			filters = form.find('.export-filters');
 		filters.hide();
 		form.find('input:radio').change(function() {
			filters.slideUp('fast');
			switch ( $(this).val() ) {
				case 'attachment': $('#attachment-filters').slideDown(); break;
				
			}
 		});
	});
</script>
<?php
}
add_action( 'admin_head', 'export_add_js' );

get_current_screen()->add_help_tab( array(
	'id'      => 'overview',
	'title'   => __('Overview'),
	'content' => '<p>' . __('You can export a file of your site&#8217;s content in order to import it into another installation or platform. The export file will be an XML file format called WXR. Posts, pages, comments, custom fields, categories, and tags can be included. You can choose for the WXR file to include only certain posts or pages by setting the dropdown filters to limit the export by category, author, date range by month, or publishing status.') . '</p>' .
		'<p>' . __('Once generated, your WXR file can be imported by another WordPress site or by another blogging platform able to access this format.') . '</p>',
) );

get_current_screen()->set_help_sidebar(
	'<p><strong>' . __('For more information:') . '</strong></p>' .
	'<p>' . __('<a href="https://codex.wordpress.org/Tools_Export_Screen" target="_blank">Documentation on Export</a>') . '</p>' .
	'<p>' . __('<a href="https://wordpress.org/support/" target="_blank">Support Forums</a>') . '</p>'
);

// If the 'download' URL parameter is set, a WXR export file is baked and returned.
if ( isset( $_REQUEST['download'] ) ) {
	$args = array();
	if ( ! isset( $_GET['content'] ) || 'all' == $_GET['content'] ) {
		$args['content'] = 'all';
	} elseif ( 'posts' == $_GET['content'] ) {
		$args['content'] = 'post';

		if ( $_GET['cat'] )
			$args['category'] = (int) $_GET['cat'];

		if ( $_GET['post_author'] )
			$args['author'] = (int) $_GET['post_author'];

		if ( $_GET['post_start_date'] || $_GET['post_end_date'] ) {
			$args['start_date'] = $_GET['post_start_date'];
			$args['end_date'] = $_GET['post_end_date'];
		}

		if ( $_GET['post_status'] )
			$args['status'] = $_GET['post_status'];
	} elseif ( 'pages' == $_GET['content'] ) {
		$args['content'] = 'page';

		if ( $_GET['page_author'] )
			$args['author'] = (int) $_GET['page_author'];

		if ( $_GET['page_start_date'] || $_GET['page_end_date'] ) {
			$args['start_date'] = $_GET['page_start_date'];
			$args['end_date'] = $_GET['page_end_date'];
		}

		if ( $_GET['page_status'] )
			$args['status'] = $_GET['page_status'];
	} elseif ( 'attachment' == $_GET['content'] ) {
		$args['content'] = 'attachment';

		if ( $_GET['attachment_start_date'] || $_GET['attachment_end_date'] ) {
			$args['start_date'] = $_GET['attachment_start_date'];
			$args['end_date'] = $_GET['attachment_end_date'];
		}
	}
	else {
		$args['content'] = $_GET['content'];
	}

	/**
	 * Filters the export args.
	 *
	 * @since 3.5.0
	 *
	 * @param array $args The arguments to send to the exporter.
	 */
	$args = apply_filters( 'export_args', $args );
	export_wp( $args );
	die();
}

//require_once( ABSPATH . 'wp-admin/admin-header.php' );

/**
 * Create the date options fields for exporting a given post type.
 *
 * @global wpdb      $wpdb      WordPress database abstraction object.
 * @global WP_Locale $wp_locale Date and Time Locale object.
 *
 * @since 3.1.0
 *
 * @param string $post_type The post type. Default 'post'.
 */

?>

<div class="wrap">
<h1><?php echo esc_html( $title ); ?></h1>

<p><?php _e('When you click the button below WordPress will create an XML file for you to save to your computer.'); ?></p>
<p><?php _e('This format, which we call WordPress eXtended RSS or WXR, will contain your posts, pages, comments, custom fields, categories, and tags.'); ?></p>
<p><?php _e('Once you&#8217;ve saved the download file, you can use the Import function in another WordPress installation to import the content from this site.'); ?></p>

<form method="get" id="export-filters">
<fieldset>
<legend class="screen-reader-text"><?php _e( 'Content to export' ); ?></legend>
<input type="hidden" name="post_type" value="yolo_templater" />
<input type="hidden" name="page" value="export_attributes" />
<input type="hidden" name="download" value="true" />
<input type="hidden" name="content" value="yolo_templater" />


</fieldset>
<?php
/**
 * Fires at the end of the export filters form.
 *
 * @since 3.5.0
 */
do_action( 'export_filters' );
?>

<?php submit_button( __('Download Export Templater') ); ?>
</form>
</div>

<?php include( ABSPATH . 'wp-admin/admin-footer.php' ); ?>
