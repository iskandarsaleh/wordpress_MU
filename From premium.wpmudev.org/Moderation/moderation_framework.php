<?php
/*
Plugin Name: Moderation
Plugin URI: 
Description:
Author: Andrew Billits (Incsub)
Version: 1.0.1
Author URI: http://incsub.com
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

$moderation_current_version = '1.0.1';
//------------------------------------------------------------------------//
//---Config---------------------------------------------------------------//
//------------------------------------------------------------------------//

$moderation_save_to_archive = 'all'; //Either 'all' or 'removed'

//------------------------------------------------------------------------//
//---Hook-----------------------------------------------------------------//
//------------------------------------------------------------------------//
if ($_GET['key'] == '' || $_GET['key'] === ''){
	add_action('admin_head', 'moderation_make_current');
}
add_action('init', 'moderation_init');
add_action('admin_menu', 'moderation_plug_pages');
add_action('wpmu_options', 'moderation_site_admin_options');
add_action('update_wpmu_options', 'moderation_site_admin_options_process');
add_action('wp_print_scripts', 'moderation_print_scripts');
add_action('wp_head','moderation_head');
add_filter('the_content', 'moderation_report_post', 20, 1);
if ( $moderation_save_to_archive == 'all' ) {
	add_action('save_post', 'moderation_post_archive_insert');
	add_action('comment_post', 'moderation_comment_archive_insert');
}
add_action('admin_footer', 'moderation_warnings_check');
add_filter('wp_footer', 'moderation_report_blog');
add_action('delete_post', 'moderation_post_delete');
add_action('delete_blog', 'moderation_blog_delete', 10, 1);
add_action('delete_comment', 'moderation_comment_delete');
add_filter('get_comment_text', 'moderation_report_comment', 20, 1);
add_filter('wpmu_users_columns', 'moderation_site_admin_users_column_header');
add_action('manage_users_custom_column','moderation_site_admin_users_column_content', 1, 2);
//------------------------------------------------------------------------//
//---Functions------------------------------------------------------------//
//------------------------------------------------------------------------//
function moderation_make_current() {
	global $wpdb, $moderation_current_version;
	if (get_site_option( "moderation_version" ) == '') {
		add_site_option( 'moderation_version', '0.0.0' );
	}

	if (get_site_option( "moderation_version" ) == $moderation_current_version) {
		// do nothing
	} else {
		//up to current version
		update_site_option( "moderation_installed", "no" );
		update_site_option( "moderation_version", $moderation_current_version );
	}
	moderation_global_install();
	//--------------------------------------------------//
	if (get_option( "moderation_version" ) == '') {
		add_option( 'moderation_version', '0.0.0' );
	}
	
	if (get_option( "moderation_version" ) == $moderation_current_version) {
		// do nothing
	} else {
		//up to current version
		update_option( "moderation_version", $moderation_current_version );
		moderation_blog_install();
	}
}

function moderation_blog_install() {
	global $wpdb, $moderation_current_version;
	//$moderation_table1 = "";
	//$wpdb->query( $moderation_table1 );
}

function moderation_global_install() {
	global $wpdb, $moderation_current_version;
	if (get_site_option( "moderation_installed" ) == '') {
		add_site_option( 'moderation_installed', 'no' );
	}
	
	if (get_site_option( "moderation_installed" ) == "yes") {
		// do nothing
	} else {
	
		$moderation_table1 = "CREATE TABLE IF NOT EXISTS `" . $wpdb->base_prefix . "moderation_reports` (
  `report_ID` bigint(20) unsigned NOT NULL auto_increment,
  `report_blog_ID` int(11) NOT NULL default '0',
  `report_object_type` varchar(255),
  `report_object_ID` int(11) NOT NULL default '0',
  `report_reason` varchar(255),
  `report_note` TEXT,
  `report_user_ID` int(11) NOT NULL default '0',
  `report_user_email` varchar(255),
  `report_user_IP` varchar(100),
  `report_stamp` varchar(255),
  `report_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `report_date_gmt` datetime NOT NULL default '0000-00-00 00:00:00',
  `report_status` varchar(20) NOT NULL default 'new',
  PRIMARY KEY  (`report_ID`)
) ENGINE=MyISAM;";
		$moderation_table2 = "CREATE TABLE IF NOT EXISTS `" . $wpdb->base_prefix . "post_archive` (
  `post_archive_id` bigint(20) unsigned NOT NULL auto_increment,
  `blog_id` bigint(20),
  `post_id` bigint(20),
  `post_author` bigint(20),
  `post_title` TEXT,
  `post_content` TEXT,
  `post_type` varchar(255),
  `post_stamp` varchar(255),
  `post_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `post_date_gmt` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`post_archive_id`)
) ENGINE=MyISAM;";
		$moderation_table3 = "CREATE TABLE IF NOT EXISTS `" . $wpdb->base_prefix . "moderation_warnings` (
  `warning_ID` bigint(20) unsigned NOT NULL auto_increment,
  `warning_user_ID` int(11) NOT NULL default '0',
  `warning_read` tinyint(1) NOT NULL default '0',
  `warning_note` TEXT,
  PRIMARY KEY  (`warning_ID`)
) ENGINE=MyISAM;";
		$moderation_table4 = "CREATE TABLE IF NOT EXISTS `" . $wpdb->base_prefix . "comment_archive` (
  `comment_archive_id` bigint(20) unsigned NOT NULL auto_increment,
  `blog_id` bigint(20),
  `comment_id` bigint(20),
  `post_id` bigint(20),
  `comment_author_user_id` bigint(20),
  `comment_author_email` varchar(255),
  `comment_author_ip` varchar(255),
  `comment_author_url` varchar(255),
  `comment_content` TEXT,
  `comment_stamp` varchar(255),
  `comment_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `comment_date_gmt` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`comment_archive_id`)
) ENGINE=MyISAM;";

		$wpdb->query( $moderation_table1 );
		$wpdb->query( $moderation_table2 );
		$wpdb->query( $moderation_table3 );
		$wpdb->query( $moderation_table4 );
		update_site_option( "moderation_installed", "yes" );
	}
}


function is_moderator( $user_login = false ) {
	global $current_user;

	if ( !$current_user && !$user_login ) {
		return false;
	}
	if ( is_site_admin( $user_login ) ) {
		return true;
	}
	if ( $user_login ) {
		$user_login = sanitize_user( $user_login );
	} else {
		$user_login = $current_user->user_login;
	}

	$site_moderators = get_site_option( 'site_moderators' );
	if ( is_array( $site_moderators ) && in_array( $user_login, $site_moderators ) ) {
		return true;
	}
	return false;
}

function moderation_plug_pages() {
	global $wpdb;
	if ( is_moderator() ) {
		$post_count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "moderation_reports WHERE report_object_type = 'post' AND report_status = 'new'");
		$blog_count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "moderation_reports WHERE report_object_type = 'blog' AND report_status = 'new'");
		$comment_count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "moderation_reports WHERE report_object_type = 'comment' AND report_status = 'new'");
		$total_count = $post_count + $blog_count + $comment_count;
		if ( $post_count > 0 ) {
			$post_count = ' <span class="moderation-posts-menu"><span class="update-plugins"><span class="moderation-post-count count-' . $post_count . '">' . $post_count . '</span></span></span>';
		} else {
			$post_count = '';
		}
		if ( $blog_count > 0 ) {
			$blog_count = ' <span class="moderation-blogs-menu"><span class="update-plugins"><span class="moderation-blog-count count-' . $blog_count . '">' . $blog_count . '</span></span></span>';
		} else {
			$blog_count = '';
		}
		if ( $comment_count > 0 ) {
			$comment_count = ' <span class="moderation-comments-menu"><span class="update-plugins"><span class="moderation-comment-count count-' . $comment_count . '">' . $comment_count . '</span></span></span>';
		} else {
			$comment_count = '';
		}
		if ( $total_count > 0 ) {
			$total_count = ' <span class="moderation-total-menu"><span class="update-plugins"><span class="moderation-total-count count-' . $total_count . '">' . $total_count . '</span></span></span>';
		} else {
			$total_count = '';
		}
		add_menu_page(__('Moderation'), __('Moderation') . $total_count, 0, 'moderation-admin.php');
		add_submenu_page('moderation-admin.php', __('Blog Moderation'), __('Blogs') . $blog_count, '0', 'blogs', 'moderation_blogs' );
		add_submenu_page('moderation-admin.php', __('Post Moderation'), __('Posts') . $post_count, '0', 'posts', 'moderation_posts' );
		add_submenu_page('moderation-admin.php', __('Comment Moderation'), __('Comments') . $comment_count, '0', 'comments', 'moderation_comments' );
		add_submenu_page('moderation-admin.php', __('Report Archive'), __('Report Archive'), '0', 'report-archive', 'moderation_report_archive' );
		add_submenu_page('moderation-admin.php', __('Post Archive'), __('Post Archive'), '0', 'post-archive', 'moderation_post_archive' );
		add_submenu_page('moderation-admin.php', __('Comment Archive'), __('Comment Archive'), '0', 'comment-archive', 'moderation_comment_archive' );
	}
}

function moderation_site_admin_options_process() {
	$site_moderators = explode( ' ', str_replace( ",", " ", $_POST['site_moderators'] ) );
	update_site_option( 'site_moderators' , $site_moderators );
	update_site_option( 'moderators_can_remove_users' , $_POST['moderators_can_remove_users'] );
	update_site_option( 'moderators_can_remove_blogs' , $_POST['moderators_can_remove_blogs'] );
	if( $_POST['moderation_report_post_reasons'] != '' ) {
		$moderation_report_post_reasons = split( "\n", stripslashes( $_POST['moderation_report_post_reasons'] ) );
		foreach( (array) $moderation_report_post_reasons as $moderation_report_post_reason ) {
			$report_post_reasons[] = trim( $moderation_report_post_reason );
		}
		update_site_option( "moderation_report_post_reasons", $report_post_reasons );
	} else {
		update_site_option( "moderation_report_post_reasons", '' );
	}
	if( $_POST['moderation_report_comment_reasons'] != '' ) {
		$moderation_report_comment_reasons = split( "\n", stripslashes( $_POST['moderation_report_comment_reasons'] ) );
		foreach( (array) $moderation_report_comment_reasons as $moderation_report_comment_reason ) {
			$report_comment_reasons[] = trim( $moderation_report_comment_reason );
		}
		update_site_option( "moderation_report_comment_reasons", $report_comment_reasons );
	} else {
		update_site_option( "moderation_report_comment_reasons", '' );
	}
	if( $_POST['moderation_report_blog_reasons'] != '' ) {
		$moderation_report_blog_reasons = split( "\n", stripslashes( $_POST['moderation_report_blog_reasons'] ) );
		foreach( (array) $moderation_report_blog_reasons as $moderation_report_blog_reason ) {
			$report_blog_reasons[] = trim( $moderation_report_blog_reason );
		}
		update_site_option( "moderation_report_blog_reasons", $report_blog_reasons );
	} else {
		update_site_option( "moderation_report_blog_reasons", '' );
	}
	if( $_POST['moderation_remove_notes'] != '' ) {
		$moderation_remove_notes = split( "\n", stripslashes( $_POST['moderation_remove_notes'] ) );
		foreach( (array) $moderation_remove_notes as $moderation_remove_note ) {
			$remove_notes[] = trim( $moderation_remove_note );
		}
		update_site_option( "moderation_remove_notes", $remove_notes );
	} else {
		update_site_option( "moderation_remove_notes", '' );
	}
}

function moderation_print_scripts() {
	wp_enqueue_script('moderation');	
}

function moderation_init() {
	global $wpdb, $moderation_current_version;
	
	wp_register_script('moderation', get_option('siteurl') . '/wp-content/moderation.js', array('thickbox'), $moderation_current_version);
	
	if (isset($_REQUEST['moderation_action'])) {
		
		switch ($_REQUEST['moderation_action']) {
			
			case "report_form" :
				$ot = $_REQUEST['object_type'];
				$oi = $_REQUEST['object_id'];
				moderation_report_form($ot, $oi);
				exit();
				
			break;
			
			case "submit_report" :
				
				moderation_process_submission();
				echo '<p>&nbsp;</p><p>&nbsp;</p><p>Thanks for the report. We\'ll look into it.</p>'; //// CHMAC TODO Prettify and nocache header this
				echo '<script type="text/javascript">setTimeout("tb_remove()",5000);</script>';
				exit();
				
			break;
			
		}
		
	}
	
}

function moderation_process_submission() {
	global $wpdb, $user_ID;
	
	$user_email = $_POST['report_author_email'];
	
	if ( empty( $user_email ) && !empty( $user_ID ) ) {
		$user_email = $wpdb->get_var("SELECT user_email FROM " . $wpdb->users . " WHERE ID = '" . $user_ID . "'");
	}
	
	$wpdb->query("INSERT IGNORE INTO " . $wpdb->base_prefix . "moderation_reports
	(report_blog_ID, report_object_type, report_object_ID, report_reason, report_note, report_user_ID, report_user_email, report_user_IP, report_stamp, report_date, report_date_gmt)
	VALUES
	('" . $wpdb->blogid . "', '" . $_POST['object_type'] . "', '" . $_POST['object_id'] . "', '" . $_POST['report_reason'] . "', '" . $_POST['report_note'] . "', '" . $user_ID . "', '" . $user_email . "', '" . $_SERVER['REMOTE_ADDR'] . "', '" . time() . "', '" . current_time('mysql') . "', '" . get_gmt_from_date( current_time('mysql') ) . "')");
}

function moderation_report_link($object_type, $object_id) {
	global $post;
	$link = '<p class="wp-report-this"><a href="' . get_option( 'siteurl') . '?moderation_action=report_form&object_type=' . rawurlencode( $object_type ) . '&object_id=' . rawurlencode(  $object_id ) . '&width=250&height=300" class="thickbox" title="Report this ' . $object_type . '">' . __('Report This ' . ucfirst($object_type) ) . '</a></p>';
	return $link;
}

function moderation_post_archive_insert($post_ID) {
	global $wpdb, $current_site;
	
	$post = get_post($post_ID);
	if ( !empty( $post->post_content ) && !empty($post->post_title) ) {
		$wpdb->query("INSERT IGNORE INTO " . $wpdb->base_prefix . "post_archive
		(blog_id, post_id, post_author, post_title, post_content, post_type, post_stamp, post_date, post_date_gmt)
		VALUES
		('" . $wpdb->blogid . "', '" . $post_ID . "', '" . $post->post_author . "', '" . addslashes( $post->post_title ) . "', '" . addslashes( $post->post_content ) . "', '" . $post->post_type . "', '" . time() . "', '" . $post->post_date . "', '" . $post->post_date_gmt . "')");
	}
}

function moderation_comment_archive_insert($comment_ID){
	global $wpdb, $current_site;
	
	$comment = get_comment($comment_ID);
	if ( !empty( $comment->comment_content ) ) {
		$wpdb->query("INSERT IGNORE INTO " . $wpdb->base_prefix . "comment_archive
		(blog_id, comment_id, post_id, comment_author_user_id, comment_author_email, comment_author_ip, comment_author_url, comment_content, comment_stamp, comment_date, comment_date_gmt)
		VALUES
		('" . $wpdb->blogid . "', '" . $comment->comment_ID . "', '" . $comment->comment_post_ID . "', '" . $comment->user_id . "', '" . $comment->comment_author_email . "', '" . $comment->comment_author_IP . "', '" . $comment->comment_author_url . "', '" . $comment->comment_content . "', '" . time() . "', '" . $comment->comment_date . "', '" . $comment->comment_date_gmt . "')");
	}
}

function moderation_warnings_check() {
	global $wpdb, $user_ID;
	if ( !strpos($_SERVER['REQUEST_URI'], 'warning') ){
		$user_warning_count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "moderation_warnings WHERE warning_user_ID = '" . $user_ID . "' AND warning_read = '0'");
		if ( $user_warning_count > 0 ) {
			echo "
			<SCRIPT LANGUAGE='JavaScript'>
			window.location='warning.php';
			</script>
			";
		}
	}
}

function moderation_post_delete($post_ID) {
	global $wpdb;
	$wpdb->query( "DELETE FROM " . $wpdb->base_prefix . "moderation_reports WHERE report_status = 'new' AND report_blog_ID = '" . $wpdb->blogid . "' AND report_object_type = 'post' AND report_object_ID = '" . $post_ID . "'" );
}

function moderation_blog_delete($blog_ID) {
	global $wpdb;
	$wpdb->query( "DELETE FROM " . $wpdb->base_prefix . "moderation_reports WHERE report_status = 'new' AND report_blog_ID = '" . $wpdb->blogid . "'" );
}

function moderation_comment_delete($comment_ID) {
	global $wpdb;
	$wpdb->query( "DELETE FROM " . $wpdb->base_prefix . "moderation_reports WHERE report_status = 'new' AND report_blog_ID = '" . $wpdb->blogid . "' AND report_object_type = 'comment' AND report_object_ID = '" . $comment_ID . "'" );
}

function moderation_site_admin_users_column_header($posts_columns) {
	$new_column = array('warnings' => __('Warnings'));
	$posts_columns = array_merge($posts_columns, $new_column);
	return $posts_columns;
}

function moderation_site_admin_users_column_content($column,$uid) {
	global $wpdb;
	if ( $column == 'warnings' ) {
		$warning_count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "moderation_warnings WHERE warning_user_ID = '" . $uid . "'");
		echo $warning_count;
	}
}
//------------------------------------------------------------------------//
//---Output Functions-----------------------------------------------------//
//------------------------------------------------------------------------//

function moderation_report_post($content){
	global $post, $wpdb;
	if ( $wpdb->blogid != 1 && !is_search() ) {
		$link = moderation_report_link('post', $post->ID);
	}
	return $content . $link;
}

function moderation_report_comment($content){
	global $comment, $wpdb;
	if ( $wpdb->blogid != 1 ) {
		$link = moderation_report_link('comment', $comment->comment_ID);
	}
	return $content . $link;
}

function moderation_report_blog(){
	global $wpdb;
	if ( $wpdb->blogid != 1 ) {
		echo moderation_report_link('blog', $wpdb->blogid);
	}
}

function moderation_head() {

	wp_enqueue_style('thickbox_css', get_bloginfo('wpurl')."/wp-includes/js/thickbox/thickbox.css", false, false, 'screen');
	wp_print_styles(array('thickbox_css'));
	?>
	<script type="text/javascript">
	var tb_pathToImage = "<? echo get_option('siteurl') . '/' . WPINC; ?>/js/thickbox/loadingAnimation.gif";
	var tb_closeImage = "<?php echo get_option('siteurl') . '/' . WPINC; ?>/js/thickbox/tb-close.png";
	var moderation_ajaxurl = "<?php echo get_option('siteurl'); ?>/";
	function moderation_submit() {
		jQuery('#moderation-report').load( moderation_ajaxurl, jQuery('form#moderation-report-form').serializeArray(), function() {
			jQuery('#moderation-report').append('<p>Press ESC or click anywhere outside this box to close it.</p>');
		} );
		return false;
	}
	</script>
	<?php
	
}

function moderation_site_admin_options() {
	$site_moderators = get_site_option( 'site_moderators' );
	if ( !empty( $site_moderators ) ) {
		$site_moderators = implode(' ', $site_moderators );
	}
	$moderators_can_remove_users = get_site_option('moderators_can_remove_users', 'no');
	$moderators_can_remove_blogs = get_site_option('moderators_can_remove_blogs', 'no');
	
	$moderation_report_post_reasons = get_site_option('moderation_report_post_reasons', array('Spam','Language'));
	$moderation_report_comment_reasons = get_site_option('moderation_report_comment_reasons', array('Spam','Language'));
	$moderation_report_blog_reasons = get_site_option('moderation_report_blog_reasons', array('Spam','Language'));
	$moderation_remove_notes = get_site_option('moderation_remove_notes', array('Warning: TOS violated - Further infractions could result in your account being removed','Warning: AUP violated - Further infractions could result in your account being removed'));
	?>
		<h3><?php _e('Moderation'); ?></h3>
		<table class="form-table">
			<tr valign="top"> 
				<th scope="row"><?php _e('Site Moderators') ?></th> 
				<td>
					<input name="site_moderators" id="site_moderators" style="width: 95%;" value="<?php echo $site_moderators; ?>" size="45" type="text">
					<br />
					<?php _e('These users may access the moderation tab. Space separated list of usernames.') ?>
					<br />
					<?php _e('Note that all Site Admins can access the moderation tab by default and do not need to be listed here.') ?>
				</td>
			</tr>
			<tr valign="top"> 
				<th scope="row"><?php _e('Moderators Can Remove Users') ?></th> 
				<td>
					<input name="moderators_can_remove_users" id="moderators_can_remove_users" value="yes" <?php if ( $moderators_can_remove_users == 'yes' ) { echo 'checked="checked"'; } ?> type="radio"> <?php _e('Yes'); ?><br />
					<input name="moderators_can_remove_users" id="moderators_can_remove_users" value="no" <?php if ( $moderators_can_remove_users == 'no' ) { echo 'checked="checked"'; } ?> type="radio"> <?php _e('No'); ?>
				</td>
			</tr>
			<tr valign="top"> 
				<th scope="row"><?php _e('Moderators Can Remove Blogs') ?></th> 
				<td>
					<input name="moderators_can_remove_blogs" id="moderators_can_remove_blogs" value="yes" <?php if ( $moderators_can_remove_blogs == 'yes' ) { echo 'checked="checked"'; } ?> type="radio"> <?php _e('Yes'); ?><br />
					<input name="moderators_can_remove_blogs" id="moderators_can_remove_blogs" value="no" <?php if ( $moderators_can_remove_blogs == 'no' ) { echo 'checked="checked"'; } ?> type="radio"> <?php _e('No'); ?>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Report Post Reasons') ?></th>
				<td>
					<textarea name="moderation_report_post_reasons" id="moderation_report_post_reasons" cols='40' rows='5' style="width: 95%;"><?php echo $moderation_report_post_reasons == '' ? '' : @implode( "\n", $moderation_report_post_reasons ); ?></textarea>
					<br />
					<?php _e('Reasons for reporting a post. One per line.') ?>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Report Comment Reasons') ?></th>
				<td>
					<textarea name="moderation_report_comment_reasons" id="moderation_report_comment_reasons" cols='40' rows='5' style="width: 95%;"><?php echo $moderation_report_comment_reasons == '' ? '' : @implode( "\n", $moderation_report_comment_reasons ); ?></textarea>
					<br />
					<?php _e('Reasons for reporting a comment. One per line.') ?>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Report Blog Reasons') ?></th>
				<td>
					<textarea name="moderation_report_blog_reasons" id="moderation_report_blog_reasons" cols='40' rows='5' style="width: 95%;"><?php echo $moderation_report_blog_reasons == '' ? '' : @implode( "\n", $moderation_report_blog_reasons ); ?></textarea>
					<br />
					<?php _e('Reasons for reporting a Blog. One per line.') ?>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Remove Notes') ?></th>
				<td>
					<textarea name="moderation_remove_notes" id="moderation_remove_notes" cols='40' rows='5' style="width: 95%;"><?php echo $moderation_remove_notes == '' ? '' : @implode( "\n", $moderation_remove_notes ); ?></textarea>
					<br />
					<?php _e('Note to user when a post or comment is removed. One per line.') ?>
				</td>
			</tr>
		</table>
	<?php
}

function moderation_report_form($ot, $oi) {

	if ( $ot == 'post' ) {
		$reasons = get_site_option('moderation_report_post_reasons', array('Spam','Language'));
	}
	if ( $ot == 'comment' ) {
		$reasons = get_site_option('moderation_report_comment_reasons', array('Spam','Language'));
	}
	if ( $ot == 'blog' ) {
		$reasons = get_site_option('moderation_report_blog_reasons', array('Spam','Language'));
	}

	$output .= '<div id="moderation-report">';
	$output .= '<form id="moderation-report-form" action="' . get_option('siteurl') . '" onsubmit="return moderation_submit();" method="post">';
	$output .= '<input type="hidden" name="object_type" value="' . $ot . '">';
	$output .= '<input type="hidden" name="object_id" value="' . $oi . '">';
	$output .= '<input type="hidden" name="moderation_action" value="submit_report">';
	$output .= '<p>' . __('Reason:') . ' <select name="report_reason">';
	foreach ( $reasons as $reason ) {
		$output .= '<option value="' . $reason . '">' . $reason . '</option>';
	}
	$output .= '</select></p>';
	$output .= '<p>' . __('Notes') . ' (' . __('optional') . '):<br/><textarea name="report_note" style="width:95%;"></textarea></p>';
	if ( !is_user_logged_in() ) {
		$output .= '<p>' . __('Email') . ' (' . __('optional') . '):<br /><input type="text" name="report_author_email">';
	}
	$output .= '<p><input type="submit" name="action" value="' . __('Submit Report') . '">';
	$output .= '</form>';
	$output .= '</div>';
	
	echo $output;
	
}

//------------------------------------------------------------------------//
//---Page Output Functions------------------------------------------------//
//------------------------------------------------------------------------//

function moderation_overview() {
	global $wpdb, $wp_roles, $current_user, $user_ID, $current_site;

	if ( !is_moderator() ) {
		die();
	}
	
	if (isset($_GET['updated'])) {
		?><div id="message" class="updated fade"><p><?php _e(urldecode($_GET['updatedmsg'])) ?></p></div><?php
	}
	echo '<div class="wrap">';
	switch( $_GET[ 'action' ] ) {
		//---------------------------------------------------//
		default:
			$moderators_can_remove_users = get_site_option('moderators_can_remove_users', 'no');
			$moderators_can_remove_blogs = get_site_option('moderators_can_remove_blogs', 'no');
			$post_count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "moderation_reports WHERE report_object_type = 'post' AND report_status = 'new'");
			$blog_count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "moderation_reports WHERE report_object_type = 'blog' AND report_status = 'new'");
			$comment_count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "moderation_reports WHERE report_object_type = 'comment' AND report_status = 'new'");
			?>
            <h2><?php _e('Moderation') ?></h2>
            <h3><?php _e('Reports') ?></h3>
            <p>
            <strong><?php _e('Posts'); ?></strong>: <?php echo $blog_count; ?><br />
            <strong><?php _e('Comments'); ?></strong>: <?php echo $comment_count; ?><br />
            <strong><?php _e('Blogs'); ?></strong>: <?php echo $blog_count; ?>
            </p>
            <h3><?php _e('User Information') ?></h3>
            <form name="user_information" method="POST" action="moderation-admin.php?action=user_information">
                <table class="form-table">
                <tr valign="top">
                <th scope="row"><?php _e('Username') ?></th>
                <td><input type="text" name="user_login" id="user_login" style="width: 95%" value="" />
                <br />
                <?php //_e('') ?></td> 
                </tr>
                <tr valign="top">
                <th scope="row"><?php _e('User ID') ?></th>
                <td><input type="text" name="uid" id="uid" style="width: 95%" value="" />
                <br />
                <?php //_e('') ?></td> 
                </tr>
                <tr valign="top">
                <th scope="row"><?php _e('User Email') ?></th>
                <td><input type="text" name="user_email" id="user_email" style="width: 95%" value="" />
                <br />
                <?php //_e('') ?></td> 
                </tr>
                </table>
            <p class="submit">
            <input type="submit" name="Submit" value="<?php _e('Continue') ?>" /> 
            </p> 
            </form>
            <?php
			if ( $moderators_can_remove_users == 'yes' ) {
			?>
            <h3><?php _e('Remove User') ?></h3>
            <form name="remove_user" method="POST" action="moderation-admin.php?action=remove_user">
                <table class="form-table">
                <tr valign="top">
                <th scope="row"><?php _e('Username') ?></th>
                <td><input type="text" name="user_login" id="user_login" style="width: 95%" value="" />
                <br />
                <?php //_e('') ?></td> 
                </tr>
                <tr valign="top">
                <th scope="row"><?php _e('User ID') ?></th>
                <td><input type="text" name="uid" id="uid" style="width: 95%" value="" />
                <br />
                <?php //_e('') ?></td> 
                </tr>
                <tr valign="top">
                <th scope="row"><?php _e('User Email') ?></th>
                <td><input type="text" name="user_email" id="user_email" style="width: 95%" value="" />
                <br />
                <?php //_e('') ?></td> 
                </tr>
                </table>
            <p class="submit">
            <input type="submit" name="Submit" value="<?php _e('Continue') ?>" /> 
            </p> 
            </form>
            <?php
			}
			if ( $moderators_can_remove_blogs == 'yes' ) {
			?>
            <h3><?php _e('Remove Blog') ?></h3>
            <form name="remove_blog" method="POST" action="moderation-admin.php?action=remove_blog">
                <table class="form-table">
                <tr valign="top">
                <th scope="row"><?php _e('Blog ID') ?></th>
                <td><input type="text" name="bid" id="bid" style="width: 95%" value="" />
                <br />
                <?php //_e('') ?></td> 
                </tr>
                <tr valign="top">
                <th scope="row"><?php _e('Blogname') ?></th>
                <td><input type="text" name="blog_name" id="blog_name" style="width: 95%" value="" />
                <br />
                <?php //_e('') ?></td> 
                </tr>
                </table>
            <p class="submit">
            <input type="submit" name="Submit" value="<?php _e('Continue') ?>" /> 
            </p> 
            </form>
            <?php
			}
		break;
		//---------------------------------------------------//
		case "user_information":
			$uid = $_POST['uid'];
			if ( empty( $uid ) ) {
				$uid = $_GET['uid'];
			}
			$user_login = $_POST['user_login'];
			if ( empty( $user_login ) ) {
				$user_login = $_GET['user_login'];
			}
			$user_email = $_POST['user_email'];
			if ( empty( $user_email ) ) {
				$user_email = $_GET['user_email'];
			}
			if ( !empty( $user_login ) ) {
				$uid = $wpdb->get_var("SELECT ID FROM " . $wpdb->users . " WHERE user_login = '" . $user_login . "'");
			}
			if ( !empty( $user_email ) ) {
				$uid = $wpdb->get_var("SELECT ID FROM " . $wpdb->users . " WHERE user_email = '" . $user_email . "'");
			}
			$user_count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "users WHERE ID = '" . $uid . "'");
			if ( $user_count > 0 ) {
				$user_login = $wpdb->get_var("SELECT user_login FROM " . $wpdb->base_prefix . "users WHERE ID = '" . $uid . "'");
				$warning_count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "moderation_warnings WHERE warning_user_ID = '" . $uid . "'");
				$user_registered = $wpdb->get_var("SELECT user_registered FROM " . $wpdb->base_prefix . "users WHERE ID = '" . $uid . "'");
				$user_email = $wpdb->get_var("SELECT user_email FROM " . $wpdb->base_prefix . "users WHERE ID = '" . $uid . "'");
				$user_blogs = get_blogs_of_user( $uid, true );
				?>
				<h2><?php _e('User Information') ?>: <?php echo $user_login; ?></h2>
				<form name="user_information" method="POST" action="moderation-admin.php">
				<p>
				<strong><?php _e('Email'); ?></strong>: <?php echo $user_email; ?>
				<br />
				<strong><?php _e('Registered'); ?></strong>: <?php echo mysql2date(get_option('date_format'), $user_registered); ?>
				<br />
				<strong><?php _e('Warnings'); ?></strong>: <?php echo $warning_count; ?>
				<br />
				<strong><?php _e('Post Archive'); ?></strong>: <a href="moderation-admin.php?page=post-archive&post_type=post&uid=<?php echo $uid;?>" style="text-decoration:none;" ><?php _e('View'); ?></a>
				<br />
				<strong><?php _e('Blogs'); ?></strong>:
                <?php
				if( is_array( $user_blogs ) ) {
					echo '<br />';
					foreach ( (array) $user_blogs as $key => $val ) {
						$path	= ($val->path == '/') ? '' : $val->path;
						echo '<a href="http://' . $val->domain . $path . '">' . str_replace( '.' . $current_site->domain, '', $val->domain . $path ) . '</a>';
						echo '<br />';
					}
				} else {
					echo __('None');
				}
				?>
				</p>
				<p class="submit">
				<input type="submit" name="Submit" value="<?php _e('Back') ?>" />
				</p>
				</form>
				<?php
			} else {
				?>
				<h2><?php _e('Error') ?></h2>
                <?php
				echo '<p>' . __('User not found.') . '</p>';
			}
		break;
		//---------------------------------------------------//
		case "remove_user":
			$uid = $_POST['uid'];
			if ( empty( $uid ) ) {
				$uid = $_GET['uid'];
			}
			$user_login = $_POST['user_login'];
			if ( empty( $user_login ) ) {
				$user_login = $_GET['user_login'];
			}
			$user_email = $_POST['user_email'];
			if ( empty( $user_email ) ) {
				$user_email = $_GET['user_email'];
			}
			if ( !empty( $user_login ) ) {
				$uid = $wpdb->get_var("SELECT ID FROM " . $wpdb->users . " WHERE user_login = '" . $user_login . "'");
			}
			if ( !empty( $user_email ) ) {
				$uid = $wpdb->get_var("SELECT ID FROM " . $wpdb->users . " WHERE user_email = '" . $user_email . "'");
			}
			$user_count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "users WHERE ID = '" . $uid . "'");
			if ( $user_count > 0 ) {
				$user_login = $wpdb->get_var("SELECT user_login FROM " . $wpdb->base_prefix . "users WHERE ID = '" . $uid . "'");
				if ( !is_moderator( $user_login ) ) {
					?>
					<h2><?php _e('Remove User') ?>: <?php echo $user_login; ?></h2>
					<form name="remove_user" method="POST" action="moderation-admin.php?action=remove_user_process&uid=<?php echo $uid; ?>">
						<table class="form-table">
						<tr valign="top">
						<th scope="row"><?php _e('Are you sure?') ?></th>
						<td>
						<select name="remove_user" id="remove_user">
								<option value="yes"><?php _e('Yes'); ?></option>
								<option value="no" selected="selected" ><?php _e('No'); ?></option>
						</select>
						<br /><?php //_e('') ?></td>
						</tr>
						</table>
					<p class="submit">
					<input type="submit" name="Submit" value="<?php _e('Continue') ?>" />
					</p>
					</form>
					<?php
				} else {
					?>
					<h2><?php _e('Error') ?></h2>
					<?php
					echo '<p>' . __('You cannot remove a moderator or site admin.') . '</p>';
				}
			} else {
				?>
				<h2><?php _e('Error') ?></h2>
                <?php
				echo '<p>' . __('User not found.') . '</p>';
			}
		break;
		//---------------------------------------------------//
		case "remove_user_process":
			if ( $_POST['remove_user'] == 'no' ) {
				echo "
				<SCRIPT LANGUAGE='JavaScript'>
				window.location='moderation-admin.php';
				</script>
				";
			} else {
				wpmu_delete_user( $_GET['uid'] );
				echo "
				<SCRIPT LANGUAGE='JavaScript'>
				window.location='moderation-admin.php?updated=true&updatedmsg=" . urlencode('User removed') . "';
				</script>
				";
			}
		break;
		//---------------------------------------------------//
		case "remove_blog":
			$bid = $_POST['bid'];
			if ( empty( $bid ) ) {
				$bid = $_GET['bid'];
			}
			$blog_name = $_POST['blog_name'];
			if ( empty( $blog_name ) ) {
				$blog_name = $_GET['blog_name'];
			}
			if ( !empty( $blog_name ) ) {
				if (VHOST == 'yes') {
					$bid = $wpdb->get_var("SELECT blog_id FROM " . $wpdb->blogs . " WHERE domain = '" . $blog_name . "." . $current_site->domains . "'");
				} else {
					$bid = $wpdb->get_var("SELECT blog_id FROM " . $wpdb->blogs . " WHERE path = '" . $current_site->path . $blog_name . "/'");
				}
			}
			$blog_count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "blogs WHERE blog_id = '" . $bid . "'");
			if ( $blog_count > 0 ) {
				$blog_details = get_blog_details( $bid );
				if ( $bid != '1' ) {
					?>
					<h2><?php _e('Remove Blog') ?>: <a href="<?php echo $blog_details->siteurl; ?>" style="text-decoration:none;"><?php echo $blog_details->blogname; ?></a></h2>
					<form name="remove_blog" method="POST" action="moderation-admin.php?action=remove_blog_process&bid=<?php echo $bid; ?>">
						<table class="form-table">
						<tr valign="top">
						<th scope="row"><?php _e('Are you sure?') ?></th>
						<td>
						<select name="remove_blog" id="remove_blog">
								<option value="yes"><?php _e('Yes'); ?></option>
								<option value="no" selected="selected" ><?php _e('No'); ?></option>
						</select>
						<br /><?php //_e('') ?></td>
						</tr>
						</table>
					<p class="submit">
					<input type="submit" name="Submit" value="<?php _e('Continue') ?>" />
					</p>
					</form>
					<?php
				} else {
					?>
					<h2><?php _e('Error') ?></h2>
					<?php
					echo '<p>' . __('You cannot remove the main blog.') . '</p>';
				}
			} else {
				?>
				<h2><?php _e('Error') ?></h2>
                <?php
				echo '<p>' . __('Blog not found.') . '</p>';
			}
		break;
		//---------------------------------------------------//
		case "remove_blog_process":
			if ( $_POST['remove_blog'] == 'no' ) {
				echo "
				<SCRIPT LANGUAGE='JavaScript'>
				window.location='moderation-admin.php';
				</script>
				";
			} else {
				wpmu_delete_blog( $_GET['bid'] );
				echo "
				<SCRIPT LANGUAGE='JavaScript'>
				window.location='moderation-admin.php?updated=true&updatedmsg=" . urlencode('Blog removed') . "';
				</script>
				";
			}
		break;
		//---------------------------------------------------//
	}
	echo '</div>';
}

function moderation_posts() {
	global $wpdb, $wp_roles, $current_user, $user_ID, $current_site, $moderation_save_to_archive;

	if ( !is_moderator() ) {
		die();
	}
	
	if (isset($_GET['updated'])) {
		?><div id="message" class="updated fade"><p><?php _e(urldecode($_GET['updatedmsg'])) ?></p></div><?php
	}
	echo '<div class="wrap">';
	switch( $_GET[ 'action' ] ) {
		//---------------------------------------------------//
		default:
			?>
            <h2><?php _e('Posts') ?></h2>
			<?php
			if( isset( $_GET[ 'start' ] ) == false ) {
				$start = 0;
			} else {
				$start = intval( $_GET[ 'start' ] );
			}
			if( isset( $_GET[ 'num' ] ) == false ) {
				$num = 30;
			} else {
				$num = intval( $_GET[ 'num' ] );
			}
			
			$query = "SELECT * FROM " . $wpdb->base_prefix . "moderation_reports WHERE report_object_type = 'post' AND report_status = 'new' GROUP BY report_blog_ID, report_object_ID ORDER BY report_stamp DESC";
			$query .= " LIMIT " . intval( $start ) . ", " . intval( $num );
			$reports = $wpdb->get_results( $query, ARRAY_A );
			if( count( $reports ) < $num ) {
				$next = false;
			} else {
				$next = true;
			}
			if ( count( $reports ) > 0 ) {
				$report_count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "moderation_reports WHERE report_object_type = 'post' AND report_status = 'new' GROUP BY GROUP BY report_blog_id, report_object_type, report_object_id ORDER BY report_stamp DESC");
				if ($report_count > 30){
					?>
                    <br />
                    <table><td>
					<fieldset>
					<?php 
					
					//$order_sort = "order=" . $_GET[ 'order' ] . "&sortby=" . $_GET[ 'sortby' ];
					
					if( $start == 0 ) { 
						echo __('Previous Page');
					} elseif( $start <= 30 ) { 
						echo '<a href="moderation-admin.php?page=posts&start=0&' . $order_sort . ' " style="text-decoration:none;" >' . __('Previous Page') . '</a>';
					} else {
						echo '<a href="moderation-admin.php?page=posts&start=' . ( $start - $num ) . '&' . $order_sort . '" style="text-decoration:none;" >' . __('Previous Page') . '</a>';
					} 
					if ( $next ) {
						echo '&nbsp;||&nbsp;<a href="moderation-admin.php?page=posts&start=' . ( $start + $num ) . '&' . $order_sort . '" style="text-decoration:none;" >' . __('Next Page') . '</a>';
					} else {
						echo '&nbsp;||&nbsp;' . __('Next Page');
					}
					?>
					</fieldset>
					</td></table>
					<?php
				}
				echo "<form name='process_reports' method='POST' action='moderation-admin.php?page=posts&action=process_reports' >";
				echo "
				<br />
				<table cellpadding='3' cellspacing='3' width='100%' class='widefat'> 
				<thead><tr>
				<th scope='col'>" . __('Post') . "</th>
				<th width='25%' scope='col'>" . __('Information') . "</th>
				</tr></thead>
				<tbody id='the-list'>
				";
				//=========================================================//
					$class = ('alternate' == $class) ? '' : 'alternate';
					$date_format = get_option('date_format');
					$time_format = get_option('time_format');
					foreach ($reports as $report){
					//=========================================================//
					echo "<tr class='" . $class . "'>";

					unset( $blog_details );
					$blog_details = get_blog_details( $report['report_blog_ID'] );

					unset( $post_details );
					unset( $post_permalink );
					switch_to_blog( $report['report_blog_ID'] );
					$post_details = get_post( $report['report_object_ID'] );
					$post_permalink = get_permalink( $report['report_object_ID'] );
					restore_current_blog();

					unset( $author_user_login );
					$author_user_login = $wpdb->get_var("SELECT user_login FROM " . $wpdb->users . " WHERE ID = '" . $post_details->post_author . "'");

					unset( $reasons );
					$query = "SELECT report_reason, report_note FROM " . $wpdb->base_prefix . "moderation_reports WHERE report_object_type = 'post' AND report_status = 'new' AND report_blog_ID = '" . $report['report_blog_ID'] . "' AND report_object_ID = '" . $report['report_object_ID'] . "' ORDER BY report_stamp DESC";
					$reasons = $wpdb->get_results( $query, ARRAY_A );
					echo "<td valign='top'>" . stripslashes( $post_details->post_content ) . "</td>";
					echo "<td valign='top'>";
					echo "<strong>" . __('Post Title') . "</strong>:<br />";
					echo "<a href='" . $post_permalink . "' rel='permalink' class='edit'>" . stripslashes( $post_details->post_title ) . "</a>";
					echo "<br /><br />";
					echo "<strong>" . __('Post Author') . "</strong>:<br />";
					echo $author_user_login . " (<a href='moderation-admin.php?page=post-archive&post_type=post&uid=" . $post_details->post_author . "' rel='permalink' class='edit'>" . __('Archive') . "</a>)";
					echo "<br /><br />";
					echo "<strong>" . __('Blog') . "</strong>:<br />";
					echo "<a href='" . $blog_details->siteurl . "' rel='permalink' class='edit'>" . $blog_details->blogname . "</a> (<a href='moderation-admin.php?page=post-archive&post_type=post&bid=" . $report['report_blog_ID'] . "' rel='permalink' class='edit'>" . __('Archive') . "</a>)";
					echo "<br /><br />";
					echo "<strong>" . __('Report Date/Time') . "</strong>:<br />";
					echo date( $date_format . ' ' . $time_format, $report['report_stamp'] );
					echo "<br /><br />";
					echo "<strong>" . __('Reason(s)') . "</strong>:<br />";
					foreach ( $reasons as $reason ) {
						echo $reason['report_reason'];
						if ( !empty( $reason['report_note'] ) ) {
							echo " - " . $reason['report_note'];
						}
						echo "<br />";
					}
					echo "<br />";
					echo "<strong>" . __('Action') . "</strong>:<br />";
					echo "<select name='reports[" . $report['report_ID'] . "-" . $report['report_blog_ID'] . "-" . $report['report_object_ID'] . "]'>";
							echo "<option value='reject_report'>" . __('Reject Report') . "</option>";
							echo "<option value='remove_post'>" . __('Remove Post') . "</option>";
					echo "</select>";
					echo "<br /><br />";
					echo "<strong>" . __('Remove Note') . "</strong>:<br />";
					echo "<select name='remove_notes[" . $report['report_ID'] . "-" . $report['report_blog_ID'] . "-" . $report['report_object_ID'] . "]' style='width:200px;'>";
						$remove_notes = get_site_option('moderation_remove_notes', array('Warning: TOS violated - Further infractions could result in your account being removed','Warning: AUP violated - Further infractions could result in your account being removed'));
						foreach ( $remove_notes as $remove_note ) {
							echo "<option value='" . $remove_note . "'>" . $remove_note . "</option>";
						}
					echo "</select>";
					echo "</td>";
					$class = ('alternate' == $class) ? '' : 'alternate';
					//=========================================================//
					}
				//=========================================================//
				?>
				</tbody></table>
				<p class="submit">
				<input type="submit" name="Submit" value="<?php _e('Process Reports') ?>" />
				</p>
				</form>
				<?php
			} else {
				?>
	            <p><?php _e('There currently aren\'t any posts in the moderation queue.') ?></p>
                <?php
			}
		break;
		//---------------------------------------------------//
		case "process_reports":
			$reports = $_POST['reports'];
			$remove_notes = $_POST['remove_notes'];
			if ( count( $reports ) > 0 ) {
				foreach ( $reports as $report_information => $action ) {
					unset( $report_ID );
					unset( $blog_ID );
					unset( $post_ID );
					unset( $remove_note );
					
					foreach ( $remove_notes as $remove_note_information => $note ) {
						if ( $remove_note_information = $report_information ) {
							$remove_note = $note;
						}
					}
					
					list($report_ID, $blog_ID, $post_ID) = explode("-", $report_information);
					if ( $action == 'reject_report' ) {
						$wpdb->query( "UPDATE " . $wpdb->base_prefix . "moderation_reports SET report_status = 'rejected' WHERE report_object_type = 'post' AND report_status = 'new' AND report_blog_ID = '" . $blog_ID . "' AND report_object_ID = '" . $post_ID . "'");
					}
					if ( $action == 'remove_post' ) {
						switch_to_blog( $blog_ID );
						$post_details = get_post( $post_ID );
						if ( $moderation_save_to_archive == 'removed' ) {
							moderation_post_archive_insert($post_ID);
						}
						$wpdb->query( "DELETE FROM " . $wpdb->posts . " WHERE ID = '" . $post_ID . "'" );
						restore_current_blog();
		
						$wpdb->query( "UPDATE " . $wpdb->base_prefix . "moderation_reports SET report_status = 'removed' WHERE report_object_type = 'post' AND report_status = 'new' AND report_blog_ID = '" . $blog_ID . "' AND report_object_ID = '" . $post_ID . "'");
						$wpdb->query("INSERT IGNORE INTO " . $wpdb->base_prefix . "moderation_warnings
						(warning_user_ID, warning_note)
						VALUES
						('" . $post_details->post_author . "', '" . addslashes( $remove_note ) . "')");
					}
				}
			}
		echo "
		<SCRIPT LANGUAGE='JavaScript'>
		window.location='moderation-admin.php?page=posts&updated=true&updatedmsg=" . urlencode(__('Reports Processed.')) . "';
		</script>
		";
		break;
		//---------------------------------------------------//
		case "process":
		break;
		//---------------------------------------------------//
	}
	echo '</div>';
}

function moderation_blogs() {
	global $wpdb, $wp_roles, $current_user, $user_ID, $current_site;

	if ( !is_moderator() ) {
		die();
	}
	
	if (isset($_GET['updated'])) {
		?><div id="message" class="updated fade"><p><?php _e(urldecode($_GET['updatedmsg'])) ?></p></div><?php
	}
	echo '<div class="wrap">';
	switch( $_GET[ 'action' ] ) {
		//---------------------------------------------------//
		default:
			?>
            <h2><?php _e('Blogs') ?></h2>
			<?php
			if( isset( $_GET[ 'start' ] ) == false ) {
				$start = 0;
			} else {
				$start = intval( $_GET[ 'start' ] );
			}
			if( isset( $_GET[ 'num' ] ) == false ) {
				$num = 30;
			} else {
				$num = intval( $_GET[ 'num' ] );
			}
			
			$query = "SELECT * FROM " . $wpdb->base_prefix . "moderation_reports WHERE report_object_type = 'blog' AND report_status = 'new' GROUP BY report_blog_ID, report_object_ID ORDER BY report_stamp DESC";
			$query .= " LIMIT " . intval( $start ) . ", " . intval( $num );
			$reports = $wpdb->get_results( $query, ARRAY_A );
			if( count( $reports ) < $num ) {
				$next = false;
			} else {
				$next = true;
			}
			if ( count( $reports ) > 0 ) {
				$report_count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "moderation_reports WHERE report_object_type = 'blog' AND report_status = 'new' GROUP BY GROUP BY report_blog_id, report_object_type, report_object_id ORDER BY report_stamp DESC");
				if ($report_count > 30){
					?>
                    <br />
                    <table><td>
					<fieldset>
					<?php 
					
					//$order_sort = "order=" . $_GET[ 'order' ] . "&sortby=" . $_GET[ 'sortby' ];
					
					if( $start == 0 ) { 
						echo __('Previous Page');
					} elseif( $start <= 30 ) { 
						echo '<a href="moderation-admin.php?page=blogs&start=0&' . $order_sort . ' " style="text-decoration:none;" >' . __('Previous Page') . '</a>';
					} else {
						echo '<a href="moderation-admin.php?page=blogs&start=' . ( $start - $num ) . '&' . $order_sort . '" style="text-decoration:none;" >' . __('Previous Page') . '</a>';
					} 
					if ( $next ) {
						echo '&nbsp;||&nbsp;<a href="moderation-admin.php?page=blogss&start=' . ( $start + $num ) . '&' . $order_sort . '" style="text-decoration:none;" >' . __('Next Page') . '</a>';
					} else {
						echo '&nbsp;||&nbsp;' . __('Next Page');
					}
					?>
					</fieldset>
					</td></table>
					<?php
				}
				echo "<form name='process_reports' method='POST' action='moderation-admin.php?page=blogs&action=process_reports' >";
				echo "
				<br />
				<table cellpadding='3' cellspacing='3' width='100%' class='widefat'> 
				<thead><tr>
				<th scope='col'>" . __('Blog') . "</th>
				<th scope='col'>" . __('Report Date/Time') . "</th>
				<th scope='col'>" . __('Reason(s)') . "</th>
				<th scope='col'>" . __('Action') . "</th>
				</tr></thead>
				<tbody id='the-list'>
				";
				//=========================================================//
					$class = ('alternate' == $class) ? '' : 'alternate';
					$date_format = get_option('date_format');
					$time_format = get_option('time_format');
					foreach ($reports as $report){
					//=========================================================//
					echo "<tr class='" . $class . "'>";

					unset( $blog_details );
					$blog_details = get_blog_details( $report['report_blog_ID'] );


					unset( $reasons );
					$query = "SELECT report_reason, report_note FROM " . $wpdb->base_prefix . "moderation_reports WHERE report_object_type = 'blog' AND report_status = 'new' AND report_blog_ID = '" . $report['report_blog_ID'] . "' AND report_object_ID = '" . $report['report_object_ID'] . "' ORDER BY report_stamp DESC";
					$reasons = $wpdb->get_results( $query, ARRAY_A );

					echo "<td valign='top'><a href='" . $blog_details->siteurl . "' rel='permalink' class='edit'>" . $blog_details->blogname . "</a> (" . $blog_details->siteurl . ")</td>";
					echo "<td valign='top'>" . date( $date_format . ' ' . $time_format, $report['report_stamp'] ) . "</td>";
					echo "<td valign='top'>";
					foreach ( $reasons as $reason ) {
						echo $reason['report_reason'];
						if ( !empty( $reason['report_note'] ) ) {
							echo " - " . $reason['report_note'];
						}
						echo "<br />";
					}
					echo "</td>";
					echo "<td valign='top'>";
					echo "<select name='reports[" . $report['report_ID'] . "-" . $report['report_blog_ID'] . "]'>";
							echo "<option value='reject_report'>" . __('Reject Report') . "</option>";
							echo "<option value='suspend_blog'>" . __('Suspend Blog') . "</option>";
					echo "</select>";
					echo "</td>";
					echo "</tr>";
					$class = ('alternate' == $class) ? '' : 'alternate';
					//=========================================================//
					}
				//=========================================================//
				?>
				</tbody></table>
				<p class="submit">
				<input type="submit" name="Submit" value="<?php _e('Process Reports') ?>" />
				</p>
				</form>
				<?php
			} else {
				?>
	            <p><?php _e('There currently aren\'t any blogs in the moderation queue.') ?></p>
                <?php
			}
		break;
		//---------------------------------------------------//
		case "process_reports":
			$reports = $_POST['reports'];
			if ( count( $reports ) > 0 ) {
				foreach ( $reports as $report_information => $action ) {
					unset( $report_ID );
					unset( $blog_ID );

					list($report_ID, $blog_ID) = explode("-", $report_information);
					if ( $action == 'reject_report' ) {
						$wpdb->query( "UPDATE " . $wpdb->base_prefix . "moderation_reports SET report_status = 'rejected' WHERE report_object_type = 'blog' AND report_status = 'new' AND report_blog_ID = '" . $blog_ID . "' AND report_object_ID = '" . $blog_ID . "'");
					}
					if ( $action == 'suspend_blog' ) {
						$wpdb->query( "UPDATE " . $wpdb->base_prefix . "moderation_reports SET report_status = 'suspended' WHERE report_object_type = 'blog' AND report_status = 'new' AND report_blog_ID = '" . $blog_ID . "' AND report_object_ID = '" . $blog_ID . "'");
				
						update_archived( $blog_ID, '1' );
					}
				}
			}
		echo "
		<SCRIPT LANGUAGE='JavaScript'>
		window.location='moderation-admin.php?page=posts&updated=true&updatedmsg=" . urlencode(__('Reports Processed.')) . "';
		</script>
		";
		break;
		//---------------------------------------------------//
		case "process":
		break;
		//---------------------------------------------------//
	}
	echo '</div>';
}

function moderation_comments() {
	global $wpdb, $wp_roles, $current_user, $user_ID, $current_site, $moderation_save_to_archive;

	if ( !is_moderator() ) {
		die();
	}
	
	if (isset($_GET['updated'])) {
		?><div id="message" class="updated fade"><p><?php _e(urldecode($_GET['updatedmsg'])) ?></p></div><?php
	}
	echo '<div class="wrap">';
	switch( $_GET[ 'action' ] ) {
		//---------------------------------------------------//
		default:
			?>
            <h2><?php _e('Comments') ?></h2>
			<?php
			if( isset( $_GET[ 'start' ] ) == false ) {
				$start = 0;
			} else {
				$start = intval( $_GET[ 'start' ] );
			}
			if( isset( $_GET[ 'num' ] ) == false ) {
				$num = 30;
			} else {
				$num = intval( $_GET[ 'num' ] );
			}
			
			$query = "SELECT * FROM " . $wpdb->base_prefix . "moderation_reports WHERE report_object_type = 'comment' AND report_status = 'new' GROUP BY report_blog_ID, report_object_ID ORDER BY report_stamp DESC";
			$query .= " LIMIT " . intval( $start ) . ", " . intval( $num );
			$reports = $wpdb->get_results( $query, ARRAY_A );
			if( count( $reports ) < $num ) {
				$next = false;
			} else {
				$next = true;
			}
			if ( count( $reports ) > 0 ) {
				$report_count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "moderation_reports WHERE report_object_type = 'comment' AND report_status = 'new' GROUP BY GROUP BY report_blog_id, report_object_type, report_object_id ORDER BY report_stamp DESC");
				if ($report_count > 30){
					?>
                    <br />
                    <table><td>
					<fieldset>
					<?php 
					
					//$order_sort = "order=" . $_GET[ 'order' ] . "&sortby=" . $_GET[ 'sortby' ];
					
					if( $start == 0 ) { 
						echo __('Previous Page');
					} elseif( $start <= 30 ) { 
						echo '<a href="moderation-admin.php?page=comments&start=0&' . $order_sort . ' " style="text-decoration:none;" >' . __('Previous Page') . '</a>';
					} else {
						echo '<a href="moderation-admin.php?page=comments&start=' . ( $start - $num ) . '&' . $order_sort . '" style="text-decoration:none;" >' . __('Previous Page') . '</a>';
					} 
					if ( $next ) {
						echo '&nbsp;||&nbsp;<a href="moderation-admin.php?page=comments&start=' . ( $start + $num ) . '&' . $order_sort . '" style="text-decoration:none;" >' . __('Next Page') . '</a>';
					} else {
						echo '&nbsp;||&nbsp;' . __('Next Page');
					}
					?>
					</fieldset>
					</td></table>
					<?php
				}
				echo "<form name='process_reports' method='POST' action='moderation-admin.php?page=comments&action=process_reports' >";
				echo "
				<br />
				<table cellpadding='3' cellspacing='3' width='100%' class='widefat'> 
				<thead><tr>
				<th scope='col'>" . __('Comment') . "</th>
				<th width='25%' scope='col'>" . __('Information') . "</th>
				</tr></thead>
				<tbody id='the-list'>
				";
				//=========================================================//
					$class = ('alternate' == $class) ? '' : 'alternate';
					$date_format = get_option('date_format');
					$time_format = get_option('time_format');
					foreach ($reports as $report){
					//=========================================================//
					echo "<tr class='" . $class . "'>";

					unset( $blog_details );
					$blog_details = get_blog_details( $report['report_blog_ID'] );

					unset( $comment_details );
					unset( $post_permalink );
					switch_to_blog( $report['report_blog_ID'] );
					$comment_details = get_comment( $report['report_object_ID'] );
					restore_current_blog();

					unset( $author_user_login );
					if ( $comment_details->user_id != '0' ) {
						$author_user_login = $wpdb->get_var("SELECT user_login FROM " . $wpdb->users . " WHERE ID = '" . $comment_details->user_id . "'");
					}
					
					unset( $author_email );
					$author_email = $comment_details->comment_author_email;

					if ( !empty( $author_user_login ) ) {
						$author = $author_user_login . " (" . $author_email . ")";
					} else {
						$author = $author_email;
					}

					unset( $reasons );
					$query = "SELECT report_reason, report_note FROM " . $wpdb->base_prefix . "moderation_reports WHERE report_object_type = 'comment' AND report_status = 'new' AND report_blog_ID = '" . $report['report_blog_ID'] . "' AND report_object_ID = '" . $report['report_object_ID'] . "' ORDER BY report_stamp DESC";
					$reasons = $wpdb->get_results( $query, ARRAY_A );
					echo "<td valign='top'>" . stripslashes( $comment_details->comment_content ) . "</td>";
					echo "<td valign='top'>";
					echo "<strong>" . __('Comment Author') . "</strong>:<br />";
					echo $author . " (<a href='moderation-admin.php?page=comment-archive&email=" . $author_email . "' rel='permalink' class='edit'>" . __('Archive') . "</a>)";
					echo "<br /><br />";
					echo "<strong>" . __('Blog') . "</strong>:<br />";
					echo "<a href='" . $blog_details->siteurl . "' rel='permalink' class='edit'>" . $blog_details->blogname . "</a> (<a href='moderation-admin.php?page=comment-archive&post_type=post&bid=" . $report['report_blog_ID'] . "' rel='permalink' class='edit'>" . __('Archive') . "</a>)";
					echo "<br /><br />";
					echo "<strong>" . __('Report Date/Time') . "</strong>:<br />";
					echo date( $date_format . ' ' . $time_format, $report['report_stamp'] );
					echo "<br /><br />";
					echo "<strong>" . __('Reason(s)') . "</strong>:<br />";
					foreach ( $reasons as $reason ) {
						echo $reason['report_reason'];
						if ( !empty( $reason['report_note'] ) ) {
							echo " - " . $reason['report_note'];
						}
						echo "<br />";
					}
					echo "<br />";
					echo "<strong>" . __('Action') . "</strong>:<br />";
					echo "<select name='reports[" . $report['report_ID'] . "-" . $report['report_blog_ID'] . "-" . $report['report_object_ID'] . "]'>";
							echo "<option value='reject_report'>" . __('Reject Report') . "</option>";
							echo "<option value='remove_comment'>" . __('Remove Comment') . "</option>";
					echo "</select>";
					echo "<br /><br />";
					echo "<strong>" . __('Remove Note') . "</strong>:<br />";
					echo "<select name='remove_notes[" . $report['report_ID'] . "-" . $report['report_blog_ID'] . "-" . $report['report_object_ID'] . "]' style='width:200px;'>";
						$remove_notes = get_site_option('moderation_remove_notes', array('Warning: TOS violated - Further infractions could result in your account being removed','Warning: AUP violated - Further infractions could result in your account being removed'));
						foreach ( $remove_notes as $remove_note ) {
							echo "<option value='" . $remove_note . "'>" . $remove_note . "</option>";
						}
					echo "</select>";
					echo "</td>";
					$class = ('alternate' == $class) ? '' : 'alternate';
					//=========================================================//
					}
				//=========================================================//
				?>
				</tbody></table>
				<p class="submit">
				<input type="submit" name="Submit" value="<?php _e('Process Reports') ?>" />
				</p>
				</form>
				<?php
			} else {
				?>
	            <p><?php _e('There currently aren\'t any comments in the moderation queue.') ?></p>
                <?php
			}
		break;
		//---------------------------------------------------//
		case "process_reports":
			$reports = $_POST['reports'];
			$remove_notes = $_POST['remove_notes'];
			if ( count( $reports ) > 0 ) {
				foreach ( $reports as $report_information => $action ) {
					unset( $report_ID );
					unset( $blog_ID );
					unset( $comment_ID );
					unset( $remove_note );
					unset( $blog_admin_admin_email );
					unset( $blog_admin_user_ID );
					unset( $warning_user_ID );
					
					foreach ( $remove_notes as $remove_note_information => $note ) {
						if ( $remove_note_information = $report_information ) {
							$remove_note = $note;
						}
					}
					
					list($report_ID, $blog_ID, $comment_ID) = explode("-", $report_information);
					if ( $action == 'reject_report' ) {
						$wpdb->query( "UPDATE " . $wpdb->base_prefix . "moderation_reports SET report_status = 'rejected' WHERE report_object_type = 'comment' AND report_status = 'new' AND report_blog_ID = '" . $blog_ID . "' AND report_object_ID = '" . $comment_ID . "'");
					}
					if ( $action == 'remove_comment' ) {
						switch_to_blog( $blog_ID );
						$comment_details = get_comment( $comment_ID );
						if ( $moderation_save_to_archive == 'removed' ) {
							moderation_comment_archive_insert($comment_ID);
						}
						$wpdb->query( "DELETE FROM " . $wpdb->comments . " WHERE comment_ID = '" . $comment_ID . "'" );
						restore_current_blog();
		
						$wpdb->query( "UPDATE " . $wpdb->base_prefix . "moderation_reports SET report_status = 'removed' WHERE report_object_type = 'comment' AND report_status = 'new' AND report_blog_ID = '" . $blog_ID . "' AND report_object_ID = '" . $comment_ID . "'");
						if ( $comment_details->user_id != '0' ) {
							$warning_user_ID = $comment_details->user_id;
						} else {
							$blog_admin_admin_email = get_blog_option($blog_ID, 'admin_email');
							$blog_admin_user_ID = $wpdb->get_var("SELECT ID FROM " . $wpdb->users . " WHERE user_email = '" . $blog_admin_admin_email . "'");
							$warning_user_ID = $blog_admin_user_ID;
						}
						if ( !empty( $warning_user_ID ) ) {
							$wpdb->query("INSERT IGNORE INTO " . $wpdb->base_prefix . "moderation_warnings
							(warning_user_ID, warning_note)
							VALUES
							('" . $warning_user_ID . "', '" . addslashes( $remove_note ) . "')");
						}
					}
				}
			}
		echo "
		<SCRIPT LANGUAGE='JavaScript'>
		window.location='moderation-admin.php?page=comments&updated=true&updatedmsg=" . urlencode(__('Reports Processed.')) . "';
		</script>
		";
		break;
		//---------------------------------------------------//
		case "process":
		break;
		//---------------------------------------------------//
	}
	echo '</div>';
}

function moderation_post_archive() {
	global $wpdb, $wp_roles, $current_user, $user_ID, $current_site;

	if ( !is_moderator() ) {
		die();
	}
	
	if (isset($_GET['updated'])) {
		?><div id="message" class="updated fade"><p><?php _e(urldecode($_GET['updatedmsg'])) ?></p></div><?php
	}
	echo '<div class="wrap">';
	switch( $_GET[ 'action' ] ) {
		//---------------------------------------------------//
		default:
			$pid = $_POST['pid'];
			if ( empty( $pid ) ) {
				$pid = $_GET['pid'];
			}
			$bid = $_POST['bid'];
			if ( empty( $bid ) ) {
				$bid = $_GET['bid'];
			}
			$blog_name = $_POST['blog_name'];
			if ( empty( $blog_name ) ) {
				$blog_name = $_GET['blog_name'];
			}
			$uid = $_POST['uid'];
			if ( empty( $uid ) ) {
				$uid = $_GET['uid'];
			}
			$user_login = $_POST['user_login'];
			if ( empty( $user_login ) ) {
				$user_login = $_GET['user_login'];
			}
			$user_email = $_POST['user_email'];
			if ( empty( $user_email ) ) {
				$user_email = $_GET['user_email'];
			}
			$post_type = $_POST['post_type'];
			if ( empty( $post_type ) ) {
				$post_type = $_GET['post_type'];
			}
			if ( !empty( $blog_name ) ) {
				if (VHOST == 'yes') {
					$bid = $wpdb->get_var("SELECT blog_id FROM " . $wpdb->blogs . " WHERE domain = '" . $blog_name . "." . $current_site->domains . "'");
				} else {
					$bid = $wpdb->get_var("SELECT blog_id FROM " . $wpdb->blogs . " WHERE path = '" . $current_site->path . $blog_name . "/'");
				}
			}
			if ( !empty( $user_login ) ) {
				$uid = $wpdb->get_var("SELECT ID FROM " . $wpdb->users . " WHERE user_login = '" . $user_login . "'");
			}
			if ( !empty( $user_email ) ) {
				$uid = $wpdb->get_var("SELECT ID FROM " . $wpdb->users . " WHERE user_email = '" . $user_email . "'");
			}
			
			
			?>
            <h2><?php _e('Post Archive') ?></h2>
            <?php
			if ( empty( $post_type ) ) {
			?>
            <form name="post_archive" method="POST" action="moderation-admin.php?page=post-archive">
                <table class="form-table">
                <tr valign="top"> 
                <th scope="row"><?php _e('Post Type') ?></th> 
                <td><select name="post_type">
                    <option value="post"><?php _e('Post'); ?></option>
                    <option value="page" ><?php _e('Page'); ?></option>
                    <option value="revision" ><?php _e('Revision'); ?></option>
                    <option value="all" selected="selected" ><?php _e('All'); ?></option>
                </select>
                </td> 
                </tr>
                <tr valign="top">
                <th scope="row"><?php _e('Post ID') ?></th>
                <td><input type="text" name="pid" id="pid" style="width: 95%" value="" />
                <br />
                <?php //_e('') ?></td> 
                </tr>
                <tr valign="top">
                <th scope="row"><?php _e('Blog ID') ?></th>
                <td><input type="text" name="bid" id="bid" style="width: 95%" value="" />
                <br />
                <?php //_e('') ?></td> 
                </tr>
                <tr valign="top">
                <th scope="row"><?php _e('Blogname') ?></th>
                <td><input type="text" name="blog_name" id="blog_name" style="width: 95%" value="" />
                <br />
                <?php //_e('') ?></td> 
                </tr>
                <tr valign="top">
                <th scope="row"><?php _e('Username') ?></th>
                <td><input type="text" name="user_login" id="user_login" style="width: 95%" value="" />
                <br />
                <?php //_e('') ?></td> 
                </tr>
                <tr valign="top">
                <th scope="row"><?php _e('User ID') ?></th>
                <td><input type="text" name="uid" id="uid" style="width: 95%" value="" />
                <br />
                <?php //_e('') ?></td> 
                </tr>
                <tr valign="top">
                <th scope="row"><?php _e('User Email') ?></th>
                <td><input type="text" name="user_email" id="user_email" style="width: 95%" value="" />
                <br />
                <?php //_e('') ?></td> 
                </tr>
                </table>
            <p><?php _e('Note that only posts published after the moderation plugin was added will be available.'); ?></p>
            <p class="submit">
            <input type="submit" name="Submit" value="<?php _e('Search') ?>" /> 
            </p> 
            </form>
			<?php
			}
			if ( !empty( $post_type ) ) {
                if( isset( $_GET[ 'start' ] ) == false ) {
                    $start = 0;
                } else {
                    $start = intval( $_GET[ 'start' ] );
                }
                if( isset( $_GET[ 'num' ] ) == false ) {
                    $num = 30;
                } else {
                    $num = intval( $_GET[ 'num' ] );
                }
                
                $count = 0;
                if ( !empty( $uid ) || !empty( $bid ) || !empty( $pid ) || ( !empty( $post_type ) && $post_type != 'all' ) ) {
                    $where =  "WHERE ";
                }
                if ( $post_type != 'all' ) {
                    $where = $where . "post_type = '" . $post_type . "' ";
                    $count = $count + 1;
                }
                if ( !empty( $uid ) ) {
                    if ( $count > 0 ) {
                    $where = $where . "AND ";
                    }
                    $where = $where . "post_author = '" . $uid . "' ";
                    $count = $count + 1;
                }
                if ( !empty( $bid ) ) {
                    if ( $count > 0 ) {
                    $where = $where . "AND ";
                    }
                    $where = $where . "blog_id = '" . $bid . "' ";
                    $count = $count + 1;
                }
                if ( !empty( $pid ) ) {
                    if ( $count > 0 ) {
                    $where = $where . "AND ";
                    }
                    $where = $where . "post_id = '" . $pid . "' ";
                    $count = $count + 1;
                }
                
                $query = "SELECT * FROM " . $wpdb->base_prefix . "post_archive " . $where . " ORDER BY post_stamp DESC";
                $query .= " LIMIT " . intval( $start ) . ", " . intval( $num );
                $posts = $wpdb->get_results( $query, ARRAY_A );
                if( count( $posts ) < $num ) {
                    $next = false;
                } else {
                    $next = true;
                }
                if ( count( $posts ) > 0 ) {
                    $post_count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "post_archive " . $where);
                    if ($post_count > 30){
                        ?>
                        <br />
                        <table><td>
                        <fieldset>
                        <?php 
                        
                        //$order_sort = "order=" . $_GET[ 'order' ] . "&sortby=" . $_GET[ 'sortby' ];
                        
                        if( $start == 0 ) { 
                            echo __('Previous Page');
                        } elseif( $start <= 30 ) { 
                            echo '<a href="moderation-admin.php?page=post-archive&post_type=' . $post_type . '&uid=' . $uid . '&bid=' . $bid . '&start=0&' . $order_sort . ' " style="text-decoration:none;" >' . __('Previous Page') . '</a>';
                        } else {
                            echo '<a href="moderation-admin.php?page=post-archive&post_type=' . $post_type . '&uid=' . $uid . '&bid=' . $bid . '&start=' . ( $start - $num ) . '&' . $order_sort . '" style="text-decoration:none;" >' . __('Previous Page') . '</a>';
                        } 
                        if ( $next ) {
                            echo '&nbsp;||&nbsp;<a href="moderation-admin.php?page=post-archive&post_type=' . $post_type . '&uid=' . $uid . '&bid=' . $bid . '&start=' . ( $start + $num ) . '&' . $order_sort . '" style="text-decoration:none;" >' . __('Next Page') . '</a>';
                        } else {
                            echo '&nbsp;||&nbsp;' . __('Next Page');
                        }
                        ?>
                        </fieldset>
                        </td></table>
                        <?php
                    }
                    echo "
                    <br />
                    <table cellpadding='3' cellspacing='3' width='100%' class='widefat'> 
                    <thead><tr>
                    <th scope='col'>" . __('Blog') . "</th>
                    <th scope='col'>" . __('Author') . "</th>
                    <th scope='col'>" . __('Title') . "</th>
                    <th scope='col'>" . __('Date/Time') . "</th>
                    <th scope='col'>" . __('Type') . "</th>
                    <th scope='col'>" . __('Actions') . "</th>
                    </tr></thead>
                    <tbody id='the-list'>
                    ";
                    //=========================================================//
                        $class = ('alternate' == $class) ? '' : 'alternate';
                        $date_format = get_option('date_format');
                        $time_format = get_option('time_format');
                        foreach ($posts as $post){
                        //=========================================================//
                        echo "<tr class='" . $class . "'>";
    
                        unset( $blog_details );
                        $blog_details = get_blog_details( $post['blog_id'] );
    
                        unset( $author_user_login );
                        $author_user_login = $wpdb->get_var("SELECT user_login FROM " . $wpdb->users . " WHERE ID = '" . $post['post_author'] . "'");
    
                        echo "<td valign='top'><a href='" . $blog_details->siteurl . "' rel='permalink' class='edit'>" . $blog_details->blogname . "</a> (<a href='moderation-admin.php?page=post-archive&post_type=" . $post_type . "&bid=" . $post['blog_id'] . "' rel='permalink' class='edit'>" . __('Archive') . "</a>)</td>";
                        echo "<td valign='top'>" . $author_user_login . " (<a href='moderation-admin.php?page=post-archive&post_type=" . $post_type . "&uid=" . $post['post_author'] . "' rel='permalink' class='edit'>" . __('Archive') . "</a>)</td>";
                        echo "<td valign='top'>" . stripslashes( $post['post_title'] ) . "</td>";
                        echo "<td valign='top'>" . date( $date_format . ' ' . $time_format, $post['post_stamp'] ) . "</td>";
                        echo "<td valign='top'>" . ucfirst( $post['post_type'] ) . "</td>";
                        echo "<td valign='top'><a href='moderation-admin.php?page=post-archive&action=view&post_archive_id=" . $post['post_archive_id'] . "&start=" . $_GET['start'] . "&num=" . $_GET['num'] . "&post_type=" . $post_type . "&bid=" . $bid . "&uid=" . $uid . "&pid=" . $pid . "' rel='permalink' class='edit'>" . __('View') . "</a></td>";
    
                        echo "</tr>";
                        $class = ('alternate' == $class) ? '' : 'alternate';
                        //=========================================================//
                        }
                    //=========================================================//
                    ?>
                    </tbody></table>
                    <?php
                } else {
                    ?>
                    <p><?php _e('No posts found.') ?></p>
                    <?php
                }
			}
		break;
		//---------------------------------------------------//
		case "view":
			$post_details = $wpdb->get_row("SELECT * FROM " . $wpdb->base_prefix . "post_archive WHERE post_archive_id = '" . $_GET['post_archive_id'] . "'");
			$blog_details = get_blog_details( $post_details->blog_id );
			$author_user_login = $wpdb->get_var("SELECT user_login FROM " . $wpdb->users . " WHERE ID = '" . $post_details->post_author . "'");
			?>
        	<h2><?php echo stripslashes($post_details->post_title); ?></h2>
            <ul>
            	<li><strong><?php _e('Blog'); ?>: </strong><a href="<?php echo $blog_details->siteurl; ?>" style="text-decoration:none;"><?php echo $blog_details->blogname; ?></a> (<a href="moderation-admin.php?page=post-archive&post_type=<?php echo $_GET['post_type']; ?>&bid=<?php echo $post_details->blog_id; ?>" style="text-decoration:none;"><?php _e('Archive'); ?></a>)</li>
            	<li><strong><?php _e('Author'); ?>: </strong><?php echo $author_user_login; ?>  (<a href="moderation-admin.php?page=post-archive&post_type=<?php echo $_GET['post_type']; ?>&uid=<?php echo $post_details->post_author; ?>" style="text-decoration:none;"><?php _e('Archive'); ?></a>)</li>
            	<li><strong><?php _e('Date/Time'); ?>: </strong><?php echo date( get_option('date_format') . ' ' . get_option('time_format'), $post_details->post_stamp ); ?></li>
            </ul>
        	<p><?php echo stripslashes($post_details->post_content); ?></p>
            <?php
			if ( !empty($_GET['start']) || !empty($_GET['num']) ) {
				?>
				<form name="post_archive" method="POST" action="moderation-admin.php?page=post-archive&start=<?php echo $_GET['start']; ?>&num=<?php echo $_GET['num']; ?>&post_type=<?php echo $_GET['post_type']; ?>&bid=<?php echo $_GET['bid']; ?>&uid=<?php echo $_GET['uid']; ?>&pid=<?php echo $_GET['pid']; ?>">
                <?php
			} else {
				?>
            	<form name="post_archive" method="POST" action="moderation-admin.php?page=post-archive&post_type=<?php echo $_GET['post_type']; ?>&bid=<?php echo $_GET['bid']; ?>&uid=<?php echo $_GET['uid']; ?>&pid=<?php echo $_GET['pid']; ?>">
                <?php
			}
			?>
            <p class="submit">
            <input type="submit" name="Submit" value="<?php _e('Return') ?>" /> 
            </p> 
            </form>
    	    <?php
		break;
		//---------------------------------------------------//
		case "process":
		break;
		//---------------------------------------------------//
	}
	echo '</div>';
}

function moderation_comment_archive() {
	global $wpdb, $wp_roles, $current_user, $user_ID, $current_site;

	if ( !is_moderator() ) {
		die();
	}
	
	if (isset($_GET['updated'])) {
		?><div id="message" class="updated fade"><p><?php _e(urldecode($_GET['updatedmsg'])) ?></p></div><?php
	}
	echo '<div class="wrap">';
	switch( $_GET[ 'action' ] ) {
		//---------------------------------------------------//
		default:
			$cid = $_POST['cid'];
			if ( empty( $cid ) ) {
				$cid = $_GET['cid'];
			}
			$bid = $_POST['bid'];
			if ( empty( $bid ) ) {
				$bid = $_GET['bid'];
			}
			$blog_name = $_POST['blog_name'];
			if ( empty( $blog_name ) ) {
				$blog_name = $_GET['blog_name'];
			}
			$uid = $_POST['uid'];
			if ( empty( $uid ) ) {
				$uid = $_GET['uid'];
			}
			$ip = $_POST['ip'];
			if ( empty( $ip ) ) {
				$ip = $_GET['ip'];
			}
			$user_login = $_POST['user_login'];
			if ( empty( $user_login ) ) {
				$user_login = $_GET['user_login'];
			}
			$email = $_POST['email'];
			if ( empty( $email ) ) {
				$email = $_GET['email'];
			}
			if ( !empty( $blog_name ) ) {
				if (VHOST == 'yes') {
					$bid = $wpdb->get_var("SELECT blog_id FROM " . $wpdb->blogs . " WHERE domain = '" . $blog_name . "." . $current_site->domains . "'");
				} else {
					$bid = $wpdb->get_var("SELECT blog_id FROM " . $wpdb->blogs . " WHERE path = '" . $current_site->path . $blog_name . "/'");
				}
			}
			if ( !empty( $user_login ) ) {
				$uid = $wpdb->get_var("SELECT ID FROM " . $wpdb->users . " WHERE user_login = '" . $user_login . "'");
			}
			
			?>
            <h2><?php _e('Comment Archive') ?></h2>
            <?php
			if ( empty( $cid ) && empty( $bid ) && empty( $email ) && empty( $ip ) && !isset( $_POST['search'] ) ) {
			?>
            <form name="post_archive" method="POST" action="moderation-admin.php?page=comment-archive">
            	<input type="hidden" name="search" value="search" />
                <table class="form-table">
                <tr valign="top">
                <th scope="row"><?php _e('Comment ID') ?></th>
                <td><input type="text" name="cid" id="cid" style="width: 95%" value="" />
                <br />
                <?php //_e('') ?></td> 
                </tr>
                <tr valign="top">
                <th scope="row"><?php _e('Blog ID') ?></th>
                <td><input type="text" name="bid" id="bid" style="width: 95%" value="" />
                <br />
                <?php //_e('') ?></td> 
                </tr>
                <tr valign="top">
                <th scope="row"><?php _e('Blogname') ?></th>
                <td><input type="text" name="blog_name" id="blog_name" style="width: 95%" value="" />
                <br />
                <?php //_e('') ?></td> 
                </tr>
                <tr valign="top">
                <th scope="row"><?php _e('Username') ?></th>
                <td><input type="text" name="user_login" id="user_login" style="width: 95%" value="" />
                <br />
                <?php //_e('') ?></td> 
                </tr>
                <tr valign="top">
                <th scope="row"><?php _e('User ID') ?></th>
                <td><input type="text" name="uid" id="uid" style="width: 95%" value="" />
                <br />
                <?php //_e('') ?></td> 
                </tr>
                <tr valign="top">
                <th scope="row"><?php _e('Email') ?></th>
                <td><input type="text" name="user_email" id="user_email" style="width: 95%" value="" />
                <br />
                <?php //_e('') ?></td> 
                </tr>
                <tr valign="top">
                <th scope="row"><?php _e('IP') ?></th>
                <td><input type="text" name="ip" id="ip" style="width: 95%" value="" />
                <br />
                <?php //_e('') ?></td> 
                </tr>
                </table>
            <p><?php _e('Note that only comments published after the moderation plugin was added will be available.'); ?></p>
            <p class="submit">
            <input type="submit" name="Submit" value="<?php _e('Search') ?>" /> 
            </p> 
            </form>
			<?php
			}
			if ( !empty( $cid ) || !empty( $bid ) || !empty( $email ) || !empty( $ip ) || isset( $_POST['search'] ) ) {
                if( isset( $_GET[ 'start' ] ) == false ) {
                    $start = 0;
                } else {
                    $start = intval( $_GET[ 'start' ] );
                }
                if( isset( $_GET[ 'num' ] ) == false ) {
                    $num = 30;
                } else {
                    $num = intval( $_GET[ 'num' ] );
                }
                
                $count = 0;
                if ( !empty( $uid ) || !empty( $bid ) || !empty( $cid ) || !empty( $ip ) || !empty( $email ) ) {
                    $where =  "WHERE ";
                }
                if ( !empty( $uid ) ) {
                    if ( $count > 0 ) {
                    $where = $where . "AND ";
                    }
                    $where = $where . "comment_author_user_id = '" . $uid . "' ";
                    $count = $count + 1;
                }
                if ( !empty( $bid ) ) {
                    if ( $count > 0 ) {
                    $where = $where . "AND ";
                    }
                    $where = $where . "blog_id = '" . $bid . "' ";
                    $count = $count + 1;
                }
                if ( !empty( $cid ) ) {
                    if ( $count > 0 ) {
                    $where = $where . "AND ";
                    }
                    $where = $where . "comment_id = '" . $cid . "' ";
                    $count = $count + 1;
                }
                if ( !empty( $email ) ) {
                    if ( $count > 0 ) {
                    $where = $where . "AND ";
                    }
                    $where = $where . "comment_author_email = '" . $email . "' ";
                    $count = $count + 1;
                }
                if ( !empty( $ip ) ) {
                    if ( $count > 0 ) {
                    $where = $where . "AND ";
                    }
                    $where = $where . "comment_author_ip = '" . $ip . "' ";
                    $count = $count + 1;
                }
                
                $query = "SELECT * FROM " . $wpdb->base_prefix . "comment_archive " . $where . " ORDER BY comment_stamp DESC";
                $query .= " LIMIT " . intval( $start ) . ", " . intval( $num );
                $comments = $wpdb->get_results( $query, ARRAY_A );
                if( count( $comments ) < $num ) {
                    $next = false;
                } else {
                    $next = true;
                }
                if ( count( $comments ) > 0 ) {
                    $comment_count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "comment_archive " . $where);
                    if ($comment_count > 30){
                        ?>
                        <br />
                        <table><td>
                        <fieldset>
                        <?php 
                        
                        //$order_sort = "order=" . $_GET[ 'order' ] . "&sortby=" . $_GET[ 'sortby' ];
                        
                        if( $start == 0 ) { 
                            echo __('Previous Page');
                        } elseif( $start <= 30 ) { 
                            echo '<a href="moderation-admin.php?page=comment-archive&uid=' . $uid . '&bid=' . $bid . '&ip=' . $ip . '&email=' . $email . '&start=0&' . $order_sort . ' " style="text-decoration:none;" >' . __('Previous Page') . '</a>';
                        } else {
                            echo '<a href="moderation-admin.php?page=comment-archive&uid=' . $uid . '&bid=' . $bid . '&ip=' . $ip . '&email=' . $email . '&start=' . ( $start - $num ) . '&' . $order_sort . '" style="text-decoration:none;" >' . __('Previous Page') . '</a>';
                        } 
                        if ( $next ) {
                            echo '&nbsp;||&nbsp;<a href="moderation-admin.php?page=comment-archive&uid=' . $uid . '&bid=' . $bid . '&ip=' . $ip . '&email=' . $email . '&start=' . ( $start + $num ) . '&' . $order_sort . '" style="text-decoration:none;" >' . __('Next Page') . '</a>';
                        } else {
                            echo '&nbsp;||&nbsp;' . __('Next Page');
                        }
                        ?>
                        </fieldset>
                        </td></table>
                        <?php
                    }
                    echo "
                    <br />
                    <table cellpadding='3' cellspacing='3' width='100%' class='widefat'> 
                    <thead><tr>
                    <th scope='col'>" . __('Blog') . "</th>
                    <th scope='col'>" . __('Author') . "</th>
                    <th scope='col'>" . __('Date/Time') . "</th>
                    <th scope='col'>" . __('Actions') . "</th>
                    </tr></thead>
                    <tbody id='the-list'>
                    ";
                    //=========================================================//
                        $class = ('alternate' == $class) ? '' : 'alternate';
                        $date_format = get_option('date_format');
                        $time_format = get_option('time_format');
                        foreach ($comments as $comment){
                        //=========================================================//
                        echo "<tr class='" . $class . "'>";
    
                        unset( $blog_details );
                        $blog_details = get_blog_details( $comment['blog_id'] );
    
						unset( $author_user_login );
						if ( $comment['comment_author_user_id'] != '0' ) {
							$author_user_login = $wpdb->get_var("SELECT user_login FROM " . $wpdb->users . " WHERE ID = '" . $comment['comment_author_user_id'] . "'");
						}
						
						unset( $author_email );
						$author_email = $comment['comment_author_email'];
	
						if ( !empty( $author_user_login ) ) {
							$author = $author_user_login . " (" . $author_email . ")";
						} else {
							$author = $author_email;
						}
    
                        echo "<td valign='top'><a href='" . $blog_details->siteurl . "' rel='permalink' class='edit'>" . $blog_details->blogname . "</a> (<a href='moderation-admin.php?page=comment-archive&bid=" . $comment['blog_id'] . "' rel='permalink' class='edit'>" . __('Archive') . "</a>)</td>";
                        echo "<td valign='top'>" . $author . " (<a href='moderation-admin.php?page=comment-archive&email=" . $author_email . "' rel='permalink' class='edit'>" . __('Archive') . "</a>)</td>";
                        echo "<td valign='top'>" . date( $date_format . ' ' . $time_format, $comment['comment_stamp'] ) . "</td>";
                        echo "<td valign='top'><a href='moderation-admin.php?page=comment-archive&action=view&comment_archive_id=" . $comment['comment_archive_id'] . "&start=" . $_GET['start'] . "&num=" . $_GET['num'] . "&bid=" . $bid . "&uid=" . $uid . "&ip=" . $ip . "&email=" . $email . "&cid=" . $cid . "' rel='permalink' class='edit'>" . __('View') . "</a></td>";
    
                        echo "</tr>";
                        $class = ('alternate' == $class) ? '' : 'alternate';
                        //=========================================================//
                        }
                    //=========================================================//
                    ?>
                    </tbody></table>
                    <?php
                } else {
                    ?>
                    <p><?php _e('No comments found.') ?></p>
                    <?php
                }
			}
		break;
		//---------------------------------------------------//
		case "view":
			$comment_details = $wpdb->get_row("SELECT * FROM " . $wpdb->base_prefix . "comment_archive WHERE comment_archive_id = '" . $_GET['comment_archive_id'] . "'");
			$blog_details = get_blog_details( $comment_details->blog_id );
			if ( $comment_details->comment_author_user_id != '0' ) {
				$author_user_login = $wpdb->get_var("SELECT user_login FROM " . $wpdb->users . " WHERE ID = '" . $comment_details->comment_author_user_id . "'");
			}
			
			$author_email = $comment_details->comment_author_email;

			if ( !empty( $author_user_login ) ) {
				$author = $author_user_login . " (" . $author_email . ")";
			} else {
				$author = $author_email;
			}
			?>
        	<h2><?php __('View Comment'); ?></h2>
            <ul>
            	<li><strong><?php _e('Blog'); ?>: </strong><a href="<?php echo $blog_details->siteurl; ?>" style="text-decoration:none;"><?php echo $blog_details->blogname; ?></a> (<a href="moderation-admin.php?page=comment-archive&bid=<?php echo $comment_details->blog_id; ?>" style="text-decoration:none;"><?php _e('Archive'); ?></a>)</li>
            	<li><strong><?php _e('Author'); ?>: </strong><?php echo $author; ?>  (<a href="moderation-admin.php?page=comment-archive&email=<?php echo $author_email; ?>" style="text-decoration:none;"><?php _e('Archive'); ?></a>)</li>
            	<li><strong><?php _e('Date/Time'); ?>: </strong><?php echo date( get_option('date_format') . ' ' . get_option('time_format'), $comment_details->comment_stamp ); ?></li>
            </ul>
        	<p><?php echo stripslashes($comment_details->comment_content); ?></p>
            <?php
			if ( !empty($_GET['start']) || !empty($_GET['num']) ) {
				?>
				<form name="comment_archive" method="POST" action="moderation-admin.php?page=comment-archive&start=<?php echo $_GET['start']; ?>&num=<?php echo $_GET['num']; ?>&&bid=<?php echo $_GET['bid']; ?>&uid=<?php echo $_GET['uid']; ?>&ip=<?php echo $_GET['ip']; ?>&email=<?php echo $_GET['email']; ?>&cid=<?php echo $_GET['cid']; ?>">
                <?php
			} else {
				?>
            	<form name="comment_archive" method="POST" action="moderation-admin.php?page=comment-archive&bid=<?php echo $_GET['bid']; ?>&uid=<?php echo $_GET['uid']; ?>&ip=<?php echo $_GET['ip']; ?>&email=<?php echo $_GET['email']; ?>&cid=<?php echo $_GET['cid']; ?>">
                <?php
			}
			?>
            <p class="submit">
            <input type="submit" name="Submit" value="<?php _e('Return') ?>" /> 
            </p> 
            </form>
    	    <?php
		break;
		//---------------------------------------------------//
		case "process":
		break;
		//---------------------------------------------------//
	}
	echo '</div>';
}

function moderation_report_archive() {
	global $wpdb, $wp_roles, $current_user, $user_ID, $current_site;

	if ( !is_moderator() ) {
		die();
	}
	
	if (isset($_GET['updated'])) {
		?><div id="message" class="updated fade"><p><?php _e(urldecode($_GET['updatedmsg'])) ?></p></div><?php
	}
	echo '<div class="wrap">';
	switch( $_GET[ 'action' ] ) {
		//---------------------------------------------------//
		default:
			$report_type = $_POST['report_type'];
			if ( empty( $report_type ) ) {
				$report_type = $_GET['report_type'];
			}
			$bid = $_POST['bid'];
			if ( empty( $bid ) ) {
				$bid = $_GET['bid'];
			}
			$pid = $_POST['pid'];
			if ( empty( $pid ) ) {
				$pid = $_GET['pid'];
			}
			if ( !empty( $pid ) ) {
				$report_type = 'post';
			}
			$cid = $_POST['cid'];
			if ( empty( $cid ) ) {
				$cid = $_GET['cid'];
			}
			if ( !empty( $cid ) ) {
				$report_type = 'comment';
			}
			?>
            <h2><?php _e('Report Archive') ?></h2>
            <?php
			if ( empty( $report_type ) ) {
			?>
            <form name="report_archive" method="POST" action="moderation-admin.php?page=report-archive">
                <table class="form-table">
                <tr valign="top"> 
                <th scope="row"><?php _e('Report Type') ?></th> 
                <td><select name="report_type">
                    <option value="post"><?php _e('Post'); ?></option>
                    <option value="comment" ><?php _e('Comment'); ?></option>
                    <option value="blog" ><?php _e('Blog'); ?></option>
                    <option value="all" selected="selected" ><?php _e('All'); ?></option>
                </select>
                </td> 
                </tr>
                <tr valign="top">
                <th scope="row"><?php _e('Blog ID') ?></th>
                <td><input type="text" name="bid" id="bid" style="width: 95%" value="" />
                <br />
                <?php //_e('') ?></td> 
                </tr>
                <tr valign="top">
                <th scope="row"><?php _e('Post ID') ?></th>
                <td><input type="text" name="pid" id="pid" style="width: 95%" value="" />
                <br />
                <?php //_e('') ?></td> 
                </tr>
                <tr valign="top">
                <th scope="row"><?php _e('Comment ID') ?></th>
                <td><input type="text" name="cid" id="cid" style="width: 95%" value="" />
                <br />
                <?php //_e('') ?></td> 
                </tr>
                </table>
            <p class="submit">
            <input type="submit" name="Submit" value="<?php _e('Search') ?>" /> 
            </p> 
            </form>
			<?php
			}
			if ( !empty( $report_type ) ) {
                if( isset( $_GET[ 'start' ] ) == false ) {
                    $start = 0;
                } else {
                    $start = intval( $_GET[ 'start' ] );
                }
                if( isset( $_GET[ 'num' ] ) == false ) {
                    $num = 30;
                } else {
                    $num = intval( $_GET[ 'num' ] );
                }

                $where =  "WHERE report_status != 'new' ";
                if ( $report_type != 'all' ) {
                    $where = $where . "AND report_object_type = '" . $report_type . "' ";
                }
                if ( !empty($bid ) ) {
                    $where = $where . "AND report_blog_ID = '" . $bid . "' ";
                }
                if ( !empty($pid ) ) {
                    $where = $where . "AND report_object_ID = '" . $pid . "' ";
                }
                if ( !empty($cid ) ) {
                    $where = $where . "AND report_object_ID = '" . $cid . "' ";
                }
                
                $query = "SELECT * FROM " . $wpdb->base_prefix . "moderation_reports " . $where . " ORDER BY report_stamp DESC";
                $query .= " LIMIT " . intval( $start ) . ", " . intval( $num );
                $reports = $wpdb->get_results( $query, ARRAY_A );
                if( count( $reports ) < $num ) {
                    $next = false;
                } else {
                    $next = true;
                }
                if ( count( $reports ) > 0 ) {
                    $report_count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "moderation_reports " . $where);
                    if ($report_count > 30){
                        ?>
                        <br />
                        <table><td>
                        <fieldset>
                        <?php 
                        
                        //$order_sort = "order=" . $_GET[ 'order' ] . "&sortby=" . $_GET[ 'sortby' ];
                        
                        if( $start == 0 ) { 
                            echo __('Previous Page');
                        } elseif( $start <= 30 ) { 
                            echo '<a href="moderation-admin.php?page=report-archive&cid=' . $cid . '&bid=' . $bid . '&pid=' . $pid . '&report_type=' . $report_type . '&start=0&' . $order_sort . ' " style="text-decoration:none;" >' . __('Previous Page') . '</a>';
                        } else {
                            echo '<a href="moderation-admin.php?page=report-archive&cid=' . $cid . '&bid=' . $bid . '&pid=' . $pid . '&report_type=' . $report_type . '&start=' . ( $start - $num ) . '&' . $order_sort . '" style="text-decoration:none;" >' . __('Previous Page') . '</a>';
                        } 
                        if ( $next ) {
                            echo '&nbsp;||&nbsp;<a href="moderation-admin.php?page=report-archive&cid=' . $cid . '&bid=' . $bid . '&pid=' . $pid . '&report_type=' . $report_type . '&start=' . ( $start + $num ) . '&' . $order_sort . '" style="text-decoration:none;" >' . __('Next Page') . '</a>';
                        } else {
                            echo '&nbsp;||&nbsp;' . __('Next Page');
                        }
                        ?>
                        </fieldset>
                        </td></table>
                        <?php
                    }
                    echo "
                    <br />
                    <table cellpadding='3' cellspacing='3' width='100%' class='widefat'> 
                    <thead><tr>
                    <th scope='col'>" . __('Report Type') . "</th>
					<th scope='col'>" . __('Report Reason') . "</th>
					<th scope='col'>" . __('Report Status') . "</th>
                    <th scope='col'>" . __('Blog') . "</th>
                    <th scope='col'>" . __('Date/Time') . "</th>
                    <th scope='col'>" . __('Actions') . "</th>
                    </tr></thead>
                    <tbody id='the-list'>
                    ";
                    //=========================================================//
                        $class = ('alternate' == $class) ? '' : 'alternate';
                        $date_format = get_option('date_format');
                        $time_format = get_option('time_format');
                        foreach ($reports as $report){
                        //=========================================================//
                        echo "<tr class='" . $class . "'>";
    
                        unset( $blog_details );
                        $blog_details = get_blog_details( $report['report_blog_ID'] );

						unset( $report_reason );
						$report_reason = $report['report_reason'];
						if ( !empty( $report['report_note'] ) ) {
							$report_reason = $report_reason . ' - ' . $report['report_note'];
						}

						echo "<td valign='top'>" . ucfirst( $report['report_object_type'] ) . "</td>";
						echo "<td valign='top'>" . $report_reason . "</td>";
						echo "<td valign='top'>" . ucfirst( $report['report_status'] ) . "</td>";
						echo "<td valign='top'><a href='" . $blog_details->siteurl . "' rel='permalink' class='edit'>" . $blog_details->blogname . "</a> (" . $blog_details->siteurl . ")</td>";
						
                        echo "<td valign='top'>" . date( $date_format . ' ' . $time_format, $report['report_stamp'] ) . "</td>";
                        echo "<td valign='top'>";
						if ( $report['report_object_type'] == 'post' ) {
							echo "<a href='moderation-admin.php?page=post-archive&post_type=all&bid=" . $report['report_blog_ID'] . "&pid=" . $report['report_object_ID'] . "' rel='permalink' class='edit'>" . __('View') . "</a>";
						}
						if ( $report['report_object_type'] == 'comment' ) {
							echo "<a href='moderation-admin.php?page=comment-archive&bid=" . $report['report_blog_ID'] . "&cid=" . $report['report_object_ID'] . "' rel='permalink' class='edit'>" . __('View') . "</a>";
						}
						echo"</td>";
    
                        echo "</tr>";
                        $class = ('alternate' == $class) ? '' : 'alternate';
                        //=========================================================//
                        }
                    //=========================================================//
                    ?>
                    </tbody></table>
                    <?php
                } else {
                    ?>
                    <p><?php _e('No reports found.') ?></p>
                    <?php
                }
			}
		break;
		//---------------------------------------------------//
		case "process":
		break;
		//---------------------------------------------------//
	}
	echo '</div>';
}

function moderation_warnings() {
	global $wpdb, $wp_roles, $current_user, $user_ID, $current_site;
	
	if (isset($_GET['updated'])) {
		?><div id="message" class="updated fade"><p><?php _e(urldecode($_GET['updatedmsg'])) ?></p></div><?php
	}
	echo '<div class="wrap">';
	switch( $_GET[ 'action' ] ) {
		//---------------------------------------------------//
		default:
			?>
            <h2><?php _e('Warnings') ?></h2>
            <ul>
            <?php
			$query = "SELECT warning_note FROM " . $wpdb->base_prefix . "moderation_warnings WHERE warning_user_ID = '" . $user_ID . "' AND warning_read = '0'";
			$warnings = $wpdb->get_results( $query, ARRAY_A );
			foreach ( $warnings as $warning ) {
				echo '<li>' . $warning['warning_note'] . '</li>';
			}
			?>
            </ul>
            <form name="accept" method="POST" action="warning.php?action=accept">
            <p class="submit">
            <input type="submit" name="Submit" value="<?php _e('Accept') ?>" /> 
            </p> 
            </form>
            <?php
		break;
		//---------------------------------------------------//
		case "accept":
			$wpdb->query( "UPDATE " . $wpdb->base_prefix . "moderation_warnings SET warning_read = '1' WHERE warning_user_ID = '" . $user_ID . "'" );

			echo "
			<SCRIPT LANGUAGE='JavaScript'>
			window.location='index.php';
			</script>
			";
		break;
		//---------------------------------------------------//
	}
	echo '</div>';
}

//------------------------------------------------------------------------//
//---Support Functions----------------------------------------------------//
//------------------------------------------------------------------------//

function moderation_roundup($value, $dp){
    return ceil($value*pow(10, $dp))/pow(10, $dp);
}

?>