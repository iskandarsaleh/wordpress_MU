<?php
/*
Plugin Name: Upgrades (Payment Module: WorldPay)
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
add_action('upgrades_payment_module_options', 'upgrades_payment_module_worldpay_options');
add_action('upgrades_payment_module_process', 'upgrades_payment_module_worldpay_process');
add_action('upgrades_payment_module_buy', 'upgrades_payment_module_worldpay_buy_output');

add_action('upgrades_payment_module_buy_5', 'upgrades_payment_module_worldpay_buy_5');
add_action('upgrades_payment_module_buy_10', 'upgrades_payment_module_worldpay_buy_10');
add_action('upgrades_payment_module_buy_25', 'upgrades_payment_module_worldpay_buy_25');
add_action('upgrades_payment_module_buy_50', 'upgrades_payment_module_worldpay_buy_50');
add_action('upgrades_payment_module_buy_75', 'upgrades_payment_module_worldpay_buy_75');
add_action('upgrades_payment_module_buy_100', 'upgrades_payment_module_worldpay_buy_100');
//------------------------------------------------------------------------//
//---Functions------------------------------------------------------------//
//------------------------------------------------------------------------//
function upgrades_payment_module_worldpay_process(){
	global $wpdb, $current_site;
	if (get_site_option( "upgrades_worldpay_id" ) == '') {
		add_site_option( 'upgrades_worldpay_id', $_POST['upgrades_worldpay_id'] );
	} else {
		update_site_option( "upgrades_worldpay_id", $_POST['upgrades_worldpay_id'] );
	}
	if (get_site_option( "upgrades_worldpay_status" ) == '') {
		add_site_option( 'upgrades_worldpay_status', $_POST['upgrades_worldpay_status'] );
	} else {
		update_site_option( "upgrades_worldpay_status", $_POST['upgrades_worldpay_status'] );
	}
}
//------------------------------------------------------------------------//
//---Output Functions-----------------------------------------------------//
//------------------------------------------------------------------------//
function upgrades_payment_module_worldpay_options(){
	global $wpdb, $current_site;
	?>
    <h3><?php _e('WorldPay Options'); ?></h3>
    <table class="form-table">
        <tr valign="top"> 
        <th scope="row"><?php _e('WorldPay ID') ?></th> 
        <td><input type="text" name="upgrades_worldpay_id" value="<?php echo get_site_option( "upgrades_worldpay_id" ); ?>" />
        <br />
        <?php //_e('Format: 00.00 - Ex: 1.25') ?></td> 
        </tr>
        <tr valign="top"> 
        <th scope="row"><?php _e('WorldPay Mode') ?></th> 
        <td><select name="upgrades_worldpay_status">
        <option value="live" <?php if (get_site_option( "upgrades_worldpay_status" ) == 'live') echo 'selected="selected"'; ?>><?php _e('Live Site') ?></option>
        <option value="test" <?php if (get_site_option( "upgrades_worldpay_status" ) == 'test') echo 'selected="selected"'; ?>><?php _e('Test Mode (Sandbox)') ?></option>
        </select>
        <br />
        <?php //_e('Format: 00.00 - Ex: 1.25') ?></td> 
        </tr>
    </table>
    <?php
}

function upgrades_payment_module_worldpay_button_output($tmp_credits) {
	global $wpdb, $current_site, $current_user;
	if (get_site_option( "upgrades_worldpay_status" ) == 'live'){
		$tmp_test_mode = '0';
	} else {
		$tmp_test_mode = '100';
	}
	$blog_url = get_blogaddress_by_id($wpdb->blogid);
	$tmp_amount = get_site_option( "upgrades_cost_per_credit" );
	$tmp_amount = $tmp_amount * $tmp_credits;
	$tmp_button = '
	<form action="https://select.worldpay.com/wcc/purchase" method=POST style="margin:0;padding:0;display:inline;">
		<input type=hidden name="instId" value="' . get_site_option( "upgrades_worldpay_id" ) . '">
		<input type=hidden name="cartId" value="' . $tmp_credits . '_' . $tmp_amount . '_' . get_site_option( "upgrades_currency" ) . '_' . $current_user->ID . '">
		<input type=hidden name="amount" value="' . $tmp_amount . '">
		<input type=hidden name="currency" value="' . get_site_option( "upgrades_currency" ) . '">
		<input type=hidden name="desc" value="' . $current_site->site_name . ' Credits">
		<input type=hidden name="testMode" value="' . $tmp_test_mode . '">
		<input type=hidden name="M_user" value="' . $current_user->ID . '">
		<input type=hidden name="M_credits" value="' . $tmp_credits . '">
		<p class="submit" style="border:none;padding-top:2px;">
		<input type="submit" name="Submit" value="WorldPay">
		</p>
	</form>
	';
	echo $tmp_button;
}

//------------------------------------------------------------------------//
//---Page Output Functions------------------------------------------------//
//------------------------------------------------------------------------//
function upgrades_payment_module_worldpay_buy_5(){
	upgrades_payment_module_worldpay_button_output('5');
}
function upgrades_payment_module_worldpay_buy_10(){
	upgrades_payment_module_worldpay_button_output('10');
}
function upgrades_payment_module_worldpay_buy_25(){
	upgrades_payment_module_worldpay_button_output('25');
}
function upgrades_payment_module_worldpay_buy_50(){
	upgrades_payment_module_worldpay_button_output('50');
}
function upgrades_payment_module_worldpay_buy_75(){
	upgrades_payment_module_worldpay_button_output('75');
}
function upgrades_payment_module_worldpay_buy_100(){
	upgrades_payment_module_worldpay_button_output('100');
}
?>
