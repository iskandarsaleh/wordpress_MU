<?php
/*
Plugin Name: Global Footer Content
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
//---Hook-----------------------------------------------------------------//
//------------------------------------------------------------------------//
add_action('wpmu_options', 'global_footer_content_site_admin_options');
add_action('update_wpmu_options', 'global_footer_content_site_admin_options_process');
add_action('wp_footer', 'global_footer_content');
//------------------------------------------------------------------------//
//---Functions------------------------------------------------------------//
//------------------------------------------------------------------------//

function global_footer_content_site_admin_options_process() {
	$global_footer_content = $_POST['global_footer_content'];
	if ( $global_footer_content == '' ) {
		$global_footer_content = 'empty';
	}

	update_site_option( 'global_footer_content' , $global_footer_content );
}


//------------------------------------------------------------------------//
//---Output Functions-----------------------------------------------------//
//------------------------------------------------------------------------//

function global_footer_content() {
	$global_footer_content = get_site_option('global_footer_content');
	if ( $global_footer_content == 'empty' ) {
		$global_footer_content = '';
	}
	if ( !empty( $global_footer_content ) ) {
		echo stripslashes( $global_footer_content );
	}
}

function global_footer_content_site_admin_options() {
	$global_footer_content = get_site_option('global_footer_content');
	if ( $global_footer_content == 'empty' ) {
		$global_footer_content = '';
	}
	?>
		<h3><?php _e('Footer Content') ?></h3> 
		<table class="form-table">
			<tr valign="top"> 
				<th scope="row"><?php _e('Footer Content') ?></th> 
				<td>
                	<textarea name="global_footer_content" id="global_footer_content" rows="5" cols="45" style="width: 95%;" ><?php echo stripslashes( $global_footer_content ); ?></textarea>
					<br />
					<?php _e('Added to the footer content of every blog page. Useful for statistics embeds, etc.') ?>
				</td>
			</tr>
		</table>
	<?php
}

//------------------------------------------------------------------------//
//---Page Output Functions------------------------------------------------//
//------------------------------------------------------------------------//


?>