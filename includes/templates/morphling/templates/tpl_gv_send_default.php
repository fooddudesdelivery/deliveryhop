<?php
/**
 * Page Template
 *
 * Template used to collect/display details of sending a GV to a friend from own GV balance. <br />
 *
 * @package templateSystem
 * @copyright Copyright 2003-2011 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_gv_send_default.php 18695 2011-05-04 05:24:19Z drbyte $
 */
?>
<div class="centerColumn" id="gvSendDefault">

<div id="sendSpendWrapper">
<!--<h2><?php echo TEXT_AVAILABLE_BALANCE;?></h2>-->
<h5 id="gvSendDefaultBalance" class="text-danger"><?php echo TEXT_BALANCE_IS . $gv_current_balance; ?></h5>
<?php
  if ($gv_result->fields['amount'] > 0 && $_GET['action'] == 'doneprocess') {
?>
<p><?php echo TEXT_SEND_ANOTHER; ?></p>

<div class="buttonRow pull-left"><a href="<?php echo zen_href_link(FILENAME_GV_SEND, '', 'SSL', false); ?>" class="pt-button"><?php echo BUTTON_SEND_ANOTHER_ALT; ?></a></div>
<br class="clearBoth">
<?php
    }
?>
</div>
<?php
  if ($_GET['action'] == 'doneprocess') {
?>
<!--BOF GV sent success-->

<h1 id="gvSendDefaultHeadingDone" class="page-default-heading"><?php echo HEADING_TITLE_COMPLETED; ?></h1>

<p id="gvSendDefaultContentSuccess" class="content"><?php echo TEXT_SUCCESS; ?></p>

<div class="buttonRow pull-left"><a href="<?php echo zen_href_link(FILENAME_ACCOUNT, '', 'SSL', false); ?>" class="pt-button"><?php echo BUTTON_CONTINUE_ALT; ?></a></div>
<!--EOF GV sent success -->
<?php
  }
  if ($_GET['action'] == 'send' && !$error) {
?>
<!--BOF GV send confirm -->

<h1 id="gvSendDefaultHeadingConfirm" class="page-default-heading"><?php echo HEADING_TITLE_CONFIRM_SEND; ?></h1>

<?php echo zen_draw_form('gv_send_process', zen_href_link(FILENAME_GV_SEND, 'action=process', 'SSL', false)); ?>
<p id="gvSendDefaultMainMessage" class="content"><?php echo sprintf(MAIN_MESSAGE, $currencies->format($_POST['amount'], false), $_POST['to_name'], $_POST['email']); ?></p>

<p id="gvSendDefaultMessageSecondary" class="content"><?php echo sprintf(SECONDARY_MESSAGE, $_POST['to_name'], $currencies->format($_POST['amount'], false), $send_name); ?></p>
<?php
    if ($_POST['message']) {
?>

<p id="gvSendDefaultMessagePersonal" class="content"><?php echo sprintf(PERSONAL_MESSAGE, $send_firstname); ?></p>

<p id="gvSendDefaultMessage" class="content"><?php echo stripslashes($_POST['message']); ?></p>
<?php
    }

    echo zen_draw_hidden_field('to_name', stripslashes($_POST['to_name'])) . zen_draw_hidden_field('email', $_POST['email']) . zen_draw_hidden_field('amount', $gv_amount) . zen_draw_hidden_field('message', stripslashes($_POST['message']));
?>

<div class="buttonRow pull-left"><input type="submit" value="<?php echo BUTTON_CONFIRM_SEND_ALT; ?>" class="pt-button"></div>


</form>
<br class="clearBoth" />

<!--<p class="advisory"><?php //echo EMAIL_ADVISORY_INCLUDED_WARNING . str_replace('-----', '', EMAIL_ADVISORY); ?></p>-->
<!--EOF GV send confirm -->
<?php
  } elseif ($_GET['action']=='' || $error) {
?>
<!--BOF GV send-->
<!--<h1 id="gvSendDefaultHeadingSend" class="page-default-heading"><?php echo HEADING_TITLE; ?></h1>-->


<br class="clearBoth" />
<?php if ($messageStack->size('gv_send') > 0) echo $messageStack->output('gv_send'); ?>

<?php echo zen_draw_form('gv_send_send', zen_href_link(FILENAME_GV_SEND, 'action=send', 'SSL', false)); ?>

<fieldset>
<legend><?php echo HEADING_TITLE; ?></legend>
<p id="gvSendDefaultMainContent" class="content"><?php echo HEADING_TEXT; ?></p>
<div class="form-group">
  <label class="inputLabel" for="to-name"><?php echo ENTRY_NAME; ?></label>
  <?php echo zen_draw_input_field('to_name', $_POST['to_name'], 'size="40" id="to-name"') . '<span class="alert form-alert text-danger">' . ENTRY_REQUIRED_SYMBOL . '</span>';?>
</div>

<div class="form-group">
  <label class="inputLabel" for="email-address"><?php echo ENTRY_EMAIL; ?></label>
  <?php echo zen_draw_input_field('email', $_POST['email'], 'size="40" id="email-address"') . '<span class="alert form-alert text-danger">' . ENTRY_REQUIRED_SYMBOL . '</span>'; if ($error) echo $error_email; ?>
</div>

<div class="form-group">
  <label class="inputLabel" for="amount"><?php echo ENTRY_AMOUNT; ?></label>
  <?php echo zen_draw_input_field('amount', $_POST['amount'], 'id="amount"', 'text', false) . '<span class="alert form-alert text-danger">' . ENTRY_REQUIRED_SYMBOL . '</span>'; if ($error) echo $error_amount; ?>
</div>

<div class="form-group">
<label class="inputLabel" for="message-area"><?php echo ENTRY_MESSAGE; ?></label>
<?php echo zen_draw_textarea_field('message', 50, 10, stripslashes($_POST['message']), 'id="message-area"'); ?>
</div>
</fieldset>
<br class="clearBoth" />
<div class="buttonRow pull-left"><input type="submit" value="<?php echo BUTTON_SEND_ALT; ?>" class="pt-button"></div>
<!--<div class="buttonRow pull-left"><a href="<?php //echo zen_back_link(true); ?>" class="pt-button"><?php echo BUTTON_BACK_ALT; ?></a></div>-->
<br class="clearBoth" />
</form>

<!--<p class="advisory"><?php //echo EMAIL_ADVISORY_INCLUDED_WARNING . str_replace('-----', '', EMAIL_ADVISORY); ?></p>-->
<?php
  }
?>
<!--EOF GV send-->
</div>