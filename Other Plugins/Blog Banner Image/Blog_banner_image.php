<?php
/******************************************************************************************************************
Plugin Name: Blog Banner Images
Plugin URI: http://www.cmurrayconsulting.com/software
Description: Allow individual MU blogs to create their own banner image. Great for MU themes. 
Version: 1.0
Author: Jacob M Goldman (C. Murray Consulting)

Copyright:

    Copyright 2008 CETS

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*******************************************************************************************************************/

function mu_blog_banners_admin_init() {
	register_setting('mu-blog-banners-options', 'mu_blog_banner');
}
add_action( 'admin_init', 'mu_blog_banners_admin_init' );

//check if its a banner and save to option if applicable
function create_banner($post_id) {
	$post = get_post($post_id);
	if (strstr($post->post_mime_type,"image") && $post->post_title == "banner") update_option("mu_blog_banner",$post->guid);
	elseif ($post->post_title != "banner" && $post->guid == get_option("mu_blog_banner")) delete_option("mu_blog_banner"); //if they renamed the image that was previously the banner
}
function delete_banner($post_id) {
	$post = get_post($post_id);
	if (strstr($post->post_mime_type,"image") && $post->post_title == "banner") delete_option("mu_blog_banner");
}
add_action( 'add_attachment', 'create_banner' );
add_action( 'edit_attachment', 'create_banner' );
add_action( 'delete_attachment', 'delete_banner' );

function get_blog_banner_src($blog_id = "") {
	if(!$blog_id) $blog_banner = get_option("mu_blog_banner");
	elseif (is_int($blog_id)) $blog_banner = get_blog_option($blog_id,"mu_blog_banner");
	
	if (!isset($blog_banner) || !$blog_banner) return false;
	
	return $blog_banner; 
}

function show_blog_banner($alt_value = "",$blog_id = "") {
	$blog_banner_src = get_blog_banner_src($blog_id);
	if (!$blog_banner_src) return false;
	
	if (!$alt_value) $alt_value = (!$blog_id) ?  get_bloginfo('name') :  get_blog_option($blog_id, 'blogname');
	echo '<img src="'.$blog_banner_src.'" alt="'.str_replace("\"","'",$alt_value).'" id="blog_banner" />';
}
?>
