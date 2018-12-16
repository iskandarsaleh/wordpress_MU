<?php
/*
Plugin Name: Comment Indexer
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

$comment_indexer_current_version = '1.0.2';
//------------------------------------------------------------------------//
//---Config---------------------------------------------------------------//
//------------------------------------------------------------------------//

//------------------------------------------------------------------------//
//---Hook-----------------------------------------------------------------//
//------------------------------------------------------------------------//
//check for activating
if ($_GET['key'] == '' || $_GET['key'] === ''){
	add_action('admin_head', 'comment_indexer_make_current');
}
//index comments
add_action('comment_post', 'comment_indexer_comment_insert_update');
add_action('edit_comment', 'comment_indexer_comment_insert_update');
add_action('delete_comment', 'comment_indexer_delete');
add_action('wp_set_comment_status', 'comment_indexer_update_comment_status', 5, 2);
//handle blog changes
add_action('make_spam_blog', 'comment_indexer_change_remove');
add_action('archive_blog', 'comment_indexer_change_remove');
add_action('mature_blog', 'comment_indexer_change_remove');
add_action('deactivate_blog', 'comment_indexer_change_remove');
add_action('blog_privacy_selector', 'comment_indexer_public_update');
add_action('delete_blog', 'comment_indexer_change_remove', 10, 1);
//update blog types
add_action('blog_types_update', 'comment_indexer_sort_terms_update');
//------------------------------------------------------------------------//
//---Functions------------------------------------------------------------//
//------------------------------------------------------------------------//
function comment_indexer_make_current() {
	global $wpdb, $comment_indexer_current_version;
	if (get_site_option( "comment_indexer_version" ) == '') {
		add_site_option( 'comment_indexer_version', '0.0.0' );
	}
	
	if (get_site_option( "comment_indexer_version" ) == $comment_indexer_current_version) {
		// do nothing
	} else {
		//update to current version
		update_site_option( "comment_indexer_installed", "no" );
		update_site_option( "comment_indexer_version", $comment_indexer_current_version );
	}
	comment_indexer_global_install();
	//--------------------------------------------------//
	if (get_option( "comment_indexer_version" ) == '') {
		add_option( 'comment_indexer_version', '0.0.0' );
	}
	
	if (get_option( "comment_indexer_version" ) == $comment_indexer_current_version) {
		// do nothing
	} else {
		//update to current version
		update_option( "comment_indexer_version", $comment_indexer_current_version );
		comment_indexer_blog_install();
	}
}

function comment_indexer_blog_install() {
	global $wpdb, $comment_indexer_current_version;
	//$comment_indexer_table1 = "";
	//$wpdb->query( $comment_indexer_table1 );
}

function comment_indexer_global_install() {
	global $wpdb, $comment_indexer_current_version;
	if (get_site_option( "comment_indexer_installed" ) == '') {
		add_site_option( 'comment_indexer_installed', 'no' );
	}
	
	if (get_site_option( "comment_indexer_installed" ) == "yes") {
		// do nothing
	} else {
	
		$comment_indexer_table1 = "CREATE TABLE IF NOT EXISTS `" . $wpdb->base_prefix . "site_comments` (
  `site_comment_id` bigint(20) unsigned NOT NULL auto_increment,
  `blog_id` bigint(20),
  `site_id` bigint(20),
  `sort_terms` TEXT,
  `blog_public` int(2),
  `comment_approved` VARCHAR(255),
  `comment_id` bigint(20),
  `comment_post_id` bigint(20),
  `comment_post_permalink` TEXT,
  `comment_author` VARCHAR(60),
  `comment_author_email` VARCHAR(255),
  `comment_author_IP` VARCHAR(255),
  `comment_author_url` VARCHAR(50),
  `comment_author_user_id` bigint(20),
  `comment_content` TEXT,
  `comment_content_stripped` TEXT,
  `comment_karma` VARCHAR(255),
  `comment_agent` VARCHAR(255),
  `comment_type` VARCHAR(255),
  `comment_parent` VARCHAR(255),
  `comment_date_gmt` datetime NOT NULL default '0000-00-00 00:00:00',
  `comment_date_stamp` VARCHAR(255),
  PRIMARY KEY  (`site_comment_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
		$comment_indexer_table2 = "";
		$comment_indexer_table3 = "";
		$comment_indexer_table4 = "";
		$comment_indexer_table5 = "";

		$wpdb->query( $comment_indexer_table1 );
		$wpdb->query( $comment_indexer_table2 );
		//$wpdb->query( $comment_indexer_table3 );
		//$wpdb->query( $comment_indexer_table4 );
		//$wpdb->query( $comment_indexer_table5 );
		update_site_option( "comment_indexer_installed", "yes" );
	}
}

function comment_indexer_update_comment_status($tmp_comment_ID, $tmp_comment_status){
  global $wpdb;
  
  switch ( $tmp_comment_status ) {
  case 'hold':
    $query = "UPDATE " . $wpdb->base_prefix . "site_comments SET comment_approved='0' WHERE comment_id ='" . $tmp_comment_ID . "' and blog_id = '" . $wpdb->blogid . "' LIMIT 1";
    break;
  case 'approve':
    $query = "UPDATE " . $wpdb->base_prefix . "site_comments SET comment_approved='1' WHERE comment_id ='" . $tmp_comment_ID . "' and blog_id = '" . $wpdb->blogid . "' LIMIT 1";
    break;
  case 'spam':
    $query = "UPDATE " . $wpdb->base_prefix . "site_comments SET comment_approved='spam' WHERE comment_id ='" . $tmp_comment_ID . "' and blog_id = '" . $wpdb->blogid . "' LIMIT 1";
    break;
  case 'delete':
	comment_indexer_delete($tmp_comment_ID);
    return true;
    break;
  default:
    return false;
  }

  if ( !$wpdb->query($query) )
    return false;
}

function comment_indexer_get_sort_terms($tmp_blog_ID){
	$comment_indexer_blog_lang = get_blog_option($tmp_blog_ID,"WPLANG");
	if ($comment_indexer_blog_lang == ''){
		$comment_indexer_blog_lang = 'en_EN';
	}
	$comment_indexer_blog_types = get_blog_option($tmp_blog_ID,"blog_types");
	if ($comment_indexer_blog_types == ''){
		$comment_indexer_blog_types = '||';
	}
	$comment_indexer_class = get_blog_option($tmp_blog_ID,"blog_class");
	
	$tmp_sort_terms = array();
	
	$comment_indexer_blog_types = explode("|", $comment_indexer_blog_types);
	foreach ( $comment_indexer_blog_types as $comment_indexer_blog_type ) {
		if ( $comment_indexer_blog_type != '' ) {
			$tmp_sort_terms[] = 'blog_type_' . $comment_indexer_blog_type;
		}
	}
	if ( $comment_indexer_class != '' ) {
		$tmp_sort_terms[] = 'class_' . $comment_indexer_class;
	}
	
	$tmp_sort_terms[] = 'blog_lang_' . strtolower( $comment_indexer_blog_lang );
	
	return '|' . implode("|", $tmp_sort_terms) . '|all|';

}

function comment_indexer_comment_insert_update($tmp_comment_ID){
	global $wpdb, $current_site;
	
	$tmp_blog_public = get_blog_status( $wpdb->blogid, 'public');
	$tmp_blog_archived = get_blog_status( $wpdb->blogid, 'archived');
	$tmp_blog_mature = get_blog_status( $wpdb->blogid, 'mature');
	$tmp_blog_spam = get_blog_status( $wpdb->blogid, 'spam');
	$tmp_blog_deleted = get_blog_status( $wpdb->blogid, 'deleted');
	
	$tmp_comment = get_comment($tmp_comment_ID);
	if ($tmp_blog_archived == '1'){
		comment_indexer_delete($tmp_comment_ID);
	} else if ($tmp_blog_mature == '1'){
		comment_indexer_delete($tmp_comment_ID);
	} else if ($tmp_blog_spam == '1'){
		comment_indexer_delete($tmp_comment_ID);
	} else if ($tmp_blog_deleted == '1'){
		comment_indexer_delete($tmp_comment_ID);
	} else if ($tmp_comment->comment_content == ''){
		comment_indexer_delete($tmp_comment_ID);
	} else {
		//delete comment
		comment_indexer_delete($tmp_comment_ID);
		
		//get sort terms
		$tmp_sort_terms = comment_indexer_get_sort_terms($wpdb->blogid);
		//comment does not exist - insert site comment

		$wpdb->query("INSERT IGNORE INTO " . $wpdb->base_prefix . "site_comments
		(blog_id, site_id, sort_terms, blog_public, comment_approved, comment_id, comment_post_id, comment_post_permalink, comment_author, comment_author_email, comment_author_IP, comment_author_url, comment_author_user_id, comment_content, comment_content_stripped, comment_karma, comment_agent, comment_type, comment_parent, comment_date_gmt, comment_date_stamp)
		VALUES
		('" . $wpdb->blogid . "','" . $wpdb->siteid . "','" . $tmp_sort_terms . "','" . $tmp_blog_public . "','" . $tmp_comment->comment_approved . "','" . $tmp_comment_ID . "','" . $tmp_comment->comment_post_ID . "','" . get_permalink($tmp_comment->comment_post_ID) . "','" .  $tmp_comment->comment_author . "','" . $tmp_comment->comment_author_email . "','" . $tmp_comment->comment_author_IP . "','" . $tmp_comment->comment_author_url . "','" . $tmp_comment->user_id . "','" . addslashes($tmp_comment->comment_content) . "','" . addslashes(comment_indexer_strip_content($tmp_comment->comment_content)) . "','" . $tmp_comment->comment_karma . "','" . $tmp_comment->comment_agent . "','" . $tmp_comment->comment_type . "','" . $tmp_comment->comment_parent . "','" . $tmp_comment->comment_date_gmt . "','" . time() . "')");
	}
}

function comment_indexer_delete($tmp_comment_ID){
	global $wpdb;
	//delete site comment
	$wpdb->query( "DELETE FROM " . $wpdb->base_prefix . "site_comments WHERE comment_id = '" . $tmp_comment_ID . "' AND blog_id = '" . $wpdb->blogid . "'" );
}

function comment_indexer_delete_by_site_comment_id($tmp_site_comment_ID, $tmp_blog_ID) {
	global $wpdb;
	//delete site comment
	$wpdb->query( "DELETE FROM " . $wpdb->base_prefix . "site_comments WHERE site_comment_id = '" . $tmp_site_comment_ID . "'" );
}

function comment_indexer_public_update(){
	global $wpdb;
	if ( $_GET['updated'] == 'true' ) {
		$wpdb->query("UPDATE " . $wpdb->base_prefix . "site_comments SET blog_public = '" . get_blog_status( $wpdb->blogid, 'public') . "' WHERE blog_id = '" . $wpdb->blogid . "' AND site_id = '" . $wpdb->siteid . "'");
	}
}
function comment_indexer_sort_terms_update(){
	global $wpdb;
	$wpdb->query("UPDATE " . $wpdb->base_prefix . "site_comments SET sort_terms = '" . comment_indexer_get_sort_terms($wpdb->blogid) . "' WHERE blog_id = '" . $wpdb->blogid . "' AND site_id = '" . $wpdb->siteid . "'");
}

function comment_indexer_change_remove($tmp_blog_ID){
	global $wpdb, $current_user, $current_site;
	//delete site posts
	$query = "SELECT * FROM " . $wpdb->base_prefix . "site_comments WHERE blog_id = '" . $tmp_blog_ID . "' AND site_id = '" . $wpdb->siteid . "'";
	$blog_site_comments = $wpdb->get_results( $query, ARRAY_A );
	if (count($blog_site_comments) > 0){
		foreach ($blog_site_comments as $blog_site_comment){
			comment_indexer_delete_by_site_comment_id($blog_site_comment['site_comment_id'], $tmp_blog_ID);
		}
	}
}

//------------------------------------------------------------------------//
//---Output Functions-----------------------------------------------------//
//------------------------------------------------------------------------//

//------------------------------------------------------------------------//
//---Page Output Functions------------------------------------------------//
//------------------------------------------------------------------------//

//------------------------------------------------------------------------//
//---Support Functions----------------------------------------------------//
//------------------------------------------------------------------------//

function comment_indexer_strip_content($tmp_content){
	$tmp_content = strip_tags($tmp_content);
	return $tmp_content;
}

?>
