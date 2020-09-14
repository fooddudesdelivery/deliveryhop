<?php
/**
 * Side Box Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2011 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_whats_new.php 18698 2011-05-04 14:50:06Z wilt $
 */
?>
<div class="widget widget-subscribe col-md-4 col-sm-12"> 
<h3 class="widget-title"><span><?php echo 'Follow Us' ?></span></h3> 
 <ul class="footer-social">  
  <?php if(true){ ?>
  <li><a href="<?php echo $data_themes['pt_store_facebook']; ?>" target="_blank" style="background-color:#3a5795"><i class="fa fa-facebook"></i></a></li>
  <?php } ?>
  <?php if(true){ ?>
  <li><a href="<?php echo $data_themes['pt_store_twitter']; ?>" target="_blank" style="background-color:#009fe9"><i class="fa fa-twitter"></i></a></li>
  <?php } ?>
  <?php if($data_themes['pt_store_google'] != ''){ ?>
  <li><a href="<?php echo $data_themes['pt_store_google']; ?>" target="_blank"><i class="fa fa-google-plus"></i></a></li>
  <?php } ?>
  <?php if($data_themes['pt_store_pinterest'] != ''){ ?>
  <li><a href="<?php echo $data_themes['pt_store_pinterest']; ?>" target="_blank"><i class="fa fa-pinterest"></i></a></li>
  <?php } ?>
  <?php if($data_themes['pt_store_instagram'] != ''){ ?>
  <li><a href="<?php echo $data_themes['pt_store_instagram']; ?>" target="_blank" style="background-color:#2f689b"><i class="fa fa-instagram"></i></a></li>
  <?php } ?>
  <?php if($data_themes['pt_store_youtube'] != ''){ ?>
  <li><a href="<?php echo $data_themes['pt_store_youtube']; ?>" target="_blank"><i class="fa fa-youtube"></i></a></li>
  <?php } ?>
  <?php if($data_themes['pt_store_skype'] != ''){ ?>
  <li><a href="<?php echo $data_themes['pt_store_skype']; ?>" target="_blank"><i class="fa fa-skype"></i></a></li>
  <?php } ?>
  </ul>

<?php 
      // BEGIN newsletter_subscribe mod 1/1
       if(defined('NEWSONLY_SUBSCRIPTION_ENABLED') &&
          (NEWSONLY_SUBSCRIPTION_ENABLED=='true') &&
          (NEWSONLY_SUBSCRIPTION_HEADER=='true')) {
           include(DIR_WS_MODULES . zen_get_module_directory(FILENAME_SUBSCRIBE_HEADER));
       }
      // END newsletter_subscribe mod 1/1    
      ?>

 


<!--  <input class="email" type="text" name="EMAIL" placeholder="Email Address" />
  <input type="hidden" name="EMAILTYPE" value="html" />
  <input class="btn button-default sub-btn" type="submit" value="Subscribe" name="submit" />
</form>-->
</div>