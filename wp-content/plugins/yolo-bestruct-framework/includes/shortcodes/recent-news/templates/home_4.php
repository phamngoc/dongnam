<?php
/**
 *  
 * @package    YoloTheme
 * @version    1.0.0
 * @created    26/1/2016
 * @author     Administrator <yolotheme@vietbrain.com>
 * @copyright  Copyright (c) 2015, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
*/

$sttload = 0;

?>
<div class="recent-news-container row">
    <?php while( $recent_news->have_posts() ) : $recent_news->the_post(); ?>
      <?php $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'large'); ?>
      <?php if ($sttload == 0){ 
        echo '<div class="col-xs-12 col-sm-6 col-md-7">';
      };?>
      <?php if ($sttload == 1){ 
        echo '<div class="col-xs-12 col-sm-6 col-md-5">';
      };?>
      <a href="<?php the_permalink() ?>">
        <div class="col-xs-12 no-padding <?php if ($sttload == 2) { echo "last-post"; } ?> ">
          <div class="post-thumbnail" style="background:url('<?php echo $thumbnail_url; ?>');">
            <div class="entry-content">
              <h4 class="entry-title"><?php the_title(); ?></h4>
              <div class="entry-post-meta">
                <div class="post-author">Post by <span class="author"><?php the_author(); ?></span></div>
                <div class="post-date"><i class="fa fa-calendar"></i><?php the_time('j, F, Y'); ?> </div>
              </div>
              <div class="entry-excerpt"><?php echo ($excerpt_length != '') ? wp_trim_words(get_the_excerpt(), $excerpt_length) : get_the_excerpt(); ?></div>
            </div>
          </div>
        </div>
      </a>
      <?php
      if ($sttload == 0 || $sttload == 2) {
        echo '</div>';
      }
      $sttload = $sttload +1;
      ?>
    <?php endwhile; ?>
</div>    
