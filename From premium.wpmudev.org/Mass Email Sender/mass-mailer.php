<?php
/*
Plugin Name: Mass Mailer
Plugin URI: 
Description:
Author: Andrew Billits
Version: 1.6.0
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
//---Hook-----------------------------------------------------------------//
//------------------------------------------------------------------------//
if ($_GET['page'] == 'mass-mailer'){
	mass_mailer_install();
	mass_mailer_upgrade();
}

if (get_site_option( "mass_mailer_installed" ) == "yes") {
	mass_mailer_user_install();
}

add_action('admin_menu', 'mass_mailer_plug_pages');
add_action('wp_head', 'mass_mailer_unsubscribe');
if ( $user_types_display_profile_option == 'yes' ) {
	add_action('show_user_profile', 'mass_mailer_profile');
}
add_action('edit_user_profile', 'mass_mailer_profile');
add_action('show_user_profile', 'mass_mailer_profile');
add_filter('wp_redirect', 'mass_mailer_profile_process', 1, 1);
//------------------------------------------------------------------------//
//---Functions------------------------------------------------------------//
//------------------------------------------------------------------------//
function mass_mailer_upgrade() {
	global $wpdb;
	if (get_site_option( "mass_mailer_version" ) == '') {
		add_site_option( 'mass_mailer_version', '0.0.0' );
	}
	
	if (get_site_option( "mass_mailer_version" ) == "1.6.0") {
		// do nothing
	} else {
		//upgrade code goes here
		//update to current version
		update_site_option( "mass_mailer_version", "1.6.0" );
	}
}

function mass_mailer_install() {
	global $wpdb;
	if (get_site_option( "mass_mailer_installed" ) == '') {
		add_site_option( 'mass_mailer_installed', 'no' );
	}
	
	if (get_site_option( "mass_mailer_installed" ) == "yes") {
		// do nothing
	} else {
	
		$mass_mailer_table1 = "CREATE TABLE " . $wpdb->base_prefix . "mass_mailer (
							email_ID bigint(20) unsigned NOT NULL auto_increment,
							email_user_id VARCHAR(255),
							email_optout VARCHAR(255) NOT NULL default 'yes',
							email_status VARCHAR(255) NOT NULL default 'no',
							PRIMARY KEY  (email_ID)
							);";

		$wpdb->query( $mass_mailer_table1 );
		mass_mailer_table_populate();
		update_site_option( "mass_mailer_installed", "yes" );
	}
}

function mass_mailer_table_populate() {
	global $wpdb, $wp_roles, $current_user;
		$query = "SELECT ID, user_login FROM wp_users";
		$tmp_users_list = $wpdb->get_results( $query, ARRAY_A );
		processArrayUsersPopulate($tmp_users_list);
}

function processArrayUsersPopulate($arrayName) {
	global $wpdb, $wp_roles, $current_user, $user_ID;
	foreach ($arrayName as $arrayElement) {
		if (count($arrayElement) > 1) {
			processArrayUsersPopulate($arrayElement);
		} else {
			$intArrayCount = $intArrayCount + 1;
			if ($intArrayCount == 1) {
				//$tmp_count = $wpdb->get_var("SELECT COUNT(*) FROM ".$wpdb->usermeta." WHERE user_id = '" . $arrayElement . "' AND meta_key = 'recieve_admin_emails'");
				//if ($tmp_count == '1') {
					//$tmp_value = $wpdb->get_var("SELECT meta_value FROM ".$wpdb->usermeta." WHERE user_id = '" . $arrayElement . "' AND meta_key = 'recieve_admin_emails'");
					//if ($tmp_value == 'no'){
						//--------------------------
							$tmp_email_count = $wpdb->get_var("SELECT COUNT(*) FROM wp_mass_mailer WHERE email_user_id = '" . $arrayElement . "'");
							if ($tmp_email_count == '0') {
									$tmp_email_count2 = $wpdb->get_var("SELECT COUNT(*) FROM wp_usermeta WHERE user_id = '" . $arrayElement . "' AND meta_key = 'recieve_admin_emails'");
									if ($tmp_email_count2 == '0') {
										$wpdb->query( "INSERT INTO wp_mass_mailer (email_user_id, email_optout, email_status) VALUES ( '" . $arrayElement . "', 'yes', 'yes' )" );
									} else {
										$wpdb->query( "INSERT INTO wp_mass_mailer (email_user_id, email_optout, email_status) VALUES ( '" . $arrayElement . "', '" . get_usermeta($arrayElement, 'recieve_admin_emails') . "', 'yes' )" );								
									}
							} else {
									$wpdb->query( "UPDATE wp_mass_mailer SET email_optout = '" . get_usermeta($arrayElement, 'recieve_admin_emails') . "' WHERE email_user_id = '" . $arrayElementc . "'" );
							}
							//$wpdb->query( "UPDATE wp_mass_mailer SET email_optout = '" . get_usermeta($arrayElement, 'recieve_admin_emails') . "' WHERE email_user_id = '" . $arrayElementc . "'" );
						//--------------------------
					//} else {
						//--------------------------
						
						//--------------------------
					//}
				//}
			}
			if ($intArrayCount == 2) {
				//echo "<td valign='top'>$arrayElement</td>";
			}
		}
	}
}

function mass_mailer_clear() {
	global $wpdb, $wp_roles, $current_user;
	$wpdb->query( "UPDATE wp_mass_mailer SET email_status = 'yes'" );
}

function mass_mailer_reset() {
	global $wpdb, $wp_roles, $current_user;
	$wpdb->query( "UPDATE wp_mass_mailer SET email_status = 'no'" );
}

function mass_mailer_global_db_sync() {
	global $wpdb, $wp_roles, $current_user;
	$email_count = $wpdb->get_var("SELECT COUNT(*) FROM wp_mass_mailer WHERE email_user_id = '" . $current_user->ID . "'");
	if ($email_count == '0') {
			$wpdb->query( "INSERT INTO wp_mass_mailer (email_user_id, email_optout, email_status) VALUES ( '" . $current_user->ID . "', 'yes', 'yes' )" );
	} else {
			$wpdb->query( "UPDATE wp_mass_mailer SET email_optout = '" . get_usermeta($current_user->ID, 'recieve_admin_emails') . "' WHERE email_user_id = '" . $current_user->ID . "'" );
	}
}

function mass_mailer_user_install(){
	global $wpdb, $wp_roles, $current_user;
	if(get_usermeta($current_user->ID, 'mass_mailer_user_installed')!='1'){
	mass_mailer_global_db_sync();
	update_usermeta($current_user->ID, 'mass_mailer_user_installed', '1');
	}
}

function processArrayUsers($arrayName) {
	global $wpdb, $wp_roles, $current_user, $user_ID, $tmp_send_count;
	$intArrayCount = 0;
	foreach ($arrayName as $arrayElement) {
		if (count($arrayElement) > 1) {
			processArrayUsers($arrayElement);
		} else {
			$intArrayCount = $intArrayCount + 1;
			/*
			if ($intArrayCount == 1) {
				$tmp_count = $wpdb->get_var("SELECT COUNT(*) FROM ".$wpdb->usermeta." WHERE user_id = '" . $arrayElement . "' AND meta_key = 'recieve_admin_emails'");
				if ($tmp_count == '1') {
					$tmp_value = $wpdb->get_var("SELECT meta_value FROM ".$wpdb->usermeta." WHERE user_id = '" . $arrayElement . "' AND meta_key = 'recieve_admin_emails'");
					if ($tmp_value == 'yes'){
					mass_email_send_email($arrayElement);
					}
				
				}
			}
			*/
			if ($intArrayCount == 1) {
				//$tmp_count = $wpdb->get_var("SELECT COUNT(*) FROM ".$wpdb->usermeta." WHERE user_id = '" . $arrayElement . "' AND meta_key = 'recieve_admin_emails'");
				//if ($tmp_count == '1') {
					//$tmp_value = $wpdb->get_var("SELECT meta_value FROM ".$wpdb->usermeta." WHERE user_id = '" . $arrayElement . "' AND meta_key = 'recieve_admin_emails'");
					//if ($tmp_value == 'no'){
						// do nothing - they don't want email
					//} else {
						mass_mailer_send_email($arrayElement);
						$wpdb->query( "UPDATE wp_mass_mailer SET email_status = 'yes' WHERE email_user_id = '" . $arrayElement . "'" );
					//}
				
				//}
			}
			if ($intArrayCount == 2) {
				//echo "<td valign='top'>$arrayElement</td>";
			}
		}
	}
}

function mass_mailer_send_email($tmp_user_id) {
	global $wpdb, $wp_roles, $current_user, $user_ID, $current_site, $tmp_send_count;

	$tmp_username =  $wpdb->get_var("SELECT user_login FROM ".$wpdb->users." WHERE ID = '" . $tmp_user_id . "'");
	$tmp_user_email =  $wpdb->get_var("SELECT user_email FROM ".$wpdb->users." WHERE ID = '" . $tmp_user_id . "'");

	$message_content = get_site_option( "mass_mailer_message" );
	$message_content = str_replace( "SITE_NAME", $current_site->site_name, $message_content );
	$message_content = str_replace( "USERNAME", $tmp_username, $message_content );
	$message_content = str_replace( "\'", "'", $message_content );
	$tmp_unsubscribe_url = 'http://' . $current_site->domain . '/?eaction=unsubscribe&key=a013658e3af0acf26850d' . $tmp_user_id . '0387f7a60cd';
	$message_content = str_replace( "UNSUBSCRIBE_URL", $tmp_unsubscribe_url, $message_content );
	//$notification_email = str_replace( "DOMAIN", $blog_domain, $notification_email );


	$admin_email = get_site_option( "mass_mailer_sender" );
	if( $admin_email == '' )
		$admin_email = 'support@' . $_SERVER[ 'SERVER_NAME' ];
	$message_headers = "MIME-Version: 1.0\n" . "From: " . get_site_option( "site_name" ) .  " <{$admin_email}>\n" . "Content-Type: text/plain; charset=\"" . get_option('blog_charset') . "\"\n";
	$message = $notification_email;
	if( empty( $current_site->site_name ) )
		$current_site->site_name = "Blog Provider";
	wp_mail($tmp_user_email, get_site_option( "mass_mailer_subject" ), $message_content, $message_headers);
}

function mass_mailer_plug_pages() {
	global $wpdb, $wp_roles, $current_user;
	if ( is_site_admin() ) {
		add_submenu_page('wpmu-admin.php', 'Send Email', 'Send Email', 10, 'mass-mailer', 'mass_mailer_page_main_output');
	}
}

function mass_mailer_profile_process($location) {
	global $user_ID;
	if ( !empty( $_GET['user_id'] ) ) {
		$uid = $_GET['user_id'];
	} else {
		$uid = $user_ID;
	}
	if ( !empty( $_POST['recieve_admin_emails'] ) ) {
		update_usermeta( $uid, 'recieve_admin_emails', $_POST['recieve_admin_emails'] );
	}
	return $location;
}

function mass_mailer_profile() {
	global $user_types, $user_types_branding, $user_ID;
	mass_mailer_global_db_sync();
	if ( !empty( $_GET['user_id'] ) ) {
		$uid = $_GET['user_id'];
	} else {
		$uid = $user_ID;
	}
	
	$recieve_admin_emails = get_usermeta( $uid, 'recieve_admin_emails' );
	?>
    <h3><?php _e('Receive admin emails'); ?></h3>
    
    <table class="form-table">
    <tr>
        <th><label for="recieve_admin_emails"><?php _e('Receive admin emails'); ?></label></th>
        <td>
            <select name="recieve_admin_emails" id="recieve_admin_emails">
                    <option value="yes"<?php if ( $recieve_admin_emails == 'yes' ) { echo ' selected="selected" '; } ?>><?php _e('Yes'); ?></option>
                    <option value="no"<?php if ( $recieve_admin_emails == 'no' ) { echo ' selected="selected" '; } ?>><?php _e('No'); ?></option>
            </select>
        </td>
    
    </tr>
    </table>
    <?php
}

function mass_mailer_unsubscribe() {
	global $wpdb, $wp_roles, $current_site, $current_user;
	if($_GET['eaction'] == 'unsubscribe') {
		$tmp_key = $_GET['key'];
		$tmp_key = str_replace( "a013658e3af0acf26850d", "", $tmp_key );
		$tmp_key = str_replace( "0387f7a60cd", "", $tmp_key );
		
		update_usermeta($tmp_key, 'recieve_admin_emails', 'no');
		$wpdb->query( "UPDATE wp_mass_mailer SET email_optout = '" . get_usermeta($tmp_key, 'recieve_admin_emails') . "' WHERE email_user_id = '" . $tmp_key . "'" );

		//send unsubscribed email
		$tmp_username =  $wpdb->get_var("SELECT user_login FROM ".$wpdb->users." WHERE ID = '" . $tmp_key . "'");
		$tmp_user_email =  $wpdb->get_var("SELECT user_email FROM ".$wpdb->users." WHERE ID = '" . $tmp_key . "'");
		
		$tmp_message_content = "Dear USERNAME,

You have been successfully unsubscribed from future emails.

 Thanks!

--The Team @ SITE_NAME

-------------------------

To receive emails again, login and edit your profile to 'receive admin emails'.";
		
		$message_content = $tmp_message_content;
		$message_content = str_replace( "SITE_NAME", $current_site->site_name, $message_content );
		$message_content = str_replace( "USERNAME", $tmp_username, $message_content );
		$message_content = str_replace( "\'", "'", $message_content );
	
		$admin_email = get_site_option( "mass_mailer_sender" );
		if( $admin_email == '' )
			$admin_email = 'support@' . $_SERVER[ 'SERVER_NAME' ];
		$message_headers = "MIME-Version: 1.0\n" . "From: " . get_site_option( "site_name" ) .  " <{$admin_email}>\n" . "Content-Type: text/plain; charset=\"" . get_option('blog_charset') . "\"\n";
		$message = $notification_email;
		if( empty( $current_site->site_name ) )
			$current_site->site_name = "Blog Provider";
		wp_mail($tmp_user_email, 'Unsubscribed', $message_content, $message_headers);
	}
}

//------------------------------------------------------------------------//
//---Page Output Functions------------------------------------------------//
//------------------------------------------------------------------------//

function mass_mailer_page_main_output() {
	global $wpdb, $wp_roles, $current_user, $user_ID, $current_site, $tmp_send_count;
	/*
	if(!current_blog_can('edit_users')) {
		echo "<p>Nice Try...</p>";  //If accessed properly, this message doesn't appear.
		return;
	}
	*/
	
	if (get_site_option( "mass_mailer_message" ) == '') {
		add_site_option( 'mass_mailer_message', 'empty' );
	}
	if (get_site_option( "mass_mailer_subject" ) == '') {
		add_site_option( 'mass_mailer_subject', 'empty' );
	}
	if (get_site_option( "mass_mailer_sender" ) == '') {
		add_site_option( 'mass_mailer_sender', 'empty' );
	}
	if (get_site_option( "mass_mailer_number_sent" ) == '') {
		add_site_option( 'mass_mailer_number_sent', '0' );
	}

	if (isset($_GET['updated'])) {
		?><div id="message" class="updated fade"><p><?php _e('' . urldecode($_GET['updatedmsg']) . '') ?></p></div><?php
	}
	echo '<div class="wrap">';

	$tmp_last_email_count = $wpdb->get_var("SELECT COUNT(*) FROM wp_mass_mailer WHERE email_optout = 'yes' AND email_status = 'no'");
	$tmp_users_count = $wpdb->get_var("SELECT COUNT(*) FROM wp_users");
	$tmp_user_count = $wpdb->get_var("SELECT COUNT(*) FROM wp_mass_mailer WHERE email_optout = 'no'");
	$tmp_user_count = $tmp_users_count - $tmp_user_count;

	if ($tmp_user_count < 2500) {
	switch( $_GET[ 'action' ] ) {
		//---------------------------------------------------//
		default:
			?>
			<h2><?php _e('Send Email') ?></h2>
			<p><?php echo $tmp_user_count; ?> out of <?php echo $tmp_users_count; ?> user(s) currently accepting emails.</p>
			<?php
            if ($tmp_last_email_count != 0) {
                echo "<p>Your last email still needs to be sent to " . $tmp_last_email_count . " user(s). Click <a href='wpmu-admin.php?page=mass-mailer&action=loop'>here</a> to finish sending the email.</p>";
            }
            ?>
            <form method="post" action="wpmu-admin.php?page=mass-mailer&action=process">
            <table class="form-table">
            <tr valign="top">
            <th scope="row"><?php _e('Sender Email:') ?></th>
            <td><input name="email_sender" type="text" id="from_email" style="width: 95%" value="<?php echo stripslashes( get_site_option('admin_email') ) ?>" size="45" />
            <br /><?php _e('The address that will appear in the "email from" field.') ?></td>
            </tr>
            <tr valign="top">
            <th scope="row"><?php _e('Subject:') ?></th>
            <td><input name="email_subject" type="text" id="subject" style="width: 95%" value="" size="75" />
            <br /><?php _e('This cannot be left blank.') ?></td>
            </tr>
            <tr valign="top">
            <th scope="row"><?php _e('Content:') ?></th>
            <td><textarea name="email_content" id="email_content" rows='5' style="width: 95%">Dear USERNAME,

Blah Blah Blah

 Thanks!

--The Team @ SITE_NAME

-------------------------

To unsubscribe from admin emails please visit this address: UNSUBSCRIBE_URL</textarea>		
            <br /><?php _e('Plain text only. No HTML allowed.') ?></td>
            </tr>
            </table>
            
            <p class="submit">
            <input type="submit" name="Submit" value="<?php _e('Save Changes') ?>" />
			<input type="submit" name="Reset" value="<?php _e('Reset') ?>" />
            </p>
            </form>
		<?php
		break;
		//---------------------------------------------------//
		case "process":
			//reset email sent status
			mass_mailer_reset();
			if ($_POST['email_sender'] == '' || $_POST['email_subject'] == '' || $_POST['email_content'] == '') {
			?>
				<h2><?php _e('Send Email') ?></h2>
				<form name="email_form" method="POST" action="wpmu-admin.php?page=mass-mailer&action=process">
				<fieldset class="options"> 
				<legend>Send an email to blog owners. <?php echo $tmp_user_count; ?> out of <?php echo $tmp_users_count; ?> user(s) currently accepting emails.</legend> 
					<p>You must fill in ALL required fields.</p>
					<table width="100%" cellspacing="2" cellpadding="5" class="editform"> 
						<tr valign="top"> 
							<th scope="row">Sender Email:</th> 
							<td><input name="email_sender" type="text" id="from_email" style="width: 95%" value="<?php echo stripslashes( get_site_option('admin_email') ) ?>" size="45" />
							<br />
							The address that will appear in the "email from" field.</td> 
						</tr> 
						<tr valign="top"> 
							<th scope="row">Subject:</th> 
							<td><input name="email_subject" type="text" id="subject" style="width: 95%" value="" size="75" />
							<br />
							This cannot be left blank.</td> 
						</tr>
						<tr valign="top"> 
							<th scope="row">Email Content:</th> 
							<td><textarea name="email_content" id="email_content" rows='5' cols='45' style="width: 95%">Dear USERNAME,

Blah Blah Blah

 Thanks!

--The Team @ SITE_NAME

-------------------------

To unsubscribe from admin emails please visit this address: UNSUBSCRIBE_URL</textarea>		
							<br />
							Plain text only. No HTML allowed.</td> 
						</tr>
					</table>	
				</fieldset>
				<p class="submit"> 
				<input type="submit" name="Submit" value="Send Email" /> 
				</p> 
				</form> 
			<?php
			
			} else {
				//proceed to process
				?>
				<h2><?php _e('Send Email') ?></h2>
				<p>Preparing to send emails... This could take a while. Please be patient!</p>
				<?php
				
				//$query = "SELECT ID, user_login FROM wp_users ";
				//$users_list = $wpdb->get_results( $query, ARRAY_A );
				
				update_site_option( "mass_mailer_message", $_POST['email_content'] );
				update_site_option( "mass_mailer_subject", $_POST['email_subject'] );
				update_site_option( "mass_mailer_sender", $_POST['email_sender'] );
				update_site_option( "mass_mailer_number_sent", '0' );
				//get_site_option( "mass_email_message" );
				//die ($tmp_loops);

				echo "
				<SCRIPT LANGUAGE='JavaScript'>
				window.location='wpmu-admin.php?page=mass-mailer&action=loop';
				</script>
				";
				
				//processArrayUsers($users_list);
			}
		break;
		//---------------------------------------------------//
		case "loop":
			if ( is_site_admin() ) {
				set_time_limit(0);
				$tmp_emails_left_count = $wpdb->get_var("SELECT COUNT(*) FROM wp_mass_mailer WHERE email_optout = 'yes' AND email_status = 'no'");
				if ($tmp_emails_left_count == 0){
					?>
					<h2><?php _e('Send Email') ?></h2>
					<p>Finished! </p>
					<?php			
				} else {
					?>
					<h2><?php _e('Send Email') ?></h2>
					<p>Sending emails... Roughly <?php echo $tmp_emails_left_count; ?> left to send.</p>
					<?php
					
					//------------------------------//
					$query = "SELECT email_user_id, email_optout FROM wp_mass_mailer WHERE email_optout = 'yes' AND email_status = 'no' LIMIT 500";
					$users_list = $wpdb->get_results( $query, ARRAY_A );
					$tmp_count_array = count( $users_list );
					if ($tmp_count_array == 0) {
					} else {
					processArrayUsers($users_list);
					}
					//------------------------------//
	
					echo "
					<SCRIPT LANGUAGE='JavaScript'>
					window.location.reload();
					</script>
					";
					/*
					echo "
					<SCRIPT LANGUAGE='JavaScript'>
					window.location='wpmu-admin.php?page=mass-mailer&action=loop';
					</script>
					";
					*/
				}
			}
		break;
		//---------------------------------------------------//
		case "temp2":
		break;
		//---------------------------------------------------//
	}
	} else {
		echo "<p>This plugin is only for sites with less than 2,500 users.</p>";
	}
	echo '</div>';
}

?>
