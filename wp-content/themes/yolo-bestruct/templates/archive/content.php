<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 */
global $yolo_archive_loop,$yolo_excerpt_length,$post,$yolo_padding;
$size = 'full';
if($yolo_excerpt_length == ''){
    $yolo_excerpt_length = 20;
}
if (isset($yolo_archive_loop['image-size'])) {
    $size = $yolo_archive_loop['image-size'];
}
$date    = get_the_date('d M');
$date    = explode(' ',$date);
$class   = array();
$class[] = "clearfix";
wp_enqueue_style('prettyPhoto');
wp_enqueue_script('prettyPhoto');
?>
<article id="post-<?php the_ID(); ?>" <?php post_class($class); ?> <?php if($yolo_padding){ echo 'style="padding: 0 15px 30px 15px;"'; }?>>
    <div class="post-item">
        <div class="entry-wrap">
            <?php
            $thumbnail = yolo_post_thumbnail('blog-medium-image');
            if (!empty($thumbnail)) : ?>
                <div class="entry-thumbnail-wrap">
                    <?php echo wp_kses_post($thumbnail); ?>
                </div>
            <?php endif; ?>
            <div class="entry-content-wrap">
                <div class="entry-detail">
                    <div class="entry-post-meta-wrap">
                        <?php yolo_post_meta(); ?>
                    </div>
                    <h3 class="entry-title p-font">
                        <a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a>
                    </h3>
                    <div class="entry-meta-date">
                        <i class="fa fa-calendar p-color"></i> <a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>"> <?php echo  get_the_date(get_option('date_format'));?> </a>
                    </div>
                    <div class="entry-excerpt">
                        <?php
                            if( $yolo_excerpt_length ) {
                                    $excerpt = wp_trim_words(get_the_excerpt(),$yolo_excerpt_length,'...');
                                    echo '<p>'.esc_html($excerpt).'</p>';
                            } else {
                                the_excerpt();
                            }  
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</article>