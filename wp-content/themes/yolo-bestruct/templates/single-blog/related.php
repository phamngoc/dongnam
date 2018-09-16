<?php
global $yolo_bestruct_options;
$related_class = '';
$related_heading = isset($yolo_bestruct_options['related_title']) ? $yolo_bestruct_options['related_title'] : '';
$related_layout = isset($yolo_bestruct_options['related_layout']) ? $yolo_bestruct_options['related_layout'] : 'slider';
$margin = isset($yolo_bestruct_options['related_margin']) ? $yolo_bestruct_options['related_margin'] : '0';
$per_page = isset($yolo_bestruct_options['related_count']) ? $yolo_bestruct_options['related_count'] : '3';
$related_col = isset($yolo_bestruct_options['related_post_col']) ? $yolo_bestruct_options['related_post_col'] : '3';
if(!empty($related_col) && $related_layout == 'grid'){
  $related_class = ' yolo-col-'.esc_attr($related_col);
}
if(!empty($related_layout)){
  $related_class .= ' '.$related_layout;
}
if($related_layout == 'slider'){
  wp_enqueue_style('owl-carousel');
  wp_enqueue_script('owl-carousel');
  $related_class .= ' owl-carousel';
}
$taxonomies = array('category');
  $terms = wp_get_object_terms( get_the_ID(), $taxonomies, array( 'fields' => 'ids' ) );
  if ( is_wp_error( $terms ) || empty( $terms ) ) {
    return array();
  }
  $args = array(
    'post_type' => 'post',
    'post_status' => 'publish',
    'posts_per_page' => $per_page,
    'orderby' => 'post_date',
    'tax_query' => array(
      array(
          'taxonomy' => 'category',
          'field'    => 'id',
          'terms' => $terms
      )
    ),
    'post__not_in' => array (get_the_ID()),
    );
  $related_items = new WP_Query( $args );
?>
<?php if(!empty($related_heading)):?>
    <h2><?php echo esc_html($related_heading);?></h2>
<?php endif;?>
<div class = "yolo-related-post<?php echo esc_attr($related_class);?>" <?php if($related_layout == 'slider'):?> data-col = "<?php echo esc_attr($related_col);?>" data-margin = "<?php echo esc_attr($margin);?>"<?php endif;?>>
	<?php 
		while ( $related_items->have_posts() ) : $related_items->the_post();
            $permalink   = get_permalink();
            $title_post  = get_the_title();
            ?>
            <div class = "yolo-related-post-item">
            	<div class = "yolo-related-post-thumb">
            		<a href="<?php echo esc_url($permalink);?>">
            			<?php the_post_thumbnail('thumbnail'); ?>
            		</a>
            	</div>
            	<div class = "yolo-related-post-content">
            		<h4 class = "yolo-related-post-title">
            			<a href = "<?php echo esc_url($permalink);?>"><?php echo esc_html($title_post);?></a>
            		</h4>
        			<span class="meta-author-text">Author:</span> <?php printf('<a href="%1$s">%2$s</a>',esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),esc_html( get_the_author() )); ?>
        			<span><?php comments_popup_link( wp_kses_post(__('<i class="fa fa-comments-o p-color"></i> 0 Comment','yolo-bestruct')),wp_kses_post(__('<i class="fa fa-comments-o p-color"></i> 1 Comment','yolo-bestruct')), wp_kses_post(__('<i class="fa fa-comments-o p-color"></i> % Comments','yolo-bestruct'))); ?></span>
            		
            	</div>
            </div>
        <?php
    endwhile;
    wp_reset_postdata();
	?>
</div>