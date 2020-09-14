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
<div class="widget widget-store-contact  col-md-4 col-sm-12">  

 
  <h3 class="widget-title"><span><?php echo zen_decode_specialchars($data_themes['pt_store_about_content'][$_SESSION['languages_id']]); ?></span></h3> 
 
<ul>
    <li><span class="contact-dd"><a href="index.php?main_page=contact_us">Contact Us</a></span></li>
    <li><span class="contact-dd"><a href="index.php?main_page=faqs">FAQs</a></span></li>
    <?php //if($_SESSION['fooddudestaging_login']){ ?>
    <li><span class="contact-dd"><a href="index.php?main_page=rewards">Rewards</a></span></li>
    <li><span class="contact-dd"><a href="index.php?main_page=giftcards">Gift Cards</a></span></li>
    <li><span class="contact-dd"><a href="index.php?main_page=terms">Terms of Use</a></span></li>
    <li><span class="contact-dd"><a href="index.php?main_page=privacy">Privacy Policy</a></span></li>
    
    <?php //} ?>

</ul>
<!-- <span>-->

<!-- <?php $array_footer= json_decode(base64_decode($data_themes['pt_store_about_content'][$_SESSION['languages_id']]),true); ?></span>
 <?php  if(is_array($array_footer)){ ?>
 <ul>
 	<?php  foreach($array_footer as $key => $val){ ?>
    <li><span class="contact-dd"><a href="<?php //echo $val ?>"><?php //echo $key  ?></a></span></li>
    <?php  }} ?>
</ul>
 -->
 
 
 
 
<!-- 
  <ul class="footer-social">
  <?php if($data_themes['pt_store_facebook'] != ''){ ?>
  <li><a href="<?php //echo $data_themes['pt_store_facebook']; ?>" target="_blank"><i class="fa fa-facebook"></i></a></li>
  <?php } ?>
  <?php if($data_themes['pt_store_twitter'] != ''){ ?>
  <li><a href="<?php //echo $data_themes['pt_store_twitter']; ?>" target="_blank" style="background-color:#009fe9"><i class="fa fa-twitter"></i></a></li>
  <?php } ?>
  <?php if($data_themes['pt_store_google'] != ''){ ?>
  <li><a href="<?php //echo $data_themes['pt_store_google']; ?>" target="_blank"><i class="fa fa-google-plus"></i></a></li>
  <?php } ?>
  <?php if($data_themes['pt_store_pinterest'] != ''){ ?>
  <li><a href="<?php //echo $data_themes['pt_store_pinterest']; ?>" target="_blank"><i class="fa fa-pinterest"></i></a></li>
  <?php } ?>
  <?php if($data_themes['pt_store_instagram'] != ''){ ?>
  <li><a href="<?php //echo $data_themes['pt_store_instagram']; ?>" target="_blank"><i class="fa fa-instagram"></i></a></li>
  <?php } ?>
  <?php if($data_themes['pt_store_youtube'] != ''){ ?>
  <li><a href="<?php //echo $data_themes['pt_store_youtube']; ?>" target="_blank"><i class="fa fa-youtube"></i></a></li>
  <?php } ?>
  <?php if($data_themes['pt_store_skype'] != ''){ ?>
  <li><a href="<?php //echo $data_themes['pt_store_skype']; ?>" target="_blank"><i class="fa fa-skype"></i></a></li>
  <?php } ?>
  </ul>-->
</div>