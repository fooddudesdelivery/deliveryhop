<?php
/**
 * Module Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2011 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_modules_main_product_image.php 18698 2011-05-04 14:50:06Z wilt $
 */
?>
<?php require(DIR_WS_MODULES . zen_get_module_directory(FILENAME_MAIN_PRODUCT_IMAGE)); ?>
<?php require(DIR_WS_MODULES . zen_get_module_directory('additional_images.php')); ?>

<div id="productMainImage" class="img-carousel owl-carousel">
	<div class="image-item" data-parent="0">
		<?php echo zen_image($products_image_medium, $products_name, MEDIUM_IMAGE_WIDTH, MEDIUM_IMAGE_HEIGHT, 'class="img-responsive" itemprop="image"'); ?>
		<a href="<?php echo $products_image_large; ?>" class="image-zoom image-popup" data-toggle="pt-tooltip" title="<?php echo TEXT_ZOOM; ?>"><i class="fa fa-expand"></i></a>
	</div>
	<?php if ($flag_show_product_info_additional_images != 0 && $num_images > 0) { ?>
		<?php $i = 1; ?>
		<?php foreach ($list_box_contents[0] as $image) { ?>
			<div class="image-item" data-parent="<?php echo $i; ?>">
				<?php echo $image['text_medium']; ?>
				<a href="<?php echo $image['src']; ?>" class="image-zoom image-popup" data-toggle="pt-tooltip" title="<?php echo TEXT_ZOOM; ?>"><i class="fa fa-expand"></i></a>
			</div>
			<?php $i++; ?>
		<?php } ?>
	<?php } ?>
</div>
<?php if ($flag_show_product_info_additional_images != 0 && $num_images > 0) { ?>
<div id="productAdditionalImage" class="img-thumb owl-carousel">
	<div class="image-item" data-child="0">
		<a href="#" data-target="0"><?php echo zen_image($products_image_medium, $products_name, MEDIUM_IMAGE_WIDTH, MEDIUM_IMAGE_HEIGHT, 'class="img-responsive"'); ?></a>
	</div>	
	<?php $j = 1; ?>
	<?php foreach ($list_box_contents[0] as $image) { ?>
		<div class="image-item" data-child="<?php echo $j; ?>">
			<a href="#" data-target="<?php echo $j; ?>"><?php echo $image['text_medium']; ?></a>
		</div>
		<?php $j++; ?>
	<?php } ?>
</div>
<?php } ?>	
