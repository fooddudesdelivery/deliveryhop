<?php
/**
 * Page Template
 *
 * @package templateSystem Easy Sign-Up and Login
 * @copyright Copyright 2007-2008 Numinix Technology http://www.numinix.com
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_login_default.php 101 2010-01-28 20:50:41Z numinix $
 */
 
?>
<div style="min-height:390px">

<script>
$(document).ready(function(e) {
    $("#stateZoneShipping").children("option").each(function(index, element) {
        if($(this).text().toLowerCase()=='<?php echo strtolower($_SESSION['address_separated'][0]['state']) ?>'){
			$(this).attr('selected',true);
		}else{
			$(this).attr('selected',false);
		}
    });
	$("#shippingAddress-checkbox").attr("checked",true);
});
</script>
<?php
if(isset($_GET['error'])){
	echo'<script>$(document).ready(function(e) {$(".create-acct-legend").click();});</script>';
}

?>
<div id="centerColumn" class="fec-container">
    
    


    <?php if ($messageStack->size('login') > 0) echo $messageStack->output('login'); ?>
    
    <?php if (FEC_STATUS=='true' || FEC_EASY_SIGNUP_STATUS == 'true') { ?>
      <!-- BOF SHOPPING CART -->
      <?php
        if ($fec_order_total_enabled) {
          include(DIR_WS_TEMPLATE . 'templates/fec/tpl_modules_esl_ordertotal.php');
        } 
      ?>
      
      <!-- EOF SHOPPING CART -->
      <div id="easySignUp" class="fec-easy-sing-up">
          
         

        <div id="loginColumnLeft" class="fec-col-left">
            <!-- begin/login -->
            <fieldset class="fec-fieldset ">  
                <legend><?php echo HEADING_RETURNING_CUSTOMER_SPLIT; ?></legend>
                <span class="fec-fieldset-legend"><?php echo HEADING_RETURNING_CUSTOMER_SPLIT; ?></span>
                
                <?php echo zen_draw_form('login', zen_href_link(FILENAME_LOGIN, 'action=process', 'SSL')); ?>
                      
                      <fieldset>
                          <div class="fec-field">
                              <label class="inputLabel return-login" for="login-email-address"><?php echo ENTRY_EMAIL_ADDRESS; ?></label>
                              <?php echo zen_draw_input_field('email_address', '', 'size="25" id="login-email-address"'); ?>
                          </div>
                    
                          <div class="fec-field">
                              <label class="inputLabel return-login" for="login-password"><?php echo ENTRY_PASSWORD; ?></label>
                              <?php echo zen_draw_password_field('password', '', 'size="25" id="login-password"'); ?>
                          </div>
                          <?php 
                              if (PROJECT_VERSION_MAJOR > 1 || (PROJECT_VERSION_MAJOR == 1 && substr(PROJECT_VERSION_MINOR, 0, 3) >= 3.8)) { 
                                  echo zen_draw_hidden_field('securityToken', $_SESSION['securityToken']); 
                          }?>  
                                <br class="clearBoth" />
      <br class="clearBoth" />
                          <div class="buttonRow forward"><?php echo zen_image_submit(BUTTON_IMAGE_LOGIN, BUTTON_LOGIN_ALT); ?></div>
                                                                                                <div class="fec-important forgot_pass" ><?php echo '<a href="' . zen_href_link(FILENAME_PASSWORD_FORGOTTEN, '', 'SSL') . '">' . TEXT_PASSWORD_FORGOTTEN . '</a>'; ?></div>

                          <?php    
  // OneAll Social Login
 // require ($template->get_template_dir ('tpl_oneallsociallogin_widget.php', DIR_WS_TEMPLATE, $current_page_base, 'templates') . '/tpl_oneallsociallogin_widget.php');
?>
                      </fieldset>
                        
                </form> 

            </fieldset>

            <!-- end/login -->
            
            <!-- BOF CHECKOUT/CONFIDENCE -->
            <?php 
                if (FEC_CONFIDENCE == 'true') {
            ?> 
                    <fieldset class="fec-fieldset fec-confidence">
                        <legend><?php echo HEADING_CONFIDENCE; ?></legend>
                        <span class="fec-fieldset-legend"><?php echo HEADING_CONFIDENCE; ?></span>
                        
                        <div class="fec-information"><?php echo TEXT_CONFIDENCE; ?></div>
                    </fieldset>
            <?php } ?>
            <!-- EOF CHECKOUT/CONFIDENCE -->

        </div> <!-- end columnRight -->



	 <div id="loginColumnRight" class="fec-col-right">
          <!-- BEGIN CHECKOUT WITHOUT ACCOUNT -->
          <?php
              if (FEC_NOACCOUNT_SWITCH == 'true' && FEC_NOACCOUNT_POSITION == 'top') {
              
                  if ($_SESSION['cart']->count_contents() > 0) { ?>
                      <fieldset class="fec-fieldset">
                          <legend><?php echo COWOA_HEADING; ?></legend>
                          <span class="fec-fieldset-legend"><?php echo COWOA_HEADING; ?></span>

                          <div class="information"><?php echo TEXT_RATHER_COWOA; ?></div>

                          <div class="buttonRow forward">
                              <?php echo "<a href=\"" . zen_href_link(FILENAME_NO_ACCOUNT, '', 'SSL') . "\">"; ?>
                              <?php echo zen_image_button(BUTTON_IMAGE_CONTINUE, BUTTON_CONTINUE_ALT); ?></a>
                          </div>
                      </fieldset>
    	    <?php }} ?>
    	    <!-- END CHECKOUT WITHOUT ACCOUNT -->

    	    <!--BOF PPEC split login- DO NOT REMOVE-->
<!--	<p id="createAcctDefaultLoginLink" style="display:none"><?php // echo sprintf(TEXT_ORIGIN_LOGIN, zen_href_link(FILENAME_LOGIN, zen_get_all_get_params(array('action')), 'SSL')); ?></p> -->
    	    <fieldset class="fec-fieldset">
      	    	<legend data-target=".login_collapse " data-toggle="collapse" class="create-acct-legend"><?php echo HEADING_NEW_CUSTOMER_SPLIT; ?></legend>
      	    	<span class="fec-fieldset-legend"><?php echo HEADING_NEW_CUSTOMER_SPLIT; ?></span>
      	    	
              <?php if ($_SESSION['cart']->count_contents() > 0) { ?>

      	    	<?php } else { ?>
    
      	    	<?php } ?>
      	    	
      	    	<?php echo zen_draw_form('create_account', zen_href_link(FILENAME_LOGIN, '', 'SSL'), 'post', ' class="create_acct_form"') . '<div>' . zen_draw_hidden_field('action', 'process') . zen_draw_hidden_field('email_format', $email_format); ?>
                    <?php require($template->get_template_dir('tpl_modules_create_account.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_create_account.php'); ?>
      		    		      <div class="buttonRow forward login_collapse collapse">
							  <input type="submit"  value="Continue" class="btn create_account_btn">
							  </div>
      		    	   </div>
      	    	</form>
    	    </fieldset>
                        <!-- BEGIN GUEST CHECKOUT WITHOUT ACCOUNT -->
            <?php
              if (FEC_NOACCOUNT_SWITCH == 'true' && FEC_NOACCOUNT_POSITION == 'side') {
                if ($_SESSION['cart']->count_contents() > 0) { ?>
                  <fieldset class="fec-fieldset fec-no-account">
                     <?php echo "<a href=\"" . zen_href_link(FILENAME_NO_ACCOUNT, '', 'SSL') . "\">"; ?>
                             <legend><?php echo COWOA_HEADING; ?> </legend>
                             
                          </a>
                      

                  </fieldset>
            <?php }} ?>
            
            
                       <!-- BOF PAYPAL -->
            <?php // ** BEGIN PAYPAL EXPRESS CHECKOUT ** 
            ?>
                <?php 
                    if (defined('MODULE_PAYMENT_PAYPALWPP_ECS_BUTTON') && MODULE_PAYMENT_PAYPALWPP_ECS_BUTTON != 'Off' && false) {
                ?>
                        <fieldset class="fec-fieldset fec-paypal">
                            <legend data-toggle="collapse" data-target="#paypal-check"><?php echo HEADING_PAYPAL; ?></legend>
                            <div id="paypal-check" class="collapse">
                            <span class="fec-fieldset-legend"><?php echo HEADING_PAYPAL; ?></span>
                            
                            <div class="fec-information"><?php echo TEXT_PAYPAL_INTRODUCTION_SPLIT; ?></div>
                            
                            <div class="center"><?php require(DIR_FS_CATALOG . DIR_WS_MODULES . 'payment/paypal/tpl_ec_button.php'); ?></div>
                            </div>
                        </fieldset>
                <?php } ?>
            
            <?php // ** END PAYPAL EXPRESS CHECKOUT ** 
            
            ?>
            <!-- EOF PAYPAL -->
            <!-- END GUEST CHECKOUT WITHOUT ACCOUNT -->
        </div> 
        <!-- end columnLeft -->


        <!--EOF PPEC split login- DO NOT REMOVE-->
      </div>
    <?php } elseif (USE_SPLIT_LOGIN_MODE == 'True' || $ec_button_enabled) { ?>
      <!--BOF PPEC split login- DO NOT REMOVE-->
      <fieldset class="fec-fieldset fec-box">
          <legend><?php echo HEADING_NEW_CUSTOMER_SPLIT; ?></legend>
          <span class="fec-fieldset-legend"><?php echo HEADING_NEW_CUSTOMER_SPLIT; ?></span>
          <?php // ** BEGIN PAYPAL EXPRESS CHECKOUT ** ?>
          <?php if ($ec_button_enabled) { ?>
          <div class="fec-information"><?php echo TEXT_NEW_CUSTOMER_INTRODUCTION_SPLIT; ?></div>

          <div class="center"><?php require(DIR_FS_CATALOG . DIR_WS_MODULES . 'payment/paypal/tpl_ec_button.php'); ?></div>
          <hr />
      
          <?php echo TEXT_NEW_CUSTOMER_POST_INTRODUCTION_DIVIDER; ?>
          <?php } ?>
          <?php // ** END PAYPAL EXPRESS CHECKOUT ** ?>
          <div class="fec-information"><?php echo TEXT_NEW_CUSTOMER_POST_INTRODUCTION_SPLIT; ?></div>

          <?php echo zen_draw_form('create', zen_href_link(FILENAME_CREATE_ACCOUNT, '', 'SSL')); ?>
            <div class="buttonRow forward"><?php echo zen_image_submit(BUTTON_IMAGE_CREATE_ACCOUNT, BUTTON_CREATE_ACCOUNT_ALT); ?></div>
          </form>
      </fieldset>

      <fieldset class="fec-fieldset fec-box">
          <legend><?php echo HEADING_RETURNING_CUSTOMER_SPLIT; ?></legend>
          <span class="fec-fieldset-legend"><?php echo HEADING_RETURNING_CUSTOMER_SPLIT; ?></span>

          <div class="fec-information"><?php echo TEXT_RETURNING_CUSTOMER_SPLIT; ?></div>

          <?php echo zen_draw_form('login', zen_href_link(FILENAME_LOGIN, 'action=process', 'SSL')); ?>
              <label class="inputLabel return-login" for="login-email-address"><?php echo ENTRY_EMAIL_ADDRESS; ?></label>
              <?php echo zen_draw_input_field('email_address', '', 'size="18" id="login-email-address"'); ?>
              <br class="clearBoth" />

              <label class="inputLabel return-login" for="login-password"><?php echo ENTRY_PASSWORD; ?></label>
              <?php echo zen_draw_password_field('password', '', 'size="18" id="login-password"'); ?>
              <?php echo zen_draw_hidden_field('securityToken', $_SESSION['securityToken']); ?>
              <br class="clearBoth" />

              <div class="buttonRow forward"><?php echo zen_image_submit(BUTTON_IMAGE_LOGIN, BUTTON_LOGIN_ALT); ?></div>
              <div class="buttonRow back important"><?php echo '<a href="' . zen_href_link(FILENAME_PASSWORD_FORGOTTEN, '', 'SSL') . '">' . TEXT_PASSWORD_FORGOTTEN . '</a>'; ?></div>
          </form>
      </fieldset>
      <!--EOF PPEC split login- DO NOT REMOVE-->
    <?php } else { ?>
      <!--BOF normal login-->
      <?php
        if ($_SESSION['cart']->count_contents() > 0) {
      ?>
      <div class="advisory"><?php echo TEXT_VISITORS_CART; ?></div>
      <?php
        }
      ?>
      <?php echo zen_draw_form('login', zen_href_link(FILENAME_LOGIN, 'action=process', 'SSL')); ?>
      <fieldset class="fec-fieldset fec-box">
          <legend><?php echo HEADING_RETURNING_CUSTOMER; ?></legend>
          <span class="fec-fieldset-legend"><?php echo HEADING_RETURNING_CUSTOMER; ?></span>

          <label class="inputLabel return-login" for="login-email-address"><?php echo ENTRY_EMAIL_ADDRESS; ?></label>
          <?php echo zen_draw_input_field('email_address', '', zen_set_field_length(TABLE_CUSTOMERS, 'customers_email_address', '40') . ' id="login-email-address"'); ?>
          <div class="clearBoth"></div>
          <?php if (FEC_CONFIRM_EMAIL == 'true') { ?>
            <label class="inputLabel return-login" for="login-email-address-confirm"><?php echo ENTRY_EMAIL_ADDRESS_CONFIRM; ?></label>
            <?php echo zen_draw_input_field('email_address_confirm', '', zen_set_field_length(TABLE_CUSTOMERS, 'customers_email_address', '40') . ' id="login-email-address-confirm"'); ?>
            <div class="clearBoth"></div>    
          <?php } ?>
          <label class="inputLabel return-login" for="login-password"><?php echo ENTRY_PASSWORD; ?></label>
          <?php echo zen_draw_password_field('password', '', zen_set_field_length(TABLE_CUSTOMERS, 'customers_password') . ' id="login-password"'); ?>
          <div class="clearBoth"></div>
          <?php 
            if (PROJECT_VERSION_MAJOR > 1 || (PROJECT_VERSION_MAJOR == 1 && substr(PROJECT_VERSION_MINOR, 0, 3) >= 3.8)) { 
              echo zen_draw_hidden_field('securityToken', $_SESSION['securityToken']);
            }
          ?>
      </fieldset><br class="clearBoth" />
          <div class="buttonRow forward"><?php echo zen_image_submit(BUTTON_IMAGE_LOGIN, BUTTON_LOGIN_ALT); ?></div>
          <div class="buttonRow back important"><?php echo '<a href="' . zen_href_link(FILENAME_PASSWORD_FORGOTTEN, '', 'SSL') . '">' . TEXT_PASSWORD_FORGOTTEN . '</a>'; ?></div>
      </form>
      <br class="clearBoth" /><br class="clearBoth" />
      <!-- BEGIN CHECKOUT WITHOUT ACCOUNT -->
      <?php
        if (FEC_NOACCOUNT_SWITCH == 'true') {
          if ($_SESSION['cart']->count_contents() > 0) { ?>
             <fieldset class="fec-fieldset fec-box">
                  <legend>Checkout Without Account</legend>
                  <span class="fec-fieldset-legend"><?php echo HEADING_RETURNING_CUSTOMER; ?></span>
                  <?php echo TEXT_RATHER_COWOA; ?>
                  <div class="buttonRow forward">
                  <?php echo "<a href=\"" . zen_href_link(FILENAME_NO_ACCOUNT, '', 'SSL') . "\">"; ?>
                  <?php echo zen_image_button(BUTTON_IMAGE_CONTINUE, BUTTON_CONTINUE_ALT); ?></a></div>
                  <div class="clearBoth"></div>
            </fieldset>
      <?php }} ?>
      <!-- END CHECKOUT WITHOUT ACCOUNT -->
      <?php echo zen_draw_form('create_account', zen_href_link(FILENAME_CREATE_ACCOUNT, '', 'SSL'), 'post', 'onsubmit="return check_form(create_account);"') . '<div>' . zen_draw_hidden_field('action', 'process') . zen_draw_hidden_field('email_pref_html', 'email_format') . '</div>'; ?>
          <fieldset class="fec-fieldset fec-box">
              <legend><?php echo HEADING_NEW_CUSTOMER; ?></legend>
              <span class="fec-fieldset-legend"><?php echo HEADING_RETURNING_CUSTOMER; ?></span>

              <div class="fec-information"><?php echo TEXT_NEW_CUSTOMER_INTRODUCTION; ?></div>
              <?php require($template->get_template_dir('tpl_modules_create_account.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_create_account.php'); ?>
              </fieldset>
          <div class="buttonRow forward"><?php echo zen_image_submit(BUTTON_IMAGE_SUBMIT, BUTTON_SUBMIT_ALT); ?></div>
      </form>
      <!--EOF normal login-->
    <?php } ?>
      <br class="clearBoth" />
    </div>
     <?php
    // ** GOOGLE CHECKOUT **
    if (strtolower(MODULE_PAYMENT_GOOGLECHECKOUT_STATUS) == 'true') {
    ?>
      <div id="googleCheckout">
      <?php
        include(DIR_WS_MODULES . 'show_google_components.php');
      ?>
      </div>
      
      
      
    <?php
    }
    // ** END GOOGLE CHECKOUT **
    ?>
</div>