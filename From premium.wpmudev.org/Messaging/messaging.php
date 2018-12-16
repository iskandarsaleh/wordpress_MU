<?php
/*
Plugin Name: Messaging
Plugin URI: 
Description:
Author: Andrew Billits
Version: 1.0.1
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

$messaging_current_version = '1.0.0';
//------------------------------------------------------------------------//
//---Config---------------------------------------------------------------//
//------------------------------------------------------------------------//

$messaging_max_inbox_messages = 30;
$messaging_max_reached_message = 'You are currently at or over your inbox message limit. You will not be able to view, reply to, or send new messages until you remove messages from your inbox.';
$messaging_official_message_bg_color = '#E5F3FF';

$messaging_email_notification_subject = __('[SITE_NAME] New Message'); // SITE_NAME
$messaging_email_notification_content = __('Dear TO_USER,

You have receieved a new message from FROM_USER.

Thanks,
SITE_NAME'); // TO_USER, FROM_USER, SITE_NAME, SITE_URL

//------------------------------------------------------------------------//
//---Hook-----------------------------------------------------------------//
//------------------------------------------------------------------------//
//check for activating
if ($_GET['key'] == '' || $_GET['key'] === ''){
	add_action('admin_head', 'messaging_make_current');
}
if($_GET['page'] == 'new'){
	add_action('admin_head', 'messaging_header_js');
}
if($_GET['action'] == 'reply' && $_GET['mid'] != ''){
	add_action('admin_head', 'messaging_header_js');
}
if($_GET['action'] == 'reply_process' && $_POST['message_to'] != ''){
	add_action('admin_head', 'messaging_header_js');
}
add_action('admin_menu', 'messaging_plug_pages');
add_action('wpabar_menuitems', 'messaging_admin_bar');
if ($_GET['action'] == 'view' && $_GET['mid'] != ''){
	messaging_update_message_status($_GET['mid'],'read');
}
if ($_GET['action'] == 'reply' && $_GET['mid'] != ''){
	add_action('admin_footer', 'messaging_set_focus_js');
}
if ($_GET['action'] == 'reply_process'){
	add_action('admin_footer', 'messaging_set_focus_js');
}
//------------------------------------------------------------------------//
//---Functions------------------------------------------------------------//
//------------------------------------------------------------------------//
function messaging_make_current() {
	global $wpdb, $messaging_current_version;
	if (get_site_option( "messaging_version" ) == '') {
		add_site_option( 'messaging_version', '0.0.0' );
	}
	
	if (get_site_option( "messaging_version" ) == $messaging_current_version) {
		// do nothing
	} else {
		//up to current version
		update_site_option( "messaging_installed", "no" );
		update_site_option( "messaging_version", $messaging_current_version );
	}
	messaging_global_install();
	//--------------------------------------------------//
	if (get_option( "messaging_version" ) == '') {
		add_option( 'messaging_version', '0.0.0' );
	}
	
	if (get_option( "messaging_version" ) == $messaging_current_version) {
		// do nothing
	} else {
		//up to current version
		update_option( "messaging_version", $messaging_current_version );
		messaging_blog_install();
	}
}

function messaging_blog_install() {
	global $wpdb, $messaging_current_version;
	//$messaging_table1 = "";
	//$wpdb->query( $messaging_table1 );
}

function messaging_global_install() {
	global $wpdb, $messaging_current_version;
	if (get_site_option( "messaging_installed" ) == '') {
		add_site_option( 'messaging_installed', 'no' );
	}
	
	if (get_site_option( "messaging_installed" ) == "yes") {
		// do nothing
	} else {
	
		$messaging_table1 = "CREATE TABLE `" . $wpdb->base_prefix . "messages` (
  `message_ID` bigint(20) unsigned NOT NULL auto_increment,
  `message_from_user_ID` bigint(20) NOT NULL,
  `message_to_user_ID` bigint(20) NOT NULL,
  `message_to_all_user_IDs` TEXT NOT NULL,
  `message_subject` TEXT NOT NULL,
  `message_content` TEXT NOT NULL,
  `message_status` VARCHAR(255) NOT NULL,
  `message_stamp`  VARCHAR(255) NOT NULL,
  `message_official` tinyint(0) NOT NULL default '0',
  PRIMARY KEY  (`message_ID`)
) ENGINE=MyISAM;";
		$messaging_table2 = "CREATE TABLE `" . $wpdb->base_prefix . "sent_messages` (
  `sent_message_ID` bigint(20) unsigned NOT NULL auto_increment,
  `sent_message_from_user_ID` bigint(20) NOT NULL,
  `sent_message_to_user_IDs` TEXT NOT NULL,
  `sent_message_subject` TEXT NOT NULL,
  `sent_message_content` TEXT NOT NULL,
  `sent_message_stamp`  VARCHAR(255) NOT NULL,
  `sent_message_official` tinyint(0) NOT NULL default '0',
  PRIMARY KEY  (`sent_message_ID`)
) ENGINE=MyISAM;";
		$messaging_table3 = "";
		$messaging_table4 = "";
		$messaging_table5 = "";

		$wpdb->query( $messaging_table1 );
		$wpdb->query( $messaging_table2 );
		//$wpdb->query( $messaging_table3 );
		//$wpdb->query( $messaging_table4 );
		//$wpdb->query( $messaging_table5 );
		update_site_option( "messaging_installed", "yes" );
	}
}

function messaging_plug_pages() {
	global $wpdb, $user_ID;
	//$tmp_unread_message_count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "messages WHERE message_to_user_ID = '" . $user_ID . "' AND message_status = 'unread'");
	//if ($tmp_unread_message_count > 0){
		//add_menu_page('Inbox', 'Inbox (' . $tmp_unread_message_count . ')', 0, 'inbox.php');
	//} else {
		add_menu_page('Inbox', 'Inbox', 0, 'inbox.php');
	//}
	//add_submenu_page('inbox.php', 'Inbox', 'Inbox', '0', 'messaging_inbox', 'messaging_inbox_page_output' );
	add_submenu_page('inbox.php', 'Inbox', 'New Message', '0', 'new', 'messaging_new_page_output' );
	add_submenu_page('inbox.php', 'Inbox', 'Sent Messages', '0', 'sent', 'messaging_sent_page_output' );
	//add_submenu_page('inbox.php', 'Inbox', 'Export', '0', 'export', 'messaging_export_page_output' );
	add_submenu_page('inbox.php', 'Inbox', 'Notifications', '0', 'message-notifications', 'messaging_notifications_page_output' );
}

function messaging_admin_bar( $menu ) {
	unset( $menu['inbox.php'] );
	return $menu;
}

function messaging_insert_message($tmp_to_uid,$tmp_to_all_uids,$tmp_from_uid,$tmp_subject,$tmp_content,$tmp_status,$tmp_official = 0) {
	global $wpdb;
	$wpdb->query( "INSERT INTO " . $wpdb->base_prefix . "messages (message_from_user_ID,message_to_user_ID,message_to_all_user_IDs,message_subject,message_content,message_status,message_stamp,message_official) VALUES ( '" . $tmp_from_uid . "','" . $tmp_to_uid . "','" . $tmp_to_all_uids . "','" . addslashes($tmp_subject) . "','" . addslashes($tmp_content) . "','" . $tmp_status . "','" . time() . "','" . $tmp_official . "' )" );
}

function messaging_update_message_status($tmp_mid,$tmp_status) {
	global $wpdb;
	$wpdb->query( "UPDATE " . $wpdb->base_prefix . "messages SET message_status = '" . $tmp_status . "' WHERE message_ID = '" . $tmp_mid . "' " );
}

function messaging_remove_message($tmp_mid) {
	global $wpdb;
	$wpdb->query( "DELETE FROM " . $wpdb->base_prefix . "messages WHERE message_ID = '" . $tmp_mid . "' " );
}

function messaging_insert_sent_message($tmp_to_all_uids,$tmp_from_uid,$tmp_subject,$tmp_content,$tmp_official = 0) {
	global $wpdb;
	$wpdb->query( "INSERT INTO " . $wpdb->base_prefix . "sent_messages (sent_message_from_user_ID,sent_message_to_user_IDs,sent_message_subject,sent_message_content,sent_message_stamp,sent_message_official) VALUES ( '" . $tmp_from_uid . "','" . $tmp_to_all_uids . "','" . addslashes($tmp_subject) . "','" . addslashes($tmp_content) . "','" . time() . "','" . $tmp_official . "' )" );
}

function messaging_remove_sent_message($tmp_mid) {
	global $wpdb;
	$wpdb->query( "DELETE FROM " . $wpdb->base_prefix . "sent_messages WHERE sent_message_ID = '" . $tmp_mid . "' " );
}

function messaging_new_message_notification($tmp_to_uid,$tmp_from_uid,$tmp_subject,$tmp_content) {
	global $wpdb, $current_site, $user_ID, $messaging_email_notification_subject, $messaging_email_notification_content;
	if (get_usermeta($tmp_to_uid,'message_email_notification') != 'no'){
		$tmp_to_username =  $wpdb->get_var("SELECT user_login FROM " . $wpdb->users . " WHERE ID = '" . $tmp_to_uid . "'");
		$tmp_to_email =  $wpdb->get_var("SELECT user_email FROM " . $wpdb->users . " WHERE ID = '" . $tmp_to_uid . "'");
		$tmp_from_username =  $wpdb->get_var("SELECT user_login FROM " . $wpdb->users . " WHERE ID = '" . $tmp_from_uid . "'");
		
		$message_content = $messaging_email_notification_content;
		$message_content = str_replace( "SITE_NAME", $current_site->site_name, $message_content );
		$message_content = str_replace( "SITE_URL", 'http://' . $current_site->domain . '', $message_content );

		$message_content = str_replace( "TO_USER", $tmp_to_username, $message_content );
		$message_content = str_replace( "FROM_USER", $tmp_from_username, $message_content );
		$message_content = str_replace( "\'", "'", $message_content );
		
		$subject_content = $messaging_email_notification_subject;
		$subject_content = str_replace( "SITE_NAME", $current_site->site_name, $subject_content );
		
		$admin_email = get_site_option('admin_email');
		if ($admin_email == ''){
			$admin_email = 'admin@' . $current_site->domain;
		}
		$from_email = $admin_email;
		
		$message_headers = "MIME-Version: 1.0\n" . "From: " . $current_site->site_name .  " <{$from_email}>\n" . "Content-Type: text/plain; charset=\"" . get_option('blog_charset') . "\"\n";
		wp_mail($tmp_to_email, $subject_content, $message_content, $message_headers);
	}
}

//------------------------------------------------------------------------//
//---Output Functions-----------------------------------------------------//
//------------------------------------------------------------------------//

function messaging_set_focus_js(){
	?>
	<SCRIPT LANGUAGE='JavaScript'>
		setTimeout("tinyMCE.execCommand('mceFocus', false, 'message_content');window.blur();window.focus();tinyMCE.execCommand('mceFocus', false, 'message_content');", 0);
	</SCRIPT>
	<?php
}

function messaging_header_js(){
	global $current_site;
	$valid_elements = 'p/-div[*],-strong/-b[*],-em/-i[*],-font[*],-ul[*],-ol[*],-li[*],*[*]';
	$valid_elements = apply_filters('mce_valid_elements', $valid_elements);
	$mce_buttons = apply_filters('mce_buttons', array('bold', 'italic', 'strikethrough', 'separator', 'bullist', 'numlist', 'outdent', 'indent', 'separator', 'justifyleft', 'justifycenter', 'justifyright', 'separator', 'link', 'unlink', 'image', 'wp_more', 'separator', 'spellchecker', 'separator', 'wp_help', 'wp_adv', 'wp_adv_start', 'formatselect', 'underline', 'justifyfull', 'forecolor', 'separator', 'pastetext', 'pasteword', 'separator', 'removeformat', 'cleanup', 'separator', 'charmap', 'separator', 'undo', 'redo', 'wp_adv_end'));
	$mce_buttons = implode($mce_buttons, ',');

	$mce_buttons_2 = apply_filters('mce_buttons_2', array());
	$mce_buttons_2 = implode($mce_buttons_2, ',');

	$mce_buttons_3 = apply_filters('mce_buttons_3', array());
	$mce_buttons_3 = implode($mce_buttons_3, ',');

	$mce_browsers = apply_filters('mce_browsers', array('msie', 'gecko', 'opera', 'safari'));
	$mce_browsers = implode($mce_browsers, ',');

	$mce_popups_css = get_option('siteurl') . '/wp-includes/js/tinymce/plugins/wordpress/popups.css';
	$mce_css = get_option('siteurl') . '/wp-includes/js/tinymce/plugins/wordpress/wordpress.css';
	$mce_css = apply_filters('mce_css', $mce_css);
	if ( $_SERVER['HTTPS'] == 'on' ) {
		$mce_css = str_replace('http://', 'https://', $mce_css);
		$mce_popups_css = str_replace('http://', 'https://', $mce_popups_css);
	}

	$mce_locale = ( '' == get_locale() ) ? 'en' : strtolower(get_locale());
	?>
<script type='text/javascript' src='http://<?php echo $current_site->domain . $current_site->path; ?>wp-includes/js/tinymce/tiny_mce.js?ver=20070528'></script>
<script language="javascript" type="text/javascript">
tinyMCE.init({
	mode : "specific_textareas",
	editor_selector : "mceEditor",
	width : "10%",
	theme : "advanced",
	theme_advanced_buttons1 : "<?php echo $mce_buttons; ?>",
	theme_advanced_buttons2 : "<?php echo $mce_buttons_2; ?>",
	theme_advanced_buttons3 : "<?php echo $mce_buttons_3; ?>",
	language : "<?php echo $mce_locale; ?>",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_path_location : "bottom",
	theme_advanced_resizing : true,
	browsers : "<?php echo $mce_browsers; ?>",
	dialog_type : "modal",
	theme_advanced_resize_horizontal : false,
	convert_urls : false,
	relative_urls : false,
	remove_script_host : false,
	force_p_newlines : true,
	force_br_newlines : false,
	convert_newlines_to_brs : false,
	remove_linebreaks : false,
	fix_list_elements : true,
	gecko_spellcheck : true,
	entities : "38,amp,60,lt,62,gt",
	button_tile_map : true,
	content_css : "<?php echo $mce_css; ?>",
	valid_elements : "<?php echo $valid_elements; ?>"
});
</script>
	<?php
}

//------------------------------------------------------------------------//
//---Page Output Functions------------------------------------------------//
//------------------------------------------------------------------------//

function messaging_inbox_page_output() {
	global $wpdb, $wp_roles, $current_user, $user_ID, $current_site, $messaging_official_message_bg_color, $messaging_max_inbox_messages, $messaging_max_reached_message;

	if (isset($_GET['updated'])) {
		?><div id="message" class="updated fade"><p><?php _e('' . urldecode($_GET['updatedmsg']) . '') ?></p></div><?php
	}
	echo '<div class="wrap">';
	switch( $_GET[ 'action' ] ) {
		//---------------------------------------------------//
		default:
			if ( isset($_POST['Remove']) ) {
				messaging_update_message_status($_POST['mid'],'removed');
				echo "
				<SCRIPT LANGUAGE='JavaScript'>
				window.location='inbox.php?updated=true&updatedmsg=" . urlencode('Message removed.') . "';
				</script>
				";
			}
			if ( isset($_POST['Reply']) ) {
				echo "
				<SCRIPT LANGUAGE='JavaScript'>
				window.location='inbox.php?action=reply&mid=" . $_POST['mid'] . "';
				</script>
				";
			}
			$tmp_message_count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "messages WHERE message_to_user_ID = '" . $user_ID . "'");
			$tmp_unread_message_count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "messages WHERE message_to_user_ID = '" . $user_ID . "' AND message_status = 'unread'");
			$tmp_read_message_count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "messages WHERE message_to_user_ID = '" . $user_ID . "' AND message_status = 'read'");
			?>
            <h2><?php _e('Inbox') ?> (<a href="inbox.php?page=new"><?php _e('New Message') ?></a>)</h2>
            <?php
			if ($tmp_message_count == 0){
			?>
            <p><?php _e('No messages to display') ?></p>
            <?php
			} else {
				?>
				<h3><?php _e('Usage') ?></h3>
                <p>
				<?php _e('Maximum inbox messages') ?>: <strong><?php echo $messaging_max_inbox_messages; ?></strong>
                <br />
                <?php _e('Current inbox messages') ?>: <strong><?php echo $tmp_message_count ?></strong>
                </p>
                <?php
				if ($tmp_message_count >= $messaging_max_inbox_messages){
				?>
                <p><strong><center><?php _e($messaging_max_reached_message) ?></center></strong></p>
				<?php
				}
				if ($tmp_unread_message_count > 0){
				?>
				<h3><?php _e('Unread') ?></h3>
				<?php
				$query = "SELECT * FROM " . $wpdb->base_prefix . "messages WHERE message_to_user_ID = '" . $user_ID . "' AND message_status = 'unread' ORDER BY message_ID DESC";
				$tmp_messages = $wpdb->get_results( $query, ARRAY_A );
				echo "
				<table cellpadding='3' cellspacing='3' width='100%' class='widefat'> 
				<thead><tr>
				<th scope='col'>" . __("From") . "</th>
				<th scope='col'>" . __("Subject") . "</th>
				<th scope='col'>" . __("Recieved") . "</th>
				<th scope='col'>" . __("Actions") . "</th>
				<th scope='col'></th>
				<th scope='col'></th>
				</tr></thead>
				<tbody id='the-list'>
				";
				if (count($tmp_messages) > 0){
					$class = ('alternate' == $class) ? '' : 'alternate';
					foreach ($tmp_messages as $tmp_message){
					if ($tmp_message['message_official'] == 1){
						$style = "'style=background-color:" . $messaging_official_message_bg_color . ";'";
					} else {
						$style = "";
					}
					//=========================================================//
					echo "<tr class='" . $class . "' " . $style . ">";
					if ($tmp_message['message_official'] == 1){
						$tmp_username = $wpdb->get_var("SELECT user_login FROM " . $wpdb->users . " WHERE ID = '" . $tmp_message['message_from_user_ID'] . "'");
						$tmp_display_name = $wpdb->get_var("SELECT display_name FROM " . $wpdb->users . " WHERE ID = '" . $tmp_message['message_from_user_ID'] . "'");
						if ( $tmp_display_name == '' ) {
							$tmp_display_name = $tmp_username;
						}
						$tmp_user_url = messaging_user_primary_blog_url($tmp_message['message_from_user_ID']);
						if ($tmp_user_url == ''){
							echo "<td valign='top'><strong>" . $tmp_display_name . "</strong></td>";
						} else {
							echo "<td valign='top'><strong><a href='" . $tmp_user_url . "'>" . $tmp_display_name . "</a></strong></td>";
						}
						echo "<td valign='top'><strong>" . stripslashes($tmp_message['message_subject']) . "</strong></td>";
						echo "<td valign='top'><strong>" . date(get_option('date_format') . ' ' . get_option('time_format'),$tmp_message['message_stamp']) . "</strong></td>";
					} else {
						$tmp_username = $wpdb->get_var("SELECT user_login FROM " . $wpdb->users . " WHERE ID = '" . $tmp_message['message_from_user_ID'] . "'");
						$tmp_display_name = $wpdb->get_var("SELECT display_name FROM " . $wpdb->users . " WHERE ID = '" . $tmp_message['message_from_user_ID'] . "'");
						if ( $tmp_display_name == '' ) {
							$tmp_display_name = $tmp_username;
						}
						$tmp_user_url = messaging_user_primary_blog_url($tmp_message['message_from_user_ID']);
						if ($tmp_user_url == ''){
							echo "<td valign='top'>" . $tmp_display_name . "</td>";
						} else {
							echo "<td valign='top'><a href='" . $tmp_user_url . "'>" . $tmp_display_name . "</a></td>";					
						}
						echo "<td valign='top'>" . stripslashes($tmp_message['message_subject']) . "</td>";
						echo "<td valign='top'>" . date(get_option('date_format') . ' ' . get_option('time_format'),$tmp_message['message_stamp']) . "</td>";
					}
					if ($tmp_message_count >= $messaging_max_inbox_messages){
						echo "<td valign='top'><a class='edit'>" . __('View') . "</a></td>";
						echo "<td valign='top'><a class='edit'>" . __('Reply') . "</a></td>";
					} else {
						echo "<td valign='top'><a href='inbox.php?action=view&mid=" . $tmp_message['message_ID'] . "' rel='permalink' class='edit'>" . __('View') . "</a></td>";
						echo "<td valign='top'><a href='inbox.php?action=reply&mid=" . $tmp_message['message_ID'] . "' rel='permalink' class='edit'>" . __('Reply') . "</a></td>";
					}
					echo "<td valign='top'><a href='inbox.php?action=remove&mid=" . $tmp_message['message_ID'] . "' rel='permalink' class='delete'>" . __('Remove') . "</a></td>";
					echo "</tr>";
					$class = ('alternate' == $class) ? '' : 'alternate';
					//=========================================================//
					}
				}
				?>
				</tbody></table>
				<?php
				}
				//=========================================================//
				if ($tmp_read_message_count > 0){
				?>
				<h3><?php _e('Read') ?></h3>
				<?php
				$query = "SELECT * FROM " . $wpdb->base_prefix . "messages WHERE message_to_user_ID = '" . $user_ID . "' AND message_status = 'read' ORDER BY message_ID DESC";
				$tmp_messages = $wpdb->get_results( $query, ARRAY_A );
				echo "
				<table cellpadding='3' cellspacing='3' width='100%' class='widefat'> 
				<thead><tr>
				<th scope='col'>" . __("From") . "</th>
				<th scope='col'>" . __("Subject") . "</th>
				<th scope='col'>" . __("Recieved") . "</th>
				<th scope='col'>" . __("Actions") . "</th>
				<th scope='col'></th>
				<th scope='col'></th>
				</tr></thead>
				<tbody id='the-list'>
				";
				if (count($tmp_messages) > 0){
					$class = ('alternate' == $class) ? '' : 'alternate';
					foreach ($tmp_messages as $tmp_message){
					if ($tmp_message['message_official'] == 1){
						$style = "'style=background-color:" . $messaging_official_message_bg_color . ";'";
					} else {
						$style = "";
					}
					//=========================================================//
					echo "<tr class='" . $class . "' " . $style . ">";
					if ($tmp_message['message_official'] == 1){
						$tmp_username = $wpdb->get_var("SELECT user_login FROM " . $wpdb->users . " WHERE ID = '" . $tmp_message['message_from_user_ID'] . "'");
						$tmp_display_name = $wpdb->get_var("SELECT user_login FROM " . $wpdb->users . " WHERE ID = '" . $tmp_message['message_from_user_ID'] . "'");
						if ( $tmp_display_name == '' ) {
							$tmp_display_name = $tmp_username;
						}
						$tmp_user_url = messaging_user_primary_blog_url($tmp_message['message_to_user_ID']);
						if ($tmp_user_url == ''){
							echo "<td valign='top'><strong>" . $tmp_display_name . "</strong></td>";
						} else {
							echo "<td valign='top'><strong><a href='" . $tmp_user_url . "'>" . $tmp_display_name . "</a></strong></td>";					
						}
						echo "<td valign='top'><strong>" . stripslashes($tmp_message['message_subject']) . "</strong></td>";
						echo "<td valign='top'><strong>" . date(get_option('date_format') . ' ' . get_option('time_format'),$tmp_message['message_stamp']) . "</strong></td>";
					} else {
						$tmp_username = $wpdb->get_var("SELECT user_login FROM " . $wpdb->users . " WHERE ID = '" . $tmp_message['message_from_user_ID'] . "'");
						$tmp_display_name = $wpdb->get_var("SELECT display_name FROM " . $wpdb->users . " WHERE ID = '" . $tmp_message['message_from_user_ID'] . "'");
						if ( $tmp_display_name == '' ) {
							$tmp_display_name = $tmp_username;
						}
						$tmp_user_url = messaging_user_primary_blog_url($tmp_message['message_to_user_ID']);
						if ($tmp_user_url == ''){
							echo "<td valign='top'>" . $tmp_display_name . "</td>";
						} else {
							echo "<td valign='top'><a href='" . $tmp_user_url . "'>" . $tmp_display_name . "</a></td>";					
						}
						echo "<td valign='top'>" . stripslashes($tmp_message['message_subject']) . "</td>";
						echo "<td valign='top'>" . date(get_option('date_format') . ' ' . get_option('time_format'),$tmp_message['message_stamp']) . "</td>";
					}
					if ($tmp_message_count >= $messaging_max_inbox_messages){
						echo "<td valign='top'><a class='edit'>" . __('View') . "</a></td>";
						echo "<td valign='top'><a class='edit'>" . __('Reply') . "</a></td>";
					} else {
						echo "<td valign='top'><a href='inbox.php?action=view&mid=" . $tmp_message['message_ID'] . "' rel='permalink' class='edit'>" . __('View') . "</a></td>";
						echo "<td valign='top'><a href='inbox.php?action=reply&mid=" . $tmp_message['message_ID'] . "' rel='permalink' class='edit'>" . __('Reply') . "</a></td>";
					}
					echo "<td valign='top'><a href='inbox.php?action=remove&mid=" . $tmp_message['message_ID'] . "' rel='permalink' class='delete'>" . __('Remove') . "</a></td>";
					echo "</tr>";
					$class = ('alternate' == $class) ? '' : 'alternate';
					//=========================================================//
					}
				}
				?>
				</tbody></table>
				<?php
				}
			}
		break;
		//---------------------------------------------------//
		case "view":
			$tmp_total_message_count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "messages WHERE message_to_user_ID = '" . $user_ID . "'");
			$tmp_message_count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "messages WHERE message_ID = '" . $_GET['mid'] . "' AND message_to_user_ID = '" . $user_ID . "'");
			if ($tmp_message_count > 0){
				if ($tmp_total_message_count >= $messaging_max_inbox_messages){
					?>
					<p><strong><center><?php _e($messaging_max_reached_message) ?></center></strong></p>
					<?php
					} else {
					messaging_update_message_status($_GET['mid'],'read');
					$tmp_message_subject = stripslashes($wpdb->get_var("SELECT message_subject FROM " . $wpdb->base_prefix . "messages WHERE message_ID = '" . $_GET['mid'] . "'"));
					$tmp_message_content = stripslashes($wpdb->get_var("SELECT message_content FROM " . $wpdb->base_prefix . "messages WHERE message_ID = '" . $_GET['mid'] . "'"));
					$tmp_message_from_user_ID = $wpdb->get_var("SELECT message_from_user_ID FROM " . $wpdb->base_prefix . "messages WHERE message_ID = '" . $_GET['mid'] . "'");
					$tmp_username = $wpdb->get_var("SELECT user_login FROM " . $wpdb->users . " WHERE ID = '" . $tmp_message_from_user_ID . "'");
					$tmp_message_status = $wpdb->get_var("SELECT message_status FROM " . $wpdb->base_prefix . "messages WHERE message_ID = '" . $_GET['mid'] . "'");
					$tmp_message_status = ucfirst($tmp_message_status);
					$tmp_message_status = __($tmp_message_status);
					$tmp_message_stamp = $wpdb->get_var("SELECT message_stamp FROM " . $wpdb->base_prefix . "messages WHERE message_ID = '" . $_GET['mid'] . "'");
					?>
		
					<h2><?php _e('View Message: ') ?><?php echo $_GET['mid']; ?></h2>
					<form name="new_message" method="POST" action="inbox.php">
					<input type="hidden" name="mid" value="<?php echo $_GET['mid']; ?>" />
					<h3><?php _e('Sent') ?></h3>
					<p><?php echo date(get_option('date_format') . ' ' . get_option('time_format'),$tmp_message_stamp); ?></p>
					<h3><?php _e('Status') ?></h3>
					<p><?php echo $tmp_message_status; ?></p>
					<h3><?php _e('From') ?></h3>
					<p><?php echo $tmp_username; ?></p>
					<h3><?php _e('Subject') ?></h3>
					<p><?php echo $tmp_message_subject; ?></p>
					<h3><?php _e('Content') ?></h3>
					<p><?php echo $tmp_message_content; ?></p>
                    <p class="submit">
					<input type="submit" name="Submit" value="<?php _e('Back') ?>" />
					<input type="submit" name="Remove" value="<?php _e('Remove') ?>" /> 
					<input type="submit" name="Reply" value="<?php _e('Reply') ?>" /> 
                    </p>
					</form>
					<?php
				}		
			} else {
			?>
            <p><?php _e('You do not have permission to view this message') ?></p>
            <?php
			}
		break;
		//---------------------------------------------------//
		case "remove":
			//messaging_update_message_status($_GET['mid'],'removed');
			messaging_remove_message($_GET['mid']);
			echo "
			<SCRIPT LANGUAGE='JavaScript'>
			window.location='inbox.php?updated=true&updatedmsg=" . urlencode('Message removed.') . "';
			</script>
			";
		break;
		//---------------------------------------------------//
		case "reply":
			$tmp_message_count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "messages WHERE message_ID = '" . $_GET['mid'] . "' AND message_to_user_ID = '" . $user_ID . "'");
			if ($tmp_message_count > 0){
			$tmp_message_from_user_ID = $wpdb->get_var("SELECT message_from_user_ID FROM " . $wpdb->base_prefix . "messages WHERE message_ID = '" . $_GET['mid'] . "'");
			$tmp_username = $wpdb->get_var("SELECT user_login FROM " . $wpdb->users . " WHERE ID = '" . $tmp_message_from_user_ID . "'");
			$tmp_message_subject = stripslashes($wpdb->get_var("SELECT message_subject FROM " . $wpdb->base_prefix . "messages WHERE message_ID = '" . $_GET['mid'] . "'"));
			$tmp_message_subject = __('RE: ') . $tmp_message_subject;
			$tmp_message_content = stripslashes($wpdb->get_var("SELECT message_content FROM " . $wpdb->base_prefix . "messages WHERE message_ID = '" . $_GET['mid'] . "'"));
			//$tmp_message_content = "\n\n" . $tmp_username . __(' wrote:') . '<hr>' . $tmp_message_content;

			$rows = get_option('default_post_edit_rows');
            if (($rows < 3) || ($rows > 100)){
                $rows = 12;
			}
            $rows = "rows='$rows'";

            if ( user_can_richedit() ){
                add_filter('the_editor_content', 'wp_richedit_pre');
			}
			//	$the_editor_content = apply_filters('the_editor_content', $content);
            ?>
			<h2><?php _e('Send Reply') ?></h2>
			<form name="reply_to_message" method="POST" action="inbox.php?action=reply_process">
            <input type="hidden" name="message_to" value="<?php echo $tmp_username; ?>" />
            <input type="hidden" name="message_subject" value="<?php echo $tmp_message_subject; ?>" />
                <table class="form-table">
                <tr valign="top">
                <th scope="row"><?php _e('To') ?></th>
                <td><input disabled="disabled" type="text" name="message_to" id="message_to_disabled" style="width: 95%" maxlength="200" value="<?php echo $tmp_username; ?>" />
                <br />
                <?php //_e('Required - seperate multiple usernames by commas Ex: demouser1,demouser2') ?></td> 
                </tr>
                <tr valign="top">
                <th scope="row"><?php _e('Subject') ?></th>
                <td><input disabled="disabled" type="text" name="message_subject" id="message_subject_disabled" style="width: 95%" maxlength="200" value="<?php echo $tmp_message_subject; ?>" />
                <br />
                <?php //_e('Required') ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php echo $tmp_username . __(' wrote'); ?></th> 
                <td><?php echo $tmp_message_content; ?>
                <br />
                <?php _e('Required') ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Content') ?></th> 
                <td><textarea <?php if ( user_can_richedit() ){ echo "class='mceEditor'"; } ?> <?php echo $rows; ?> style="width: 95%" name='message_content' tabindex='1' id='message_content'><?php //echo $tmp_message_content; ?></textarea>
                <br />
                <?php _e('Required') ?></td> 
                </tr>
                </table>
            <p class="submit">
            <input type="submit" name="Submit" value="<?php _e('Send') ?>" />
            </p>
            </form>
            <?php
			} else {
			?>
            <p><?php _e('You do not have permission to view this message') ?></p>
            <?php
			}
		break;
		//---------------------------------------------------//
		case "reply_process":
			if ($_POST['message_to'] == '' || $_POST['message_subject'] == '' || $_POST['message_content'] == ''){
				$rows = get_option('default_post_edit_rows');
				if (($rows < 3) || ($rows > 100)){
					$rows = 12;
				}
				$rows = "rows='$rows'";
	
				if ( user_can_richedit() ){
					add_filter('the_editor_content', 'wp_richedit_pre');
				}
				//	$the_editor_content = apply_filters('the_editor_content', $content);
				?>
				<h2><?php _e('Send Reply') ?></h2>
                <p><?php _e('Please fill in all required fields') ?></p>
				<form name="reply_to_message" method="POST" action="inbox.php?action=reply_process">
                <input type="hidden" name="message_to" value="<?php echo $_POST['message_to']; ?>" />
                <input type="hidden" name="message_subject" value="<?php echo $_POST['message_subject']; ?>" />
					<table class="form-table">
					<tr valign="top">
					<th scope="row"><?php _e('To') ?></th>
					<td><input disabled="disabled" type="text" name="message_to" id="message_to_disabled" style="width: 95%" maxlength="200" value="<?php echo $_POST['message_to']; ?>" />
					<br />
					<?php //_e('Required - seperate multiple usernames by commas Ex: demouser1,demouser2') ?></td> 
					</tr>
					<tr valign="top">
					<th scope="row"><?php _e('Subject') ?></th>
					<td><input disabled="disabled" type="text" name="message_subject" id="message_subject_disabled" style="width: 95%" maxlength="200" value="<?php echo $_POST['message_subject']; ?>" />
					<br />
					<?php //_e('Required') ?></td> 
					</tr>
					<tr valign="top"> 
					<th scope="row"><?php _e('Content') ?></th> 
					<td><textarea <?php if ( user_can_richedit() ){ echo "class='mceEditor'"; } ?> <?php echo $rows; ?> style="width: 95%" name='message_content' tabindex='1' id='message_content'><?php echo $_POST['message_content']; ?></textarea>
					<br />
					<?php _e('Required') ?></td> 
					</tr>
					</table>
                <p class="submit">
                <input type="submit" name="Submit" value="<?php _e('Send') ?>" />
                </p>
				</form>
				<?php
			} else {
				//==========================================================//
				$tmp_usernames = $_POST['message_to'];
				$tmp_usernames = str_replace( ",", ', ', $tmp_usernames );
				$tmp_usernames = ',,' . $tmp_usernames . ',,';
				$tmp_usernames = str_replace( " ", '', $tmp_usernames );
				$tmp_usernames_array = explode(",", $tmp_usernames);
				$tmp_usernames_array = array_unique($tmp_usernames_array);
				
				$tmp_username_error = 0;
				$tmp_error_usernames = '';
				$tmp_to_all_uids = '|';
				foreach ($tmp_usernames_array as $tmp_username){
					if ($tmp_username != ''){
						$tmp_username_count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->users . " WHERE user_login = '" . $tmp_username . "'");
						if ($tmp_username_count > 0){
							$tmp_user_id = $wpdb->get_var("SELECT ID FROM " . $wpdb->users . " WHERE user_login = '" . $tmp_username . "'");
							$tmp_to_all_uids = $tmp_to_all_uids . $tmp_uid . '|';
							//found
						} else {
							$tmp_username_error = $tmp_username_error + 1;
							$tmp_error_usernames = $tmp_error_usernames . $tmp_username . ', ';
						}
					}
				}
				$tmp_error_usernames = trim($tmp_error_usernames, ", ");
				//==========================================================//
				if ($tmp_username_error > 0){
					$rows = get_option('default_post_edit_rows');
					if (($rows < 3) || ($rows > 100)){
						$rows = 12;
					}
					$rows = "rows='$rows'";
					?>
					<h2><?php _e('Send Reply') ?></h2>
					<p><?php _e('The following usernames could not be found in the system') ?> <em><?php echo $tmp_error_usernames; ?></em></p>
                    <form name="new_message" method="POST" action="inbox.php?action=reply_process">
                    <input type="hidden" name="message_to" value="<?php echo $_POST['message_to']; ?>" />
                    <input type="hidden" name="message_subject" value="<?php echo $_POST['message_subject']; ?>" />
                        <table class="form-table">
                        <tr valign="top">
                        <th scope="row"><?php _e('To') ?></th>
                        <td><input disabled="disabled" type="text" name="message_to" id="message_to_disabled" style="width: 95%" tabindex='1' maxlength="200" value="<?php echo $_POST['message_to']; ?>" />
                        <br />
                        <?php //_e('Required - seperate multiple usernames by commas Ex: demouser1,demouser2') ?></td> 
                        </tr>
                        <tr valign="top">
                        <th scope="row"><?php _e('Subject') ?></th>
                        <td><input disabled="disabled" type="text" name="message_subject" id="message_subject_disabled" style="width: 95%" tabindex='2' maxlength="200" value="<?php echo $_POST['message_subject']; ?>" />
                        <br />
                        <?php //_e('Required') ?></td> 
                        </tr>
                        <tr valign="top"> 
                        <th scope="row"><?php _e('Content') ?></th> 
                        <td><textarea <?php if ( user_can_richedit() ){ echo "class='mceEditor'"; } ?> <?php echo $rows; ?> style="width: 95%" name='message_content' tabindex='3' id='message_content'><?php echo $_POST['message_content']; ?></textarea>
                        <br />
                        <?php _e('Required') ?></td> 
                        </tr>
                        </table>
                    <p class="submit">
                    <input type="submit" name="Submit" value="<?php _e('Send') ?>" />
                    </p>
                    </form>
                    <?php

				} else {
					//everything checked out - send the messages
					?>
					<p><?php _e('Sending message(s)...') ?></p>
                    <?php
					foreach ($tmp_usernames_array as $tmp_username){
						if ($tmp_username != ''){
							$tmp_to_uid = $wpdb->get_var("SELECT ID FROM " . $wpdb->users . " WHERE user_login = '" . $tmp_username . "'");
							messaging_insert_message($tmp_to_uid,$tmp_to_all_uids,$user_ID,$_POST['message_subject'],$_POST['message_content'],'unread',0);
							messaging_new_message_notification($tmp_to_uid,$user_ID,$_POST['message_subject'],$_POST['message_content']);
						}
					}
					messaging_insert_sent_message($tmp_to_all_uids,$user_ID,$_POST['message_subject'],$_POST['message_content'],0);
					echo "
					<SCRIPT LANGUAGE='JavaScript'>
					window.location='inbox.php?updated=true&updatedmsg=" . urlencode('Reply Sent.') . "';
					</script>
					";
				}
			}
		break;
		//---------------------------------------------------//
		case "test":
		break;
		//---------------------------------------------------//
	}
	echo '</div>';
}

function messaging_new_page_output() {
	global $wpdb, $wp_roles, $current_user, $user_ID, $current_site, $messaging_max_inbox_messages, $messaging_max_reached_message;

	if (isset($_GET['updated'])) {
		?><div id="message" class="updated fade"><p><?php _e('' . urldecode($_GET['updatedmsg']) . '') ?></p></div><?php
	}
	echo '<div class="wrap">';
	switch( $_GET[ 'action' ] ) {
		//---------------------------------------------------//
		default:
			$tmp_total_message_count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "messages WHERE message_to_user_ID = '" . $user_ID . "'");
			if ($tmp_total_message_count >= $messaging_max_inbox_messages){
				?>
				<p><strong><center><?php _e($messaging_max_reached_message) ?></center></strong></p>
				<?php
			} else {
				$rows = get_option('default_post_edit_rows');
				if (($rows < 3) || ($rows > 100)){
					$rows = 12;
				}
				$rows = "rows='$rows'";
	
				if ( user_can_richedit() ){
					add_filter('the_editor_content', 'wp_richedit_pre');
				}
				//	$the_editor_content = apply_filters('the_editor_content', $content);
				?>
				<h2><?php _e('New Message') ?></h2>
				<form name="new_message" method="POST" action="inbox.php?page=new&action=process">
					<table class="form-table">
					<tr valign="top">
					<th scope="row"><?php _e('To (usernames)') ?></th>
                    <?php
					$message_to = $_POST['message_to'];
					if ( empty( $message_to ) ) {
						$message_to = $_GET['message_to'];
					}
					?>
					<td><input type="text" name="message_to" id="message_to" style="width: 95%" tabindex='1' maxlength="200" value="<?php echo $message_to; ?>" />
					<br />
					<?php _e('Required - seperate multiple usernames by commas Ex: demouser1,demouser2') ?></td> 
					</tr>
					<tr valign="top">
					<th scope="row"><?php _e('Subject') ?></th>
					<td><input type="text" name="message_subject" id="message_subject" style="width: 95%" tabindex='2' maxlength="200" value="<?php echo $_POST['message_subject']; ?>" />
					<br />
					<?php _e('Required') ?></td> 
					</tr>
					<tr valign="top"> 
					<th scope="row"><?php _e('Content') ?></th> 
					<td><textarea <?php if ( user_can_richedit() ){ echo "class='mceEditor'"; } ?> <?php echo $rows; ?> style="width: 95%" name='message_content' tabindex='3' id='message_content'><?php echo $_POST['message_content']; ?></textarea>
					<br />
					<?php _e('Required') ?></td> 
					</tr>
					</table>
                <p class="submit">
                <input type="submit" name="Submit" value="<?php _e('Send') ?>" />
                </p>
				</form>
				<?php
			}
		break;
		//---------------------------------------------------//
		case "process":
			if ($_POST['message_to'] == '' || $_POST['message_subject'] == '' || $_POST['message_content'] == ''){
				$rows = get_option('default_post_edit_rows');
				if (($rows < 3) || ($rows > 100)){
					$rows = 12;
				}
				$rows = "rows='$rows'";
				?>
				<h2><?php _e('New Message') ?></h2>
                <p><?php _e('Please fill in all required fields') ?></p>
				<form name="new_message" method="POST" action="inbox.php?page=new&action=process">
					<table class="form-table">
					<tr valign="top">
					<th scope="row"><?php _e('To (usernames)') ?></th>
					<td><input type="text" name="message_to" id="message_to" style="width: 95%" tabindex='1' maxlength="200" value="<?php echo $_POST['message_to']; ?>" />
					<br />
					<?php _e('Required - seperate multiple usernames by commas Ex: demouser1,demouser2') ?></td> 
					</tr>
					<tr valign="top">
					<th scope="row"><?php _e('Subject') ?></th>
					<td><input type="text" name="message_subject" id="message_subject" style="width: 95%" tabindex='2' maxlength="200" value="<?php echo $_POST['message_subject']; ?>" />
					<br />
					<?php _e('Required') ?></td> 
					</tr>
					<tr valign="top"> 
					<th scope="row"><?php _e('Content') ?></th> 
					<td><textarea <?php if ( user_can_richedit() ){ echo "class='mceEditor'"; } ?> <?php echo $rows; ?> style="width: 95%" name='message_content' tabindex='3' id='message_content'><?php echo $_POST['message_content']; ?></textarea>
					<br />
					<?php _e('Required') ?></td> 
					</tr>
					</table>
                <p class="submit">
                <input type="submit" name="Submit" value="<?php _e('Send') ?>" />
                </p>
                </form>
				<?php
			} else {
				//==========================================================//
				$tmp_usernames = $_POST['message_to'];
				$tmp_usernames = str_replace( ",", ', ', $tmp_usernames );
				$tmp_usernames = ',,' . $tmp_usernames . ',,';
				$tmp_usernames = str_replace( " ", '', $tmp_usernames );
				$tmp_usernames_array = explode(",", $tmp_usernames);
				$tmp_usernames_array = array_unique($tmp_usernames_array);

				$tmp_username_error = 0;
				$tmp_error_usernames = '';
				$tmp_to_all_uids = '|';
				foreach ($tmp_usernames_array as $tmp_username){
					if ($tmp_username != ''){
						$tmp_username_count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->users . " WHERE user_login = '" . $tmp_username . "'");
						if ($tmp_username_count > 0){
							$tmp_uid = $wpdb->get_var("SELECT ID FROM " . $wpdb->users . " WHERE user_login = '" . $tmp_username . "'");
							$tmp_to_all_uids = $tmp_to_all_uids . $tmp_uid . '|';
							//found
						} else {
							$tmp_username_error = $tmp_username_error + 1;
							$tmp_error_usernames = $tmp_error_usernames . $tmp_username . ', ';
						}
					}
				}
				$tmp_error_usernames = trim($tmp_error_usernames, ", ");
				//==========================================================//
				if ($tmp_username_error > 0){
					$rows = get_option('default_post_edit_rows');
					if (($rows < 3) || ($rows > 100)){
						$rows = 12;
					}
					$rows = "rows='$rows'";
					?>
					<h2><?php _e('New Message') ?></h2>
					<p><?php _e('The following usernames could not be found in the system') ?> <em><?php echo $tmp_error_usernames; ?></em></p>
					<form name="new_message" method="POST" action="inbox.php?page=new&action=process">
						<table class="form-table">
                            <tr valign="top">
                                <th scope="row"><?php _e('To (usernames)') ?></th>
                                <td><input type="text" name="message_to" id="message_to" style="width: 95%" tabindex='1' maxlength="200" value="<?php echo $_POST['message_to']; ?>" />
                                <br />
                                <?php _e('Required - seperate multiple usernames by commas Ex: demouser1,demouser2') ?></td> 
                            </tr>
                            <tr valign="top">
                                <th scope="row"><?php _e('Subject') ?></th>
                                <td><input type="text" name="message_subject" id="message_subject" style="width: 95%" tabindex='2' maxlength="200" value="<?php echo $_POST['message_subject']; ?>" />
                                <br />
                                <?php _e('Required') ?></td> 
                            </tr>
                            <tr valign="top"> 
                                <th scope="row"><?php _e('Content') ?></th> 
                                <td><textarea <?php if ( user_can_richedit() ){ echo "class='mceEditor'"; } ?> <?php echo $rows; ?> style="width: 95%" name='message_content' tabindex='3' id='message_content'><?php echo $_POST['message_content']; ?></textarea>
                                <br />
                                <?php _e('Required') ?></td> 
                            </tr>
						</table>
                    <p class="submit">
                    <input type="submit" name="Submit" value="<?php _e('Send') ?>" />
                    </p>
                    </form>
					<?php

				} else {
					//everything checked out - send the messages
					?>
					<p><?php _e('Sending message(s)...') ?></p>
                    <?php
					foreach ($tmp_usernames_array as $tmp_username){
						if ($tmp_username != ''){
							$tmp_to_uid = $wpdb->get_var("SELECT ID FROM " . $wpdb->users . " WHERE user_login = '" . $tmp_username . "'");
							messaging_insert_message($tmp_to_uid,$tmp_to_all_uids,$user_ID,$_POST['message_subject'],$_POST['message_content'],'unread',0);
							messaging_new_message_notification($tmp_to_uid,$user_ID,$_POST['message_subject'],$_POST['message_content']);
						}
					}
					messaging_insert_sent_message($tmp_to_all_uids,$user_ID,$_POST['message_subject'],$_POST['message_content'],0);
					echo "
					<SCRIPT LANGUAGE='JavaScript'>
					window.location='inbox.php?updated=true&updatedmsg=" . urlencode('Message(s) Sent.') . "';
					</script>
					";
				}
			}
		break;
		//---------------------------------------------------//
	}
	echo '</div>';
}

function messaging_sent_page_output() {
	global $wpdb, $wp_roles, $current_user, $user_ID, $current_site, $messaging_official_message_bg_color, $messaging_max_inbox_messages, $messaging_max_reached_message;

	if (isset($_GET['updated'])) {
		?><div id="message" class="updated fade"><p><?php _e('' . urldecode($_GET['updatedmsg']) . '') ?></p></div><?php
	}
	echo '<div class="wrap">';
	switch( $_GET[ 'action' ] ) {
		//---------------------------------------------------//
		default:
		$tmp_sent_message_count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "sent_messages WHERE sent_message_from_user_ID = '" . $user_ID . "'");
			?>
            <h2><?php _e('Sent Messages') ?></h2>
            <?php
			if ($tmp_sent_message_count == 0){
			?>
            <p><?php _e('No messages to display') ?></p>
            <?php
			} else {
			$query = "SELECT * FROM " . $wpdb->base_prefix . "sent_messages WHERE sent_message_from_user_ID = '" . $user_ID . "' ORDER BY sent_message_ID DESC LIMIT 50";
			$tmp_sent_messages = $wpdb->get_results( $query, ARRAY_A );
			echo "
			<table cellpadding='3' cellspacing='3' width='100%' class='widefat'> 
			<thead><tr>
			<th scope='col'>" . __("To") . "</th>
			<th scope='col'>" . __("Subject") . "</th>
			<th scope='col'>" . __("Sent") . "</th>
			<th scope='col'>" . __("Actions") . "</th>
			</tr></thead>
			<tbody id='the-list'>
			";
			if (count($tmp_sent_messages) > 0){
				$class = ('alternate' == $class) ? '' : 'alternate';
				foreach ($tmp_sent_messages as $tmp_sent_message){
				if ($tmp_message['message_official'] == 1){
					$style = "'style=background-color:" . $messaging_official_message_bg_color . ";'";
				} else {
					$style = "";
				}
				//=========================================================//
				$tmp_user_ids = $tmp_sent_message['sent_message_to_user_IDs'];
				$tmp_user_ids_array = explode("|", $tmp_user_ids);

				$tmp_usernames = '';
				foreach ($tmp_user_ids_array as $tmp_user_id){
					$tmp_username = $wpdb->get_var("SELECT user_login FROM " . $wpdb->users . " WHERE ID = '" . $tmp_user_id . "'");
					$tmp_display_name = $wpdb->get_var("SELECT display_name FROM " . $wpdb->users . " WHERE ID = '" . $tmp_user_id . "'");
					if ( $tmp_display_name != '' ) {
						$tmp_username = $tmp_display_name;
					}
					$tmp_user_url = messaging_user_primary_blog_url($tmp_user_id);
					if ($tmp_user_url == ''){
						$tmp_usernames = $tmp_usernames . $tmp_username . ", ";
					} else {
						$tmp_usernames = $tmp_usernames . "<a href='" . $tmp_user_url . "'>" . $tmp_username . "</a>, ";
					}
				}
				$tmp_usernames = trim($tmp_usernames, ", ");
				//=========================================================//
				echo "<tr class='" . $class . "' " . $style . ">";
				if ($tmp_message['message_official'] == 1){
					echo "<td valign='top'><strong>" . $tmp_usernames . "</strong></td>";
					echo "<td valign='top'><strong>" . stripslashes($tmp_sent_message['sent_message_subject']) . "</strong></td>";
					echo "<td valign='top'><strong>" . date(get_option('date_format') . ' ' . get_option('time_format'),$tmp_sent_message['sent_message_stamp']) . "</strong></td>";
				} else {
					echo "<td valign='top'>" . $tmp_usernames . "</td>";
					echo "<td valign='top'>" . stripslashes($tmp_sent_message['sent_message_subject']) . "</td>";
					echo "<td valign='top'>" . date(get_option('date_format') . ' ' . get_option('time_format'),$tmp_sent_message['sent_message_stamp']) . "</td>";
				}
				echo "<td valign='top'><a href='inbox.php?page=sent&action=view&mid=" . $tmp_sent_message['sent_message_ID'] . "' rel='permalink' class='edit'>" . __('View') . "</a></td>";
				echo "</tr>";
				$class = ('alternate' == $class) ? '' : 'alternate';
				//=========================================================//
				}
			}
			?>
			</tbody></table>
            <?php
			}
		break;
		//---------------------------------------------------//
		case "view":
			$tmp_message_count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "sent_messages WHERE sent_message_ID = '" . $_GET['mid'] . "' AND sent_message_from_user_ID = '" . $user_ID . "'");
			if ($tmp_message_count > 0){
			$tmp_message_subject = stripslashes($wpdb->get_var("SELECT sent_message_subject FROM " . $wpdb->base_prefix . "sent_messages WHERE sent_message_ID = '" . $_GET['mid'] . "'"));
			$tmp_message_content = stripslashes($wpdb->get_var("SELECT sent_message_content FROM " . $wpdb->base_prefix . "sent_messages WHERE sent_message_ID = '" . $_GET['mid'] . "'"));
			$tmp_message_to_user_IDs = $wpdb->get_var("SELECT sent_message_to_user_IDs FROM " . $wpdb->base_prefix . "sent_messages WHERE sent_message_ID = '" . $_GET['mid'] . "'");
			$tmp_message_stamp = $wpdb->get_var("SELECT sent_message_stamp FROM " . $wpdb->base_prefix . "sent_messages WHERE sent_message_ID = '" . $_GET['mid'] . "'");
			//=========================================================//
			$tmp_user_ids = $tmp_message_to_user_IDs;
			$tmp_user_ids_array = explode("|", $tmp_user_ids);
			$tmp_usernames = '';
			foreach ($tmp_user_ids_array as $tmp_user_id){
				$tmp_username = $wpdb->get_var("SELECT user_login FROM " . $wpdb->users . " WHERE ID = '" . $tmp_user_id . "'");
				$tmp_user_url = messaging_user_primary_blog_url($tmp_user_id);
				if ($tmp_user_url == ''){
					$tmp_usernames = $tmp_usernames . $tmp_username . ", ";
				} else {
					$tmp_usernames = $tmp_usernames . "<a href='" . $tmp_user_url . "'>" . $tmp_username . "</a>, ";
				}
			}
			$tmp_usernames = trim($tmp_usernames, ", ");
			//$tmp_usernames = str_replace(", ","<br />",$tmp_usernames);
			//=========================================================//
			?>

            <h2><?php _e('View Message: ') ?><?php echo $_GET['mid']; ?></h2>
			<form name="new_message" method="POST" action="inbox.php?page=sent">
            <h3><?php _e('To') ?></h3>
            <p><?php echo $tmp_usernames; ?></p>
            <h3><?php _e('Subject') ?></h3>
            <p><?php echo $tmp_message_subject; ?></p>
            <h3><?php _e('Date') ?></h3>
            <p><?php echo date(get_option('date_format') . ' ' . get_option('time_format'),$tmp_message_stamp); ?></p>
            <h3><?php _e('Content') ?></h3>
            <p><?php echo $tmp_message_content; ?></p>
            <p class="submit">
            <input type="submit" name="Submit" value="<?php _e('Back') ?>" />
            </p>
            </form>
            <?php
			} else {
			?>
            <p><?php _e('You do not have permission to view this message') ?></p>
            <?php
			}
		break;
		//---------------------------------------------------//
	}
	echo '</div>';
}

function messaging_export_page_output() {
	global $wpdb, $wp_roles, $current_user, $user_ID, $current_site;

	if (isset($_GET['updated'])) {
		?><div id="message" class="updated fade"><p><?php _e('' . urldecode($_GET['updatedmsg']) . '') ?></p></div><?php
	}
	echo '<div class="wrap">';
	switch( $_GET[ 'action' ] ) {
		//---------------------------------------------------//
		default:
			?>
			<h2><?php _e('Export Messages') ?></h2>
                <form method="post" action="inbox.php?page=export&action=process"> 
                <table class="form-table"> 
                <tr valign="top"> 
                <th scope="row"><?php _e('Generate export data for') ?></th> 
                <td>
                <select name="export_type" id="export_type">
                <option value="received" ><?php _e('Received Messages') ?></option>
                <option value="sent" ><?php _e('Sent Messages') ?></option>
                </select>
                </td> 
                </tr> 
                </table>
                <p class="submit">
                <input type="submit" name="Submit" value="<?php _e('Next') ?>" />
                <input type="hidden" name="action" value="update" />
                </p>
                </form>
            <?php
		break;
		//---------------------------------------------------//
		case "process":
			$export_data_divider = "==============================================================================\n";
			$export_data = $export_data_divider;
			//============================================//
			if ($_POST['export_type'] == 'received'){
				$query = "SELECT * FROM " . $wpdb->base_prefix . "messages WHERE message_to_user_ID = '" . $user_ID . "' ORDER BY message_ID DESC";
				$tmp_messages = $wpdb->get_results( $query, ARRAY_A );
				if (count($tmp_messages) > 0){
					foreach ($tmp_messages as $tmp_message){
						$tmp_username = $wpdb->get_var("SELECT user_login FROM " . $wpdb->users . " WHERE ID = '" . $tmp_message['message_from_user_ID'] . "'");
						$export_data = $export_data . __('From'). ': ' . $tmp_username . "\n";
						$export_data = $export_data . __('Received'). ': ' . date(get_option('date_format') . ' ' . get_option('time_format'),$tmp_message['message_stamp']) . "\n";
						$export_data = $export_data . __('Subject'). ': ' . stripslashes($tmp_message['message_subject']) . "\n";
						$export_data = $export_data . __('Content'). ': ' . stripslashes($tmp_message['message_content']) . "\n";
						$export_data = $export_data . $export_data_divider;	
					}
				}
			}
			//============================================//
			if ($_POST['export_type'] == 'sent'){
				$query = "SELECT * FROM " . $wpdb->base_prefix . "sent_messages WHERE sent_message_from_user_ID = '" . $user_ID . "' ORDER BY sent_message_ID DESC";
				$tmp_sent_messages = $wpdb->get_results( $query, ARRAY_A );
				if (count($tmp_sent_messages) > 0){
					foreach ($tmp_sent_messages as $tmp_sent_message){
						//=========================================================//
						$tmp_user_ids = $tmp_sent_message['sent_message_to_user_IDs'];
						$tmp_user_ids_array = explode("|", $tmp_user_ids);
						$tmp_usernames = '';
						foreach ($tmp_user_ids_array as $tmp_user_id){
							$tmp_username = $wpdb->get_var("SELECT user_login FROM " . $wpdb->users . " WHERE ID = '" . $tmp_user_id . "'");
							$tmp_usernames = $tmp_usernames . $tmp_username . ", ";
						}
						$tmp_usernames = trim($tmp_usernames, ", ");
						//=========================================================//
						$tmp_username = $wpdb->get_var("SELECT user_login FROM " . $wpdb->users . " WHERE ID = '" . $tmp_sent_message['sent_message_from_user_ID'] . "'");
						$export_data = $export_data . __('To'). ': ' . $tmp_usernames . "\n";
						$export_data = $export_data . __('Sent'). ': ' . date(get_option('date_format') . ' ' . get_option('time_format'),$tmp_sent_message['sent_message_stamp']) . "\n";
						$export_data = $export_data . __('Subject'). ': ' . stripslashes($tmp_sent_message['sent_message_subject']) . "\n";
						$export_data = $export_data . __('Content'). ': ' . stripslashes($tmp_sent_message['sent_message_content']) . "\n";
						$export_data = $export_data . $export_data_divider;	
					}
				}
			}
			//============================================//
			if ($export_data == $export_data_divider){
				$export_data = '';
			}
			//============================================//
			if ($_POST['export_type'] == 'received'){
				?>
	            <h2><?php _e('Export Data') ?> <?php _e('Received Messages') ?></h2>
                <?php
			} else if ($_POST['export_type'] == 'sent'){
				?>
	            <h2><?php _e('Export Data') ?> <?php _e('Sent Messages') ?></h2>
                <?php
			} else {
				?>
	            <h2><?php _e('Export Data') ?></h2>
                <?php
			}
			?>
			<form name="back" method="POST" action="inbox.php?page=export">
            <p style="padding-left:0px;padding-right:10px;"><textarea style="width:100%" rows="35"><?php echo $export_data; ?></textarea></p>
            <p class="submit">
            <input type="submit" name="Submit" value="<?php _e('Back') ?>" />
            </p>
            </form>
            <?php
		break;
		//---------------------------------------------------//
	}
	echo '</div>';
}

function messaging_notifications_page_output() {
	global $wpdb, $wp_roles, $current_user, $user_ID, $current_site;

	if (isset($_GET['updated'])) {
		?><div id="message" class="updated fade"><p><?php _e('' . urldecode($_GET['updatedmsg']) . '') ?></p></div><?php
	}
	echo '<div class="wrap">';
	switch( $_GET[ 'action' ] ) {
		//---------------------------------------------------//
		default:
			$tmp_message_email_notification = get_usermeta($user_ID,'message_email_notification');
			?>
			<h2><?php _e('Notification Settings') ?></h2>
                <form method="post" action="inbox.php?page=message-notifications&action=process">
                <table class="form-table">
                <tr valign="top"> 
                <th scope="row"><?php _e('Receive an email notifying you of new messages') ?></th> 
                <td>
                <select name="message_email_notification" id="message_email_notification">
                <option value="yes" <?php if ($tmp_message_email_notification == 'yes'){ echo 'selected="selected"'; } ?> ><?php _e('Yes') ?></option>
                <option value="no" <?php if ($tmp_message_email_notification == 'no'){ echo 'selected="selected"'; } ?> ><?php _e('No') ?></option>
                </select>
                </td> 
                </tr> 
                </table>
                <p class="submit">
                <input type="submit" name="Submit" value="<?php _e('Save Changes') ?>" />
                </p>
                </form>
            <?php
		break;
		//---------------------------------------------------//
		case "process":
			update_usermeta($user_ID,'message_email_notification',$_POST['message_email_notification']);
			echo "
			<SCRIPT LANGUAGE='JavaScript'>
			window.location='inbox.php?page=notifications&updated=true&updatedmsg=" . urlencode('Settings saved.') . "';
			</script>
			";
		break;
		//---------------------------------------------------//
	}
	echo '</div>';
}



//------------------------------------------------------------------------//
//---Support Functions----------------------------------------------------//
//------------------------------------------------------------------------//

function messaging_user_primary_blog_url($tmp_uid){
	global $wpdb;
	$tmp_blog_id = $wpdb->get_var("SELECT meta_value FROM " . $wpdb->base_prefix . "usermeta WHERE meta_key = 'primary_blog' AND user_id = '" . $tmp_uid . "'");
	if ($tmp_blog_id == ''){
		return;
	}
	$tmp_blog_domain = $wpdb->get_var("SELECT domain FROM " . $wpdb->base_prefix . "blogs WHERE blog_id = '" . $tmp_blog_id . "'");
	$tmp_blog_path = $wpdb->get_var("SELECT path FROM " . $wpdb->base_prefix . "blogs WHERE blog_id = '" . $tmp_blog_id . "'");
	return 'http://' . $tmp_blog_domain . $tmp_blog_path;
}

?>