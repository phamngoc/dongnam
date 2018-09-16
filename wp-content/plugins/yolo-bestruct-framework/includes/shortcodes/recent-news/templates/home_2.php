<?php
/**
 * Created by GDragon.
 * User: Administrator
 * Date: 21/4/2016
 * Time: 5:40 PM
 */

$recent_news_id  = uniqid();
?>
<div id="recent-news-container-<?php echo $recent_news_id; ?>" class="recent-news-container owl-carousel"
  data-owl="<?php echo esc_attr($columns)?>"
  data-autoplay="<?php echo esc_attr($autoplay)?>"
  data-duration="<?php echo esc_attr($slide_duration)?>"
  data-margin="30"
  data-rtl="<?php echo esc_attr($rtl)?>"
  data-nav="true"
  data-loop="true"
>
    <?php while( $recent_news->have_posts() ) : $recent_news->the_post(); ?>
      <article class="recent_news_item">
        <a href="<?php the_permalink();?>">
          <div class="post-thumbnail">
            <?php the_post_thumbnail('large'); ?>
          </div>
        </a>
        <div class="post-information">
          <div class="post-meta">
            <div class="yl-meta-left">
              <p class="yl-date"><?php echo get_the_date( 'd', get_the_ID() );?></p>
            </div>
            <div class="yl-meta-right">
              <p class="yl-month"><?php echo get_the_date( 'F, Y', get_the_ID() );?></p>
              <h3 class="post-blog-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>
            </div>
          </div>
          <div class="info-meta">
            <span class="post-author"><?php echo esc_html__('Post by ', 'yolo-bestruct');?><span><?php echo get_the_author(); ?></span></span>
            <span class="post-count-comments"><i class="fa fa-comment-o"></i><?php echo get_comments_number( get_the_ID() ); ?></span>
          </div>
          <p class="post-blog-excerpt"><?php echo ($excerpt_length != '') ? yolo_limit_words_pg(get_the_excerpt(), $excerpt_length) : get_the_excerpt(); ?></p>
          <a href="<?php the_permalink();?>" class="btn-readmore"><span class="span-text"><?php echo esc_html__('Read more...', 'yolo-bestruct');?></span></a>
        </div>
      </article>
    <?php endwhile; ?>
</div>


