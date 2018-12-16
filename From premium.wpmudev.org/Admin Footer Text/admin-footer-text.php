<?php
/*
Plugin Name: Admin Footer Text
Plugin URI: 
Description:
Author: Andrew Billits (Incsub)
Version: 1.0.3
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
$admin_footer_text_default = '';
//------------------------------------------------------------------------//
//---Hook-----------------------------------------------------------------//
//------------------------------------------------------------------------//
add_action('wpmu_options', 'admin_footer_text_site_admin_options');
add_action('update_wpmu_options', 'admin_footer_text_site_admin_options_process');
add_filter('admin_footer_text', 'admin_footer_text_output', 1, 1);
//------------------------------------------------------------------------//
//---Functions------------------------------------------------------------//
//------------------------------------------------------------------------//

function admin_footer_text_site_admin_options_process() {
	update_site_option( 'admin_footer_text' , $_POST['admin_footer_text'] );
}

//------------------------------------------------------------------------//
//---Output Functions-----------------------------------------------------//
//------------------------------------------------------------------------//

function admin_footer_text_output($footer_text) {
	global $admin_footer_text_default;
	$admin_footer_text = get_site_option('admin_footer_text');
	if ( empty( $admin_footer_text ) ) {
		$footer_text = $admin_footer_text_default;
	} else {
		$footer_text = $admin_footer_text;
	}
	return $footer_text;
}

function admin_footer_text_site_admin_options() {
global $admin_footer_text_default;
$admin_footer_text = get_site_option('admin_footer_text');
if ( empty( $admin_footer_text ) ) {
	$admin_footer_text = $admin_footer_text_default;
}
?>
		<h3><?php _e('Admin Panel Footer Settings') ?></h3> 
		<table class="form-table">
			<tr valign="top"> 
				<th scope="row"><?php _e('Footer Text') ?></th> 
				<td><textarea name="admin_footer_text" type="text" rows="3" wrap="soft" id="admin_footer_text" style="width: 95%"/><?php echo stripslashes( $admin_footer_text ); ?></textarea>
					<br />
					<?php _e('HTML Allowed.') ?>
				</td>
			</tr>
		</table>
<?php
}

?>