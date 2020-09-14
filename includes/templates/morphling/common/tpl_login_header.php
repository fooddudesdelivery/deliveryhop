<?php
/**
 * Common Template - tpl_login_header.php
 *
 *
 * @package Pepper Framework 
 * @copyright Copyright 2009-2014 Pepper Themes
 * @copyright Portions Copyright 2003-2012 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 */

require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . FILENAME_LOGIN . '.php'); 
?>

<div id="login-popup" class="pt-popup pt-paddingless mfp-hide">
  <div class="login-popup-head">
    <div class="popup-title">Login</div>
    <ul class="nav nav-tabs pt-nav-tabs" role="tablist">
      <li class="active"><a href="#login-content" role="tab" data-toggle="tab">My Account</a></li>
      <li><a href="<?php echo zen_href_link('login');  ?>" role="tab" >Sign Up</a></li>
    </ul>
  </div>
  <div class="login-popup-content tab-content">
    <div class="tab-pane fade in active" id="login-content">
      <?php echo zen_draw_form('login', zen_href_link(FILENAME_LOGIN, 'action=process', 'SSL'), 'post', 'id="loginForm" class="form-horizontal" role="form"'); ?>
        <div class="form-group">
          <input id="login-email-address" class="form-control" type="email" name="email_address" placeholder="<?php echo str_replace(':', '', ENTRY_EMAIL_ADDRESS); ?>">
        </div>
        <div class="form-group">
          <input id="login-password" class="form-control" type="password" name="password" placeholder="<?php echo str_replace(':', '', ENTRY_PASSWORD); ?>">
        </div>
        
        <div class="form-group">
          <button type="submit" class="pt-button pt-button-c pt-button-s"><?php echo BUTTON_LOGIN_ALT; ?></button>
        </div>

              <div class="form-group">
 <a href="<?php echo zen_href_link(FILENAME_PASSWORD_FORGOTTEN, '', 'SSL'); ?>"> <?php echo TEXT_PASSWORD_FORGOTTEN; ?></a>    
</div>
<!--<div style="margin-left:-15px">
                                      <?php    
  // OneAll Social Login
//  require ($template->get_template_dir ('tpl_oneallsociallogin_widget.php', DIR_WS_TEMPLATE, $current_page_base, 'templates') . '/tpl_oneallsociallogin_widget.php');
?>
</div>-->
      </form>
    </div>

    <div class="tab-pane fade" id="register-content">
      <p class="information"><?php echo TEXT_NEW_CUSTOMER_POST_INTRODUCTION_SPLIT; ?></p>
      <a href="<?php echo zen_href_link(FILENAME_CREATE_ACCOUNT, '', 'SSL'); ?>" id="register-button" class="pt-button pt-button-c pt-button-s"><?php echo BUTTON_CREATE_ACCOUNT_ALT; ?></a>
    </div>
  </div>
</div>