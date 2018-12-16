<?php
/*
Plugin Name: Admin Help Content
Plugin URI: 
Description:
Author: Andrew Billits (Incsub)
Version: 1.0.2
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
//---Config-----------------------------------------------------------------//
//------------------------------------------------------------------------//
$admin_help_content_default = '';
//------------------------------------------------------------------------//
//---Hook-----------------------------------------------------------------//
//------------------------------------------------------------------------//
add_action('wpmu_options', 'admin_help_content_site_admin_options');
add_action('update_wpmu_options', 'admin_help_content_site_admin_options_process');
add_filter('contextual_help', 'admin_help_content_output', 1, 1);
//------------------------------------------------------------------------//
//---Functions------------------------------------------------------------//
//------------------------------------------------------------------------//

function admin_help_content_site_admin_options_process() {
	update_site_option( 'admin_help_content' , $_POST['admin_help_content'] );
}

//------------------------------------------------------------------------//
//---Output Functions-----------------------------------------------------//
//------------------------------------------------------------------------//

function admin_help_content_output($_wp_contextual_help) {
	global $admin_help_content_default;
	$admin_help_content = get_site_option('admin_help_content');
	if ( empty( $admin_help_content ) ) {
		$_wp_contextual_help = $admin_help_content_default;
	} else {
		$_wp_contextual_help = $admin_help_content;
	}
	return stripslashes( $_wp_contextual_help );
}

function admin_help_content_site_admin_options() {
	global $admin_help_content_default;
	$admin_help_content = get_site_option('admin_help_content');
	if ( empty( $admin_help_content ) ) {
		$admin_help_content = $admin_help_content_default;
	}
	?>
		<h3><?php _e('Admin Panel Help Settings') ?></h3> 
		<table class="form-table">
			<tr valign="top"> 
				<th scope="row"><?php _e('Help Content') ?></th> 
				<td>
		            <textarea name="admin_help_content" type="text" rows="5" wrap="soft" id="admin_help_content" style="width: 95%"/><?php echo stripslashes( $admin_help_content ); ?></textarea>
					<br />
					<?php _e('HTML Allowed.') ?>
				</td>
			</tr>
		</table>
	<?php
}

?>