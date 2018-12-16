<?php
/*
Plugin Name: WPMU Plugin Manager
Plugin URI: http://missionsplace.com
Description: Plugin management for Wordpress MU that supports the native WPMU plugins page and the WPMUdev Premium Supporter plugin!
Version: 1.4.1
Author: Aaron Edwards
Author URI: http://missionsplace.com
License: GPL (see http://www.gnu.org/copyleft/gpl.html)

For WPMU 2.7.1+ only! Might work for 2.7, but before that the hooks were not in plugins.php yet.
This is a rewrite of Plugin Commander and is intended to replace it.

  Instructions: Copy into the mu-plugins folder. If the WPMUdev Premium Supporter plugin is
  enabled it will detect that. Make sure the plugins menu is enabled under site options.
*/
define('PC_HOME','wpmu-admin.php');
define('PC_CMD_BASE',PC_HOME."?page=plugin-management");

//declare hooks
add_action( 'admin_menu', 'mp_pm_add_menu' );
add_action( 'wpmu_new_blog','mp_pm_new_blog' ); //auto activation hook
add_filter( 'all_plugins', 'mp_pm_remove_plugins' );
add_filter( 'plugin_action_links', 'mp_pm_action_links', 10, 4 );
add_filter( 'active_plugins', 'mp_pm_check_activated' );
//add_action( 'pre_current_active_plugins', 'mp_pm_supporter_message' );
add_action( 'admin_notices', 'mp_pm_supporter_message' );

function mp_pm_add_menu() {
  //check for WPMUdev Premium Supporter plugin
  global $supporter;
  if (function_exists(is_supporter))
    $supporter = true;
  else
    $supporter = false;

  $file = substr(__FILE__,strlen(ABSPATH));
	if (is_site_admin())
		add_submenu_page('wpmu-admin.php', 'Plugin Management', 'Plugin Management', '10', 'plugin-management', 'mp_pm_page' );
}


function mp_pm_page() {
  global $supporter;
	if (!is_site_admin()) return;
	mp_pm_process_form();
?>
<div class='wrap'>
<h2>Manage Plugins</h2>

<?php if ($_REQUEST['saved']) { ?>
<div id="message" class="updated fade"><p>Settings Saved</p></div>
<?php } ?>
<?php if ($_REQUEST['mass_activate']) { ?>
<div id="message" class="updated fade"><p>Update: <span style="color:#FF3300;"><?php echo $_REQUEST['mass_activate']; ?></span> has been <strong>MASS ACTIVATED</strong>.</p></div>
<?php } ?>
<?php if ($_REQUEST['mass_deactivate']) { ?>
<div id="message" class="updated fade"><p>Update: <span style="color:#FF3300;"><?php echo $_REQUEST['mass_deactivate']; ?></span> has been <strong>MASS DEACTIVATED</strong>.</p></div>
<?php } 

  if ($supporter == FALSE) {
    echo '<p style="border:1px gray solid;margin:10px;padding:10px;">If you want to limit certain plugins to paid Supporters only, you must have the <a href="http://premium.wpmudev.org/?ref=prayhumbly-3442">WPMU Dev Premium</a> Supporter plugin installed.
    <a href="http://premium.wpmudev.org/?ref=prayhumbly-3442"><img src="http://premium.wpmudev.org/banners/180x60-banner.png" alt="180x60-banner.png" title="Check Out WPMU DEV Premium" /></a></p>';
  }
?>
<div class="donate-message" style="border:1px gray solid;margin:10px;padding:10px;">
	<table>
	 <tr>
     <td><?php if ($supporter) { echo "You are making money with this plugin. ";} ?>Why not send me a small donation in honor of the time I put into this? Thanks!</td>
     <td>
      <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
      <input type="hidden" name="cmd" value="_s-xclick">
      <input type="hidden" name="hosted_button_id" value="5935926">
      <input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
      <img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
      </form>
     </td>
   </tr>
   <tr>
     <td>I provide support and answer feature requests for this plugin exclusively through the forums at <a href="http://premium.wpmudev.org/?ref=prayhumbly-3442">WPMU Dev Premium</a>. If you are not a member, signup using this button and you can post your questions there.</td>
     <td><a href='http://premium.wpmudev.org/?ref=prayhumbly-3442'><img src='http://premium.wpmudev.org/banners/180x60-banner.png' alt='180x60-banner.png' title='Check Out WPMU DEV Premium' /></a></td>
   </tr>
  </table>
</div>
<h3>Help</h3>
<p><strong>Auto Activation</strong><br/>
When auto activation is on for a plugin, newly created blogs will have that plugin activated automatically. This does not affect existing blogs.</p>
<p><strong>User Control</strong><br/>
<?php if ($supporter) { ?>
Choose if all users, supporters only, or no one will be able to activate/deactivate the plugin through the <cite>Plugins</cite> menu. When you turn it off, users that have the plugin activated are grandfathered in, and will continue to have access until they deactivate it.
<?php } else { ?>
When user control is enabled for a plugin, all users will be able to activate/deactivate the plugin through the <cite>Plugins</cite> menu. When you turn it off, users that have the plugin activated are grandfathered in, and will continue to have access until they deactivate it.
<?php } ?>
</p>
<p><strong>Mass Activation/Deactivation</strong><br/>
Mass activate and Mass deactivate buttons activate/deactivates the specified plugin for all blogs. This is different than the "Activate All" option on the WPMU plugins page, as users can later disable it and this only affects existing blogs. It also ignores the User Control option.</p>
<form action="wpmu-admin.php?page=plugin-management&saved=1" method="post">
<table class="widefat">
  <thead>
	<tr>
		<th>Name</th>
		<th>Version</th>
		<th>Author</th>
		<th title="Users may activate/deactivate">User Control</th>
		<th>Mass Activate</th>
		<th>Mass Deactivate</th>
	</tr>
	</thead>
<?php

$plugins = get_plugins(); 
$auto_activate = explode(',',get_site_option('mp_pm_auto_activate_list'));
$user_control = explode(',',get_site_option('mp_pm_user_control_list'));
$supporter_control = explode(',',get_site_option('mp_pm_supporter_control_list'));
foreach($plugins as $file=>$p)
{
?>
	<tr>
		<td><?php echo $p['Name']?></td>
		<td><?php echo $p['Version']?></td>
		<td><?php echo $p['Author']?></td>
		<td style="text-align:center;">
		<?php 
		  echo '<select name="control['.$file.']" />'."\n";
			$u_checked = in_array($file, $user_control);
			$s_checked = in_array($file, $supporter_control);
      $auto_checked = in_array($file, $auto_activate);
      
			if ($u_checked) {
				$n_opt = '';
				$s_opt = '';
				$a_opt = ' selected="yes"';
				$auto_opt = '';
			} else if ($s_checked) {
				$n_opt = '';
				$s_opt = ' selected="yes"';
				$a_opt = '';
				$auto_opt = '';
			} else if ($auto_checked) {
				$n_opt = '';
				$s_opt = '';
				$a_opt = '';
				$auto_opt = ' selected="yes"';
			}else {
				$n_opt = ' selected="yes"';
				$s_opt = '';
				$a_opt = '';
				$auto_opt = '';
 			}
 			
 			$opts = '<option value="none"'.$n_opt.'>None</option>'."\n";
			if ($supporter)
				$opts .= '<option value="supporters"'.$s_opt.'>Supporters</option>'."\n";
			$opts .= '<option value="all"'.$a_opt.'>All Users</option>'."\n";
			$opts .= '<option value="auto"'.$auto_opt.'>Auto-Activate (All Users)</option>'."\n";
			
			echo $opts.'</select>';
		?>
		</td>
		<td><?php echo "<a href='".PC_CMD_BASE."&mass_activate=$file'>Activate All</a>" ?></td>
		<td><?php echo "<a href='".PC_CMD_BASE."&mass_deactivate=$file'>Deactivate All</a>" ?></td>
	</tr>
<?php
}
?>
</table>
<p class="submit">
  <input name="Submit" value="<?php _e('Update Options') ?>" type="submit">
</p>
</form>
</div>
<?php
} //end mp_pm_page()


function mp_pm_process_form() {

	if (isset($_GET['mass_activate'])) {
		$plugins = get_plugins();
		$plugin = $_GET['mass_activate'];
		mp_pm_mass_activate($plugin);
	}
	if (isset($_GET['mass_deactivate'])) {
		$plugins = get_plugins();
		$plugin = $_GET['mass_deactivate'];
		mp_pm_mass_deactivate($plugin);
	}
	
	if (isset($_POST['control'])) {
	  //create blank arrays
    $supporter_control = array();
    $user_control = array();
    $auto_activate = array();		
  	foreach ($_POST['control'] as $plugin => $value) {
  	  if ($value == 'none') {
  		  //do nothing
      }	else if ($value == 'supporters') {
        $supporter_control[] = $plugin;
      }	else if ($value == 'all') {
        $user_control[] = $plugin;
      }	else if ($value == 'auto') {
        $auto_activate[] = $plugin;
      }
  	}  		
    update_site_option('mp_pm_supporter_control_list',implode(',',array_unique($supporter_control)));
  	update_site_option('mp_pm_user_control_list',implode(',',array_unique($user_control)));
  	update_site_option('mp_pm_auto_activate_list',implode(',',array_unique($auto_activate)));
  	
  	//can't save blank value via update_site_option
    if (!$supporter_control)
      update_site_option('mp_pm_supporter_control_list','EMPTY');
    if (!$user_control)
      update_site_option('mp_pm_user_control_list','EMPTY');
    if (!$auto_activate)
      update_site_option('mp_pm_auto_activate_list','EMPTY');
  }
}


///////activation functions (thanks plugin commander!)
function mp_pm_new_blog($new_blog_id) {
	// a work around wpmu bug (http://trac.mu.wordpress.org/ticket/497)
	global $wpdb;
	if (!isset($wpdb->siteid)) $wpdb->siteid = 1;
	$auto_activate_list = get_site_option('mp_pm_auto_activate_list');
	$auto_activate = explode(',',$auto_activate_list);
	foreach($auto_activate as $plugin) {
		mp_pm_activate_plugin($new_blog_id, $plugin);
	}
}

function mp_pm_activate_plugin($blog_id, $plugin) {
	if (empty($plugin)) return;
	if (validate_file($plugin)) return;
	if (!file_exists(ABSPATH . PLUGINDIR . '/' . $plugin)) return;
	switch_to_blog($blog_id);
	$current = get_option('active_plugins');
	ob_start();
	include_once(ABSPATH . PLUGINDIR . '/' . $plugin);
	$current[] = $plugin;
	sort($current);
	update_option('active_plugins', $current);
	do_action('activate_' . $plugin);
	$res = ob_get_clean();
	if (!empty($res)) echo __("Error activating $plugin for blog id=$blog_id: $res<br/>");
	restore_current_blog();
}

function mp_pm_deactivate_plugin($blog_id, $plugin) {
	if (empty($plugin)) return;
	if (validate_file($plugin)) return;
	if (!file_exists(ABSPATH . PLUGINDIR . '/' . $plugin)) return;

	switch_to_blog($blog_id);
	$current = get_option('active_plugins');
	array_splice($current, array_search($plugin, $current), 1 ); // Array-fu!
	update_option('active_plugins', $current);
	ob_start();
	do_action('deactivate_'.$plugin);
	$res = ob_get_clean();
	if (!empty($res)) echo "Error deactivating $plugin for blog id=$blog_id: $res<br/>";
	restore_current_blog();
}

function mp_pm_mass_activate($plugin) {
	global $wpdb;
	$res = $wpdb->get_results("select blog_id from wp_blogs");
	if ($res === false) 
	{
		echo "Failed to mass activate $plugin : error selecting blogs";
		return;
	}

	foreach($res as $r)
	{
		mp_pm_activate_plugin($r->blog_id, $plugin);
	}
}

function mp_pm_mass_deactivate($plugin) {
	global $wpdb;
	$res = $wpdb->get_results("select blog_id from wp_blogs");
	if ($res === false) 
	{
		echo "Failed to mass deactivate $plugin : error selecting blogs";
		return;
	}

	foreach($res as $r)
	{
		mp_pm_deactivate_plugin($r->blog_id, $plugin);
	}
}

//remove plugins with no user control
function mp_pm_remove_plugins($all_plugins) {
  if (is_site_admin()) //don't filter siteadmin
    return $all_plugins;
  
  $auto_activate = explode(',',get_site_option('mp_pm_auto_activate_list'));
  $user_control = explode(',',get_site_option('mp_pm_user_control_list'));
  $supporter_control = explode(',',get_site_option('mp_pm_supporter_control_list'));
  
  foreach ( (array)$all_plugins as $plugin_file => $plugin_data) {
    if (in_array($plugin_file, $user_control) || in_array($plugin_file, $auto_activate) || in_array($plugin_file, $supporter_control)) {
      //do nothing - leave it in
    } else {
      unset($all_plugins[$plugin_file]); //remove plugin
    }
  }
  return $all_plugins;
}

//plugin activate links
function mp_pm_action_links($action_links, $plugin_file, $plugin_data, $context) {
  global $supporter;
  if (is_site_admin()) //don't filter siteadmin
    return $action_links;
  
  $auto_activate = explode(',',get_site_option('mp_pm_auto_activate_list'));
  $user_control = explode(',',get_site_option('mp_pm_user_control_list'));
  $supporter_control = explode(',',get_site_option('mp_pm_supporter_control_list'));
  if ($context != 'active') {
    if (in_array($plugin_file, $user_control) || in_array($plugin_file, $auto_activate)) {
      return $action_links;
    } else if (in_array($plugin_file, $supporter_control)) {
      if ($supporter) {
        if (is_supporter()) {
          return $action_links;
        } else {
          add_action( "after_plugin_row_$plugin_file", "mp_pm_remove_checks" ); //add action to disable row's checkbox
          return array('<a style="color:red;" href="./supporter.php">Supporters Only</a>');
        }
      }
    }
  }
  return $action_links;
}

//show supporter message if plugin exists
function mp_pm_supporter_message() {
  global $supporter;
  if (is_site_admin()) //don't filter siteadmin
    return; // $action_links; 2.7.1
  
  if ($supporter && substr( $_SERVER["PHP_SELF"], -11 ) == 'plugins.php') {
    if (!is_supporter()) {
   		echo '<div class="error fade"><p style="font-weight:bold;padding:10px;">Premium plugins are only available to '.get_site_option('site_name').' Supporters. <a title="Become a Supporter" href="./supporter.php">Why not become a Supporter today?</a></p></div>';
  	} else {
      echo '<div class="error" style="background-color:#F9F9F9;border:0;font-weight:bold;"><p>As a '.get_site_option('site_name')." Supporter, you now have access to all our premium plugins!</p></div>";
    }
	}

	return;
}

//use jquery to remove associated checkboxes to prevent mass activation (usability, not security)
function mp_pm_remove_checks($plugin_file) {
  echo '
<script type="text/javascript">
';
  echo "  jQuery(\"input:checkbox[value='".attribute_escape($plugin_file)."']\").remove();\n";
  echo '
</script>
'; 
}

/*
Removes activated plugins that should not have been activated (multi). Single activations
are additionaly protected by a nonce field. Dirty hack in case someone uses firebug or 
something to hack the post and simulate a bulk activation. I'd rather prevent
them from being activated in the first place, but there are no hooks for that! The 
display will show the activated status, but really they are not. Only hacking attempts
will see this though! */
function mp_pm_check_activated($active_plugins) {
  global $supporter, $_GET;
  if (is_site_admin()) //don't filter siteadmin
    return $active_plugins;
  
  //only perform check right after activation hack attempt
  if (!isset($_GET['activate-multi']))
    return $active_plugins;
  
  $auto_activate = explode(',',get_site_option('mp_pm_auto_activate_list'));
  $user_control = explode(',',get_site_option('mp_pm_user_control_list'));
  $supporter_control = explode(',',get_site_option('mp_pm_supporter_control_list'));
  
  foreach ( (array)$active_plugins as $plugin_file => $plugin_data) {
    if (in_array($plugin_file, $user_control) || in_array($plugin_file, $auto_activate) || in_array($plugin_file, $supporter_control)) {
      //do nothing - leave it in
    } else {
      deactivate_plugins($plugin_file, true); //silently remove any plugins
      unset($active_plugins[$plugin_file]);
    }
  } 
  
  if ($supporter) {
    if (count($supporter_control) && !is_supporter()) {
      deactivate_plugins($supporter_control, true); //silently remove any plugins
      foreach ($supporter_control as $plugin_file)
        unset($active_plugins[$plugin_file]);
    }
  }
  
  return $active_plugins;
}
?>