<?php
/**
 * Common Template - tpl_footer.php
 *
 * this file can be copied to /templates/your_template_dir/pagename<br />
 * example: to override the privacy page<br />
 * make a directory /templates/my_template/privacy<br />
 * copy /templates/templates_defaults/common/tpl_footer.php to /templates/my_template/privacy/tpl_footer.php<br />
 * to override the global settings and turn off the footer un-comment the following line:<br />
 * <br />
 * $flag_disable_footer = true;<br />
 *
 * @package templateSystem
 * @copyright Copyright 2003-2010 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_footer.php 15511 2010-02-18 07:19:44Z drbyte $
 */
require(DIR_WS_MODULES . zen_get_module_directory('footer.php'));
?>

<?php if (!isset($flag_disable_footer) || !$flag_disable_footer) { ?>

<footer id="footer" class="footer-wrap">

  <?php if($data_themes['pt_footer_top_status'] == 'true'){ ?>
	<section class="footer-top">
  		<div class="footer-inner section-content container">
    		<div class="row">
    			<!-- Bestsellers Footer -->
    			<?php require(DIR_WS_MODULES . 'footer/' . PT_NAME . '/best_sellers.php'); ?>
    			<!-- Bestsellers Footer -->
    			<!-- Featured Footer -->
    			<?php require(DIR_WS_MODULES . 'footer/' . PT_NAME . '/featured.php'); ?>
    			<!-- Featured Footer -->
          <div class="clearfix hidden-md hidden-lg"></div>
				  <!-- Latest Footer -->
    			<?php require(DIR_WS_MODULES . 'footer/' . PT_NAME . '/whats_new.php'); ?>
    			<!-- Latest Footer -->
    			<!-- Specials Footer -->
    			<?php require(DIR_WS_MODULES . 'footer/' . PT_NAME . '/specials.php'); ?>
    			<!-- Specials Footer -->
    		</div>
  		</div>
	</section>
  <?php } ?>

  <section class="footer-middle footer-dark">
    <div class="footer-inner section-content container">
      <div class="row">
        <?php 
          if($data_themes['pt_footer_first'] != ''){
            require($template->get_template_dir($data_themes['pt_footer_first'],DIR_WS_TEMPLATE, $current_page_base,'footer'). '/' . $data_themes['pt_footer_first']); 
          }
        ?> 
        <?php 
          if($data_themes['pt_footer_second'] != ''){
            require($template->get_template_dir($data_themes['pt_footer_second'],DIR_WS_TEMPLATE, $current_page_base,'footer'). '/' . $data_themes['pt_footer_second']); 
          }
        ?> 
        <?php 
          if($data_themes['pt_footer_third'] != ''){
            require($template->get_template_dir($data_themes['pt_footer_third'],DIR_WS_TEMPLATE, $current_page_base,'footer'). '/' . $data_themes['pt_footer_third']); 
          }
		  
        ?> 
      </div>
    </div>
  </section>

  <section class="footer-bottom">
    <div class="footer-inner container">
      <div class="copyright pull-left">
        <p>&copy; <?php echo date('Y'); ?> Food Dudes Delivery, LLC
		<?php //echo zen_decode_specialchars($data_themes['pt_footer_copyright'][$_SESSION['languages_id']]); ?></p>
      </div>
      <div class="widget-payment pull-right">
        <div class="payment-image"><img src="<?php echo $data_themes['pt_payment_available']; ?>" alt="" class="img-responsive"></div>
      </div>
    </div>
  </section>

</footer>

<?php if($data_themes['pt_backtop'] == 'true'){ ?>

<span id="back-top"><a href="#header"><i class="fa fa-angle-up"></i></a></span>
<?php } ?>

<?php
} // flag_disable_footer
?>
