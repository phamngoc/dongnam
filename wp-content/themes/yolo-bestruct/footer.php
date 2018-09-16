			<?php 
				/*
				* @hooked - yolo....
				*/
				do_action( 'yolo_main_wrapper_content_end' );
			?>
			</div>
			<!-- Close wrapper content -->

			<footer id="yolo-footer-wrapper">
				<?php
				global $yolo_footer_id;
				global $yolo_bestruct_options;
				if( $yolo_footer_id == '' &&  isset($yolo_bestruct_options) && isset( $yolo_bestruct_options['footer'])) {
					$yolo_footer_id = $yolo_bestruct_options['footer'];
				}
				if ( $yolo_footer_id ):
				$footer_object = get_post( $yolo_footer_id );
				?>
				<div class="yolo-footer-wrapper <?php echo esc_attr($footer_object->post_name); ?>">
					<?php
						/*
						* @hooked - yolo_footer_block - 10
						*/
						do_action( 'yolo_main_wrapper_footer' );
					?>
				</div>
				<?php endif;?>
			</footer>
		</div>
		<!-- Close wrapper -->
		<?php
			/*
			* @hooked - yolo_back_to_top - 5
			*/
			do_action( 'yolo_after_page_wrapper' );
		?>
	<?php wp_footer(); ?>
	</body>
</html>