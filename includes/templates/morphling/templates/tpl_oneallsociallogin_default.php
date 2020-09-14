<?php
/**
 * @package   	OneAll Social Login
 * @copyright 	Copyright 2011-Present http://www.oneall.com
 * @license   	GNU/GPL 2 or later
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307,USA.
 *
 * The "GNU General Public License" (GPL) is available at
 * http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 *
 */

/**
 *
 * COLLECT ADDITIONAL USER DATA
 *
 */

?>
<div class="centerColumn" id="accountEditDefault">
	<?php echo zen_draw_form ('oneallsociallogin', zen_href_link ('oneallsociallogin'), 'post') . zen_draw_hidden_field ('action', 'process'); ?>
		<?php if ($messageStack->size ('oneallsociallogin') > 0) echo $messageStack->output ('oneallsociallogin'); ?>
		<h3>
			<?php echo sprintf (OASL_CONNECTED_WITH, $user_data ['identity_provider']); ?>
		</h3>
		<p>
			<?php echo OASL_TAKE_MINUTE_TO_REVIEW; ?>
			<?php echo sprintf (OASL_READY_FOR, $user_data ['identity_provider']); ?>
		</p>
        			<br class="clearBoth" />
		<fieldset>
			<legend><?php echo OASL_REVIEW_DETAILS; ?></legend>
			<?php
				if (ACCOUNT_GENDER == 'true')
				{
					$gender = (!empty ($user_data ['user_gender']) ? $user_data ['user_gender'] : '');
					echo zen_draw_radio_field ('gender', 'm', $gender, 'id="gender-male"') . '<label class="radioButtonLabel" for="gender-male">' . MALE . '</label>' . zen_draw_radio_field ('gender', 'f', $female, 'id="gender-female"') . '<label class="radioButtonLabel" for="gender-female">' . FEMALE . '</label>' . (zen_not_null (ENTRY_GENDER_TEXT) ? '<span class="alert">' . ENTRY_GENDER_TEXT . '</span>' : '');
					?>
						<br class="clearBoth" />
					<?php
				}
			?>
                          <div class="fec-field">

			<label class="inputLabel return-login" for="firstname"><?php echo ENTRY_FIRST_NAME; ?></label>
			<?php
				$firstname = (!empty ($user_data ['user_first_name']) ? $user_data ['user_first_name'] : '');
				echo zen_draw_input_field ('firstname', $firstname, 'id="firstname"');
			?>
			</div>
                          <div class="fec-field">

			<label class="inputLabel return-login" for="lastname"><?php echo ENTRY_LAST_NAME; ?></label>
			<?php
				$lastname = (!empty ($user_data ['user_last_name']) ? $user_data ['user_last_name'] : '');
				echo zen_draw_input_field ('lastname', $lastname, 'id="lastname"');
			?>
			</div>

			<?php
				if (defined ('ACCOUNT_DOB') AND ACCOUNT_DOB == 'true')
				{
					?>                          <div class="fec-field">

						<label class="inputLabel return-login" for="dob"><?php echo ENTRY_DATE_OF_BIRTH; ?></label>
						<?php
							$birthdate = (!empty ($user_data ['user_birthdate']) ? $user_data ['user_birthdate'] : '');
							echo zen_draw_input_field ('dob', $birthdate, 'id="dob"');
						?>
						</div>
					<?php
				}
			?>
                          <div class="fec-field">

			<label class="inputLabel return-login" for="email-address"><?php echo ENTRY_EMAIL_ADDRESS; ?></label>
			<?php
				$email = (!empty ($user_data ['user_email']) ? $user_data ['user_email'] : '');
				echo zen_draw_input_field ('email_address', $email, 'id="email-address"');
			?>
			</div>
                          <div class="fec-field">

			<label class="inputLabel return-login" for="telephone"><?php echo ENTRY_TELEPHONE_NUMBER; ?></label>
			<?php
				$telephone = (!empty ($user_data ['user_phone']) ? $user_data ['user_phone'] : '');
				echo zen_draw_input_field ('telephone', $telephone, 'id="telephone"');
			?>
			</div>
		</fieldset>
        			<br class="clearBoth" />

		<fieldset>
			<legend><?php echo TABLE_HEADING_ADDRESS_DETAILS; ?></legend>
                                      <div class="fec-field">

			<label class="inputLabel return-login" for="street-address"><?php echo ENTRY_STREET_ADDRESS; ?></label>
			<?php
				$street_address = (!empty ($user_data ['user_street_address']) ? $user_data ['user_street_address'] : '');
				echo zen_draw_input_field('street_address', $street_address, 'id="street-address"');
			?>
			</div>

			<?php
				if (defined ('ACCOUNT_SUBURB') && ACCOUNT_SUBURB == 'true')
				{
					?>                          <div class="fec-field">

						<label class="inputLabel return-login" for="suburb"><?php echo ENTRY_SUBURB; ?></label>
						<?php
							$suburb = (!empty ($user_data ['user_suburb']) ? $user_data ['user_suburb'] : '');
							echo zen_draw_input_field('suburb', '', ' id="suburb"');
						?>
						</div>
					<?php
  			}
			?>
                          <div class="fec-field">

			<label class="inputLabel return-login" for="postcode"><?php echo ENTRY_POST_CODE; ?></label>
			<?php
				$postcode = (!empty ($user_data ['user_postcode']) ? $user_data ['user_postcode'] : '');
				echo zen_draw_input_field('postcode', $postcode, 'id="postcode"');
			?>
			</div>
                          <div class="fec-field">

			<label class="inputLabel return-login" for="city"><?php echo ENTRY_CITY; ?></label>
			<?php
				$city = (!empty ($user_data ['user_city']) ? $user_data ['user_city'] : '');
				echo zen_draw_input_field('city', $city, ' id="city"');
			?>
			</div>
                          <div class="fec-field">

			<label class="inputLabel return-login" for="country"><?php echo ENTRY_COUNTRY; ?></label>
			<?php
				$country = (!empty ($user_data ['user_country_id']) ? $user_data ['user_country_id'] : '');
				echo zen_get_country_list('country_id', $country, 'id="country" ');
			?>
			</div>

			<?php
				if (ACCOUNT_STATE == 'true')
				{
					if ($user_data['show_pulldown_states'] == true)
					{
						?>                          <div class="fec-field">

							<label class="inputLabel return-login" for="stateZone" id="zoneLabel"><?php echo ENTRY_STATE; ?></label>
						<?php
							$selected_country = (!empty ($user_data ['user_selected_country_id']) ? $user_data ['user_selected_country_id'] : '');
							$zone_id = (!empty ($user_data ['user_zone_id']) ? $user_data ['user_zone_id'] : false);
							echo zen_draw_pull_down_menu('zone_id', zen_prepare_country_zones_pull_down($selected_country), $zone_id, 'id="stateZone"');
						?>
							&nbsp;<span class="alert"><?php echo ENTRY_STATE_TEXT; ?></span>
							</div>
						<?php
					}
					else
					{
						?>                          <div class="fec-field">

							<label class="inputLabel return-login" for="state" id="stateLabel"><?php echo ENTRY_STATE; ?></label>
						<?php
							$state = (!empty ($user_data ['user_state']) ? $user_data ['user_state'] : '');
    					echo zen_draw_input_field('state', $state, zen_set_field_length(TABLE_ADDRESS_BOOK, 'entry_state', '40') . ' id="state"');
    				?>
    					</div>
    				<?php
					}
				}
			?>

		</fieldset>
                			<br class="clearBoth" />

		<div class="buttonRow forward"><?php echo zen_image_submit (BUTTON_IMAGE_UPDATE, BUTTON_UPDATE_ALT); ?></div>
	</form>
</div>
