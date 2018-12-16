<?php
/*
Plugin Name: Supporter (Feature: Ads)
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

$supporter_ads_current_version = '1.6.1';
$supporter_ads_enable_additional_ad_free_blogs = '1';
//------------------------------------------------------------------------//
//---Config---------------------------------------------------------------//
//------------------------------------------------------------------------//

//------------------------------------------------------------------------//
//---Hook-----------------------------------------------------------------//
//------------------------------------------------------------------------//
if ( $supporter_ads_enable_additional_ad_free_blogs == '1' ) {
	add_action('supporter_plug_pages', 'supporter_ads_plug_pages');
	add_action('supporter_settings', 'supporter_ads_setting');
	add_action('supporter_settings_process', 'supporter_ads_setting_process');
	//add_action('supporter_active', 'supporter_ads_active');
	//add_action('supporter_inactive', 'supporter_ads_inactive');
	add_action('supporter_extend', 'supporter_ads_extend', 2, 2);
	add_action('supporter_withdraw', 'supporter_ads_withdraw', 2, 2);
}

if ($_GET['page'] == 'supporter' && $supporter_ads_enable_additional_ad_free_blogs == '1') {
	supporter_ads_make_current();
}


//------------------------------------------------------------------------//
//---Functions------------------------------------------------------------//
//------------------------------------------------------------------------//

function supporter_ads_make_current() {
	global $wpdb, $supporter_ads_current_version;
	if (get_site_option( "supporter_ads_version" ) == '') {
		add_site_option( 'supporter_ads_version', '0.0.0' );
	}
	
	if (get_site_option( "supporter_ads_version" ) == $supporter_ads_current_version) {
		// do nothing
	} else {
		//update to current version
		update_site_option( "supporter_ads_installed", "no" );
		update_site_option( "supporter_ads_version", $supporter_ads_current_version );
	}
	supporter_ads_global_install();
	//--------------------------------------------------//
	if (get_option( "supporter_ads_version" ) == '') {
		add_option( 'supporter_ads_version', '0.0.0' );
	}
	
	if (get_option( "supporter_ads_version" ) == $supporter_ads_current_version) {
		// do nothing
	} else {
		//update to current version
		update_option( "supporter_ads_version", $supporter_ads_current_version );
		supporter_ads_blog_install();
	}
}

function supporter_ads_blog_install() {
	global $wpdb, $supporter_ads_current_version;
	$supporter_ads_hits_table = "";

	//$wpdb->query( $supporter_hits_table );
}

function supporter_ads_global_install() {
	global $wpdb, $supporter_ads_current_version;
	if (get_site_option( "supporter_ads_installed" ) == '') {
		add_site_option( 'supporter_ads_installed', 'no' );
	}
	
	if (get_site_option( "supporter_ads_installed" ) == "yes") {
		// do nothing
	} else {
	
		$supporter_ads_table1 = "CREATE TABLE `" . $wpdb->base_prefix . "supporter_ads` (
  `supporter_ads_ID` bigint(20) unsigned NOT NULL auto_increment,
  `supporter_blog_ID` bigint(20) NOT NULL default '0',
  `blog_ID` bigint(20) NOT NULL default '0',
  `expire` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`supporter_ads_ID`)
) ENGINE=InnoDB;";
		$supporter_ads_table2 = "";
		$supporter_ads_table3 = "";
		$supporter_ads_table4 = "";
		$supporter_ads_table5 = "";

		$wpdb->query( $supporter_ads_table1 );
		//$wpdb->query( $supporter_ads_table2 );
		//wpdb->query( $supporter_ads_table3 );
		//$wpdb->query( $supporter_ads_table4 );
		//$wpdb->query( $supporter_ads_table5 );

		update_site_option( "supporter_ads_installed", "yes" );
	}
}

function supporter_ads_plug_pages() {
	global $wpdb, $wp_roles, $current_user;
	if ( $wpdb->blogid != 1 ) {
		add_submenu_page('supporter.php', __('Disable Ads'), __('Disable Ads'), 10, 'ads', 'supporter_ads');
	}
}

function supporter_ads_extend($blog_ID, $new_expire){
	global $wpdb;
	$wpdb->query("UPDATE " . $wpdb->base_prefix . "supporter_ads SET expire = '" . $new_expire . "' WHERE supporter_blog_ID = '" . $blog_ID . "'");
}

function supporter_ads_withdraw($blog_ID, $new_expire){
	global $wpdb;
	$wpdb->query("UPDATE " . $wpdb->base_prefix . "supporter_ads SET expire = '" . $new_expire . "' WHERE supporter_blog_ID = '" . $blog_ID . "'");
}

function supporter_ads_check($blog_ID = ''){
	global $wpdb;

	if ( empty( $blog_ID ) ) {
		$blog_ID = $wpdb->blogid;
	}

	$count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "supporter_ads WHERE blog_ID = '" . $blog_ID . "' AND expire > '" . time() . "'");

	if ( $count > 0 ) {
		return true;
	} else {
		return false;
	}
	
}

function supporter_show_ads($blog_ID = ''){
	global $wpdb;

	if ( empty( $blog_ID ) ) {
		$blog_ID = $wpdb->blogid;
	}
	if ( $blog_ID == 1 ) {
		return false;
	} else {
		if ( is_supporter($blog_ID) || supporter_ads_check($blog_ID) ) {
			return false;
		} else {
			return true;
		}
	}
}

function supporter_hide_ads($blog_ID = ''){
	global $wpdb;

	if ( empty( $blog_ID ) ) {
		$blog_ID = $wpdb->blogid;
	}
	if ( $blog_ID == 1 ) {
		return true;
	} else {
		if ( is_supporter($blog_ID) || supporter_ads_check($blog_ID) ) {
			return true;
		} else {
			return false;
		}
	}
}

function supporter_ads_setting_process() {
	update_site_option( "supporter_ad_free_blogs", $_POST[ 'supporter_ad_free_blogs' ] );
	update_site_option( "supporter_ads_message", addslashes( $_POST[ 'supporter_ads_message' ] ) );
}

//------------------------------------------------------------------------//
//---Output Functions-----------------------------------------------------//
//------------------------------------------------------------------------//

function supporter_ads_setting() {
	?>
                <tr valign="top"> 
                <th scope="row"><?php _e('Additional Ad-Free Blogs') ?></th> 
                <td><select name="supporter_ad_free_blogs">
				<?php
					$supporter_ad_free_blogs = get_site_option( "supporter_ad_free_blogs" );
					$counter = 0;
					for ( $counter = 1; $counter <=  100; $counter += 1) {
                        echo '<option value="' . $counter . '"' . ($counter == $supporter_ad_free_blogs ? ' selected' : '') . '>' . $counter . '</option>' . "\n";
					}
                ?>
                </select>
                <br /><?php _e('Number of blogs that can have ads disabled in addition to the supporter blog.'); ?></td> 
                </tr>
                <tr valign="top">
                <th scope="row"><?php _e('Ads Message') ?></th>
                <td>
                <textarea name="supporter_ads_message" type="text" rows="10" wrap="soft" id="supporter_ads_message" style="width: 95%"/><?php echo stripslashes( get_site_option('supporter_ads_message') ) ?></textarea>
                <br /><?php _e('Optional - HTML allowed - This message is displayed at the top of the "Disable Ads" page.') ?>
                <br /><?php echo '"AD_FREE_BLOGS"' . ' ' . _('Will be replaced by the number of ad free blogs chosen above') ?></td>
                </tr>
    <?php
}

//------------------------------------------------------------------------//
//---Page Output Functions------------------------------------------------//
//------------------------------------------------------------------------//

function supporter_ads() {
	global $wpdb, $wp_roles, $current_user;
	if ( is_supporter() ) {
		$is_supporter = '1';
	} else {
		$is_supporter = '0';
	}
	
	if(!current_user_can('edit_users')) {
		echo "<p>" . __('Nice Try...') . "</p>";  //If accessed properly, this message doesn't appear.
		return;
	}
	if (isset($_GET['updated'])) {
		?><div id="message" class="updated fade"><p><?php _e('' . urldecode($_GET['updatedmsg']) . '') ?></p></div><?php
	}
	if ( $is_supporter != '1' ) {
		supporter_feature_notice();	
	}
	echo '<div class="wrap">';
	switch( $_GET[ 'action' ] ) {
		//---------------------------------------------------//
		default:
			$supporter_ad_free_blogs = get_site_option('supporter_ad_free_blogs');
			?>
            <h2><?php _e('Disable Ads') ?></h2>
            <?php
			$supporter_ads_message = stripslashes( get_site_option('supporter_ads_message') );
			if ( !empty( $supporter_ads_message ) ) {
				$supporter_ads_message = str_replace("AD_FREE_BLOGS", $supporter_ad_free_blogs, $supporter_ads_message);
				echo '<p>';
				echo __($supporter_ads_message);
				echo '</p>';
			}
			$query = "SELECT * FROM " . $wpdb->base_prefix . "supporter_ads WHERE supporter_blog_ID = '" . $wpdb->blogid . "' ORDER BY supporter_ads_ID DESC";
			$blogs = $wpdb->get_results( $query, ARRAY_A );
			$supporter_ad_free_blogs_remaining = $supporter_ad_free_blogs - count( $blogs );
			?>
            <p><?php _e('Maximum blogs') ?>: <?php echo $supporter_ad_free_blogs; ?><br />
            <?php _e('Currently disabling ads on') ?>: <?php echo count( $blogs ); ?><br />
            <?php _e('Remaining') ?>: <?php echo $supporter_ad_free_blogs_remaining; ?></p>
            <?php
			if ( $supporter_ad_free_blogs_remaining > 0 && $is_supporter == '1' ) {
			?>
                    <h3><?php _e('Search Blogs') ?></h3>
                    <p><?php _e('Find blogs to disable ads on them.') ?></p>
                    <form method="post" action="supporter.php?page=ads&action=search">
                    <table class="form-table">
                        <tr valign="top"> 
                        <th scope="row"><?php _e('Search') ?></th> 
                        <td><input type="text" name="search" value="" />
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
			if ( count( $blogs ) > 0 && $is_supporter == '1' ){
				?>
                <h3><?php _e('Blogs') ?></h3>
                <?php
				echo "
				<table cellpadding='3' cellspacing='3' width='100%' class='widefat'> 
				<thead><tr>
				<th scope='col' width='45px'>" . __("Remove") . "</th>
				<th scope='col'>" . __("Blog") . "</th>
				</tr></thead>
				<tbody id='the-list'>
				<form method='post' action='supporter.php?page=ads&action=remove'>
				";
				$class = ('alternate' == $class) ? '' : 'alternate';
				foreach ($blogs as $blog) {
				$blog_details = get_blog_details( $blog['blog_ID'] );
				if ( $blog_details->path == '/' ) {
					$blog_details->path = '';
				}
				//=========================================================//
				echo "<tr class='" . $class . "'>";
				echo "<td valign='top'><center><input name='blogs[" . $blog['blog_ID'] . "]' value='1' type='checkbox'></center></td>";
				echo "<td valign='top'><strong>" . $blog_details->domain . $blog_details->path . "</strong></td>";
				echo "</tr>";
				$class = ('alternate' == $class) ? '' : 'alternate';
				//=========================================================//
				}
				?>
				</tbody></table>
                <p class="submit">
                <input type="submit" name="Submit" value="<?php _e('Remove') ?>" />
                </p>
                </form>
				<?php
			}
		break;
		//---------------------------------------------------//
		case "search":
			if ( isset( $_POST['Back'] ) ) {
				echo "
				<SCRIPT LANGUAGE='JavaScript'>
				window.location='supporter.php?page=ads';
				</script>
				";
			} else {
				if ( $is_supporter != '1' ) {
					die( __('Supporter only feature.') );	
				}
				$supporter_ad_free_blogs = get_site_option('supporter_ad_free_blogs');
				$supporter_ad_free_blogs_current = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "supporter_ads WHERE supporter_blog_ID = '" . $wpdb->blogid . "'");
				$supporter_ad_free_blogs_remaining = $supporter_ad_free_blogs - $supporter_ad_free_blogs_current;
				?>
				<h2><?php _e('Search') ?></h2>
				<p><?php _e('Maximum blogs') ?>: <?php echo $supporter_ad_free_blogs; ?><br />
				<?php _e('Currently disabling ads on') ?>: <?php echo $supporter_ad_free_blogs_current; ?><br />
				<?php _e('Remaining') ?>: <?php echo $supporter_ad_free_blogs_remaining; ?></p>
				<h3><?php _e('Search Blogs') ?></h3>
				<form method="post" action="supporter.php?page=ads&action=search">
				<table class="form-table">
					<tr valign="top"> 
					<th scope="row"><?php _e('Search') ?></th> 
					<td><input type="text" name="search" value="<?php echo $_POST['search']; ?>" />
					<br />
					<?php //_e('Format: 00.00 - Ex: 1.25') ?></td> 
					</tr>
				</table>
				
				<p class="submit">
				<input type="submit" name="Back" value="<?php _e('Back') ?>" />
				<input type="submit" name="Submit" value="<?php _e('Search') ?>" />
				</p>
				</form>
				<h3><?php _e('Results') ?></h3>
				<?php
				$query = "SELECT blog_id, domain, path FROM " . $wpdb->blogs . " WHERE ( domain LIKE '%" . $_POST['search'] . "%' OR path LIKE '%" . $_POST['search'] . "%' ) AND blog_id != '" . $wpdb->blogid . "' LIMIT 150";
				$blogs = $wpdb->get_results( $query, ARRAY_A );
				if ( count( $blogs ) > 0 ) {
					if ( count( $blogs ) == 150 ) {
						?>
	                    <h3><?php _e('Over 150 blogs were found matching the provided search criteria. If you do not find the blog you are looking for in the selection below please try refining your search criteria.') ?></h3>
	                    <?php
					}
					echo "
					<table cellpadding='3' cellspacing='3' width='100%' class='widefat'> 
					<thead><tr>
					<th scope='col' width='75px'>" . __("Disable Ads") . "</th>
					<th scope='col'>" . __("Blog") . "</th>
					</tr></thead>
					<tbody id='the-list'>
					<form method='post' action='supporter.php?page=ads&action=process'>
					";
					$class = ('alternate' == $class) ? '' : 'alternate';
					foreach ($blogs as $blog) {
					if ( $blog['path'] == '/' ) {
						$blog['path'] = '';
					}
					//=========================================================//
					echo "<tr class='" . $class . "'>";
					$existing_check = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "supporter_ads WHERE supporter_blog_ID = '" . $wpdb->blogid . "' AND blog_ID = '" . $blog['blog_id'] . "'");
					if ( $existing_check > 0 ) {
						echo "<td valign='top'><center><input name='blogs[" . $blog['blog_id'] . "]' value='1' type='checkbox' disabled='disabled'></center></td>";
					} else {
						echo "<td valign='top'><center><input name='blogs[" . $blog['blog_id'] . "]' value='1' type='checkbox'></center></td>";
					}
					if ( $existing_check > 0 ) {
						echo "<td valign='top' style='color:#666666;'><strong>" . $blog['domain'] . $blog['path'] . " (" . __("Ads already disabled") . ")</strong></td>";
					} else {
						echo "<td valign='top'><strong>" . $blog['domain'] . $blog['path'] . "</strong></td>";
					}
					echo "</tr>";
					$class = ('alternate' == $class) ? '' : 'alternate';
					//=========================================================//
					}
					?>
                    </tbody></table>
                    <p class="submit">
                    <input type="submit" name="Back" value="<?php _e('Back') ?>" />
                    <input type="submit" name="Submit" value="<?php _e('Disable Ads') ?>" />
                    </p>
                    </form>
                    <?php
				} else {
					?>
                    <p><?php _e('No blogs found matching search criteria.') ?></p>
                    <?php
				}
			}
		break;
		//---------------------------------------------------//
		case "process":
			if ( isset( $_POST['Back'] ) ) {
				echo "
				<SCRIPT LANGUAGE='JavaScript'>
				window.location='supporter.php?page=ads';
				</script>
				";
			} else {
				if ( $is_supporter != '1' ) {
					die( __('Supporter only feature.') );	
				}
				$supporter_ad_free_blogs = get_site_option('supporter_ad_free_blogs');
				$supporter_ad_free_blogs_current = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "supporter_ads WHERE supporter_blog_ID = '" . $wpdb->blogid . "'");
				$supporter_ad_free_blogs_remaining = $supporter_ad_free_blogs - $supporter_ad_free_blogs_current;
				$expire = supporter_get_expire();
				$blogs = $_POST['blogs'];
				foreach ( $blogs as $blog_ID => $value) {
					if ( $supporter_ad_free_blogs_remaining > 0 && $value == '1' ) {
						$existing_check = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "supporter_ads WHERE supporter_blog_ID = '" . $wpdb->blogid . "' AND blog_ID = '" . $blog_ID . "'");
						if ( $existing_check < 1 ) {
							$supporter_ad_free_blogs_remaining = $supporter_ad_free_blogs_remaining - 1;
							$wpdb->query( "INSERT INTO " . $wpdb->base_prefix . "supporter_ads (blog_ID, supporter_blog_ID) VALUES ( '" . $blog_ID . "', '" . $wpdb->blogid . "' )" );
						}
					}
				}
				$wpdb->query("UPDATE " . $wpdb->base_prefix . "supporter_ads SET expire = '" . $expire . "' WHERE supporter_blog_ID = '" . $wpdb->blogid . "'");
				echo "
				<SCRIPT LANGUAGE='JavaScript'>
				window.location='supporter.php?page=ads&updated=true&updatedmsg=" . urlencode(__('Ads disabled.')) . "';
				</script>
				";
			}
		break;
		//---------------------------------------------------//
		case "remove":
				$blogs = $_POST['blogs'];
				foreach ( $blogs as $blog_ID => $value) {
					if ( $value == '1' ) {
						$wpdb->query( "DELETE FROM " . $wpdb->base_prefix . "supporter_ads WHERE blog_ID = '" . $blog_ID . "' AND supporter_blog_ID = '" . $wpdb->blogid . "'" );
					}
				}
				echo "
				<SCRIPT LANGUAGE='JavaScript'>
				window.location='supporter.php?page=ads&updated=true&updatedmsg=" . urlencode(__('Blogs removed')) . "';
				</script>
				";
		break;
		//---------------------------------------------------//
		case "temp":
		break;
		//---------------------------------------------------//
	}
	echo '</div>';
}
?>