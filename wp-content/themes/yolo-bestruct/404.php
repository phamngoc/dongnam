<?php
get_header();
?>
    <?php
    global $yolo_bestruct_options;
    $background_404 = $yolo_bestruct_options['page_404_bg_image']['url'];
    if($background_404 == ''){
        $background_404 = get_template_directory_uri().'/assets/images/404-bg.jpg';
    }
    $page_title_404 = $yolo_bestruct_options['page_title_404'];
    if($page_title_404 == ''){
        $page_title_404 = esc_html__('THE PAGE','yolo-bestruct');
    }
    $page404_sub_title = $yolo_bestruct_options['sub_page_title_404'];
    if($page404_sub_title == ''){
        $page404_sub_title = esc_html__('Sorry but the page that you are looking for does not exist...','yolo-bestruct');
    }
    $title_404 = isset($yolo_bestruct_options['title_404']) ? $yolo_bestruct_options['title_404'] : esc_html__('404 ERROR','yolo-bestruct');
    $go_back_text = $yolo_bestruct_options['go_back_404'];
    if($go_back_text == ''){
        $go_back_text = esc_html__('Return Homepage','yolo-bestruct');
    }
    ?>
    <div class="page404" style="background: url(<?php echo esc_url($background_404); ?>);">
        <div class=" content-wrap">
            <div class="page404-content">
                <p class="404-content"><?php echo wp_kses_post($title_404); ?></p>
            </div>
            <div class="page404-title">
                <h2 class="p-title"><?php echo wp_kses_post($page_title_404); ?></h2>
                <h4  class="p-description p-font"><?php echo wp_kses_post($page404_sub_title); ?></h4>
            </div>
            <div class="return">
                <?php
                $go_back_link = $yolo_bestruct_options['go_back_url_404'];
                if($go_back_link == '' )
                    $go_back_link = get_home_url();
                ?>
                Back to
                <a href="<?php echo esc_url($go_back_link) ?>"><?php echo wp_kses_post($go_back_text); ?></a>
            </div>
        </div>
    </div>
<?php get_footer(); ?>



