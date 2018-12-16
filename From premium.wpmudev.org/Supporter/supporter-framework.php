<?php
/*
Plugin Name: Supporter
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

$supporter_current_version = '1.6.1';
//------------------------------------------------------------------------//
//---Hook-----------------------------------------------------------------//
//------------------------------------------------------------------------//

add_action('admin_menu', 'supporter_plug_pages');
add_filter('wpabar_menuitems', 'supporter_admin_bar');
add_action('admin_head', 'supporter_check');
add_action('wp_head', 'supporter_check');
add_action('wpmu_new_blog', 'supporter_free_days', 1, 1);

if ($_GET['page'] == 'supporter'){
	supporter_make_current();
}

//------------------------------------------------------------------------//
//---Functions------------------------------------------------------------//
//------------------------------------------------------------------------//

function supporter_make_current() {
	global $wpdb, $supporter_current_version;
	if (get_site_option( "supporter_version" ) == '') {
		add_site_option( 'supporter_version', '0.0.0' );
	}
	
	if (get_site_option( "supporter_version" ) == $supporter_current_version) {
		// do nothing
	} else {
		//update to current version
		update_site_option( "supporter_installed", "no" );
		update_site_option( "supporter_version", $supporter_current_version );
	}
	supporter_global_install();
	//--------------------------------------------------//
	if (get_option( "supporter_version" ) == '') {
		add_option( 'supporter_version', '0.0.0' );
	}
	
	if (get_option( "supporter_version" ) == $supporter_current_version) {
		// do nothing
	} else {
		//update to current version
		update_option( "supporter_version", $supporter_current_version );
		supporter_blog_install();
	}
}

function supporter_blog_install() {
	global $wpdb, $supporter_current_version;
	$supporter_hits_table = "";

	//$wpdb->query( $supporter_hits_table );
}

function supporter_global_install() {
	global $wpdb, $supporter_current_version;
	if (get_site_option( "supporter_installed" ) == '') {
		add_site_option( 'supporter_installed', 'no' );
	}
	
	if (get_site_option( "supporter_installed" ) == "yes") {
		// do nothing
	} else {
	
		$supporter_table1 = "CREATE TABLE `" . $wpdb->base_prefix . "supporters` (
  `supporter_ID` bigint(20) unsigned NOT NULL auto_increment,
  `blog_ID` bigint(20) NOT NULL default '0',
  `expire` bigint(20) NOT NULL default '0',
  `note` TEXT,
  PRIMARY KEY  (`supporter_ID`)
) ENGINE=InnoDB;";
		$supporter_table2 = "CREATE TABLE `" . $wpdb->base_prefix . "supporter_transactions` (
  `supporter_transaction_ID` bigint(20) unsigned NOT NULL auto_increment,
  `blog_ID` bigint(20) NOT NULL default '0',
  `paypal_ID` varchar(20),
  `payment_type` varchar(20),
  `stamp` bigint(35) NOT NULL default '0',
  `amount` varchar(35),
  `currency` varchar(35),
  `status` varchar(35),
  PRIMARY KEY  (`supporter_transaction_ID`)
) ENGINE=InnoDB;";
		$supporter_table3 = "";
		$supporter_table4 = "";
		$supporter_table5 = "";

		$wpdb->query( $supporter_table1 );
		$wpdb->query( $supporter_table2 );
		//wpdb->query( $supporter_table3 );
		//$wpdb->query( $supporter_table4 );
		//$wpdb->query( $supporter_table5 );

		update_site_option( "supporter_installed", "yes" );
	}
}

function supporter_plug_pages() {
	global $wpdb, $wp_roles, $current_user;
	if ( is_site_admin() ) {
		add_submenu_page('wpmu-admin.php', __('Supporter'), __('Supporter'), 10, 'supporter', 'supporter_admin_output');
	}
	if ( $wpdb->blogid != 1 ) {
		add_menu_page(__('Supporter'), __('Supporter'), 10, 'supporter.php');
		$supporter_show_transactions_tab = get_site_option( "supporter_show_transactions_tab" );
		if ( $supporter_show_transactions_tab == 'yes' || empty( $supporter_show_transactions_tab ) ) {
			$transaction_count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "supporter_transactions WHERE blog_ID = '" . $wpdb->blogid . "'");
			if ( $transaction_count > 0 ) {
				add_submenu_page('supporter.php', __('Transactions'), __('Transactions'), 10, 'transactions', 'supporter_transactions');
			}
		}
	}
	do_action('supporter_plug_pages');
}

function supporter_admin_bar( $menu ) {
	unset( $menu['supporter.php'] );
	return $menu;
}

function supporter_free_days($blog_ID) {
	$supporter_free_days = get_site_option('supporter_free_days');
	if ( $supporter_free_days > 0 ) {
		$extend = $supporter_free_days * 86400;
		supporter_extend($blog_ID, $extend);
	}
}

function supporter_check() {
	if (  is_supporter() ) {
		do_action('supporter_active');
	} else {
		do_action('supporter_inactive');
	}
}

function supporter_insert_update_transaction($blog_ID, $paypal_id, $payment_type, $stamp, $amount, $currency, $status) {
	global $wpdb;
	
	$transaction_count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "supporter_transactions WHERE paypal_ID = '" . $paypal_id . "'");

	if ( $transaction_count > 0 ) {
		$wpdb->query("UPDATE " . $wpdb->base_prefix . "supporter_transactions SET status = '" . $status . "' WHERE paypal_ID = '" . $paypal_id . "'");
	} else {
		$wpdb->query( "INSERT INTO " . $wpdb->base_prefix . "supporter_transactions (blog_ID, paypal_ID, payment_type, stamp, amount, currency, status) VALUES ( '" . $blog_ID . "', '" . $paypal_id . "', '" . $payment_type . "', '" . $stamp . "', '" . $amount . "', '" . $currency . "', '" . $status . "' )" );
	}

}

function supporter_extend($blog_ID, $extend) {
	global $wpdb;

	$now = time();

	$blog_count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "supporters WHERE blog_ID = '" . $blog_ID . "'");

	if ( $blog_count > 0 ) {
		$old_expire = $wpdb->get_var("SELECT expire FROM " . $wpdb->base_prefix . "supporters WHERE blog_ID = '" . $blog_ID . "'");
		if ( $now > $current_expire ) {
			$old_expire = $now;
		}
	} else {
		$wpdb->query( "INSERT INTO " . $wpdb->base_prefix . "supporters (blog_ID) VALUES ( '" . $blog_ID . "' )" );
		$old_expire = $now;
	}

	if ( $extend == '1' ) {
		$extend = 2629744;
	} else if ( $extend == '3' ) {
		$extend = 7889231;
	} else if ( $extend == '12' ) {
		$extend = 31556926;
	}

	$new_expire = $old_expire + $extend;

    $wpdb->query("UPDATE " . $wpdb->base_prefix . "supporters SET expire = '" . $new_expire . "' WHERE blog_ID = '" . $blog_ID . "'");
	do_action('supporter_extend', $blog_ID, $new_expire);
}

function is_supporter($blog_ID = '') {
	global $wpdb;

	if ( empty( $blog_ID ) ) {
		$blog_ID = $wpdb->blogid;
	}

	if ( $blog_ID == 1 ) {
		return true;
	} else {
		$now = time();
		$expire = supporter_get_expire($blog_ID);
		if ( $expire > $now ) {
			return true;
		} else {
			return false;
		}
	}
}

function supporter_get_note($blog_ID = '') {
	global $wpdb;

	if ( empty( $blog_ID ) ) {
		$blog_ID = $wpdb->blogid;
	}

	$note = '';

	$blog_count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "supporters WHERE blog_ID = '" . $blog_ID . "'");

	if ( $blog_count > 0 ) {
		$note = $wpdb->get_var("SELECT note FROM " . $wpdb->base_prefix . "supporters WHERE blog_ID = '" . $blog_ID . "'");
		return $note;
	} else {
		return $note;
	}
}

function supporter_get_expire($blog_ID = '') {
	global $wpdb;

	if ( empty( $blog_ID ) ) {
		$blog_ID = $wpdb->blogid;
	}

	$now = time();
	$expire = $now - 3600;

	$blog_count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "supporters WHERE blog_ID = '" . $blog_ID . "'");

	if ( $blog_count > 0 ) {
		$expire = $wpdb->get_var("SELECT expire FROM " . $wpdb->base_prefix . "supporters WHERE blog_ID = '" . $blog_ID . "'");
		return $expire;
	} else {
		return $expire;
	}
}

function supporter_withdraw($blog_ID, $withdraw) {
	global $wpdb;

	$old_expire = $wpdb->get_var("SELECT expire FROM " . $wpdb->base_prefix . "supporters WHERE blog_ID = '" . $blog_ID . "'");

	if ( $withdraw == '1' ) {
		$withdraw = 2629744;
	} else if ( $withdraw == '3' ) {
		$withdraw = 7889231;
	} else if ( $withdraw == '12' ) {
		$withdraw = 31556926;
	}

	$new_expire = $old_expire - $withdraw;

    $wpdb->query("UPDATE " . $wpdb->base_prefix . "supporters SET expire = '" . $new_expire . "' WHERE blog_ID = '" . $blog_ID . "'");
	do_action('supporter_withdraw', $blog_ID, $new_expire);
}

function supporter_update_note($blog_ID, $note = '') {
	global $wpdb;

	$blog_count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "supporters WHERE blog_ID = '" . $blog_ID . "'");

	if ( $blog_count > 0 ) {
	    $wpdb->query("UPDATE " . $wpdb->base_prefix . "supporters SET note = '" . $note . "' WHERE blog_ID = '" . $blog_ID . "'");
	} else {
		$wpdb->query( "INSERT INTO " . $wpdb->base_prefix . "supporters (blog_ID, note) VALUES ( '" . $blog_ID . "', '" . $note . "' )" );
	}
}

function supporter_get_blog_name($blog_ID) {
	global $wpdb, $wp_roles, $current_user;

	$blog_name = stripslashes( get_blog_option( $blog_ID, 'blogname' ) );
	if ( empty( $blog_name ) ) {
		$blog_name = $wpdb->get_var("SELECT domain FROM $wpdb->blogs WHERE blog_id = '" . $blog_ID . "'");
	}
	return $blog_name;
}

//------------------------------------------------------------------------//
//---Output Functions-----------------------------------------------------//
//------------------------------------------------------------------------//

function supporter_list($number = '10', $global_before, $global_after, $before,$after, $dispay_avatar = '', $avatar_size = '', $character_limit = ''){
	global $wpdb, $current_site;
	
	if ($dispay_avatar == 'yes' || $dispay_avatar == 'no'){
		//we're good
	} else {
		$dispay_avatar == 'no';
	}
	
	
	if ($avatar_size == '16' || $avatar_size == '32' || $avatar_size == '48' || $avatar_size == '96' || $avatar_size == '128'){
		//we're good
	} else {
		$avatar_size = '16';
	}
	
	$query = "SELECT blog_ID FROM " . $wpdb->base_prefix . "supporters WHERE expire > '" . time() . "'  ORDER BY RAND() LIMIT " . $number;
	$supporters = $wpdb->get_results( $query, ARRAY_A );

	if ( count( $supporters ) > 0 ) {
		echo $global_before;
		foreach ( $supporters as $supporter ){
		//=========================================================//
			echo $before;
				$blog_domain = $wpdb->get_var("SELECT domain FROM $wpdb->blogs WHERE blog_id = '" . $supporter['blog_ID'] . "'");
				$blog_path = $wpdb->get_var("SELECT path FROM $wpdb->blogs WHERE blog_id = '" . $supporter['blog_ID'] . "'");
				$blog_name = supporter_get_blog_name( $supporter['blog_ID'] );
				if ( !empty( $character_limit ) ) {
					$char_count = strlen($blog_name);
					if ($char_count > $character_limit){
						$blog_name = substr($blog_name, 0, $character_limit);
						$blog_name = rtrim($blog_name);
						$blog_name = $blog_name;
					}
				}
				if ($dispay_avatar == "yes"){
					echo "<img src='http://" . $blog_domain . $blog_path . "avatar/blog-" . $supporter['blog_ID'] . "-" . $avatar_size . ".png'/> <a href='http://" . $blog_domain . $blog_path . "'>" . $blog_name . "</a";		
				} else {
					echo "<a href='http://" . $blog_domain . $blog_path . "'>" . $blog_name . "</a";
				}
			echo $after;
		//=========================================================//
		}
		echo $global_after;
	} else {
		//nothing to display
	}
}

function supporter_paypal_button_output($period) {
	global $wpdb, $current_site, $current_user;
	// Live URL:	https://www.paypal.com/cgi-bin/webscr
	// Sandbox URL:	https://www.sandbox.paypal.com/cgi-bin/webscr
	if (get_site_option( "supporter_paypal_status" ) == 'live'){
		$action = 'https://www.paypal.com/cgi-bin/webscr';
	} else {
		$action = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
	}
	$blog_url = get_blogaddress_by_id($wpdb->blogid);
	if ( $period == '1' ) {
		$amount = get_site_option( "supporter_1_whole_cost" ) . '.' . get_site_option( "supporter_1_partial_cost" );
	} else if ( $period == '3' ) {
		$amount = get_site_option( "supporter_3_whole_cost" ) . '.' . get_site_option( "supporter_3_partial_cost" );
	} else if ( $period == '12' ) {
		$amount = get_site_option( "supporter_12_whole_cost" ) . '.' . get_site_option( "supporter_12_partial_cost" );
	}
	if ( get_site_option( "supporter_paypal_payment_type" ) == 'single' ) {
		$button = '
		<form action="' . $action . '" method="post">
			<input type="hidden" name="cmd" value="_xclick">
			<input type="hidden" name="business" value="' . get_site_option( "supporter_paypal_email" ) . '">
			<input type="hidden" name="item_name" value="' . $current_site->site_name . ' Supporter">
			<input type="hidden" name="item_number" value="' . $period . '">
			<input type="hidden" name="amount" value="' . $amount . '">
			<input type="hidden" name="no_shipping" value="1">
			<input type="hidden" name="return" value="' . $blog_url . 'wp-admin/supporter.php?updated=true&updatedmsg=' . urlencode(__('Transaction Complete!')) . '">
			<input type="hidden" name="cancel_return" value="' . $blog_url . 'wp-admin/supporter.php?updated=true&updatedmsg=' . urlencode(__('Transaction Canceled!')) . '">
			<input type="hidden" name="notify_url" value="' . $blog_url . 'supporter-paypal.php">
			<input type="hidden" name="no_note" value="1">
			<input type="hidden" name="currency_code" value="' . get_site_option( "supporter_currency" ) . '">
			<input type="hidden" name="lc" value="' . get_site_option( "supporter_paypal_site" ) . '">
			<input type="hidden" name="custom" value="' . $wpdb->blogid . '_' . $period . '_' . $amount . '_' . get_site_option( "supporter_currency" ) . '_' . time() . '">
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
			<input type="hidden" name="return" value="' . $blog_url . 'wp-admin/supporter.php?updated=true&updatedmsg=' . urlencode(__('Transaction Complete!')) . '">
			<input type="hidden" name="cancel_return" value="' . $blog_url . 'wp-admin/supporter.php?updated=true&updatedmsg=' . urlencode(__('Transaction Canceled!')) . '">
			<input type="hidden" name="notify_url" value="' . $blog_url . 'supporter-paypal.php">
			<input type="hidden" name="no_note" value="1">
			<input type="hidden" name="currency_code" value="' . get_site_option( "supporter_currency" ) . '">
			<input type="hidden" name="lc" value="' . get_site_option( "supporter_paypal_site" ) . '">
			<input type="hidden" name="custom" value="' . $wpdb->blogid . '_' . $period . '_' . $amount . '_' . get_site_option( "supporter_currency" ) . '_' . time() . '">
			<input type="hidden" name="a3" value="' . $amount . '">
			<input type="hidden" name="p3" value="' . $period . '">
			<input type="hidden" name="t3" value="M">
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

function supporter_feature_notice() {
	$supporter_feature_message = stripslashes( get_site_option('supporter_feature_message') );
	if ( empty( $supporter_feature_message ) ) {
		$supporter_feature_message = 'This feature is limited to supporters only. <a href="supporter.php">Click here to find out how to become a supporter</a>.';
	}
	echo '<div id="message" class="error"><p>' . $supporter_feature_message . '</p></div>';
}

//------------------------------------------------------------------------//
//---Page Output Functions------------------------------------------------//
//------------------------------------------------------------------------//

function supporter_admin_output() {
	global $wpdb, $wp_roles, $current_user;
	
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
			$supporter_feature_message = stripslashes( get_site_option('supporter_feature_message') );
			if ( empty( $supporter_feature_message ) ) {
				$supporter_feature_message = 'This feature is limited to supporters only. <a href="supporter.php">Click here to find out how to become a supporter</a>.';
			}
			$supporter_single_expire_message = stripslashes( get_site_option('supporter_single_expire_message') );
			if ( empty( $supporter_single_expire_message ) ) {
				$supporter_single_expire_message = 'Your supporter privileges will expire on: DATE';
			}
			$supporter_recurring_expire_message = stripslashes( get_site_option('supporter_recurring_expire_message') );
			if ( empty( $supporter_recurring_expire_message ) ) {
				$supporter_recurring_expire_message = 'Your supporter privileges will expire on: DATE<br />Unless you have canceled your subscription via PayPal or your blog was upgraded via the Bulk Upgrades tool, your supporter privileges will automatically be renewed.';
			}
			$supporter_payment_message = stripslashes( get_site_option('supporter_payment_message') );
			if ( empty( $supporter_payment_message ) ) {
				$supporter_payment_message = 'Depending on your payment method it may take just a few minutes (Credit Card or PayPal funds) or it may take several days (eCheck) for your account to be activated.';
			}
			$supporter_1_single_payment_message = stripslashes( get_site_option('supporter_1_single_payment_message') );
			if ( empty( $supporter_1_single_payment_message ) ) {
				$supporter_1_single_payment_message = 'Activate supporter privileges for one month (for AMOUNT CURRENCY):';
			}
			$supporter_3_single_payment_message = stripslashes( get_site_option('supporter_3_single_payment_message') );
			if ( empty( $supporter_3_single_payment_message ) ) {
				$supporter_3_single_payment_message = 'Activate supporter privileges for three months (for AMOUNT CURRENCY):';
			}
			$supporter_12_single_payment_message = stripslashes( get_site_option('supporter_12_single_payment_message') );
			if ( empty( $supporter_12_single_payment_message ) ) {
				$supporter_12_single_payment_message = 'Activate supporter privileges for twelve months (for AMOUNT CURRENCY):';
			}
			$supporter_1_recurring_payment_message = stripslashes( get_site_option('supporter_1_recurring_payment_message') );
			if ( empty( $supporter_1_recurring_payment_message ) ) {
				$supporter_1_recurring_payment_message = 'Activate supporter privileges with a one month recurring subscription (for AMOUNT CURRENCY each month):';
			}
			$supporter_3_recurring_payment_message = stripslashes( get_site_option('supporter_3_recurring_payment_message') );
			if ( empty( $supporter_3_recurring_payment_message ) ) {
				$supporter_3_recurring_payment_message = 'Activate supporter privileges with a three month recurring subscription (for AMOUNT CURRENCY every three months):';
			}
			$supporter_12_recurring_payment_message = stripslashes( get_site_option('supporter_12_recurring_payment_message') );
			if ( empty( $supporter_12_recurring_payment_message ) ) {
				$supporter_12_recurring_payment_message = 'Activate supporter privileges with a twelve month recurring subscription (for AMOUNT CURRENCY every twelve months):';
			}
			?>
			<h2><?php _e('Supporter') ?></h2>
            <h3><?php _e('Statistics') ?></h3>
            <?php
			$active_supporters = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "supporters WHERE expire > '" . time() . "'");
			$total_transactions = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "supporter_transactions");
			$refunded_transactions = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "supporter_transactions WHERE status = 'Refunded'");
			$reversed_transactions = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "supporter_transactions WHERE status = 'Reversed'");
			?>
            <ul>
                <li><strong><?php _e('Active Supporters'); ?>:</strong> <?php echo $active_supporters; ?></li>
                <li><strong><?php _e('Total Transactions'); ?>:</strong> <?php echo $total_transactions; ?></li>
                <li><strong><?php _e('Refunded Transactions'); ?>:</strong> <?php echo $refunded_transactions; ?></li>
                <li><strong><?php _e('Reversed Transactions'); ?>:</strong> <?php echo $reversed_transactions; ?></li>
            </ul>
            <h3><?php _e('Extend Blog') ?></h3>
            <form method="post" action="wpmu-admin.php?page=supporter&action=extend">
            <table class="form-table">
                <tr valign="top"> 
                <th scope="row"><?php _e('Blog ID') ?></th> 
                <td><input type="text" name="bid" value="" />
                <br />
                <?php //_e('Format: 00.00 - Ex: 1.25') ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Period') ?></th> 
                <td><select name="extend_period">
				<?php
					$counter = 0;
					for ( $counter = 1; $counter <= 365; $counter += 1) {
                        echo '<option value="' . $counter . '">' . $counter . '</option>' . "\n";
					}
                ?>
                </select>
                <br /><?php _e('Period (in days) you wish to extend the blog.'); ?></td> 
                </tr>
            </table>
            
            <p class="submit">
            <input type="submit" name="Submit" value="<?php _e('Continue') ?>" />
            </p>
            </form>
            <h3><?php _e('Transactions') ?></h3>
            <form method="post" action="wpmu-admin.php?page=supporter&action=transactions">
            <table class="form-table">
                <tr valign="top"> 
                <th scope="row"><?php _e('Blog ID') ?></th> 
                <td><input type="text" name="bid" value="" />
                <br />
                <?php //_e('Format: 00.00 - Ex: 1.25') ?></td> 
                </tr>
            </table>
            
            <p class="submit">
            <input type="submit" name="Submit" value="<?php _e('Continue') ?>" />
            </p>
            </form>
            <h3><?php _e('Settings') ?></h3>
            <form method="post" action="wpmu-admin.php?page=supporter&action=process">
            <table class="form-table">
                <tr valign="top"> 
                <th scope="row"><?php _e('Currency') ?></th> 
                <td><select name="supporter_currency">
				<?php
					$supporter_currency = get_site_option( "supporter_currency" );
                    $sel_currency = empty($supporter_currency) ? 'USD' : $supporter_currency;
                    $currencies = array(
                        'AUD' => 'AUD - Australian Dollar',
                        'CAD' => 'CAD - Canadian Dollar',
                        'CHF' => 'CHF - Swiss Franc',
                        'CZK' => 'CZK - Czech Koruna',
                        'DKK' => 'DKK - Danish Krone',
                        'EUR' => 'EUR - Euro',
                        'GBP' => 'GBP - Pound Sterling',
                        'HKD' => 'HKD - Hong Kong Dollar',
                        'HUF' => 'HUF - Hungarian Forint',
                        'JPY' => 'JPY - Japanese Yen',
                        'NOK' => 'NOK - Norwegian Krone',
                        'NZD' => 'NZD - New Zealand Dollar',
                        'PLN' => 'PLN - Polish Zloty',
                        'SEK' => 'SEK - Swedish Krona',
                        'SGD' => 'SGD - Singapore Dollar',
                        'USD' => 'USD - U.S. Dollar'
                        );
                
                    foreach ($currencies as $k => $v) {
                        echo '		<option value="' . $k . '"' . ($k == $sel_currency ? ' selected' : '') . '>' . wp_specialchars($v, true) . '</option>' . "\n";
                    }
                ?>
                </select>
                <br /><?php //_e('') ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('PayPal Email') ?></th> 
                <td><input type="text" name="supporter_paypal_email" value="<?php echo get_site_option( "supporter_paypal_email" ); ?>" />
                <br />
                <?php //_e('Format: 00.00 - Ex: 1.25') ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('PayPal Site') ?></th> 
                <td><select name="supporter_paypal_site">
                <?php
                    $supporter_paypal_site = get_site_option( "supporter_paypal_site" );
                    $sel_locale = empty($supporter_paypal_site) ? 'US' : $supporter_paypal_site;
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
                <td><select name="supporter_paypal_status">
                <option value="live" <?php if (get_site_option( "supporter_paypal_status" ) == 'live') echo 'selected="selected"'; ?>><?php _e('Live Site') ?></option>
                <option value="test" <?php if (get_site_option( "supporter_paypal_status" ) == 'test') echo 'selected="selected"'; ?>><?php _e('Test Mode (Sandbox)') ?></option>
                </select>
                <br />
                <?php //_e('Format: 00.00 - Ex: 1.25') ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('PayPal Payment Type') ?></th> 
                <td><select name="supporter_paypal_payment_type">
                <option value="single" <?php if (get_site_option( "supporter_paypal_payment_type" ) == 'single') echo 'selected="selected"'; ?>><?php _e('Single') ?></option>
                <option value="recurring" <?php if (get_site_option( "supporter_paypal_payment_type" ) == 'recurring') echo 'selected="selected"'; ?>><?php _e('Recurring') ?></option>
                </select>
                <br />
                <?php _e('Recurring = PayPal Subscription') ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('1 Month') ?></th> 
                <td><select name="supporter_1_whole_cost">
				<?php
					$supporter_1_whole_cost = get_site_option( "supporter_1_whole_cost" );
					$counter = 0;
					for ( $counter = 1; $counter <= 300; $counter += 1) {
                        echo '<option value="' . $counter . '"' . ($counter == $supporter_1_whole_cost ? ' selected' : '') . '>' . $counter . '</option>' . "\n";
					}
                ?>
                </select>
                .
				<select name="supporter_1_partial_cost">
				<?php
					$supporter_1_partial_cost = get_site_option( "supporter_1_partial_cost" );
					$counter = 0;
                    echo '<option value="00"' . ('00' == $supporter_1_partial_cost ? ' selected' : '') . '>00</option>' . "\n";
					for ( $counter = 1; $counter <= 99; $counter += 1) {
						if ( $counter < 10 ) {
							$number = '0' . $counter;
						} else {
							$number = $counter;
						}
                        echo '<option value="' . $number . '"' . ($number == $supporter_1_partial_cost ? ' selected' : '') . '>' . $number . '</option>' . "\n";
					}
                ?>
                </select>
                <br /><?php _e('Cost for one month in the currency selected above.'); ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('3 Months') ?></th> 
                <td><select name="supporter_3_whole_cost">
				<?php
					$supporter_3_whole_cost = get_site_option( "supporter_3_whole_cost" );
					$counter = 0;
					for ( $counter = 1; $counter <= 300; $counter += 1) {
                        echo '<option value="' . $counter . '"' . ($counter == $supporter_3_whole_cost ? ' selected' : '') . '>' . $counter . '</option>' . "\n";
					}
                ?>
                </select>
                .
				<select name="supporter_3_partial_cost">
				<?php
					$supporter_3_partial_cost = get_site_option( "supporter_3_partial_cost" );
					$counter = 0;
                    echo '<option value="00"' . ('00' == $supporter_3_partial_cost ? ' selected' : '') . '>00</option>' . "\n";
					for ( $counter = 1; $counter <= 99; $counter += 1) {
						if ( $counter < 10 ) {
							$number = '0' . $counter;
						} else {
							$number = $counter;
						}
                        echo '<option value="' . $number . '"' . ($number == $supporter_3_partial_cost ? ' selected' : '') . '>' . $number . '</option>' . "\n";
					}
                ?>
                </select>
                <br /><?php _e('Cost for three months in the currency selected above.'); ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('12 Months') ?></th> 
                <td><select name="supporter_12_whole_cost">
				<?php
					$supporter_12_whole_cost = get_site_option( "supporter_12_whole_cost" );
					$counter = 0;
					for ( $counter = 1; $counter <= 300; $counter += 1) {
                        echo '<option value="' . $counter . '"' . ($counter == $supporter_12_whole_cost ? ' selected' : '') . '>' . $counter . '</option>' . "\n";
					}
                ?>
                </select>
                .
				<select name="supporter_12_partial_cost">
				<?php
					$supporter_12_partial_cost = get_site_option( "supporter_12_partial_cost" );
					$counter = 0;
                    echo '<option value="00"' . ('00' == $supporter_12_partial_cost ? ' selected' : '') . '>00</option>' . "\n";
					for ( $counter = 1; $counter <= 99; $counter += 1) {
						if ( $counter < 10 ) {
							$number = '0' . $counter;
						} else {
							$number = $counter;
						}
                        echo '<option value="' . $number . '"' . ($number == $supporter_12_partial_cost ? ' selected' : '') . '>' . $number . '</option>' . "\n";
					}
                ?>
                </select>
                <br /><?php _e('Cost for one year in the currency selected above.'); ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Free Days') ?></th> 
                <td><select name="supporter_free_days">
				<?php
					$supporter_free_days = get_site_option( "supporter_free_days" );
					$counter = 0;
					for ( $counter = 0; $counter <=  365; $counter += 1) {
                        echo '<option value="' . $counter . '"' . ($counter == $supporter_free_days ? ' selected' : '') . '>' . $counter . '</option>' . "\n";
					}
                ?>
                </select>
                <br /><?php _e('Free days for all new blogs.'); ?></td> 
                </tr>
                <tr valign="top">
                <th scope="row"><?php _e('Supporter Message') ?></th>
                <td>
                <textarea name="supporter_message" type="text" rows="10" wrap="soft" id="supporter_message" style="width: 95%"/><?php echo stripslashes( get_site_option('supporter_message') ) ?></textarea>
                <br /><?php _e('Optional - HTML allowed - This message is displayed at the top of the "Supporter" page.') ?></td>
                </tr>
                <tr valign="top">
                <th scope="row"><?php _e('Supporter Feature Message') ?></th>
                <td>
                <textarea name="supporter_feature_message" type="text" rows="10" wrap="soft" id="supporter_feature_message" style="width: 95%"/><?php echo $supporter_feature_message ?></textarea>
                <br /><?php _e('Required - HTML allowed - This message is displayed when a supporter-only feature is accessed on a non-supporter blog.') ?></td>
                </tr>
                <tr valign="top">
                <th scope="row"><?php _e('Single Payment Message') ?></th>
                <td>
                <textarea name="supporter_single_expire_message" type="text" rows="5" wrap="soft" id="supporter_single_expire_message" style="width: 95%"/><?php echo $supporter_single_expire_message; ?></textarea>
                <br /><?php _e('Required - HTML allowed - If you selected "Single" for the "PayPal Payment Type" abovem this message will be shown.') ?>
                <br /><?php echo '"DATE"' . __('will be replaced with the expiration date.') ?></td>
                </tr>
                <tr valign="top">
                <th scope="row"><?php _e('Recurring Payment Message') ?></th>
                <td>
                <textarea name="supporter_recurring_expire_message" type="text" rows="5" wrap="soft" id="supporter_recurring_expire_message" style="width: 95%"/><?php echo $supporter_recurring_expire_message; ?></textarea>
                <br /><?php _e('Required - HTML allowed - If you selected "Recurring" for the "PayPal Payment Type" abovem this message will be shown.') ?>
                <br /><?php echo '"DATE"' . ' ' . __('will be replaced with the expiration date.') ?></td>
                </tr>
                <tr valign="top">
                <th scope="row"><?php _e('Payment Message') ?></th>
                <td>
                <textarea name="supporter_payment_message" type="text" rows="5" wrap="soft" id="supporter_payment_message" style="width: 95%"/><?php echo $supporter_payment_message; ?></textarea>
                <br /><?php _e('Required - HTML allowed') ?></td>
                </tr>
                <tr valign="top">
                <th scope="row"><?php _e('1 Month Single Payment Message') ?></th>
                <td>
                <textarea name="supporter_1_single_payment_message" type="text" rows="3" wrap="soft" id="supporter_1_single_payment_message" style="width: 95%"/><?php echo $supporter_1_single_payment_message; ?></textarea>
                <br /><?php _e('Required - HTML allowed') ?>
                <br /><?php echo '"AMOUNT"' . ' ' . _('Will be replaced by the amount chosen above') ?>
                <br /><?php echo '"CURRENCY"' . ' ' . _('Will be replaced by the currency chosen above') ?></td>
                </tr>
                <tr valign="top">
                <th scope="row"><?php _e('3 Month Single Payment Message') ?></th>
                <td>
                <textarea name="supporter_3_single_payment_message" type="text" rows="3" wrap="soft" id="supporter_3_single_payment_message" style="width: 95%"/><?php echo $supporter_3_single_payment_message; ?></textarea>
                <br /><?php _e('Required - HTML allowed') ?>
                <br /><?php echo '"AMOUNT"' . ' ' . _('Will be replaced by the amount chosen above') ?>
                <br /><?php echo '"CURRENCY"' . ' ' . _('Will be replaced by the currency chosen above') ?></td>
                </tr>
                <tr valign="top">
                <th scope="row"><?php _e('12 Month Single Payment Message') ?></th>
                <td>
                <textarea name="supporter_12_single_payment_message" type="text" rows="3" wrap="soft" id="supporter_12_single_payment_message" style="width: 95%"/><?php echo $supporter_12_single_payment_message; ?></textarea>
                <br /><?php _e('Required - HTML allowed') ?>
                <br /><?php echo '"AMOUNT"' . ' ' . _('Will be replaced by the amount chosen above') ?>
                <br /><?php echo '"CURRENCY"' . ' ' . _('Will be replaced by the currency chosen above') ?></td>
                </tr>
                <tr valign="top">
                <th scope="row"><?php _e('1 Month Recurring Payment Message') ?></th>
                <td>
                <textarea name="supporter_1_recurring_payment_message" type="text" rows="3" wrap="soft" id="supporter_1_recurring_payment_message" style="width: 95%"/><?php echo $supporter_1_recurring_payment_message; ?></textarea>
                <br /><?php _e('Required - HTML allowed') ?>
                <br /><?php echo '"AMOUNT"' . ' ' . _('Will be replaced by the amount chosen above') ?>
                <br /><?php echo '"CURRENCY"' . ' ' . _('Will be replaced by the currency chosen above') ?></td>
                </tr>
                <tr valign="top">
                <th scope="row"><?php _e('3 Month Recurring Payment Message') ?></th>
                <td>
                <textarea name="supporter_3_recurring_payment_message" type="text" rows="3" wrap="soft" id="supporter_3_recurring_payment_message" style="width: 95%"/><?php echo $supporter_3_recurring_payment_message; ?></textarea>
                <br /><?php _e('Required - HTML allowed') ?>
                <br /><?php echo '"AMOUNT"' . ' ' . _('Will be replaced by the amount chosen above') ?>
                <br /><?php echo '"CURRENCY"' . ' ' .  _('Will be replaced by the currency chosen above') ?></td>
                </tr>
                <tr valign="top">
                <th scope="row"><?php _e('12 Month Recurring Payment Message') ?></th>
                <td>
                <textarea name="supporter_12_recurring_payment_message" type="text" rows="3" wrap="soft" id="supporter_12_recurring_payment_message" style="width: 95%"/><?php echo $supporter_12_recurring_payment_message; ?></textarea>
                <br /><?php _e('Required - HTML allowed') ?>
                <br /><?php echo '"AMOUNT"' . ' ' . _('Will be replaced by the amount chosen above') ?>
                <br /><?php echo '"CURRENCY"' . ' ' . _('Will be replaced by the currency chosen above') ?></td>
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Show Transactions Tab') ?></th> 
                <td><select name="supporter_show_transactions_tab">
                <option value="yes" <?php if (get_site_option( "supporter_show_transactions_tab" ) == 'yes') echo 'selected="selected"'; ?>><?php _e('Yes') ?></option>
                <option value="no" <?php if (get_site_option( "supporter_show_transactions_tab" ) == 'no') echo 'selected="selected"'; ?>><?php _e('No') ?></option>
                </select>
                <br />
                <?php _e('Show the "Transactions" tab under the "Supporter" menu item.') ?></td> 
                </tr>
                <?php
				do_action('supporter_settings');
				?>
            </table>

            <p class="submit">
            <input type="submit" name="Submit" value="<?php _e('Save Changes') ?>" />
            </p>
            </form>

			<?php
		break;
		//---------------------------------------------------//
		case "process":
			update_site_option( "supporter_free_days", $_POST[ 'supporter_free_days' ] );
			update_site_option( "supporter_currency", $_POST[ 'supporter_currency' ] );
			update_site_option( "supporter_paypal_email", $_POST[ 'supporter_paypal_email' ] );
			update_site_option( "supporter_paypal_site", $_POST[ 'supporter_paypal_site' ] );
			update_site_option( "supporter_feature_message", $_POST[ 'supporter_feature_message' ] );
			update_site_option( "supporter_message", $_POST[ 'supporter_message' ] );
			update_site_option( "supporter_paypal_status", $_POST[ 'supporter_paypal_status' ] );
			update_site_option( "supporter_1_whole_cost", $_POST[ 'supporter_1_whole_cost' ] );
			update_site_option( "supporter_1_partial_cost", $_POST[ 'supporter_1_partial_cost' ] );
			update_site_option( "supporter_3_whole_cost", $_POST[ 'supporter_3_whole_cost' ] );
			update_site_option( "supporter_3_partial_cost", $_POST[ 'supporter_3_partial_cost' ] );
			update_site_option( "supporter_12_whole_cost", $_POST[ 'supporter_12_whole_cost' ] );
			update_site_option( "supporter_12_partial_cost", $_POST[ 'supporter_12_partial_cost' ] );
			update_site_option( "supporter_paypal_payment_type", $_POST[ 'supporter_paypal_payment_type' ] );
			update_site_option( "supporter_single_expire_message", $_POST[ 'supporter_single_expire_message' ] );
			update_site_option( "supporter_recurring_expire_message", $_POST[ 'supporter_recurring_expire_message' ] );
			update_site_option( "supporter_payment_message", $_POST[ 'supporter_payment_message' ] );
			update_site_option( "supporter_1_single_payment_message", $_POST[ 'supporter_1_single_payment_message' ] );
			update_site_option( "supporter_3_single_payment_message", $_POST[ 'supporter_3_single_payment_message' ] );
			update_site_option( "supporter_12_single_payment_message", $_POST[ 'supporter_12_single_payment_message' ] );
			update_site_option( "supporter_1_recurring_payment_message", $_POST[ 'supporter_1_recurring_payment_message' ] );
			update_site_option( "supporter_3_recurring_payment_message", $_POST[ 'supporter_3_recurring_payment_message' ] );
			update_site_option( "supporter_12_recurring_payment_message", $_POST[ 'supporter_12_recurring_payment_message' ] );
			update_site_option( "supporter_show_transactions_tab", $_POST[ 'supporter_show_transactions_tab' ] );

			do_action('supporter_settings_process');

			echo "
			<SCRIPT LANGUAGE='JavaScript'>
			window.location='wpmu-admin.php?page=supporter&updated=true&updatedmsg=" . urlencode(__('Changes saved.')) . "';
			</script>
			";
		break;
		//---------------------------------------------------//
		case "extend":
			if ( isset($_POST['Cancel']) ) {
				echo "
				<SCRIPT LANGUAGE='JavaScript'>
				window.location='wpmu-admin.php?page=supporter';
				</script>
				";
			} else {
				$blog_count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "blogs WHERE blog_id = '" . $_POST[ 'bid' ] . "'");
				if ( $blog_count > 0 ) {
					$extend = $_POST[ 'extend_period' ];
					$extend = $extend * 86400;
					supporter_extend($_POST[ 'bid' ], $extend);
					supporter_update_note($_POST[ 'bid' ], '');
					echo "
					<SCRIPT LANGUAGE='JavaScript'>
					window.location='wpmu-admin.php?page=supporter&updated=true&updatedmsg=" . urlencode(__('Blog extended.')) . "';
					</script>
					";
				} else {
					?>
                    <h2><?php _e('Extend Blog') ?></h2>
                    <p><?php _e('Invalid blog ID. Please try again.') ?></p>
                    <form method="post" action="wpmu-admin.php?page=supporter&action=extend">
                    <table class="form-table">
                        <tr valign="top"> 
                        <th scope="row"><?php _e('Blog ID') ?></th> 
                        <td><input type="text" name="bid" value="" />
                        <br />
                        <?php //_e('Format: 00.00 - Ex: 1.25') ?></td> 
                        </tr>
                        <tr valign="top"> 
                        <th scope="row"><?php _e('Period') ?></th> 
                        <td><select name="extend_period">
                        <?php
                            $counter = 0;
                            for ( $counter = 1; $counter <= 365; $counter += 1) {
                                echo '<option value="' . $counter . '">' . $counter . '</option>' . "\n";
                            }
                        ?>
                        </select>
                        <br /><?php _e('Period (in days) you wish to extend the blog.'); ?></td> 
                        </tr>
                    </table>
                    
                    <p class="submit">
                    <input type="submit" name="Cancel" value="<?php _e('Cancel') ?>" />
                    <input type="submit" name="Submit" value="<?php _e('Continue') ?>" />
                    </p>
                    </form>
	    	        <?php
				}
			}
		break;
		//---------------------------------------------------//
		case "transactions":
			?>
            <h2><?php _e('Transactions') ?></h2>
            <?php
			$transaction_count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "supporter_transactions WHERE blog_ID = '" . $_POST[ 'bid' ] . "'");
			if ( $transaction_count > 30 ) {
			?>
            <p><?php _e('Only the thirty most recent transactions are showb.') ?></p>
            <?php
			}
			$query = "SELECT * FROM " . $wpdb->base_prefix . "supporter_transactions WHERE blog_ID = '" . $_POST[ 'bid' ] . "' ORDER BY supporter_transaction_ID DESC";
			$transactions = $wpdb->get_results( $query, ARRAY_A );
			echo "
			<table cellpadding='3' cellspacing='3' width='100%' class='widefat'> 
			<thead><tr>
			<th scope='col'>" . __("PayPal Transaction ID") . "</th>
			<th scope='col'>" . __("Date") . "</th>
			<th scope='col'>" . __("Payment Type") . "</th>
			<th scope='col'>" . __("Amount") . "</th>
			<th scope='col'>" . __("Status") . "</th>
			</tr></thead>
			<tbody id='the-list'>
			";
			if (count($transactions) > 0){
				$class = ('alternate' == $class) ? '' : 'alternate';
				foreach ($transactions as $transaction){
				//=========================================================//
				echo "<tr class='" . $class . "'>";
				echo "<td valign='top'><strong>" . $transaction['paypal_ID'] . "</strong></td>";
				echo "<td valign='top'>" . date(get_option('date_format'), $transaction['stamp']) . "</td>";
				$payment_type = $transaction['payment_type'];
				if ( $payment_type == 'instant' ) {
					$payment_type = ucfirst( $payment_type );
				}
				echo "<td valign='top'>" . __($payment_type) . "</td>";
				echo "<td valign='top'>" . $transaction['amount'] . " " . $transaction['currency'] . "</td>";
				echo "<td valign='top'>" . __($transaction['status']) . "</td>";
				echo "</tr>";
				$class = ('alternate' == $class) ? '' : 'alternate';
				//=========================================================//
				}
			}
			?>
			</tbody></table>
            <form method="post" action="wpmu-admin.php?page=supporter">
            <p class="submit">
            <input type="submit" name="Submit" value="<?php _e('Back') ?>" />
            </p>
            </form>
            <?php
		break;
		//---------------------------------------------------//
		case "temp":
		break;
		//---------------------------------------------------//
	}
	echo '</div>';
}

function supporter_output() {
	global $wpdb, $wp_roles, $current_user;
	
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
			$expire = supporter_get_expire();
			$note = supporter_get_note();
			?>
			<h2><?php _e('Supporter') ?></h2>
			<?php
			$supporter_message = stripslashes( get_site_option('supporter_message') );
			if ( !empty( $supporter_message ) ) {
				echo '<p>';
				echo __($supporter_message);
				echo '</p>';
			}
			if ( $expire > $now ) {
				if ( get_site_option( "supporter_paypal_payment_type" ) == 'single' ) {
					$supporter_single_expire_message = stripslashes( get_site_option('supporter_single_expire_message') );
					if ( empty( $supporter_single_expire_message ) ) {
						$supporter_single_expire_message = 'Your supporter privileges will expire on: DATE';
					}
					$supporter_single_expire_message = str_replace("DATE", date(get_option('date_format'), $expire), $supporter_single_expire_message);
					echo '<p>';
					echo __($supporter_single_expire_message);
					echo '</p>';
				} else {
					$supporter_recurring_expire_message = stripslashes( get_site_option('supporter_recurring_expire_message') );
					if ( empty( $supporter_recurring_expire_message ) ) {
						$supporter_recurring_expire_message = 'Your supporter privileges will expire on: DATE<br />Unless you have canceled your subscription via PayPal or your blog was upgraded via the Bulk Upgrades tool, your supporter privileges will automatically be renewed.';
					}
					$supporter_recurring_expire_message = str_replace("DATE", date(get_option('date_format'), $expire), $supporter_recurring_expire_message);
					echo '<p>';
					echo __($supporter_recurring_expire_message);
					echo '</p>';
				}
				if ( !empty( $note ) ) {
					echo '<p><strong>';
					echo __('Note') . ': ' . __($note);
					echo '</strong></p>';
				}
			} else {
				if ( !empty( $note ) ) {
					echo '<p><strong>';
					echo __('Note') . ': ' . __($note);
					echo '</strong></p>';
				}
				$supporter_payment_message = stripslashes( get_site_option('supporter_payment_message') );
				if ( empty( $supporter_payment_message ) ) {
					$supporter_payment_message = 'Depending on your payment method it may take just a few minutes (Credit Card or PayPal funds) or it may take several days (eCheck) for your account to be activated.';
				}
				echo '<p>';
				echo __('Note') . ': ' . __($supporter_payment_message);
				echo '</p>';
				if ( get_site_option( "supporter_paypal_payment_type" ) == 'single' ) {
					$currency = get_site_option( "supporter_currency" );
					$supporter_1_single_payment_message = stripslashes( get_site_option('supporter_1_single_payment_message') );
					if ( empty( $supporter_1_single_payment_message ) ) {
						$supporter_1_single_payment_message = 'Activate supporter privileges for one month (for AMOUNT CURRENCY):';
					}
					$supporter_1_single_payment_message = str_replace("CURRENCY", $currency, $supporter_1_single_payment_message);
					$supporter_1_single_payment_message = str_replace("AMOUNT", get_site_option( "supporter_1_whole_cost" ) . '.' . get_site_option( "supporter_1_partial_cost" ), $supporter_1_single_payment_message);
					$supporter_3_single_payment_message = stripslashes( get_site_option('supporter_3_single_payment_message') );
					if ( empty( $supporter_3_single_payment_message ) ) {
						$supporter_3_single_payment_message = 'Activate supporter privileges for three months (for AMOUNT CURRENCY):';
					}
					$supporter_3_single_payment_message = str_replace("CURRENCY", $currency, $supporter_3_single_payment_message);
					$supporter_3_single_payment_message = str_replace("AMOUNT", get_site_option( "supporter_3_whole_cost" ) . '.' . get_site_option( "supporter_3_partial_cost" ), $supporter_3_single_payment_message);
					$supporter_12_single_payment_message = stripslashes( get_site_option('supporter_12_single_payment_message') );
					if ( empty( $supporter_12_single_payment_message ) ) {
						$supporter_12_single_payment_message = 'Activate supporter privileges for twelve months (for AMOUNT CURRENCY):';
					}
					$supporter_12_single_payment_message = str_replace("CURRENCY", $currency, $supporter_12_single_payment_message);
					$supporter_12_single_payment_message = str_replace("AMOUNT", get_site_option( "supporter_12_whole_cost" ) . '.' . get_site_option( "supporter_12_partial_cost" ), $supporter_12_single_payment_message);
					echo '<p class="submit" style="padding-top:2px;">';
					echo __($supporter_1_single_payment_message);
					echo '<br />';
					echo supporter_paypal_button_output(1);
					echo '</p>';
					echo '<p class="submit" style="padding-top:2px;">';
					echo __($supporter_3_single_payment_message);
					echo '<br />';
					echo supporter_paypal_button_output(3);
					echo '</p>';
					echo '<p class="submit" style="padding-top:2px;">';
					echo __($supporter_12_single_payment_message);
					echo '<br />';
					echo supporter_paypal_button_output(12);
					echo '</p>';
				} else {
					$currency = get_site_option( "supporter_currency" );
					$supporter_1_recurring_payment_message = stripslashes( get_site_option('supporter_1_recurring_payment_message') );
					if ( empty( $supporter_1_recurring_payment_message ) ) {
						$supporter_1_recurring_payment_message = 'Activate supporter privileges with a one month recurring subscription (for AMOUNT CURRENCY each month):';
					}
					$supporter_1_recurring_payment_message = str_replace("CURRENCY", $currency, $supporter_1_recurring_payment_message);
					$supporter_1_recurring_payment_message = str_replace("AMOUNT", get_site_option( "supporter_1_whole_cost" ) . '.' . get_site_option( "supporter_1_partial_cost" ), $supporter_1_recurring_payment_message);
					$supporter_3_recurring_payment_message = stripslashes( get_site_option('supporter_3_recurring_payment_message') );
					if ( empty( $supporter_3_recurring_payment_message ) ) {
						$supporter_3_recurring_payment_message = 'Activate supporter privileges with a three month recurring subscription (for AMOUNT CURRENCY every three months):';
					}
					$supporter_3_recurring_payment_message = str_replace("CURRENCY", $currency, $supporter_3_recurring_payment_message);
					$supporter_3_recurring_payment_message = str_replace("AMOUNT", get_site_option( "supporter_3_whole_cost" ) . '.' . get_site_option( "supporter_3_partial_cost" ), $supporter_3_recurring_payment_message);
					$supporter_12_recurring_payment_message = stripslashes( get_site_option('supporter_12_recurring_payment_message') );
					if ( empty( $supporter_12_recurring_payment_message ) ) {
						$supporter_12_recurring_payment_message = 'Activate supporter privileges with a twelve month recurring subscription (for AMOUNT CURRENCY every twelve months):';
					}
					$supporter_12_recurring_payment_message = str_replace("CURRENCY", $currency, $supporter_12_recurring_payment_message);
					$supporter_12_recurring_payment_message = str_replace("AMOUNT", get_site_option( "supporter_12_whole_cost" ) . '.' . get_site_option( "supporter_12_partial_cost" ), $supporter_12_recurring_payment_message);
					echo '<p class="submit" style="padding-top:2px;">';
					echo __($supporter_1_recurring_payment_message);
					echo '<br />';
					echo supporter_paypal_button_output(1);
					echo '</p>';
					echo '<p class="submit" style="padding-top:2px;">';
					echo __($supporter_3_recurring_payment_message);
					echo '<br />';
					echo supporter_paypal_button_output(3);
					echo '</p>';
					echo '<p class="submit" style="padding-top:2px;">';
					echo __($supporter_12_recurring_payment_message);
					echo '<br />';
					echo supporter_paypal_button_output(12);
					echo '</p>';
				}
			}
		break;
		//---------------------------------------------------//
		case "process":
		break;
		//---------------------------------------------------//
		case "temp":
		break;
		//---------------------------------------------------//
	}
	echo '</div>';
}

function supporter_transactions() {
	global $wpdb, $wp_roles, $current_user;
	
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
			?>
            <h2><?php _e('Transactions') ?></h2>
            <?php
			$transaction_count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "supporter_transactions WHERE blog_ID = '" . $wpdb->blogid . "'");
			if ( $transaction_count > 30 ) {
			?>
            <p><?php _e('Only the thirty most recent transactions are shown.') ?></p>
            <?php
			}
			$query = "SELECT * FROM " . $wpdb->base_prefix . "supporter_transactions WHERE blog_ID = '" . $wpdb->blogid . "' ORDER BY supporter_transaction_ID DESC";
			$transactions = $wpdb->get_results( $query, ARRAY_A );
			echo "
			<table cellpadding='3' cellspacing='3' width='100%' class='widefat'> 
			<thead><tr>
			<th scope='col'>" . __("PayPal Transaction ID") . "</th>
			<th scope='col'>" . __("Date") . "</th>
			<th scope='col'>" . __("Payment Type") . "</th>
			<th scope='col'>" . __("Amount") . "</th>
			<th scope='col'>" . __("Status") . "</th>
			</tr></thead>
			<tbody id='the-list'>
			";
			if ( count( $transactions ) > 0 ) {
				$class = ('alternate' == $class) ? '' : 'alternate';
				foreach ($transactions as $transaction) {
				//=========================================================//
				echo "<tr class='" . $class . "'>";
				echo "<td valign='top'><strong>" . $transaction['paypal_ID'] . "</strong></td>";
				echo "<td valign='top'>" . date(get_option('date_format'), $transaction['stamp']) . "</td>";
				$payment_type = $transaction['payment_type'];
				if ( $payment_type == 'instant' ) {
					$payment_type = ucfirst( $payment_type );
				}
				echo "<td valign='top'>" . __($payment_type) . "</td>";
				echo "<td valign='top'>" . $transaction['amount'] . " " . $transaction['currency'] . "</td>";
				echo "<td valign='top'>" . __($transaction['status']) . "</td>";
				echo "</tr>";
				$class = ('alternate' == $class) ? '' : 'alternate';
				//=========================================================//
				}
			}
			?>
			</tbody></table>
            <?php
		break;
		//---------------------------------------------------//
		case "process":
		break;
		//---------------------------------------------------//
		case "temp":
		break;
		//---------------------------------------------------//
	}
	echo '</div>';
}

?>
