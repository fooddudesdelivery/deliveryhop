<?php
/**
 * Side Box Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_subscribe_header.php,v 1.1 2006/06/16 01:46:16 Owner Exp $
 */
  $content = '<h3 class="widget-title"><span>'. zen_decode_specialchars($data_themes['pt_mailchimp_title'][$_SESSION['languages_id']]).'</span></h3>'.  
'Enter your email address to join our newsletter</p>';
  $content .= zen_draw_form('subscribe', zen_href_link(FILENAME_SUBSCRIBE, '', 'SSL'), 'post', '');
  $content .= zen_draw_hidden_field('act', 'subscribe');
  $content .= zen_draw_hidden_field('main_page',FILENAME_SUBSCRIBE);

  $content .= '<label>' . zen_draw_input_field('email', '', 'size="25" style="float:none !important;height:40px;color:#393939; font-size: 14px;
    font-weight: 400;" maxlength="120" value="' . HEADER_SUBSCRIBE_DEFAULT_TEXT .
            '" onfocus="if (this.value == \'' . HEADER_SUBSCRIBE_DEFAULT_TEXT . '\') this.value = \'\';"');
  $content .= '</label>';
  if(EMAIL_USE_HTML == 'true') {
    $content .= '<label>' . zen_draw_radio_field('email_format', 'HTML', true) . ENTRY_EMAIL_HTML_DISPLAY . '</label>';
    $content .= '<label>' . zen_draw_radio_field('email_format', 'TEXT', false) . ENTRY_EMAIL_TEXT_DISPLAY . '</label>';
  }
  $content .= zen_image_submit (BUTTON_IMAGE_SUBSCRIBE,HEADER_SUBSCRIBE_BUTTON, 'value="' . HEADER_SUBSCRIBE_BUTTON . '" style="height:40px;margin-top:-4px;float:none;position:relative"');
  $content .= '</form>';
?>
