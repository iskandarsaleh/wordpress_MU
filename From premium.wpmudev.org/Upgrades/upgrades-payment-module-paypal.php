<?php
/*
Plugin Name: Upgrades (Payment Module: PayPal)
Plugin URI: 
Description:
Author: Andrew Billits (Incsub)
Version: 1.4.2
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
add_action('upgrades_payment_module_options', 'upgrades_payment_module_paypal_options');
add_action('upgrades_payment_module_process', 'upgrades_payment_module_paypal_process');
add_action('upgrades_payment_module_buy', 'upgrades_payment_module_paypal_buy_output');

add_action('upgrades_payment_module_buy_5', 'upgrades_payment_module_paypal_buy_5');
add_action('upgrades_payment_module_buy_10', 'upgrades_payment_module_paypal_buy_10');
add_action('upgrades_payment_module_buy_25', 'upgrades_payment_module_paypal_buy_25');
add_action('upgrades_payment_module_buy_50', 'upgrades_payment_module_paypal_buy_50');
add_action('upgrades_payment_module_buy_75', 'upgrades_payment_module_paypal_buy_75');
add_action('upgrades_payment_module_buy_100', 'upgrades_payment_module_paypal_buy_100');
//------------------------------------------------------------------------//
//---Functions------------------------------------------------------------//
//------------------------------------------------------------------------//
function upgrades_payment_module_paypal_process(){
	global $wpdb, $current_site;
	update_site_option( "upgrades_paypal_email", $_POST['upgrades_paypal_email'] );
	update_site_option( "upgrades_paypal_site", $_POST['upgrades_paypal_site'] );
	update_site_option( "upgrades_paypal_status", $_POST['upgrades_paypal_status'] );
}
//------------------------------------------------------------------------//
//---Output Functions-----------------------------------------------------//
//------------------------------------------------------------------------//
function upgrades_payment_module_paypal_options(){
	global $wpdb, $current_site;
	?>
    <h3><?php _e('PayPal Options'); ?></h3>
    <table class="form-table">
        <tr valign="top"> 
        <th scope="row"><?php _e('PayPal Email') ?></th> 
        <td><input type="text" name="upgrades_paypal_email" value="<?php echo get_site_option( "upgrades_paypal_email" ); ?>" />
        <br />
        <?php //_e('Format: 00.00 - Ex: 1.25') ?></td> 
        </tr>
        <tr valign="top"> 
        <th scope="row"><?php _e('PayPal Site') ?></th> 
        <td><select name="upgrades_paypal_site">
        <?php
            $tmp_upgrades_paypal_site = get_site_option( "upgrades_paypal_site" );
            $sel_locale = empty($tmp_upgrades_paypal_site) ? 'US' : $tmp_upgrades_paypal_site;
            $locales = array(
                'AU'	=> 'Australia',
                'AT'	=> 'Austria',
                'BE'	=> 'Belgium',
                'CA'	=> 'Canada',
                'CN'	=> 'China',
                'FR'	=> 'France',
                'DE'	=> 'Germany',
                'IT'	=> 'Italy',
                'NL'	=> 'Netherlands',
                'PL'	=> 'Poland',
                'ES'	=> 'Spain',
                'CH'	=> 'Switzerland',
                'GB'	=> 'United Kingdom',
                'US'	=> 'United States'
                );
        
            foreach ($locales as $k => $v) {
                echo '		<option value="' . $k . '"' . ($k == $sel_locale ? ' selected' : '') . '>' . wp_specialchars($v, true) . '</option>' . "\n";
            }
        ?>
        </select>
        <br />
        <?php //_e('Format: 00.00 - Ex: 1.25') ?></td> 
        </tr> 
        <tr valign="top"> 
        <th scope="row"><?php _e('PayPal Mode') ?></th> 
        <td><select name="upgrades_paypal_status">
        <option value="live" <?php if (get_site_option( "upgrades_paypal_status" ) == 'live') echo 'selected="selected"'; ?>><?php _e('Live Site') ?></option>
        <option value="test" <?php if (get_site_option( "upgrades_paypal_status" ) == 'test') echo 'selected="selected"'; ?>><?php _e('Test Mode (Sandbox)') ?></option>
        </select>
        <br />
        <?php //_e('Format: 00.00 - Ex: 1.25') ?></td> 
        </tr>
    </table>
    <?php
}

function upgrades_payment_module_paypal_button_output($tmp_credits) {
	global $wpdb, $current_site, $current_user;
	// Live URL:	https://www.paypal.com/cgi-bin/webscr
	// Sandbox URL:	https://www.sandbox.paypal.com/cgi-bin/webscr
	if (get_site_option( "upgrades_paypal_status" ) == 'live'){
		$action = 'https://www.paypal.com/cgi-bin/webscr';
	} else {
		$action = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
	}
	$blog_url = get_blogaddress_by_id($wpdb->blogid);
	$tmp_amount = get_site_option( "upgrades_cost_per_credit" );
	$tmp_amount = $tmp_amount * $tmp_credits;
	$tmp_button = '
	<form action="' . $action . '" method="post">
		<input type="hidden" name="cmd" value="_xclick">
		<input type="hidden" name="business" value="' . get_site_option( "upgrades_paypal_email" ) . '">
		<input type="hidden" name="item_name" value="' . $current_site->site_name . ' Credits">
		<input type="hidden" name="item_number" value="' . $tmp_credits . '">
		<input type="hidden" name="amount" value="' . $tmp_amount . '">
		<input type="hidden" name="no_shipping" value="1">
		<input type="hidden" name="return" value="' . $blog_url . 'wp-admin/upgrades.php?page=upgrades_credits&updated=true&updatedmsg=' . urlencode(__('Transaction Complete!')) . '">
		<input type="hidden" name="cancel_return" value="' . $blog_url . 'wp-admin/upgrades.php?page=upgrades_credits&updated=true&updatedmsg=' . urlencode(__('Transaction Canceled!')) . '">
		<input type="hidden" name="notify_url" value="' . $blog_url . 'paypal.php">
		<input type="hidden" name="no_note" value="1">
		<input type="hidden" name="currency_code" value="' . get_site_option( "upgrades_currency" ) . '">
		<input type="hidden" name="lc" value="' . get_site_option( "upgrades_paypal_site" ) . '">
		<input type="hidden" name="custom" value="' . $tmp_credits . '_' . $tmp_amount . '_' . get_site_option( "upgrades_currency" ) . '_' . $current_user->ID . '">
		<input type="hidden" name="bn" value="PP-BuyNowBF">
		<p class="submit" style="border:none;padding-top:2px;">
		<input type="submit" name="Submit" value="PayPal">
		</p>
	</form>
	';
	echo $tmp_button;
}

//------------------------------------------------------------------------//
//---Page Output Functions------------------------------------------------//
//------------------------------------------------------------------------//
function upgrades_payment_module_paypal_buy_5(){
	upgrades_payment_module_paypal_button_output('5');
}
function upgrades_payment_module_paypal_buy_10(){
	upgrades_payment_module_paypal_button_output('10');
}
function upgrades_payment_module_paypal_buy_25(){
	upgrades_payment_module_paypal_button_output('25');
}
function upgrades_payment_module_paypal_buy_50(){
	upgrades_payment_module_paypal_button_output('50');
}
function upgrades_payment_module_paypal_buy_75(){
	upgrades_payment_module_paypal_button_output('75');
}
function upgrades_payment_module_paypal_buy_100(){
	upgrades_payment_module_paypal_button_output('100');
}
?>
