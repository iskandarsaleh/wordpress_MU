<?php
/*
Plugin Name: Upgrades (Framework)
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

$upgrades_current_version = '1.2.0';
//------------------------------------------------------------------------//
//---Config---------------------------------------------------------------//
//------------------------------------------------------------------------//

//------------------------------------------------------------------------//
//---Hook-----------------------------------------------------------------//
//------------------------------------------------------------------------//
if ($_GET['key'] == '' || $_GET['key'] === ''){
	upgrades_make_current();
}

add_action('activity_box_end', 'upgrades_dashboard_credits');
add_action('admin_menu', 'upgrades_plug_pages_framework');
add_filter('wpabar_menuitems', 'upgrades_admin_bar');

if (get_site_option( "upgrades_cost_per_credit") == '') {
	update_site_option("upgrades_cost_per_credit",'1.00');
}

$upgrades_branding = get_site_option( "upgrades_branding");
if ($upgrades_branding == ''){
	update_site_option("upgrades_branding",'upgrades');
	$upgrades_branding_singular = __('Upgrade');
	$upgrades_branding_plural = __('Upgrades');
}
if ($upgrades_branding == 'add-ons'){
	$upgrades_branding_singular = __('Add-on');
	$upgrades_branding_plural = __('Add-ons');
}
if ($upgrades_branding == 'extensions'){
	$upgrades_branding_singular = __('Extension');
	$upgrades_branding_plural = __('Extensions');
}
if ($upgrades_branding == 'extras'){
	$upgrades_branding_singular = __('Extra');
	$upgrades_branding_plural = __('Extras');
}
if ($upgrades_branding == 'premium'){
	$upgrades_branding_singular = __('Premium');
	$upgrades_branding_plural = __('Premium');
}
if ($upgrades_branding == 'supporter'){
	$upgrades_branding_singular = __('Supporter');
	$upgrades_branding_plural = __('Supporter');
}
if ($upgrades_branding == 'upgrades'){
	$upgrades_branding_singular = __('Upgrade');
	$upgrades_branding_plural = __('Upgrades');
}

//------------------------------------------------------------------------//
//---Install/Upgrade------------------------------------------------------//
//------------------------------------------------------------------------//

function upgrades_make_current() {
	global $wpdb, $upgrades_current_version;
	if (get_site_option( "upgrades_version" ) == '') {
		add_site_option( 'upgrades_version', '0.0.0' );
	}
	
	if (get_site_option( "upgrades_version" ) == $upgrades_current_version) {
		// do nothing
	} else {
		//update to current version
		update_site_option( "upgrades_installed", "no" );
		update_site_option( "upgrades_version", $upgrades_current_version );
	}
	upgrades_global_install();
	//--------------------------------------------------//
	if (get_option( "upgrades_version" ) == '') {
		add_option( 'upgrades_version', '0.0.0' );
	}
	
	if (get_option( "upgrades_version" ) == $upgrades_current_version) {
		// do nothing
	} else {
		//update to current version
		update_option( "upgrades_version", $upgrades_current_version );
		upgrades_blog_install();
	}
}

function upgrades_blog_install() {
	global $wpdb, $upgrades_current_version;
	//$upgrades_table1 = "";

	//$wpdb->query( $upgrades_table1 );
}

function upgrades_global_install() {
	global $wpdb, $upgrades_current_version;
	if (get_site_option( "upgrades_installed" ) == '') {
		add_site_option( 'upgrades_installed', 'no' );
	}
	
	if (get_site_option( "upgrades_installed" ) == "yes") {
		// do nothing
	} else {
	
		$upgrades_table1 = "CREATE TABLE IF NOT EXISTS `" . $wpdb->base_prefix . "upgrades_credits` (
  `user_ID` int(11) NOT NULL default '0',
  `credits` int(11) NOT NULL default '0',
  PRIMARY KEY  (`user_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;";
		$upgrades_table2 = "CREATE TABLE IF NOT EXISTS `" . $wpdb->base_prefix . "upgrades_package_status` (
  `package_status_ID` bigint(20) unsigned NOT NULL auto_increment,
  `package_ID` int(11) NOT NULL default '0',
  `blog_ID` int(11) NOT NULL default '0',
  `package_expire` int(11) NOT NULL default '0',
  PRIMARY KEY  (`package_status_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;";
		$upgrades_table3 = "CREATE TABLE IF NOT EXISTS `" . $wpdb->base_prefix . "upgrades_log` (
  `msg_ID` bigint(20) unsigned NOT NULL auto_increment,
  `user_ID` int(11) NOT NULL default '0',
  `msg_text` varchar(255) NOT NULL default '0',
  PRIMARY KEY  (`msg_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=43 ;";
		$upgrades_table4 = "CREATE TABLE IF NOT EXISTS `" . $wpdb->base_prefix . "upgrades_packages` (
  `package_ID` bigint(20) unsigned NOT NULL auto_increment,
  `package_name` varchar(255) NOT NULL default '0',
  `package_active` int(20) NOT NULL default '0',
  `package_description` TEXT,
  `package_cost_one` int(20) NOT NULL default '1',
  `package_cost_three` int(20) NOT NULL default '1',
  `package_cost_twelve` int(20) NOT NULL default '1',
  `package_plugin_one` varchar(255) NOT NULL default '0',
  `package_plugin_two` varchar(255) NOT NULL default '0',
  `package_plugin_three` varchar(255) NOT NULL default '0',
  `package_plugin_four` varchar(255) NOT NULL default '0',
  `package_plugin_five` varchar(255) NOT NULL default '0',
  `package_plugin_six` varchar(255) NOT NULL default '0',
  `package_plugin_seven` varchar(255) NOT NULL default '0',
  `package_plugin_eight` varchar(255) NOT NULL default '0',
  `package_plugin_nine` varchar(255) NOT NULL default '0',
  `package_plugin_ten` varchar(255) NOT NULL default '0',
  `package_plugin_eleven` varchar(255) NOT NULL default '0',
  `package_plugin_twelve` varchar(255) NOT NULL default '0',
  `package_plugin_thirteen` varchar(255) NOT NULL default '0',
  `package_plugin_fourteen` varchar(255) NOT NULL default '0',
  `package_plugin_fifteen` varchar(255) NOT NULL default '0',
  PRIMARY KEY  (`package_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=43 ;";
		$upgrades_table5 = "CREATE TABLE IF NOT EXISTS `" . $wpdb->base_prefix . "upgrades_features` (
  `feature_ID` bigint(20) unsigned NOT NULL auto_increment,
  `feature_hash` varchar(255),
  `feature_name` varchar(255),
  `feature_description` TEXT,
  `feature_last_active` bigint(50),
  PRIMARY KEY  (`feature_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=43 ;";

		$wpdb->query( $upgrades_table1 );
		$wpdb->query( $upgrades_table2 );
		$wpdb->query( $upgrades_table3 );
		$wpdb->query( $upgrades_table4 );
		$wpdb->query( $upgrades_table5 );
		update_site_option( "upgrades_installed", "yes" );
	}
}

//------------------------------------------------------------------------//
//---Functions------------------------------------------------------------//
//------------------------------------------------------------------------//

function upgrades_plug_pages_framework() {
	global $wpdb, $wp_roles, $current_user, $upgrades_branding_singular, $upgrades_branding_plural;
	
	$tmp_package_count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "upgrades_packages WHERE package_active = '1'");
	if ($tmp_package_count > 0){
		add_menu_page($upgrades_branding_plural, $upgrades_branding_plural, 8, 'upgrades.php');
		add_submenu_page('upgrades.php', __('Credits'), __('Credits'), 'edit_users', 'credits', 'upgrades_credits_output' );
		add_submenu_page('upgrades.php', __('History'), __('History'), 'edit_users', 'history', 'upgrades_log_output' );
	}

	if ( is_site_admin() ){
		add_submenu_page('wpmu-admin.php', $upgrades_branding_plural, $upgrades_branding_plural, 10, 'upgrades', 'upgrades_config_output');
	}
}

function upgrades_admin_bar( $menu ) {
	unset( $menu['upgrades.php'] );
	return $menu;
}

function upgrades_log_add_msg($tmp_uid, $tmp_msg) {
	global $wpdb, $wp_roles, $current_user;
	$wpdb->query( "INSERT INTO " . $wpdb->base_prefix . "upgrades_log (user_ID, msg_text) VALUES ( '" . $tmp_uid . "', '" . $tmp_msg . "' )" );
}

function upgrades_user_credit_check($tmp_user_id = 'na'){
	global $wpdb, $wp_roles, $current_user;
	if ($tmp_user_id == '' || $tmp_user_id == 'na'){
		$tmp_credits_check = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "upgrades_credits WHERE  user_ID = '" . $current_user->ID . "'");
		if ($tmp_credits_check == 0){
			$tmp_upgrades_signup_credits = get_site_option( "upgrades_signup_credits" );
			if ($tmp_upgrades_signup_credits == ''){
				$tmp_upgrades_signup_credits = '0';
			}
			$wpdb->query( "INSERT INTO " . $wpdb->base_prefix . "upgrades_credits (user_ID, credits) VALUES ( '" . $current_user->ID . "', '" . $tmp_upgrades_signup_credits . "' )" );
		}
	} else {
		$tmp_credits_check = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "upgrades_credits WHERE  user_ID = '" . $tmp_user_id . "'");
		if ($tmp_credits_check == 0){
			$tmp_upgrades_signup_credits = get_site_option( "upgrades_signup_credits" );
			if ($tmp_upgrades_signup_credits == ''){
				$tmp_upgrades_signup_credits = '0';
			}
			$wpdb->query( "INSERT INTO " . $wpdb->base_prefix . "upgrades_credits (user_ID, credits) VALUES ( '" . $tmp_user_id . "', '" . $tmp_upgrades_signup_credits . "' )" );
		}
	}
}

function upgrades_package_subscribers($tmp_package_id){
	global $wpdb;
	$tmp_subscribers = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "upgrades_package_status WHERE package_ID = '" . $tmp_package_id . "' AND package_expire > '" . time() . "'");
	return $tmp_subscribers;
}

function upgrades_user_credits_update($new_total){
	global $wpdb, $wp_roles, $current_user;
	$wpdb->query( "UPDATE " . $wpdb->base_prefix . "upgrades_credits SET credits = '" . $new_total . "' WHERE user_ID = '" . $current_user->ID . "'");
}

function upgrades_user_credits_available($tmp_user_id){
	global $wpdb;
	upgrades_user_credit_check();
	$tmp_user_credits = $wpdb->get_var("SELECT credits FROM " . $wpdb->base_prefix . "upgrades_credits WHERE  user_ID = '" . $tmp_user_id . "'");
	return $tmp_user_credits;
}

function upgrades_user_credits_add($tmp_credits, $tmp_user_id){
	global $wpdb, $wp_roles, $current_user;
	$tmp_old_total = $wpdb->get_var("SELECT credits FROM " . $wpdb->base_prefix . "upgrades_credits WHERE user_ID = '" . $tmp_user_id . "'");
	$tmp_new_total = $tmp_old_total + $tmp_credits;
	$wpdb->query( "UPDATE " . $wpdb->base_prefix . "upgrades_credits SET credits = '" . $tmp_new_total . "' WHERE user_ID = '" . $tmp_user_id . "'");
}

function upgrades_subscribe($pid, $period){
	global $wpdb, $wp_roles, $current_user;
	$tmp_package_check = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "upgrades_package_status WHERE blog_ID = '" . $wpdb->blogid . "' AND package_ID = '" . $pid . "'");
	$tmp_now = time();

	if ($period == '1'){
	$tmp_add = 30 * (24 * (60 * 60));
	}
	if ($period == '3'){
	$tmp_add = 90 * (24 * (60 * 60));
	}
	if ($period == '12'){
	$tmp_add = 365 * (24 * (60 * 60));
	}

	$tmp_expire = $tmp_now + $tmp_add;
	
	if ($tmp_package_check == 0){
		$wpdb->query( "INSERT INTO " . $wpdb->base_prefix . "upgrades_package_status (package_ID, blog_ID, package_expire) VALUES ( '" . $pid . "', '" . $wpdb->blogid . "', '" . $tmp_expire . "' )" );
	} else {
		$wpdb->query( "UPDATE " . $wpdb->base_prefix . "upgrades_package_status SET package_expire = '" . $tmp_expire . "' WHERE blog_ID = '" . $wpdb->blogid . "' AND package_ID = '" . $pid . "'" );
	}
}

function upgrades_extend($pid, $period){
	global $wpdb, $wp_roles, $current_user;
	$tmp_package_expire = $wpdb->get_var("SELECT package_expire FROM " . $wpdb->base_prefix . "upgrades_package_status WHERE blog_ID = '" . $wpdb->blogid . "' AND package_ID = '" . $pid . "'");

	if ($period == '1'){
	$tmp_add = 30 * (24 * (60 * 60));
	}
	if ($period == '3'){
	$tmp_add = 90 * (24 * (60 * 60));
	}
	if ($period == '12'){
	$tmp_add = 365 * (24 * (60 * 60));
	}

	$tmp_expire = $tmp_package_expire + $tmp_add;
	
	$wpdb->query( "UPDATE " . $wpdb->base_prefix . "upgrades_package_status SET package_expire = '" . $tmp_expire . "' WHERE blog_ID = '" . $wpdb->blogid . "' AND package_ID = '" . $pid . "'" );
}

function upgrades_cancel($pid){
	global $wpdb, $wp_roles, $current_user;
	$tmp_now = time();
	$tmp_subtract = 999 * (24 * (60 * 60));
	$tmp_ago = $tmp_now - $tmp_subtract;
	$wpdb->query( "UPDATE " . $wpdb->base_prefix . "upgrades_package_status SET package_expire = '" . $tmp_ago . "' WHERE blog_ID = '" . $wpdb->blogid . "' AND package_ID = '" . $pid . "'" );
}

function upgrades_package_expires($pid){
	global $wpdb, $wp_roles, $current_user;

	$tmp_package_expires = $wpdb->get_var("SELECT package_expire FROM " . $wpdb->base_prefix . "upgrades_package_status WHERE blog_ID = '" . $wpdb->blogid . "' AND package_ID = '" . $pid . "'");

	return $tmp_package_expires;
}

function upgrades_gift_notification($sending_user, $recieving_user, $credits) {
		global $wpdb, $wp_roles, $current_user, $current_site;

		$notification_email = stripslashes( __( "Hello,

SENDING_USER has sent you NUM_CREDITS credits.

You can use these credits to purchase advanced features for your blog!

Thanks!
--The SITE_NAME Team" ) );

	$url = get_blogaddress_by_id($blog_id);
	$user = new WP_User($user_id);

	$notification_email = str_replace( "SITE_NAME", $current_site->site_name, $notification_email );
	$notification_email = str_replace( "SENDING_USER", $sending_user, $notification_email );
	$notification_email = str_replace( "RECIEVING_USER", $$recieving_user, $notification_email );
	$notification_email = str_replace( "NUM_CREDITS", $credits, $notification_email );


	$admin_email = get_site_option( "admin_email" );
	if( $admin_email == '' )
		$admin_email = 'support@' . $_SERVER[ 'SERVER_NAME' ];
	$message_headers = "MIME-Version: 1.0\n" . "From: " . get_site_option( "site_name" ) .  " <{$admin_email}>\n" . "Content-Type: text/plain; charset=\"" . get_option('blog_charset') . "\"\n";
	$message = $notification_email;
	if( empty( $current_site->site_name ) )
		$current_site->site_name = "Hattrick";
	$subject = ucfirst($recieving_user) . ": You have been sent credits";
	$tmp_recieving_user_email = $wpdb->get_var("SELECT user_email FROM " . $wpdb->base_prefix . "users WHERE user_login = '" . $recieving_user . "'");
	wp_mail($tmp_recieving_user_email, $subject, $message, $message_headers);
}

//------------------------------------------------------------------------//
//---Output Functions-----------------------------------------------------//
//------------------------------------------------------------------------//

function upgrades_dashboard_credits() {
	global $wpdb, $wp_roles, $current_user, $upgrades_branding_singular, $upgrades_branding_plural;
	$tmp_available_credits = upgrades_user_credits_available($current_user->ID);
	if ($tmp_available_credits == ''){
		$tmp_available_credits = '0';
	}
	?>
	<div id='availablecredits'>
		<h3><?php _e("Credits <a href='upgrades.php?page=credits' title='Manage Credits...'>&raquo;</a>"); ?></h3>
        <?php
		if ($tmp_available_credits == '0'){
		?>
			<p><?php _e('Available Credits:'); ?> <strong><?php _e('None - <a href="upgrades.php?page=credits">Click here</a> to purchase credits'); ?></strong></p>
        <?php		
		} else {
		?>
			<p><?php _e('Available Credits:'); ?> <strong><?php echo upgrades_user_credits_available($current_user->ID); ?></strong></p>
			<p><?php _e('<a href="upgrades.php?page=credits">Click here to purchase more credits</a>'); ?></p>
        <?php
		}
		?>
	</div>
	<?php
}

function upgrades_buy_output(){
	$tmp_amount = get_site_option( "upgrades_cost_per_credit" );
	echo '<p class="submit" style="padding-top:2px;">';
	echo '' . __('Purchase') . ' 5 ' . __('credits') . ' (' . __('for') . ' ' . ($tmp_amount * 5) . ' ' . get_site_option( "upgrades_currency" ) . '):<br />';
	do_action('upgrades_payment_module_buy_5');
	echo '</p>';
	echo '<p class="submit" style="padding-top:2px;">';
	echo '' . __('Purchase') . ' 10 ' . __('credits') . ' (' . __('for') . ' ' . ($tmp_amount * 10) . ' ' . get_site_option( "upgrades_currency" ) . '):<br />';
	do_action('upgrades_payment_module_buy_10');
	echo '</p>';
	echo '<p class="submit" style="padding-top:2px;">';
	echo '' . __('Purchase') . ' 25 ' . __('credits') . ' (' . __('for') . ' ' . ($tmp_amount * 25) . ' ' . get_site_option( "upgrades_currency" ) . '):<br />';
	do_action('upgrades_payment_module_buy_25');
	echo '</p>';
	echo '<p class="submit" style="padding-top:2px;">';
	echo '' . __('Purchase') . ' 50 ' . __('credits') . ' (' . __('for') . ' ' . ($tmp_amount * 50) . ' ' . get_site_option( "upgrades_currency" ) . '):<br />';
	do_action('upgrades_payment_module_buy_50');
	echo '</p>';
	echo '<p class="submit" style="padding-top:2px;">';
	echo '' . __('Purchase') . ' 75 ' . __('credits') . ' (' . __('for') . ' ' . ($tmp_amount * 75) . ' ' . get_site_option( "upgrades_currency" ) . '):<br />';
	do_action('upgrades_payment_module_buy_75');
	echo '</p>';
	echo '<p class="submit" style="padding-top:2px;">';
	echo '' . __('Purchase') . ' 100 ' . __('credits') . ' (' . __('for') . ' ' . ($tmp_amount * 100) . ' ' . get_site_option( "upgrades_currency" ) . '):<br />';
	do_action('upgrades_payment_module_buy_100');
	echo '</p>';
	echo '<br />';
}

function echoArrayPremiumLog($arrayName) {
	$intArrayCount = 0;
	$mid = '';
	foreach ($arrayName as $arrayElement) {
		if (count($arrayElement) > 1) {
			echoArrayPremiumLog($arrayElement);
			$class = ('alternate' == $class) ? '' : 'alternate';
			echo "<tr class='" . $class . "'>";
		} else {
			$intArrayCount = $intArrayCount + 1;
			if ($intArrayCount == 1) {
			$mid = $arrayElement;
				echo "<td valign='top'><strong>$arrayElement</strong></td>";
			}
			if ($intArrayCount == 2) {
				echo "<td valign='top'>$arrayElement</td>";
			}
		}
	}
}

function echoArrayPremiumSubscribePackages($arrayName) {
	$intArrayCount = 0;
	$pid = '';
	$pname = '';
	foreach ($arrayName as $arrayElement) {
		if (count($arrayElement) > 1) {
			echoArrayPremiumSubscribePackages($arrayElement);
			$class = ('alternate' == $class) ? '' : 'alternate';
			echo "<tr class='" . $class . "'>";
		} else {
			$intArrayCount = $intArrayCount + 1;
			if ($intArrayCount == 1) {
				$pid = $arrayElement;
				echo "<td valign='top'><strong>$arrayElement</strong></td>";
			}
			if ($intArrayCount == 2) {
				$pname = $arrayElement;
				echo "<td valign='top'>$arrayElement</td>";
			}
			if ($intArrayCount == 3) {
				echo "<td valign='top'>$arrayElement</td>";
			}
			if ($intArrayCount == 4) {
				echo "<td valign='top'>$arrayElement " . __('Credits') . "</td>";
			}
			if ($intArrayCount == 5) {
				echo "<td valign='top'>$arrayElement " . __('Credits') . "</td>";
			}
			if ($intArrayCount == 6) {
				echo "<td valign='top'>$arrayElement " . __('Credits') . "</td>";
			}
		}
	}
	if ($pid == '') {
		//do nothing
	} else {
		
		if (upgrades_package_check($pid) == 'active'){
			//expires in...
			echo "<td valign='top'><strong>" . __('Expires on: ') . date(get_option('date_format'),upgrades_package_expires($pid)) . "</strong> (<a href='upgrades.php?action=extend&pid=" . $pid . "''>" . __('Extend') . "</a>/<a href='upgrades.php?action=cancel&pid=" . $pid . "''>" . __('Cancel') . "</a>)</td>";
		} else {
			echo "<td valign='top'><a href='upgrades.php?action=subscribe&pid=" . $pid . "' rel='permalink' class='edit'>" . __('Subscribe') . "</a></td>";
		}
		echo "</tr>";
		$class = ('alternate' == $class) ? '' : 'alternate';
	}
}

function echoArrayPremiumConfigPackages($arrayName) {
	$intArrayCount = 0;
	$pid = '';
	$pname = '';
	foreach ($arrayName as $arrayElement) {
		if (count($arrayElement) > 1) {
			echoArrayPremiumConfigPackages($arrayElement);
			$class = ('alternate' == $class) ? '' : 'alternate';
			echo "<tr class='" . $class . "'>";
		} else {
			$intArrayCount = $intArrayCount + 1;
			if ($intArrayCount == 1) {
				$pid = $arrayElement;
				echo "<td valign='top'><strong>$arrayElement</strong></td>";
			}
			if ($intArrayCount == 2) {
				$pname = $arrayElement;
				echo "<td valign='top'>$arrayElement</td>";
			}
			if ($intArrayCount == 3) {
				echo "<td valign='top'>$arrayElement</td>";
			}
			//subscribers...
			if ($intArrayCount == 3) {
				echo "<td valign='top'>" . upgrades_package_subscribers($pid) . "</td>";
			}
			if ($intArrayCount == 4) {
				if ($arrayElement == '1'){
				echo "<td valign='top'>" . __('Yes') . "</td>";
				} else {
				echo "<td valign='top'>" . __('No') . "</td>";
				}
			}
		}
	}
	if ($pid == '') {
		//do nothing
	} else {
		echo "<td valign='top'><a href='wpmu-admin.php?page=upgrades&action=edit_package&pid=" . $pid . "' rel='permalink' class='edit'>" . __('Edit') . "</a></td>";
		echo "<td valign='top'><a href='wpmu-admin.php?page=upgrades&action=delete_package&pid=" . $pid . "' rel='permalink' class='delete'>" . __('Remove') . "</a></td>";
		echo "</tr>";
		$class = ('alternate' == $class) ? '' : 'alternate';
	}
}

function upgrades_output_plugins_select($tmp_hash = '') {
	global $wpdb, $wp_roles, $current_user;

	$query = "SELECT feature_hash FROM " . $wpdb->base_prefix . "upgrades_features";
	$upgrades_plugin_list = $wpdb->get_results( $query, ARRAY_A );
	
	if ($tmp_hash == '' || $tmp_hash == '0'){
		echo '<option value="0" selected="selected">' . __('None') . '</option>';	
	} else {
		echo '<option value="0">' . __('None') . '</option>';
	}
	foreach ($upgrades_plugin_list as $upgrades_plugin) {
		foreach ($upgrades_plugin as $upgrades_plugin_hash) {
			$tmp_plugin_name = $wpdb->get_var("SELECT feature_name FROM " . $wpdb->base_prefix . "upgrades_features WHERE feature_hash = '" . $upgrades_plugin_hash . "'");
			$tmp_plugin_name = ucfirst($tmp_plugin_name);
			if ($tmp_hash == $upgrades_plugin_hash){
				echo '<option value="' . $upgrades_plugin_hash . '" selected="selected">' . $tmp_plugin_name . '</option>';
			} else {
				echo '<option value="' . $upgrades_plugin_hash . '">' . $tmp_plugin_name . '</option>';
			}
		}
	}
}

//------------------------------------------------------------------------//
//---Page Output Functions------------------------------------------------//
//------------------------------------------------------------------------//

function upgrades_config_output() {
	global $wpdb, $wp_roles, $current_user, $upgrades_branding_singular, $upgrades_branding_plural;
	
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
		$tmp_package_count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "upgrades_packages");
			?>
            <a name='packages_top' id='packages_top'></a>
            <h2><?php _e('Packages') ?> (<a href="wpmu-admin.php?page=upgrades&action=new_package"><?php _e('New') ?></a>)</h2>
            <?php
			if ($tmp_package_count == 0){
			?>
            <p><?php _e('Click ') ?><a href="wpmu-admin.php?page=upgrades&action=new_package"><?php _e('here') ?></a><?php _e(' to create a package.') ?></p>
            <?php
			} else {
			$query = "SELECT package_ID, package_name, package_description, package_active FROM " . $wpdb->base_prefix . "upgrades_packages";
			if( $_GET[ 'sortby' ] == 'active' ) {
				$query .= ' ORDER BY package_active DESC';
			} else {
				$query .= ' ORDER BY package_ID DESC';
			}
			$upgrades_package_list = $wpdb->get_results( $query, ARRAY_A );
			
			echo "
			<table cellpadding='3' cellspacing='3' width='100%' class='widefat'> 
			<tbody><tr class='thead'>
			<th scope='col'><a href='wpmu-admin.php?page=upgrades&sortby=id#packages_top'>" . __('ID') . "</a></th>
			<th scope='col'>" . __('Name') . "</th>
			<th scope='col'>" . __('Description') . "</th>
			<th scope='col'>" . __('Subscribers') . "</th>
			<th scope='col'><a href='wpmu-admin.php?page=upgrades&sortby=active#packages_top'>" . __('Active') . "</a></th>
			<th scope='col'>Actions</th>
			<th scope='col'></th>
			</tr>
			";
			echoArrayPremiumConfigPackages($upgrades_package_list);
			?>
			</tbody></table>
            <?php
			}
			?>
            <br />
            <a name='credits_top' id='credits_top'></a>
			<h2><?php _e('Credits') ?></h2>
            <form name="form1" method="POST" action="wpmu-admin.php?page=upgrades&action=manage_credits">
			<table class="form-table"> 
                <tr valign="top"> 
                <th scope="row"><?php _e('Action') ?></th> 
                <td><input type="radio" name="manage_credits_action" value="send_all_users" /> <?php _e('Send Credits to all users'); ?><br />
                <input type="radio" name="manage_credits_action" value="send_single_user" checked="checked" /> <?php _e('Send Credits to one user'); ?><br />
                <?php //_e('Format: 00.00 - Ex: 1.25') ?></td> 
                </tr>
            </table> 
            <p class="submit">
            <input type="submit" name="Submit" value="<?php _e('Next') ?>" />
            </p>
            </form>
            <br />
			<h2><?php _e('Options') ?></h2>
            <form name="form1" method="POST" action="wpmu-admin.php?page=upgrades&action=process">
			<table class="form-table"> 
                <tr valign="top"> 
                <th scope="row"><?php _e('Cost per credit') ?></th> 
                <td><input type="text" name="upgrades_cost_per_credit" value="<?php echo get_site_option( "upgrades_cost_per_credit" ); ?>" />
                <br />
                <?php _e('Format: 00.00 - Ex: 1.25') ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Currency') ?></th> 
                <td><select name="upgrades_currency">
				<?php
					$tmp_upgrades_currency = get_site_option( "upgrades_currency" );
                    $sel_currency = empty($tmp_upgrades_currency) ? 'USD' : $tmp_upgrades_currency;
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
                <br />
                <?php //_e('Format: 00.00 - Ex: 1.25') ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Branding') ?></th> 
                <td><select name="upgrades_branding">
                    <option value="add-ons" <?php if (get_site_option( "upgrades_branding" ) == 'add-ons') echo 'selected="selected"'; ?>>Add-Ons</option>
                    <option value="extensions" <?php if (get_site_option( "upgrades_branding" ) == 'extensions') echo 'selected="selected"'; ?>>Extensions</option>
                    <option value="extras" <?php if (get_site_option( "upgrades_branding" ) == 'extras') echo 'selected="selected"'; ?>>Extras</option>
                    <option value="premium" <?php if (get_site_option( "upgrades_branding" ) == 'premium' || get_site_option( "upgrades_branding" ) == '') echo 'selected="selected"'; ?>>Premium</option>
					<option value="supporter" <?php if (get_site_option( "upgrades_branding" ) == 'supporter') echo 'selected="selected"'; ?>>Supporter</option>
                    <option value="upgrades" <?php if (get_site_option( "upgrades_branding" ) == 'upgrades') echo 'selected="selected"'; ?>>Upgrades</option>
                </select>
                <br />
                <?php //_e('Format: 00.00 - Ex: 1.25') ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Signup Credits') ?></th> 
                <td><select name="upgrades_signup_credits">
				<?php
					$tmp_upgrades_signup_credits = get_site_option( "upgrades_signup_credits" );
					$tmp_counter = 0;
					for ( $counter = 1; $counter <= 101; $counter += 1) {
                        echo '<option value="' . $tmp_counter . '"' . ($tmp_counter == $tmp_upgrades_signup_credits ? ' selected' : '') . '>' . $tmp_counter . '</option>' . "\n";
						$tmp_counter = $tmp_counter + 1;
					}
                ?>
                </select>
                <br />
                <?php _e('How many credits each user receives when they signup.'); ?></td> 
                </tr>        
            </table> 
			<?php
            do_action('upgrades_payment_module_options');
			?>
            <p class="submit">
            <input type="submit" name="Submit" value="<?php _e('Save Changes') ?>" />
            </p>
            </form>
			<?php
		break;
		//---------------------------------------------------//
		case "process":
			if ($_POST['upgrades_cost_per_credit'] == ''){
				update_site_option( "upgrades_cost_per_credit", '1.00' );
			} else {
				update_site_option( "upgrades_cost_per_credit", $_POST['upgrades_cost_per_credit'] );
			}
			update_site_option( "upgrades_currency", $_POST['upgrades_currency'] );
			update_site_option( "upgrades_branding", $_POST['upgrades_branding'] );
			update_site_option( "upgrades_signup_credits", $_POST['upgrades_signup_credits'] );
			do_action('upgrades_payment_module_process');
			echo "
			<SCRIPT LANGUAGE='JavaScript'>
			window.location='wpmu-admin.php?page=upgrades&updated=true&updatedmsg=" . urlencode(__('Settings saved.')) . "';
			</script>
			";
		break;
		//---------------------------------------------------//
		case "new_package":
		?>
            <form name="form1" method="POST" action="wpmu-admin.php?page=upgrades&action=new_package_process"> 
                <table class="form-table">
                <tr valign="top"> 
                <th scope="row"><?php _e('Name') ?></th> 
				<td><input name="package_name" type="text" id="package_name" style="width: 95%" value="" size="45" />
                <br />
                <?php //_e('') ?></td> 
                </tr> 
                <tr valign="top"> 
                <th scope="row"><?php _e('Description') ?></th> 
				<td><input name="package_description" type="text" id="package_description" style="width: 95%" value="" size="45" />
                <br />
                <?php //_e('') ?></td> 
                </tr> 
                <tr valign="top"> 
                <th scope="row"><?php _e('One Month') ?></th> 
				<td><select id="package_cost_one" name="package_cost_one" >
				<?php for ( $i = 1; $i < 101; ++$i ) echo "<option value='$i' ".($_POST['package_cost_one']==$i ? "selected='selected'" : '').">$i</option>"; ?>
				</select>
                <br />
                <?php _e('Credits') ?></td>
                </tr> 
                <tr valign="top"> 
                <th scope="row"><?php _e('Three Months') ?></th> 
				<td><select id="package_cost_three" name="package_cost_three" >
				<?php for ( $i = 1; $i < 101; ++$i ) echo "<option value='$i' ".($_POST['package_cost_three']==$i ? "selected='selected'" : '').">$i</option>"; ?>
				</select>
                <br />
                <?php _e('Credits') ?></td>
                </tr> 
                <tr valign="top"> 
                <th scope="row"><?php _e('Twelve Months') ?></th> 
				<td><select id="package_cost_twelve" name="package_cost_twelve" >
				<?php for ( $i = 1; $i < 101; ++$i ) echo "<option value='$i' ".($_POST['package_cost_twelve']==$i ? "selected='selected'" : '').">$i</option>"; ?>
				</select>
                <br />
                <?php _e('Credits') ?></td>
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Plugin One') ?></th> 
				<td><select name="package_plugin_one" id="package_plugin_one">
				<?php upgrades_output_plugins_select('') ?>
				</select>
                <br />
                <?php //_e('') ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Plugin Two') ?></th> 
				<td><select name="package_plugin_two" id="package_plugin_two">
				<?php upgrades_output_plugins_select('') ?>
				</select>
                <br />
                <?php //_e('') ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Plugin Three') ?></th> 
				<td><select name="package_plugin_three" id="package_plugin_three">
				<?php upgrades_output_plugins_select('') ?>
				</select>
                <br />
                <?php //_e('') ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Plugin Four') ?></th> 
				<td><select name="package_plugin_four" id="package_plugin_four">
				<?php upgrades_output_plugins_select('') ?>
				</select>
                <br />
                <?php //_e('') ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Plugin Five') ?></th> 
				<td><select name="package_plugin_five" id="package_plugin_five">
				<?php upgrades_output_plugins_select('') ?>
				</select>
                <br />
                <?php //_e('') ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Plugin Six') ?></th> 
				<td><select name="package_plugin_six" id="package_plugin_six">
				<?php upgrades_output_plugins_select('') ?>
				</select>
                <br />
                <?php //_e('') ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Plugin Seven') ?></th> 
				<td><select name="package_plugin_seven" id="package_plugin_seven">
				<?php upgrades_output_plugins_select('') ?>
				</select>
                <br />
                <?php //_e('') ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Plugin Eight') ?></th> 
				<td><select name="package_plugin_eight" id="package_plugin_eight">
				<?php upgrades_output_plugins_select('') ?>
				</select>
                <br />
                <?php //_e('') ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Plugin Nine') ?></th> 
				<td><select name="package_plugin_nine" id="package_plugin_nine">
				<?php upgrades_output_plugins_select('') ?>
				</select>
                <br />
                <?php //_e('') ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Plugin Ten') ?></th> 
				<td><select name="package_plugin_ten" id="package_plugin_ten">
				<?php upgrades_output_plugins_select('') ?>
				</select>
                <br />
                <?php //_e('') ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Plugin Eleven') ?></th> 
				<td><select name="package_plugin_eleven" id="package_plugin_eleven">
				<?php upgrades_output_plugins_select('') ?>
				</select>
                <br />
                <?php //_e('') ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Plugin Twelve') ?></th> 
				<td><select name="package_plugin_twelve" id="package_plugin_twelve">
				<?php upgrades_output_plugins_select('') ?>
				</select>
                <br />
                <?php //_e('') ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Plugin Thirteen') ?></th> 
				<td><select name="package_plugin_thirteen" id="package_plugin_thirteen">
				<?php upgrades_output_plugins_select('') ?>
				</select>
                <br />
                <?php //_e('') ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Plugin Fourteen') ?></th> 
				<td><select name="package_plugin_fourteen" id="package_plugin_fourteen">
				<?php upgrades_output_plugins_select('') ?>
				</select>
                <br />
                <?php //_e('') ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Plugin Fifteen') ?></th> 
				<td><select name="package_plugin_fifteen" id="package_plugin_fifteen">
				<?php upgrades_output_plugins_select('') ?>
				</select>
                <br />
                <?php //_e('') ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Active') ?></th> 
				<td><select name="package_active" id="package_active">
				<option value="1"><?php _e('Yes') ?></option>
				<option value="0"><?php _e('No') ?></option>
				</select>
                <br />
                <?php //_e('') ?></td> 
                </tr>
                </table>
            <p class="submit"> 
            <input type="submit" name="Submit" value="<?php _e('Save') ?>" /> 
            </p> 
            </form>
        <?php
		break;
		//---------------------------------------------------//
		case "new_package_process":
		if ($_POST['package_name'] == '' || $_POST['package_description'] == '' || $_POST['package_cost_one'] == '' || $_POST['package_cost_three'] == '' || $_POST['package_cost_twelve'] == ''){
		?>
        	<p><?php _e('All fields are required.') ?></p>
            <form name="form1" method="POST" action="wpmu-admin.php?page=upgrades&action=new_package_process"> 
                <table class="form-table">
                <tr valign="top"> 
                <th scope="row"><?php _e('Name') ?></th> 
				<td><input name="package_name" type="text" id="package_name" style="width: 95%" value="<?php echo $_POST['package_name']; ?>" size="45" />
                <br />
                <?php //_e('') ?></td> 
                </tr> 
                <tr valign="top"> 
                <th scope="row"><?php _e('Description') ?></th> 
				<td><input name="package_description" type="text" id="package_description" style="width: 95%" value="<?php echo $_POST['package_description']; ?>" size="45" />
                <br />
                <?php //_e('') ?></td> 
                </tr> 
                <tr valign="top"> 
                <th scope="row"><?php _e('One Month') ?></th> 
				<td><select id="package_cost_one" name="package_cost_one" >
				<?php for ( $i = 1; $i < 101; ++$i ) echo "<option value='$i' ".($_POST['package_cost_one']==$i ? "selected='selected'" : '').">$i</option>"; ?>
				</select>
                <br />
                <?php _e('Credits') ?></td>
                </tr> 
                <tr valign="top"> 
                <th scope="row"><?php _e('Three Months') ?></th> 
				<td><select id="package_cost_three" name="package_cost_three" >
				<?php for ( $i = 1; $i < 101; ++$i ) echo "<option value='$i' ".($_POST['package_cost_three']==$i ? "selected='selected'" : '').">$i</option>"; ?>
				</select>
                <br />
                <?php _e('Credits') ?></td>
                </tr> 
                <tr valign="top"> 
                <th scope="row"><?php _e('Twelve Months') ?></th> 
				<td><select id="package_cost_twelve" name="package_cost_twelve" >
				<?php for ( $i = 1; $i < 101; ++$i ) echo "<option value='$i' ".($_POST['package_cost_twelve']==$i ? "selected='selected'" : '').">$i</option>"; ?>
				</select>
                <br />
                <?php _e('Credits') ?></td>
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Plugin One') ?></th> 
				<td><select name="package_plugin_one" id="package_plugin_one">
				<?php upgrades_output_plugins_select($_POST['package_plugin_one']) ?>
				</select>
                <br />
                <?php //_e('') ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Plugin Two') ?></th> 
				<td><select name="package_plugin_two" id="package_plugin_two">
				<?php upgrades_output_plugins_select($_POST['package_plugin_two']) ?>
				</select>
                <br />
                <?php //_e('') ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Plugin Three') ?></th> 
				<td><select name="package_plugin_three" id="package_plugin_three">
				<?php upgrades_output_plugins_select($_POST['package_plugin_three']) ?>
				</select>
                <br />
                <?php //_e('') ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Plugin Four') ?></th> 
				<td><select name="package_plugin_four" id="package_plugin_four">
				<?php upgrades_output_plugins_select($_POST['package_plugin_four']) ?>
				</select>
                <br />
                <?php //_e('') ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Plugin Five') ?></th> 
				<td><select name="package_plugin_five" id="package_plugin_five">
				<?php upgrades_output_plugins_select($_POST['package_plugin_five']) ?>
				</select>
                <br />
                <?php //_e('') ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Plugin Six') ?></th> 
				<td><select name="package_plugin_six" id="package_plugin_six">
				<?php upgrades_output_plugins_select($_POST['package_plugin_six']) ?>
				</select>
                <br />
                <?php //_e('') ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Plugin Seven') ?></th> 
				<td><select name="package_plugin_seven" id="package_plugin_seven">
				<?php upgrades_output_plugins_select($_POST['package_plugin_seven']) ?>
				</select>
                <br />
                <?php //_e('') ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Plugin Eight') ?></th> 
				<td><select name="package_plugin_eight" id="package_plugin_eight">
				<?php upgrades_output_plugins_select($_POST['package_plugin_eight']) ?>
				</select>
                <br />
                <?php //_e('') ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Plugin Nine') ?></th> 
				<td><select name="package_plugin_nine" id="package_plugin_nine">
				<?php upgrades_output_plugins_select($_POST['package_plugin_nine']) ?>
				</select>
                <br />
                <?php //_e('') ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Plugin Ten') ?></th> 
				<td><select name="package_plugin_ten" id="package_plugin_ten">
				<?php upgrades_output_plugins_select($_POST['package_plugin_ten']) ?>
				</select>
                <br />
                <?php //_e('') ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Plugin Eleven') ?></th> 
				<td><select name="package_plugin_eleven" id="package_plugin_eleven">
				<?php upgrades_output_plugins_select($_POST['package_plugin_eleven']) ?>
				</select>
                <br />
                <?php //_e('') ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Plugin Twelve') ?></th> 
				<td><select name="package_plugin_twelve" id="package_plugin_twelve">
				<?php upgrades_output_plugins_select($_POST['package_plugin_twelve']) ?>
				</select>
                <br />
                <?php //_e('') ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Plugin Thirteen') ?></th> 
				<td><select name="package_plugin_thirteen" id="package_plugin_thirteen">
				<?php upgrades_output_plugins_select($_POST['package_plugin_thirteen']) ?>
				</select>
                <br />
                <?php //_e('') ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Plugin Fourteen') ?></th> 
				<td><select name="package_plugin_fourteen" id="package_plugin_fourteen">
				<?php upgrades_output_plugins_select($_POST['package_plugin_fourteen']) ?>
				</select>
                <br />
                <?php //_e('') ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Plugin Fifteen') ?></th> 
				<td><select name="package_plugin_fifteen" id="package_plugin_fifteen">
				<?php upgrades_output_plugins_select($_POST['package_plugin_fifteen']) ?>
				</select>
                <br />
                <?php //_e('') ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Active') ?></th> 
				<td><select name="package_active" id="package_active">
                <?php
				if ($_POST['package_active'] == '1'){
				?>
				<option value="1" selected="selected"><?php _e('Yes') ?></option>
				<option value="0"><?php _e('No') ?></option>
                <?php
				} else {
				?>
				<option value="1"><?php _e('Yes') ?></option>
				<option value="0" selected="selected"><?php _e('No') ?></option>
                <?php
				}
				?>
				</select>
                <br />
                <?php //_e('') ?></td> 
                </tr>
                </table>
            <p class="submit"> 
            <input type="submit" name="Submit" value="<?php _e('Save') ?>" /> 
            </p> 
            </form>
        <?php
		} else {
			$wpdb->query( "INSERT INTO " . $wpdb->base_prefix . "upgrades_packages (package_name, package_description, package_cost_one, package_cost_three, package_cost_twelve, package_active, package_plugin_one, package_plugin_two, package_plugin_three, package_plugin_four, package_plugin_five, package_plugin_six, package_plugin_seven, package_plugin_eight, package_plugin_nine, package_plugin_ten, package_plugin_eleven, package_plugin_twelve, package_plugin_thirteen, package_plugin_fourteen, package_plugin_fifteen) VALUES ( '" . $_POST['package_name'] . "', '" . $_POST['package_description'] . "', '" . $_POST['package_cost_one'] . "', '" . $_POST['package_cost_three'] . "', '" . $_POST['package_cost_twelve'] . "', '" . $_POST['package_active'] . "', '" . $_POST['package_plugin_one'] . "', '" . $_POST['package_plugin_two'] . "', '" . $_POST['package_plugin_three'] . "', '" . $_POST['package_plugin_four'] . "', '" . $_POST['package_plugin_five'] . "', '" . $_POST['package_plugin_six'] . "', '" . $_POST['package_plugin_seven'] . "', '" . $_POST['package_plugin_eight'] . "', '" . $_POST['package_plugin_nine'] . "', '" . $_POST['package_plugin_ten'] . "', '" . $_POST['package_plugin_eleven'] . "', '" . $_POST['package_plugin_twelve'] . "', '" . $_POST['package_plugin_thirteen'] . "', '" . $_POST['package_plugin_fourteen'] . "', '" . $_POST['package_plugin_fifteen'] . "' )" );
			echo "
			<SCRIPT LANGUAGE='JavaScript'>
			window.location='wpmu-admin.php?page=upgrades&updated=true&updatedmsg=" . urlencode(__('Package Saved.')) . "';
			</script>
			";
		}
		break;
		//---------------------------------------------------//
		case "edit_package":
		$tmp_package_edit_name = $wpdb->get_var("SELECT package_name FROM " . $wpdb->base_prefix . "upgrades_packages WHERE package_ID = '" . $_GET['pid'] . "'");
		$tmp_package_edit_description = $wpdb->get_var("SELECT package_description FROM " . $wpdb->base_prefix . "upgrades_packages WHERE package_ID = '" . $_GET['pid'] . "'");
		$tmp_package_edit_cost_one = $wpdb->get_var("SELECT package_cost_one FROM " . $wpdb->base_prefix . "upgrades_packages WHERE package_ID = '" . $_GET['pid'] . "'");
		$tmp_package_edit_cost_three = $wpdb->get_var("SELECT package_cost_three FROM " . $wpdb->base_prefix . "upgrades_packages WHERE package_ID = '" . $_GET['pid'] . "'");
		$tmp_package_edit_cost_twelve = $wpdb->get_var("SELECT package_cost_twelve FROM " . $wpdb->base_prefix . "upgrades_packages WHERE package_ID = '" . $_GET['pid'] . "'");
		$tmp_package_edit_active = $wpdb->get_var("SELECT package_active FROM " . $wpdb->base_prefix . "upgrades_packages WHERE package_ID = '" . $_GET['pid'] . "'");
		
		$tmp_package_edit_plugin_one = $wpdb->get_var("SELECT package_plugin_one FROM " . $wpdb->base_prefix . "upgrades_packages WHERE package_ID = '" . $_GET['pid'] . "'");
		$tmp_package_edit_plugin_two = $wpdb->get_var("SELECT package_plugin_two FROM " . $wpdb->base_prefix . "upgrades_packages WHERE package_ID = '" . $_GET['pid'] . "'");
		$tmp_package_edit_plugin_three = $wpdb->get_var("SELECT package_plugin_three FROM " . $wpdb->base_prefix . "upgrades_packages WHERE package_ID = '" . $_GET['pid'] . "'");
		$tmp_package_edit_plugin_four = $wpdb->get_var("SELECT package_plugin_four FROM " . $wpdb->base_prefix . "upgrades_packages WHERE package_ID = '" . $_GET['pid'] . "'");
		$tmp_package_edit_plugin_five = $wpdb->get_var("SELECT package_plugin_five FROM " . $wpdb->base_prefix . "upgrades_packages WHERE package_ID = '" . $_GET['pid'] . "'");
		$tmp_package_edit_plugin_six = $wpdb->get_var("SELECT package_plugin_six FROM " . $wpdb->base_prefix . "upgrades_packages WHERE package_ID = '" . $_GET['pid'] . "'");
		$tmp_package_edit_plugin_seven = $wpdb->get_var("SELECT package_plugin_seven FROM " . $wpdb->base_prefix . "upgrades_packages WHERE package_ID = '" . $_GET['pid'] . "'");
		$tmp_package_edit_plugin_eight = $wpdb->get_var("SELECT package_plugin_eight FROM " . $wpdb->base_prefix . "upgrades_packages WHERE package_ID = '" . $_GET['pid'] . "'");
		$tmp_package_edit_plugin_nine = $wpdb->get_var("SELECT package_plugin_nine FROM " . $wpdb->base_prefix . "upgrades_packages WHERE package_ID = '" . $_GET['pid'] . "'");
		$tmp_package_edit_plugin_ten = $wpdb->get_var("SELECT package_plugin_ten FROM " . $wpdb->base_prefix . "upgrades_packages WHERE package_ID = '" . $_GET['pid'] . "'");
		$tmp_package_edit_plugin_eleven = $wpdb->get_var("SELECT package_plugin_eleven FROM " . $wpdb->base_prefix . "upgrades_packages WHERE package_ID = '" . $_GET['pid'] . "'");
		$tmp_package_edit_plugin_twelve = $wpdb->get_var("SELECT package_plugin_twelve FROM " . $wpdb->base_prefix . "upgrades_packages WHERE package_ID = '" . $_GET['pid'] . "'");
		$tmp_package_edit_plugin_thirteen = $wpdb->get_var("SELECT package_plugin_thirteen FROM " . $wpdb->base_prefix . "upgrades_packages WHERE package_ID = '" . $_GET['pid'] . "'");
		$tmp_package_edit_plugin_fourteen = $wpdb->get_var("SELECT package_plugin_fourteen FROM " . $wpdb->base_prefix . "upgrades_packages WHERE package_ID = '" . $_GET['pid'] . "'");
		$tmp_package_edit_plugin_fifteen = $wpdb->get_var("SELECT package_plugin_fifteen FROM " . $wpdb->base_prefix . "upgrades_packages WHERE package_ID = '" . $_GET['pid'] . "'");
		?>
            <form name="form1" method="POST" action="wpmu-admin.php?page=upgrades&action=edit_package_process&pid=<?php echo $_GET['pid']; ?>"> 
                <table class="form-table">
                <tr valign="top"> 
                <th scope="row"><?php _e('Name') ?></th> 
				<td><input name="package_name" type="text" id="package_name" style="width: 95%" value="<?php echo $tmp_package_edit_name; ?>" size="45" />
                <br />
                <?php //_e('') ?></td> 
                </tr> 
                <tr valign="top"> 
                <th scope="row"><?php _e('Description') ?></th>
				<td><input name="package_description" type="text" id="package_description" style="width: 95%" value="<?php echo $tmp_package_edit_description; ?>" size="45" />
                <br />
                <?php //_e('') ?></td> 
                </tr> 
                <tr valign="top"> 
                <th scope="row"><?php _e('One Month') ?></th> 
				<td><select id="package_cost_one" name="package_cost_one" >
				<?php for ( $i = 1; $i < 101; ++$i ) echo "<option value='$i' ".($tmp_package_edit_cost_one==$i ? "selected='selected'" : '').">$i</option>"; ?>
				</select>
                <br />
                <?php _e('Credits') ?></td>
                </tr> 
                <tr valign="top"> 
                <th scope="row"><?php _e('Three Months') ?></th> 
				<td><select id="package_cost_three" name="package_cost_three" >
				<?php for ( $i = 1; $i < 101; ++$i ) echo "<option value='$i' ".($tmp_package_edit_cost_three==$i ? "selected='selected'" : '').">$i</option>"; ?>
				</select>
                <br />
                <?php _e('Credits') ?></td>
                </tr> 
                <tr valign="top"> 
                <th scope="row"><?php _e('Twelve Months') ?></th> 
				<td><select id="package_cost_twelve" name="package_cost_twelve" >
				<?php for ( $i = 1; $i < 101; ++$i ) echo "<option value='$i' ".($tmp_package_edit_cost_twelve==$i ? "selected='selected'" : '').">$i</option>"; ?>
				</select>
                <br />
                <?php _e('Credits') ?></td>
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Plugin One') ?></th> 
				<td><select name="package_plugin_one" id="package_plugin_one">
				<?php upgrades_output_plugins_select($tmp_package_edit_plugin_one) ?>
				</select>
                <br />
                <?php //_e('') ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Plugin Two') ?></th>
				<td><select name="package_plugin_two" id="package_plugin_two">
				<?php upgrades_output_plugins_select($tmp_package_edit_plugin_two) ?>
				</select>
                <br />
                <?php //_e('') ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Plugin Three') ?></th>
				<td><select name="package_plugin_three" id="package_plugin_three">
				<?php upgrades_output_plugins_select($tmp_package_edit_plugin_three) ?>
				</select>
                <br />
                <?php //_e('') ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Plugin Four') ?></th>
				<td><select name="package_plugin_four" id="package_plugin_four">
				<?php upgrades_output_plugins_select($tmp_package_edit_plugin_four) ?>
				</select>
                <br />
                <?php //_e('') ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Plugin Five') ?></th>
				<td><select name="package_plugin_five" id="package_plugin_five">
				<?php upgrades_output_plugins_select($tmp_package_edit_plugin_five) ?>
				</select>
                <br />
                <?php //_e('') ?></td> 
                </tr>                
                <tr valign="top"> 
                <th scope="row"><?php _e('Plugin Six') ?></th>
				<td><select name="package_plugin_six" id="package_plugin_six">
				<?php upgrades_output_plugins_select($tmp_package_edit_plugin_six) ?>
				</select>
                <br />
                <?php //_e('') ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Plugin Seven') ?></th>
				<td><select name="package_plugin_seven" id="package_plugin_seven">
				<?php upgrades_output_plugins_select($tmp_package_edit_plugin_seven) ?>
				</select>
                <br />
                <?php //_e('') ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Plugin Eight') ?></th>
				<td><select name="package_plugin_eight" id="package_plugin_eight">
				<?php upgrades_output_plugins_select($tmp_package_edit_plugin_eight) ?>
				</select>
                <br />
                <?php //_e('') ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Plugin Nine') ?></th>
				<td><select name="package_plugin_nine" id="package_plugin_nine">
				<?php upgrades_output_plugins_select($tmp_package_edit_plugin_nine) ?>
				</select>
                <br />
                <?php //_e('') ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Plugin Ten') ?></th>
				<td><select name="package_plugin_ten" id="package_plugin_ten">
				<?php upgrades_output_plugins_select($tmp_package_edit_plugin_ten) ?>
				</select>
                <br />
                <?php //_e('') ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Plugin Eleven') ?></th>
				<td><select name="package_plugin_eleven" id="package_plugin_eleven">
				<?php upgrades_output_plugins_select($tmp_package_edit_plugin_eleven) ?>
				</select>
                <br />
                <?php //_e('') ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Plugin Twelve') ?></th>
				<td><select name="package_plugin_twelve" id="package_plugin_twelve">
				<?php upgrades_output_plugins_select($tmp_package_edit_plugin_twelve) ?>
				</select>
                <br />
                <?php //_e('') ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Plugin Thirteen') ?></th>
				<td><select name="package_plugin_thirteen" id="package_plugin_thirteen">
				<?php upgrades_output_plugins_select($tmp_package_edit_plugin_thirteen) ?>
				</select>
                <br />
                <?php //_e('') ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Plugin Fourteen') ?></th>
				<td><select name="package_plugin_fourteen" id="package_plugin_fourteen">
				<?php upgrades_output_plugins_select($tmp_package_edit_plugin_fourteen) ?>
				</select>
                <br />
                <?php //_e('') ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Plugin Fifteen') ?></th>
				<td><select name="package_plugin_fifteen" id="package_plugin_fifteen">
				<?php upgrades_output_plugins_select($tmp_package_edit_plugin_fifteen) ?>
				</select>
                <br />
                <?php //_e('') ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Active') ?></th>
				<td><select name="package_active" id="package_active">
                <?php
				if ($tmp_package_edit_active == '1'){
				?>
				<option value="1" selected="selected"><?php _e('Yes') ?></option>
				<option value="0"><?php _e('No') ?></option>
                <?php
				} else {
				?>
				<option value="1"><?php _e('Yes') ?></option>
				<option value="0" selected="selected"><?php _e('No') ?></option>
                <?php
				}
				?>
				</select>
                <br />
                <?php //_e('') ?></td> 
                </tr>
                </table>
            <p class="submit"> 
            <input type="submit" name="Submit" value="<?php _e('Save Changes') ?>" /> 
            </p> 
            </form>
        <?php
		break;
		//---------------------------------------------------//
		case "edit_package_process":
		if ($_POST['package_name'] == '' || $_POST['package_description'] == '' || $_POST['package_cost_one'] == '' || $_POST['package_cost_three'] == '' || $_POST['package_cost_twelve'] == ''){
		?>
        	<p><?php _e('All fields are required.') ?></p>
            <form name="form1" method="POST" action="wpmu-admin.php?page=upgrades&action=edit_package_process&pid=<?php echo $_GET['pid']; ?>"> 
                <table class="form-table">
                <tr valign="top"> 
                <th scope="row"><?php _e('Name') ?></th> 
				<td><input name="package_name" type="text" id="package_name" style="width: 95%" value="<?php echo $_POST['package_name']; ?>" size="45" />
                <br />
                <?php //_e('') ?></td> 
                </tr> 
                <tr valign="top"> 
                <th scope="row"><?php _e('Description:') ?></th> 
				<td><input name="package_description" type="text" id="package_description" style="width: 95%" value="<?php echo $_POST['package_description']; ?>" size="45" />
                <br />
                <?php //_e('') ?></td> 
                </tr> 
                <tr valign="top"> 
                <th scope="row"><?php _e('One Month') ?></th> 
				<td><select id="package_cost_one" name="package_cost_one" >
				<?php for ( $i = 1; $i < 101; ++$i ) echo "<option value='$i' ".($_POST['package_cost_one']==$i ? "selected='selected'" : '').">$i</option>"; ?>
				</select>
                <br />
                <?php _e('Credits') ?></td>
                </tr> 
                <tr valign="top"> 
                <th scope="row"><?php _e('Three Months') ?></th> 
				<td><select id="package_cost_three" name="package_cost_three" >
				<?php for ( $i = 1; $i < 101; ++$i ) echo "<option value='$i' ".($_POST['package_cost_three']==$i ? "selected='selected'" : '').">$i</option>"; ?>
				</select>
                <br />
                <?php _e('Credits') ?></td>
                </tr> 
                <tr valign="top"> 
                <th scope="row"><?php _e('Twelve Months') ?></th>
				<td><select id="package_cost_twelve" name="package_cost_twelve" >
				<?php for ( $i = 1; $i < 101; ++$i ) echo "<option value='$i' ".($_POST['package_cost_twelve']==$i ? "selected='selected'" : '').">$i</option>"; ?>
				</select>
                <br />
                <?php _e('Credits') ?></td>
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Plugin One') ?></th> 
				<td><select name="package_plugin_one" id="package_plugin_one">
				<?php upgrades_output_plugins_select($_POST['package_plugin_one']) ?>
				</select>
                <br />
                <?php //_e('') ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Plugin Two') ?></th> 
				<td><select name="package_plugin_two" id="package_plugin_two">
				<?php upgrades_output_plugins_select($_POST['package_plugin_two']) ?>
				</select>
                <br />
                <?php //_e('') ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Plugin Three') ?></th> 
				<td><select name="package_plugin_three" id="package_plugin_three">
				<?php upgrades_output_plugins_select($_POST['package_plugin_three']) ?>
				</select>
                <br />
                <?php //_e('') ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Plugin Four') ?></th> 
				<td><select name="package_plugin_four" id="package_plugin_four">
				<?php upgrades_output_plugins_select($_POST['package_plugin_four']) ?>
				</select>
                <br />
                <?php //_e('') ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Plugin Five') ?></th> 
				<td><select name="package_plugin_five" id="package_plugin_five">
				<?php upgrades_output_plugins_select($_POST['package_plugin_five']) ?>
				</select>
                <br />
                <?php //_e('') ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Plugin Six') ?></th> 
				<td><select name="package_plugin_six" id="package_plugin_six">
				<?php upgrades_output_plugins_select($_POST['package_plugin_six']) ?>
				</select>
                <br />
                <?php //_e('') ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Plugin Seven') ?></th> 
				<td><select name="package_plugin_seven" id="package_plugin_seven">
				<?php upgrades_output_plugins_select($_POST['package_plugin_seven']) ?>
				</select>
                <br />
                <?php //_e('') ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Plugin Eight') ?></th> 
				<td><select name="package_plugin_eight" id="package_plugin_eight">
				<?php upgrades_output_plugins_select($_POST['package_plugin_eight']) ?>
				</select>
                <br />
                <?php //_e('') ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Plugin Nine') ?></th> 
				<td><select name="package_plugin_nine" id="package_plugin_nine">
				<?php upgrades_output_plugins_select($_POST['package_plugin_nine']) ?>
				</select>
                <br />
                <?php //_e('') ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Plugin Ten') ?></th> 
				<td><select name="package_plugin_ten" id="package_plugin_ten">
				<?php upgrades_output_plugins_select($_POST['package_plugin_ten']) ?>
				</select>
                <br />
                <?php //_e('') ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Plugin Eleven') ?></th> 
				<td><select name="package_plugin_eleven" id="package_plugin_eleven">
				<?php upgrades_output_plugins_select($_POST['package_plugin_eleven']) ?>
				</select>
                <br />
                <?php //_e('') ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Plugin Twelve') ?></th> 
				<td><select name="package_plugin_twelve" id="package_plugin_twelve">
				<?php upgrades_output_plugins_select($_POST['package_plugin_twelve']) ?>
				</select>
                <br />
                <?php //_e('') ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Plugin Thirteen') ?></th> 
				<td><select name="package_plugin_thirteen" id="package_plugin_thirteen">
				<?php upgrades_output_plugins_select($_POST['package_plugin_thirteen']) ?>
				</select>
                <br />
                <?php //_e('') ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Plugin Fourteen') ?></th> 
				<td><select name="package_plugin_fourteen" id="package_plugin_fourteen">
				<?php upgrades_output_plugins_select($_POST['package_plugin_fourteen']) ?>
				</select>
                <br />
                <?php //_e('') ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Plugin Fifteen') ?></th> 
				<td><select name="package_plugin_fifteen" id="package_plugin_fifteen">
				<?php upgrades_output_plugins_select($_POST['package_plugin_fifteen']) ?>
				</select>
                <br />
                <?php //_e('') ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Active') ?></th> 
				<td><select name="package_active" id="package_active">
                <?php
				if ($_POST['package_active'] == '1'){
				?>
				<option value="1" selected="selected"><?php _e('Yes') ?></option>
				<option value="0"><?php _e('No') ?></option>
                <?php
				} else {
				?>
				<option value="1"><?php _e('Yes') ?></option>
				<option value="0" selected="selected"><?php _e('No') ?></option>
                <?php
				}
				?>
				</select>
                <br />
                <?php //_e('') ?></td> 
                </tr>
                </table>
            <p class="submit"> 
            <input type="submit" name="Submit" value="<?php _e('Save Changes') ?>" /> 
            </p> 
            </form>
        <?php
		} else {
			$wpdb->query( "UPDATE " . $wpdb->base_prefix . "upgrades_packages SET package_name = '" . $_POST['package_name'] . "' WHERE package_ID = '" . $_GET['pid'] . "'" );
			$wpdb->query( "UPDATE " . $wpdb->base_prefix . "upgrades_packages SET package_description = '" . $_POST['package_description'] . "' WHERE package_ID = '" . $_GET['pid'] . "'" );
			$wpdb->query( "UPDATE " . $wpdb->base_prefix . "upgrades_packages SET package_cost_one = '" . $_POST['package_cost_one'] . "' WHERE package_ID = '" . $_GET['pid'] . "'" );
			$wpdb->query( "UPDATE " . $wpdb->base_prefix . "upgrades_packages SET package_cost_three = '" . $_POST['package_cost_three'] . "' WHERE package_ID = '" . $_GET['pid'] . "'" );
			$wpdb->query( "UPDATE " . $wpdb->base_prefix . "upgrades_packages SET package_cost_twelve = '" . $_POST['package_cost_twelve'] . "' WHERE package_ID = '" . $_GET['pid'] . "'" );
			$wpdb->query( "UPDATE " . $wpdb->base_prefix . "upgrades_packages SET package_active = '" . $_POST['package_active'] . "' WHERE package_ID = '" . $_GET['pid'] . "'" );
			
			$wpdb->query( "UPDATE " . $wpdb->base_prefix . "upgrades_packages SET package_plugin_one = '" . $_POST['package_plugin_one'] . "' WHERE package_ID = '" . $_GET['pid'] . "'" );
			$wpdb->query( "UPDATE " . $wpdb->base_prefix . "upgrades_packages SET package_plugin_two = '" . $_POST['package_plugin_two'] . "' WHERE package_ID = '" . $_GET['pid'] . "'" );
			$wpdb->query( "UPDATE " . $wpdb->base_prefix . "upgrades_packages SET package_plugin_three = '" . $_POST['package_plugin_three'] . "' WHERE package_ID = '" . $_GET['pid'] . "'" );
			$wpdb->query( "UPDATE " . $wpdb->base_prefix . "upgrades_packages SET package_plugin_four = '" . $_POST['package_plugin_four'] . "' WHERE package_ID = '" . $_GET['pid'] . "'" );
			$wpdb->query( "UPDATE " . $wpdb->base_prefix . "upgrades_packages SET package_plugin_five = '" . $_POST['package_plugin_five'] . "' WHERE package_ID = '" . $_GET['pid'] . "'" );
			$wpdb->query( "UPDATE " . $wpdb->base_prefix . "upgrades_packages SET package_plugin_six = '" . $_POST['package_plugin_six'] . "' WHERE package_ID = '" . $_GET['pid'] . "'" );
			$wpdb->query( "UPDATE " . $wpdb->base_prefix . "upgrades_packages SET package_plugin_seven = '" . $_POST['package_plugin_seven'] . "' WHERE package_ID = '" . $_GET['pid'] . "'" );
			$wpdb->query( "UPDATE " . $wpdb->base_prefix . "upgrades_packages SET package_plugin_eight = '" . $_POST['package_plugin_eight'] . "' WHERE package_ID = '" . $_GET['pid'] . "'" );
			$wpdb->query( "UPDATE " . $wpdb->base_prefix . "upgrades_packages SET package_plugin_nine = '" . $_POST['package_plugin_nine'] . "' WHERE package_ID = '" . $_GET['pid'] . "'" );
			$wpdb->query( "UPDATE " . $wpdb->base_prefix . "upgrades_packages SET package_plugin_ten = '" . $_POST['package_plugin_ten'] . "' WHERE package_ID = '" . $_GET['pid'] . "'" );
			$wpdb->query( "UPDATE " . $wpdb->base_prefix . "upgrades_packages SET package_plugin_eleven = '" . $_POST['package_plugin_eleven'] . "' WHERE package_ID = '" . $_GET['pid'] . "'" );
			$wpdb->query( "UPDATE " . $wpdb->base_prefix . "upgrades_packages SET package_plugin_twelve = '" . $_POST['package_plugin_twelve'] . "' WHERE package_ID = '" . $_GET['pid'] . "'" );
			$wpdb->query( "UPDATE " . $wpdb->base_prefix . "upgrades_packages SET package_plugin_thirteen = '" . $_POST['package_plugin_thirteen'] . "' WHERE package_ID = '" . $_GET['pid'] . "'" );
			$wpdb->query( "UPDATE " . $wpdb->base_prefix . "upgrades_packages SET package_plugin_fourteen = '" . $_POST['package_plugin_fourteen'] . "' WHERE package_ID = '" . $_GET['pid'] . "'" );
			$wpdb->query( "UPDATE " . $wpdb->base_prefix . "upgrades_packages SET package_plugin_fifteen = '" . $_POST['package_plugin_fifteen'] . "' WHERE package_ID = '" . $_GET['pid'] . "'" );
			
			
			//$wpdb->query( "INSERT INTO " . $wpdb->base_prefix . "upgrades_package (package_name, package_description, package_cost_one, package_cost_three, package_cost_twelve, package_active) VALUES ( '" . $_POST['package_name'] . "', '" . $_POST['package_description'] . "', '" . $_POST['package_cost_one'] . "', '" . $_POST['package_cost_three'] . "', '" . $_POST['package_cost_twelve'] . "', '" . $_POST['package_active'] . "' )" );
			echo "
			<SCRIPT LANGUAGE='JavaScript'>
			window.location='wpmu-admin.php?page=upgrades&updated=true&updatedmsg=" . urlencode(__('Settings saved.')) . "';
			</script>
			";
		}
		break;
		//---------------------------------------------------//
		case "delete_package":
		$package_active_count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "upgrades_package_status WHERE package_ID = '" . $_GET['pid'] . "' AND package_expire > '" . time() . "'");
		if ($package_active_count > 0){
		?>
        <p><?php _e('You cannot remove a package while users are subscribed to it.') ?></p>
        <?php
		} else {
			$wpdb->query( "DELETE FROM " . $wpdb->base_prefix . "upgrades_packages WHERE package_ID = '" . $_GET['pid'] . "'" );
			
			echo "
			<SCRIPT LANGUAGE='JavaScript'>
			window.location='wpmu-admin.php?page=upgrades&updated=true&updatedmsg=" . urlencode(__('Package Removed.')) . "';
			</script>
			";
		}
		break;
		//---------------------------------------------------//
		case "manage_credits":
		
			if ($_POST['manage_credits_action'] == 'send_all_users'){
			?>
			<h2><?php _e('Send Credits To All Users') ?></h2>
            <form name="form1" method="POST" action="wpmu-admin.php?page=upgrades&action=manage_credits_process">
            <input type="hidden" name="manage_credits_action" value="send_all_users" />
			<table class="form-table"> 
                <tr valign="top"> 
                <th scope="row"><?php _e('Credits') ?></th> 
                <td><select name="manage_credits_number">
				<?php
					$tmp_default_credits = '20';
					$tmp_counter = 0;
					for ( $counter = 1; $counter <= 100; $counter += 1) {
						$tmp_counter = $tmp_counter + 1;
                        echo '<option value="' . $tmp_counter . '"' . ($tmp_counter == $tmp_default_credits ? ' selected' : '') . '>' . $tmp_counter . '</option>' . "\n";
					}
                ?>
                </select>
                <br />
                <?php //_e(''); ?></td> 
                </tr>
            </table>
            <p class="submit">
            <input type="submit" name="Submit" value="<?php _e('Send') ?>" />
            </p>
            </form>
            <?php
			}
			?>
            <?php
			if ($_POST['manage_credits_action'] == 'send_single_user'){
			?>
			<h2><?php _e('Send Credits To One User') ?></h2>
            <form name="form1" method="POST" action="wpmu-admin.php?page=upgrades&action=manage_credits_process">
            <input type="hidden" name="manage_credits_action" value="send_single_user" />
			<table class="form-table">
                <tr valign="top"> 
                <th scope="row"><?php _e('User (name, not ID)') ?></th> 
                <td><input name="manage_credits_user" value="" />
                <br />
                <?php _e('Case Sensitive'); ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Credits') ?></th> 
                <td><select name="manage_credits_number">
				<?php
					$tmp_default_credits = '20';
					$tmp_counter = 0;
					for ( $counter = 1; $counter <= 100; $counter += 1) {
						$tmp_counter = $tmp_counter + 1;
                        echo '<option value="' . $tmp_counter . '"' . ($tmp_counter == $tmp_default_credits ? ' selected' : '') . '>' . $tmp_counter . '</option>' . "\n";
					}
                ?>
                </select>
                <br />
                <?php //_e(''); ?></td> 
                </tr>
            </table>
            <p class="submit">
            <input type="submit" name="Submit" value="<?php _e('Send') ?>" />
            </p>
            </form>
            <?php
			}
			?>
            <?php
		break;
		//---------------------------------------------------//
		case "manage_credits_process":
			if ($_POST['manage_credits_action'] == 'send_all_users'){
				$query = "SELECT ID, user_login FROM " . $wpdb->base_prefix . "users";
				$tmp_manage_credits_users = $wpdb->get_results( $query, ARRAY_A );
				if (count($tmp_manage_credits_users) > 0){
					foreach ($tmp_manage_credits_users as $tmp_manage_credits_user){
					//=========================================================//
					upgrades_user_credit_check($tmp_manage_credits_user['ID']);
					upgrades_user_credits_add($_POST['manage_credits_number'], $tmp_manage_credits_user['ID']);
					//=========================================================//
					}
				}
				echo "
				<SCRIPT LANGUAGE='JavaScript'>
				window.location='wpmu-admin.php?page=upgrades&updated=true&updatedmsg=" . urlencode(__('Credits Sent.')) . "';
				</script>
				";
			}
			if ($_POST['manage_credits_action'] == 'send_single_user'){
				$tmp_user_check = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "users WHERE user_login = '" . $_POST['manage_credits_user'] . "'");
				if ($tmp_user_check == 0){
				?>
                    <h2><?php _e('Send Credits To One User') ?></h2>
                    <p><?php _e('User not found! Please check the spelling.'); ?></p>
                    <form name="form1" method="POST" action="wpmu-admin.php?page=upgrades&action=manage_credits_process">
                    <input type="hidden" name="manage_credits_action" value="send_single_user" />
                    <table class="optiontable"> 
                        <tr valign="top"> 
                        <th scope="row"><?php _e('User (name, not ID):') ?></th> 
                        <td><input name="manage_credits_user" value="" />
                        <br />
                        <?php _e('Case Sensitive'); ?></td> 
                        </tr>
                        <tr valign="top"> 
                        <th scope="row"><?php _e('Credits:') ?></th> 
                        <td><select name="manage_credits_number">
                        <?php
                            $tmp_default_credits = '20';
                            $tmp_counter = 0;
                            for ( $counter = 1; $counter <= 100; $counter += 1) {
                                $tmp_counter = $tmp_counter + 1;
                                echo '<option value="' . $tmp_counter . '"' . ($tmp_counter == $tmp_default_credits ? ' selected' : '') . '>' . $tmp_counter . '</option>' . "\n";
                            }
                        ?>
                        </select>
                        <br />
                        <?php //_e(''); ?></td> 
                        </tr>
                    </table>
                    <p class="submit"><input type="submit" name="Submit" value="<?php _e('Send &raquo;') ?>" /></p>
                    </form>
				<?php
				} else {
					$tmp_user_ID = $wpdb->get_var("SELECT ID FROM " . $wpdb->base_prefix . "users WHERE  user_login = '" . $_POST['manage_credits_user'] . "'");
					upgrades_user_credit_check($tmp_user_ID);
					upgrades_user_credits_add($_POST['manage_credits_number'], $tmp_user_ID);
					echo "
					<SCRIPT LANGUAGE='JavaScript'>
					window.location='wpmu-admin.php?page=upgrades&updated=true&updatedmsg=" . urlencode(__('Credits Sent To ' . $_POST['manage_credits_user'] . '.')) . "';
					</script>
					";
				}
			}
		break;
		//---------------------------------------------------//
		case "3":
		break;
		//---------------------------------------------------//
	}
	echo '</div>';
}

function upgrades_output() {
	global $wpdb, $wp_roles, $current_user, $upgrades_branding_singular, $upgrades_branding_plural;
	

	
	if (isset($_GET['updated'])) {
		?><div id="message" class="updated fade"><p><?php _e('' . urldecode($_GET['updatedmsg']) . '') ?></p></div><?php
	}
	echo '<div class="wrap">';
	switch( $_GET[ 'action' ] ) {
		//---------------------------------------------------//
		default:
			upgrades_user_credit_check();
			?>
            <h2><?php _e('Packages') ?>&nbsp;&nbsp;&nbsp;<em style="font-size:14px;"><?php _e('You currently have'); ?> <?php echo $wpdb->get_var("SELECT credits FROM " . $wpdb->base_prefix . "upgrades_credits WHERE  user_ID = '" . $current_user->ID . "'"); ?> <?php _e(' credits for use with your blog(s)'); ?></em></h2>
            <?php
			//-------------------------------------//
			$query = "SELECT package_ID, package_name, package_description, package_cost_one, package_cost_three, package_cost_twelve FROM " . $wpdb->base_prefix . "upgrades_packages WHERE package_active = '1'";
			if( $_GET[ 'sortby' ] == 'active' ) {
				$query .= ' ORDER BY package_active DESC';
			} else {
				$query .= ' ORDER BY package_ID DESC';
			}
			$upgrades_package_subscribe_list = $wpdb->get_results( $query, ARRAY_A );
			//-------------------------------------//
			echo "
			<table cellpadding='3' cellspacing='3' width='100%' class='widefat'> 
			<tbody><tr class='thead'>
			<th scope='col'>" . __('ID') . "</th>
			<th scope='col'>" . __('Name') . "</th>
			<th scope='col'>" . __('Description') . "</th>
			<th scope='col'>" . __('1 Month') . "</th>
			<th scope='col'>" . __('3 Months') . "</th>
			<th scope='col'>" . __('12 Months') . "</th>
			<th scope='col'>" . __('Action') . "</th>
			</tr>
			";
			echoArrayPremiumSubscribePackages($upgrades_package_subscribe_list);
			?>
			</tbody></table>
            <?php

				
		break;
		//---------------------------------------------------//
		case "subscribe":
		$tmp_package_name = $wpdb->get_var("SELECT package_name FROM " . $wpdb->base_prefix . "upgrades_packages WHERE package_ID = '" . $_GET['pid'] . "'");
		$tmp_package_cost_one = $wpdb->get_var("SELECT package_cost_one FROM " . $wpdb->base_prefix . "upgrades_packages WHERE package_ID = '" . $_GET['pid'] . "'");
		$tmp_package_cost_three = $wpdb->get_var("SELECT package_cost_three FROM " . $wpdb->base_prefix . "upgrades_packages WHERE package_ID = '" . $_GET['pid'] . "'");
		$tmp_package_cost_twelve = $wpdb->get_var("SELECT package_cost_twelve FROM " . $wpdb->base_prefix . "upgrades_packages WHERE package_ID = '" . $_GET['pid'] . "'");
		?>
        	<h2><?php _e('Subscribe To Package ') ?>&nbsp;&nbsp;&nbsp;(<em><?php echo $tmp_package_name; ?></em>)</h2>
            <form name="subscribe" method="POST" action="upgrades.php?action=subscribe_process&pid=<?php echo $_GET['pid']; ?>"> 
            <table class="form-table">
                <tr valign="top"> 
                <th scope="row"><?php _e('Period') ?></th> 
				<td><select name="period" id="period">
				<option value="1"><?php _e('1 Month (') ?><?php echo $tmp_package_cost_one; ?><?php _e(' Credits)') ?></option>
                <option value="3"><?php _e('3 Months (') ?><?php echo $tmp_package_cost_three; ?><?php _e(' Credits)') ?></option>
                <option value="12"><?php _e('12 Months (') ?><?php echo $tmp_package_cost_twelve; ?><?php _e(' Credits)') ?></option>
				</select>
                <br />
                <?php //_e('') ?></td> 
                </tr>
                </table>
            <p class="submit"> 
            <input type="submit" name="Submit" value="<?php _e('Subscribe') ?>" /> 
            </p> 
            </form>
		<?php
		break;
		//---------------------------------------------------//
		case "subscribe_process":
		$tmp_package_name = $wpdb->get_var("SELECT package_name FROM " . $wpdb->base_prefix . "upgrades_packages WHERE package_ID = '" . $_GET['pid'] . "'");
		$tmp_package_cost_one = $wpdb->get_var("SELECT package_cost_one FROM " . $wpdb->base_prefix . "upgrades_packages WHERE package_ID = '" . $_GET['pid'] . "'");
		$tmp_package_cost_three = $wpdb->get_var("SELECT package_cost_three FROM " . $wpdb->base_prefix . "upgrades_packages WHERE package_ID = '" . $_GET['pid'] . "'");
		$tmp_package_cost_twelve = $wpdb->get_var("SELECT package_cost_twelve FROM " . $wpdb->base_prefix . "upgrades_packages WHERE package_ID = '" . $_GET['pid'] . "'");
		
		$tmp_available_credits = $wpdb->get_var("SELECT credits FROM " . $wpdb->base_prefix . "upgrades_credits WHERE  user_ID = '" . $current_user->ID . "'");
		
		$tmp_credit_check = 0;
		
		if ($_POST['period'] == '1'){
			if ($tmp_package_cost_one > $tmp_available_credits){
				$tmp_credit_check = 1;
			}
		} else if ($_POST['period'] == '3'){
			if ($tmp_package_cost_three > $tmp_available_credits){
				$tmp_credit_check = 1;
			}
		} else if ($_POST['period'] == '12'){
			if ($tmp_package_cost_twelve > $tmp_available_credits){
				$tmp_credit_check = 1;
			}
		}

		if ($tmp_credit_check == 1){
			echo '<p>' . __('You currently do not have enought credits to subscribe to this package!') . ' ' . __('Click <a href="upgrades.php?page=credits" >here</a> to purchase more credits.') .'</p>';
		} else {
			upgrades_subscribe($_GET['pid'], $_POST['period']);
			upgrades_log_add_msg($current_user->ID, __('You subscribed to package #') . $_GET['pid'] );
			if ($_POST['period'] == '1'){
				$tmp_new_total = $tmp_available_credits - $tmp_package_cost_one;
				upgrades_user_credits_update($tmp_new_total);
			} else if ($_POST['period'] == '3'){
				$tmp_new_total = $tmp_available_credits - $tmp_package_cost_three;
				upgrades_user_credits_update($tmp_new_total);
			} else if ($_POST['period'] == '12'){
				$tmp_new_total = $tmp_available_credits - $tmp_package_cost_twelve;
				upgrades_user_credits_update($tmp_new_total);
			}
			echo '<p>' . __('Subscription Active!');
			echo "
			<SCRIPT LANGUAGE='JavaScript'>
			window.location='upgrades.php?updated=true&updatedmsg=" . urlencode('Subscription Active.') . "';
			</script>
			";
		}
		
		break;
		//---------------------------------------------------//
		case "extend":
		$tmp_package_name = $wpdb->get_var("SELECT package_name FROM " . $wpdb->base_prefix . "upgrades_packages WHERE package_ID = '" . $_GET['pid'] . "'");
		$tmp_package_cost_one = $wpdb->get_var("SELECT package_cost_one FROM " . $wpdb->base_prefix . "upgrades_packages WHERE package_ID = '" . $_GET['pid'] . "'");
		$tmp_package_cost_three = $wpdb->get_var("SELECT package_cost_three FROM " . $wpdb->base_prefix . "upgrades_packages WHERE package_ID = '" . $_GET['pid'] . "'");
		$tmp_package_cost_twelve = $wpdb->get_var("SELECT package_cost_twelve FROM " . $wpdb->base_prefix . "upgrades_packages WHERE package_ID = '" . $_GET['pid'] . "'");
		?>
        	<h2><?php _e('Extend Subscription To Package') ?>&nbsp;&nbsp;&nbsp;(<em><?php echo $tmp_package_name; ?></em>)</h2>
            <form name="subscribe" method="POST" action="upgrades.php?action=extend_process&pid=<?php echo $_GET['pid']; ?>"> 
            <table class="form-table">
                <tr valign="top"> 
                <th scope="row"><?php _e('Period') ?></th> 
				<td><select name="period" id="period">
				<option value="1"><?php _e('1 Month (') ?><?php echo $tmp_package_cost_one; ?><?php _e(' Credits)') ?></option>
                <option value="3"><?php _e('3 Months (') ?><?php echo $tmp_package_cost_three; ?><?php _e(' Credits)') ?></option>
                <option value="12"><?php _e('12 Months (') ?><?php echo $tmp_package_cost_twelve; ?><?php _e(' Credits)') ?></option>
				</select>
                <br />
                <?php //_e('') ?></td> 
                </tr>
                </table>
            <p class="submit"> 
            <input type="submit" name="Submit" value="<?php _e('Extend') ?>" /> 
            </p> 
            </form>
		<?php
		break;
		//---------------------------------------------------//
		case "extend_process":
		$tmp_package_name = $wpdb->get_var("SELECT package_name FROM " . $wpdb->base_prefix . "upgrades_packages WHERE package_ID = '" . $_GET['pid'] . "'");
		$tmp_package_cost_one = $wpdb->get_var("SELECT package_cost_one FROM " . $wpdb->base_prefix . "upgrades_packages WHERE package_ID = '" . $_GET['pid'] . "'");
		$tmp_package_cost_three = $wpdb->get_var("SELECT package_cost_three FROM " . $wpdb->base_prefix . "upgrades_packages WHERE package_ID = '" . $_GET['pid'] . "'");
		$tmp_package_cost_twelve = $wpdb->get_var("SELECT package_cost_twelve FROM " . $wpdb->base_prefix . "upgrades_packages WHERE package_ID = '" . $_GET['pid'] . "'");
		
		$tmp_available_credits = $wpdb->get_var("SELECT credits FROM " . $wpdb->base_prefix . "upgrades_credits WHERE  user_ID = '" . $current_user->ID . "'");
		
		$tmp_credit_check = 0;
		
		if ($_POST['period'] == '1'){
			if ($tmp_package_cost_one > $tmp_available_credits){
				$tmp_credit_check = 1;
			}
		} else if ($_POST['period'] == '3'){
			if ($tmp_package_cost_three > $tmp_available_credits){
				$tmp_credit_check = 1;
			}
		} else if ($_POST['period'] == '12'){
			if ($tmp_package_cost_twelve > $tmp_available_credits){
				$tmp_credit_check = 1;
			}
		}

		if ($tmp_credit_check == 1){
			echo '<p>' . __('You currently do not have enought credits to extend the subscription for this package!') . ' ' . __('Click <a href="upgrades.php?page=credits" >here</a> to purchase more credits.') .'</p>';
		} else {
			upgrades_extend($_GET['pid'], $_POST['period']);
			upgrades_log_add_msg($current_user->ID, __('You extended your subscription to package #') . $_GET['pid'] );
			if ($_POST['period'] == '1'){
				$tmp_new_total = $tmp_available_credits - $tmp_package_cost_one;
				upgrades_user_credits_update($tmp_new_total);
			} else if ($_POST['period'] == '3'){
				$tmp_new_total = $tmp_available_credits - $tmp_package_cost_three;
				upgrades_user_credits_update($tmp_new_total);
			} else if ($_POST['period'] == '12'){
				$tmp_new_total = $tmp_available_credits - $tmp_package_cost_twelve;
				upgrades_user_credits_update($tmp_new_total);
			}	
			echo '<p>' . __('Subscription Extended!');
			echo "
			<SCRIPT LANGUAGE='JavaScript'>
			window.location='upgrades.php?updated=true&updatedmsg=" . urlencode('Subscription Extended.') . "';
			</script>
			";
		}
		break;
		//---------------------------------------------------//
		case "cancel":
		$tmp_package_name = $wpdb->get_var("SELECT package_name FROM " . $wpdb->base_prefix . "upgrades_packages WHERE package_ID = '" . $_GET['pid'] . "'");
		$tmp_package_cost_one = $wpdb->get_var("SELECT package_cost_one FROM " . $wpdb->base_prefix . "upgrades_packages WHERE package_ID = '" . $_GET['pid'] . "'");
		$tmp_package_cost_three = $wpdb->get_var("SELECT package_cost_three FROM " . $wpdb->base_prefix . "upgrades_packages WHERE package_ID = '" . $_GET['pid'] . "'");
		$tmp_package_cost_twelve = $wpdb->get_var("SELECT package_cost_twelve FROM " . $wpdb->base_prefix . "upgrades_packages WHERE package_ID = '" . $_GET['pid'] . "'");
		?>
        	<h2><?php _e('Cancel Subscription To Package') ?>&nbsp;&nbsp;&nbsp;(<em><?php echo $tmp_package_name; ?></em>)</h2>
            <p><?php _e('Please note that you will not receive any credits back for the time remaining on the subscription.') ?></p>
            <form name="cancel" method="POST" action="upgrades.php?action=cancel_process&pid=<?php echo $_GET['pid']; ?>"> 
            <p class="submit"> 
            <input type="submit" name="Submit" value="<?php _e('Cancel Subscription') ?>" /> 
            </p> 
            </form>
		<?php
		break;
		//---------------------------------------------------//
		case "cancel_process":
			upgrades_cancel($_GET['pid']);
			upgrades_log_add_msg($current_user->ID, __('You canceled your subscription to package #') . $_GET['pid'] );
			echo '<p>' . __('Subscription Canceled!') . '</p>';
			echo "
			<SCRIPT LANGUAGE='JavaScript'>
			window.location='upgrades.php?updated=true&updatedmsg=" . urlencode('Subscription Canceled.') . "';
			</script>
			";
		break;
		//---------------------------------------------------//
	}
	echo '</div>';
}

function upgrades_credits_output() {
	global $wpdb, $wp_roles, $current_user, $upgrades_branding_singular, $upgrades_branding_plural;
	if(!current_user_can('edit_users')) {
		echo "<p>Nice Try...</p>";  //If accessed properly, this message doesn't appear.
		return;
	}
	if (isset($_GET['updated'])) {
		?><div id="message" class="updated fade"><p><?php _e('' . urldecode($_GET['updatedmsg']) . '') ?></p></div><?php
	}
	echo '<div class="wrap">';
	switch( $_GET[ 'action' ] ) {
		//---------------------------------------------------//
		default:
		upgrades_user_credit_check();
		?>
        <h2><?php _e('Add Credits') ?>&nbsp;&nbsp;&nbsp;<em style="font-size:14px;"><?php _e('You currently have'); ?> <?php echo $wpdb->get_var("SELECT credits FROM " . $wpdb->base_prefix . "upgrades_credits WHERE  user_ID = '" . $current_user->ID . "'"); ?> <?php _e(' credits for use with your blog(s)'); ?></em></h2>
        <?php
		$tmp_amount = get_site_option( "upgrades_cost_per_credit" );
		$tmp_amount = $tmp_amount . ' ' . get_site_option( "upgrades_currency" );
		echo '<p>' . __('Credits are ') . $tmp_amount . __(' each') . '</p>';
		upgrades_buy_output();
		echo '<br />';
		if ($wpdb->get_var("SELECT credits FROM " . $wpdb->base_prefix . "upgrades_credits WHERE user_ID = '" . $current_user->ID . "'") == 0){
			//do nothing
		} else {
			echo '<h2>' . __('Give credits as a gift') . '</h2>';
			?>
				<form action="upgrades.php?page=credits&action=confirm_gift" method="post">
				<table class="form-table">
                <tr valign="top">
                <th scope="row"><?php _e('Credits:') ?></th> 
                <td>
                <select name="num_credits" id="num_credits">
                <?php
                if ($wpdb->get_var("SELECT credits FROM " . $wpdb->base_prefix . "upgrades_credits WHERE  user_ID = '" . $current_user->ID . "'") > 5){
                    echo'<option value="5">5</option>';
                }
                if ($wpdb->get_var("SELECT credits FROM " . $wpdb->base_prefix . "upgrades_credits WHERE  user_ID = '" . $current_user->ID . "'") > 10){
                    echo'<option value="10">10</option>';
                }
                if ($wpdb->get_var("SELECT credits FROM " . $wpdb->base_prefix . "upgrades_credits WHERE  user_ID = '" . $current_user->ID . "'") > 15){
                    echo'<option value="15">15</option>';
                }
                if ($wpdb->get_var("SELECT credits FROM " . $wpdb->base_prefix . "upgrades_credits WHERE  user_ID = '" . $current_user->ID . "'") > 20){
                    echo'<option value="20">20</option>';
                }
                if ($wpdb->get_var("SELECT credits FROM " . $wpdb->base_prefix . "upgrades_credits WHERE  user_ID = '" . $current_user->ID . "'") > 25){
                    echo'<option value="25">25</option>';
                }
                if ($wpdb->get_var("SELECT credits FROM " . $wpdb->base_prefix . "upgrades_credits WHERE  user_ID = '" . $current_user->ID . "'") > 30){
                    echo'<option value="30">30</option>';
                }
                if ($wpdb->get_var("SELECT credits FROM " . $wpdb->base_prefix . "upgrades_credits WHERE  user_ID = '" . $current_user->ID . "'") > 35){
                    echo'<option value="35">35</option>';
                }
                if ($wpdb->get_var("SELECT credits FROM " . $wpdb->base_prefix . "upgrades_credits WHERE  user_ID = '" . $current_user->ID . "'") > 40){
                    echo'<option value="40">40</option>';
                }
                if ($wpdb->get_var("SELECT credits FROM " . $wpdb->base_prefix . "upgrades_credits WHERE  user_ID = '" . $current_user->ID . "'") > 45){
                    echo'<option value="45">45</option>';
                }
                if ($wpdb->get_var("SELECT credits FROM " . $wpdb->base_prefix . "upgrades_credits WHERE  user_ID = '" . $current_user->ID . "'") > 50){
                    echo'<option value="50">50</option>';
                }
                if ($wpdb->get_var("SELECT credits FROM " . $wpdb->base_prefix . "upgrades_credits WHERE  user_ID = '" . $current_user->ID . "'") > 100){
                    echo'<option value="100">100</option>';
                }
                echo'<option value="' . $wpdb->get_var("SELECT credits FROM " . $wpdb->base_prefix . "upgrades_credits WHERE  user_ID = '" . $current_user->ID . "'") . '">' . $wpdb->get_var("SELECT credits FROM " . $wpdb->base_prefix . "upgrades_credits WHERE  user_ID = '" . $current_user->ID . "'") . '</option>';

                ?>
                </select>
                </td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Send to (Username)') ?></th> 
                <td>
	            <input name="username" value="" type="text">
        	    <br />
       	    	<?php _e('Note: This should be the username the person uses to login with and not the name of their blog.') ?>
                </td> 
                </tr> 
                </table>
				<p class="submit">
				<input name="Submit" value="<?php _e('Send'); ?>" type="submit">
				</p>
				</form>
			<?php
		}
		break;
		//---------------------------------------------------//
		case "confirm_gift":
		$check_credits = $wpdb->get_var("SELECT credits FROM " . $wpdb->base_prefix . "upgrades_credits WHERE  user_ID = '" . $current_user->ID . "'");
		$check_username = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "users WHERE  user_login = '" . $_POST['username'] . "'");
		$username_id = $wpdb->get_var("SELECT ID FROM " . $wpdb->base_prefix . "users WHERE  user_login = '" . $_POST['username'] . "'");
		$send_credits = $_POST['num_credits'];
		
		if ($_POST['username'] == ''){
			echo '<h2>' . __('Error') . '</h2>';
			echo '<p>' . __('You must enter a username!') . '</p>';
		} else if ($check_username == 0){
			echo '<h2>' . __('Error') . '</h2>';
			echo '<p>' . __('Invalid Username!') . '</p>';
		} else if ($send_credits > $check_credits){
			echo '<h2>' . __('Error') . '</h2>';
			echo '<p>' . __('You do not have enough credits!') . '</p>';
		} else {
			//--------------------------------//
				$tmp_new_credits = $check_credits - $send_credits;
				$wpdb->query( "UPDATE " . $wpdb->base_prefix . "upgrades_credits SET credits = '" . $tmp_new_credits . "' WHERE user_ID = '" . $current_user->ID . "'");
				//----//
				//make sure the other user has premium installed
					$tmp2_credits_check = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "upgrades_credits WHERE  user_ID = '" . $username_id . "'");
					if ($tmp2_credits_check == 0){
						$wpdb->query( "INSERT INTO " . $wpdb->base_prefix . "upgrades_credits (user_ID, credits) VALUES ( '" . $username_id . "', '0' )" );
					}
				//----//
				$tmp_username_credits = $wpdb->get_var("SELECT credits FROM " . $wpdb->base_prefix . "upgrades_credits WHERE user_ID = '" . $username_id . "'");
				$tmp_new_credits_receive = $tmp_username_credits + $send_credits;
				$wpdb->query( "UPDATE " . $wpdb->base_prefix . "upgrades_credits SET credits = '" . $tmp_new_credits_receive . "' WHERE user_ID = '" . $username_id . "'");
				
				upgrades_log_add_msg($current_user->ID, __("You sent ") . $send_credits . __(" credits to ") . $_POST['username'] . ".");
				$get_current_username = $wpdb->get_var("SELECT user_login FROM " . $wpdb->base_prefix . "users WHERE ID = '" . $current_user->ID . "'");
				upgrades_log_add_msg($username_id, "" . $get_current_username . __(" sent you ") . $send_credits . __(" credits."));
				//----//
				//Send email
				upgrades_gift_notification($get_current_username, $_POST['username'], $send_credits);
				//----//
			//--------------------------------//
			echo "
			<SCRIPT LANGUAGE='JavaScript'>
			window.location='upgrades.php?page=credits&updated=true&updatedmsg=" . urlencode('Gift Sent.') . "';
			</script>
			";
		}
		break;
		//---------------------------------------------------//
		case "add":
		break;
		//---------------------------------------------------//
		case "add_process":
		break;
		//---------------------------------------------------//
		case "1":
		break;
		//---------------------------------------------------//
		case "2":
		break;
		//---------------------------------------------------//

	}
	echo '</div>';
}

function upgrades_log_output() {
	global $wpdb, $wp_roles, $current_user, $upgrades_branding_singular, $upgrades_branding_plural;

	if (isset($_GET['updated'])) {
		?><div id="message" class="updated fade"><p><?php _e('' . urldecode($_GET['updatedmsg']) . '') ?></p></div><?php
	}
	echo '<div class="wrap">';
	switch( $_GET[ 'action' ] ) {
		//---------------------------------------------------//
		default:
			if( isset( $_GET[ 'start' ] ) == false ) {
				$start = 0;
			} else {
				$start = intval( $_GET[ 'start' ] );
			}
			if( isset( $_GET[ 'num' ] ) == false ) {
				$num = 30;
			} else {
				$num = intval( $_GET[ 'num' ] );
			}
	
			$query = "SELECT msg_ID, msg_text FROM " . $wpdb->base_prefix . "upgrades_log WHERE user_ID = '" . $current_user->ID . "' ";
			if( $_GET[ 'sortby' ] == 'Message' ) {
				$query .= ' ORDER BY msg_text ';
			} else {
				$query .= ' ORDER BY msg_ID ';
			}
				
			if( $_GET[ 'order' ] == 'ASC' ) {
				$query .= "ASC";
			} else {
				$query .= "DESC";
			}
	
			$query .= " LIMIT " . intval( $start ) . ", " . intval( $num );
			$upgrades_msg_list = $wpdb->get_results( $query, ARRAY_A );
			if( count( $friends_list ) < $num ) {
				$next = false;
			} else {
				$next = true;
			}	
		?>
			<h2><?php _e('History') ?></h2>
		<?php
			if (count($upgrades_msg_list) < 1){
				echo "<p>" . __('No history to display.') . "</p>";
			} else {
				if (count($upgrades_msg_list) > 30){
					?>
					<table><td>
					<fieldset> 
					<legend><?php _e('History Navigation') ?></legend> 
					<?php 
					
					$url2 = "order=" . $_GET[ 'order' ] . "&sortby=" . $_GET[ 'sortby' ];
					
					if( $start == 0 ) { 
						echo __('Previous&nbsp;Page');
					} elseif( $start <= 30 ) { 
						echo '<a href="upgrades.php?page=history&start=0&' . $url2 . ' ">' . __('Previous&nbsp;Page') . '</a>';
					} else {
						echo '<a href="upgrades.php?page=history&start=' . ( $start - $num ) . '&' . $url2 . '">' . __('Previous&nbsp;Page') . '</a>';
					} 
					if ( $next ) {
						echo '&nbsp;||&nbsp;<a href="upgrades.php?page=history&start=' . ( $start + $num ) . '&' . $url2 . '">' . __('Next&nbsp;Page') . '</a>';
					} else {
						echo '&nbsp;||&nbsp;Next&nbsp;Page';
					}
					?>
					</fieldset>
					</td></table>
					<br style="clear:both;" />
					<?php
					echo "
					<table cellpadding='3' cellspacing='3' width='100%' class='widefat'> 
					<tbody><tr class='thead'>
					<th scope='col'><a href='upgrades.php?page=history&sortby=ID&amp;start=" . $start . "'>" . __('ID') . "</a></th>
					<th scope='col'><a href='upgrades.php?page=history&sortby=Message&amp;order=ASC&amp;start=" . $start . "'>" . __('Message') . "/a></th>
					</tr>
					";
					echoArrayPremiumLog($upgrades_msg_list);
				} else {
					echo "
					<table cellpadding='3' cellspacing='3' width='100%' class='widefat'> 
					<tbody><tr class='thead'>
					<th scope='col'><a href='upgrades.php?page=history&sortby=ID&amp;start=" . $start . "'>" . __('ID') . "</a></th>
					<th scope='col'><a href='upgrades.php?page=history&sortby=Message&amp;order=ASC&amp;start=" . $start . "'>" . __('Message') . "</a></th>
					</tr>
					";
					echoArrayPremiumLog($upgrades_msg_list);
				}
			}
			?>
			</tbody></table>
			<?php
		break;
		//---------------------------------------------------//
		case "step1":
		break;
		//---------------------------------------------------//
		case "step2":
		break;
		//---------------------------------------------------//
		case "step3":
		break;
		//---------------------------------------------------//
	}
	echo '</div>';
}

//------------------------------------------------------------------------//
//---Support Functions----------------------------------------------------//
//------------------------------------------------------------------------//
?>
