<?php
/*
Plugin Name: Global Header - WPMU
Plugin URI: http://wpmudev.org/project/global-header
Description: Add a Global Header to your WPMU install
Author: Hiranthi Molhoek-Herlaar (illutic WebDesign)
Version: 1.7
Author URI: http://www.illutic.nl
*/ 

/*
	CHANGELOG
	
	v1.0 - 06/21/2009
	First version of the plugin: add HTML/CSS for your global header, including the possibility of enabling/disabling the plugin from your backend (for every site and for mainblog only).
	
	v1.1 - 06/21/2009
	Added the same abilities for a global footer (by request of Ovidiu).
	
	v1.2 - 06/21/2009
	Added the possibility of adding PHP code to both header and footer.
	Merged the globalheader_html/globalheader_html_footer and globalheader_css/globalheader_css_footer functions.
	Added the functionality of adding blogIDs where you don't want the global header/footer enabled.
	
	v1.2.1 - 06/21/2009
	Small bugfix (removed add_action for globalheader_html_footer and globalheader_css_footer).
	
	v1.3 - 06/21/2009
	Added Supporter (WPMUDEV Premium plugin) support.
	
	v1.3.1 - 06/30/2009
	CSS bugfix for the header-part.
	
	v1.4 - 06/30/2009
	A few bugfixes.
	Changed looks in admin-page.
	Added the functionality of enabling the header/footer for supporters only (if Premium Supporters plugin is available).
	
	v1.5 - 06/30/2009
	Added labels to the headers all form-fields
	Added a 'revert to default settings' option
	
	v1.6 - 07/22/2009
	Added stripslashes() to output on blog
	
	v1.7 - 07/23/2009
	Added stripslashes() to saving to DB (for those that are still having problems with slashes saved into their DB)
	
*/

/**************************************************************
	Hooks
**************************************************************/
add_action('admin_menu',	'globalheader_admin_menu');
add_action('wp_footer',		'globalheader_html');
add_action('wp_head',		'globalheader_css');


/**************************************************************
	Functions
**************************************************************/
load_muplugin_textdomain('globalheader');

/*
add subpage to site admin menu
*/
function globalheader_admin_menu()
{
	global $wpdb, $wp_roles, $current_user;
	add_submenu_page('wpmu-admin.php', __('Global Header', 'globalheader'), __('Global Header', 'globalheader'), 10, 'global-header', 'globalheader_output');
} // adp_admin_menu

/*
output for admin page
*/
function globalheader_output()
{
	global $wpdb;
	
	if( !current_user_can('edit_users') )
	{
		echo "<p>" . __('Nice Try...', 'globalheader') . "</p>";  // If accessed properly, this message doesn't appear.
		return;
	}
	if (isset($_GET['updated'])) {
		?><div id="message" class="updated fade"><p><?php _e('' . urldecode($_GET['updatedmsg']) . '') ?></p></div><?php
	}
	
	echo '<div class="wrap">';
	switch ( strtolower( $_GET['action'] ) )
	{
		
		/* DEFAULT CASE */
		case '':
		default:
		?>
        <h2><?php _e('Settings for the Global Header plugin', 'globalheader') ?></h2>
        <p><?php _e('This plugin was initially meant to add a global header to your WPMU website. Since a global footer was a requested feature, this was added too. But don\'t let the Global header/footer parts on this page keep you down. Because you could easily use it for other purposes (double headers, double footers, etc.).', 'globalheader') ?></p>
        
        <form method="post" action="wpmu-admin.php?page=global-header&action=process">
            <table class="widefat">
            <thead>
            <tr>
            	<th colspan="2"><?php _e('Global header settings', 'globalheader') ?></th>
            </tr>
            </thead>
            <tbody>
            <tr valign="top"> 
                <th scope="row"><label for="globalheader_enabled"><?php _e('Enable the header', 'globalheader') ?></label></th> 
                <td><input type="checkbox" name="globalheader_enabled" id="globalheader_enabled" value="on"<?php echo ( get_site_option('globalheader_enabled') == 'on' ) ? ' checked="checked"' : ''; ?> />
                	<br /><small><?php _e('Check to enable the global header.', 'globalheader') ?></small></td> 
            </tr>
            <tr valign="top"> 
                <th scope="row"><label for="globalheader_mainsite_enabled"><?php _e('Enable the header on the main site', 'globalheader') ?></label></th> 
                <td><input type="checkbox" name="globalheader_mainsite_enabled" id="globalheader_mainsite_enabled" value="on"<?php echo ( get_site_option('globalheader_mainsite_enabled') == 'on' ) ? ' checked="checked"' : ''; ?> />
                	<br /><small><?php _e('Check to enable the global header on the mainblog too (disabled by default).', 'globalheader') ?></small></td> 
            </tr>
            <?php
			if ( function_exists( 'supporter_check' ) ) // supporter_check exists
			{
			?>
			<tr valign="top">
				<th scope="row"><label for="globalheader_supporters_enabled"><?php _e('Enable header for Supporters', 'globalheader') ?></label></th> 
				<td><input type="checkbox" name="globalheader_supporters_enabled" id="globalheader_supporters_enabled" value="on"<?php echo ( get_site_option('globalheader_supporters_enabled') != 'off' ) ? ' checked="checked"' : ''; ?> />
                	<br /><small><?php _e('Check to enable the global header on Supporter blogs (enabled by default).', 'globalheader') ?></small></td> 
			</tr>
			<tr valign="top">
				<th scope="row"><label for="globalheader_supportersonly_enabled"><?php _e('Make this header SUPPORTERS ONLY', 'globalheader') ?></label></th> 
				<td><input type="checkbox" name="globalheader_supportersonly_enabled" id="globalheader_supportersonly_enabled" value="on"<?php echo ( get_site_option('globalheader_supportersonly_enabled') == 'on' ) ? ' checked="checked"' : ''; ?> />
                	<br /><small><?php _e('Check to enable the global header on Supporter blogs only (disabled by default, only works if the header is enabled for supporters).', 'globalheader') ?></small></td>
			</tr>
			<?php
			} // end if ptb
			?>
            <tr valign="top"> 
                <th scope="row"><label for="globalheader_php_enabled"><?php _e('Enable executing PHP in the header', 'globalheader') ?></label></th> 
                <td><input type="checkbox" name="globalheader_php_enabled" id="globalheader_php_enabled" value="on"<?php echo ( get_site_option('globalheader_php_enabled') == 'on' ) ? ' checked="checked"' : ''; ?> />
                	<br /><small><?php _e('Check to enable the possibility of using PHP in your header HTML (disabled by default).', 'globalheader') ?></small></td> 
            </tr>
            <tr valign="top"> 
                <th scope="row"><label for="globalheader_html"><?php _e('HTML to add', 'globalheader') ?></label></th> 
                <td><textarea name="globalheader_html" id="globalheader_html" style="width:100%" rows="8"><?php if ( get_site_option('globalheader_html') ) { echo stripslashes( get_site_option('globalheader_html') ); } else { ?><div id="global-header"><a href="%SITEURL%">%SITETITLE%</a></div><?php } ?></textarea>
                	<br /><small><?php _e('The HTML that will be added to every blog (will be placed in the footer). %SITEURL% will be replaced with the URL of the mainblog, %SITETITLE% by its title.', 'globalheader') ?></small></td> 
            </tr>
            <tr valign="top"> 
                <th scope="row"><label for="globalheader_css"><?php _e('CSS', 'globalheader') ?></label></th> 
                <td><textarea name="globalheader_css" id="globalheader_css" style="width:100%" rows="8"><?php if ( get_site_option('globalheader_css') ) { echo stripslashes( get_site_option('globalheader_css') ); } else { ?>body { margin:30px 0 0; position:relative; }
#global-header { position:absolute; top:-30px; left:0; background-color:#000; width:100%; height:30px; display:block; }
#global-header a { color:#fff; padding:5px; }<?php } ?></textarea>
                	<br /><small><?php _e('Use CSS to place the HTML to the top of the page.', 'globalheader') ?></small></td> 
            </tr>
            <tr valign="top"> 
                <th scope="row"><label for="globalheader_excludeblogs"><?php _e('Exclude blogs', 'globalheader') ?></label></th> 
                <td><input type="text" name="globalheader_excludeblogs" id="globalheader_excludeblogs" style="width:100%" value="<?php if ( get_site_option('globalheader_excludeblogs') ) { echo stripslashes( get_site_option('globalheader_excludeblogs') ); } ?>" />
                	<br /><small><?php _e('Blogs that you don\'t want to have the global header on. Seperate blogIDs with a comma (ie: 2,3).', 'globalheader') ?></small></td> 
            </tr>
            </tbody>
            </table>
            
            <p>&nbsp;</p>
            <?php /***************************************************************************************************************/ ?>
            
            <table class="widefat">
            <thead>
            <tr>
            	<th colspan="2"><?php _e('Global footer settings','globalheader'); ?></th>
            </tr>
            </thead>
            <tbody>
            <tr valign="top"> 
                <th scope="row"><label for="globalheader_enabled_footer"><?php _e('Enable the footer', 'globalheader') ?></label></th> 
                <td><input type="checkbox" name="globalheader_enabled_footer" id="globalheader_enabled_footer" value="on"<?php echo ( get_site_option('globalheader_enabled_footer') == 'on' ) ? ' checked="checked"' : ''; ?> />
                	<br /><small><?php _e('Check to enable the global footer.', 'globalheader') ?></small></td> 
            </tr>
            <tr valign="top"> 
                <th scope="row"><label for="globalheader_mainsite_enabled_footer"><?php _e('Enable the footer on the main site', 'globalheader') ?></label></th> 
                <td><input type="checkbox" name="globalheader_mainsite_enabled_footer" id="globalheader_mainsite_enabled_footer" value="on"<?php echo ( get_site_option('globalheader_mainsite_enabled_footer') == 'on' ) ? ' checked="checked"' : ''; ?> />
                	<br /><small><?php _e('Check to enable the global footer on the mainblog too (disabled by default).', 'globalheader') ?></small></td> 
            </tr>
            <?php
			if ( function_exists( 'supporter_check' ) ) // supporter_check exists
			{
			?>
			<tr valign="top">
				<th scope="row"><label for="globalheader_supporters_enabled_footer"><?php _e('Enable footer for Supporters', 'globalheader') ?></label></th> 
				<td><input type="checkbox" name="globalheader_supporters_enabled_footer" id="globalheader_supporters_enabled_footer" value="on"<?php echo ( get_site_option('globalheader_supporters_enabled_footer') != 'off' ) ? ' checked="checked"' : ''; ?> />
                	<br /><small><?php _e('Check to enable the global footer on Supporter blogs (enabled by default).', 'globalheader') ?></small></td> 
			</tr>
			<tr valign="top">
				<th scope="row"><label for="globalheader_supportersonly_enabled_footer"><?php _e('Make this footer SUPPORTERS ONLY', 'globalheader') ?></label></th> 
				<td><input type="checkbox" name="globalheader_supportersonly_enabled_footer" id="globalheader_supportersonly_enabled_footer" value="on"<?php echo ( get_site_option('globalheader_supportersonly_enabled_footer') == 'on' ) ? ' checked="checked"' : ''; ?> />
                	<br /><small><?php _e('Check to enable the global footer on Supporter blogs only (disabled by default, only works if the footer is enabled for supporters).', 'globalheader') ?></small></td>
			</tr>
			<?php
			} // end if ptb
			?>
            <tr valign="top"> 
                <th scope="row"><label for="globalheader_php_enabled_footer"><?php _e('Enable executing PHP in the footer', 'globalheader') ?></label></th> 
                <td><input type="checkbox" name="globalheader_php_enabled_footer" id="globalheader_php_enabled_footer" value="on"<?php echo ( get_site_option('globalheader_php_enabled_footer') == 'on' ) ? ' checked="checked"' : ''; ?> />
                	<br /><small><?php _e('Check to enable the possibility of using PHP in your footer HTML (disabled by default).', 'globalheader') ?></small></td> 
            </tr>
            <tr valign="top"> 
                <th scope="row"><label for="globalheader_html_footer"><?php _e('HTML to add', 'globalheader') ?></label></th> 
                <td><textarea name="globalheader_html_footer" id="globalheader_html_footer" style="width:100%" rows="8"><?php if ( get_site_option('globalheader_html_footer') ) { echo stripslashes( get_site_option('globalheader_html_footer') ); } else { ?><div id="global-footer"><a href="%SITEURL%">%SITETITLE%</a></div><?php } ?></textarea>
                	<br /><small><?php _e('The HTML that will be added to every blog (will be placed in the footer). %SITEURL% will be replaced with the URL of the mainblog, %SITETITLE% by its title.', 'globalheader') ?></small></td> 
            </tr>
            <tr valign="top"> 
                <th scope="row"><label for="globalheader_css_footer"><?php _e('CSS', 'globalheader') ?></label></th> 
                <td><textarea name="globalheader_css_footer" id="globalheader_css_footer" style="width:100%" rows="8"><?php if ( get_site_option('globalheader_css_footer') ) { echo stripslashes( get_site_option('globalheader_css_footer') ); } else { ?>#global-footer { background-color:#000; width:100%; height:30px; display:block; }
#global-footer a { color:#fff; padding:5px; }<?php } ?></textarea>
                	<br /><small><?php _e('Use CSS to place the HTML to the bottom of the page.', 'globalheader') ?></small></td> 
            </tr>
            <tr valign="top"> 
                <th scope="row"><label for="globalheader_excludeblogs_footer"><?php _e('Exclude blogs', 'globalheader') ?></label></th> 
                <td><input type="text" name="globalheader_excludeblogs_footer" id="globalheader_excludeblogs_footer" style="width:100%" value="<?php if ( get_site_option('globalheader_excludeblogs_footer') ) { echo stripslashes( get_site_option('globalheader_excludeblogs_footer') ); } ?>" />
                	<br /><small><?php _e('Blogs that you don\'t want to have the global footer on. Seperate blogIDs with a comma (ie: 2,3).', 'globalheader') ?></small></td> 
            </tr>
            </tbody>
            </table>
            <p class="submit"><input type="submit" name="gh_Submit" class="button-primary" value="<?php _e('Save settings', 'globalheader') ?>" /> <input type="reset" class="button-secondary" value="<?php _e('Reset settings', 'globalheader') ?>" /></p>
        </form>
        
        <br class="clear" />
        
        <form method="post" action="wpmu-admin.php?page=global-header&action=reset">
        <table class="widefat">
        <thead>
        <tr>
        	<th><?php _e('Revert to default settings', 'globalheader') ?></th>
        </tr>
        </thead>
        <tbody>
        <tr>
        	<td><label for="globalheader_default_settings"><input type="checkbox" name="globalheader_default_settings" id="globalheader_default_settings" value="1" /> <?php _e('Check this to revert to the default settings in case of emergency.', 'globalheader') ?></label>
            	<br /><small><?php _e('Use wisely, this cannot be undone!', 'globalheader') ?></small></td>
        </tr>
        </tbody>
        </table>
        <p class="submit"><input type="submit" name="reset_Submit" class="button-primary" value="<?php _e('Revert to default settings', 'globalheader') ?>" /></p>
        </form>
        <?php
		break;
		//---------------------------------------------------//
		case "process":
		
			if ( isset($_POST['gh_Submit']) )
			{
				if ( isset($_POST['globalheader_enabled']) ) { update_site_option( 'globalheader_enabled', $_POST['globalheader_enabled'] ); } else { update_site_option( 'globalheader_enabled', 'off' ); }
				if ( isset($_POST['globalheader_mainsite_enabled']) ) { update_site_option( 'globalheader_mainsite_enabled', $_POST['globalheader_mainsite_enabled'] ); } else { update_site_option( 'globalheader_mainsite_enabled', 'off' ); }
				if ( isset($_POST['globalheader_php_enabled']) ) { update_site_option( 'globalheader_php_enabled', $_POST['globalheader_php_enabled'] ); } else { update_site_option( 'globalheader_php_enabled', 'off' ); }
				if ( isset($_POST['globalheader_supporters_enabled']) ) { update_site_option( 'globalheader_supporters_enabled', $_POST['globalheader_supporters_enabled'] ); } else { update_site_option( 'globalheader_supporters_enabled', 'off' ); }
				if ( isset($_POST['globalheader_supportersonly_enabled']) ) { update_site_option( 'globalheader_supportersonly_enabled', $_POST['globalheader_supportersonly_enabled'] ); } else { update_site_option( 'globalheader_supportersonly_enabled', 'off' ); }
				
				update_site_option( 'globalheader_excludeblogs',	$_POST['globalheader_excludeblogs'] );
				update_site_option( 'globalheader_html',			stripslashes($_POST['globalheader_html']) );
				update_site_option( 'globalheader_css',				stripslashes($_POST['globalheader_css']) );
				
				
				if ( isset($_POST['globalheader_enabled_footer']) ) { update_site_option( 'globalheader_enabled_footer', $_POST['globalheader_enabled_footer'] ); } else { update_site_option( 'globalheader_enabled_footer', 'off' ); }
				if ( isset($_POST['globalheader_mainsite_enabled_footer']) ) { update_site_option( 'globalheader_mainsite_enabled_footer', $_POST['globalheader_mainsite_enabled_footer'] ); } else { update_site_option( 'globalheader_mainsite_enabled_footer', 'off' ); }
				if ( isset($_POST['globalheader_php_enabled_footer']) ) { update_site_option( 'globalheader_php_enabled_footer', $_POST['globalheader_php_enabled_footer'] ); } else { update_site_option( 'globalheader_php_enabled_footer', 'off' ); }
				if ( isset($_POST['globalheader_supporters_enabled_footer']) ) { update_site_option( 'globalheader_supporters_enabled_footer', $_POST['globalheader_supporters_enabled_footer'] ); } else { update_site_option( 'globalheader_supporters_enabled_footer', 'off' ); }
				if ( isset($_POST['globalheader_supportersonly_enabled_footer']) ) { update_site_option( 'globalheader_supportersonly_enabled_footer', $_POST['globalheader_supportersonly_enabled_footer'] ); } else { update_site_option( 'globalheader_supportersonly_enabled_footer', 'off' ); }
				
				update_site_option( 'globalheader_excludeblogs_footer', $_POST['globalheader_excludeblogs_footer'] );
				update_site_option( 'globalheader_html_footer',			stripslashes($_POST['globalheader_html_footer']) );
				update_site_option( 'globalheader_css_footer',			stripslashes($_POST['globalheader_css_footer']) );
				
				echo '
				<script language="javascript">
				window.location="wpmu-admin.php?page=global-header&updated=true&updatedmsg=' . urlencode(__('Changes saved.', 'globalheader')) . '";
				</script>
				';
			}
			else
			{
				echo '
				<script language="javascript">
				window.location="wpmu-admin.php?page=global-header";
				</script>
				';
			}
			
		break;
		//---------------------------------------------------//
		case "reset":
		
			if ( isset($_POST['reset_Submit']) && $_POST['globalheader_default_settings'] == 1 )
			{
				update_site_option( 'globalheader_enabled', 'off' );
				update_site_option( 'globalheader_mainsite_enabled', 'off' );
				update_site_option( 'globalheader_php_enabled', 'off' );
				update_site_option( 'globalheader_supporters_enabled', 'on' );
				update_site_option( 'globalheader_supportersonly_enabled', 'off' );
				update_site_option( 'globalheader_excludeblogs', '' );
				update_site_option( 'globalheader_html', '<div id="global-header"><a href="%SITEURL%">%SITETITLE%</a></div>' );
				update_site_option( 'globalheader_css', 'body { margin:30px 0 0; position:relative; }
#global-header { position:absolute; top:-30px; left:0; background-color:#000; width:100%; height:30px; display:block; }
#global-header a { color:#fff; padding:5px; }' );
				
				update_site_option( 'globalheader_enabled_footer', 'off' );
				update_site_option( 'globalheader_mainsite_enabled_footer', 'off' );
				update_site_option( 'globalheader_php_enabled_footer', 'off' );
				update_site_option( 'globalheader_supporters_enabled_footer', 'on' );
				update_site_option( 'globalheader_supportersonly_enabled_footer', 'off' );
				update_site_option( 'globalheader_excludeblogs_footer', '' );
				update_site_option( 'globalheader_html_footer', '<div id="global-footer"><a href="%SITEURL%">%SITETITLE%</a></div>' );
				update_site_option( 'globalheader_css_footer', '#global-footer { background-color:#000; width:100%; height:30px; display:block; }
#global-footer a { color:#fff; padding:5px; }' );
				
				echo '
				<script language="javascript">
				window.location="wpmu-admin.php?page=global-header&updated=true&updatedmsg=' . urlencode(__('Settings are back to default.', 'globalheader')) . '";
				</script>
				';
			}
			else
			{
				echo '
				<script language="javascript">
				window.location="wpmu-admin.php?page=global-header";
				</script>
				';
			}
			
		break;
		//---------------------------------------------------//
	}
	echo '</div>';
} // end globalheader_output


function globalheader_html()
{
	global $blog_id;
	$excludeblogs_header = explode(',', get_site_option('globalheader_excludeblogs'));
	$excludeblogs_footer = explode(',', get_site_option('globalheader_excludeblogs_footer'));
	
	$is_supporter		= false; // set to false by default for when Supporters plugin is not available
	$is_supporter_only	= false; // set to false by default for when Supporters plugin is not available
	$is_supporter_only_footer = false; // set to false by default for when Supporters plugin is not available
	$supp_header		= true; // set to true by default for when Supporters plugin is not available
	$supp_footer		= true; // set to true by default for when Supporters plugin is not available
	
	if ( function_exists( 'supporter_check' ) ) // when the Supporters plugin IS available
	{
		$is_supporter = is_supporter($blog_id);
		$is_supporter_only = (( get_site_option('globalheader_supportersonly_enabled') == 'off' ) ? false : true );
		$is_supporter_only_footer = (( get_site_option('globalheader_supportersonly_enabled_footer') == 'off' ) ? false : true );
		$supp_header = (( get_site_option('globalheader_supporters_enabled') == 'off' ) ? false : true );
		$supp_footer = (( get_site_option('globalheader_supporters_enabled_footer') == 'off' ) ? false : true );
	}
	
	/* header */
	if ( ( get_site_option('globalheader_enabled') == 'on' ) ) // header is enabled
	{
		if ( $is_supporter == true && $is_supporter_only == true && $supp_header == true )
		{
			$globalheader = get_site_option('globalheader_html');
			$globalheader = str_replace( '%SITEURL%', get_blogaddress_by_id( 1 ), $globalheader);
			$globalheader = str_replace( '%SITETITLE%', get_blog_option( 1, 'blogname' ), $globalheader);
			
			echo (( get_site_option('globalheader_php_enabled') == 'on' ) ? execute_php( $globalheader ) : $globalheader )."\n";
		}
		elseif ( $is_supporter_only == false )
		{
			if ( $is_supporter == false || ( $is_supporter == true && $supp_header == true ) ) // not a supporter or footer is enabled for supporters
			{
				if (( ( $blog_id != 1 ) || (( $blog_id == 1 ) && ( get_site_option('globalheader_mainsite_enabled') == 'on' )) ) && ( !in_array( $blog_id, $excludeblogs_header) ) )
				{
					$globalheader = get_site_option('globalheader_html');
					$globalheader = str_replace( '%SITEURL%', get_blogaddress_by_id( 1 ), $globalheader);
					$globalheader = str_replace( '%SITETITLE%', get_blog_option( 1, 'blogname' ), $globalheader);
					
					echo (( get_site_option('globalheader_php_enabled') == 'on' ) ? execute_php( $globalheader ) : $globalheader )."\n";
				}
			}
		}
	}
	/* footer */
	if ( ( get_site_option('globalheader_enabled_footer') == 'on' ) ) // footer is enabled
	{
		if ( $is_supporter == true && $is_supporter_only_footer == true && $supp_footer == true )
		{
			$globalfooter = get_site_option('globalheader_html_footer');
			$globalfooter = str_replace( '%SITEURL%', get_blogaddress_by_id( 1 ), $globalfooter);
			$globalfooter = str_replace( '%SITETITLE%', get_blog_option( 1, 'blogname' ), $globalfooter);
			
			echo (( get_site_option('globalheader_php_enabled_footer') == 'on' ) ? execute_php( $globalfooter ) : $globalfooter )."\n";
		}
		elseif ( $is_supporter_only_footer == false )
		{
			if ( $is_supporter == false || ( $is_supporter == true && $supp_footer == true ) ) // not a supporter or footer is enabled for supporters
			{
				if (( ( $blog_id != 1 ) || (( $blog_id == 1 ) && ( get_site_option('globalheader_mainsite_enabled_footer') == 'on' )) ) && ( !in_array( $blog_id, $excludeblogs_footer) ) )
				{
					$globalfooter = get_site_option('globalheader_html_footer');
					$globalfooter = str_replace( '%SITEURL%', get_blogaddress_by_id( 1 ), $globalfooter);
					$globalfooter = str_replace( '%SITETITLE%', get_blog_option( 1, 'blogname' ), $globalfooter);
					
					echo '<!-- generated by Global Header -->'."\n".(( get_site_option('globalheader_php_enabled_footer') == 'on' ) ? execute_php( stripslashes($globalfooter) ) : stripslashes($globalfooter) )."\n".'<!-- / generated by Global Header -->'."\n";
				}
			}
		}
	}
} // end globalheader_html

function globalheader_css()
{
	global $blog_id;
	$excludeblogs_header = explode(',', get_site_option('globalheader_excludeblogs'));
	$excludeblogs_footer = explode(',', get_site_option('globalheader_excludeblogs_footer'));
	
	$css = '';
	
	$is_supporter		= false; // set to false by default for when Supporters plugin is not available
	$is_supporter_only	= false; // set to false by default for when Supporters plugin is not available
	$is_supporter_only_footer = false; // set to false by default for when Supporters plugin is not available
	$supp_header		= true; // set to true by default for when Supporters plugin is not available
	$supp_footer		= true; // set to true by default for when Supporters plugin is not available
	
	if ( function_exists( 'supporter_check' ) ) // when the Supporters plugin IS available
	{
		$is_supporter = is_supporter($blog_id); // whether the blog is a Supporter blog or not
		$is_supporter_only = (( get_site_option('globalheader_supportersonly_enabled') == 'off' ) ? false : true );
		$is_supporter_only_footer = (( get_site_option('globalheader_supportersonly_enabled_footer') == 'off' ) ? false : true );
		$supp_header = (( get_site_option('globalheader_supporters_enabled') == 'off' ) ? false : true );
		$supp_footer = (( get_site_option('globalheader_supporters_enabled_footer') == 'off' ) ? false : true );
	}
	
	/* header */
	if ( ( get_site_option('globalheader_enabled') == 'on' ) ) // header is enabled
	{
		if ( $is_supporter == true && $is_supporter_only == true && $supp_header == true )
		{
			$css .= get_site_option('globalheader_css')."\n";
		}
		elseif ( $is_supporter_only == false )
		{
			if ( $is_supporter == false || ( $is_supporter == true && $supp_header == true ) ) // not a supporter or header is enabled for supporters
			{
				if (( ( $blog_id != 1 ) || (( $blog_id == 1 ) && ( get_site_option('globalheader_mainsite_enabled') == 'on' )) ) && ( !in_array( $blog_id, $excludeblogs_header) ) )
				{
					$css .= get_site_option('globalheader_css')."\n";
				}
			}
		}
	}
	/* footer */
	if ( ( get_site_option('globalheader_enabled_footer') == 'on' ) ) // footer is enabled
	{
		if ( $is_supporter == true && $is_supporter_only_footer == true && $supp_footer == true )
		{
			$css .= get_site_option('globalheader_css_footer')."\n";
		}
		elseif ( $is_supporter_only_footer == false )
		{
			if ( $is_supporter == false || ( $is_supporter == true && $supp_footer == true ) ) // not a supporter or header is enabled for supporters
			{	
				if (( ( $blog_id != 1 ) || (( $blog_id == 1 ) && ( get_site_option('globalheader_mainsite_enabled_footer') == 'on' )) ) && ( !in_array( $blog_id, $excludeblogs_footer) ) )
				{				
					$css .= get_site_option('globalheader_css_footer')."\n";
				}
			}
		}
	}
	
	echo ( ( $css != '' ) ? '<!-- generated by Global Header -->'."\n".'<style type="text/css">'."\n".stripslashes($css)."\n".'</style>'."\n".'<!-- / generated by Global Header -->'."\n" : '');
} // end globalheader_css

if ( !function_exists('execute_php') )
{
	function execute_php( $content )
	{
		ob_start();
		eval("?>$content<?php ");
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}
} // execute_php

?>
