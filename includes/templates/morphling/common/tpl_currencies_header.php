<?php
/**
 * @package Pepper Themes Framework
 * @copyright Copyright 2012 - 2014 Pepper Themes
 * @author IronLady
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 */

$currency = pt_get_currency($_SESSION['currency']);

?>
<li class="currencies-top top-dd"><a href="<?php echo zen_href_link($_GET['main_page'], zen_get_all_get_params(array('language', 'currency')) . 'currency=' . $_SESSION['currency'], $request_type); ?>"><span class="cur-symbol"><?php echo $currency['symbol_left']; ?><?php echo $currency['symbol_right']; ?></span> <?php echo $currency['title']; ?></a>
	<ul>
	<?php foreach ($currencies_array as $curr) { ?>
		<li><a href="<?php echo zen_href_link($_GET['main_page'], zen_get_all_get_params(array('language', 'currency')) . 'currency=' . $curr['id'], $request_type); ?>"><span class="cur-symbol"><?php echo $curr['symbol']; ?></span> <?php echo $curr['title']; ?></a></li>
	<?php } ?>
	</ul>
</li>