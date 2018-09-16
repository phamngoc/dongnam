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

global $yolo_bestruct_options;

$time_id = uniqid();

date_default_timezone_set($yolo_bestruct_options['timezone']);
$current_time = date('Y/m/d H:i:s');
$online_time  = $yolo_bestruct_options['online_time'];

$time_to_reload         = strtotime($online_time) - strtotime($current_time);
$maintenance_background = $yolo_bestruct_options['maintenance_background'];

?>
<!DOCTYPE html>
<!-- Open HTML -->
<html <?php language_attributes(); ?>>
	<!-- Open Head -->
	<head>
		<?php 
		wp_head();
		?>
		<?php
		if (version_compare($wp_version, '4.1', '<')) : ?>
			<title><?php wp_title('|', true, 'right'); ?></title>
		<?php endif; ?>
		<meta charset="<?php bloginfo( 'charset' ); ?>"/>
		<?php
		$viewport_content = apply_filters('yolo_viewport_content','width=device-width, initial-scale=1, maximum-scale=1');
		?>
		<meta name="viewport" content="<?php echo esc_attr($viewport_content);?>">
		<?php if ( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ) : ?>
		    <?php if (isset($yolo_bestruct_options['custom_favicon']['url']) && !empty($yolo_bestruct_options['custom_favicon']['url'])) :?>
		        <link rel="shortcut icon" href="<?php echo esc_url($yolo_bestruct_options['custom_favicon']['url']); ?>" />
		    <?php else: ?>
		        <link rel="shortcut icon" href="<?php echo esc_url( get_template_directory_uri() . '/assets/images/favicon.ico' ); ?>" />
		    <?php endif;?>
		<?php endif; ?>

		<link href="<?php echo get_template_directory_uri() . '/style.css'; ?>" rel="stylesheet" type="text/css" />
		<link href="<?php echo get_template_directory_uri(). '/assets/plugins/fonts-awesome/css/font-awesome.min.css'; ?>" rel="stylesheet" type="text/css" />
		<!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script> -->
		<script src="<?php echo plugins_url(). '/yolo-bestruct-framework/includes/shortcodes/countdown/assets/js/redcountdown/jquery.knob.min.js'; ?>"></script>
		<script src="<?php echo plugins_url(). '/yolo-bestruct-framework/includes/shortcodes/countdown/assets/js/redcountdown/jquery.ba-throttle-debounce.min.js'; ?>"></script>
		<script src="<?php echo plugins_url(). '/yolo-bestruct-framework/includes/shortcodes/countdown/assets/js/redcountdown/jquery.redcountdown.js'; ?>"></script>
		<script>
           	function ReloadPage() {
               	window.location.reload(true);
           	};

           	jQuery(document).ready(function() {
	           	var timeout = <?php echo esc_js($time_to_reload); ?> * 1000; // calculation buy miliseconds
	           	if(timeout > 2147483647){//max value of parameter because use 32bit
	               timeout = 2147483647;
	           	} else {
	               timeout = timeout;
	           	}

	           	setTimeout("ReloadPage()", timeout);
           	});
       	</script>
	</head>
	<body style="background: url('<?php echo esc_url($maintenance_background['url']); ?>');">
		<div class="wrapper">
			<div class="maintanence-page">
				<div class="container">
					<div class="maintenance-title">
						<h2><?php echo esc_html($yolo_bestruct_options['maintenance_title']); ?></h2>
					</div>
					<div class="countdown-wrap">
						<div id="countdown-content-<?php echo esc_attr($time_id);?>" class="countdown-content" data-date="<?php echo esc_html( $online_time );?>"></div>
					</div>
					<div class="maintenance-social">
						<?php yolo_get_template('maintenance_social'); ?>
					</div>
				</div>
			</div>
		</div>
		<?php 
			$diff = strtotime($online_time)-time();
		?>
		<?php wp_footer(); ?>
	</body>
	<script type="text/javascript">
	    jQuery(document).ready(function($){
	    	// More details here: https://github.com/wimbarelds/TimeCircles
	        var $time_id = '<?php echo esc_js($time_id)?>';
	        var days    = "<?php echo esc_html__( 'Days', 'yolo-bestruct' ); ?>";
	        var hours   = "<?php echo esc_html__( 'Hours', 'yolo-bestruct' ); ?>";
	        var minutes = "<?php echo esc_html__( 'Minutes', 'yolo-bestruct' ); ?>";
	        var seconds = "<?php echo esc_html__( 'Seconds', 'yolo-bestruct' ); ?>";

			$('#countdown-content-' + $time_id).redCountdown({
	            end: $.now() + parseInt(<?php echo esc_js($diff); ?>),
	            labels: true,
	            style: {
	                element: "",
	                textResponsive: .5,
	                daysElement: {
	                    gauge: {
	                        thickness: .03,
	                        bgColor: "rgba(255,255,255,0.05)",
	                        fgColor: "#ffffff"
	                    },
	                    textCSS: 'font-family:\'Open Sans\'; font-size:25px; font-weight:300; color:#fff;'
	                },
	                hoursElement: {
	                    gauge: {
	                        thickness: .03,
	                        bgColor: "rgba(255,255,255,0.05)",
	                        fgColor: "#ffffff"
	                    },
	                    textCSS: 'font-family:\'Open Sans\'; font-size:25px; font-weight:300; color:#fff;'
	                },
	                minutesElement: {
	                    gauge: {
	                        thickness: .03,
	                        bgColor: "rgba(255,255,255,0.05)",
	                        fgColor: "#ffffff"
	                    },
	                    textCSS: 'font-family:\'Open Sans\'; font-size:25px; font-weight:300; color:#fff;'
	                },
	                secondsElement: {
	                    gauge: {
	                        thickness: .03,
	                        bgColor: "rgba(255,255,255,0.05)",
	                        fgColor: "#ffffff"
	                    },
	                    textCSS: 'font-family:\'Open Sans\'; font-size:25px; font-weight:300; color:#fff;'
	                }
	                
	            },
	            onEndCallback: function() { console.log("Time out!"); }
	        });
	    });
	</script>
</html>
