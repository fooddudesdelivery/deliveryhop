<?php
/**
 * @package Pepper Themes Framework
 * @copyright Copyright 2012 - 2014 Pepper Themes
 * @author IronLady
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 */

/* Featured */
$random_featured_products_query = "select p.products_id, p.products_image, pd.products_name,
                                   p.master_categories_id
                       from (" . TABLE_PRODUCTS . " p
                       left join " . TABLE_FEATURED . " f on p.products_id = f.products_id
                       left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on p.products_id = pd.products_id )
                       where p.products_id = f.products_id
                       and p.products_id = pd.products_id
                       and p.products_status = 1
                       and f.status = 1
                       and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'";

$random_featured_product = $db->ExecuteRandomMulti($random_featured_products_query, MAX_RANDOM_SELECT_FEATURED_PRODUCTS);

/* Specials */
$random_specials_sidebox_product_query = "select p.products_id, pd.products_name, p.products_price,
                                    p.products_tax_class_id, p.products_image,
                                    s.specials_new_products_price,
                                    p.master_categories_id
                             from " . TABLE_PRODUCTS . " p, " .
                                      TABLE_PRODUCTS_DESCRIPTION . " pd, " .
                                      TABLE_SPECIALS . " s
                             where p.products_status = 1
                             and p.products_id = s.products_id
                             and pd.products_id = s.products_id
                             and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'
                             and s.status = 1";

$random_specials_sidebox_product = $db->ExecuteRandomMulti($random_specials_sidebox_product_query, MAX_RANDOM_SELECT_SPECIALS);

/* Latest */
$display_limit = zen_get_new_date_range();
$random_whats_new_sidebox_product_query = "select p.products_id, p.products_image, p.products_tax_class_id, p.products_price, pd.products_name,
                                            p.master_categories_id, p.products_date_added 
                         from (" . TABLE_PRODUCTS . " p
                         left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on p.products_id = pd.products_id )
                         where p.products_id = pd.products_id
                         and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'
                         and p.products_status = 1 " . $display_limit . " order by p.products_date_added DESC";

$random_whats_new_sidebox_product = $db->ExecuteRandomMulti($random_whats_new_sidebox_product_query, MAX_RANDOM_SELECT_NEW);

$featured_title =  BOX_HEADING_FEATURED_PRODUCTS;
$specials_title =  BOX_HEADING_SPECIALS;
$latest_title =  TEXT_SIDEBAR_LATEST;

$title =  '';
$title_link = false;

require($template->get_template_dir('tpl_product_tabs.php',DIR_WS_TEMPLATE, $current_page_base,'sideboxes'). '/tpl_product_tabs.php');
require($template->get_template_dir($column_box_default, DIR_WS_TEMPLATE, $current_page_base,'common') . '/' . $column_box_default);