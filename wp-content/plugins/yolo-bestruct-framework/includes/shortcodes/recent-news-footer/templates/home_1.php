<?php
/**
 * Created by GDragon.
 * User: Administrator
 * Date: 21/4/2016
 * Time: 5:40 PM
 */

$recent_news_id  = uniqid();
?>
<div id="recent-news-container-<?php echo $recent_news_id; ?>" class="recent-news-container">
    <?php while( $recent_news_footer->have_posts() ) : $recent_news_footer->the_post(); ?>
      <?php $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'medium');
    ?>
      <article class="<?php echo esc_attr($text_color); ?>">
      <div class="recent_news_item">
        <div class="post-thumbnail">
          <div class="post-image">
            <?php the_post_thumbnail('medium'); ?>  
          </div>
          <a href="<?php the_permalink() ?>">
            <div class="post-meta">
            </div>
          </a> 
        </div> 
        <div class="post-content <?php echo esc_attr($text_color); ?>">
          <h4 class="entry-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
          <div class="post-info">
            <span class="post-author <?php if($hide_author != 'true') echo('hide_content'); ?>"><?php echo get_the_author(); ?> </span>
            <span class="post-date <?php if($hide_date != 'true') echo('hide_content'); ?>"><?php echo get_the_date('M, Y'); ?> </span>
            <span class="post-count-comments <?php if($hide_comment != 'true') echo('hide_content'); ?>"><i class="fa fa-comments"></i><?php echo get_comments_number( get_the_ID() ); ?></span>
          </div>
        </div> 
      </div>  
      <p class="post-excerpt <?php if($hide_excerpt != 'true') echo('hide_content'); ?>"><?php echo ($excerpt_length != '') ? wp_trim_words(get_the_excerpt(), $excerpt_length) : get_the_excerpt(); ?></p> 
      </article>
    <?php endwhile; ?>
</div>
