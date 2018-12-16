<?php
/*
Plugin Name: Additional Privacy
Plugin URI: 
Description:
Author: Andrew Billits (Incsub)
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

//------------------------------------------------------------------------//
//---Config---------------------------------------------------------------//
//------------------------------------------------------------------------//

//------------------------------------------------------------------------//
//---Hook-----------------------------------------------------------------//
//------------------------------------------------------------------------//
add_action('wpmu_options', 'additional_privacy_site_admin_options');
add_action('update_wpmu_options', 'additional_privacy_site_admin_options_process');
add_action("blog_privacy_selector", 'additional_privacy_blog_options');
add_action('admin_menu', 'additional_privacy_modify_menu_items',99);
add_action('wpmu_new_blog', 'additional_privacy_set_default', 100, 2);
add_action('init', 'additional_privacy');
add_action("login_form", 'additional_privacy_login_message');
//------------------------------------------------------------------------//
//---Functions------------------------------------------------------------//
//------------------------------------------------------------------------//

function additional_privacy() {
	$privacy = get_option('blog_public');
	if ( is_numeric($privacy) && $privacy < 0 && !stristr($_SERVER['REQUEST_URI'], 'wp-activate') && !stristr($_SERVER['REQUEST_URI'], 'wp-signup') && !stristr($_SERVER['REQUEST_URI'], 'wp-login') && !stristr($_SERVER['REQUEST_URI'], 'wp-admin') ) {
		if ( $privacy == '-1' ) {
			if ( !is_user_logged_in() ) {
				//header("Location: " . get_option('siteurl') . "wp-login.php?privacy=1&redirect_to=" . urlencode($_SERVER['REQUEST_URI']));
				wp_redirect(get_option('home') . "/wp-login.php?privacy=1&redirect_to=" . urlencode($_SERVER['REQUEST_URI']));
				exit();
			}
		} else if ( $privacy == '-2' ) {
			if ( !is_user_logged_in() ) {
				//header("Location: " . get_option('siteurl') . "wp-login.php?privacy=2&redirect_to=" . urlencode($_SERVER['REQUEST_URI']));
				wp_redirect(get_option('home') . "/wp-login.php?privacy=2&redirect_to=" . urlencode($_SERVER['REQUEST_URI']));
				exit();
			} else {
				if ( !current_user_can('read') ) {
					additional_privacy_deny_message('2');
				}
			}
		} else if ( $privacy == '-3' ) {
			if ( !is_user_logged_in() ) {
				//header("Location: " . get_option('siteurl') . "wp-login.php?privacy=3&redirect_to=" . urlencode($_SERVER['REQUEST_URI']));
				wp_redirect(get_option('home') . "/wp-login.php?privacy=3&redirect_to=" . urlencode($_SERVER['REQUEST_URI']));
				exit();
			} else {
				if ( !current_user_can('manage_options') ) {
					additional_privacy_deny_message('3');
				}
			}
		}
	}
}

function additional_privacy_set_default($blog_id, $user_id) {
	global $wpdb;
	$privacy_default = get_site_option('privacy_default', 1);
	update_blog_option($blog_id, "blog_public", $privacy_default);
	$wpdb->query("UPDATE $wpdb->blogs SET public = '". $privacy_default ."' WHERE blog_id = '". $blog_id ."' LIMIT 1");
}

function additional_privacy_site_admin_options_process() {
	global $wpdb;
	update_site_option( 'privacy_default' , $_POST['privacy_default']);
	update_site_option( 'privacy_override' , $_POST['privacy_override']);
	if (  $_POST['privacy_update_all_blogs'] == 'update' )  {
		$wpdb->query("UPDATE $wpdb->blogs SET public = '". $_POST['privacy_default'] ."' WHERE blog_id != '1'");
		$query = "SELECT blog_id FROM $wpdb->blogs WHERE blog_id != '1'";
		$blogs = $wpdb->get_results( $query, ARRAY_A );
		if ( count( $blogs ) > 0 ) {
			foreach ( $blogs as $blog ){;
				update_blog_option($blog['blog_id'], "blog_public", $_POST['privacy_default']);
			}
		}
	}
}

function additional_privacy_modify_menu_items() {
	global $submenu, $menu, $wpdb;
	if ( get_site_option('privacy_override', 'yes') == 'no' && !is_site_admin() && $wpdb->blogid != 1 ) {
			unset( $submenu['options-general.php'][35] );
	}
}

//------------------------------------------------------------------------//
//---Output Functions-----------------------------------------------------//
//------------------------------------------------------------------------//

function additional_privacy_deny_message($privacy) {
	header('Cache-Control: no-cache, no-store, max-age=0, must-revalidate');
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
	header('Pragma: no-cache');
	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title><?php _e('Blog Access Denied'); ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

		<style media="screen" type="text/css">
		html { background: #f1f1f1; }

		body {
			background: #fff;
			color: #333;
			font-family: "Lucida Grande", "Lucida Sans Unicode", Tahoma, Verdana, sans-serif;
			margin: 2em auto 0 auto;
			width: 700px;
			padding: 1em 2em;
			-moz-border-radius: 12px;
			-khtml-border-radius: 12px;
			-webkit-border-radius: 12px;
			border-radius: 12px;
		}

		a { color: #2583ad; text-decoration: none; }

		a:hover { color: #d54e21; }


		h1 {
			font-size: 18px;
			margin-bottom: 0;
		}

		h2 { font-size: 16px; }

		p, li {
			padding-bottom: 2px;
			font-size: 13px;
			line-height: 18px;
		}
		</style>
	</head>
	<body>
	<h2><?php _e('Blog Access Denied'); ?></h2>
    <?php
	if ( $privacy == '2' ) {
		?>
		<p><?php _e('This blog may only be viewed by users who are subscribed to this blog.'); ?></p>
        <?php
	} else if ( $privacy == '3' ) {
		?>
		<p><?php _e('This blog may only be viewed by administrators.'); ?></p>
        <?php
	}
	?>
    </body>
    </html>
	<?php
	exit();
}

function additional_privacy_login_message() {
	if ( $_GET['privacy'] == '1' ) {
		?>
        <div id="login_error">
        <strong><?php _e('Authorization Required'); ?></strong>: <?php _e('This blog may only be viewed by users who are logged in.'); ?><br />
        </div>
        <?php
	} else if ( $_GET['privacy'] == '2' ) {
		?>
        <div id="login_error">
        <strong><?php _e('Authorization Required'); ?></strong>: <?php _e('This blog may only be viewed by users who are subscribed to this blog.'); ?><br />
        </div>
        <?php
	} else if ( $_GET['privacy'] == '3' ) {
		?>
        <div id="login_error">
        <strong><?php _e('Authorization Required'); ?></strong>: <?php _e('This blog may only be viewed by administrators.'); ?><br />
        </div>
        <?php
	}
}

function additional_privacy_blog_options() {
	$blog_public = get_option('blog_public');
	?>
    <p>
    <input id="blog-public" type="radio" name="blog_public" value="-1" <?php if ( $blog_public == '-1' ) { echo 'checked="checked"'; } ?> />
    <label><?php _e('I would like only logged in users to see my blog.') ?></label>
    </p>
    <p>
    <input id="blog-norobots" type="radio" name="blog_public" value="-2" <?php if ( $blog_public == '-2' ) { echo 'checked="checked"'; } ?> />
    <label><?php _e('I would like only logged in users who are <em><a href="http:/wp-admin/users.php">registered subscribers</a></em> to see my blog.</label>'); ?></label>
    </p>
    <p>
    <input id="blog-norobots" type="radio" name="blog_public" value="-3" <?php if ( $blog_public == '-3' ) { echo 'checked="checked"'; } ?> />
    <label><?php _e('I would like only administrators of this blog, and network to see my blog.'); ?></label>
    </p>
    <?php
}

function additional_privacy_site_admin_options() {
	$privacy_default = get_site_option('privacy_default', 1);
	$privacy_override = get_site_option('privacy_override', 'yes');
	?>
		<h3><?php _e('Blog Privacy Settings') ?></h3> 
		<table class="form-table">
			<tr valign="top"> 
				<th scope="row"><?php _e('Default Setting') ?></th> 
				<td>
					<label><input name="privacy_default" id="privacy_default" value="1" <?php if ( $privacy_default == '1' ) { echo 'checked="checked"'; } ?> type="radio"> <?php _e('Allow all visitors to all blogs.'); ?>
                    <br />
                    <small><?php _e('This makes all blogs visible to everyone, including search engines (like Google, Sphere, Technorati), archivers and all public listings around your site.'); ?></small></label>
                    <br />
					<label><input name="privacy_default" id="privacy_default" value="0" <?php if ( $privacy_default == '0' ) { echo 'checked="checked"'; } ?> type="radio"> <?php _e('Block search engines from all blogs, but allow normal visitors to see all blogs.'); ?></label>
                    <br />
					<label><input name="privacy_default" id="privacy_default" value="-1" <?php if ( $privacy_default == '-1' ) { echo 'checked="checked"'; } ?> type="radio"> <?php _e('Only allow logged in users to see all blogs.'); ?></label>
                    <br />
					<label><input name="privacy_default" id="privacy_default" value="-2" <?php if ( $privacy_default == '-2' ) { echo 'checked="checked"'; } ?> type="radio"> <?php _e('Only allow a registered user to see a blog for which they are registered to.'); ?>
                    <br />
                    <small><?php _e('Even if a user is logged in, they must be a user of the individual blog in order to see it.'); ?></small></label>
                    <br />
					<label><input name="privacy_default" id="privacy_default" value="-3" <?php if ( $privacy_default == '-3' ) { echo 'checked="checked"'; } ?> type="radio"> <?php _e('Only allow administrators of a blog to view the blog for which they are an admin.'); ?>
                    <br />
                    <small><?php _e('A Site Admin can always view any blog, regardless of any privacy setting. (<em>Note:</em> "Site Admin", not an individual blog admin.)'); ?></small></label>
				</td>
			</tr>
			<tr valign="top"> 
				<th scope="row"><?php _e('Allow Override') ?></th> 
				<td>
					<input name="privacy_override" id="privacy_override" value="yes" <?php if ( $privacy_override == 'yes' ) { echo 'checked="checked"'; } ?> type="radio"> <?php _e('Yes'); ?>
					<br />
					<input name="privacy_override" id="privacy_override" value="no" <?php if ( $privacy_override == 'no' ) { echo 'checked="checked"'; } ?> type="radio"> <?php _e('No'); ?>
					<br />
					<?php _e('Allow Blog Administrators to modify the privacy setting for their blog(s). Note that Site Admins will always be able to edit blog privacy options.') ?>
				</td>
			</tr>
			<tr valign="top"> 
				<th scope="row"><?php _e('Update All Blogs') ?></th> 
				<td>
	                <input id="privacy_update_all_blogs" name="privacy_update_all_blogs" value="update" type="checkbox">
					<br />
					<?php _e('Updates all blogs with the default privacy setting. The main blog is not updated. Please be patient as this can take a few minutes.') ?>
				</td>
			</tr>
		</table>
	<?php
}

?>