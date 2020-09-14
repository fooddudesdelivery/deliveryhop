<?php
/**
 * @package Pepper Themes Framework
 * @copyright Copyright 2012 - 2014 Pepper Themes
 * @author IronLady
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 */

$content = "";
$content .= '<div class="sideBoxContent centeredContent">';

  $content .= '<div class="price-slider" data-min="' . $min . '" data-max="' . $max . '"></div>';
  $content .= zen_draw_form('price_slider', zen_href_link(FILENAME_DEFAULT, '', $request_type, false), 'get');
  $content .= zen_draw_hidden_field('main_page', FILENAME_DEFAULT);  
  $content .= zen_hide_session_id();

  /* Get All Filter Params from tpl_index_product_list.php */
  if (!$getoption_set) {
    $content .= zen_draw_hidden_field('cPath', $cPath);
  } else {
    $content .= zen_draw_hidden_field($get_option_variable, $_GET[$get_option_variable]);
  }

  if (isset($_GET['filter_id']) && $_GET['filter_id'] != '') $content .= zen_draw_hidden_field('filter_id', $_GET['filter_id']);

  if (isset($_GET['music_genre_id']) && $_GET['music_genre_id'] != '') $content .= zen_draw_hidden_field('music_genre_id', $_GET['music_genre_id']);

  if (isset($_GET['record_company_id']) && $_GET['record_company_id'] != '') $content .= zen_draw_hidden_field('record_company_id', $_GET['record_company_id']);

  if (isset($_GET['typefilter']) && $_GET['typefilter'] != '') $content .= zen_draw_hidden_field('typefilter', $_GET['typefilter']);

  if ($get_option_variable != 'manufacturers_id' && isset($_GET['manufacturers_id']) && $_GET['manufacturers_id'] > 0) {
    $content .= zen_draw_hidden_field('manufacturers_id', $_GET['manufacturers_id']);
  }

  if (isset($_GET['alpha_filter_id']) && $_GET['alpha_filter_id'] != '') $content .= zen_draw_hidden_field('alpha_filter_id', $_GET['alpha_filter_id']);

  if (isset($_GET['sort']) && $_GET['sort'] != '') $content .= zen_draw_hidden_field('sort', $_GET['sort']);
  /* Get All Filter Params from tpl_index_product_list.php */

  $content .= '<input type="hidden" name="pfrom" value="' . $min . '"><input type="hidden" name="pto" value="' . $max . '">';
  $content .= '<span class="price-slider-text">' . $curr['symbol_left'] . '<span id="price-slider-min">' . $min_start . '</span>' . $curr['symbol_right'] . 
              ' - ' . $curr['symbol_left'] . '<span id="price-slider-max">' . $max_start . '</span>' . $curr['symbol_right'] . '</span>';
  $content .= '<span class="price-slider-button"><input type="submit" value="filter" class="pt-button pt-button-vs"></span>';
  $content .= '<div class="clearfix"></div>';
  $content .= '<script>jQuery(document).ready(function(){jQuery(\'.price-slider\').noUiSlider({' . 
                'start: [' . $min_start . ',' . $max_start . '],' . 
                'range: [' . $min . ',' . $max . '],' .
                'connect: true,' . 
                'step: 1,' . 
                'slide: function(){' . 
                  'var sliderValue = jQuery(\'.price-slider\').val();' . 
                  'jQuery(\'#price-slider-min\').html(Math.round(sliderValue[0]));' . 
                  'jQuery(\'#price-slider-max\').html(Math.round(sliderValue[1]));' . 
                  'jQuery(\'input[name="pfrom"]\').val(Math.round(sliderValue[0]));' . 
                  'jQuery(\'input[name="pto"]\').val(Math.round(sliderValue[1]));' .
                '}});});</script>';
  $content .= '</form>';

$content .= '</div>' . "\n";
?>

  