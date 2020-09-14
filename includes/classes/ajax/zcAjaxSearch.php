<?php
/**
 * zcAjaxPayment
 *
 * @package templateSystem
 * @copyright Copyright 2003-2014 Zen Cart Development Team
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version GIT: $Id: Author: Ian Wilson  New in v1.5.4 $
 */
class zcAjaxSearch extends base
{
  public function getSuggestion()
  {
    $data = array();
    $data['keyword'] = stripslashes(isset($_POST['keyword']) ? zen_output_string_protected($_POST['keyword']) : zen_output_string_protected(KEYWORD_FORMAT_STRING));
    $products = pt_handle_ajax_search($data['keyword']);
    return $products;
  }
}