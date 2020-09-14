<?php
  //NOTE: Edit this first line with the name of your gift card brand, e.g. 'Gift Express', or the name of your company.
  define('MODULE_ORDER_TOTAL_GIFTCARD_BRAND', '');
  define('MODULE_ORDER_TOTAL_GIFTCARD_TITLE', MODULE_ORDER_TOTAL_GIFTCARD_BRAND .' Gift Card');
  
  define('MODULE_ORDER_TOTAL_GIFTCARD_HEADER', 'Gift Card');
  define('MODULE_ORDER_TOTAL_GIFTCARD_DESCRIPTION', MODULE_ORDER_TOTAL_GIFTCARD_TITLE);
  define('GIFTCARD_SHIPPING_NOT_INCLUDED', ' [Shipping not included]');
  define('GIFTCARD_TAX_NOT_INCLUDED', ' [Tax not included]');
  define('MODULE_ORDER_TOTAL_GIFTCARD_TEXT_ENTER_CODE', 'Gift Card Number:');
  define('GIFTCARD_TEXT_INVALID_REDEEM_AMOUNT', 'It appears that the amount you have tried to apply and your gift card balance do not match. Please try again.');
  define('MODULE_ORDER_TOTAL_GIFTCARD_USER_BALANCE', 'Available Balance: ');
  define('MODULE_ORDER_TOTAL_GIFTCARD_INCLUDE_ERROR', ' Setting Include tax = true, should only happen when recalculate = None');
  define('IMAGE_REDEEM_GIFTCARD', 'Redeem Gift Card');
  define('MODULE_ORDER_TOTAL_GIFTCARD_REDEEM_INSTRUCTIONS', '<p>To use a gift card please enter the gift card number in the box and click update. Note: only one per order.</p>');
  define('MODULE_ORDER_TOTAL_GIFTCARD_REDEEM_BOX', 'true');
  define('MODULE_ORDER_TOTAL_GIFTCARD_TEXT_CURRENT_CODE', 'Your Current Gift Card Number: ');
  define('MODULE_ORDER_TOTAL_GIFTCARD_REMOVE_INSTRUCTIONS', '<p>To remove a gift card from this order type REMOVE and press Enter or Return</p>');
  define('TEXT_REMOVE_REDEEM_GIFTCARD', 'Gift Card Removed by Request!');
  define('NAVBAR_TITLE', '');
  define('HEADING_TITLE', '');
  define('TEXT_INFORMATION', '');
  define('TEXT_GIFTCARD_NUMBER_FAILED', '<span class="alert important">%s</span> This gift card number does not appear to be valid. Please try typing it in again.');
  define('TEXT_GIFTCARD_BALANCE_ZERO', '<span class="alert important">%s</span> This gift card does not appear to have any funds available.  The balance remaining is zero.');
  define('TEXT_GIFTCARD_INACTIVE', '<span class="alert important">%s</span> It appears this gift card is not activated in our system.  Please contact us if you think you have reached this message in error.');
  define('HEADING_GIFTCARD_HELP', 'Gift Card Help');
  define('TEXT_CLOSE_WINDOW', 'Close Window [x]');
  define('TEXT_GIFTCARD_HELP_HEADER', '<p class="bold">The Gift Card Number you have entered is for ');
  define('TEXT_GIFTCARD_HELP_NAME', '\'%s\'. </p>');
  define('TEXT_GIFTCARD_HELP_FIXED', '');
  define('TEXT_GIFTCARD_HELP_MINORDER', '');
  define('TEXT_GIFTCARD_HELP_FREESHIP', '');
  define('TEXT_GIFTCARD_HELP_DESC', '<p><span class="bold">Giftcard:</span> %s</p><p class="smallText">Certain other restrictions may apply. Please see below for other details.</p>');
  define('TEXT_GIFTCARD_HELP_RESTRICT', '<p class="biggerText bold">Gift Card Restrictions</p>');
  define('TEXT_GIFTCARD_HELP_CATEGORIES', '<p class="bold">Category Restrictions:</p>');
  define('TEXT_GIFTCARD_HELP_PRODUCTS', '<p class="bold">Item Restrictions:</p>');
  define('TEXT_ALLOW', 'Allow');
  define('TEXT_DENY', 'Deny');
  define('TEXT_NO_CAT_RESTRICTIONS', '<p>This gift card is valid for all categories.</p>');
  define('TEXT_NO_PROD_RESTRICTIONS', '<p>This gift card is valid for all items.</p>');
  define('TEXT_CAT_ALLOWED', ' (Valid for this category)');
  define('TEXT_CAT_DENIED', ' (Not allowed on this category)');
  define('TEXT_PROD_ALLOWED', ' (Valid for this item)');
  define('TEXT_PROD_DENIED', ' (Not allowed item)');
  // giftcards cannot be purchased with giftcards
  define('TEXT_GIFTCARD_RESTRICTION','<p class="smallText">Gift cards may not be applied towards the purchase of other gift cards. Limit 1 gift card per order.</p>');
  define('TEXT_GIFTCARD_ID_INFO', 'Look-up Gift Card ... ');
  define('TEXT_GIFTCARD_ID', 'Your Number: ');
  define('TEXT_GIFTCARD_RESTRICTION_ZONES', 'Billing Address Restrictions apply.');

?>