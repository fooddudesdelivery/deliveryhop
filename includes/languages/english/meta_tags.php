<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2013 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version GIT: $Id: Author: DrByte  Fri Feb 1 21:08:47 2013 -0500 Modified in v1.5.2 $
 */

// page title
define('TITLE', 'Online Food Delivery Services | Order Food Online | Food Dudes');

// Site Tagline
define('SITE_TAGLINE', '');

// Custom Keywords
define('CUSTOM_KEYWORDS', 'food delivery, food delivery service, online food delivery, order food online, food dudes');

// Home Page Only:
  define('HOME_PAGE_META_DESCRIPTION', 'Food Dudes Delivery is an Online Restaurant Food Delivery Company. We work with Restaurant Partners and deliver their Food to  homes, offices, and hotels.');
  define('HOME_PAGE_META_KEYWORDS', 'food delivery, food delivery service, online food delivery, order food online, food dudes');

  // NOTE: If HOME_PAGE_TITLE is left blank (default) then TITLE and SITE_TAGLINE will be used instead.
  define('HOME_PAGE_TITLE', ''); // usually best left blank


// EZ-Pages meta-tags.  Follow this pattern for all ez-pages for which you desire custom metatags. Replace the # with ezpage id.
// If you wish to use defaults for any of the 3 items for a given page, simply do not define it.
// (ie: the Title tag is best not set, so that site-wide defaults can be used.)
// repeat pattern as necessary
//  define('META_TAG_DESCRIPTION_EZPAGE_#','');
//  define('META_TAG_KEYWORDS_EZPAGE_#','');
//  define('META_TAG_TITLE_EZPAGE_#', '');

// Per-Page meta-tags. Follow this pattern for individual pages you wish to override. This is useful mainly for additional pages.
// replace "page_name" with the UPPERCASE name of your main_page= value, such as ABOUT_US or SHIPPINGINFO etc.
// repeat pattern as necessary
//  define('META_TAG_DESCRIPTION_page_name','');
//  define('META_TAG_KEYWORDS_page_name','');
//  define('META_TAG_TITLE_page_name', '');
  
  define('META_TAG_DESCRIPTION_DRIVER','The more you drive, the more you earn. Whether your looking for a part time gig or full time work, being a Food Dudes Driver Partner is a great opportunity for all.');
//define('META_TAG_KEYWORDS_DRIVER','');  
  define('META_TAG_TITLE_DRIVER', 'Become a Food Dudes Delivery Driver | Work at Food Dudes');
  
//  define('META_TAG_DESCRIPTION_RESTAURANT','');
  define('META_TAG_KEYWORDS_RESTAURANT','delivery restaurants, restaurants that deliver, food places that deliver, places that deliver');
  define('META_TAG_TITLE_RESTAURANT', 'Delivery Restaurants | Restaurants + Food Places that Deliver');

  define('META_TAG_DESCRIPTION_CONTACT_US','Food Dudes Delivery is a restaurant delivery service with locations throughout the Midwest. Contact us today at 800-599-5770.');
  define('META_TAG_KEYWORDS_CONTACT_US','food delivery companies, contact food dudes, food dudes phone number');
  define('META_TAG_TITLE_CONTACT_US', 'Food Delivery Companies | Contact Food Dudes, Phone Number');

// Review Page can have a lead in:
  define('META_TAGS_REVIEW', 'Reviews: ');

// separators for meta tag definitions
// Define Primary Section Output
  define('PRIMARY_SECTION', ' | ');

// Define Secondary Section Output
  define('SECONDARY_SECTION', ' | ');

// Define Tertiary Section Output
  define('TERTIARY_SECTION', ' | ');

// Define divider ... usually just a space or a comma plus a space
  define('METATAGS_DIVIDER', ' | ');

// Define which pages to tell robots/spiders not to index
// This is generally used for account-management pages or typical SSL pages, and usually doesn't need to be touched.
  define('ROBOTS_PAGES_TO_SKIP','login,logoff,create_account,account,account_edit,account_history,account_history_info,account_newsletters,account_notifications,account_password,address_book,advanced_search,advanced_search_result,checkout_success,checkout_process,checkout_shipping,checkout_payment,checkout_confirmation,cookie_usage,create_account_success,contact_us,download,download_timeout,customers_authorization,down_for_maintenance,password_forgotten,time_out,unsubscribe,info_shopping_cart,gv_faq,gv_redeem,gv_send,popup_image,popup_image_additional,product_reviews_write,ssl_check,shopping_cart,no_account,order_status');


