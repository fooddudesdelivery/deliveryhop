<?php
/**
 * best_sellers footer - displays selected number of (usu top ten) best selling products
 *
 * @package templateSystem
 * @copyright Copyright 2003-2011 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: best_sellers.php 18941 2011-06-13 22:12:42Z wilt $
 */

$limit = " LIMIT " . (int)3;
$best_sellers_query = "select distinct p.products_id, p.products_image, pd.products_name, p.products_ordered
                       from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd
                       where p.products_status = '1'
                       and p.products_ordered > 0
                       and p.products_id = pd.products_id
                       and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'
                       order by p.products_ordered desc, pd.products_name";

$best_sellers_query .= $limit;
$best_sellers = $db->Execute($best_sellers_query);

if ($best_sellers->RecordCount() >= 1) {
  $bestsellers_list = array();
  $title =  BOX_HEADING_BESTSELLERS;
  $box_id =  'best-seller-widget';
  $rows = 0;
  while (!$best_sellers->EOF) {
    $rows++;
    $bestsellers_list[$rows]['id'] = $best_sellers->fields['products_id'];
    $bestsellers_list[$rows]['name']  = $best_sellers->fields['products_name'];
    $bestsellers_list[$rows]['image']  = $best_sellers->fields['products_image'];
    $best_sellers->MoveNext();
  }

  $title_link = false;
  require($template->get_template_dir('tpl_best_sellers.php',DIR_WS_TEMPLATE, $current_page_base,'footer'). '/tpl_best_sellers.php');
}
?>
