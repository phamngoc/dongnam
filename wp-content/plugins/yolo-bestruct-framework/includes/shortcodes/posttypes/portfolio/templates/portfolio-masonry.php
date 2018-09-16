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

// Portfolio source
$args = array(
  'offset'         => $offset,
  'orderby'        => 'post__in',
  'post__in'       => explode(",", $portfolio_ids),
  'posts_per_page' => $post_per_page,
  'post_type'      => 'yolo_portfolio',
  'post_status'    => 'publish'
);
// If not choose tag
if( $portfolio_tag != '' ) {
  $args['tax_query'] = array(
    'relation' => 'AND',
    array(
      'taxonomy' => 'portfolio_tag',
      'field'    => 'slug',
      'terms'    => explode(',', $portfolio_tag),
    ),
  );
}

// Source from category
if ($data_source == '') {
  $args = array(
    'offset'             => $offset,
    'posts_per_page'     => $post_per_page,
    'orderby'            => 'post_date',
    'order'              => $order,
    'post_type'          => 'yolo_portfolio',
    'post_status'        => 'publish'
  );
  // If not choose tag
  if( $portfolio_tag == '' ) {
    $args['tax_query'] = array(
      'relation' => 'AND',
      array(
        'taxonomy' => 'portfolio_category',
        'field'    => 'slug',
        'terms'    => explode(',', $category),
      ),
    );
  } else {
    $args['tax_query'] = array(
      'relation' => 'AND',
      array(
        'taxonomy' => 'portfolio_category',
        'field'    => 'slug',
        'terms'    => explode(',', $category),
      ),
      array(
        'taxonomy' => 'portfolio_tag',
        'field'    => 'slug',
        'terms'    => explode(',', $portfolio_tag),
      ),
    );
  } 
}

$posts_array = new WP_Query($args);

$total_post  = $posts_array->found_posts;
$col_class   = '';
$col_class   = 'bestruct-col-md-' . $column;
if ($data_section_id == '')
    $data_section_id = uniqid();
$paging_style = 'paging';
$hover_dir_class = 'hover-dir-' . $hover_dir;

?>
<div class="portfolio-container">
  <div class="portfolio overflow-hidden <?php echo esc_attr($yolo_animation . ' ' . $paging_style) ?>" <?php if($styles_animation):?>style= "<?php echo esc_attr($styles_animation);?>"<?php endif;?> id="portfolio-<?php echo esc_attr($data_section_id) ?>">
      <!-- Portfolio Filter -->
      <?php if ($show_filter != '' ) : ?>
      <div class="portfolio-tabs clearfix <?php if($show_filter!=''){ echo $filter_by;} ?>">
        <?php 
          include(plugin_dir_path(__FILE__) . '/filter/filter-' . $filter_by . '.php');
        ?>
      </div>
      <?php endif; ?>
      <!-- End Portfolio Filter -->

      <!-- Portfolio Wrapper -->
      <div class="portfolio-wrapper <?php echo sprintf('%s %s %s %s', $col_class, $padding, $portfolio_thumbnail, $hover_dir_class) ?>"
          data-section-id="<?php echo esc_attr($data_section_id); ?>"
          id="portfolio-container-<?php echo esc_attr($data_section_id); ?>"
          data-columns="<?php echo esc_attr($column); ?>">
          <?php
          $index = 0;

          while ($posts_array->have_posts()) : $posts_array->the_post();
            $index++;
            $permalink      = get_permalink();
            $title_post     = get_the_title();
            if( $filter_by == 'category' ) {
              $terms          = wp_get_post_terms(get_the_ID(), array('portfolio_category'));
            } else {
              $terms          = wp_get_post_terms(get_the_ID(), array('portfolio_tag'));
            }
            $filter_name            = $filter_slug = '';
            foreach ($terms as $term) {
              $filter_slug .= $term->slug . ' ';
              $filter_name .= $term->name . ', ';
            }
            $filter_name = rtrim($filter_name, ', ');
          ?>

          <?php
            include(plugin_dir_path(__FILE__) . '/loop/' . $portfolio_thumbnail . '-item.php');
          ?>

          <?php
          endwhile;
          wp_reset_postdata();
          ?>
      </div>
      <!-- End Portfolio Wrap -->

      <!-- Portfolio Paging -->
      <?php if ($show_pagging == '1' && $post_per_page > 0 && $total_post / $post_per_page > 1 && $total_post > ($post_per_page * $current_page)) : ?>
          <div style="clear: both"></div>
          <div class="paging" id="load-more-<?php echo esc_attr($data_section_id) ?>">
              <a href="javascript:;" class="bestruct-button load-more ladda-button "
                 data-source          ="<?php echo esc_attr($data_source) ?>"
                 data-overlay-style   ="<?php echo esc_attr($overlay_style) ?>"
                 data-overlay-effect  ="<?php echo esc_attr($overlay_effect) ?>"
                 data-category        ="<?php echo esc_attr($category) ?>"
                 data-portfolio-ids   ="<?php echo esc_attr($portfolio_ids) ?>"
                 data-section-id      ="<?php echo esc_attr($data_section_id) ?>"
                 data-current-page    ="<?php echo esc_attr($current_page + 1) ?>"
                 data-column          ="<?php echo esc_attr($column); ?>"
                 data-offset          ="<?php echo esc_attr($offset) ?>"
                 data-current-page    ="<?php echo esc_attr($current_page) ?>"
                 data-post-per-page   ="<?php echo esc_attr($post_per_page) ?>"
                 data-show-paging     ="<?php echo esc_attr($show_pagging) ?>"
                 data-padding         ="<?php echo esc_attr($padding) ?>"
                 data-thumbnail       ="<?php echo esc_attr($portfolio_thumbnail); ?>"
                 data-tag             ="<?php echo esc_attr($portfolio_tag); ?>"
                 data-filter-by       ="<?php echo esc_attr($filter_by); ?>"
                 data-hover-dir       ="<?php echo esc_attr($hover_dir); ?>"
                 data-portfolio-title ="<?php echo esc_attr($portfolio_title); ?>"
                 data-order           ="<?php echo esc_attr($order) ?>"
                 data-style           ="zoom-out" 
                 data-spinner-color   ="#fff"
              >
                <?php esc_html_e('Load more', 'yolo-bestruct') ?>
              </a>
          </div>
      <?php endif; ?>
  </div>
</div>

<script type="text/javascript">
  (function ($) {
    "use strict";
    $(document).ready(function () {
      var $tab_container = jQuery('#portfolio-<?php echo esc_attr($data_section_id); ?>');
      $('.portfolio-tabs .isotope-portfolio', $tab_container).off();
      $('.portfolio-tabs .isotope-portfolio', $tab_container).click(function () {
        $('.portfolio-tabs .isotope-portfolio', $tab_container).removeClass('active');
        $('.portfolio-tabs li', $tab_container).removeClass('active');
        $(this).addClass('active');
        $(this).parent().addClass('active');
        var dataSectionId = $(this).attr('data-section-id');
        var filter        = $(this).attr('data-filter');
        var $container    = jQuery('div[data-section-id="' + dataSectionId + '"]').isotope({ filter: filter});
        $container.imagesLoaded(function () {
          $container.isotope('layout');
        });
      });
      var $container = jQuery('div[data-section-id="<?php echo esc_attr($data_section_id); ?>"]');
      $container.imagesLoaded(function () {
        $container.isotope({
          itemSelector: '.portfolio-item'
        }).isotope('layout');
      });
    });

    $(document).ready(function () {
      <?php if ('on' == $hover_dir) : ?>
      $('.portfolio-item.hover-dir > div.entry-thumbnail').hoverdir();
      <?php endif; ?>
      
      PortfolioAjaxAction.init('<?php echo esc_url(get_site_url() . '/wp-admin/admin-ajax.php') ?>', '<?php echo esc_attr($data_section_id)?>');
    })

  })(jQuery);
</script>