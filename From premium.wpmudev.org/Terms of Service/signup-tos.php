<?php
/*
Plugin Name: Signup TOS
Plugin URI: 
Description:
Author: Andrew Billits
Version: 1.0.8
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
add_action('signup_extra_fields', 'signup_tos_field');
add_filter('wpmu_validate_user_signup', 'signup_tos_filter');
add_action('admin_menu', 'signup_tos_plug_pages');
//------------------------------------------------------------------------//
//---Functions------------------------------------------------------------//
//------------------------------------------------------------------------//

function signup_tos_plug_pages() {
	global $wpdb, $wp_roles, $current_user;
	if ( is_site_admin() ) {
		add_submenu_page('wpmu-admin.php', 'TOS', 'TOS', 10, 'signup-tos', 'signup_tos_page_main_output');
	}
}

//------------------------------------------------------------------------//
//---Page Output Functions------------------------------------------------//
//------------------------------------------------------------------------//

function signup_tos_field($errors) {
	$error = $errors->get_error_message('tos');
	$signup_tos = get_site_option('signup_tos_data');
	if ( !empty( $signup_tos ) ) {
	?>
    <label for="password"><?php _e('TOS'); ?>:</label>
		<textarea name="tos_content" type="text" rows="5" wrap="soft" id="tos_content" readonly="readonly" style="width: 95%; background-color:#FFFFFF; color:#000000; border: 1px solid #999999"/><?php echo $signup_tos ?></textarea>  
    <label for="password"><?php _e('I Agree'); ?>:</label>
		<?php
        if($error) {
			echo '<p class="error">' . $error . '</p>';
        }
		?>
		<input type="checkbox" name="tos_agree" value="1"/>
	<?php
	}
}

function signup_tos_filter($content) {
	$signup_tos = get_site_option('signup_tos_data');
	if ( !empty( $signup_tos ) ) {
		$tos_agree = (int) $_POST['tos_agree'];
		if($tos_agree == '0' && $_POST['stage'] == 'validate-user-signup') {
			$content['errors']->add('tos', __('You must agree to the TOS in order to signup.'));
		}
	
		if($tos_agree == '1') {
			//correct answer!
		} else {
			if($_POST['stage'] == 'validate-user-signup') {
				$content['errors']->add('tos', __('You must agree to the TOS in order to signup.'));
			}
		}
	}
	return $content;
}

function signup_tos_page_main_output() {
	global $wpdb, $wp_roles, $current_user;
	/*
	if(!current_blog_can('edit_users')) {
		echo "<p>Nice Try...</p>";  //If accessed properly, this message doesn't appear.
		return;
	}
	*/
	if (isset($_GET['updated'])) {
		?><div id="message" class="updated fade"><p><?php _e('' . urldecode($_GET['updatedmsg']) . '') ?></p></div><?php
	}
	echo '<div class="wrap">';
	switch( $_GET[ 'action' ] ) {
		//---------------------------------------------------//
		default:
		?>
        <h2><?php _e('Terms of Service') ?></h2> 
        <form method="post" action="wpmu-admin.php?page=signup-tos&action=update">
        <table class="form-table">
        <tr valign="top">
        <th scope="row"><?php _e('TOS:') ?></th>
        <td>
        <textarea name="signup_tos_data" type="text" rows="5" wrap="soft" id="signup_tos_data" style="width: 95%"/><?php echo get_site_option('signup_tos_data') ?></textarea>
        <br /></td>
        </tr>
        </table>
        
        <p class="submit">
        <input type="submit" name="Submit" value="<?php _e('Save Changes') ?>" />
        </p>
        </form>
        <?php
		break;
		//---------------------------------------------------//
		case "update":
			update_site_option( "signup_tos_data", $_POST[ 'signup_tos_data' ] );
			echo "<p>Options saved.</p>";
			echo "
			<SCRIPT LANGUAGE='JavaScript'>
			window.location='wpmu-admin.php?page=signup-tos&updated=true&updatedmsg=" . urlencode('Settings saved.') . "';
			</script>
			";
		break;
		//---------------------------------------------------//
		case "temp":
		break;
		//---------------------------------------------------//
	}
	echo '</div>';
}

?>
