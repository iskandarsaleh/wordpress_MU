<?php
/*
Plugin Name: Forums
Plugin URI: 
Description:
Author: Andrew Billits
Version: 1.5.1
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

$forums_current_version = '1.5.1';
//------------------------------------------------------------------------//
//---Config---------------------------------------------------------------//
//------------------------------------------------------------------------//
$forums_topics_per_page = 20; //The number of topics per page
$forums_posts_per_page = 20; //The number of posts per page
$forums_max_forums = 1; //The maximum number of forums per blog - Max 25
$forums_upgrades_forums = 10; //The maximum number of forums when the upgrade package is active. This overides the max forums setting - Max 25
$forums_enable_upgrades = '0'; //Either 0 or 1 - 0 = disabled/1 = enabled

function forums_upgrades_advertise(){
global $forums_max_forums;
?>
<p><strong>Visit the upgrades tab to get more forums. Currently you are limit to <?php echo $forums_max_forums; ?></strong></p>
<?php
}

//------------------------------------------------------------------------//
//---Hook-----------------------------------------------------------------//
//------------------------------------------------------------------------//
//check for activating
if ($_GET['key'] == '' || $_GET['key'] === ''){
	add_action('admin_head', 'forums_make_current');
}
//if ($wpdb->blogid == 2){
add_action('admin_menu', 'forums_plug_pages');
add_filter('wpabar_menuitems', 'forums_admin_bar');
add_filter('the_content', 'forums_output', 20);
add_filter('the_excerpt', 'forums_output', 20);
//}
//--------------------------------Premium---------------------------------//
if ($forums_enable_upgrades == '1'){
	//register premium features
	upgrades_register_feature('68daf8bdc8755fe8f4859024b3054fb8', 'Forums', 'Additional Forums');
	
	//load premium features
	if (upgrades_active_feature('68daf8bdc8755fe8f4859024b3054fb8') == 'active'){
		$forums_max_forums = $forums_upgrades_forums;
	}
}
//------------------------------------------------------------------------//
//---Functions------------------------------------------------------------//
//------------------------------------------------------------------------//
function forums_make_current() {
	global $wpdb, $forums_current_version;
	if (get_site_option( "forums_version" ) == '') {
		add_site_option( 'forums_version', '0.0.0' );
	}
	
	if (get_site_option( "forums_version" ) == $forums_current_version) {
		// do nothing
	} else {
		//up to current version
		update_site_option( "forums_installed", "no" );
		update_site_option( "forums_version", $forums_current_version );
	}
	forums_global_install();
	//--------------------------------------------------//
	if (get_option( "forums_version" ) == '') {
		add_option( 'forums_version', '0.0.0' );
	}
	
	if (get_option( "forums_version" ) == $forums_current_version) {
		// do nothing
	} else {
		//up to current version
		update_option( "forums_version", $forums_current_version );
		forums_blog_install();
	}
}

function forums_blog_install() {
	global $wpdb, $forums_current_version;
	//$forums_table1 = "";
	//$wpdb->query( $forums_table1 );
}

function forums_global_install() {
	global $wpdb, $forums_current_version;
	if (get_site_option( "forums_installed" ) == '') {
		add_site_option( 'forums_installed', 'no' );
	}
	
	if (get_site_option( "forums_installed" ) == "yes") {
		// do nothing
	} else {
	
		$forums_table1 = "CREATE TABLE `" . $wpdb->base_prefix . "forums` (
  `forum_ID` bigint(20) unsigned NOT NULL auto_increment,
  `forum_blog_ID` bigint(20) NOT NULL,
  `forum_name` TEXT NOT NULL,
  `forum_nicename` TEXT,
  `forum_description` TEXT,
  `forum_topics` bigint(20) NOT NULL default '0',
  `forum_posts` bigint(20) NOT NULL default '0',
  `forum_color_one` VARCHAR(255),
  `forum_color_two` VARCHAR(255),
  `forum_color_header` VARCHAR(255),
  `forum_color_border` VARCHAR(255),
  `forum_border_size` VARCHAR(255),
  PRIMARY KEY  (`forum_ID`)
) ENGINE=MyISAM;";
		$forums_table2 = "CREATE TABLE `" . $wpdb->base_prefix . "topics` (
  `topic_ID` bigint(20) unsigned NOT NULL auto_increment,
  `topic_forum_ID` bigint(20) NOT NULL,
  `topic_title` TEXT NOT NULL,
  `topic_author` bigint(20) NOT NULL,
  `topic_last_author` bigint(20) NOT NULL,
  `topic_stamp` bigint(30) NOT NULL,
  `topic_last_updated_stamp` bigint(30) NOT NULL,
  `topic_closed` tinyint(1) NOT NULL default '0',
  `topic_sticky` tinyint(1) NOT NULL default '0',
  `topic_posts` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`topic_ID`)
) ENGINE=MyISAM;";
		$forums_table3 = "CREATE TABLE `" . $wpdb->base_prefix . "posts` (
  `post_ID` bigint(20) unsigned NOT NULL auto_increment,
  `post_forum_ID` bigint(20) NOT NULL,
  `post_topic_ID` bigint(20) NOT NULL,
  `post_author` bigint(20) NOT NULL,
  `post_content` TEXT,
  `post_stamp` bigint(30) NOT NULL,
  PRIMARY KEY  (`post_ID`)
) ENGINE=MyISAM;";
		$forums_table4 = "";
		$forums_table5 = "";

		$wpdb->query( $forums_table1 );
		$wpdb->query( $forums_table2 );
		$wpdb->query( $forums_table3 );
		//$wpdb->query( $forums_table4 );
		//$wpdb->query( $forums_table5 );
		update_site_option( "forums_installed", "yes" );
	}
}

function forums_plug_pages() {
	add_menu_page(__('Forums'), __('Forums'), 10, 'forums.php');
}

function forums_admin_bar( $menu ) {
	unset( $menu['forums.php'] );
	return $menu;
}

function forums_delete_forum($tmp_fid) {
	global $wpdb;
	$tmp_forum_count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "forums WHERE forum_ID = '" . $tmp_fid . "' AND forum_blog_ID = '" . $wpdb->blogid . "'");
	if ($tmp_forum_count > 0){
		$wpdb->query( "DELETE FROM " . $wpdb->base_prefix . "forums WHERE forum_ID = '" . $tmp_fid . "' AND forum_blog_ID = '" . $wpdb->blogid . "'" );
		$wpdb->query( "DELETE FROM " . $wpdb->base_prefix . "topics WHERE topic_forum_ID = '" . $tmp_fid . "'" );
		$wpdb->query( "DELETE FROM " . $wpdb->base_prefix . "posts WHERE post_forum_ID = '" . $tmp_fid . "'" );
	}
}


//------------------------------------------------------------------------//
//---Output Functions-----------------------------------------------------//
//------------------------------------------------------------------------//

function forums_output($content) {
	global $wpdb, $user_ID, $forums_posts_per_page, $current_site;
	$original_content = $content;
	if(preg_match("[forum:[0-9]{1,20}]",$content) == true) {
		$tmp_match = $content;
		preg_match("|[forum:[0-9]{1,20}]|",$tmp_match,$tmp_match);
		$tmp_fid = $tmp_match[0];
		$tmp_fid = str_replace('[forum:','',$tmp_fid);
		$tmp_fid = str_replace(']','',$tmp_fid);
		$tmp_forum_count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "forums WHERE forum_ID = '" . $tmp_fid . "' AND forum_blog_ID = '" . $wpdb->blogid . "'");
		if ($tmp_forum_count > 0){
			$content = '';
			if ($_GET['action'] == 'new_topic'){
				//Display New Topic Form
				$content = forums_output_new_topic($tmp_fid,0,'');
			} else if ($_GET['action'] == 'new_topic_process'){
				//Display Topic Process, etc
				$tmp_errors = 0;
				//check for empty title
				if ($_POST['topic_title'] == ''){
					$tmp_errors = $tmp_errors + 1;
				}
				//check for empty content
				if ($_POST['post_content'] == ''){
					$tmp_errors = $tmp_errors + 1;
				}
				//check for invalid user ID
				$tmp_user_count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "users WHERE ID = '" . $_POST['uid'] . "'");
				if ($tmp_user_count > 0){
					//we're good
				} else {
					$tmp_errors = $tmp_errors + 1;
					$tmp_error_msg = 'Invalid user account...';
				}
				//check for invalid forum ID
				if ($_POST['fid'] != $tmp_fid){
					$tmp_errors = $tmp_errors + 1;
					$tmp_error_msg = 'Invalid forum...';
				}
				if ($tmp_errors > 0){
					$content = forums_output_new_topic($tmp_fid,$tmp_errors,$tmp_error_msg);
				} else {
					$tmp_tid = forums_topic_process($tmp_fid);
					if ($tmp_tid == ''){
						//nothing
					} else {
						forums_topic_count_posts($tmp_tid);
						forums_forum_count_posts($tmp_fid);
						forums_forum_count_topics($tmp_fid);
						$content = $content . '<p><center>' . _('Topic Added!') . '</center></p>';
						$content = $content . forums_output_search_form($tmp_fid);
						$content = $content . '<br />';
						$content = $content . forums_output_forum_nav($tmp_fid);
						$content = $content . '<br />';
						$content = $content . forums_output_forum($tmp_fid);
						$content = $content . '<br />';
						$content = $content . forums_output_forum_nav($tmp_fid);
					}
				}
			} else if ($_GET['topic'] != ''){
				$tmp_topic_count = 0;
				$tmp_forum_count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "forums WHERE forum_ID = '" . $tmp_fid . "' AND forum_blog_ID = '" . $wpdb->blogid . "'");
				if ($tmp_forum_count > 0){
					$tmp_topic_count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "topics WHERE topic_ID = '" . $_GET['topic'] . "' AND topic_forum_ID = '" . $tmp_fid . "'");
				}
				if ($tmp_topic_count > 0){
					if ($_GET['action'] == 'close_topic'){
						if(current_user_can('manage_options')) {
							$wpdb->query( "UPDATE " . $wpdb->base_prefix . "topics SET topic_closed = '1' WHERE topic_ID = '" . $_GET['topic'] . "' AND topic_forum_ID = '" . $tmp_fid . "'");
							$tmp_msg = 'Topic Closed!';
						} else {
							$tmp_msg = 'Permission denied...';
						}
					}
					if ($_GET['action'] == 'open_topic'){
						if(current_user_can('manage_options')) {
							$wpdb->query( "UPDATE " . $wpdb->base_prefix . "topics SET topic_closed = '0' WHERE topic_ID = '" . $_GET['topic'] . "' AND topic_forum_ID = '" . $tmp_fid . "'");
							$tmp_msg = 'Topic Opened!';
						} else {
							$tmp_msg = 'Permission denied...';
						}
					}
					$tmp_topic_title = $wpdb->get_var("SELECT topic_title FROM " . $wpdb->base_prefix . "topics WHERE topic_ID = '" . $_GET['topic'] . "'");
					$tmp_topic_last_updated = $wpdb->get_var("SELECT topic_last_updated_stamp FROM " . $wpdb->base_prefix . "topics WHERE topic_ID = '" . $_GET['topic'] . "'");
					$tmp_topic_last_author = $wpdb->get_var("SELECT topic_last_author FROM " . $wpdb->base_prefix . "topics WHERE topic_ID = '" . $_GET['topic'] . "'");
					$tmp_topic_closed = $wpdb->get_var("SELECT topic_closed FROM " . $wpdb->base_prefix . "topics WHERE topic_ID = '" . $_GET['topic'] . "'");
					if ($tmp_topic_closed == 1){
						$content = $content . '<h3>' . $tmp_topic_title . ' (' . __('Closed') . ')</h3>';					
					} else {
						$content = $content . '<h3>' . $tmp_topic_title . '</h3>';
					}
					if ($tmp_msg != ''){
					$content = $content . '<p><center>' . __($tmp_msg) . '</center></p>';
					}
					if ($_GET['msg'] != ''){
					$content = $content . '<p><center>' . __(urldecode($_GET['msg'])) . '</center></p>';
					}
					$content = $content . '<br />';
					$content = $content . '<hr />';
					$content = $content . '<ul>';
					$content = $content . '<li>' . __('Last updated: ') . date("D, F jS Y g:i A",$tmp_topic_last_updated) . '</li>';
					$content = $content . '<li>' . __('Latest Reply From: ') . forums_author_display_name($tmp_topic_last_author) . '</li>';
					$content = $content . '</ul>';
					$content = $content . '<hr />';
					if(current_user_can('manage_options')) {
						$content = $content . '<center><a href="?action=delete_topic&tid=' . $_GET['topic'] . '">' . __('Delete Topic') . '</a> | ';
						if ($tmp_topic_closed == 1){
							$content = $content . '<a href="?topic=' . $_GET['topic'] . '&action=open_topic">' . __('Open Topic') . '</a>';
						} else {
							$content = $content . '<a href="?topic=' . $_GET['topic'] . '&action=close_topic">' . __('Close Topic') . '</a>';
						}
						$content = $content . '</center>';
						$content = $content . '<hr />';
					}
					$content = $content . forums_output_topic_nav($_GET['topic']);
					$content = $content . '<br />';
					$content = $content . forums_output_view_topic($_GET['topic'],$tmp_fid);
					$content = $content . '<br />';
					$content = $content . forums_output_topic_nav($_GET['topic']);
					$content = $content . '<br />';
					$content = $content . forums_output_new_post($tmp_fid,$_GET['topic'],0,'');
				} else {
					$content = $content . '<p><center>' . __('Invalid topic...') . '</center></p>';	
				}
			} else if ($_GET['action'] == 'delete_topic'){
				$tmp_topic_count = 0;
				$tmp_forum_count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "forums WHERE forum_ID = '" . $tmp_fid . "' AND forum_blog_ID = '" . $wpdb->blogid . "'");
				if ($tmp_forum_count > 0){
					$tmp_topic_count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "topics WHERE topic_ID = '" . $_GET['tid'] . "' AND topic_forum_ID = '" . $tmp_fid . "'");	
				}
				if ($tmp_topic_count > 0){
					if(current_user_can('manage_options')) {
						$content = $content . forums_output_delete_topic($tmp_fid,$_GET['tid']);
					} else {
						$content = $content . '<p><center>' . __('Permission denied...') . '</center></p>';	
					}
				} else {
						$content = $content . '<p><center>' . __('Permission denied...') . '</center></p>';	
				}
			} else if ($_GET['action'] == 'delete_topic_process'){
				$tmp_topic_count = 0;
				$tmp_forum_count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "forums WHERE forum_ID = '" . $tmp_fid . "' AND forum_blog_ID = '" . $wpdb->blogid . "'");
				if ($tmp_forum_count > 0){
					$tmp_topic_count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "topics WHERE topic_ID = '" . $_POST['tid'] . "' AND topic_forum_ID = '" . $tmp_fid . "'");	
				}
				if ($tmp_topic_count > 0){
					if ( isset($_POST['Cancel']) ) {
						if ($_GET['action'] == 'close_topic'){
							if(current_user_can('manage_options')) {
								$wpdb->query( "UPDATE " . $wpdb->base_prefix . "topics SET topic_closed = '1' WHERE topic_ID = '" . $_GET['topic'] . "' AND topic_forum_ID = '" . $tmp_fid . "'");
								$tmp_msg = 'Topic Closed!';
							} else {
								$tmp_msg = 'Permission denied...';
							}
						}
						if ($_GET['action'] == 'open_topic'){
							if(current_user_can('manage_options')) {
								$wpdb->query( "UPDATE " . $wpdb->base_prefix . "topics SET topic_closed = '0' WHERE topic_ID = '" . $_GET['topic'] . "' AND topic_forum_ID = '" . $tmp_fid . "'");
								$tmp_msg = 'Topic Opened!';
							} else {
								$tmp_msg = 'Permission denied...';
							}
						}
						$tmp_topic_title = $wpdb->get_var("SELECT topic_title FROM " . $wpdb->base_prefix . "topics WHERE topic_ID = '" . $_POST['tid'] . "'");
						$tmp_topic_last_updated = $wpdb->get_var("SELECT topic_last_updated_stamp FROM " . $wpdb->base_prefix . "topics WHERE topic_ID = '" . $_POST['tid'] . "'");
						$tmp_topic_last_author = $wpdb->get_var("SELECT topic_last_author FROM " . $wpdb->base_prefix . "topics WHERE topic_ID = '" . $_POST['tid'] . "'");
						$tmp_topic_closed = $wpdb->get_var("SELECT topic_closed FROM " . $wpdb->base_prefix . "topics WHERE topic_ID = '" . $_POST['tid'] . "'");
						
						if ($tmp_topic_closed == 1){
							$content = $content . '<h3>' . $tmp_topic_title . ' (' . __('Closed') . ')</h3>';					
						} else {
							$content = $content . '<h3>' . $tmp_topic_title . '</h3>';
						}
						if ($tmp_msg != ''){
						$content = $content . '<p><center>' . __($tmp_msg) . '</center></p>';
						}
						if ($_GET['msg'] != ''){
						$content = $content . '<p><center>' . __(urldecode($_GET['msg'])) . '</center></p>';
						}
						$content = $content . '<br />';
						$content = $content . '<hr />';
						$content = $content . '<ul>';
						$content = $content . '<li>' . __('Last updated: ') . date("D, F jS Y g:i A",$tmp_topic_last_updated) . '</li>';
						$content = $content . '<li>' . __('Latest Reply From: ') . forums_author_display_name($tmp_topic_last_author) . '</li>';
						$content = $content . '</ul>';
						$content = $content . '<hr />';
						if(current_user_can('manage_options')) {
							$content = $content . '<center><a href="?action=delete_topic&tid=' . $_POST['tid'] . '">' . __('Delete Topic') . '</a> | ';
							if ($tmp_topic_closed == 1){
								$content = $content . '<a href="?topic=' . $_POST['tid'] . '&action=open_topic">' . __('Open Topic') . '</a>';
							} else {
								$content = $content . '<a href="?topic=' . $_POST['tid'] . '&action=close_topic">' . __('Close Topic') . '</a>';
							}
							$content = $content . '</center>';
							$content = $content . '<hr />';
						}
						$content = $content . forums_output_topic_nav($_POST['tid']);
						$content = $content . '<br />';
						$content = $content . forums_output_view_topic($_POST['tid'],$tmp_fid);
						$content = $content . '<br />';
						$content = $content . forums_output_topic_nav($_POST['tid']);
						$content = $content . '<br />';
						$content = $content . forums_output_new_post($tmp_fid,$_GET['tid'],0,'');
					} else {
						if(current_user_can('manage_options')) {
							$tmp_errors = forums_output_delete_topic_process($tmp_fid,$_POST['tid']);
							if ($tmp_errors > 0){
								if ($_GET['action'] == 'close_topic'){
									if(current_user_can('manage_options')) {
										$wpdb->query( "UPDATE " . $wpdb->base_prefix . "topics SET topic_closed = '1' WHERE topic_ID = '" . $_GET['topic'] . "' AND topic_forum_ID = '" . $tmp_fid . "'");
										$tmp_msg = 'Topic Closed!';
									} else {
										$tmp_msg = 'Permission denied...';
									}
								}
								if ($_GET['action'] == 'open_topic'){
									if(current_user_can('manage_options')) {
										$wpdb->query( "UPDATE " . $wpdb->base_prefix . "topics SET topic_closed = '0' WHERE topic_ID = '" . $_GET['topic'] . "' AND topic_forum_ID = '" . $tmp_fid . "'");
										$tmp_msg = 'Topic Opened!';
									} else {
										$tmp_msg = 'Permission denied...';
									}
								}
								$tmp_topic_title = $wpdb->get_var("SELECT topic_title FROM " . $wpdb->base_prefix . "topics WHERE topic_ID = '" . $_POST['tid'] . "'");
								$tmp_topic_last_updated = $wpdb->get_var("SELECT topic_last_updated_stamp FROM " . $wpdb->base_prefix . "topics WHERE topic_ID = '" . $_POST['tid'] . "'");
								$tmp_topic_last_author = $wpdb->get_var("SELECT topic_last_author FROM " . $wpdb->base_prefix . "topics WHERE topic_ID = '" . $_POST['tid'] . "'");
								$tmp_topic_closed = $wpdb->get_var("SELECT topic_closed FROM " . $wpdb->base_prefix . "topics WHERE topic_ID = '" . $_GET['topic'] . "'");
								
								if ($tmp_topic_closed == 1){
									$content = $content . '<h3>' . $tmp_topic_title . ' (' . __('Closed') . ')</h3>';					
								} else {
									$content = $content . '<h3>' . $tmp_topic_title . '</h3>';
								}
								if ($tmp_msg != ''){
								$content = $content . '<p><center>' . __($tmp_msg) . '</center></p>';
								}
								if ($_GET['msg'] != ''){
								$content = $content . '<p><center>' . __(urldecode($_GET['msg'])) . '</center></p>';
								}
								$content = $content . '<p><center>' . __('Error deleting topic...') . '</center></p>';
								$content = $content . '<br />';
								$content = $content . '<hr />';
								$content = $content . '<ul>';
								$content = $content . '<li>' . __('Last updated: ') . date("D, F jS Y g:i A",$tmp_topic_last_updated) . '</li>';
								$content = $content . '<li>' . __('Latest Reply From: ') . forums_author_display_name($tmp_topic_last_author) . '</li>';
								$content = $content . '</ul>';
								$content = $content . '<hr />';
								if(current_user_can('manage_options')) {
									$content = $content . '<center><a href="?action=delete_topic&tid=' . $_GET['topic'] . '">' . __('Delete Topic') . '</a> | ';
									if ($tmp_topic_closed == 1){
										$content = $content . '<a href="?topic=' . $_GET['topic'] . '&action=open_topic">' . __('Open Topic') . '</a>';
									} else {
										$content = $content . '<a href="?topic=' . $_GET['topic'] . '&action=close_topic">' . __('Close Topic') . '</a>';
									}
									$content = $content . '</center>';
									$content = $content . '<hr />';
								}
								$content = $content . forums_output_topic_nav($_POST['tid']);
								$content = $content . '<br />';
								$content = $content . forums_output_view_topic($_POST['tid'],$tmp_fid);
								$content = $content . '<br />';
								$content = $content . forums_output_topic_nav($_POST['tid']);
								$content = $content . '<br />';
								$content = $content . forums_output_new_post($tmp_fid,$_GET['tid'],0,'');
							} else {
								forums_forum_count_posts($tmp_fid);
								forums_forum_count_topics($tmp_fid);
								$content = $content . '<p><center>' . _('Topic Deleted!') . '</center></p>';
								$content = $content . forums_output_search_form($tmp_fid);
								$content = $content . '<br />';
								$content = $content . forums_output_forum_nav($tmp_fid);
								$content = $content . '<br />';
								$content = $content . forums_output_forum($tmp_fid);
								$content = $content . '<br />';
								$content = $content . forums_output_forum_nav($tmp_fid);
							}
						} else {
							$content = $content . '<p><center>' . __('Permission denied...') . '</center></p>';	
						}
					}
				} else {
					$content = $content . '<p><center>' . _('Invalid Topic!') . '</center></p>';
				}
			} else if ($_GET['action'] == 'delete_post'){
				$tmp_topic_count = 0;
				$tmp_post_count = 0;
				$tmp_forum_count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "forums WHERE forum_ID = '" . $tmp_fid . "' AND forum_blog_ID = '" . $wpdb->blogid . "'");
				if ($tmp_forum_count > 0){
					$tmp_topic_count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "topics WHERE topic_ID = '" . $_GET['tid'] . "' AND topic_forum_ID = '" . $tmp_fid . "'");	
				}
				if ($tmp_topic_count > 0){
					$tmp_post_count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "posts WHERE post_topic_ID = '" . $_GET['tid'] . "' AND post_ID = '" . $_GET['pid'] . "'");	
				}
				if ($tmp_post_count > 0){
					if(current_user_can('manage_options')) {
						$content = $content . forums_output_delete_post($_GET['pid'],$_GET['tid'],$_GET['page']);
					} else {
						$content = $content . '<p><center>' . __('Permission denied...') . '</center></p>';	
					}
				} else {
						$content = $content . '<p><center>' . __('Permission denied...') . '</center></p>';	
				}
			} else if ($_GET['action'] == 'delete_post_process'){
				if ( isset($_POST['Cancel']) ) {
					$content = $content . '<SCRIPT LANGUAGE="JavaScript">';
					$content = $content . 'window.location="?topic=' . $_POST['tid'] . '&page=' . $_POST['page'] . '#post-' . $_POST['pid'] . '";';
					$content = $content . '</script>';
				} else {
					$tmp_errors = forums_output_delete_post_process($tmp_fid,$_POST['pid'],$_POST['tid']);
					if ($tmp_errors > 0){
						$content = $content . '<SCRIPT LANGUAGE="JavaScript">';
						$content = $content . 'window.location="?topic=' . $_POST['tid'] . '&page=' . $_POST['page'] . '&msg=' . urlencode(__('Error deleting post')) . '#post-' . $_POST['pid'] . '";';
						$content = $content . '</script>';
					} else {
						$content = $content . '<SCRIPT LANGUAGE="JavaScript">';
						$content = $content . 'window.location="?topic=' . $_POST['tid'] . '&msg=' . urlencode(__('Post deleted')) . '";';
						$content = $content . '</script>';
					}
				}
					
			} else if ($_GET['action'] == 'edit_post'){
				$tmp_topic_count = 0;
				$tmp_post_count = 0;
				$tmp_forum_count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "forums WHERE forum_ID = '" . $tmp_fid . "' AND forum_blog_ID = '" . $wpdb->blogid . "'");
				if ($tmp_forum_count > 0){
					$tmp_topic_count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "topics WHERE topic_ID = '" . $_GET['tid'] . "' AND topic_forum_ID = '" . $tmp_fid . "'");	
				}
				if ($tmp_topic_count > 0){
					$tmp_post_count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "posts WHERE post_topic_ID = '" . $_GET['tid'] . "' AND post_ID = '" . $_GET['pid'] . "'");	
				}
				if ($tmp_post_count > 0){
					if(current_user_can('manage_options')) {
						//yep
						$content = $content . forums_output_edit_post($tmp_pid,$tmp_fid,$_GET['tid'],0,'',$_GET['page']);
					} else {
						$tmp_post_auhtor = $wpdb->get_var("SELECT post_author FROM " . $wpdb->base_prefix . "posts WHERE post_topic_ID = '" . $_GET['tid'] . "' AND post_ID = '" . $_GET['pid'] . "'");	
						if ($tmp_post_auhtor == $user_ID){
							//yep
							$content = $content . forums_output_edit_post($_GET['pid'],$tmp_fid,$_GET['tid'],0,'',$_GET['page']);
						} else {
							//nope
							$content = $content . '<p><center>' . __('Permission denied...') . '</center></p>';	
						}
					}
				} else {
						$content = $content . '<p><center>' . __('Permission denied...') . '</center></p>';	
				}
			} else if ($_GET['action'] == 'edit_post_process'){
				if ( isset($_POST['Cancel']) ) {
					$content = $content . '<SCRIPT LANGUAGE="JavaScript">';
					$content = $content . 'window.location="?topic=' . $_POST['tid'] . '&page=' . $_POST['page'] . '#post-' . $_POST['pid'] . '";';
					$content = $content . '</script>';
				} else {
					if ($_POST['post_content'] == ''){
							$content = $content . forums_output_edit_post($_POST['pid'],$tmp_fid,$_POST['tid'],1,'',$_POST['page']);
					} else {
						//auth check
						if(current_user_can('manage_options')) {
							forums_output_edit_post_process($tmp_fid,$_POST['pid'],$_POST['tid']);
							$content = $content . '<SCRIPT LANGUAGE="JavaScript">';
							$content = $content . 'window.location="?topic=' . $_POST['tid'] . '&page=' . $_POST['page'] . '&msg=' . urlencode(__('Post updated...')) . '";';
							
							$content = $content . '</script>';					
						} else {
							$tmp_post_auhtor = $wpdb->get_var("SELECT post_author FROM " . $wpdb->base_prefix . "posts WHERE post_topic_ID = '" . $_GET['tid'] . "' AND post_ID = '" . $_GET['pid'] . "'");	
							if ($tmp_post_auhtor == $user_ID){
								forums_output_edit_post_process($tmp_fid,$_POST['pid'],$_POST['tid']);
								$content = $content . '<SCRIPT LANGUAGE="JavaScript">';
								$content = $content . 'window.location="?topic=' . $_POST['tid'] . '&page=' . $_POST['page'] . '&msg=' . urlencode(__('Post updated...')) . '";';
							
								$content = $content . '</script>';
							} else {
								$content = $content . '<p><center>' . __('Permission denied...') . '</center></p>';	
							}
						}
					}
				}
			} else if ($_GET['action'] == 'new_post_process'){
				if ($user_ID == '' || $user_ID == '0'){
					$content = $content . '<p><center>' . _('You must be a registered and logged in user of') . ' <a href="http://' . $current_site->domain . $current_site->path . '">' . get_site_option('site_name') . '</a> ' . __('to post on this forum.') . '</center></p>';
				} else {
					$tmp_topic_closed = $wpdb->get_var("SELECT topic_closed FROM " . $wpdb->base_prefix . "topics WHERE topic_ID = '" . $_POST['tid'] . "'");
					if ($tmp_topic_closed != '1'){
						if ($_POST['post_content'] == ''){
								$content = $content . forums_output_new_post_separate($tmp_fid,$_POST['tid'],1,'');
						} else {
							$tmp_post_count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "posts WHERE post_topic_ID = '" . $_POST['tid'] . "' AND post_forum_ID = '" . $tmp_fid . "'");
							$tmp_total_pages = forums_roundup($tmp_post_count / $forums_posts_per_page, 0);
							forums_output_new_post_process($tmp_fid,$_POST['tid']);
							$content = $content . '<SCRIPT LANGUAGE="JavaScript">';
							$content = $content . 'window.location="?topic=' . $_POST['tid'] . '&page=' . $tmp_total_pages . '&msg=' . urlencode(__('Post added...')) . '";';
							$content = $content . '</script>';
						}
					}
				}
			} else if ($_POST['search'] != '' || $_GET['search'] != ''){
				$tmp_query = '';
				$tmp_query = $_POST['search'];
				if ($tmp_query == ''){
					$tmp_query = $_GET['search'];
				}
				$content = $content . forums_output_search_results($tmp_fid,$tmp_query);
			} else if ($_GET['action'] == '2'){
			} else {
				//Display Forum
				$content = $content . forums_output_search_form($tmp_fid);
				$content = $content . '<br />';	
				$content = $content . forums_output_forum_nav($tmp_fid);
				$content = $content . '<br />';
				$content = $content . forums_output_forum($tmp_fid);
				$content = $content . '<br />';
				$content = $content . forums_output_forum_nav($tmp_fid);
			}
		} else {
			$content = 'Invalid Forum Code';
		}
		//insert/post content
		$original_content = str_replace('[forum:' . $tmp_fid . ']','',$original_content);
		$content = $original_content . $content;
		/*
		if(preg_match("|[forum:[0-9]{1,20}]|",$original_content) == true) {
			$tmp_match_original = $original_content;
			preg_match("|[forum:[0-9]{1,20}]|",$tmp_match_original,$tmp_match_original);
			$tmp_fid = $tmp_match[0];
			$tmp_fid = str_replace('[forum:','',$tmp_fid);
			$tmp_fid = str_replace(']','',$tmp_fid);
		}
		*/
	}
	return $content;
}

function forums_output_search_results($tmp_fid,$tmp_query){
	global $wpdb, $user_ID, $forums_posts_per_page;

	$tmp_forum_color_one = $wpdb->get_var("SELECT forum_color_one FROM " . $wpdb->base_prefix . "forums WHERE forum_ID = '" . $tmp_fid . "' AND forum_blog_ID = '" . $wpdb->blogid . "'");
	$tmp_forum_color_two = $wpdb->get_var("SELECT forum_color_two FROM " . $wpdb->base_prefix . "forums WHERE forum_ID = '" . $tmp_fid . "' AND forum_blog_ID = '" . $wpdb->blogid . "'");
	$tmp_forum_color_header = $wpdb->get_var("SELECT forum_color_header FROM " . $wpdb->base_prefix . "forums WHERE forum_ID = '" . $tmp_fid . "' AND forum_blog_ID = '" . $wpdb->blogid . "'");
	$tmp_forum_color_border = $wpdb->get_var("SELECT forum_color_border FROM " . $wpdb->base_prefix . "forums WHERE forum_ID = '" . $tmp_fid . "' AND forum_blog_ID = '" . $wpdb->blogid . "'");
	$tmp_forum_border_size = $wpdb->get_var("SELECT forum_border_size FROM " . $wpdb->base_prefix . "forums WHERE forum_ID = '" . $tmp_fid . "' AND forum_blog_ID = '" . $wpdb->blogid . "'");
	$style = 'style="border-collapse: collapse;border-style: solid;border-width: ' . $tmp_forum_border_size . 'px;border-color: #' . $tmp_forum_color_border . ';"';

	$content = $content . '<h3>' . _('Search Results') . '</h3>';
	$content = $content . forums_output_search_form($tmp_fid);
	$content = $content . '<br />';
	$content = $content . '<h3>' . _('Posts:') . '</h3>';
	
	$query = "SELECT * FROM " . $wpdb->base_prefix . "posts WHERE post_forum_ID = '" . $tmp_fid . "' AND post_content LIKE '%" . $tmp_query . "%'";
	$query = $query . " ORDER BY post_ID ASC";
	$query = $query . " LIMIT 25";
	$tmp_results = $wpdb->get_results( $query, ARRAY_A );
	if (count($tmp_results) > 0){
		$alt_color = ('alternate' == $alt_color) ? '' : 'alternate';
		$tmp_counter = 0;
		$content = $content . '<table ' . $style . ' width="100%" cellpadding="0" cellspacing="0">';
		foreach ($tmp_results as $tmp_result){
			$tmp_counter = $tmp_counter + 1;
		//=========================================================//
			if ($alt_color == 'alternate'){
				$content =  $content . '<tr style="background-color:#' . $tmp_forum_color_one . '">';
			} else {
				$content =  $content . '<tr style="background-color:#' . $tmp_forum_color_two . '">';
			}
			$tmp_topic_title = $wpdb->get_var("SELECT topic_title FROM " . $wpdb->base_prefix . "topics WHERE topic_ID = '" . $tmp_result['post_topic_ID'] . "'");
			$tmp_topic_post_count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "posts WHERE post_topic_ID = '" . $tmp_result['post_topic_ID'] . "'");
			$content =  $content . '<td ' . $style . ' ><center>' . $tmp_counter . '.</center></td>';
			$content =  $content . '<td ' . $style . ' ><p>';
			if ($tmp_topic_post_count > $forums_posts_per_page){
				$content =  $content . '<strong><a href="?topic=' . $tmp_result['post_topic_ID'] . '#post-' . $tmp_result['post_ID'] . '">' . $tmp_topic_title . '</a></strong><br />';
			} else {
				$content =  $content . '<strong><a href="?topic=' . $tmp_result['post_topic_ID'] . '#post-' . $tmp_result['post_ID'] . '">' . $tmp_topic_title . '</a></strong><br />';
			}
			$content =  $content . str_replace($tmp_query,'<strong>' . $tmp_query . '</strong>',forums_display_post_content($tmp_result['post_content']));
			$content =  $content . '</p></td>';
			$content =  $content . '</tr>';
			$alt_color = ('alternate' == $alt_color) ? '' : 'alternate';
		//=========================================================//
		}
		$content = $content . '</table>';
	} else {
		$content =  $content . '<p><center>' . __('No matches...') . '</center></p>';
	}
	
	return $content;
}

function forums_output_search_form($tmp_fid){
	global $wpdb, $user_ID;
	
	$tmp_topic_count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "topics WHERE topic_forum_ID = '" . $tmp_fid . "'");
	
	$tmp_query = '';
	$tmp_query = $_POST['search'];
	if ($tmp_query == ''){
		$tmp_query = $_GET['search'];
	}
	
	if ($tmp_topic_count > 0){
		$content = $content . '<p><center>';
		$content = $content . '<form name="new_t" method="POST" action="?search=">';
		$content = $content . '<input type="hidden" name="uid" value="' . $user_ID . '" />';
		$content = $content . '<input type="hidden" name="fid" value="' . $tmp_fid . '" />';
		$content = $content . '<input type="hidden" name="query" value="' . $tmp_query . '" />';
		$content = $content . '<input type="text" name="search" id="search" style="width: 25%;" value="' . $tmp_query . '"/>';
		$content = $content . '<input type="submit" name="Submit" value="' . __('Search &raquo;') . '" />';
		$content = $content . '</form>';
		$content = $content . '</center></p>';
	} else {
		$content = '';
	}
	return $content;
}

function forums_output_new_post_process($tmp_fid,$tmp_tid) {
	global $wpdb, $user_ID;
	$wpdb->query( "INSERT INTO " . $wpdb->base_prefix . "posts (post_forum_ID, post_topic_ID, post_author, post_content, post_stamp) VALUES ( '" . $tmp_fid . "', '" . $tmp_tid . "', '" . $user_ID . "', '" . forums_save_post_content($_POST['post_content']) . "', '" . time() . "')" );
	$wpdb->query( "UPDATE " . $wpdb->base_prefix . "topics SET topic_last_author = '" . $user_ID . "' WHERE topic_ID = '" . $tmp_tid . "'" );
	$wpdb->query( "UPDATE " . $wpdb->base_prefix . "topics SET topic_last_updated_stamp = '" . time(). "' WHERE topic_ID = '" . $tmp_tid . "'" );
	
	forums_topic_count_posts($tmp_tid);
	forums_forum_count_posts($tmp_fid);
	forums_forum_count_topics($tmp_fid);
	
}

function forums_output_new_post_separate($tmp_fid,$tmp_tid,$tmp_errors,$tmp_error_msg = ''){
	global $wpdb, $user_ID, $current_site;
		
	if ($user_ID == '' || $user_ID == '0'){
		$content = $content . '<p><center>' . _('You must be a registered and logged in user of') . ' <a href="http://' . $current_site->domain . $current_site->path . '">' . get_site_option('site_name') . '</a> ' . __('to post on this forum.') . '</center></p>';
	} else {
		$tmp_topic_closed = $wpdb->get_var("SELECT topic_closed FROM " . $wpdb->base_prefix . "topics WHERE topic_ID = '" . $tmp_tid . "'");
		if ($tmp_topic_closed != '1'){
			$content = $content . '<h3>' . _('New Post') . '</h3>';
			if ($tmp_errors > 0){
				if ($tmp_error_msg == ''){
					$tmp_error_msg = 'You must fill in all required fields...';
				}
				$content = $content . '<p><center>' . _($tmp_error_msg) . '</center></p>';	
				
			}
			$content = $content . '<form name="new_topic" method="POST" action="?action=new_post_process">';
			$content = $content . '<input type="hidden" name="uid" value="' . $user_ID . '" />';
			$content = $content . '<input type="hidden" name="fid" value="' . $tmp_fid . '" />';
			$content = $content . '<input type="hidden" name="tid" value="' . $tmp_tid . '" />';
			$content = $content . '<fieldset style="border:none;">';
			$content = $content . '<table width="100%" cellspacing="2" cellpadding="5">';
			$content = $content . '<tr valign="top">';
			$content = $content . '<th scope="row">' . __('Post:') . '</th>';
			$content = $content . '<td><textarea name="post_content" id="post_content" style="width: 95%" rows="5">' . $_POST['post_content'] . '</textarea>';
			$content = $content . '<br />';
			$content = $content . __('Required') . '</td>';
			$content = $content . '</tr>';
			$content = $content . '</table>';
			$content = $content . '</fieldset>';
			$content = $content . '<p class="submit">';
			$content = $content . '<input type="submit" name="Submit" value="' . __('Send Post &raquo;') . '" />';
			$content = $content . '</p>';
			$content = $content . '</form>';
		}
	}
	return $content;
}

function forums_output_new_post($tmp_fid,$tmp_tid,$tmp_errors,$tmp_error_msg = '') {
	global $wpdb, $user_ID, $current_site;
		
	if ($user_ID == '' || $user_ID == '0'){
		$content = $content . '<hr />';
		$content = $content . '<p><center>' . _('You must be a registered and logged in user of') . ' <a href="http://' . $current_site->domain . $current_site->path . '">' . get_site_option('site_name') . '</a> ' . __('to post on this forum.') . '</center></p>';
	} else {
		$tmp_topic_closed = $wpdb->get_var("SELECT topic_closed FROM " . $wpdb->base_prefix . "topics WHERE topic_ID = '" . $tmp_tid . "'");
		if ($tmp_topic_closed != '1'){
			$content = $content . '<hr />';
			$content = $content . '<br />';
			$content = $content . '<h3>' . _('New Post') . '</h3>';
			if ($tmp_errors > 0){
				if ($tmp_error_msg == ''){
					$tmp_error_msg = 'You must fill in all required fields...';
				}
				$content = $content . '<p><center>' . _($tmp_error_msg) . '</center></p>';	
				
			}
			$content = $content . '<form name="new_topic" method="POST" action="?action=new_post_process">';
			$content = $content . '<input type="hidden" name="uid" value="' . $user_ID . '" />';
			$content = $content . '<input type="hidden" name="fid" value="' . $tmp_fid . '" />';
			$content = $content . '<input type="hidden" name="tid" value="' . $tmp_tid . '" />';
			$content = $content . '<fieldset style="border:none;">';
			$content = $content . '<table width="100%" cellspacing="2" cellpadding="5">';
			$content = $content . '<tr valign="top">';
			$content = $content . '<th scope="row">' . __('Post:') . '</th>';
			$content = $content . '<td><textarea name="post_content" id="post_content" style="width: 95%" rows="5">' . $_POST['post_content'] . '</textarea>';
			$content = $content . '<br />';
			$content = $content . __('Required') . '</td>';
			$content = $content . '</tr>';
			$content = $content . '</table>';
			$content = $content . '</fieldset>';
			$content = $content . '<p class="submit">';
			$content = $content . '<input type="submit" name="Submit" value="' . __('Send Post &raquo;') . '" />';
			$content = $content . '</p>';
			$content = $content . '</form>';
		}
	}
	return $content;
}

function forums_output_edit_post_process($tmp_fid,$tmp_pid,$tmp_tid) {
	global $wpdb, $user_ID;
	$wpdb->query( "UPDATE " . $wpdb->base_prefix . "posts SET post_content = '" . forums_save_post_content($_POST['post_content']) . "' WHERE post_ID = '" . $tmp_pid . "'" );

	$content = $content . forums_output_topic_nav($tmp_tid);
	$content = $content . '<br />';
	$content = $content . forums_output_view_topic($tmp_tid,$tmp_fid);
	$content = $content . '<br />';
	$content = $content . forums_output_topic_nav($tmp_tid);
	$content = $content . '<br />';
	$content = $content . forums_output_new_post($tmp_fid,$tmp_tid,0,'');
}

function forums_output_edit_post($tmp_pid,$tmp_fid,$tmp_tid,$tmp_errors,$tmp_error_msg = '',$tmp_page) {
	global $wpdb, $user_ID;
	$tmp_post_content = $wpdb->get_var("SELECT post_content FROM " . $wpdb->base_prefix . "posts WHERE post_topic_ID = '" . $_GET['tid'] . "' AND post_ID = '" . $_GET['pid'] . "'");	
	$content = $content . '<h3>' . _('Edit Post') . '</h3>';
	if ($tmp_errors > 0){
		if ($tmp_error_msg == ''){
			$tmp_error_msg = 'You must fill in all required fields...';
		}
		$content = $content . '<p><center>' . _($tmp_error_msg) . '</center></p>';	
		
	}
	$content = $content . '<form name="edit_post" method="POST" action="?action=edit_post_process">';
	$content = $content . '<input type="hidden" name="uid" value="' . $user_ID . '" />';
	if ($tmp_errors > 0){
		$content = $content . '<input type="hidden" name="pid" value="' . $_POST['pid'] . '" />';
	} else {
		$content = $content . '<input type="hidden" name="pid" value="' . $_GET['pid'] . '" />';
	}
	$content = $content . '<input type="hidden" name="tid" value="' . $tmp_tid . '" />';
	$content = $content . '<input type="hidden" name="fid" value="' . $tmp_fid . '" />';
	$content = $content . '<input type="hidden" name="page" value="' . $tmp_page . '" />';
	$content = $content . '<fieldset style="border:none;">';
	$content = $content . '<table width="100%" cellspacing="2" cellpadding="5">';
	$content = $content . '<tr valign="top">';
	$content = $content . '<th scope="row">' . __('Post:') . '</th>';
	if ($tmp_errors > 0){
		$content = $content . '<td><textarea name="post_content" id="post_content" style="width: 95%" rows="5">' . $_POST['post_content'] . '</textarea>';
	} else {
		$content = $content . '<td><textarea name="post_content" id="post_content" style="width: 95%" rows="5">' . stripslashes($tmp_post_content) . '</textarea>';
	}
	$content = $content . '<br />';
	$content = $content . __('Required') . '</td>';
	$content = $content . '</tr>';
	$content = $content . '</table>';
	$content = $content . '</fieldset>';
	$content = $content . '<p class="submit">';
	$content = $content . '<input type="submit" name="Submit" value="' . __('Update &raquo;') . '" />';
	$content = $content . '<input type="submit" name="Cancel" value="' . __('Cancel &raquo;') . '" />';
	$content = $content . '</p>';
	$content = $content . '</form>';
	return $content;
}

function forums_output_delete_post_process($tmp_fid,$tmp_pid,$tmp_tid) {
	global $wpdb, $user_ID;
	
	$wpdb->query( "DELETE FROM " . $wpdb->base_prefix . "posts WHERE post_topic_ID = '" . $tmp_tid . "' AND post_ID = '" . $tmp_pid . "'" );

	$content = $content . forums_output_topic_nav($tmp_tid);
	$content = $content . '<br />';
	$content = $content . forums_output_view_topic($tmp_tid,$tmp_fid);
	$content = $content . '<br />';
	$content = $content . forums_output_topic_nav($tmp_tid);
	$content = $content . '<br />';
	$content = $content . forums_output_new_post($tmp_fid,$tmp_tid,0,'');
	
	$error_count = 0;
	
	$tmp_post_count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "posts WHERE post_topic_ID = '" . $tmp_tid . "' AND post_ID = '" . $tmp_pid . "'");	
	
	if ($tmp_post_count > 0){
		$error_count = $error_count + 1;
	}

	return $error_count;
}

function forums_output_delete_post($tmp_pid,$tmp_tid,$tmp_page) {
	global $wpdb, $user_ID;
	if ($user_ID == '' || $user_ID == '0'){
		$content = $content . '<h3>' . _('Delete Post') . '</h3>';
		$content = $content . '<p><center>' . _('You must be logged in...') . '</center></p>';	
	} else {
		$content = $content . '<h3>' . _('Delete Post') . '</h3>';
		$content = $content . '<br />';
		$content = $content . '<p>' . __('Are you sure you want to delete this post?') . '</p>';	
		$content = $content . '<form name="delete_topic" method="POST" action="?action=delete_post_process">';
		$content = $content . '<input type="hidden" name="uid" value="' . $user_ID . '" />';
		$content = $content . '<input type="hidden" name="pid" value="' . $tmp_pid . '" />';
		$content = $content . '<input type="hidden" name="tid" value="' . $tmp_tid . '" />';
		$content = $content . '<input type="hidden" name="page" value="' . $tmp_page . '" />';
		$content = $content . '<p class="submit">';
		$content = $content . '<input type="submit" name="Submit" value="' . __('Delete &raquo;') . '" />';
		$content = $content . '<input type="submit" name="Cancel" value="' . __('Cancel &raquo;') . '" />';
		$content = $content . '</p>';
		$content = $content . '</form>';
	}
	return $content;
}

function forums_output_delete_topic_process($tmp_fid,$tmp_tid) {
	global $wpdb, $user_ID;
	
	$wpdb->query( "DELETE FROM " . $wpdb->base_prefix . "topics WHERE topic_ID = '" . $tmp_tid . "' AND topic_forum_ID = '" . $tmp_fid . "'" );
	$wpdb->query( "DELETE FROM " . $wpdb->base_prefix . "posts WHERE post_topic_ID = '" . $tmp_tid . "' AND post_forum_ID = '" . $tmp_fid . "'" );

	forums_forum_count_posts($tmp_fid);
	forums_forum_count_topics($tmp_fid);
	
	$error_count = 0;
	
	$tmp_topic_count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "topics WHERE topic_ID = '" . $tmp_tid . "' AND topic_forum_ID = '" . $tmp_fid . "'");	
	
	if ($tmp_topic_count > 0){
		$error_count = $error_count + 1;
	}

	return $error_count;
}

function forums_output_delete_topic($tmp_fid,$tmp_tid) {
	global $wpdb, $user_ID;
	if ($user_ID == '' || $user_ID == '0'){
		$content = $content . '<h3>' . _('Delete Topic') . '</h3>';
		$content = $content . '<p><center>' . _('You must be logged in...') . '</center></p>';	
	} else {
		$content = $content . '<h3>' . _('Delete Topic') . '</h3>';
		$content = $content . '<br />';
		$content = $content . '<p>' . __('Are you sure you want to delete this topic?') . '</p>';	
		$content = $content . '<form name="delete_topic" method="POST" action="?action=delete_topic_process">';
		$content = $content . '<input type="hidden" name="uid" value="' . $user_ID . '" />';
		$content = $content . '<input type="hidden" name="fid" value="' . $tmp_fid . '" />';
		$content = $content . '<input type="hidden" name="tid" value="' . $tmp_tid . '" />';
		$content = $content . '<p class="submit">';
		$content = $content . '<input type="submit" name="Submit" value="' . __('Delete &raquo;') . '" />';
		$content = $content . '<input type="submit" name="Cancel" value="' . __('Cancel &raquo;') . '" />';
		$content = $content . '</p>';
		$content = $content . '</form>';
	}
	return $content;
}

function forums_output_topic_nav($tmp_tid){
	global $wpdb, $forums_posts_per_page;	
	$tmp_post_count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "posts WHERE post_topic_ID = '" . $tmp_tid . "'");
	//=========================================//
	$tmp_current_page = $_GET['page'];
	if ($tmp_current_page == ''){
		$tmp_current_page = 1;
	}
	$tmp_total_pages = forums_roundup($tmp_post_count / $forums_posts_per_page, 0);
	$tmp_showing_low = ($tmp_current_page * $forums_posts_per_page) - ($forums_posts_per_page - 1);
	if ($tmp_total_pages == $tmp_current_page){
		//last page...
		$tmp_showing_high = $tmp_post_count;
	} else {
		$tmp_showing_high = $tmp_current_page * $forums_posts_per_page;
	}
	//=========================================//
	$content = $content . '<table border="0" width="100%" cellpadding="0" cellspacing="0">';
	$content = $content . '<tr>';
	if ($tmp_current_page == 1){
		$content = $content . '<td width="25%" style="text-align:left"></td>';
	} else {
		$tmp_previus_page = $tmp_current_page - 1;
		$content = $content . '<td width="25%" style="text-align:left"><a href="?topic=' . $_GET['topic'] . '&page=' . $tmp_previus_page . '">' . __(' &laquo; Previous') . '</a></td>';
	}
	$content = $content . '<td><center>' . __('Showing ') . $tmp_showing_low . __( ' > ') . $tmp_showing_high . __(' of ') . $tmp_post_count . __(' posts ') . '</center></td>';
	if ($tmp_current_page == $tmp_total_pages){
		//last page
		$content = $content . '<td width="25%" style="text-align:right"></td>';
	} else {
		$tmp_next_page = $tmp_current_page + 1;
		$content = $content . '<td width="25%" style="text-align:right"><a href="?topic=' . $_GET['topic'] . '&page=' . $tmp_next_page . '">' . __('Next  &raquo;') . '</a></td>';
	}
	$content = $content . '</tr>';
	$content = $content . '</table>';
	return $content;
}

function forums_output_forum_nav($tmp_fid){
	global $wpdb, $forums_topics_per_page;	
	$tmp_topic_count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "topics WHERE topic_forum_ID = '" . $tmp_fid . "'");
	//=========================================//
	$tmp_current_page = $_GET['page'];
	if ($tmp_current_page == ''){
		$tmp_current_page = 1;
	}
	$tmp_total_pages = forums_roundup($tmp_topic_count / $forums_topics_per_page, 0);
	$tmp_showing_low = ($tmp_current_page * $forums_topics_per_page) - ($forums_topics_per_page - 1);
	if ($tmp_total_pages == $tmp_current_page){
		//last page...
		$tmp_showing_high = $tmp_topic_count;
	} else {
		$tmp_showing_high = $tmp_current_page * $forums_topics_per_page;
	}
	//=========================================//
	if ($tmp_topic_count > 0){
		$content = $content . '<table border="0" width="100%" cellpadding="0" cellspacing="0">';
		$content = $content . '<tr>';
		if ($tmp_current_page == 1){
			$content = $content . '<td width="25%" style="text-align:left"></td>';
		} else {
			$tmp_previus_page = $tmp_current_page - 1;
			$content = $content . '<td width="25%" style="text-align:left"><a href="?page=' . $tmp_previus_page . '">' . __(' &laquo; Previous') . '</a></td>';
		}
		$content = $content . '<td ><center>' . __('Showing ') . $tmp_showing_low . __( ' > ') . $tmp_showing_high . __(' of ') . $tmp_topic_count . __(' topics ') . '</center></td>';
		if ($tmp_current_page == $tmp_total_pages){
			//last page
			$content = $content . '<td width="25%" style="text-align:right"></td>';
		} else {
			$tmp_next_page = $tmp_current_page + 1;
			$content = $content . '<td width="25%" style="text-align:right"><a href="?page=' . $tmp_next_page . '">' . __('Next  &raquo;') . '</a></td>';
		}
		$content = $content . '</tr>';
		$content = $content . '</table>';
	}
	return $content;
}

function forums_output_view_topic($tmp_tid,$tmp_fid){
	global $wpdb, $user_ID,  $forums_posts_per_page;
	$tmp_forum_color_one = $wpdb->get_var("SELECT forum_color_one FROM " . $wpdb->base_prefix . "forums WHERE forum_ID = '" . $tmp_fid . "' AND forum_blog_ID = '" . $wpdb->blogid . "'");
	$tmp_forum_color_two = $wpdb->get_var("SELECT forum_color_two FROM " . $wpdb->base_prefix . "forums WHERE forum_ID = '" . $tmp_fid . "' AND forum_blog_ID = '" . $wpdb->blogid . "'");
	$tmp_forum_color_header = $wpdb->get_var("SELECT forum_color_header FROM " . $wpdb->base_prefix . "forums WHERE forum_ID = '" . $tmp_fid . "' AND forum_blog_ID = '" . $wpdb->blogid . "'");
	$tmp_forum_color_border = $wpdb->get_var("SELECT forum_color_border FROM " . $wpdb->base_prefix . "forums WHERE forum_ID = '" . $tmp_fid . "' AND forum_blog_ID = '" . $wpdb->blogid . "'");
	$tmp_forum_border_size = $wpdb->get_var("SELECT forum_border_size FROM " . $wpdb->base_prefix . "forums WHERE forum_ID = '" . $tmp_fid . "' AND forum_blog_ID = '" . $wpdb->blogid . "'");
	$style = 'style="border-collapse: collapse;border-style: solid;border-width: ' . $tmp_forum_border_size . 'px;border-color: #' . $tmp_forum_color_border . ';"';
	
	//=========================================//
	$tmp_current_page = $_GET['page'];
	if ($tmp_current_page == ''){
		$tmp_current_page = 1;
	}
	if ($tmp_current_page == 1){
		$tmp_start = 0;
	} else {
		$tmp_math = $tmp_current_page - 1;
		$tmp_math = $forums_posts_per_page * $tmp_math;
		//$tmp_math = $tmp_math - 1;
		$tmp_start = $tmp_math;
	}
	//=========================================//
	
	$query = "SELECT * FROM " . $wpdb->base_prefix . "posts WHERE post_topic_ID = '" . $tmp_tid . "'";
	$query = $query . " ORDER BY post_ID ASC";
	$query = $query . " LIMIT " . intval( $tmp_start ) . ", " . intval( $forums_posts_per_page );
	$tmp_posts = $wpdb->get_results( $query, ARRAY_A ); 
	if (count($tmp_posts) > 0){
		$alt_color = ('alternate' == $alt_color) ? '' : 'alternate';
		//=========================================================//
		$content = '<table ' . $style . ' width="100%" cellpadding="0" cellspacing="0">';
		//=========================================================//
		foreach ($tmp_posts as $tmp_post){
			if ($alt_color == 'alternate'){
				$content =  $content . '<tr style="background-color:#' . $tmp_forum_color_two . '">';
			} else {
				$content =  $content . '<tr style="background-color:#' . $tmp_forum_color_one . '">';
			}
			$tmp_blog_id = $wpdb->get_var("SELECT meta_value FROM " . $wpdb->base_prefix . "usermeta WHERE meta_key = 'primary_blog' AND user_id = '" . $tmp_post['post_author'] . "'");
			$tmp_blog_domain = $wpdb->get_var("SELECT domain FROM " . $wpdb->base_prefix . "blogs WHERE blog_id = '" . $tmp_blog_id . "'");
			$tmp_blog_path = $wpdb->get_var("SELECT path FROM " . $wpdb->base_prefix . "blogs WHERE blog_id = '" . $tmp_blog_id . "'");
			if ($tmp_blog_id == ''){
				$content =  $content . '<td ' . $style . ' width="20%" style="text-align:left" ><p style="padding-left:10px;"><a name="post-' . $tmp_post['post_ID'] . '" id="post-' . $tmp_post['post_ID'] . '"></a>' . forums_author_display_name($tmp_post['post_author']) . '<br />' . get_avatar( $tmp_post['post_author'], '48', get_option('avatar_default') ) . '</p></td>';
			} else {
				$content =  $content . '<td ' . $style . ' width="20%" style="text-align:left" ><p style="padding-left:10px;"><a name="post-' . $tmp_post['post_ID'] . '" id="post-' . $tmp_post['post_ID'] . '"></a>' . forums_author_display_name($tmp_post['post_author']) . '<br /><a href="http://' . $tmp_blog_domain . $tmp_blog_path . '">' . get_avatar( $tmp_post['post_author'], '48', get_option('avatar_default') ) . '</a></p></td>';
			}
			$content =  $content . '<td ' . $style . ' width="80%" ><p style="padding-left:10px;">' . forums_display_post_content($tmp_post['post_content']) . '</li><p><hr /><div style="padding-left:10px;">';
			$content =  $content . __('Posted: ') . date("D, F jS Y g:i A",$tmp_post['post_stamp']);
			$content =  $content . ' <a href="?topic=' . $tmp_tid . '&page=' . $tmp_current_page . '#post-' . $tmp_post['post_ID'] . '">#</a> ';
			$tmp_now = time;
			$tmp_then = $tmp_post['post_stamp'];
			$tmp_ago = $tmp_now - $tmp_then;
			if(current_user_can('manage_options')){
				$tmp_post_count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "posts WHERE post_topic_ID = '" . $tmp_tid . "'");	
				if ($tmp_post_count > 1){
					$content =  $content . '<a href="?action=edit_post&page=' . $tmp_current_page . '&tid=' . $tmp_tid . '&pid=' . $tmp_post['post_ID'] . '">' . __('Edit') . '</a>|<a href="?action=delete_post&page=' . $tmp_current_page . '&tid=' . $tmp_tid . '&pid=' . $tmp_post['post_ID'] . '">' . __('Delete') . '</a>';		
				} else {
					$content =  $content . '<a href="?action=edit_post&page=' . $tmp_current_page . '&tid=' . $tmp_tid . '&pid=' . $tmp_post['post_ID'] . '">' . __('Edit') . '</a>';
				}
			} else if ($tmp_ago < 1800){
				if ($tmp_post['post_author'] == $user_ID){
					$content =  $content . '<a href="?action=edit_post&page=' . $tmp_current_page . '&tid=' . $tmp_tid . '&pid=' . $tmp_post['post_ID'] . '">' . __('Edit') . '</a>';
				}
			}
			$content =  $content . '</div></td>';
			$content =  $content . '</tr>';
			$alt_color = ('alternate' == $alt_color) ? '' : 'alternate';
		//=========================================================//
		}
		//=========================================================//
		$content = $content . '</table>';
		//=========================================================//
	} else {
		$content =  $content . '<table border="0" width="100%" cellpadding="0" cellspacing="0">';
		$content =  $content . '<tr>';
		$content =  $content . '<td><center>' . __('No posts to display...') . '</center></td>';
		$content =  $content . '</tr>';
		$content =  $content . '</table>';
	}

	return $content;
}

function forums_topic_process($tmp_fid) {
	global $wpdb, $user_ID;
	
	$tmp_time = time();
	$wpdb->query( "INSERT INTO " . $wpdb->base_prefix . "topics (topic_forum_ID, topic_title, topic_author, topic_last_author, topic_stamp, topic_last_updated_stamp) VALUES ( '" . $tmp_fid . "', '" . addslashes($_POST['topic_title']) . "', '" . $_POST['uid'] . "', '" . $_POST['uid'] . "', '" . $tmp_time . "', '" . $tmp_time . "')" );
	$tmp_tid = $wpdb->get_var("SELECT topic_ID FROM " . $wpdb->base_prefix . "topics WHERE topic_stamp = '" . $tmp_time . "' AND topic_title = '" . addslashes($_POST['topic_title']) . "' AND topic_author = '" . $_POST['uid'] . "'");
	$wpdb->query( "INSERT INTO " . $wpdb->base_prefix . "posts (post_forum_ID, post_topic_ID, post_author, post_content, post_stamp) VALUES ( '" . $tmp_fid . "', '" . $tmp_tid . "', '" . $_POST['uid'] . "', '" . $_POST['post_content'] . "', '" . $tmp_time . "')" );
	
	forums_topic_count_posts($tmp_tid);
	forums_forum_count_posts($tmp_fid);
	forums_forum_count_topics($tmp_fid);
	
	return 	$tmp_tid;
}

function forums_output_new_topic($tmp_fid, $tmp_errors,$tmp_error_msg = '') {
	global $wpdb, $user_ID;
	if ($user_ID == '' || $user_ID == '0'){
		$content = $content . '<h3>' . _('New Topic') . '</h3>';
		$content = $content . '<p><center>' . _('You must be logged in...') . '</center></p>';	
	} else {
		$content = $content . '<h3>' . _('New Topic') . '</h3>';
		if ($tmp_errors > 0){
			if ($tmp_error_msg == ''){
				$tmp_error_msg = 'You must fill in all required fields...';
			}
			$content = $content . '<p><center>' . _($tmp_error_msg) . '</center></p>';	
			
		}
		$content = $content . '<form name="new_topic" method="POST" action="?action=new_topic_process">';
		$content = $content . '<input type="hidden" name="uid" value="' . $user_ID . '" />';
		$content = $content . '<input type="hidden" name="fid" value="' . $tmp_fid . '" />';
		$content = $content . '<fieldset style="border:none;">';
		$content = $content . '<table width="100%" cellspacing="2" cellpadding="5">';
		$content = $content . '<tr valign="top">';
		$content = $content . '<th scope="row">' . __('Title:') . '</th>';
		$content = $content . '<td><input type="text" name="topic_title" id="topic_title" style="width: 95%" value="' . $_POST['topic_title'] . '"/>';
		$content = $content . '<br />';
		$content = $content . __('Required') . '</td>';
		$content = $content . '</tr>';
		$content = $content . '<tr valign="top">';
		$content = $content . '<th scope="row">' . __('Post:') . '</th>';
		$content = $content . '<td><textarea name="post_content" id="post_content" style="width: 95%" rows="5">' . $_POST['post_content'] . '</textarea>';
		$content = $content . '<br />';
		$content = $content . __('Required') . '</td>';
		$content = $content . '</tr>';
		$content = $content . '</table>';
		$content = $content . '</fieldset>';
		$content = $content . '<p class="submit">';
		$content = $content . '<input type="submit" name="Submit" value="' . __('Send Post &raquo;') . '" />';
		$content = $content . '</p>';
		$content = $content . '</form>';
	}
	return $content;
}

function forums_output_forum($tmp_fid) {
	global $wpdb, $user_ID;
	$tmp_forum_color_header = $wpdb->get_var("SELECT forum_color_header FROM " . $wpdb->base_prefix . "forums WHERE forum_ID = '" . $tmp_fid . "' AND forum_blog_ID = '" . $wpdb->blogid . "'");
	$tmp_forum_color_border = $wpdb->get_var("SELECT forum_color_border FROM " . $wpdb->base_prefix . "forums WHERE forum_ID = '" . $tmp_fid . "' AND forum_blog_ID = '" . $wpdb->blogid . "'");
	$tmp_forum_border_size = $wpdb->get_var("SELECT forum_border_size FROM " . $wpdb->base_prefix . "forums WHERE forum_ID = '" . $tmp_fid . "' AND forum_blog_ID = '" . $wpdb->blogid . "'");
	$style = 'style="border-collapse: collapse;border-style: solid;border-width: ' . $tmp_forum_border_size . 'px;border-color: #' . $tmp_forum_color_border . ';padding-top:5px;padding-bottom:5px;"';
	
	$tmp_topic_count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "topics WHERE topic_forum_ID = '" . $tmp_fid . "'");
	
	if ($tmp_topic_count > 0){
		if ($user_ID == '' || $user_ID == '0'){
			$content = '<table ' . $style . ' width="100%" cellpadding="0" cellspacing="0">
			<tr style="background-color:#' . $tmp_forum_color_header . ';">
				<td ' . $style . ' ><center>' . __('TOPICS') . '</center></td>
				<td ' . $style . ' ><center>' . __('POSTS') . '</center></td>
				<td ' . $style . ' ><center>' . __('LATEST POSTER') . '</center></td>
			</tr>';
		} else {
			$content = '<table ' . $style . ' width="100%" cellpadding="0" cellspacing="0">
			<tr style="background-color:#' . $tmp_forum_color_header . ';">
				<td ' . $style . ' ><center>' . __('TOPICS') . '(<a href="?action=new_topic">' . __('NEW') . '</a>)</center></td>
				<td ' . $style . ' ><center>' . __('POSTS') . '</center></td>
				<td ' . $style . ' ><center>' . __('LATEST POSTER') . '</center></td>
			</tr>';
		
		}
	}
	$content = $content . forums_output_topics($tmp_fid);
	if ($tmp_topic_count > 0){
		$content = $content . '</table>';
	}
	return $content;
}

function forums_output_topics($tmp_fid) {
	global $wpdb, $forums_topics_per_page, $user_ID;
	$tmp_forum_color_one = $wpdb->get_var("SELECT forum_color_one FROM " . $wpdb->base_prefix . "forums WHERE forum_ID = '" . $tmp_fid . "' AND forum_blog_ID = '" . $wpdb->blogid . "'");
	$tmp_forum_color_two = $wpdb->get_var("SELECT forum_color_two FROM " . $wpdb->base_prefix . "forums WHERE forum_ID = '" . $tmp_fid . "' AND forum_blog_ID = '" . $wpdb->blogid . "'");
	$tmp_forum_color_header = $wpdb->get_var("SELECT forum_color_header FROM " . $wpdb->base_prefix . "forums WHERE forum_ID = '" . $tmp_fid . "' AND forum_blog_ID = '" . $wpdb->blogid . "'");
	$tmp_forum_color_border = $wpdb->get_var("SELECT forum_color_border FROM " . $wpdb->base_prefix . "forums WHERE forum_ID = '" . $tmp_fid . "' AND forum_blog_ID = '" . $wpdb->blogid . "'");
	$tmp_forum_border_size = $wpdb->get_var("SELECT forum_border_size FROM " . $wpdb->base_prefix . "forums WHERE forum_ID = '" . $tmp_fid . "' AND forum_blog_ID = '" . $wpdb->blogid . "'");
	$style = 'style="border-collapse: collapse;border-style: solid;border-width: ' . $tmp_forum_border_size . 'px;border-color: #' . $tmp_forum_color_border . ';padding-top:5px;padding-bottom:5px;"';

	//=========================================//
	$tmp_current_page = $_GET['page'];
	if ($tmp_current_page == ''){
		$tmp_current_page = 1;
	}
	if ($tmp_current_page == 1){
		$tmp_start = 0;
	} else {
		$tmp_math = $tmp_current_page - 1;
		$tmp_math = $forums_topics_per_page * $tmp_math;
		//$tmp_math = $tmp_math - 1;
		$tmp_start = $tmp_math;
	}
	//=========================================//
	
	$query = "SELECT * FROM " . $wpdb->base_prefix . "topics WHERE topic_forum_ID = '" . $tmp_fid . "'";
	$query = $query . " ORDER BY topic_last_updated_stamp DESC";
	$query = $query . " LIMIT " . intval( $tmp_start ) . ", " . intval( $forums_topics_per_page );
	$tmp_topics = $wpdb->get_results( $query, ARRAY_A );
	if (count($tmp_topics) > 0){
		$alt_color = ('alternate' == $alt_color) ? '' : 'alternate';
		foreach ($tmp_topics as $tmp_topic){
		//=========================================================//
			if ($alt_color == 'alternate'){
				$content =  $content . '<tr style="background-color:#' . $tmp_forum_color_one . '">';
			} else {
				$content =  $content . '<tr style="background-color:#' . $tmp_forum_color_two . '">';
			}
			if ($tmp_topic['topic_closed'] == 1){
				$content =  $content . '<td ' . $style . ' ><center><a href="?topic=' . $tmp_topic['topic_ID'] . '">' . stripslashes($tmp_topic['topic_title']) . ' (' . __('Closed') . ')</a></center></td>';		
			} else {
				$content =  $content . '<td ' . $style . ' ><center><a href="?topic=' . $tmp_topic['topic_ID'] . '">' . stripslashes($tmp_topic['topic_title']) . '</a></center></td>';
			}
			$content =  $content . '<td ' . $style . ' ><center>' . $tmp_topic['topic_posts'] . '</center></td>';
			$content =  $content . '<td ' . $style . ' ><center>' . forums_author_display_name($tmp_topic['topic_last_author']) . '</center></td>';
			$content =  $content . '</tr>';
			$alt_color = ('alternate' == $alt_color) ? '' : 'alternate';
		//=========================================================//
		}
	} else {
		if ($user_ID == '' || $user_ID == '0'){
			$content =  $content . '<table border="0" width="100%" cellpadding="0" cellspacing="0">';
			$content =  $content . '<tr>';
			$content =  $content . '<td><center>' . __('No topics to display...') . '</center></td>';
			$content =  $content . '</tr>';
			$content =  $content . '</table>';
		} else {
			$content =  $content . '<table border="0" width="100%" cellpadding="0" cellspacing="0">';
			$content =  $content . '<tr>';
			$content =  $content . '<td><center>' . __('No topics to display... ') . '<a href="?action=new_topic">' . __('Click here') . '</a>' . __(' to create a new topic.') . '</center></td>';
			$content =  $content . '</tr>';
			$content =  $content . '</table>';
		}
	}
	/*	
	$content = '<tr>
		<td>Table Cell</td>
		<td>Table Cell</td>
		<td>Table Cell</td>
	</tr>
	<tr>
		<td>Table Cell</td>
		<td>Table Cell</td>
		<td>Table Cell</td>
	</tr>';
	*/
	return $content;
}

function forums_topic_count_posts($tmp_tid) {
	global $wpdb;
	$tmp_post_count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "posts WHERE post_topic_ID = '" . $tmp_tid . "'");
	$wpdb->query( "UPDATE " . $wpdb->base_prefix . "topics SET topic_posts = '" . $tmp_post_count . "' WHERE topic_ID = '" . $tmp_tid . "'" );
}
function forums_forum_count_posts($tmp_fid) {
	global $wpdb;
	$tmp_post_count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "posts WHERE post_forum_ID = '" . $tmp_fid . "'");
	$wpdb->query( "UPDATE " . $wpdb->base_prefix . "forums SET forum_posts = '" . $tmp_post_count . "' WHERE forum_ID = '" . $tmp_fid . "'" );
}
function forums_forum_count_topics($tmp_fid) {
	global $wpdb;
	$tmp_topic_count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "topics WHERE topic_forum_ID = '" . $tmp_fid . "'");
	$wpdb->query( "UPDATE " . $wpdb->base_prefix . "forums SET forum_topics = '" . $tmp_topic_count . "' WHERE forum_ID = '" . $tmp_fid . "'" );
}

//------------------------------------------------------------------------//
//---Page Output Functions------------------------------------------------//
//------------------------------------------------------------------------//

function forums_manage_output() {
	global $wpdb, $forums_max_forums, $forums_enable_upgrades;
	
	if(!current_user_can('manage_options')) {
		echo "<p>" . __('Nice Try...') . "</p>";  //If accessed properly, this message doesn't appear.
		return;
	}
	/*
	if (isset($_GET['updated'])) {
		?><div id="message" class="updated fade"><p><?php _e('' . urldecode($_GET['updatedmsg']) . '') ?></p></div><?php
	}
	*/
	echo '<div class="wrap">';
	switch( $_GET[ 'action' ] ) {
		//---------------------------------------------------//
		default:
		$tmp_forums_count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "forums WHERE forum_blog_ID = '" . $wpdb->blogid . "'");
			if ($tmp_forums_count < $forums_max_forums){
			?>
            <h2><?php _e('Manage Forums') ?> (<a href="forums.php?action=new_forum"><?php _e('New') ?></a>)</h2>
            <?php
			} else {
			?>
            <h2><?php _e('Manage Forums') ?></h2>
            <?php
				if ($forums_enable_upgrades == '1'){
					if (upgrades_active_feature('68daf8bdc8755fe8f4859024b3054fb8') != 'active'){
						forums_upgrades_advertise();
					}
				}			
			}
			if ($tmp_forums_count == 0){
			?>
            <p><?php _e('Click ') ?><a href="forums.php?action=new_forum"><?php _e('here') ?></a><?php _e(' to add a new forum.') ?></p>
            <?php
			} else {
			$query = "SELECT * FROM " . $wpdb->base_prefix . "forums WHERE forum_blog_ID = '" . $wpdb->blogid . "' ORDER BY forum_ID DESC";
			$tmp_forums = $wpdb->get_results( $query, ARRAY_A );
			echo "
			<table cellpadding='3' cellspacing='3' width='100%' class='widefat'> 
			<thead><tr>
			<th scope='col'>ID</th>
			<th scope='col'>Name</th>
			<th scope='col'>Topics</th>
			<th scope='col'>Posts</th>
			<th scope='col'>Page Code</th>
			<th scope='col'>Actions</th>
			<th scope='col'></th>
			</tr></thead>
			<tbody id='the-list'>
			";
			if (count($tmp_forums) > 0){
				$class = ('alternate' == $class) ? '' : 'alternate';
				foreach ($tmp_forums as $tmp_forum){
				//=========================================================//
				echo "<tr class='" . $class . "'>";
				echo "<td valign='top'><strong>" . $tmp_forum['forum_ID'] . "</strong></td>";
				echo "<td valign='top'>" . $tmp_forum['forum_name'] . "</td>";
				echo "<td valign='top'>" . $tmp_forum['forum_topics'] . "</td>";
				echo "<td valign='top'>" . $tmp_forum['forum_posts'] . "</td>";
				$tmp_page_code = '[forum:' . $tmp_forum['forum_ID'] . ']';
				echo "<td valign='top'>" . $tmp_page_code . "</td>";
				echo "<td valign='top'><a href='forums.php?action=edit_forum&fid=" . $tmp_forum['forum_ID'] . "' rel='permalink' class='edit'>" . __('Edit') . "</a></td>";
				echo "<td valign='top'><a href='forums.php?action=delete_forum&fid=" . $tmp_forum['forum_ID'] . "' rel='permalink' class='delete'>" . __('Remove') . "</a></td>";
				echo "</tr>";
				$class = ('alternate' == $class) ? '' : 'alternate';
				//=========================================================//
				}
			}
			?>
			</tbody></table>
            <?php
			}
		break;
		//---------------------------------------------------//
		case "new_forum":
			$tmp_forums_count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "forums WHERE forum_blog_ID = '" . $wpdb->blogid . "'");
			if ($tmp_forums_count < $forums_max_forums){
				?>
				<h2><?php _e('New Forum') ?></h2>
				<form name="form1" method="POST" action="forums.php?action=new_forum_process"> 
					<table class="form-table">
					<tr valign="top">
					<th scope="row"><?php _e('Name') ?></th>
					<td><input type="text" name="forum_name" id="forum_name" style="width: 95%" value="<?php echo $_POST['forum_name']; ?>" />
					<br />
					<?php _e('Required') ?></td> 
					</tr>
					<tr valign="top">
					<th scope="row"><?php _e('Description') ?></th>
					<td><textarea name="forum_description" id="forum_description" style="width: 95%" rows="5"><?php echo $_POST['forum_description']; ?></textarea>
					<br />
					<?php _e('Optional') ?></td> 
					</tr>
					<tr valign="top">
					<th scope="row"><?php _e('Color One') ?></th>
					<td><input type="text" name="forum_color_one" id="forum_color_one" style="width: 10%"  maxlength="7" value="<?php echo $_POST['forum_color_one']; ?>" />
					<br />
					<?php _e('Optional - Ex: 000000 OR FFFFFF') ?></td> 
					</tr>
					<tr valign="top">
					<th scope="row"><?php _e('Color Two') ?></th>
					<td><input type="text" name="forum_color_two" id="forum_color_two" style="width: 10%"  maxlength="7" value="<?php echo $_POST['forum_color_two']; ?>" />
					<br />
					<?php _e('Optional - Ex: 000000 OR FFFFFF') ?></td> 
					</tr>
					<tr valign="top">
					<th scope="row"><?php _e('Header Color') ?></th>
					<td><input type="text" name="forum_color_header" id="forum_color_header" style="width: 10%"  maxlength="7" value="<?php echo $_POST['forum_color_header']; ?>" />
					<br />
					<?php _e('Optional - Ex: 000000 OR FFFFFF') ?></td> 
					</tr>
					<tr valign="top">
					<th scope="row"><?php _e('Border Color') ?></th>
					<td><input type="text" name="forum_color_border" id="forum_color_border" style="width: 10%"  maxlength="7" value="<?php echo $_POST['forum_color_border']; ?>" />
					<br />
					<?php _e('Optional - Ex: 000000 OR FFFFFF') ?></td> 
					</tr>
					<tr valign="top"> 
					<th scope="row"><?php _e('Border Size') ?></th> 
					<td><select name="forum_border_size">
						<option value="0" <?php if ($_POST['forum_border_size'] == '0' || $_POST['forum_border_size'] == '') echo 'selected="selected"'; ?>>0px</option>
						<option value="1" <?php if ($_POST['forum_border_size'] == '1') echo 'selected="selected"'; ?>>1px</option>
						<option value="2" <?php if ($_POST['forum_border_size'] == '2') echo 'selected="selected"'; ?>>2px</option>
						<option value="3" <?php if ($_POST['forum_border_size'] == '3') echo 'selected="selected"'; ?>>3px</option>
						<option value="4" <?php if ($_POST['forum_border_size'] == '4') echo 'selected="selected"'; ?>>4px</option>
						<option value="5" <?php if ($_POST['forum_border_size'] == '5') echo 'selected="selected"'; ?>>5px</option>
					</select>
					</td> 
					</tr>
					</table>
				<p class="submit"> 
				<input type="submit" name="Submit" value="<?php _e('Save') ?>" /> 
				</p> 
				</form>
				<?php
            }
		break;
		//---------------------------------------------------//
		case "new_forum_process":
			if ($_POST['forum_name'] == ''){
					?>
						<h2><?php _e('New Forum') ?></h2>
                        <p><?php _e('Please fill in all required fields') ?></p>
						<form name="form1" method="POST" action="forums.php?action=new_forum_process"> 
							<table class="form-table">
							<tr valign="top">
							<th scope="row"><?php _e('Name') ?></th>
							<td><input type="text" name="forum_name" id="forum_name" style="width: 95%" value="<?php echo $_POST['forum_name']; ?>" />
							<br />
							<?php _e('Required') ?></td> 
							</tr>
							<tr valign="top">
							<th scope="row"><?php _e('Description') ?></th>
							<td><textarea name="forum_description" id="forum_description" style="width: 95%" rows="5"><?php echo $_POST['forum_description']; ?></textarea>
							<br />
							<?php _e('Optional') ?></td> 
							</tr>
                            <tr valign="top">
                            <th scope="row"><?php _e('Color One') ?></th>
                            <td><input type="text" name="forum_color_one" id="forum_color_one" style="width: 10%"  maxlength="7" value="<?php echo $_POST['forum_color_one']; ?>" />
                            <br />
                            <?php _e('Optional - Ex: 000000 OR FFFFFF') ?></td> 
                            </tr>
                            <tr valign="top">
                            <th scope="row"><?php _e('Color Two') ?></th>
                            <td><input type="text" name="forum_color_two" id="forum_color_two" style="width: 10%"  maxlength="7" value="<?php echo $_POST['forum_color_two']; ?>" />
                            <br />
                            <?php _e('Optional - Ex: 000000 OR FFFFFF') ?></td> 
                            </tr>
                            <tr valign="top">
                            <th scope="row"><?php _e('Header Color') ?></th>
                            <td><input type="text" name="forum_color_header" id="forum_color_header" style="width: 10%"  maxlength="7" value="<?php echo $_POST['forum_color_header']; ?>" />
                            <br />
                            <?php _e('Optional - Ex: 000000 OR FFFFFF') ?></td> 
                            </tr>
                            <tr valign="top">
                            <th scope="row"><?php _e('Border Color') ?></th>
                            <td><input type="text" name="forum_color_border" id="forum_color_border" style="width: 10%"  maxlength="7" value="<?php echo $_POST['forum_color_border']; ?>" />
                            <br />
                            <?php _e('Optional - Ex: 000000 OR FFFFFF') ?></td> 
                            </tr>
                            <tr valign="top"> 
                            <th scope="row"><?php _e('Border Size') ?></th> 
                            <td><select name="forum_border_size">
                                <option value="0" <?php if ($_POST['forum_border_size'] == '0' || $_POST['forum_border_size'] == '') echo 'selected="selected"'; ?>>0px</option>
                                <option value="1" <?php if ($_POST['forum_border_size'] == '1') echo 'selected="selected"'; ?>>1px</option>
                                <option value="2" <?php if ($_POST['forum_border_size'] == '2') echo 'selected="selected"'; ?>>2px</option>
                                <option value="3" <?php if ($_POST['forum_border_size'] == '3') echo 'selected="selected"'; ?>>3px</option>
                                <option value="4" <?php if ($_POST['forum_border_size'] == '4') echo 'selected="selected"'; ?>>4px</option>
                                <option value="5" <?php if ($_POST['forum_border_size'] == '5') echo 'selected="selected"'; ?>>5px</option>
                            </select>
                            </td> 
                            </tr>
							</table>
						<p class="submit"> 
						<input type="submit" name="Submit" value="<?php _e('Save') ?>" /> 
						</p> 
						</form>
					<?php
			} else {
				$wpdb->query( "INSERT INTO " . $wpdb->base_prefix . "forums (forum_blog_ID, forum_name, forum_description, forum_color_one, forum_color_two, forum_color_header, forum_color_border, forum_border_size) VALUES ( '" . $wpdb->blogid . "', '" . $_POST['forum_name'] . "' , '" . $_POST['forum_description'] . "', '" . str_replace('#','',$_POST['forum_color_one']) . "', '" . str_replace('#','',$_POST['forum_color_two']) . "', '" . str_replace('#','',$_POST['forum_color_header']) . "', '" . str_replace('#','',$_POST['forum_color_border']) . "', '" . $_POST['forum_border_size'] . "')" );
				echo "
				<SCRIPT LANGUAGE='JavaScript'>
				window.location='forums.php?updated=true&updatedmsg=" . urlencode(__('Forum Added.')) . "';
				</script>
				";
			}
		break;
		//---------------------------------------------------//
		case "edit_forum":
		$tmp_forum_name = $wpdb->get_var("SELECT forum_name FROM " . $wpdb->base_prefix . "forums WHERE forum_ID = '" . $_GET['fid'] . "' AND forum_blog_ID = '" . $wpdb->blogid . "'");
		$tmp_forum_description = $wpdb->get_var("SELECT forum_description FROM " . $wpdb->base_prefix . "forums WHERE forum_ID = '" . $_GET['fid'] . "' AND forum_blog_ID = '" . $wpdb->blogid . "'");
		$tmp_forum_color_one = $wpdb->get_var("SELECT forum_color_one FROM " . $wpdb->base_prefix . "forums WHERE forum_ID = '" . $_GET['fid'] . "' AND forum_blog_ID = '" . $wpdb->blogid . "'");
		$tmp_forum_color_two = $wpdb->get_var("SELECT forum_color_two FROM " . $wpdb->base_prefix . "forums WHERE forum_ID = '" . $_GET['fid'] . "' AND forum_blog_ID = '" . $wpdb->blogid . "'");
		$tmp_forum_color_header = $wpdb->get_var("SELECT forum_color_header FROM " . $wpdb->base_prefix . "forums WHERE forum_ID = '" . $_GET['fid'] . "' AND forum_blog_ID = '" . $wpdb->blogid . "'");
		$tmp_forum_color_border = $wpdb->get_var("SELECT forum_color_border FROM " . $wpdb->base_prefix . "forums WHERE forum_ID = '" . $_GET['fid'] . "' AND forum_blog_ID = '" . $wpdb->blogid . "'");
		$tmp_forum_border_size = $wpdb->get_var("SELECT forum_border_size FROM " . $wpdb->base_prefix . "forums WHERE forum_ID = '" . $_GET['fid'] . "' AND forum_blog_ID = '" . $wpdb->blogid . "'");
		?>
			<h2><?php _e('Edit Forum') ?></h2>
            <form name="form1" method="POST" action="forums.php?action=edit_forum_process"> 
			<input type="hidden" name="fid" value="<?php echo $_GET['fid']; ?>" />
                <table class="form-table">
                <tr valign="top">
                <th scope="row"><?php _e('Name') ?></th>
				<td><input type="text" name="forum_name" id="forum_name" style="width: 95%" value="<?php echo $tmp_forum_name; ?>" />
                <br />
                <?php _e('Required') ?></td> 
                </tr>
                <tr valign="top">
                <th scope="row"><?php _e('Description') ?></th>
				<td><textarea name="forum_description" id="forum_description" style="width: 95%" rows="5"><?php echo $tmp_forum_description; ?></textarea>
                <br />
                <?php _e('Optional') ?></td> 
                </tr>
                <tr valign="top">
                <th scope="row"><?php _e('Color One') ?></th>
				<td><input type="text" name="forum_color_one" id="forum_color_one" style="width: 10%"  maxlength="7" value="<?php echo $tmp_forum_color_one; ?>" />
                <br />
                <?php _e('Optional - Ex: 000000 OR FFFFFF') ?></td> 
                </tr>
                <tr valign="top">
                <th scope="row"><?php _e('Color Two') ?></th>
				<td><input type="text" name="forum_color_two" id="forum_color_two" style="width: 10%"  maxlength="7" value="<?php echo $tmp_forum_color_two; ?>" />
                <br />
                <?php _e('Optional - Ex: 000000 OR FFFFFF') ?></td> 
                </tr>
                <tr valign="top">
                <th scope="row"><?php _e('Header Color') ?></th>
				<td><input type="text" name="forum_color_header" id="forum_color_header" style="width: 10%"  maxlength="7" value="<?php echo $tmp_forum_color_header; ?>" />
                <br />
                <?php _e('Optional - Ex: 000000 OR FFFFFF') ?></td> 
                </tr>
                <tr valign="top">
                <th scope="row"><?php _e('Border Color') ?></th>
				<td><input type="text" name="forum_color_border" id="forum_color_border" style="width: 10%"  maxlength="7" value="<?php echo $tmp_forum_color_border; ?>" />
                <br />
                <?php _e('Optional - Ex: 000000 OR FFFFFF') ?></td> 
                </tr>
                <tr valign="top"> 
                <th scope="row"><?php _e('Border Size') ?></th> 
                <td><select name="forum_border_size">
                    <option value="0" <?php if ($tmp_forum_border_size == '0' || $tmp_forum_border_size == '') echo 'selected="selected"'; ?>>0px</option>
                    <option value="1" <?php if ($tmp_forum_border_size == '1') echo 'selected="selected"'; ?>>1px</option>
                    <option value="2" <?php if ($tmp_forum_border_size == '2') echo 'selected="selected"'; ?>>2px</option>
                    <option value="3" <?php if ($tmp_forum_border_size == '3') echo 'selected="selected"'; ?>>3px</option>
					<option value="4" <?php if ($tmp_forum_border_size == '4') echo 'selected="selected"'; ?>>4px</option>
                    <option value="5" <?php if ($tmp_forum_border_size == '5') echo 'selected="selected"'; ?>>5px</option>
                </select>
				</td> 
                </tr>
                </table>
            <p class="submit"> 
            <input type="submit" name="Submit" value="<?php _e('Save Changes') ?>" /> 
            </p> 
            </form>
        <?php
		break;
		//---------------------------------------------------//
		case "edit_forum_process":
			$tmp_forum_count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "forums WHERE forum_ID = '" . $_POST['fid'] . "' AND forum_blog_ID = '" . $wpdb->blogid . "'");
			if ($tmp_forum_count > 0){
				if ($_POST['forum_name'] == ''){
					?>
						<h2><?php _e('Edit Forum') ?></h2>
                        <p><?php _e('Please fill in all required fields') ?></p>
						<form name="form1" method="POST" action="forums.php?action=edit_forum_process"> 
						<input type="hidden" name="fid" value="<?php echo $_POST['fid']; ?>" />
							<table class="form-table">
							<tr valign="top">
							<th scope="row"><?php _e('Name') ?></th>
							<td><input type="text" name="forum_name" id="forum_name" style="width: 95%" value="<?php echo $_POST['forum_name']; ?>" />
							<br />
							<?php _e('Required') ?></td> 
							</tr>
							<tr valign="top">
							<th scope="row"><?php _e('Description') ?></th>
							<td><textarea name="forum_description" id="forum_description" style="width: 95%" rows="5"><?php echo $_POST['forum_description']; ?></textarea>
							<br />
							<?php _e('Optional') ?></td> 
							</tr>
                            <tr valign="top">
                            <th scope="row"><?php _e('Color One') ?></th>
                            <td><input type="text" name="forum_color_one" id="forum_color_one" style="width: 10%"  maxlength="7" value="<?php echo $_POST['forum_color_one']; ?>" />
                            <br />
                            <?php _e('Optional - Ex: 000000 OR FFFFFF') ?></td> 
                            </tr>
                            <tr valign="top">
                            <th scope="row"><?php _e('Color Two') ?></th>
                            <td><input type="text" name="forum_color_two" id="forum_color_two" style="width: 10%"  maxlength="7" value="<?php echo $_POST['forum_color_two']; ?>" />
                            <br />
                            <?php _e('Optional - Ex: 000000 OR FFFFFF') ?></td> 
                            </tr>
                            <tr valign="top">
                            <th scope="row"><?php _e('Header Color') ?></th>
                            <td><input type="text" name="forum_color_header" id="forum_color_header" style="width: 10%"  maxlength="7" value="<?php echo $_POST['forum_color_header']; ?>" />
                            <br />
                            <?php _e('Optional - Ex: 000000 OR FFFFFF') ?></td> 
                            </tr>
                            <tr valign="top">
                            <th scope="row"><?php _e('Border Color') ?></th>
                            <td><input type="text" name="forum_color_border" id="forum_color_border" style="width: 10%"  maxlength="7" value="<?php echo $_POST['forum_color_border']; ?>" />
                            <br />
                            <?php _e('Optional - Ex: 000000 OR FFFFFF') ?></td> 
                            </tr>
                            <tr valign="top"> 
                            <th scope="row"><?php _e('Border Size') ?></th> 
                            <td><select name="forum_border_size">
                                <option value="0" <?php if ($_POST['forum_border_size'] == '0' || $_POST['forum_border_size'] == '') echo 'selected="selected"'; ?>>0px</option>
                                <option value="1" <?php if ($_POST['forum_border_size'] == '1') echo 'selected="selected"'; ?>>1px</option>
                                <option value="2" <?php if ($_POST['forum_border_size'] == '2') echo 'selected="selected"'; ?>>2px</option>
                                <option value="3" <?php if ($_POST['forum_border_size'] == '3') echo 'selected="selected"'; ?>>3px</option>
                                <option value="4" <?php if ($_POST['forum_border_size'] == '4') echo 'selected="selected"'; ?>>4px</option>
                                <option value="5" <?php if ($_POST['forum_border_size'] == '5') echo 'selected="selected"'; ?>>5px</option>
                            </select>
                            </td> 
                            </tr>
							</table>
						<p class="submit"> 
						<input type="submit" name="Submit" value="<?php _e('Save Changes') ?>" /> 
						</p> 
						</form>
					<?php
				} else {
					$wpdb->query( "UPDATE " . $wpdb->base_prefix . "forums SET forum_name = '" . $_POST['forum_name'] . "' WHERE forum_ID = '" . $_POST['fid'] . "' AND forum_blog_ID = '" . $wpdb->blogid . "'");
					$wpdb->query( "UPDATE " . $wpdb->base_prefix . "forums SET forum_description = '" . $_POST['forum_description'] . "' WHERE forum_ID = '" . $_POST['fid'] . "' AND forum_blog_ID = '" . $wpdb->blogid . "'");

					$wpdb->query( "UPDATE " . $wpdb->base_prefix . "forums SET forum_color_one = '" . str_replace('#','',$_POST['forum_color_one']) . "' WHERE forum_ID = '" . $_POST['fid'] . "' AND forum_blog_ID = '" . $wpdb->blogid . "'");
					$wpdb->query( "UPDATE " . $wpdb->base_prefix . "forums SET forum_color_two = '" . str_replace('#','',$_POST['forum_color_two']) . "' WHERE forum_ID = '" . $_POST['fid'] . "' AND forum_blog_ID = '" . $wpdb->blogid . "'");
					$wpdb->query( "UPDATE " . $wpdb->base_prefix . "forums SET forum_color_header = '" . str_replace('#','',$_POST['forum_color_header']) . "' WHERE forum_ID = '" . $_POST['fid'] . "' AND forum_blog_ID = '" . $wpdb->blogid . "'");
					$wpdb->query( "UPDATE " . $wpdb->base_prefix . "forums SET forum_color_border = '" . str_replace('#','',$_POST['forum_color_border']) . "' WHERE forum_ID = '" . $_POST['fid'] . "' AND forum_blog_ID = '" . $wpdb->blogid . "'");
					$wpdb->query( "UPDATE " . $wpdb->base_prefix . "forums SET forum_border_size = '" . $_POST['forum_border_size'] . "' WHERE forum_ID = '" . $_POST['fid'] . "' AND forum_blog_ID = '" . $wpdb->blogid . "'");
					
					echo "
					<SCRIPT LANGUAGE='JavaScript'>
					window.location='forums.php?updated=true&updatedmsg=" . urlencode(__('Settings saved.')) . "';
					</script>
					";
				}
			}
		break;
		//---------------------------------------------------//
		case "delete_forum":
		?>
				<h2><?php _e('Remove Forum') ?></h2>
                <p><?php _e('Are you sure you want to remove this forum? All topics and posts will be deleted.') ?></p>
				<form name="step_one" method="POST" action="forums.php?action=delete_forum_process">
				<input type="hidden" name="fid" value="<?php echo $_GET['fid']; ?>" />
				<p class="submit"> 
				<input type="submit" name="Submit" value="<?php _e('Continue') ?>" />
				<input type="submit" name="Cancel" value="<?php _e('Cancel') ?>" /> 
				</p>
				</form>
        <?php
		break;
		//---------------------------------------------------//
		case "delete_forum_process":
			if ( isset($_POST['Cancel']) ) {
				echo "
				<SCRIPT LANGUAGE='JavaScript'>
				window.location='edit.php?page=forums';
				</script>
				";
			} else {
				forums_delete_forum($_POST['fid']);
				echo "
				<SCRIPT LANGUAGE='JavaScript'>
				window.location='forums.php?updated=true&updatedmsg=" . urlencode(__('Forum Removed.')) . "';
				</script>
				";
			}
		break;
		//---------------------------------------------------//
		case "temp5":
		break;
		//---------------------------------------------------//
	}
	echo '</div>';
}

//------------------------------------------------------------------------//
//---Support Functions----------------------------------------------------//
//------------------------------------------------------------------------//

function forums_save_post_content($post_content){
	$post_content = strip_tags($post_content, '<p><ul><li><a><strong><img>');
	$post_content = addslashes($post_content);
	return $post_content;
}

function forums_display_post_content($post_content){
	$post_content = stripslashes($post_content);
	//$post_content = str_replace('<br>', "\n", $post_content);
	$post_content = nl2br($post_content);
	return $post_content;
}

function forums_author_display_name($author_ID){
	global $wpdb;
	$tmp_user_login = $wpdb->get_var("SELECT user_login FROM " . $wpdb->base_prefix . "users WHERE ID = '" . $author_ID . "'");
	return $tmp_user_login;
}

function forums_roundup($value, $dp){
    return ceil($value*pow(10, $dp))/pow(10, $dp);
}

?>