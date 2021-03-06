<?php
/**
 * Module Template
 *
 * Allows entry of new addresses during checkout stages
 *
 * @package templateSystem
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_modules_checkout_new_address.php 4683 2006-10-07 06:11:53Z drbyte $
 */
?>
<div class="centerColumnModule" id="checkoutNewAddress">
<fieldset>
<legend><?php echo TITLE_PLEASE_SELECT; ?></legend>
<p class="text-danger hiddenField"><?php echo FORM_REQUIRED_INFORMATION; ?></p>
<br class="clearBoth" />

<?php
  if (ACCOUNT_GENDER == 'true') {
?>
<div class="account-radio">
  <label class="radioButtonLabel radio-inline" for="gender-male">
    <?php echo zen_draw_radio_field('gender', 'm', '', 'id="gender-male"') . MALE; ?>
  </label>
  <label class="radioButtonLabel radio-inline" for="gender-female">
    <?php echo zen_draw_radio_field('gender', 'f', '', 'id="gender-female"') . FEMALE; ?>
  </label>
  <?php echo (zen_not_null(ENTRY_GENDER_TEXT) ? '<span class="alert form-alert text-danger">' . ENTRY_GENDER_TEXT . '</span>': ''); ?>
</div>
<br class="clearBoth" />
<?php
  }
?>

<div class="form-group">
  <label class="inputLabel" for="firstname"><?php echo ENTRY_FIRST_NAME; ?></label>
  <?php echo zen_draw_input_field('firstname', '', zen_set_field_length(TABLE_CUSTOMERS, 'customers_firstname', '40') . ' id="firstname"') . (zen_not_null(ENTRY_FIRST_NAME_TEXT) ? '<span class="alert form-alert text-danger">' . ENTRY_FIRST_NAME_TEXT . '</span>': ''); ?>
</div>

<div class="form-group">
  <label class="inputLabel" for="lastname"><?php echo ENTRY_LAST_NAME; ?></label>
  <?php echo zen_draw_input_field('lastname', '', zen_set_field_length(TABLE_CUSTOMERS, 'customers_lastname', '40') . ' id="lastname"') . (zen_not_null(ENTRY_LAST_NAME_TEXT) ? '<span class="alert form-alert text-danger">' . ENTRY_LAST_NAME_TEXT . '</span>': ''); ?>
</div>

<?php
  if (ACCOUNT_COMPANY == 'true') {
?>
<div class="form-group">
  <label class="inputLabel" for="company"><?php echo ENTRY_COMPANY; ?></label>
  <?php echo zen_draw_input_field('company', '', zen_set_field_length(TABLE_ADDRESS_BOOK, 'entry_company', '40') . ' id="company"') . (zen_not_null(ENTRY_COMPANY_TEXT) ? '<span class="alert form-alert text-danger">' . ENTRY_COMPANY_TEXT . '</span>': ''); ?>
</div>
<?php
  }
?>

<div class="form-group">
  <label class="inputLabel" for="street-address"><?php echo ENTRY_STREET_ADDRESS; ?></label>
  <?php echo zen_draw_input_field('street_address', '', zen_set_field_length(TABLE_ADDRESS_BOOK, 'entry_street_address', '40') . ' id="street-address"') . (zen_not_null(ENTRY_STREET_ADDRESS_TEXT) ? '<span class="alert form-alert text-danger">' . ENTRY_STREET_ADDRESS_TEXT . '</span>': ''); ?>
</div>

<?php
  if (ACCOUNT_SUBURB == 'true') {
?>
<div class="form-group">
  <label class="inputLabel" for="suburb"><?php echo ENTRY_SUBURB; ?></label>
  <?php echo zen_draw_input_field('suburb', '', zen_set_field_length(TABLE_ADDRESS_BOOK, 'entry_suburb', '40') . ' id="suburb"') . (zen_not_null(ENTRY_SUBURB_TEXT) ? '<span class="alert form-alert text-danger">' . ENTRY_SUBURB_TEXT . '</span>': ''); ?>
</div>
<?php
  }
?>

<div class="form-group">
  <label class="inputLabel" for="city"><?php echo ENTRY_CITY; ?></label>
  <?php echo zen_draw_input_field('city', '', zen_set_field_length(TABLE_ADDRESS_BOOK, 'entry_city', '40') . ' id="city"') . (zen_not_null(ENTRY_CITY_TEXT) ? '<span class="alert form-alert text-danger">' . ENTRY_CITY_TEXT . '</span>': ''); ?>
</div>

<?php
  if (ACCOUNT_STATE == 'true') {
    if ($flag_show_pulldown_states == true) {
?>
<div class="form-group">
  <label class="inputLabel" for="stateZone" id="zoneLabel"><?php echo ENTRY_STATE; ?></label>
  <?php
    echo zen_draw_pull_down_menu('zone_id', zen_prepare_country_zones_pull_down($selected_country), $zone_id, 'id="stateZone"');
    if (zen_not_null(ENTRY_STATE_TEXT)) echo '&nbsp;<span class="alert form-alert text-danger">' . ENTRY_STATE_TEXT . '</span>'; 
  ?>
</div>
<?php } ?>

<?php if ($flag_show_pulldown_states == true) { ?>

<?php } ?>
<div class="form-group hiddenField">
  <label class="inputLabel" for="state" id="stateLabel"><?php echo $state_field_label; ?></label>
  <?php
    echo zen_draw_input_field('state', '', zen_set_field_length(TABLE_ADDRESS_BOOK, 'entry_state', '40') . ' id="state"');
    if (zen_not_null(ENTRY_STATE_TEXT)) echo '&nbsp;<span class="alert form-alert text-danger" id="stText">' . ENTRY_STATE_TEXT . '</span>';
    if ($flag_show_pulldown_states == false) {
      echo zen_draw_hidden_field('zone_id', $zone_name, ' ');
    }
  ?>
</div>
<?php
  }
?>

<div class="form-group">
  <label class="inputLabel" for="postcode"><?php echo ENTRY_POST_CODE; ?></label>
  <?php echo zen_draw_input_field('postcode', '', zen_set_field_length(TABLE_ADDRESS_BOOK, 'entry_postcode', '40') . ' id="postcode"') . (zen_not_null(ENTRY_POST_CODE_TEXT) ? '<span class="alert form-alert text-danger">' . ENTRY_POST_CODE_TEXT . '</span>': ''); ?>
</div>

<div class="form-group hiddenField">
  <label class="inputLabel " for="country"><?php echo ENTRY_COUNTRY; ?></label>
  <?php echo zen_get_country_list('zone_country_id', $selected_country, 'id="country" ' . ($flag_show_pulldown_states == true ? 'onchange="update_zone(this.form);"' : '')) . (zen_not_null(ENTRY_COUNTRY_TEXT) ? '<span class="alert form-alert text-danger">' . ENTRY_COUNTRY_TEXT . '</span>': ''); ?>
</div>

</fieldset>
</div>