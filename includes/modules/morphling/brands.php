<?php
/**
 * @package Pepper Themes Framework
 * @copyright Copyright 2012 - 2014 Pepper Themes
 * @author IronLady
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 */

  if (!defined('IS_ADMIN_FLAG')) {
    die('Illegal Access');
  }

  $list_box_contents = array();
  $brands = array();

  $manufacturers_query = "select m.manufacturers_id, m.manufacturers_name, m.manufacturers_image,
                                mi.manufacturers_url
                         from " . TABLE_MANUFACTURERS . " m
                         left join " . TABLE_MANUFACTURERS_INFO . " mi
                         on (m.manufacturers_id = mi.manufacturers_id
                         and mi.languages_id = '" . (int)$_SESSION['languages_id'] . "')
						 ORDER BY RAND() limit 0,10";

  $manufacturers = $db->Execute($manufacturers_query);

  if ($manufacturers->RecordCount() > 0) {
    while (!$manufacturers->EOF) {
      if($manufacturers->fields['manufacturers_image'] != ''){
        $brands[] = array(
          'id'    => $manufacturers->fields['manufacturers_id'],
          'name'  => $manufacturers->fields['manufacturers_name'],
          'img'   => $manufacturers->fields['manufacturers_image'],
          'url'   => $manufacturers->fields['manufacturers_url']
        );

      }
    $manufacturers->MoveNext();
    }
  }

  $row = 0;
  $col = 0;
  foreach ($brands as $brand) {
    $list_box_contents[$row][$col] = array(
      'params'  => 'class="pt-carousel-item item-standard"',
      'text'    => '<div class="pt-carousel-item">' . zen_image(DIR_WS_IMAGES .  $brand['img'], $brand['name'], 240, 240, 'class="img-responsive"') . '</div>'
    );
  $col++;
  }

?>