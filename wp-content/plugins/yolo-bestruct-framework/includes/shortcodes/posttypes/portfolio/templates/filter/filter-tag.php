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

if ($show_filter != '') {
  $termIds = array();
  $portfolio_terms = get_terms('portfolio_tag');
  // @TODO: need change tag only in selected categories
  if ($portfolio_tag != '') {
    $slugSelected = explode(',', $portfolio_tag);
    foreach ($portfolio_terms as $term) {
      if (in_array($term->slug, $slugSelected)) {
        $termIds[$term->term_id] = $term->term_id;
      }
    }
  }
  $array_terms = array(
    'include' => $termIds
  );
  $terms = get_terms('portfolio_tag', $array_terms);

  if (count($terms) > 0) {
    $index = 1;
    ?>
    <div class="tab-wrapper line-height-1 <?php echo esc_attr($show_filter) ?>">
      <ul class="<?php echo esc_attr($filter_style) ?> <?php if($filter_style=='style_3') echo('container'); ?>">
        <li class="active">
          <a  class="isotope-portfolio ladda-button bestruct-button style2 button-dark button-2x active"
              data-section-id    ="<?php echo esc_attr($data_section_id) ?>"
              data-category      =""
              data-overlay-style ="<?php echo esc_attr($overlay_style) ?>"
              data-source        ="<?php echo esc_attr($data_source) ?>"
              data-portfolio-ids ="<?php echo esc_attr($portfolio_ids) ?>"
              data-group         ="all" 
              data-filter        ="*"
              data-thumbnail     ="<?php echo esc_attr($portfolio_thumbnail); ?>"
              data-tag           ="<?php echo esc_attr($portfolio_tag); ?>"
              data-current-page  ="1"
              data-offset        ="<?php echo esc_attr($offset) ?>"
              data-post-per-page ="<?php echo esc_attr($post_per_page) ?>"
              data-order         ="<?php echo esc_attr($order) ?>"
              data-column        ="<?php echo esc_attr($column) ?>"
              data-show-paging   ="<?php echo esc_attr($show_pagging) ?>"
              data-style         ="zoom-out"
              data-spinner-color ="#fff"
              href               ="javascript:;">
              <?php echo esc_html__('All', 'yolo-bestruct'); ?>
          </a>
        </li>
        <?php foreach ($terms as $term) : ?>
        <li class="<?php if ($index == count($terms)) { echo "last"; } ?>">
          <a  class="isotope-portfolio ladda-button bestruct-button style2 button-dark button-2x "
              href               ="javascript:;" 
              data-section-id    ="<?php echo esc_attr($data_section_id) ?>"
              data-category      ="<?php echo esc_attr($term->slug) ?>"
              data-overlay-style ="<?php echo esc_attr($overlay_style) ?>"
              data-source        ="<?php echo esc_attr($data_source) ?>"
              data-portfolio-ids ="<?php echo esc_attr($portfolio_ids) ?>"
              data-group         ="<?php echo preg_replace('/\s+/', '', $term->slug) ?>"
              data-filter        =".<?php echo esc_attr($term->slug) ?>"
              data-thumbnail     ="<?php echo esc_attr($portfolio_thumbnail); ?>"
              data-tag           ="<?php echo esc_attr($portfolio_tag); ?>"
              data-current-page  ="1"
              data-offset        ="<?php echo esc_attr($offset) ?>"
              data-post-per-page ="<?php echo esc_attr($post_per_page) ?>"
              data-order         ="<?php echo esc_attr($order) ?>"
              data-column        ="<?php echo esc_attr($column) ?>"
              data-show-paging   ="<?php echo esc_attr($show_pagging) ?>"
              data-style         ="zoom-out"
              data-spinner-color ="#fff">
              <?php echo wp_kses_post($term->name); ?>
          </a>
        </li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php
  }
}
?>