<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-content">
		<?php the_content(); ?>
	</div>
	<?php wp_link_pages(array(
		'before'      => '<div class="yolo-page-links"><span class="yolo-page-links-title">' . esc_html__( 'Pages:', 'yolo-bestruct' ) . '</span>',
		'after'       => '</div>',
		'link_before' => '<span class="yolo-page-link">',
		'link_after'  => '</span>',
	)); ?>

</div>