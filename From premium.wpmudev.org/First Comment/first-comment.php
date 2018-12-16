<?php
/*
Plugin Name: First Comment
Plugin URI: 
Description:
Author: Andrew Billits (Incsub)
Version: 1.0.0
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
add_action('wpmu_options', 'first_comment_site_admin_options');
add_action('update_wpmu_options', 'first_comment_site_admin_options_process');
add_action('wpmu_new_blog', 'first_comment', 1, 1);
//------------------------------------------------------------------------//
//---Functions------------------------------------------------------------//
//------------------------------------------------------------------------//

function first_comment_site_admin_options_process() {
	$first_comment_from = $_POST['first_comment_from'];
	if ( empty( $first_comment_from ) ) {
		$first_comment_from = 'empty';
	}
	update_site_option( 'first_comment_from' , $first_comment_from );
	$first_comment_content = $_POST['first_comment_content'];
	if ( empty( $first_comment_content ) ) {
		$first_comment_content = 'empty';
	}
	update_site_option( 'first_comment_content' , $first_comment_content );
	if ( $first_comment_content == 'empty' && $first_comment_from == 'empty' ) {
		update_site_option( 'first_comment_enabled' , 'no' );
	} else {
		update_site_option( 'first_comment_enabled' , $_POST['first_comment_enabled'] );
	}
}

function first_comment($blog_ID) {
	global $wpdb, $current_site;
	
	switch_to_blog( $blog_ID );
	
	$first_comment_content = get_site_option('first_comment_content');
	if ( empty($first_comment_content) ) {
		$first_comment_content = 'default';
	}
	if ( $first_comment_content == 'empty' ) {
		$first_comment_content = '';
	}
	$first_comment_from = get_site_option('first_comment_from');
	if ( empty($first_comment_from) ) {
		$first_comment_from = 'default';
	}
	if ( $first_comment_from == 'empty' ) {
		$first_comment_from = '';
	}
	$first_comment_enabled = get_site_option('first_comment_enabled');
	if ( empty($first_comment_enabled) ) {
		$first_comment_enabled = 'yes';
	}
	if ( $first_comment_enabled == 'no' ) {
		$wpdb->query( "DELETE FROM " . $wpdb->comments . " WHERE comment_post_ID = '1' AND comment_author_IP = '127.0.0.1'" );
	} else if ( $first_comment_enabled == 'yes' ) {
		if ( $first_comment_from != 'default' || $first_comment_content != 'default' ) {
			$wpdb->query( "DELETE FROM " . $wpdb->comments . " WHERE comment_post_ID = '1' AND comment_author_IP = '127.0.0.1'" );
			$wpdb->insert( $wpdb->comments, array(
				'comment_post_ID' => '1', 
				'comment_author' => $first_comment_from, 
				'comment_author_email' => '',
				'comment_author_url' => 'http://' . $current_site->domain . $current_site->path, 
				'comment_author_IP' => '127.0.0.1', 
				'comment_date' => date('Y-m-d H:i:s'),
				'comment_date_gmt' => gmdate('Y-m-d H:i:s'), 
				'comment_content' => $first_comment_content 
			) );
		}
	}
	restore_current_blog();
}

//------------------------------------------------------------------------//
//---Output Functions-----------------------------------------------------//
//------------------------------------------------------------------------//

function first_comment_site_admin_options() {
	$first_comment_content = get_site_option('first_comment_content');
	if ( empty($first_comment_content) ) {
		$first_comment_content = __('Hi, this is a comment.
To delete a comment, just log in, and view the posts\' comments, there you will have the option to edit or delete them.');
	}
	if ( $first_comment_content == 'empty' ) {
		$first_comment_content = '';
	}
	
	$first_comment_from = get_site_option('first_comment_from');
	if ( empty($first_comment_from) ) {
		$first_comment_from = __('Mr WordPress');
	}
	if ( $first_comment_from == 'empty' ) {
		$first_comment_from = '';
	}
	$first_comment_enabled = get_site_option('first_comment_enabled');
	if ( empty($first_comment_enabled) ) {
		$first_comment_enabled = 'yes';
	}
	?>
		<h3><?php _e('First Comment') ?></h3> 
		<table class="form-table">
            <tr valign="top"> 
                <th width="33%" scope="row"><?php _e('Enabled') ?></th> 
                <td>
                    <select name="first_comment_enabled" id="first_comment_enabled">
                       <option value="yes" <?php if ( $first_comment_enabled == 'yes' ) { echo 'selected="selected"'; } ?> ><?php _e('Yes'); ?></option>
                       <option value="no" <?php if ( $first_comment_enabled == 'no' ) { echo 'selected="selected"'; } ?> ><?php _e('No'); ?></option>
                    </select>
                <br /><?php //_e('') ?></td>
            </tr>
			<tr valign="top"> 
				<th scope="row"><?php _e('First Comment From') ?></th> 
				<td><input name="first_comment_from" type="text" id="first_comment_from" value="<?php echo stripslashes( $first_comment_from ); ?>" style="width: 95%;" />
					<br />
					<?php //_e('') ?>
				</td>
			</tr>
			<tr valign="top"> 
				<th scope="row"><?php _e('First Comment') ?></th> 
				<td><textarea name="first_comment_content" type="text" rows="3" wrap="soft" id="first_comment_content" style="width: 95%"/><?php echo stripslashes( $first_comment_content ); ?></textarea>
					<br />
					<?php _e('First comment on a new blog. ') ?>
				</td>
			</tr>
		</table>
	<?php
}

?>