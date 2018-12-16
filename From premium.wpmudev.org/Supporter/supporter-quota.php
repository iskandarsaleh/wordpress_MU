<?php
/*
Plugin Name: Supporter (Feature: Quota)
Plugin URI: 
Description:
Author: Andrew Billits (Incsub)
Version: 1.6.1
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

add_action('supporter_settings', 'supporter_quota_setting');
add_action('supporter_settings_process', 'supporter_quota_setting_process');
add_action('supporter_active', 'supporter_quota_active');
add_action('supporter_inactive', 'supporter_quota_inactive');

//------------------------------------------------------------------------//
//---Functions------------------------------------------------------------//
//------------------------------------------------------------------------//
function supporter_quota_active(){
	$supporter_quota = get_site_option("supporter_quota");
	$current_quota = get_option("blog_upload_space");
	if ($current_quota == $supporter_quota){
		//already updated
	} else {
		update_option("blog_upload_space", $supporter_quota);
	}
}

function supporter_quota_inactive(){
	$default_quota = get_site_option("blog_upload_space");
	if( empty($default_quota) || !is_numeric($default_quota) ){
		$default_quota = 50;
	}
	update_option("blog_upload_space", $default_quota);
}

function supporter_quota_setting_process() {
	update_site_option( "supporter_quota", $_POST[ 'supporter_quota' ] );
}

//------------------------------------------------------------------------//
//---Output Functions-----------------------------------------------------//
//------------------------------------------------------------------------//

function supporter_quota_setting() {
	?>
                <tr valign="top"> 
                <th scope="row"><?php _e('Quota Increase') ?></th> 
                <td><select name="supporter_quota">
				<?php
					$supporter_quota = get_site_option( "supporter_quota" );
					$counter = 0;
					for ( $counter = 1; $counter <=  5120; $counter += 5) {
                        echo '<option value="' . $counter . '"' . ($counter == $supporter_quota ? ' selected' : '') . '>' . $counter . '</option>' . "\n";
					}
                ?>
                </select> MB
                <br /><?php _e('1024MB = 1GB'); ?></td> 
                </tr>
    <?php
}

//------------------------------------------------------------------------//
//---Page Output Functions------------------------------------------------//
//------------------------------------------------------------------------//

?>