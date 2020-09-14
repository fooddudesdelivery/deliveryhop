<?php
/**
 * Edit_Cart
 *
 * Edit an existing product by removing it before it hits the add to cart action
 * Author: Justin Hunt http://www.kuroobiya.com 20071120
 * Version: 1.1
 */

// intercept add_product actions and if the edit_item_id paramater is set, 
//If set, remove that item from cart, and proceed to add it again
if (($_GET['action'] == 'edit_product_in_cart')) {
//	$_SESSION['cart']->actionAddProduct($goto, $parameters);
	


    global $messageStack, $db;

    if (isset($_POST['products_id']) && is_numeric($_POST['products_id'])) {

      // verify attributes and quantity first

      $the_list = '';

      $adjust_max= 'false';

      if (isset($_POST['id'])) {

        foreach ($_POST['id'] as $key => $value) {

          $check = zen_get_attributes_valid($_POST['products_id'], $key, $value);

          if ($check == false) {

            $the_list .= TEXT_ERROR_OPTION_FOR . '<span class="alertBlack">' . zen_options_name($key) . '</span>' . TEXT_INVALID_SELECTION . '<span class="alertBlack">' . (zen_values_name($value) == 'TEXT' ? TEXT_INVALID_USER_INPUT : zen_values_name($value)) . '</span>' . '<br />';

          }

        }

      }

      // verify qty to add

//          $real_ids = $_POST['id'];



      $add_max = zen_get_products_quantity_order_max($_POST['products_id']);

      $cart_qty = $_SESSION['cart']->in_cart_mixed($_POST['products_id']);
	  
	
      $new_qty = $_POST['cart_quantity'];
     
     //here we adjust the existing cart quantity because we are going to remove existig items shortly   
      $cart_qty= $cart_qty-$new_qty;

//die('I see Add to Cart: ' . $_POST['products_id'] . 'real id ' . zen_get_uprid($_POST['products_id'], $real_ids) . ' add qty: ' . $add_max . ' - cart qty: ' . $cart_qty . ' - newqty: ' . $new_qty);

//echo 'I SEE actionAddProduct: ' . $_POST['products_id'] . '<br>';

$new_qty = $_SESSION['cart']->adjust_quantity($new_qty, $_POST['products_id'], 'shopping_cart');




      if (($add_max == 1 and $cart_qty == 1)) 
    {

    // do not add
    $new_qty = 0;
    $adjust_max= 'true';

      } else {

             // adjust quantity if needed

             if (($new_qty + $cart_qty > $add_max) and $add_max != 0) 
                {
                  $adjust_max= 'true';
                  $new_qty = $add_max - $cart_qty;
                }

    }
  
      if ((zen_get_products_quantity_order_max($_POST['products_id']) == 1 and $_SESSION['cart']->in_cart_mixed($_POST['products_id']) == 1)) {

        // do not add

      } else {

        // process normally

        // bof: set error message

        if ($the_list != '') {

          $messageStack->add('product_info', ERROR_CORRECTIONS_HEADING . $the_list, 'caution');

//          $messageStack->add('header', 'REMOVE ME IN SHOPPING CART CLASS BEFORE RELEASE<br/><BR />' . ERROR_CORRECTIONS_HEADING . $the_list, 'error');

        } else {

          // process normally

          // iii 030813 added: File uploading: save uploaded files with unique file names

          $real_ids = isset($_POST['id']) ? $_POST['id'] : "";

          if (isset($_GET['number_of_uploads']) && $_GET['number_of_uploads'] > 0) {

            /**

             * Need the upload class for attribute type that allows user uploads.

             *

             */

            include(DIR_WS_CLASSES . 'upload.php');

            for ($i = 1, $n = $_GET['number_of_uploads']; $i <= $n; $i++) {

              if (zen_not_null($_FILES['id']['tmp_name'][TEXT_PREFIX . $_POST[UPLOAD_PREFIX . $i]]) and ($_FILES['id']['tmp_name'][TEXT_PREFIX . $_POST[UPLOAD_PREFIX . $i]] != 'none')) {

                $products_options_file = new upload('id');

                $products_options_file->set_destination(DIR_FS_UPLOADS);

                $products_options_file->set_output_messages('session');

                if ($products_options_file->parse(TEXT_PREFIX . $_POST[UPLOAD_PREFIX . $i])) {

                  $products_image_extension = substr($products_options_file->filename, strrpos($products_options_file->filename, '.'));

                  if ($_SESSION['customer_id']) {

                    $db->Execute("insert into " . TABLE_FILES_UPLOADED . " (sesskey, customers_id, files_uploaded_name) values('" . zen_session_id() . "', '" . $_SESSION['customer_id'] . "', '" . zen_db_input($products_options_file->filename) . "')");

                  } else {

                    $db->Execute("insert into " . TABLE_FILES_UPLOADED . " (sesskey, files_uploaded_name) values('" . zen_session_id() . "', '" . zen_db_input($products_options_file->filename) . "')");

                  }

                  $insert_id = $db->Insert_ID();

                  $real_ids[TEXT_PREFIX . $_POST[UPLOAD_PREFIX . $i]] = $insert_id . ". " . $products_options_file->filename;

                  $products_options_file->set_filename("$insert_id" . $products_image_extension);

                  if (!($products_options_file->save())) {

                    break;

                  }

                } else {

                  break;

                }

              } else { // No file uploaded -- use previous value

                $real_ids[TEXT_PREFIX . $_POST[UPLOAD_PREFIX . $i]] = $_POST[TEXT_PREFIX . UPLOAD_PREFIX . $i];

              }

            }

          }


          //edited in version 1-2 by elkay on 12.07.2008
if ($_POST['edit_item_id'] != zen_get_uprid($_POST['products_id'], $real_ids)) 
          $_SESSION['cart']->add_cart($_POST['products_id'], $_SESSION['cart']->get_quantity(zen_get_uprid($_POST['products_id'], $real_ids))+($new_qty), $real_ids);
else 
     $_SESSION['cart']->add_cart($_POST['products_id'], $_SESSION['cart']->get_quantity(zen_get_uprid($_POST['products_id'], $real_ids)), $real_ids);
        //edit elkay end
     

          // iii 030813 end of changes.

        } // eof: set error message

      } // eof: quantity maximum = 1



      if ($adjust_max == 'true') {

        $messageStack->add_session('shopping_cart', ERROR_MAXIMUM_QTY . ' B: - ' . zen_get_products_name($_POST['products_id']), 'caution');

      }

    }

    if ($the_list == '') {

      // no errors

// display message if all is good and not on shopping_cart page

      if (DISPLAY_CART == 'false' && $_GET['main_page'] != FILENAME_SHOPPING_CART) {

        $messageStack->add_session('header', SUCCESS_ADDED_TO_CART_PRODUCT, 'success');

      }
	  //remove the existing item
/*line added by elkay with v1-2 on 12.07.2008*/  if ($_POST['edit_item_id'] != zen_get_uprid($_POST['products_id'], $real_ids)) 
	  $_SESSION['cart']->remove($_POST['edit_item_id']);
	  //head off to our destination

    
     zen_redirect(zen_href_link(FILENAME_SHOPPING_CART));

    } else {

      // errors - display popup message

    }

	
	
}


?>