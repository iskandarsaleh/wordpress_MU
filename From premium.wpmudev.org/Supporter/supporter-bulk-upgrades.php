<?php
/*
Plugin Name: Supporter (Feature: Bulk Upgrades)
Plugin URI: 
Description:
Author: Andrew Billits (Incsub)
Version: 1.6.1
Author URI:
*/

/* 
Copyright 2007-2009 Incsub (http://incsub.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License (Version 2 - GPLv2) as published by
the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

//------------------------------------------------------------------------//
//---Config---------------------------------------------------------------//
//------------------------------------------------------------------------//

//------------------------------------------------------------------------//
//---Hook-----------------------------------------------------------------//
//------------------------------------------------------------------------//

add_action('supporter_plug_pages', 'supporter_bulk_upgrades_plug_pages');
add_action('supporter_settings', 'supporter_bulk_upgrades_setting', 1);
add_action('supporter_settings_process', 'supporter_bulk_upgrades_setting_process');

//------------------------------------------------------------------------//
//---Functions------------------------------------------------------------//
//------------------------------------------------------------------------//

function supporter_bulk_upgrades_plug_pages() {
	global $wpdb, $wp_roles, $current_user;
	if ( $wpdb->blogid != 1 ) {
		add_submenu_page('supporter.php', __('Bulk Upgrades'), __('Bulk Upgrades'), 10, 'bulk-upgrades', 'supporter_bulk_upgrades');
	}
}

function supporter_bulk_upgrades_setting_process() {
	update_site_option( "supporter_bulk_upgrades_paypal_payment_type", $_POST[ 'supporter_bulk_upgrades_paypal_payment_type' ] );
	update_site_option( "supporter_bulk_upgrades_1_credits", $_POST[ 'supporter_bulk_upgrades_1_credits' ] );
	update_site_option( "supporter_bulk_upgrades_1_whole_cost", $_POST[ 'supporter_bulk_upgrades_1_whole_cost' ] );
	update_site_option( "supporter_bulk_upgrades_1_partial_cost", $_POST[ 'supporter_bulk_upgrades_1_partial_cost' ] );
	update_site_option( "supporter_bulk_upgrades_2_credits", $_POST[ 'supporter_bulk_upgrades_2_credits' ] );
	update_site_option( "supporter_bulk_upgrades_2_whole_cost", $_POST[ 'supporter_bulk_upgrades_2_whole_cost' ] );
	update_site_option( "supporter_bulk_upgrades_2_partial_cost", $_POST[ 'supporter_bulk_upgrades_2_partial_cost' ] );
	update_site_option( "supporter_bulk_upgrades_3_credits", $_POST[ 'supporter_bulk_upgrades_3_credits' ] );
	update_site_option( "supporter_bulk_upgrades_3_whole_cost", $_POST[ 'supporter_bulk_upgrades_3_whole_cost' ] );
	update_site_option( "supporter_bulk_upgrades_3_partial_cost", $_POST[ 'supporter_bulk_upgrades_3_partial_cost' ] );
	update_site_option( "supporter_bulk_upgrades_message", $_POST[ 'supporter_bulk_upgrades_message' ] );
	update_site_option( "supporter_bulk_upgrades_1_single_payment_message", $_POST[ 'supporter_bulk_upgrades_1_single_payment_message' ] );
	update_site_option( "supporter_bulk_upgrades_2_single_payment_message", $_POST[ 'supporter_bulk_upgrades_2_single_payment_message' ] );
	update_site_option( "supporter_bulk_upgrades_3_single_payment_message", $_POST[ 'supporter_bulk_upgrades_3_single_payment_message' ] );
	update_site_option( "supporter_bulk_upgrades_1_recurring_payment_message", $_POST[ 'supporter_bulk_upgrades_1_recurring_payment_message' ] );
	update_site_option( "supporter_bulk_upgrades_2_recurring_payment_message", $_POST[ 'supporter_bulk_upgrades_2_recurring_payment_message' ] );
	update_site_option( "supporter_bulk_upgrades_3_recurring_payment_message", $_POST[ 'supporter_bulk_upgrades_3_recurring_payment_message' ] );
	update_site_option( "supporter_bulk_upgrades_payment_message", $_POST[ 'supporter_bulk_upgrades_payment_message' ] );
}

function supporter_get_credits($uid) {
	$credits = get_usermeta( $uid, "supporter_credits" );
	if ( empty( $credits ) || $credits < 0 ) {
		$credits = 0;
	}
	return $credits;
}

function supporter_debit_credits($uid, $credits) {
	$old_credits = get_usermeta( $uid, "supporter_credits" );
	if ( empty( $old_credits ) || $old_credits < 0 ) {
		$old_credits = 0;
	}
	$new_credits = $old_credits - $credits;
	if ( empty( $new_credits ) || $new_credits < 0 ) {
		$new_credits = 0;
	}
	update_usermeta($uid, 'supporter_credits', $new_credits);
}

function supporter_credit_credits($uid, $credits) {
	$old_credits = get_usermeta( $uid, "supporter_credits" );
	if ( empty( $old_credits ) || $old_credits < 0 ) {
		$old_credits = 0;
	}
	$new_credits = $old_credits + $credits;
	if ( empty( $new_credits ) || $new_credits < 0 ) {
		$new_credits = 0;
	}
	update_usermeta($uid, 'supporter_credits', $new_credits);
}

function supporter_bulk_upgrades_get_note($uid) {
	return get_usermeta( $uid, "supporter_bulk_upgrades_update_note" );
}

function supporter_bulk_upgrades_update_note($uid, $note = '') {
	update_usermeta($uid, 'supporter_bulk_upgrades_update_note', $note);
}

//------------------------------------------------------------------------//
//---Output Functions-----------------------------------------------------//
//------------------------------------------------------------------------//

function supporter_bulk_upgrades_setting() {
			$supporter_bulk_upgrades_message = stripslashes( get_site_option('supporter_bulk_upgrades_message') );
			if ( empty( $supporter_bulk_upgrades_message ) ) {
				$supporter_bulk_upgrades_message = 'You can upgrade multiple blogs at a lower cost by purchasing Supporter credits below. After purchasing your credits just come back to this page, search for your blogs via the tool at the bottom of the page, and upgrade them. Each blog is upgraded for one year';
			}

			$supporter_bulk_upgrades_payment_message = stripslashes( get_site_option('supporter_bulk_upgrades_payment_message') );
			if ( empty( $supporter_bulk_upgrades_payment_message ) ) {
				$supporter_bulk_upgrades_payment_message = 'Depending on your payment method it may take just a few minutes (Credit Card or PayPal funds) or it may take several days (eCheck) for your Supporter credits to become available.';
			}
			$supporter_bulk_upgrades_1_single_payment_message = stripslashes( get_site_option('supporter_bulk_upgrades_1_single_payment_message') );
			if ( empty( $supporter_bulk_upgrades_1_single_payment_message ) ) {
				$supporter_bulk_upgrades_1_single_payment_message = 'Upgrade CREDITS blogs for AMOUNT CURRENCY for one year:';
			}
			$supporter_bulk_upgrades_2_single_payment_message = stripslashes( get_site_option('supporter_bulk_upgrades_2_single_payment_message') );
			if ( empty( $supporter_bulk_upgrades_2_single_payment_message ) ) {
				$supporter_bulk_upgrades_2_single_payment_message = 'Upgrade CREDITS blogs for AMOUNT CURRENCY for one year:';
			}
			$supporter_bulk_upgrades_3_single_payment_message = stripslashes( get_site_option('supporter_bulk_upgrades_3_single_payment_message') );
			if ( empty( $supporter_bulk_upgrades_3_single_payment_message ) ) {
				$supporter_bulk_upgrades_3_single_payment_message = 'Upgrade CREDITS blogs for AMOUNT CURRENCY for one year:';
			}
			$supporter_bulk_upgrades_1_recurring_payment_message = stripslashes( get_site_option('supporter_bulk_upgrades_1_recurring_payment_message') );
			if ( empty( $supporter_bulk_upgrades_1_recurring_payment_message ) ) {
				$supporter_bulk_upgrades_1_recurring_payment_message = 'Upgrade CREDITS blogs for AMOUNT CURRENCY for one year (renews each year):';
			}
			$supporter_bulk_upgrades_2_recurring_payment_message = stripslashes( get_site_option('supporter_bulk_upgrades_2_recurring_payment_message') );
			if ( empty( $supporter_bulk_upgrades_2_recurring_payment_message ) ) {
				$supporter_bulk_upgrades_2_recurring_payment_message = 'Upgrade CREDITS blogs for AMOUNT CURRENCY for one year (renews each year):';
			}
			$supporter_bulk_upgrades_3_recurring_payment_message = stripslashes( get_site_option('supporter_bulk_upgrades_3_recurring_payment_message') );
			if ( empty( $supporter_bulk_upgrades_3_recurring_payment_message ) ) {
				$supporter_bulk_upgrades_3_recurring_payment_message = 'Upgrade CREDITS blogs for AMOUNT CURRENCY for one year (renews each year):';
			}
	?>
                <tr valign="top"> 
                <th scope="row"><?php _e('Bulk Upgrades PayPal Payment Type') ?></th> 
                <td><select name="supporter_bulk_upgrades_paypal_payment_type">
                <option value="single" <?php if (get_site_option( "supporter_bulk_upgrades_paypal_payment_type" ) == 'single') echo 'selected="selected"'; ?>><?php _e('Single') ?></option>
                <option value="recurring" <?php if (get_site_option( "supporter_bulk_upgrades_paypal_payment_type" ) == 'recurring') echo 'selected="selected"'; ?>><?php _e('Recurring') ?></option>
                </select>
                <br />
                <?php _e('Recurring = PayPal Subscription') ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Bulk Upgrades Option One') ?></th> 
                <td><select name="supporter_bulk_upgrades_1_credits">
				<?php
					$supporter_bulk_upgrades_1_credits = get_site_option( "supporter_bulk_upgrades_1_credits" );
					$counter = 0;
					for ( $counter = 1; $counter <= 900; $counter += 1) {
                        echo '<option value="' . $counter . '"' . ($counter == $supporter_bulk_upgrades_1_credits ? ' selected' : '') . '>' . $counter . '</option>' . "\n";
					}
                ?>
                </select>
                <?php
                echo ' ' . __('Credits') . ' ' . __('for') . ' ';
				?>
                <select name="supporter_bulk_upgrades_1_whole_cost">
				<?php
					$supporter_bulk_upgrades_1_whole_cost = get_site_option( "supporter_bulk_upgrades_1_whole_cost" );
					$counter = 0;
					for ( $counter = 1; $counter <= 900; $counter += 1) {
                        echo '<option value="' . $counter . '"' . ($counter == $supporter_bulk_upgrades_1_whole_cost ? ' selected' : '') . '>' . $counter . '</option>' . "\n";
					}
                ?>
                </select>
                .
				<select name="supporter_bulk_upgrades_1_partial_cost">
				<?php
					$supporter_bulk_upgrades_1_partial_cost = get_site_option( "supporter_bulk_upgrades_1_partial_cost" );
					$counter = 0;
                    echo '<option value="00"' . ('00' == $supporter_bulk_upgrades_1_partial_cost ? ' selected' : '') . '>00</option>' . "\n";
					for ( $counter = 1; $counter <= 99; $counter += 1) {
						if ( $counter < 10 ) {
							$number = '0' . $counter;
						} else {
							$number = $counter;
						}
                        echo '<option value="' . $number . '"' . ($number == $supporter_bulk_upgrades_1_partial_cost ? ' selected' : '') . '>' . $number . '</option>' . "\n";
					}
                ?>
                </select>
                <br /><?php _e('One credit allows for one blog to be upgraded for one year.'); ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Bulk Upgrades Option Two') ?></th> 
                <td><select name="supporter_bulk_upgrades_2_credits">
				<?php
					$supporter_bulk_upgrades_2_credits = get_site_option( "supporter_bulk_upgrades_2_credits" );
					$counter = 0;
					for ( $counter = 1; $counter <= 900; $counter += 1) {
                        echo '<option value="' . $counter . '"' . ($counter == $supporter_bulk_upgrades_2_credits ? ' selected' : '') . '>' . $counter . '</option>' . "\n";
					}
                ?>
                </select>
                <?php
                echo ' ' . __('Credits') . ' ' . __('for') . ' ';
				?>
                <select name="supporter_bulk_upgrades_2_whole_cost">
				<?php
					$supporter_bulk_upgrades_2_whole_cost = get_site_option( "supporter_bulk_upgrades_2_whole_cost" );
					$counter = 0;
					for ( $counter = 1; $counter <= 900; $counter += 1) {
                        echo '<option value="' . $counter . '"' . ($counter == $supporter_bulk_upgrades_2_whole_cost ? ' selected' : '') . '>' . $counter . '</option>' . "\n";
					}
                ?>
                </select>
                .
				<select name="supporter_bulk_upgrades_2_partial_cost">
				<?php
					$supporter_bulk_upgrades_2_partial_cost = get_site_option( "supporter_bulk_upgrades_2_partial_cost" );
					$counter = 0;
                    echo '<option value="00"' . ('00' == $supporter_bulk_upgrades_2_partial_cost ? ' selected' : '') . '>00</option>' . "\n";
					for ( $counter = 1; $counter <= 99; $counter += 1) {
						if ( $counter < 10 ) {
							$number = '0' . $counter;
						} else {
							$number = $counter;
						}
                        echo '<option value="' . $number . '"' . ($number == $supporter_bulk_upgrades_2_partial_cost ? ' selected' : '') . '>' . $number . '</option>' . "\n";
					}
                ?>
                </select>
                <br /><?php _e('One credit allows for one blog to be upgraded for one year.'); ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Bulk Upgrades Option Three') ?></th> 
                <td><select name="supporter_bulk_upgrades_3_credits">
				<?php
					$supporter_bulk_upgrades_3_credits = get_site_option( "supporter_bulk_upgrades_3_credits" );
					$counter = 0;
					for ( $counter = 1; $counter <= 900; $counter += 1) {
                        echo '<option value="' . $counter . '"' . ($counter == $supporter_bulk_upgrades_3_credits ? ' selected' : '') . '>' . $counter . '</option>' . "\n";
					}
                ?>
                </select>
                <?php
                echo ' ' . __('Credits') . ' ' . __('for') . ' ';
				?>
                <select name="supporter_bulk_upgrades_3_whole_cost">
				<?php
					$supporter_bulk_upgrades_3_whole_cost = get_site_option( "supporter_bulk_upgrades_3_whole_cost" );
					$counter = 0;
					for ( $counter = 1; $counter <= 900; $counter += 1) {
                        echo '<option value="' . $counter . '"' . ($counter == $supporter_bulk_upgrades_3_whole_cost ? ' selected' : '') . '>' . $counter . '</option>' . "\n";
					}
                ?>
                </select>
                .
				<select name="supporter_bulk_upgrades_3_partial_cost">
				<?php
					$supporter_bulk_upgrades_3_partial_cost = get_site_option( "supporter_bulk_upgrades_3_partial_cost" );
					$counter = 0;
                    echo '<option value="00"' . ('00' == $supporter_bulk_upgrades_3_partial_cost ? ' selected' : '') . '>00</option>' . "\n";
					for ( $counter = 1; $counter <= 99; $counter += 1) {
						if ( $counter < 10 ) {
							$number = '0' . $counter;
						} else {
							$number = $counter;
						}
                        echo '<option value="' . $number . '"' . ($number == $supporter_bulk_upgrades_3_partial_cost ? ' selected' : '') . '>' . $number . '</option>' . "\n";
					}
                ?>
                </select>
                <br /><?php _e('One credit allows for one blog to be upgraded for one year.'); ?></td> 
                </tr>
                <tr valign="top">
                <th scope="row"><?php _e('Bulk Upgrades Message') ?></th>
                <td>
                <textarea name="supporter_bulk_upgrades_message" type="text" rows="10" wrap="soft" id="supporter_bulk_upgrades_message" style="width: 95%"/><?php echo $supporter_bulk_upgrades_message; ?></textarea>
                <br /><?php _e('Required - HTML allowed - This message is displayed at the top of the "Bulk Upgrades" page.') ?></td>
                </tr>
                <tr valign="top">
                <th scope="row"><?php _e('Bulk Upgrades Payment Message') ?></th>
                <td>
                <textarea name="supporter_bulk_upgrades_payment_message" type="text" rows="5" wrap="soft" id="supporter_bulk_upgrades_payment_message" style="width: 95%"/><?php echo $supporter_bulk_upgrades_payment_message; ?></textarea>
                <br /><?php _e('Required - HTML allowed') ?></td>
                </tr>
                <tr valign="top">
                <th scope="row"><?php _e('Bulk Upgrades Option One Single Payment Message') ?></th>
                <td>
                <textarea name="supporter_bulk_upgrades_1_single_payment_message" type="text" rows="3" wrap="soft" id="supporter_bulk_upgrades_1_single_payment_message" style="width: 95%"/><?php echo $supporter_bulk_upgrades_1_single_payment_message; ?></textarea>
                <br /><?php _e('Required - HTML allowed') ?>
                <br /><?php echo '"CREDITS"' . ' ' . _('Will be replaced by the number of credits chosen above') ?>
                <br /><?php echo '"AMOUNT"' . ' ' . _('Will be replaced by the amount chosen above') ?>
                <br /><?php echo '"CURRENCY"' . ' ' . _('Will be replaced by the currency chosen above') ?></td>
                </tr>
                <tr valign="top">
                <th scope="row"><?php _e('Bulk Upgrades Option Two Single Payment Message') ?></th>
                <td>
                <textarea name="supporter_bulk_upgrades_2_single_payment_message" type="text" rows="3" wrap="soft" id="supporter_bulk_upgrades_2_single_payment_message" style="width: 95%"/><?php echo $supporter_bulk_upgrades_2_single_payment_message; ?></textarea>
                <br /><?php _e('Required - HTML allowed') ?>
                <br /><?php echo '"CREDITS"' . ' ' . _('Will be replaced by the number of credits chosen above') ?>
                <br /><?php echo '"AMOUNT"' . ' ' . _('Will be replaced by the amount chosen above') ?>
                <br /><?php echo '"CURRENCY"' . ' ' . _('Will be replaced by the currency chosen above') ?></td>
                </tr>
                <tr valign="top">
                <th scope="row"><?php _e('Bulk Upgrades Option Three Single Payment Message') ?></th>
                <td>
                <textarea name="supporter_bulk_upgrades_3_single_payment_message" type="text" rows="3" wrap="soft" id="supporter_bulk_upgrades_3_single_payment_message" style="width: 95%"/><?php echo $supporter_bulk_upgrades_3_single_payment_message; ?></textarea>
                <br /><?php _e('Required - HTML allowed') ?>
                <br /><?php echo '"CREDITS"' . ' ' . _('Will be replaced by the number of credits chosen above') ?>
                <br /><?php echo '"AMOUNT"' . ' ' . _('Will be replaced by the amount chosen above') ?>
                <br /><?php echo '"CURRENCY"' . ' ' . _('Will be replaced by the currency chosen above') ?></td>
                </tr>
                <tr valign="top">
                <th scope="row"><?php _e('Bulk Upgrades Option One Recurring Payment Message') ?></th>
                <td>
                <textarea name="supporter_bulk_upgrades_1_recurring_payment_message" type="text" rows="3" wrap="soft" id="supporter_bulk_upgrades_1_recurring_payment_message" style="width: 95%"/><?php echo $supporter_bulk_upgrades_1_recurring_payment_message; ?></textarea>
                <br /><?php _e('Required - HTML allowed') ?>
                <br /><?php echo '"CREDITS"' . ' ' . _('Will be replaced by the number of credits chosen above') ?>
                <br /><?php echo '"AMOUNT"' . ' ' . _('Will be replaced by the amount chosen above') ?>
                <br /><?php echo '"CURRENCY"' . ' ' . _('Will be replaced by the currency chosen above') ?></td>
                </tr>
                <tr valign="top">
                <th scope="row"><?php _e('Bulk Upgrades Option Two Recurring Payment Message') ?></th>
                <td>
                <textarea name="supporter_bulk_upgrades_2_recurring_payment_message" type="text" rows="3" wrap="soft" id="supporter_bulk_upgrades_2_recurring_payment_message" style="width: 95%"/><?php echo $supporter_bulk_upgrades_2_recurring_payment_message; ?></textarea>
                <br /><?php _e('Required - HTML allowed') ?>
                <br /><?php echo '"CREDITS"' . ' ' . _('Will be replaced by the number of credits chosen above') ?>
                <br /><?php echo '"AMOUNT"' . ' ' . _('Will be replaced by the amount chosen above') ?>
                <br /><?php echo '"CURRENCY"' . ' ' . _('Will be replaced by the currency chosen above') ?></td>
                </tr>
                <tr valign="top">
                <th scope="row"><?php _e('Bulk Upgrades Option Three Recurring Payment Message') ?></th>
                <td>
                <textarea name="supporter_bulk_upgrades_3_recurring_payment_message" type="text" rows="3" wrap="soft" id="supporter_bulk_upgrades_3_recurring_payment_message" style="width: 95%"/><?php echo $supporter_bulk_upgrades_3_recurring_payment_message; ?></textarea>
                <br /><?php _e('Required - HTML allowed') ?>
                <br /><?php echo '"CREDITS"' . ' ' . _('Will be replaced by the number of credits chosen above') ?>
                <br /><?php echo '"AMOUNT"' . ' ' . _('Will be replaced by the amount chosen above') ?>
                <br /><?php echo '"CURRENCY"' . ' ' . _('Will be replaced by the currency chosen above') ?></td>
                </tr>
    <?php
}

function supporter_bulk_upgrades_paypal_button_output($option) {
	global $wpdb, $current_site, $current_user, $user_ID;
	// Live URL:	https://www.paypal.com/cgi-bin/webscr
	// Sandbox URL:	https://www.sandbox.paypal.com/cgi-bin/webscr
	if (get_site_option( "supporter_paypal_status" ) == 'live'){
		$action = 'https://www.paypal.com/cgi-bin/webscr';
	} else {
		$action = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
	}
	$blog_url = get_blogaddress_by_id($wpdb->blogid);
	if ( $option == '1' ) {
		$credits = get_site_option( "supporter_bulk_upgrades_1_credits" );
		$amount = get_site_option( "supporter_bulk_upgrades_1_whole_cost" ) . '.' . get_site_option( "supporter_bulk_upgrades_1_partial_cost" );
	} else if ( $option == '2' ) {
		$credits = get_site_option( "supporter_bulk_upgrades_2_credits" );
		$amount = get_site_option( "supporter_bulk_upgrades_2_whole_cost" ) . '.' . get_site_option( "supporter_bulk_upgrades_2_partial_cost" );
	} else if ( $option == '3' ) {
		$credits = get_site_option( "supporter_bulk_upgrades_3_credits" );
		$amount = get_site_option( "supporter_bulk_upgrades_3_whole_cost" ) . '.' . get_site_option( "supporter_bulk_upgrades_3_partial_cost" );
	}
	if ( get_site_option( "supporter_bulk_upgrades_paypal_payment_type" ) == 'single' ) {
		$button = '
		<form action="' . $action . '" method="post">
			<input type="hidden" name="cmd" value="_xclick">
			<input type="hidden" name="business" value="' . get_site_option( "supporter_paypal_email" ) . '">
			<input type="hidden" name="item_name" value="' . $current_site->site_name . ' Supporter">
			<input type="hidden" name="item_number" value="' . $option . '">
			<input type="hidden" name="amount" value="' . $amount . '">
			<input type="hidden" name="no_shipping" value="1">
			<input type="hidden" name="return" value="' . $blog_url . 'wp-admin/supporter.php?page=bulk-upgrades&updated=true&updatedmsg=' . urlencode(__('Transaction Complete!')) . '">
			<input type="hidden" name="cancel_return" value="' . $blog_url . 'wp-admin/supporter.php?page=bulk-upgrades&updated=true&updatedmsg=' . urlencode(__('Transaction Canceled!')) . '">
			<input type="hidden" name="notify_url" value="' . $blog_url . 'supporter-bulk-upgrades-paypal.php">
			<input type="hidden" name="no_note" value="1">
			<input type="hidden" name="currency_code" value="' . get_site_option( "supporter_currency" ) . '">
			<input type="hidden" name="lc" value="' . get_site_option( "supporter_paypal_site" ) . '">
			<input type="hidden" name="custom" value="' . $wpdb->blogid . '_' . $user_ID . '_' . $credits . '_' . $amount . '_' . get_site_option( "supporter_currency" ) . '_' . time() . '">
			<input type="hidden" name="bn" value="PP-BuyNowBF">
			<p class="submit" style="border:none;padding-top:2px;">
			<input type="submit" name="Submit" value="PayPal">
			</p>
		</form>
		';
	} else {
		/*
		a3 - amount to billed each recurrence
		p3 - number of time periods between each recurrence
		t3 - time period (D=days, W=weeks, M=months, Y=years)
		*/
		$button = '
		<form action="' . $action . '" method="post">
			<input type="hidden" name="cmd" value="_xclick-subscriptions">
			<input type="hidden" name="business" value="' . get_site_option( "supporter_paypal_email" ) . '">
			<input type="hidden" name="item_name" value="' . $current_site->site_name . ' Supporter">
			<input type="hidden" name="item_number" value="' . $period . '">
			<input type="hidden" name="no_shipping" value="1">
			<input type="hidden" name="return" value="' . $blog_url . 'wp-admin/supporter.php?page=bulk-upgrades&updated=true&updatedmsg=' . urlencode(__('Transaction Complete!')) . '">
			<input type="hidden" name="cancel_return" value="' . $blog_url . 'wp-admin/supporter.php?page=bulk-upgrades&updated=true&updatedmsg=' . urlencode(__('Transaction Canceled!')) . '">
			<input type="hidden" name="notify_url" value="' . $blog_url . 'supporter-bulk-upgrades-paypal.php">
			<input type="hidden" name="no_note" value="1">
			<input type="hidden" name="currency_code" value="' . get_site_option( "supporter_currency" ) . '">
			<input type="hidden" name="lc" value="' . get_site_option( "supporter_paypal_site" ) . '">
			<input type="hidden" name="custom" value="' . $wpdb->blogid . '_' . $user_ID . '_' . $credits . '_' . $amount . '_' . get_site_option( "supporter_currency" ) . '_' . time() . '">
			<input type="hidden" name="a3" value="' . $amount . '">
			<input type="hidden" name="p3" value="1">
			<input type="hidden" name="t3" value="Y">
			<input type="hidden" name="src" value="1">
			<input type="hidden" name="sra" value="1">
			<p class="submit" style="border:none;padding-top:2px;">
			<input type="submit" name="Submit" value="PayPal">
			</p>
		</form>
		';
	}
	return $button;
}

//------------------------------------------------------------------------//
//---Page Output Functions------------------------------------------------//
//------------------------------------------------------------------------//

function supporter_bulk_upgrades() {
	global $wpdb, $wp_roles, $current_user, $user_ID;
	
	if(!current_user_can('edit_users')) {
		echo "<p>" . __('Nice Try...') . "</p>";  //If accessed properly, this message doesn't appear.
		return;
	}
	if (isset($_GET['updated'])) {
		?><div id="message" class="updated fade"><p><?php _e('' . urldecode($_GET['updatedmsg']) . '') ?></p></div><?php
	}
	echo '<div class="wrap">';
	switch( $_GET[ 'action' ] ) {
		//---------------------------------------------------//
		default:
			$now = time();
			$note = supporter_bulk_upgrades_get_note($user_ID);
			?>
			<h2><?php _e('Bulk Upgrades') ?></h2>
			<?php
			$supporter_bulk_upgrades_message = stripslashes( get_site_option('supporter_bulk_upgrades_message') );
			if ( empty( $supporter_bulk_upgrades_message ) ) {
				$supporter_bulk_upgrades_message = 'You can upgrade multiple blogs at a lower cost by purchasing Supporter credits below. After purchasing your credits just come back to this page, search for your blogs via the tool at the bottom of the page, and upgrade them. Each blog is upgraded for one year';
			}
			if ( !empty( $supporter_bulk_upgrades_message ) ) {
				echo '<p>';
				echo __($supporter_bulk_upgrades_message);
				echo '</p>';
			}
			if ( !empty( $note ) ) {
				echo '<p><strong>';
				echo __('Note') . ': ' . __($note);
				echo '</strong></p>';
			}
			$supporter_bulk_upgrades_payment_message = stripslashes( get_site_option('supporter_bulk_upgrades_payment_message') );
			if ( empty( $supporter_bulk_upgrades_payment_message ) ) {
				$supporter_bulk_upgrades_payment_message = 'Depending on your payment method it may take just a few minutes (Credit Card or PayPal funds) or it may take several days (eCheck) for your Supporter credits to become available.';
			}
			echo '<p>';
			echo __('Note') . ': ' . __($supporter_bulk_upgrades_payment_message);
			echo '</p>';
			if ( get_site_option( "supporter_bulk_upgrades_paypal_payment_type" ) == 'single' ) {
				$currency = get_site_option( "supporter_currency" );
				$supporter_bulk_upgrades_1_single_payment_message = stripslashes( get_site_option('supporter_bulk_upgrades_1_single_payment_message') );
				if ( empty( $supporter_bulk_upgrades_1_single_payment_message ) ) {
					$supporter_bulk_upgrades_1_single_payment_message = 'Upgrade CREDITS blogs for AMOUNT CURRENCY for one year:';
				}
				$supporter_bulk_upgrades_1_single_payment_message = str_replace("CREDITS", get_site_option( "supporter_bulk_upgrades_1_credits" ), $supporter_bulk_upgrades_1_single_payment_message);
				$supporter_bulk_upgrades_1_single_payment_message = str_replace("CURRENCY", $currency, $supporter_bulk_upgrades_1_single_payment_message);
				$supporter_bulk_upgrades_1_single_payment_message = str_replace("AMOUNT", get_site_option( "supporter_bulk_upgrades_1_whole_cost" ) . '.' . get_site_option( "supporter_bulk_upgrades_1_partial_cost" ), $supporter_bulk_upgrades_1_single_payment_message);
				
				$supporter_bulk_upgrades_2_single_payment_message = stripslashes( get_site_option('supporter_bulk_upgrades_2_single_payment_message') );
				if ( empty( $supporter_bulk_upgrades_2_single_payment_message ) ) {
					$supporter_bulk_upgrades_2_single_payment_message = 'Upgrade CREDITS blogs for AMOUNT CURRENCY for one year:';
				}
				$supporter_bulk_upgrades_2_single_payment_message = str_replace("CREDITS", get_site_option( "supporter_bulk_upgrades_2_credits" ), $supporter_bulk_upgrades_2_single_payment_message);
				$supporter_bulk_upgrades_2_single_payment_message = str_replace("CURRENCY", $currency, $supporter_bulk_upgrades_2_single_payment_message);
				$supporter_bulk_upgrades_2_single_payment_message = str_replace("AMOUNT", get_site_option( "supporter_bulk_upgrades_2_whole_cost" ) . '.' . get_site_option( "supporter_bulk_upgrades_2_partial_cost" ), $supporter_bulk_upgrades_2_single_payment_message);
				
				$supporter_bulk_upgrades_3_single_payment_message = stripslashes( get_site_option('supporter_bulk_upgrades_3_single_payment_message') );
				if ( empty( $supporter_bulk_upgrades_3_single_payment_message ) ) {
					$supporter_bulk_upgrades_3_single_payment_message = 'Upgrade CREDITS blogs for AMOUNT CURRENCY for one year:';
				}
				$supporter_bulk_upgrades_3_single_payment_message = str_replace("CREDITS", get_site_option( "supporter_bulk_upgrades_3_credits" ), $supporter_bulk_upgrades_3_single_payment_message);
				$supporter_bulk_upgrades_3_single_payment_message = str_replace("CURRENCY", $currency, $supporter_bulk_upgrades_3_single_payment_message);
				$supporter_bulk_upgrades_3_single_payment_message = str_replace("AMOUNT", get_site_option( "supporter_bulk_upgrades_3_whole_cost" ) . '.' . get_site_option( "supporter_bulk_upgrades_3_partial_cost" ), $supporter_bulk_upgrades_3_single_payment_message);
			} else {
				$currency = get_site_option( "supporter_currency" );
				$supporter_bulk_upgrades_1_recurring_payment_message = stripslashes( get_site_option('supporter_bulk_upgrades_1_recurring_payment_message') );
				if ( empty( $supporter_bulk_upgrades_1_recurring_payment_message ) ) {
					$supporter_bulk_upgrades_1_recurring_payment_message = 'Upgrade CREDITS blogs for AMOUNT CURRENCY for one year: (renews each year):';
				}
				$supporter_bulk_upgrades_1_recurring_payment_message = str_replace("CREDITS", get_site_option( "supporter_bulk_upgrades_1_credits" ), $supporter_bulk_upgrades_1_recurring_payment_message);
				$supporter_bulk_upgrades_1_recurring_payment_message = str_replace("CURRENCY", $currency, $supporter_bulk_upgrades_1_recurring_payment_message);
				$supporter_bulk_upgrades_1_recurring_payment_message = str_replace("AMOUNT", get_site_option( "supporter_bulk_upgrades_1_whole_cost" ) . '.' . get_site_option( "supporter_bulk_upgrades_1_partial_cost" ), $supporter_bulk_upgrades_1_recurring_payment_message);
				
				$supporter_bulk_upgrades_2_recurring_payment_message = stripslashes( get_site_option('supporter_bulk_upgrades_2_recurring_payment_message') );
				if ( empty( $supporter_bulk_upgrades_2_recurring_payment_message ) ) {
					$supporter_bulk_upgrades_2_recurring_payment_message = 'Upgrade CREDITS blogs for AMOUNT CURRENCY for one year: (renews each year):';
				}
				$supporter_bulk_upgrades_2_recurring_payment_message = str_replace("CREDITS", get_site_option( "supporter_bulk_upgrades_2_credits" ), $supporter_bulk_upgrades_2_recurring_payment_message);
				$supporter_bulk_upgrades_2_recurring_payment_message = str_replace("CURRENCY", $currency, $supporter_bulk_upgrades_2_recurring_payment_message);
				$supporter_bulk_upgrades_2_recurring_payment_message = str_replace("AMOUNT", get_site_option( "supporter_bulk_upgrades_2_whole_cost" ) . '.' . get_site_option( "supporter_bulk_upgrades_2_partial_cost" ), $supporter_bulk_upgrades_2_recurring_payment_message);
				
				$supporter_bulk_upgrades_3_recurring_payment_message = stripslashes( get_site_option('supporter_bulk_upgrades_3_recurring_payment_message') );
				if ( empty( $supporter_bulk_upgrades_3_recurring_payment_message ) ) {
					$supporter_bulk_upgrades_3_recurring_payment_message = 'Upgrade CREDITS blogs for AMOUNT CURRENCY for one year: (renews each year):';
				}
				$supporter_bulk_upgrades_3_recurring_payment_message = str_replace("CREDITS", get_site_option( "supporter_bulk_upgrades_3_credits" ), $supporter_bulk_upgrades_3_recurring_payment_message);
				$supporter_bulk_upgrades_3_recurring_payment_message = str_replace("CURRENCY", $currency, $supporter_bulk_upgrades_3_recurring_payment_message);
				$supporter_bulk_upgrades_3_recurring_payment_message = str_replace("AMOUNT", get_site_option( "supporter_bulk_upgrades_3_whole_cost" ) . '.' . get_site_option( "supporter_bulk_upgrades_3_partial_cost" ), $supporter_bulk_upgrades_3_recurring_payment_message);
			}

			echo '<p class="submit" style="padding-top:2px;">';
			echo __($supporter_bulk_upgrades_1_recurring_payment_message);
			echo '<br />';
			echo supporter_bulk_upgrades_paypal_button_output(1);
			echo '</p>';
			echo '<p class="submit" style="padding-top:2px;">';
			echo __($supporter_bulk_upgrades_2_recurring_payment_message);
			echo '<br />';
			echo supporter_bulk_upgrades_paypal_button_output(2);
			echo '</p>';
			echo '<p class="submit" style="padding-top:2px;">';
			echo __($supporter_bulk_upgrades_3_recurring_payment_message);
			echo '<br />';
			echo supporter_bulk_upgrades_paypal_button_output(3);
			echo '</p>';
			?>
			<h3><?php _e('Search Blogs') ?></h3>
            <?php
			$supporter_credits = supporter_get_credits($user_ID);
			if ( $supporter_credits > 0 ) {
				?>
                <p><?php _e('Find blogs to upgrade.') ?></p>
                <p><?php _e('Credits remaining') ?>: <?php echo $supporter_credits; ?></p>
                <form method="post" action="supporter.php?page=bulk-upgrades&action=search">
                <table class="form-table">
                    <tr valign="top"> 
                    <th scope="row"><?php _e('Search') ?></th> 
                    <td><input type="text" name="search" value="" />
                    <br />
                    <?php //_e('') ?></td> 
                    </tr>
                </table>
                
                <p class="submit">
                <input type="submit" name="Submit" value="<?php _e('Search') ?>" />
                </p>
                </form>
    	        <?php
			} else {
				?>
                <p><?php _e('You must purchase supporter credits in order to upgrade blogs.') ?></p>
                <?php
			}
		break;

		//---------------------------------------------------//
		case "search":
			if ( isset( $_POST['Back'] ) ) {
				echo "
				<SCRIPT LANGUAGE='JavaScript'>
				window.location='supporter.php?page=bulk-upgrades';
				</script>
				";
			} else {
				$supporter_credits = supporter_get_credits($user_ID);
				?>
				<h2><?php _e('Search') ?></h2>
                <p><?php _e('Credits remaining') ?>: <?php echo $supporter_credits; ?></p>
				<h3><?php _e('Search Blogs') ?></h3>
                <p><?php _e('Find blogs to upgrade.') ?></p>
				<form method="post" action="supporter.php?page=bulk-upgrades&action=search">
				<table class="form-table">
					<tr valign="top"> 
					<th scope="row"><?php _e('Search') ?></th> 
					<td><input type="text" name="search" value="<?php echo $_POST['search']; ?>" />
					<br />
					<?php //_e('') ?></td> 
					</tr>
				</table>
				
				<p class="submit">
				<input type="submit" name="Back" value="<?php _e('Back') ?>" />
				<input type="submit" name="Submit" value="<?php _e('Search') ?>" />
				</p>
				</form>
				<h3><?php _e('Results') ?></h3>
				<?php
				$query = "SELECT blog_id, domain, path FROM " . $wpdb->blogs . " WHERE ( domain LIKE '%" . $_POST['search'] . "%' OR path LIKE '%" . $_POST['search'] . "%' ) LIMIT 150";
				$blogs = $wpdb->get_results( $query, ARRAY_A );
				if ( count( $blogs ) > 0 ) {
					if ( count( $blogs ) == 150 ) {
						?>
	                    <h3><?php _e('Over 150 blogs were found matching the provided search criteria. If you do not find the blog you are looking for in the selection below please try refining your search criteria.') ?></h3>
	                    <?php
					}
					echo "
					<table cellpadding='3' cellspacing='3' width='100%' class='widefat'> 
					<thead><tr>
					<th scope='col' width='75px'>" . __("Upgrade") . "</th>
					<th scope='col'>" . __("Blog") . "</th>
					</tr></thead>
					<tbody id='the-list'>
					<form method='post' action='supporter.php?page=bulk-upgrades&action=process'>
					";
					$now = time();
					$class = ('alternate' == $class) ? '' : 'alternate';
					foreach ($blogs as $blog) {
					if ( $blog['path'] == '/' ) {
						$blog['path'] = '';
					}
					//=========================================================//
					echo "<tr class='" . $class . "'>";
					$supporter_check = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "supporters WHERE blog_ID = '" . $blog['blog_id'] . "' AND expire > '" . $now . "'");
					if ( $supporter_check > 0 ) {
						echo "<td valign='top'><center><input name='blogs[" . $blog['blog_id'] . "]' value='1' type='checkbox' disabled='disabled'></center></td>";
					} else {
						echo "<td valign='top'><center><input name='blogs[" . $blog['blog_id'] . "]' value='1' type='checkbox'></center></td>";
					}
					if ( $supporter_check > 0 ) {
						echo "<td valign='top' style='color:#666666;'><strong>" . $blog['domain'] . $blog['path'] . " (" . __("Already upgraded") . ")</strong></td>";
					} else {
						echo "<td valign='top'><strong>" . $blog['domain'] . $blog['path'] . "</strong></td>";
					}
					echo "</tr>";
					$class = ('alternate' == $class) ? '' : 'alternate';
					//=========================================================//
					}
					?>
                    </tbody></table>
                    <p class="submit">
                    <input type="submit" name="Back" value="<?php _e('Back') ?>" />
                    <input type="submit" name="Submit" value="<?php _e('Upgrade') ?>" />
                    </p>
                    </form>
                    <?php
				} else {
					?>
                    <p><?php _e('No blogs found matching search criteria.') ?></p>
                    <?php
				}
			}
		break;
		//---------------------------------------------------//
		case "process":
			if ( isset( $_POST['Back'] ) ) {
				echo "
				<SCRIPT LANGUAGE='JavaScript'>
				window.location='supporter.php?page=bulk-upgrades';
				</script>
				";
			} else {
				$supporter_credits = supporter_get_credits($user_ID);
				if ( $supporter_credits < 1 ) {
					die( __('You must purchase supporter credits in order to upgrade blogs.') );	
				}
				$upgraded_blogs = 0;
				$now = time();
				$blogs = $_POST['blogs'];
				foreach ( $blogs as $blog_ID => $value) {
					if ( $supporter_credits > 0 && $value == '1' ) {
						$supporter_check = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "supporters WHERE blog_ID = '" . $blog_ID . "' AND expire > '" . $now . "'");
						if ( $supporter_check < 1 ) {
							$supporter_credits = $supporter_credits - 1;
							$upgraded_blogs = $upgraded_blogs + 1;
							supporter_extend($blog_ID, 31556926);
						}
					}
				}
				supporter_debit_credits($user_ID, $upgraded_blogs);
				echo "
				<SCRIPT LANGUAGE='JavaScript'>
				window.location='supporter.php?page=bulk-upgrades&updated=true&updatedmsg=" . urlencode(__('Blogd upgraded.')) . "';
				</script>
				";
			}
		break;
		//---------------------------------------------------//
		case "temp":
		break;
		//---------------------------------------------------//
	}
	echo '</div>';
}

?>