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
        <div class="post-thumbnail">
          <div class="post-image">
            <?php the_post_thumbnail('large'); ?>  
          </div>
          <a href="<?php the_permalink() ?>">
            <div class="post-meta">
            </div>
          </a> 
        </div>  
        <div class="post-content">
          <div class="post-info">
            <div class="info-meta">
              <span class="post-author"><?php echo esc_html__('Post by ', 'yolo-bestruct');?><span><?php echo get_the_author(); ?></span></span>
              <span class="post-count-comments"><i class="fa fa-comment-o"></i><?php echo get_comments_number( get_the_ID() ); ?></span>
            </div>
            <h4 class="entry-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
          </div>
          <div class="post-date">
              <span><i class="fa fa-calendar"></i><?php echo get_the_date('j, F, Y'); ?> </span>
          </div>
          <div class="main-content">
            <p class="post-excerpt"><?php echo ($excerpt_length != '') ? wp_trim_words(get_the_excerpt(), $excerpt_length) : get_the_excerpt(); ?></p>
          </div> 
        </div>  
      </article>
    <?php endwhile; ?>
</div>


