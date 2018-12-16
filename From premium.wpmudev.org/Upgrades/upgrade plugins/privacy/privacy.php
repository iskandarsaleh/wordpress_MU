<?php
/*
Plugin Name: Privacy
Plugin URI:
Description:
Author: Andrew Billits
Version: 1.4.2
Author URI:
Note: A few lines of code borrowed from a similar plugin by Angsuman Chakraborty, Taragana
*/

//------------------------------------------------------------------------//
//---Hook-----------------------------------------------------------------//
//------------------------------------------------------------------------//

//register premium features
upgrades_register_feature('322d4490bc46e441c5aee9da27950430', 'Privacy', 'Complete Privacy.');

if (upgrades_active_feature('322d4490bc46e441c5aee9da27950430') == 'active'){
	if (get_option('privacy_enabled') == 'yes'){
		if('wp-login.php' != $pagenow && 'wp-register.php' != $pagenow) add_action('template_redirect', 'privacy_auth_redirect');
	}
}

if (upgrades_active_feature('322d4490bc46e441c5aee9da27950430') == 'active'){
	add_action('admin_menu', 'privacy_plug_pages');
}

//------------------------------------------------------------------------//
//---Functions------------------------------------------------------------//
//------------------------------------------------------------------------//

function privacy_plug_pages() {
		//add_menu_page("Friends","Friends",1,"friends/page/index.php");
		//add_submenu_page("users.php", "","Friendship Requests (0)",1, 'users.php');
		add_submenu_page('options-general.php', 'Premium Privacy', 'Premium Privacy', 'manage_options', 'privacy_options', 'privacy_page_main_output' );
}

function privacy_auth_redirect() {
	// Checks if a user is logged in, if not redirects them to the login page
	if ( (!empty($_COOKIE[USER_COOKIE]) && 
				!wp_login($_COOKIE[USER_COOKIE], $_COOKIE[PASS_COOKIE], true)) ||
			 (empty($_COOKIE[USER_COOKIE])) ) {
		nocache_headers();
		header("HTTP/1.1 302 Moved Temporarily");
		header('Location: ' . get_settings('siteurl') . '/wp-login.php?redirect_to=' . urlencode($_SERVER['REQUEST_URI']));
            header("Status: 302 Moved Temporarily");
		exit();
	}
}

function privacy_page_main_output() {
	global $wp_roles, $current_user, $wpdb;
	
	if(!current_user_can('manage_options')) {
		echo "<p>Nice Try...</p>";  //If accessed properly, this message doesn't appear.
		return;
	}
	echo '<div class="wrap">';
	switch( $_GET[ 'action' ] ) {
		//---------------------------------------------------//
		default:
			?>
			<h2><?php _e('Privacy Options') ?></h2>
            <form name="form1" method="POST" action="options-general.php?page=privacy_options&action=update"> 
                <p><?php _e('Allow only registered users to view your blog.') ?></p> 
                <table class="form-table">
                <tr valign="top"> 
                <th scope="row"><?php _e('Enable') ?></th> 
                <td><select name="privacy_select">
                <option value="yes" <?php if (get_option('privacy_enabled') == "yes"){ echo 'selected="selected"'; } ?> >Yes</option>
                <option value="no" <?php if (get_option('privacy_enabled') == "no" || get_option('privacy_enabled') == ""){ echo 'selected="selected"'; } ?> >No</option>
                </select>
                <br />
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
		case "update":
			update_option("privacy_enabled", $_POST[ 'privacy_select' ]);
			echo "<p>Options Updated!</p>";
			echo "
			<SCRIPT LANGUAGE='JavaScript'>
			window.location='options-general.php?page=privacy_options&updated=true&updatedmsg=" . urlencode('Settings saved.') . "';
			</script>
			";
		break;
		//---------------------------------------------------//
		case "step2":
		break;
		//---------------------------------------------------//
	}
	echo '</div>';
}

?>