<?php
/**
 *  
 * @package    YoloTheme
 * @version    1.0.0
 * @created    14/3/2016
 * @author     Administrator <admin@yolotheme.com>
 * @copyright  Copyright (c) 2016, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
*/
?>
<div class="single-post-entry-meta">
    <div class="entry-meta-info">
        <h1 class="entry-title">
            <?php the_title(); ?>
        </h1>
        <ul>
            <li class="entry-meta-author">
                Post by <?php printf('<a href="%1$s">%2$s</a>',esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),esc_html( get_the_author() )); ?>
            </li>
            <?php if ( comments_open() || get_comments_number() ) : ?>
                <li class="entry-meta-comment">
                    <?php comments_popup_link( wp_kses_post(__('<i class="fa fa-comments-o p-color"></i> 0 Comment','yolo-bestruct')),wp_kses_post(__('<i class="fa fa-comments-o p-color"></i> 1 Comment','yolo-bestruct')), wp_kses_post(__('<i class="fa fa-comments-o p-color"></i> % Comments','yolo-bestruct'))); ?>
                </li>
            <?php endif; ?>
            <li class="entry-meta-date">
                <i class="fa fa-calendar p-color"></i><?php the_date(); ?>
            </li>
            
            <?php //edit_post_link( esc_html__( 'Edit', 'yolo-bestruct' ), '<li class="edit-link"><i class="fa fa-pencil p-color"></i> ', '</li>' ); ?>
        </ul>
        <div class="entry-post-format">
            <?php yolo_get_template( 'single-blog/post-format'); ?>
        </div>
    </div>
</div>