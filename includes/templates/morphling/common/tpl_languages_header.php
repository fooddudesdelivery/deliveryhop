<?php
/**
 * @package Pepper Themes Framework
 * @copyright Copyright 2012 - 2014 Pepper Themes
 * @author IronLady
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 */

?>
<li class="languages-top top-dd"><a href="<?php echo zen_href_link($_GET['main_page'], zen_get_all_get_params(array('language', 'currency')) . 'language=' . pt_get_language_code($_SESSION['languages_id']), $request_type); ?>"><i class="flag en"></i> <?php echo pt_get_language_name($_SESSION['languages_id']); ?></a>
  <ul>
    <?php foreach ($lng->catalog_languages as $key => $value) { ?>
      <li><a href="<?php echo zen_href_link($_GET['main_page'], zen_get_all_get_params(array('language', 'currency')) . 'language=' . $key, $request_type); ?>"><i class="flag <?php echo $key; ?>"></i> <?php echo $value['name']; ?></a></li>
    <?php } ?>
  </ul>
</li>