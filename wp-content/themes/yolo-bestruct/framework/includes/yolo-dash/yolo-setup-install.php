<?php
if(!class_exists('Yolo_Setup_Install')){
	Class Yolo_Setup_Install{
		private $theme_logo;
		private $theme_title;
		private $product_id;
		private $support_url;
		private $theme_name;
		private $is_yolo_framework;
		public function __construct(){
			if(is_admin()){
				$this->theme_logo       	= get_template_directory_uri() . '/assets/images/logo.png';
				$this->theme_title      	= esc_html__( 'Thank you for purchasing Bestruct Theme!', 'yolo-bestruct' );
				$this->product_id       	= 'yolo-bestruct';
				$this->support_url      	= 'https://yolotheme.com/forums/';
				$this->theme_name       	= 'Bestruct';
				$this->is_yolo_framework	= self::yolo_is_plugin_active( $this->product_id . '-framework/'. $this->product_id . '-framework.php' );
				add_action( 'admin_enqueue_scripts', array( &$this, 'enqueue_script' ) );
				add_action( 'wp_ajax_yolo_check_purchase_code', array( &$this, 'yolo_check_purchase_code' ) );
				add_action( 'admin_menu', array( &$this, 'yolo_admin_menu' ), 9 );
			}
		}
		public function enqueue_script() {
	    	wp_enqueue_style( 'yolo-theme-option', get_template_directory_uri() . '/framework/includes/yolo-dash/assets/theme-option.css' );

	    	wp_enqueue_script( 'yolo-theme-option', get_template_directory_uri() . '/framework/includes/yolo-dash/assets/theme-option.js', array( 'jquery' ), null, true );

	    	wp_localize_script( 'yolo-theme-option', 'Yolo_Theme_Option', array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'security' => wp_create_nonce( 'yolo-theme-option' ),
	        ) );

	    }
		/**
		 * Creates a new top level menu section.
		 *
		 * @return  void
		 */
		public function yolo_admin_menu() {
			global $submenu,$pagenow;
			if ( current_user_can( 'edit_theme_options' ) ) {
				$menu = 'add_menu_' . 'page';
				// Add Yolo root menu item.
				$menu(
					esc_html__( 'Bestruct', 'yolo-bestruct' ),
					esc_html__( 'Bestruct', 'yolo-bestruct' ),
					'manage_options',
					'yolo-options',
					array( $this, 'yolo_html' ),
					get_template_directory_uri() . '/assets/images/favicon.ico',
					2
				);

				// Add Yolo submenu items.
				$sub_menu = 'add_submenu_' . 'page';
				$sub_menu(
					'yolo-options',
					esc_html__( 'Yolo Dashboard', 'yolo-bestruct' ),
					esc_html__( 'Dashboard', 'yolo-bestruct' ),
					'manage_options',
					'yolo-options',
					array( $this, 'yolo_html' )
				);
				// Sort submenu
				if( isset( $submenu['yolo-options'][0][2] ) && $submenu['yolo-options'][0][2] == 'edit.php?post_type=yolo_footer' ) {
					$header = $submenu['yolo-options'][0];
					$welcome = $submenu['yolo-options'][1];

					$submenu['yolo-options'][0] = $welcome;
					$submenu['yolo-options'][1] = $header;
				}
			}
			// Redirect to Yolo welcome page after activating theme.
			if ( 'themes.php' == $pagenow && isset( $_GET['activated'] ) && $_GET['activated'] == 'true' ) {
				// Add do action

				// Redirect
				wp_redirect( admin_url ( 'admin.php?page=yolo-options#verify' ) );
			}
		}
		public static function yolo_is_plugin_active( $plugin ) {

            include_once ABSPATH . 'wp-admin/includes/plugin.php';
            return is_plugin_active( $plugin );

        }
		/**
		 * Render HTML of intro tab.
		 *
		 * @return  string
		 */
		public function yolo_html() {
			$settings_field_name = $this->yolo_get_field_name();
			$theme_options       = get_option( $settings_field_name );

			$subscribe  = 'http://eepurl.com/cadHAP';
			$twitter    = 'https://twitter.com/YoloTheme';
			$facebook   = 'https://www.facebook.com/Yolotheme/';
			$dribbble   = 'https://dribbble.com/yolotheme';
			$support    = 'https://yolotheme.com/forums/forum/';
			$docs       = 'http://docs.yolotheme.com/bestruct/';
			$changelog  = '#';
			?>
			<div class="wrap yolo-wrap">
				<h1 class="intro-title">
					<?php esc_html_e( 'Yolo Theme', 'yolo-bestruct' ); ?>
				</h1>
				<div class="welcome-panel">
					<div class="welcome-panel-content">
						<h1><?php esc_html_e( 'Welcome to Yolo Theme!', 'yolo-bestruct' ); ?></h1>
						<p class="about-description"><?php esc_html_e( 'We\'ve assembled some links to get you started', 'yolo-bestruct' ); ?></p>
						<div class = "theme-setup">
							<div class="yolo-support-active">
								<div class="welcome-panel-column">
									<h3 class = "get-start"><?php esc_html_e( 'Get start', 'yolo-bestruct' ); ?></h3>
									<a href="<?php echo ( admin_url( 'admin.php?page=_options' ) ); ?>" class="wr-scroll-animated button button-primary button-hero"><?php esc_html_e( 'Customize Your Site', 'yolo-bestruct' ); ?></a>
									<p class="small-text"><?php esc_html_e( 'or', 'yolo-bestruct' ); ?>, <a href="<?php echo esc_url( admin_url( 'themes.php' ) ); ?>"><?php esc_html_e( 'change your theme completely', 'yolo-bestruct' ); ?></a></p>
									
								</div>
								<div class="welcome-panel-column">
									<h3><?php esc_html_e( 'Next Steps', 'yolo-bestruct' ); ?></h3>
									<ul>
										<li><a target="_blank" href="<?php echo esc_url( admin_url( 'edit.php?post_type=yolo_footer' ) ); ?>" class="welcome-icon welcome-widgets-menus"><?php esc_html_e( 'View Footer Blocks', 'yolo-bestruct' ); ?></a></li>
										<li><a target="_blank" href="<?php echo esc_url( $docs ); ?>" class="welcome-icon dashicons-media-document"><?php esc_html_e( 'Read Documentation', 'yolo-bestruct' ); ?></a></li>
										<li><a target="_blank" href="<?php echo esc_url( $support ); ?>" class="welcome-icon dashicons-editor-help"><?php esc_html_e( 'Request Support', 'yolo-bestruct' ); ?></a></li>
										<li><a href="<?php echo esc_url( home_url( '/' ) );?>" class="welcome-icon welcome-view-site"><?php esc_html_e( 'View Your Site', 'yolo-bestruct' ) ?></a></li>
									</ul>
								</div>
								<div class="welcome-panel-column">
									<h3><?php esc_html_e( 'Keep in Touch', 'yolo-bestruct' ); ?></h3>
									<ul>
										<li><a target="_blank" href="<?php echo esc_url( $subscribe ); ?>" class="welcome-icon dashicons-email-alt"><?php esc_html_e( 'Newsletter', 'yolo-bestruct' ); ?></a></li>
										<li><a target="_blank" href="<?php echo esc_url( $twitter ); ?>" class="welcome-icon dashicons-twitter"><?php esc_html_e( 'Twitter', 'yolo-bestruct' ); ?></a></li>
										<li><a target="_blank" href="<?php echo esc_url( $dribbble ); ?>" class="welcome-icon dashicons-dribbble"><?php esc_html_e( 'Dribbble', 'yolo-bestruct' ); ?></a></li>
										<li><a target="_blank" href="<?php echo esc_url( $facebook ); ?>" class="welcome-icon dashicons-facebook"><?php esc_html_e( 'Facebook', 'yolo-bestruct' ); ?></a></li>
									</ul>
								</div>
							</div>
						</div>
					</div><!-- .welcome-panel-content -->
				</div><!-- .welcome-panel -->
				<div class="welcome-panel">
					<div class="welcome-panel-content">
						<div class="welcome-panel-column-container">
							<div id="tabs-container" role="tabpanel">
								<h2 class="nav-tab-wrapper">
										<a class="nav-tab yolo-nav" href="#verify"><?php esc_html_e( 'Purchase Code Verify', 'yolo-bestruct' ); ?></a>
										<a class="nav-tab yolo-nav" href="#plugin"><?php esc_html_e( 'Install Plugin', 'yolo-bestruct' ); ?></a>
										<a class="nav-tab yolo-nav" href="#demo"><?php esc_html_e( 'Import Data', 'yolo-bestruct' ); ?></a>
										<a class="nav-tab yolo-nav" href="#support"><?php esc_html_e( 'Document and Support', 'yolo-bestruct' ); ?></a>
								</h2>
								<div class="tab-content">
									<?php
										$this->yolo_purchase_form( $theme_options );
										$this->yolo_install_plugin_html( $theme_options );
										$this->yolo_import_data();
										$this->yolo_support();
									?>
								</div><!-- .tab-content -->
							</div>
						</div>
					</div><!-- .welcome-panel-content -->
				</div><!-- .welcome-panel -->
			</div><!-- wrap -->
			<?php
		}
		/**
		 * Render HTML of registration tab.
		 *
		 * @return  string
		 */
		public function yolo_purchase_form( $theme_options = null ) {
			?>
			<div id="verify" class="tab-pane" role="tabpanel">
				<div class="yolo-purchase-code-active">
					<p class="yolo-notice">
							<?php echo sprintf( esc_html__( 'Input the ThemeForest purchase code to be able to download, update and fully access to %s', 'yolo-bestruct' ), esc_html( $this->theme_name ) ); ?>
					</p>
					<form method="post" id = "yolo-purchase-code">
						<label><?php esc_html_e( 'ThemeForest Purchase Code:', 'yolo-bestruct' ); ?></label>
	                    <input type='text' name='purchase_code' value='<?php echo esc_attr( $theme_options['license_key'] ); ?>' placeholder = "<?php echo esc_attr_e('Enter Purchase Code *, eg. abcd-efgh-ikml-1234','yolo-bestruct')?>">
		                <div class="get_license_key">
		                	<a target="_blank" href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code-" class="welcome-icon dashicons-editor-help"><?php esc_html_e( 'How to get License key?', 'yolo-bestruct' ); ?></a>
						</div>
						<div style="clear:both"></div>
						<button id="yolo-active-code" type="submit">
							<?php echo esc_html__( 'Validate', 'yolo-bestruct' ); ?>
						</button>
					</form>
				</div>
			</div>
			<?php
		}
		/**
		 * Render HTML of install plugin.
		 *
		 * @return  string
		 */
		public function yolo_install_plugin_html( $theme_options = null ) {
			$license_key = get_option($this->product_id . '-license-settings');
			$tgmpa = TGM_Plugin_Activation::get_instance();
		?>
			<div id="plugin" class="tab-pane" role="tabpanel">

				<div class="yolo-install-plugin">
					<?php if ( $tgmpa->is_tgmpa_complete() === false ) :?>

						<p><?php echo wp_kses_post( '', 'yolo-bestruct' ); ?></p>
						<?php
								echo '<span id="yolo-install-all-plugin" class="button button-primary install-all-plugin">' . esc_html__( 'Install All Plugins', 'yolo-bestruct' ) . '</span>';
						?>
					<?php endif; ?>

					<p class = "plugin-active<?php if ( $tgmpa->is_tgmpa_complete() === true ) echo ' show';?>"><i class="fa fa-check" aria-hidden="true"></i> <span><?php if ( $tgmpa->is_tgmpa_complete() === true ) echo esc_html__('You installed successfull!','yolo-bestruct');?></span></p>

				</div>

				<div id="plugins" class="yolo-wrap plugins">

					<?php 
						$thumb_default = get_template_directory_uri() . '/assets/images/plugins/screenshot.jpg';

						// Check for Plugin updates
						$response = self::yolo_repload_check_update_plugins();

						foreach ( Yolo_Install_Plugin::$plugins as $plugin ):
							$path        = Yolo_Install_Plugin::yolo_bestruct_get_plugin_path( $plugin['slug'] );
							$activate    = Yolo_Install_Plugin::yolo_bestruct_is_plugin_active( $plugin['slug'] );
							$version     = '';
							$update      = false;
							$new_version = '';
							if( $activate ){
								$plugin_data = get_plugin_data(trailingslashit(WP_PLUGIN_DIR).$activate);	
								$version     = $plugin_data['Version'];
								if( array_key_exists( $path, $response ) && property_exists( $response[$activate], 'new_version' ) ){
									$update      = true;
									$new_version = $response[$activate]->new_version;
								}
							}
						?>
						<div class="item">

							<div class="plugin-screenshort" style="background-image: url(<?php echo !empty($plugin['thumb']) ? esc_url($plugin['thumb']) : $thumb_default ?>)">
								<?php
									if( $update ) {

										echo '<div class="update">';
											echo '<i class="fa fa-refresh" aria-hidden="true"></i><span>'.esc_html__( 'New version available.', 'yolo-bestruct' ).'</span>';
											?>
											<button class="button-link update-plugin<?php if( !$theme_options['license_key'] ) echo '  disabled'; ?>" data-plugin="<?php echo esc_attr( $plugin['slug'] ); ?>" data-name="<?php echo esc_attr( $plugin['name'] ).' '.esc_attr( $new_version ); ?>" data-new="<?php echo esc_attr( $new_version ); ?>" <?php if( !$theme_options['license_key'] && !is_plugin_inactive($path) ) echo ' disabled="disabled"' ?>><?php echo esc_html__( 'Update now' , 'yolo-bestruct'); ?></button>
											<?php
										echo '</div>';

						            }
									if( $plugin['required'] ):
										echo '<span class="required">'.esc_html__( 'Required', 'yolo-bestruct' ).'</span>';
									endif;
								?>
							</div>

							<h3 class="plugin-name">
								<?php echo esc_html($plugin['name']); ?>
								<span class="version"><?php echo esc_html( $version ); ?></span>
							</h3>

							<div class="plugin-actions">

								<?php if( $activate ): ?>

									<button class="button button-primary deactivate-plugin" data-plugin="<?php echo esc_attr( $plugin['slug'] ); ?>"><?php echo esc_html__( 'Deactivate', 'yolo-bestruct' ) ?></button>

									<button class="button button-primary uninstall-plugin" data-plugin="<?php echo esc_attr( $plugin['slug'] ); ?>"><?php echo esc_html__( 'Uninstall', 'yolo-bestruct' ) ?></button>

								<?php else: ?>

									<?php  if( is_file( trailingslashit(WP_PLUGIN_DIR).$path ) ): ?>
										<button class="button button-primary install-plugin" data-plugin="<?php echo esc_attr( $plugin['slug'] ); ?>" <?php if( !$theme_options['license_key'] && !is_plugin_inactive($path) ) echo ' disabled="disabled"' ?> ><?php echo esc_html__( 'Activate', 'yolo-bestruct' ); ?></button>

										<button class="button button-primary uninstall-plugin" data-plugin="<?php echo esc_attr( $plugin['slug'] ); ?>"><?php echo esc_html__( 'Uninstall', 'yolo-bestruct' ) ?></button>
									<?php else: ?>
										<button class="button button-primary install-plugin" data-plugin="<?php echo esc_attr( $plugin['slug'] ); ?>" <?php if( !$theme_options['license_key'] && !is_plugin_inactive($path) ) echo ' disabled="disabled"' ?> ><?php echo esc_html__( 'Install', 'yolo-bestruct' ); ?></button>
									<?php endif; ?>

								<?php endif; ?>

							</div>
						</div>
					<?php endforeach; ?>

				</div>

			</div> 
			<?php
		}
		/**
		 * Render HTML of import data demo.
		 *
		 * @return  string
		 */
		public function yolo_import_data() {
			
			?>
			<div id="demo" class="tab-pane" role="tabpanel">
				<?php
					if($this->is_yolo_framework):
				?>
					<div class="yolo-demo-active">
						<?php 
						Yolo_Notice_Install::yolo_import_demo_options();
						?>
					</div>
				<?php else:?>
					<h4 class = "note-message">
						<?php echo sprintf(wp_kses(__('Please <a href = "%s">Install</a> and <a href = "%s">Active</a> Yolo Bestruct Framework','yolo-bestruct'),yolo_allowed_tags()),esc_url('themes.php?page=install-required-plugins&plugin_status=install'),esc_url('themes.php?page=install-required-plugins&plugin_status=activate'))?>
					</h4>
				<?php endif;?>
			</div>
			<?php
		}
		/**
		 * Render HTML of Document and Support.
		 *
		 * @return  string
		 */
		public function yolo_support() {
			$subscribe  = 'http://eepurl.com/cadHAP';
			$twitter    = 'https://twitter.com/YoloTheme';
			$facebook   = 'https://www.facebook.com/Yolotheme/';
			$dribbble   = 'https://dribbble.com/yolotheme';
			$support    = 'https://yolotheme.com/forums/forum/';
			$docs       = 'http://docs.yolotheme.com/bestruct/';
			$changelog  = '#';
			?>
			<div id="support" class="tab-pane" role="tabpanel">
				<div class="yolo-support-active">
					<div class="welcome-panel-column">
						<h3><?php esc_html_e( 'Get start', 'yolo-bestruct' ); ?></h3>
						<ul>
							<li><a target="_blank" href="<?php echo esc_url( $docs ); ?>" class="welcome-icon dashicons-media-document"><?php esc_html_e( 'Read Documentation', 'yolo-bestruct' ); ?></a></li>
							<li><a target="_blank" href="<?php echo esc_url( $support ); ?>" class="welcome-icon dashicons-editor-help"><?php esc_html_e( 'Request Support', 'yolo-bestruct' ); ?></a></li>
							<li><a target="_blank" href="<?php echo esc_url( $changelog ); ?>" class="welcome-icon dashicons-backup"><?php esc_html_e( 'View Changelog Details', 'yolo-bestruct' ); ?></a></li>
						</ul>
					</div>
					<div class="welcome-panel-column">
						<h3><?php esc_html_e( 'Keep in Touch', 'yolo-bestruct' ); ?></h3>
						<ul>
							<li><a target="_blank" href="<?php echo esc_url( $subscribe ); ?>" class="welcome-icon dashicons-email-alt"><?php esc_html_e( 'Newsletter', 'yolo-bestruct' ); ?></a></li>
							<li><a target="_blank" href="<?php echo esc_url( $twitter ); ?>" class="welcome-icon dashicons-twitter"><?php esc_html_e( 'Twitter', 'yolo-bestruct' ); ?></a></li>
							<li><a target="_blank" href="<?php echo esc_url( $facebook ); ?>" class="welcome-icon dashicons-facebook"><?php esc_html_e( 'Facebook', 'yolo-bestruct' ); ?></a></li>
						</ul>
					</div>
				</div>
			</div>
			<?php
		}
		public function yolo_check_purchase_code() {
			if ( isset( $_POST['purchase_code'] ) && !empty( $_POST['purchase_code'] ) ) {
				$purchase_code = !empty( $_POST['purchase_code'] ) ? esc_attr( $_POST['purchase_code'] ) : '';
				unset( $_POST['action'] );
				$data_request = wp_remote_get(
					add_query_arg(
						array(
							'purchase_code' => esc_attr( $purchase_code ), 
							'site_url'      => get_site_url(),
						), 
						'http://update.yolotheme.com/verify_code'
					), 
					array( 'timeout' => 60 )
				);
				if( is_wp_error( $data_request ) ) {

					delete_option( $this->yolo_get_field_name() );

					$response['status']  = 'error';
					$response['message'] = esc_html__( 'Some troubles with connecting to YoloTheme server.', 'yolo-bestruct' );
					wp_send_json( $response );

				}

				$rp_data = json_decode( $data_request['body'], true );
				if( !is_array( $rp_data ) || empty( $rp_data ) || $rp_data['status'] !== 'success' ) {
					
					delete_option( $this->yolo_get_field_name() );
					
					$response['status']  = 'error';
					$response['message'] = esc_html__( 'Purchase code verification failed.', 'yolo-bestruct' );
					wp_send_json( $response );

				} else {

					$value_license = array(
						'license_key' => esc_attr( $purchase_code ),
						'site_url'       => esc_attr( str_replace( 'http://', '', home_url() ) ),
					);

					update_option( $this->yolo_get_field_name(), $value_license );

					$response['status']  = 'success';
					$response['message'] = esc_html__( 'Purchase code is activated', 'yolo-bestruct' );
					wp_send_json( $response );

				}

			}

			$response['status']  = 'error';
			$response['message'] = esc_html__( 'Please enter purchase code.', 'yolo-bestruct' );
			wp_send_json( $response );

		}

		/**
		 * Show message json
		 *
		 * @author  KENT <tuanlv@vietbrain.com>
		 * @version 1.0
		 */
		public function message() {

		}

		/**
		 * Setting fields
		 */
		public function yolo_get_field_name() {
            return $this->product_id . '-license-settings';
        }

        /**
         * Check update plugin
         */
        public function yolo_repload_check_update_plugins(){

			require ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
			wp_update_plugins(); 
			$plugin_updates = get_site_transient( 'update_plugins' );
			$core_update = new WP_Automatic_Updater();
			
			if ( $plugin_updates && !empty( $plugin_updates->response ) ) {
				foreach ( $plugin_updates->response as $plugin ) {
					$core_update->update( 'plugin', $plugin );
				}
				// Force refresh of plugin update information
				wp_clean_plugins_cache();
			}
			
			$response = array();
			if( property_exists ( $plugin_updates, 'response' ) ){
				$response = $plugin_updates->response;
			}
			return $response;

        }
		
	}
	new Yolo_Setup_Install;
}