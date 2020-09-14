<?php
/*
//////////////////////////////////////////////////////////
//  REDEEM COUPON FROM URL                              //
//                                                      //
//  By ResponsiveZencart.com                            //
//                                                      //
//  Released under the GNU General Public License       //
//  see "LICENSE.txt" in the downloaded zip             //
//////////////////////////////////////////////////////////
*/

  $message_stack_size = $messageStack->size('header');
  $session_cc_id = $_SESSION['cc_id'];

  function ot_coupon_get_order_total($couponCode) {
    global $order;
    $orderTaxGroups = $order->info['tax_groups'];
    $orderTotalTax = $order->info['tax'];
    $orderTotal = $order->info['total'];
    $products = $_SESSION['cart']->get_products();
    for ($i=0; $i<sizeof($products); $i++) {
      if (!is_product_valid($products[$i]['id'], $couponCode)) {
        $products_tax = zen_get_tax_rate($products[$i]['tax_class_id']);
        $productsTaxAmount = (zen_calculate_tax($products[$i]['final_price'], $products_tax))   * $products[$i]['quantity'];
        $orderTotal -= $products[$i]['final_price'] * $products[$i]['quantity'];
        if (MODULE_ORDER_TOTAL_COUPON_INC_TAX == 'true') {
         $orderTotal -= $productsTaxAmount;
        }
        if (DISPLAY_PRICE_WITH_TAX == 'true')
        {
          $orderTotal -= $productsTaxAmount;
        }
        $orderTaxGroups[zen_get_tax_description($products[$i]['tax_class_id'])] -= $productsTaxAmount;
        $orderTotalTax -= (zen_calculate_tax($products[$i]['final_price'], zen_get_tax_rate($products[$i]['tax_class_id'])))   * $products[$i]['quantity'];
      }
    }
    if (MODULE_ORDER_TOTAL_COUPON_INC_SHIPPING != 'true')
    {
      $orderTotal -= $order->info['shipping_cost'];
      if (isset($_SESSION['shipping_tax_description']) && $_SESSION['shipping_tax_description'] != '') 
      {
         $orderTaxGroups[$_SESSION['shipping_tax_description']] -= $order->info['shipping_tax']; 
         $orderTotalTax -= $order->info['shipping_tax']; 
      }
    }
    if (DISPLAY_PRICE_WITH_TAX != 'true')
    {
      $orderTotal -= $order->info['tax'];
    }
    return array('orderTotal'=>$orderTotal, 'orderTaxGroups'=>$orderTaxGroups, 'orderTax'=>$orderTotalTax, 'shipping'=>$order->info['shipping_cost'], 'shippingTax'=>$order->info['shipping_tax']);
  }

  function ot_coupon_clear_posts() {
    unset($_GET['coupon']);
    unset($_SESSION['cc_id']);
  }

  function ot_coupon_collect_posts() {
    global $db, $currencies, $messageStack, $order;
    global $discount_coupon;

    global $message_stack_size;
    global $session_cc_id;

    // remove discount coupon by request
    if (isset($_GET['coupon']) && strtoupper($_GET['coupon']) == 'REMOVE') {
      unset($_GET['coupon']);
      unset($_SESSION['cc_id']);
      //$messageStack->add_session('checkout_payment', TEXT_REMOVE_REDEEM_COUPON, 'caution');
      $messageStack->add('header', TEXT_REMOVE_REDEEM_COUPON_BY_URL, 'caution');
    }

    // bof: Discount Coupon zoned always validate coupon for payment address changes
    // eof: Discount Coupon zoned always validate coupon for payment address changes
    if ((isset($_GET['coupon']) && $_GET['coupon'] != '') || (isset($discount_coupon->fields['coupon_code']) && $discount_coupon->fields['coupon_code'] != '')) {
      // set current Discount Coupon based on current or existing
      if (isset($_GET['coupon']) && $discount_coupon->fields['coupon_code'] == '') {
        $dc_check = $_GET['coupon'];
      } else {
        $dc_check = $discount_coupon->fields['coupon_code'];
      }



      $sql = "select coupon_id, coupon_amount, coupon_type, coupon_minimum_order, uses_per_coupon, uses_per_user,
              restrict_to_products, restrict_to_categories, coupon_zone_restriction
              from " . TABLE_COUPONS . "
              where coupon_code= :couponCodeEntered
              and coupon_active='Y'
              and coupon_type !='G'";

      $sql = $db->bindVars($sql, ':couponCodeEntered', $dc_check, 'string');

      $coupon_result=$db->Execute($sql);

      if ($coupon_result->fields['coupon_type'] != 'G') {

        if ($coupon_result->RecordCount() < 1 ) {
          //$messageStack->add_session('redemptions', TEXT_INVALID_REDEEM_COUPON,'caution');
          $messageStack->add('header', TEXT_INVALID_REDEEM_COUPON,'caution');
          ot_coupon_clear_posts();
          //zen_redirect(zen_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL',true, false));
        }
        $order_total = ot_coupon_get_order_total($coupon_result->fields['coupon_id']);

/*
// left for total order amount vs qualified order amount just switch the commented lines
//        if ($order_total['totalFull'] < $coupon_result->fields['coupon_minimum_order']) {
        if (strval($order_total['orderTotal']) < $coupon_result->fields['coupon_minimum_order']) {

          //$messageStack->add_session('redemptions', sprintf(TEXT_INVALID_REDEEM_COUPON_MINIMUM, $currencies->format($coupon_result->fields['coupon_minimum_order'])),'caution');
          $messageStack->add('header', sprintf(TEXT_INVALID_REDEEM_COUPON_MINIMUM, $currencies->format($coupon_result->fields['coupon_minimum_order'])),'caution');
          ot_coupon_clear_posts();
          //zen_redirect(zen_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL',true, false));
        }
*/

        // JTD - added missing code here to handle coupon product restrictions
        // look through the items in the cart to see if this coupon is valid for any item in the cart
        $products = $_SESSION['cart']->get_products();
        $foundvalid = true;

        if ($foundvalid == true) {
          $foundvalid = false;
          for ($i=0; $i<sizeof($products); $i++) {
            if (is_product_valid($products[$i]['id'], $coupon_result->fields['coupon_id'])) {
              $foundvalid = true;
              continue;
            }
          }
        }

        if (!$foundvalid) {
          ot_coupon_clear_posts();
        }

        if (!$foundvalid && $_SESSION['cart']->count_contents()>0) {
          //zen_redirect(zen_href_link(FILENAME_CHECKOUT_PAYMENT, 'credit_class_error_code=' . $this->code . '&credit_class_error=' . urlencode(TEXT_INVALID_COUPON_PRODUCT . ' ' . $dc_check), 'SSL',true, false));
          $messageStack->add('header', TEXT_INVALID_COUPON_PRODUCT . ' ' . $dc_check,'caution');
        }
        // JTD - end of additions of missing code to handle coupon product restrictions

        $date_query=$db->Execute("select coupon_start_date from " . TABLE_COUPONS . "
                                  where coupon_start_date <= now() and
                                  coupon_code='" . zen_db_prepare_input($dc_check) . "'");

        if ($date_query->RecordCount() < 1 && $message_stack_size >= $messageStack->size('header')) {
          //$messageStack->add_session('redemptions', TEXT_INVALID_STARTDATE_COUPON,'caution');
          $messageStack->add('header', TEXT_INVALID_STARTDATE_COUPON,'caution');
          ot_coupon_clear_posts();
          //zen_redirect(zen_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL', true, false));
        }

        $date_query=$db->Execute("select coupon_expire_date from " . TABLE_COUPONS . "
                                  where coupon_expire_date >= now() and
                                  coupon_code='" . zen_db_prepare_input($dc_check) . "'");

        if ($date_query->RecordCount() < 1 && $message_stack_size >= $messageStack->size('header')) {
          //$messageStack->add_session('redemptions', TEXT_INVALID_FINISHDATE_COUPON,'caution');
          $messageStack->add('header', TEXT_INVALID_FINISHDATE_COUPON,'caution');
          ot_coupon_clear_posts();
          //zen_redirect(zen_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL', true, false));
        }

        $coupon_count = $db->Execute("select coupon_id from " . TABLE_COUPON_REDEEM_TRACK . "
                                      where coupon_id = '" . (int)$coupon_result->fields['coupon_id']."'");

        $coupon_count_customer = $db->Execute("select coupon_id from " . TABLE_COUPON_REDEEM_TRACK . "
                                               where coupon_id = '" . $coupon_result->fields['coupon_id']."' and
                                               customer_id = '" . (int)$_SESSION['customer_id'] . "'");

        if ($coupon_count->RecordCount() >= $coupon_result->fields['uses_per_coupon'] && $coupon_result->fields['uses_per_coupon'] > 0) {
          //$messageStack->add_session('redemptions', TEXT_INVALID_USES_COUPON . $coupon_result->fields['uses_per_coupon'] . TIMES ,'caution');
          $messageStack->add('header', TEXT_INVALID_USES_COUPON . $coupon_result->fields['uses_per_coupon'] . TIMES ,'caution');
          ot_coupon_clear_posts();
          //zen_redirect(zen_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL', true, false));
        }

        if ($coupon_count_customer->RecordCount() >= $coupon_result->fields['uses_per_user'] && $coupon_result->fields['uses_per_user'] > 0) {
          //$messageStack->add_session('redemptions', sprintf(TEXT_INVALID_USES_USER_COUPON, $dc_check) . $coupon_result->fields['uses_per_user'] . ($coupon_result->fields['uses_per_user'] == 1 ? TIME : TIMES) ,'caution');
          $messageStack->add('header', sprintf(TEXT_INVALID_USES_USER_COUPON, $dc_check) . $coupon_result->fields['uses_per_user'] . ($coupon_result->fields['uses_per_user'] == 1 ? TIME : TIMES) ,'caution');
          ot_coupon_clear_posts();
          //zen_redirect(zen_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL', true, false));
        }

        $_SESSION['cc_id'] = $coupon_result->fields['coupon_id'];
        if ($_SESSION['cc_id'] > 0) {
          $sql = "select coupon_id, coupon_amount, coupon_type, coupon_minimum_order, uses_per_coupon, uses_per_user,
                  restrict_to_products, restrict_to_categories, coupon_zone_restriction, coupon_code
                  from " . TABLE_COUPONS . "
                  where coupon_id= :couponIDEntered
                  and coupon_active='Y'";
          $sql = $db->bindVars($sql, ':couponIDEntered', $_SESSION['cc_id'], 'string');

          $coupon_result=$db->Execute($sql);

          $foundvalid = true;

          $check_flag = false;

          // base restrictions zone restrictions for Delivery or Billing address
          switch($coupon_result->fields['coupon_type']) {
            case 'S': // shipping
              // use delivery address
              $check_zone_country_id = $order->delivery['country']['id'];
              break;
            case 'F': // amount
              // use billing address
              $check_zone_country_id = $order->billing['country']['id'];
              break;
            case 'O': // amount off and free shipping
              // use delivery address
              $check_zone_country_id = $order->delivery['country']['id'];
              break;
            case 'P': // percentage
              // use billing address
              $check_zone_country_id = $order->billing['country']['id'];
              break;
            case 'E': // percentage and Free Shipping
              // use delivery address
              $check_zone_country_id = $order->delivery['country']['id'];
              break;
            default:
              // use billing address
              $check_zone_country_id = $order->billing['country']['id'];
              break;
          }

//          $sql = "select zone_id, zone_country_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . $coupon_result->fields['coupon_zone_restriction'] . "' and zone_country_id = '" . $order->billing['country']['id'] . "' order by zone_id";
          $sql = "select zone_id, zone_country_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . $coupon_result->fields['coupon_zone_restriction'] . "' and zone_country_id = '" . $check_zone_country_id . "' order by zone_id";
          $check = $db->Execute($sql);

          // base restrictions zone restrictions for Delivery or Billing address
          switch($coupon_result->fields['coupon_type']) {
            case 'S': // shipping
              // use delivery address
              $check_zone_id = $order->delivery['zone_id'];
              break;
            case 'F': // amount
              // use billing address
              $check_zone_id = $order->billing['zone_id'];
              break;
            case 'O': // amount off and free shipping
              // use delivery address
              $check_zone_id = $order->delivery['zone_id'];
              break;
            case 'P': // percentage
              // use billing address
              $check_zone_id = $order->billing['zone_id'];
              break;
            case 'E': // percentage and free shipping
              // use delivery address
              $check_zone_id = $order->delivery['zone_id'];
              break;
            default:
              // use billing address
              $check_zone_id = $order->billing['zone_id'];
              break;
          }

          if ($coupon_result->fields['coupon_zone_restriction'] > 0) {
            while (!$check->EOF) {
              if ($check->fields['zone_id'] < 1) {
                $check_flag = true;
                break;
//              } elseif ($check->fields['zone_id'] == $order->billing['zone_id']) {
              } elseif ($check->fields['zone_id'] == $check_zone_id) {
                $check_flag = true;
                break;
              }
              $check->MoveNext();
            }
            $foundvalid = $check_flag;
          }
          // remove if fails address validation
          if (!$foundvalid) {
            //$messageStack->add_session('checkout_payment', TEXT_REMOVE_REDEEM_COUPON_ZONE, 'caution');
            $messageStack->add('header', TEXT_REMOVE_REDEEM_COUPON_ZONE, 'caution');
            ot_coupon_clear_posts();
            if (!$foundvalid) {
              //zen_redirect(zen_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL',true, false));
            }
          } elseif ($session_cc_id != $_SESSION['cc_id'] && $message_stack_size >= $messageStack->size('header')) {
          //      if ($_POST['submit_redeem_coupon_x'] && !$_POST['gv_redeem_code']) zen_redirect(zen_href_link(FILENAME_CHECKOUT_PAYMENT, 'credit_class_error_code=' . $this->code . '&credit_class_error=' . urlencode(TEST_NO_REDEEM_CODE), 'SSL', true, false));
            $messageStack->add('header', TEXT_VALID_COUPON,'success');
          }
        }
      } else {
        //$messageStack->add_session('redemptions', TEXT_INVALID_REDEEM_COUPON,'caution');
        $messageStack->add('header', TEXT_INVALID_REDEEM_COUPON,'caution');
        ot_coupon_clear_posts();
        //zen_redirect(zen_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL',true, false));
      }

    }
  }

  ot_coupon_collect_posts();
