<?php
/**
 *  
 * @package    YoloTheme/Yolo Bestruct
 * @version    1.0.0
 * @author     Administrator <yolotheme@vietbrain.com>
 * @copyright  Copyright (c) 2016, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
*/
$team_id = uniqid();
?>
<div class="yolo-team-fix">
    <div class="yolo-team-wrap">
    </div>
</div>
<div id="yolo-teammember" class="yolo-teammember teammember-style-3 <?php echo $style; ?>">
    <ul id="teammember-list-<?php echo $team_id; ?>" class="teammembers teammember-list <?php if($style=='slider') :?>
 owl-carousel owl-theme <?php else: echo $columns; ?> <?php endif?>"
    <?php if($style=='slider'):?>
        data-owl="<?php echo esc_attr($member_per_slide)?>"
        data-autoplay="<?php echo esc_attr($autoplay)?>"
        data-duration="<?php echo esc_attr($slide_duration)?>"
        data-margin="30"
        data-rtl="<?php echo esc_attr($rtl)?>"
        data-nav="true"
        data-pagination="true"
        data-loop="true"
    <?php endif;?>
>
        <?php while( $teammembers->have_posts() ) : $teammembers->the_post(); ?>
            <li class="teammember-item">
                <div class="teammember-background">
                </div>
                <div class="teammember-content" data-option-id="<?php echo get_the_ID(); ?>">
                    <div class="teammember-image <?php echo esc_attr($bg_img); ?>">
                        <?php the_post_thumbnail('large')?>
                        <div class="social-content">
                            <ul class="teammember-social-profile">
                                <?php 
                                    $facebook = yolo_get_post_meta( get_the_ID(), 'yolo_teammember_facebook' );
                                    if( !empty($facebook) && $facebook[0] != '' ) :
                                ?>
                                <li>
                                    <a href="<?php echo esc_url($facebook[0]); ?>">
                                        <i class="fa fa-facebook"></i>
                                    </a>
                                </li>
                                <?php endif; ?>
                                <?php 
                                    $twitter = yolo_get_post_meta( get_the_ID(), 'yolo_teammember_twitter' );
                                    if( !empty($twitter) && $twitter[0] != '' ) :
                                ?>
                                <li>
                                    <a href="<?php echo esc_url($twitter[0]); ?>">
                                        <i class="fa fa-twitter"></i>
                                    </a>
                                </li>
                                <?php endif; ?>
                                <?php 
                                    $google = yolo_get_post_meta( get_the_ID(), 'yolo_teammember_google' );
                                    if( !empty($google) && $google[0] != '' ) :
                                ?>
                                <li>
                                    <a href="<?php echo esc_url($google[0]); ?>">
                                        <i class="fa fa-google-plus"></i>
                                    </a>
                                </li>
                                <?php endif; ?>

                                <?php 
                                    $instagram = yolo_get_post_meta( get_the_ID(), 'yolo_teammember_instagram' );
                                    if( !empty($instagram) && $instagram[0] != '' ) :
                                ?>
                                <li>
                                    <a href="<?php echo esc_url($instagram[0]); ?>">
                                        <i class="fa fa-instagram"></i>
                                    </a>
                                </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>

                    <div class="teammember-meta">
                        <div class="teammember-meta-inner">
                            <div class="teammember-title">
                            <?php the_title();?>
                            </div>
                            <?php if( !empty(yolo_get_post_meta( get_the_ID(), 'yolo_teammember_position' )) ) : ?>
                            <p class="teammember-position"><?php echo yolo_get_post_meta( get_the_ID(), 'yolo_teammember_position' )['0']; ?></p>
                            
                            <?php endif; ?>
                        </div>    
                    </div>
                </div>
            </li>
        <?php endwhile; ?>
    </ul>
</div>
