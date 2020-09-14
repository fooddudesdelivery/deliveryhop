<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=advanced_search.<br />
 * Displays options fields upon which a product search will be run
 *
 * @package templateSystem
 * @copyright Copyright 2003-2011 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_advanced_search_default.php 18695 2011-05-04 05:24:19Z drbyte $
 */
?>
<div class="centerColumn" id="advSearchDefault">

<?php echo zen_draw_form('advanced_search', zen_href_link(FILENAME_ADVANCED_SEARCH_RESULT, '', $request_type, false), 'get', 'onsubmit="return check_form(this);"') . zen_hide_session_id(); ?>
<?php echo zen_draw_hidden_field('main_page', FILENAME_ADVANCED_SEARCH_RESULT); ?>

<!--<h1 id="advSearchDefaultHeading"><?php echo HEADING_TITLE_1; ?></h1>-->

<?php if ($messageStack->size('search') > 0) echo $messageStack->output('search'); ?>

<div class="pull-right"><?php echo '<a href="' . zen_href_link(FILENAME_POPUP_SEARCH_HELP) .'"  data-toggle="pt-ajaxlightbox" class="page-popup pt-button pt-button-vs">' . TEXT_SEARCH_HELP_LINK . '</a>'; ?></div>
<br class="clearBoth" />

<fieldset>
    <legend><?php echo HEADING_SEARCH_CRITERIA; ?></legend>
    <div class="form-group">
        <?php echo zen_draw_input_field('keyword', '', 'placeholder="' . $sData['keyword'] . '"'); ?>&nbsp;&nbsp;&nbsp;
        <label class="checkboxLabel checkbox-inline" for="search-in-description"><?php echo zen_draw_checkbox_field('search_in_description', '1', $sData['search_in_description'], 'id="search-in-description"'); ?><?php echo TEXT_SEARCH_IN_DESCRIPTION; ?></label>
    </div>
    <br class="clearBoth" />
</fieldset>

<div class="row">
    <div class="col-md-6">
        <fieldset class="floatingBox back">
            <legend><?php echo ENTRY_CATEGORIES; ?></legend>
            <div class="form-group">
                <?php echo zen_draw_pull_down_menu('categories_id', zen_get_categories(array(array('id' => '', 'text' => TEXT_ALL_CATEGORIES)), '0' ,'', '1'), $sData['categories_id']); ?>&nbsp;&nbsp;&nbsp;
                <label class="checkboxLabel checkbox-inline" for="inc-subcat"><?php echo zen_draw_checkbox_field('inc_subcat', '1', $sData['inc_subcat'], 'id="inc-subcat"'); ?><?php echo ENTRY_INCLUDE_SUBCATEGORIES; ?></label>
            </div>
            <br class="clearBoth" />
        </fieldset>
    </div>
    <div class="col-md-6">
        <fieldset class="floatingBox forward">
            <legend><?php echo ENTRY_MANUFACTURERS; ?></legend>
            <div class="form-group">
                <?php echo zen_draw_pull_down_menu('manufacturers_id', zen_get_manufacturers(array(array('id' => '', 'text' => TEXT_ALL_MANUFACTURERS)), PRODUCTS_MANUFACTURERS_STATUS), $sData['manufacturers_id']); ?>
            </div>
            <br class="clearBoth" />
        </fieldset>
    </div>
</div>

<fieldset class="floatingBox back">
<legend><?php echo ENTRY_PRICE_RANGE; ?></legend>
<div class="row">
    <div class="col-md-6">
        <fieldset class="floatLeft">
            <legend><?php echo ENTRY_PRICE_FROM; ?></legend>
            <div class="form-group"><?php echo zen_draw_input_field('pfrom', $sData['pfrom']); ?></div>
        </fieldset>
    </div>
    <div class="col-md-6">
        <fieldset class="floatLeft">
            <legend><?php echo ENTRY_PRICE_TO; ?></legend>
            <div class="form-group"><?php echo zen_draw_input_field('pto', $sData['pto']); ?></div>
        </fieldset>
    </div>
</div>
</fieldset>
<br class="clearBoth" />

<fieldset class="floatingBox forward">
<legend><?php echo ENTRY_DATE_RANGE; ?></legend>
<div class="row">
    <div class="col-md-6">
        <fieldset class="floatLeft">
            <legend><?php echo ENTRY_DATE_FROM; ?></legend>
            <div class="form-group"><?php echo zen_draw_input_field('dfrom', '', 'placeholder="' . $sData['dfrom'] . '"'); ?></div>
        </fieldset>
    </div>
    <div class="col-md-6">
        <fieldset class="floatLeft">
            <legend><?php echo ENTRY_DATE_TO; ?></legend>
            <div class="form-group"><?php echo zen_draw_input_field('dto', '', 'placeholder="' . $sData['dto'] . '"'); ?></div>
        </fieldset>
    </div>
</div>
</fieldset>
<br class="clearBoth" />


<div class="buttonRow pull-right"><input type="submit" value="<?php echo BUTTON_SEARCH_ALT; ?>" class="pt-button"></div>
<div class="buttonRow pull-left"><a href="<?php echo zen_back_link(true); ?>" class="pt-button"><?php echo BUTTON_BACK_ALT; ?></a></div>

</form>
</div>