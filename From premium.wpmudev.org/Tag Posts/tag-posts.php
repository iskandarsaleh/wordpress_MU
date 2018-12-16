<?php
/*
Plugin Name: Tag Posts
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

/*
Usage:
tag_posts_display_recent(TAG,NUMBER,TITLE_CHARACTERS,CONTENT_CHARACTERS,TITLE_CONTENT_DIVIDER,TITLE_BEFORE,TITLE_AFTER,GLOBAL_BEFORE,GLOBAL_AFTER,BEFORE,AFTER);

Ex:
tag_posts_display_recent('test',10,40,150,'<br />','<strong>','</strong>','<ul>','</ul>','<li>','</li>');
*/
//------------------------------------------------------------------------//
//---Config---------------------------------------------------------------//
//------------------------------------------------------------------------//

//------------------------------------------------------------------------//
//---Hook-----------------------------------------------------------------//
//------------------------------------------------------------------------//

//------------------------------------------------------------------------//
//---Functions------------------------------------------------------------//
//------------------------------------------------------------------------//

//------------------------------------------------------------------------//
//---Output Functions-----------------------------------------------------//
//------------------------------------------------------------------------//

function tag_posts_display_recent($tmp_tag,$tmp_number,$tmp_title_characters = 0,$tmp_content_characters = 0,$tmp_title_content_divider = '<br />',$tmp_title_before,$tmp_title_after,$tmp_global_before,$tmp_global_after,$tmp_before,$tmp_after){
	global $wpdb;
	$tmp_tag_id = $wpdb->get_var("SELECT cat_ID FROM " . $wpdb->base_prefix . "sitecategories WHERE category_nicename = '" . $tmp_tag . "' OR cat_name = '" . $tmp_tag . "'");
	$query = "SELECT * FROM " . $wpdb->base_prefix . "site_posts WHERE post_terms LIKE '%|" . $tmp_tag_id . "|%' ORDER BY post_published_stamp DESC LIMIT " . $tmp_number;
	$tmp_posts = $wpdb->get_results( $query, ARRAY_A );
	
	if (count($tmp_posts) > 0){
		echo $tmp_global_before;
		foreach ($tmp_posts as $tmp_post){
			echo $tmp_before;
			if ( $tmp_title_characters > 0 ) {
				echo $tmp_title_before;
				echo substr($tmp_post['post_title'],0,$tmp_title_characters);
				echo $tmp_title_after;
			}
			echo $tmp_title_content_divider;
			if ( $tmp_content_characters > 0 ) {
				echo substr($tmp_post['post_content_stripped'],0,$tmp_content_characters);
			}
			echo $tmp_after;
		}
		echo $tmp_global_after;
	}
}


//------------------------------------------------------------------------//
//---Page Output Functions------------------------------------------------//
//------------------------------------------------------------------------//

//------------------------------------------------------------------------//
//---Support Functions----------------------------------------------------//
//------------------------------------------------------------------------//

?>