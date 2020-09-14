<?php
/**
 * ot_giftcard order-total module
 *
 * @package orderTotal
 * @copyright Copyright 2008 T Zinni
 * @copyright Portions Copyright 2008 Zen Cart
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: ot_giftcard.php 1.5 tzinni $
 */
/**
 * This is the order total module for using plastic gift cards.
 *
 */
/*  How this module works:
 *   1. A text box group is displayed on the checkout page just below the coupon group.  The customer enters their card
 *      number AND selects an alternative payment method to cover overages.
 *   2. After submitting, the card is verified against the stored account profile for validity and available funds.
 *   3. The confirmation page is displayed showing applied amounts (all available gift card funds are applied first).
 *   4. IF the order balance is zero, the order is processed and the account is debited.  IF the order total has an
 *      overage, then the backup funding is charged first for the overage AND if successful, debits the gift card - otherwise
 *      nothing is debited.  The only exception is the when a customer uses check/money order as a backup source. Then
 *      the gift card is charged first. Note that if a customer fails to send the check/money order, you will still be
 *      responsible for fulfilling the portion of the order their gift card covered (prepaid money), and/or credit their account.
 *  What this module does:
 *    1. Processes the use of plastic (physical) gift cards issued by a store (no eCards)
 *    2. Allows for numeric or alphanumeric (+ hyphens/spaces) card numbers
 *    3. Allows for any length of card number (must be unique)
 *    4. Allows for masking of numbers on checkout pages and invoices
 *    5. Allows for displaying any number of digits (not just 4) in masks
 *    6. Allows for the use of tax zones
 *    7. Maintains card account balances by card number (not customer) - they are gifts after all
 *    8. Allows for admin activation/deactivation of card numbers to prevent theft
 *    9. Cancels transaction if secondary payment source fails for balances over card value
 *   10. Allows for any denomination (face value) of a card
 *   11. Allows using only one gift card per transaction by customer
 *   12. Allows any other payment provider to process order balances exceeding card balance
 *   13. Note: you can prevent the use of purchasing other giftcards through product restrictions.  Store Gift Cards ARE physical products.
 *   14. Allows for admin reporting of giftcard usage since data maintained in its own table
 *   15. Will not delete transaction data if module removed/reinstalled
 *       Note:  If a customer order is cancelled or deleted after processed, card account may need to be manually credited by admin.
 *  What this module does NOT do:
 *    1. Use CVS codes
 *    2. Send card info to a remote payment server (PayPal, etc.)
 *    3. Inform card holders of gift card remaining balances after a sale (will notify if not enough funds available during transaction only)
 *    4. Allow assignment of card to a particular customer (defeats purpose of "gift") - although you may use initial order # to track purchaser
 *    5. Issue numbers by email (use zen-cart's built in vouchers/certificates for eCards)
 *    6. Allow customer to verify balances by card number for security reasons (keygen testing) - have them call you with order #, card #, etc
 *    7. Interfere with other discounts, coupons, eCards, etc.
 *    8. Allow for recharging online for security reasons (validity test).  An admin can reset balances manually, however.
 *    9. Allow for expiration dates (not legal since these are prepaid funds)
* */

if (!defined('TABLE_GIFTCARDS')) define('TABLE_GIFTCARDS', DB_PREFIX . 'giftcards');

class ot_giftcard extends base {

  /**
   * The title for this module.
   *
   * @var string
   */
  var $title;

  /**
   * The output type of this module.
   *
   * @var mixed
   */
  var $output;


  /**
   * Init function
   * @return ot_giftcard
   */
  function ot_giftcard()
  {
    //global $currencies;
    $this->code = 'ot_giftcard';
    $this->title = MODULE_ORDER_TOTAL_GIFTCARD_TITLE;
    $this->header = MODULE_ORDER_TOTAL_GIFTCARD_HEADER;
    $this->description = MODULE_ORDER_TOTAL_GIFTCARD_DESCRIPTION;
    $this->user_prompt = ' '; //MODULE_ORDER_TOTAL_GIFTCARD_USER_PROMPT;
    $this->sort_order = MODULE_ORDER_TOTAL_GIFTCARD_SORT_ORDER;
    $this->include_shipping = MODULE_ORDER_TOTAL_GIFTCARD_INC_SHIPPING;
    $this->include_tax = MODULE_ORDER_TOTAL_GIFTCARD_INC_TAX;
    $this->calculate_tax = MODULE_ORDER_TOTAL_GIFTCARD_CALC_TAX;
    $this->credit_tax = MODULE_ORDER_TOTAL_GIFTCARD_CREDIT_TAX;
    $this->tax_class  = MODULE_ORDER_TOTAL_GIFTCARD_TAX_CLASS;
    $this->show_redeem_box = MODULE_ORDER_TOTAL_GIFTCARD_REDEEM_BOX;
    $this->credit_class = true;
    $this->mask_digits = MODULE_ORDER_TOTAL_GIFTCARD_MASK_DIGITS;
    $this->mask_char = MODULE_ORDER_TOTAL_GIFTCARD_MASK_CHAR;
    $this->mask_reveal = MODULE_ORDER_TOTAL_GIFTCARD_MASK_REVEAL;
    $this->checkbox = $this->user_prompt;
    if (IS_ADMIN_FLAG === true)
    {
      if ($this->include_tax == 'true' && $this->calculate_tax != "None")
      {
        $this->title .= '<span class="alert">' . MODULE_ORDER_TOTAL_GIFTCARD_INCLUDE_ERROR . '</span>';
      }
    }
  }


  /**
   * OK - the actual order processing init
   *
   */
  function process()
  {
    global $order, $currencies;
      $od_amount = $this->calculate_deductions($this->get_order_total());
      $this->deduction = $od_amount['total'];
      if ($od_amount['total'] > 0)
      {
        reset($order->info['tax_groups']);
        $tax = 0;
        while (list($key) = each($order->info['tax_groups']))
        {
          if ($od_amount['tax_groups'][$key])
          {
            $order->info['tax_groups'][$key] -= $od_amount['tax_groups'][$key];
            $tax += $od_amount['tax_groups'][$key];
          }
        }
        $order->info['total'] = $order->info['total'] - $od_amount['total'];
        if ($this->calculate_tax == "Standard")
        {
          $order->info['total'] -= $tax;
        }
        if ($order->info['total'] < 0)
        {
           $order->info['total'] = 0;
        }
        $order->info['tax'] = $order->info['tax'] - $od_amount['tax'];
        // prepare order-total output for display and storing to invoice
        $this->output[] = array('title' => $this->display_cardnum_on_invoice() . ':',
        'text' => '-' . $currencies->format($od_amount['total']),
        'value' => $od_amount['total']);

      }
  }


  /**
   * OK - This is called to reset any Giftcard values, effectively cancelling all Giftcards applied during current login session
   */
  function clear_posts()
  {
    unset($_SESSION['gcot_giftcard_num']);
    unset($_SESSION['gcot_giftcard_bal']);
  }


  /**
   * OK - Makes sure the user is logged in
   */
  function session_test()
  {
    if ($_SESSION['customer_id'])
    {
      return true;
    }
    else
    {
      return false;
    }
  }


  /**
   * OK - Check for validity of redemption amounts and recalculate order totals to include proposed Giftcard redemption deductions
   */
  function pre_confirmation_check($order_total)
  {
    if($this->collect_posts())
    {
       $od_amount = $this->calculate_deductions($order_total);
       return $od_amount['total'] + $od_amount['tax'];
    }
    else
    {
       return 0;
    }
  }


  /**
   * OK - allow display the input field to allow entry of Giftcard number
   */
  function use_credit_amount()
  {
    if ($this->session_test())
    {
      $output_string = $this->checkbox;
    }
    return $output_string;
  }


  /**
   * is this ever used - update Giftcard balances
   */
  function update_credit_account()
   {
    if ($this->session_test())
    {
       $this->update_giftcard_balance($_SESSION['gcot_giftcard_num']);
    }
  }


  /**
   * OK - display Giftcard umber input fields on checkout pages
   */
  function credit_selection()
  {
    // displays box controls if the current customer has any Giftcard balance
    if ($this->use_credit_amount())
    {
      $selection = array('id' => $this->code,
                         'module' => $this->title,
                         'redeem_instructions' => MODULE_ORDER_TOTAL_GIFTCARD_REDEEM_INSTRUCTIONS,
                         'checkbox' => $this->use_credit_amount(),
                         'fields' => array(array('title' => MODULE_ORDER_TOTAL_GIFTCARD_TEXT_ENTER_CODE,
                         'field' => zen_draw_input_field('gcard_redeem_code', '', 'id="gcard-'.$this->code.'" onkeyup="submitFunction(0,0)"'),
                         'tag' => 'gcard-'.$this->code
                         )));
    }
    return $selection;
  }


  /**
   * The last step in the process - initiated on page 3 when customer confirms order.
   */
  function apply_credit()
  {
      // obtain final "deduction" amount - make it a negative number
      $gcard_payment_amount = ($this->deduction * -1);
      // reduce Giftcard account balance by the amount redeemed
      $transtest = $this->update_giftcard_balance($_SESSION['gcot_giftcard_num'],$gcard_payment_amount);
      if ($transtest != false)
      {
        // clear Giftcard redemption flag since it's already been claimed and deducted
        $this->clear_posts();
        // send back the amount of Giftcard used for payment on this order (positive number)
        return $this->deduction;
      }
      else
      {
        return false;
      }
  }


  /**
   * OK -Check to see if redemption code has been entered and redeem if valid
   */
  function collect_posts()
  {
    global $messageStack;
    // if we have a Giftcard code submitted, process it
    if ($_POST['gcard_redeem_code'])
    {
      //save the number to the session
      $_SESSION['gcot_giftcard_num'] = strval($_POST['gcard_redeem_code']);
      //get a local var copy
      $gcard_code = $_SESSION['gcot_giftcard_num'];
      // check for validity
      $card_check = $this->get_giftcard_balance($gcard_code);
      switch ($card_check)
      {
       case false:
        //bad card number - return error
            $messageStack->add_session('checkout_payment', TEXT_GIFTCARD_NUMBER_FAILED, error);
            //reset payment options
            $this->clear_posts();
            //report error
            zen_redirect(zen_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL'));
            break;
       case '0.0000':
         //there are no funds available - return error
            $messageStack->add_session('checkout_payment', TEXT_GIFTCARD_BALANCE_ZERO, error);
            //reset payment options
            $this->clear_posts();
            //report error
            zen_redirect(zen_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL'));
         break;
       default:
         //the card number is valid and the balance is not zero - continue
         break;
      }

      //check if card is activated
      $gcard_status = $this->get_giftcard_status($gcard_code);
      switch ($gcard_status)
      {
        case true:
           //card ok - send back the balance
           return $card_check;
           break;
        case false:
           //card not active
           $messageStack->add_session('checkout_payment', TEXT_GIFTCARD_INACTIVE, error);
           //reset payment options
           $this->clear_posts();
           //report error
           zen_redirect(zen_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL'));
         break;
      }
    }
    else
    {
      //nothing happened
      return false;
    }
    //nothing happened
    return false;
  }


  /**
   * OK - Calculate pretax subtotal minus gift card funds
   */
  function calculate_credit($pretax_order_total)
  {
    global $currencies;
    // calculate value based on default currency
    $credit_amount = $currencies->value($_SESSION['gcot_giftcard_bal'], true, DEFAULT_CURRENCY);
    $subtotal = $pretax_order_total - $credit_amount;
    //see if gift card balance covers this
    if ($subtotal < 0)
    {
      //excess funds in card account
      $subtotal = 0;  //just a placeholder
      //amount of credit equals order total
      $credit_amount = $pretax_order_total;
    }
    //return the credited amount
    return zen_round($credit_amount,2);
  }

 /**
   * OK - Calculate post tax subtotals
   */
  function calculate_deductions($order_total)
  {
    global $order;
    $od_amount = array();
    $deduction = $this->calculate_credit($this->get_order_total());
    $od_amount['total'] = $deduction;
    switch ($this->calculate_tax)
    {
      case 'None':
        $remainder = $order->info['total'] - $od_amount['total'];
        $tax_deduct = $order->info['tax'] - $remainder;
        // division by 0
        if ($order->info['tax'] <= 0)
        {
          $ratio_tax = 0;
        }
        else
        {
          $ratio_tax = $tax_deduct/$order->info['tax'];
        }
        $tax_deduct = 0;
        if ($this->include_tax)
        {
          reset($order->info['tax_groups']);
          foreach ($order->info['tax_groups'] as $key=>$value)
          {
            $od_amount['tax_groups'][$key] = $order->info['tax_groups'][$key] * $ratio_tax;
            $tax_deduct += $od_amount['tax_groups'][$key];
          }
        }
        $od_amount['tax'] = $tax_deduct;
        break;
      case 'Standard':
         if ($od_amount['total'] >= $order_total)
         {
           $ratio = 1;
         }
         else
         {
           $ratio = ($od_amount['total'] / ($order_total - $order->info['tax']));
         }
         reset($order->info['tax_groups']);
         $tax_deduct = 0;
         foreach ($order->info['tax_groups'] as $key=>$value)
         {
           $od_amount['tax_groups'][$key] = $order->info['tax_groups'][$key] * $ratio;
           $tax_deduct += $od_amount['tax_groups'][$key];
         }
         $od_amount['tax'] = $tax_deduct;
         break;
      case 'Credit Note':
        $od_amount['total'] = $deduction;
        $tax_rate = zen_get_tax_rate($this->tax_class);
        $od_amount['tax'] = zen_calculate_tax($deduction, $tax_rate);
        $tax_description = zen_get_tax_description($this->tax_class);
        $od_amount['tax_groups'][$tax_description] = $od_amount['tax'];
         break;
         default:
    }
    return $od_amount;
  }


  /**
   * OK - Check to see whether current giftcard has a balance available
    /* Returns amount of giftcard balance on account
   */
  function get_order_total()
  {
    global $order;
    $order_total = $order->info['total'];

    // if we are not supposed to include tax in credit calculations, subtract it out
    if ($this->include_tax != 'true') $order_total -= $order->info['tax'];
    // if we are not supposed to include shipping amount in credit calcs, subtract it out
    if ($this->include_shipping != 'true') $order_total -= $order->info['shipping_cost'];

    $order_total = $order->info['total'];
    return $order_total;
  }


  /**
   * OK- Makes sure this module is installed.
   *
   * @return unknown
   */
  function check()
  {
    global $db;
    if (!isset($this->check))
    {
      $check_query = $db->Execute("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_ORDER_TOTAL_GIFTCARD_STATUS'");
      $this->check = $check_query->RecordCount();
    }
    return $this->check;
  }


  /**
   * OK - Used by the uninstaller
   *
   * @return unknown
   */
  function keys()
  {
    return array('MODULE_ORDER_TOTAL_GIFTCARD_STATUS', 'MODULE_ORDER_TOTAL_GIFTCARD_SORT_ORDER', 'MODULE_ORDER_TOTAL_GIFTCARD_INC_TAX', 'MODULE_ORDER_TOTAL_GIFTCARD_CALC_TAX', 'MODULE_ORDER_TOTAL_GIFTCARD_TAX_CLASS', 'MODULE_ORDER_TOTAL_GIFTCARD_CREDIT_TAX', 'MODULE_ORDER_TOTAL_GIFTCARD_MASK_REVEAL', 'MODULE_ORDER_TOTAL_GIFTCARD_MASK_CHAR', 'MODULE_ORDER_TOTAL_GIFTCARD_MASK_DIGITS', 'MODULE_ORDER_TOTAL_GIFTCARD_INC_SHIPPING',  'MODULE_ORDER_TOTAL_GIFTCARD_ORDER_STATUS_ID');
  }


  /**
   *
   * OK - sets configuration vars and creates custom tables in the db
   */
  function install()
  {
    global $db;
    //set configuration vars
    $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('This module is installed', 'MODULE_ORDER_TOTAL_GIFTCARD_STATUS', 'true', '', '6', '1','zen_cfg_select_option(array(\\'true\\'), ', now())");
    $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_ORDER_TOTAL_GIFTCARD_SORT_ORDER', '850', 'Sort order of display.', '6', '2', now())");
    $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function ,date_added) values ('Include Shipping', 'MODULE_ORDER_TOTAL_GIFTCARD_INC_SHIPPING', 'true', 'Include Shipping in calculation', '6', '4', 'zen_cfg_select_option(array(\\'true\\', \\'false\\'), ', now())");
    $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function ,date_added) values ('Include Tax', 'MODULE_ORDER_TOTAL_GIFTCARD_INC_TAX', 'true', 'Include Tax in calculation.', '6', '5','zen_cfg_select_option(array(\\'true\\', \\'false\\'), ', now())");
    $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function ,date_added) values ('Re-calculate Tax', 'MODULE_ORDER_TOTAL_GIFTCARD_CALC_TAX', 'None', 'Re-Calculate Tax', '6', '6','zen_cfg_select_option(array(\\'None\\', \\'Standard\\', \\'Credit Note\\'), ', now())");
    $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('Tax Class', 'MODULE_ORDER_TOTAL_GIFTCARD_TAX_CLASS', '0', 'Use the following tax class when treating Gift Card as Credit Note.', '6', '3', 'zen_get_tax_class_title', 'zen_cfg_pull_down_tax_classes(', now())");
    $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function ,date_added) values ('Credit including Tax', 'MODULE_ORDER_TOTAL_GIFTCARD_CREDIT_TAX', 'false', 'Add tax to purchased Gift Card when crediting to Account', '6', '7','zen_cfg_select_option(array(\\'true\\', \\'false\\'), ', now())");
    $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, use_function, date_added) values ('Set Order Status', 'MODULE_ORDER_TOTAL_GIFTCARD_ORDER_STATUS_ID', '2', 'Set the status of orders made where Gift Card covers full payment', '6', '9', 'zen_cfg_pull_down_order_statuses(', 'zen_get_order_status_name', now())");
    $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function ,date_added) values ('Mask Digits', 'MODULE_ORDER_TOTAL_GIFTCARD_MASK_DIGITS', 'true', 'Mask card number digits on customer invoice.', '6', '10','zen_cfg_select_option(array(\\'true\\', \\'false\\'), ', now())");
    $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Mask Char', 'MODULE_ORDER_TOTAL_GIFTCARD_MASK_CHAR', '*', 'Set the printed character used to mask digits', '6', '11', now())");
    $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Reveal # Char (-1 = all)', 'MODULE_ORDER_TOTAL_GIFTCARD_MASK_REVEAL', '4', 'The number of card number digits revealed on invoice', '6', '12', now())");

    //create the StoreGiftCards table - forget if already there
 $tblsql = "CREATE TABLE IF NOT EXISTS " . TABLE_GIFTCARDS . " (
  giftcard_id integer unsigned NOT NULL AUTO_INCREMENT,
  giftcard_code varchar(32) NOT NULL,
  giftcard_value decimal(15,4) NOT NULL default '0.0000',
  giftcard_balance decimal(15,4) NOT NULL default '0.0000',
  sale_order varchar(32) default NULL,
  comments text default NULL,
  giftcard_active char(1) NOT NULL default 'N',
  date_created datetime NOT NULL default '2008-01-01 00:00:00',
  date_modified datetime NOT NULL default '2008-01-01 00:00:00',
  giftcard_zone_restriction integer unsigned NOT NULL default '0',
  PRIMARY KEY  (giftcard_id))";
    $db->Execute($tblsql);
  }

   /**
   * OK - Determines if card number masking is used and applies result using regex
   */
  function display_cardnum_on_invoice()
  {
  if ($this->mask_digits == true)
  {
     //make sure not set to show all digits
     if ($this->mask_reveal != '-1')
     {
     //accept #,upper, lower, dash, space in unlimited length but leave $mask_show chars revealed at end
       $pattern = '/^([0-9,a-z,A-Z- ]+)([0-9,a-z,A-Z-]{'.$this->mask_reveal.'})$/';
       $matches = array();
       $gcard = $_SESSION['gcot_giftcard_num'];
       preg_match($pattern, $gcard, $matches);
       $newformat = preg_replace('([0-9,a-z,A-Z])', $this->mask_char, $matches[1]).$matches[2];
       //set the constant
       return MODULE_ORDER_TOTAL_GIFTCARD_TITLE .' ' .$newformat;
     }
     else
     {
      //show whole number on invoice
        return MODULE_ORDER_TOTAL_GIFTCARD_TITLE .' ' .$_SESSION['gcot_giftcard_num'];
     }
  }
  else
  {
     //show whole number on invoice
     return MODULE_ORDER_TOTAL_GIFTCARD_TITLE .' ' .$_SESSION['gcot_giftcard_num'];
  }
  }


  /**
   * OK - The uninstaller - does not remove custom created tables tables or disturb data
   */
  function remove()
  {
    global $db;
    $db->Execute("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
  }

    /**
   * OK - updates the gift card remaining balance
   * returns new balance if successful or false if failed
   */
  function update_giftcard_balance($giftcard_code,$credit_amount = 0)
  {
    $giftcard_code = preg_replace('/[^0-9a-zA-Z- ]/', '', $giftcard_code);
    //note: credit_amount should be a negative number for a deduction (sale), positive for a debit (sale credit or recharge)
    global $db;
    //get the original account balance
    $original_giftcard_query = "select giftcard_balance from " . TABLE_GIFTCARDS . " where giftcard_code = '" . strval($giftcard_code). "'";

    $original_giftcard_amount = $db->Execute($original_giftcard_query);

    if ($original_giftcard_amount->RecordCount() > 0)
    {
      $new_giftcard_amount = $original_giftcard_amount->fields['giftcard_balance'] + $credit_amount;
      $giftcard_query = "update " . TABLE_GIFTCARDS . " set giftcard_balance = '" . $new_giftcard_amount . "' where giftcard_code = '" . strval($giftcard_code) . "'";

      $db->Execute($giftcard_query);
      //report success
      return $new_giftcard_amount;
    }
     else
    {
      //report error
      return false;
    }
  }

    /**
   * OK - Retrieves the gift card account balance remaining
   */
  function get_giftcard_balance($giftcard_code)
  {
    $giftcard_code = preg_replace('/[^0-9a-zA-Z- ]/', '', $giftcard_code);
    global $db;
    //make sure it is our customer asking
    if ($this->session_test())
    {
      //retrieve account balance from db
       $giftcard_result = $db->Execute("select giftcard_balance from " . TABLE_GIFTCARDS . " where giftcard_code = '" . strval($giftcard_code) . "'");
       if ($giftcard_result->RecordCount() > 0)
       {
           //check that it has available funds
          if ($giftcard_result->fields['giftcard_balance'] > 0)
          {
            //save the balance to the session
            $_SESSION['gcot_giftcard_bal'] = $giftcard_result->fields['giftcard_balance'];
            //return a positive balance
             return $_SESSION['gcot_giftcard_bal'];
          }
          else
          {
             //no funds available
             $_SESSION['gcot_giftcard_bal'] = '0.0000';
             return '0.0000';
          }
       }
       else
       {
         //card number not found
         return false;
       }
    }
    else
    {
      //user not logged in
      return false;
    }
  }

  /**
   * OK - Retrieves if gift card has been activated or disabled
   */
  function get_giftcard_status($giftcard_code)
   {
     $giftcard_code = preg_replace('/[^0-9a-zA-Z- ]/', '', $giftcard_code);
      global $db;
      //make sure it is our customer asking
      if ($_SESSION['customer_id'])
      {
         //get the activation status from the db
         $giftcard_result = $db->Execute("select giftcard_active from " . TABLE_GIFTCARDS . " where giftcard_code = '" . strval($giftcard_code) . "'");
         if ($giftcard_result->RecordCount() > 0)
         {
            if ($giftcard_result->fields['giftcard_active'] == 'Y')
            {
               //the card is activated
               return true;
            }
            else
            {
              //the card is not activated
              return false;
            }
         }
         else
         {
           //card number not found
            return false;
         }
      }
      else
      {
        //user not logged in
         return false;
      }
   }
}
