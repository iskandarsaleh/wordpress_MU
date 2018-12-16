<?php
/*
Plugin Name: Upgrades (Hook)
Plugin URI: 
Description:
Author: Andrew Billits (Incsub)
Version: 1.4.2
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
//---Functions------------------------------------------------------------//
//------------------------------------------------------------------------//

function upgrades_register_feature($tmp_hash, $tmp_name, $tmp_description){
	global $wpdb, $wp_roles, $current_user;
	$tmp_feature_check = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "upgrades_features WHERE feature_hash = '" . $tmp_hash . "'");
	if ($tmp_feature_check > 1){
		//duplicate feature
		$tmp_feature_check = $tmp_feature_check - 1;
		$wpdb->query( "DELETE FROM " . $wpdb->base_prefix . "upgrades_features WHERE feature_hash = '" . $tmp_hash . "' LIMIT " . $tmp_feature_check . "" );
	} else {
		if ($tmp_feature_check == 0){
			//This must be a new feature
			$wpdb->query( "INSERT INTO " . $wpdb->base_prefix . "upgrades_features (feature_hash, feature_name, feature_description, feature_last_active) VALUES ( '" . $tmp_hash . "', '" . $tmp_name . "', '" . $tmp_description . "', '" . time() . "' )" );
		} else {
			//This feature already exists, let's update it
			$wpdb->query( "UPDATE " . $wpdb->base_prefix . "upgrades_features SET feature_name = '" . $tmp_name . "' WHERE feature_ID = '" . $tmp_hash . "'" );
			$wpdb->query( "UPDATE " . $wpdb->base_prefix . "upgrades_features SET feature_description = '" . $tmp_description . "' WHERE feature_ID = '" . $tmp_hash . "'" );
			$wpdb->query( "UPDATE " . $wpdb->base_prefix . "upgrades_features SET feature_last_active = '" . time() . "' WHERE feature_ID = '" . $tmp_hash . "'" );
		}
	}
}

function upgrades_active_feature($tmp_hash){
	global $wpdb, $wp_roles, $current_user;
	$tmp_positive_count = 0;
	
	$tmp_active_count =  $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "upgrades_package_status WHERE package_expire > '" . time() . "' AND blog_ID = '" . $wpdb->blogid . "'");
	if ($tmp_active_count > 0) {
		$query = "SELECT package_ID FROM " . $wpdb->base_prefix . "upgrades_package_status WHERE package_expire > '" . time() . "' AND blog_ID = '" . $wpdb->blogid . "'";
		$upgrades_active_packages = $wpdb->get_results( $query, ARRAY_A );
		//-----------------------------------------//
		foreach ($upgrades_active_packages as $upgrades_active_package) {
			foreach ($upgrades_active_package as $upgrades_package_id) {
				$query = "SELECT package_plugin_one, package_plugin_two, package_plugin_three, package_plugin_four, package_plugin_five, package_plugin_six, package_plugin_seven, package_plugin_eight, package_plugin_nine, package_plugin_ten, package_plugin_eleven, package_plugin_twelve, package_plugin_thirteen, package_plugin_fourteen, package_plugin_fifteen FROM " . $wpdb->base_prefix . "upgrades_packages WHERE package_ID = '" . $upgrades_package_id . "'";
				$upgrades_package_features = $wpdb->get_results( $query, ARRAY_A );
				//-----------------------------------------//
				foreach ($upgrades_package_features as $upgrades_package_feature) {
					foreach ($upgrades_package_feature as $upgrades_feature_hash) {
						if ($upgrades_feature_hash == $tmp_hash){
							$tmp_positive_count = 1;
						}
					}
				}
				//-----------------------------------------//
			}
		}
		//-----------------------------------------//
	}
	if ($tmp_positive_count == 1){
		return 'active';
	} else {
		return 'inactive';
	}
}

function upgrades_package_check($tmp_pid){
	global $wpdb, $wp_roles, $current_user;
	
	$tmp_negative_count = 0;
	
	$tmp_package_check = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "upgrades_package_status WHERE package_ID = '" . $tmp_pid . "'");
	
	if ($tmp_package_check < 1){
		$tmp_negative_count = $tmp_negative_count + 1;
	}
	
	$tmp_package_stamp = $wpdb->get_var("SELECT package_expire FROM " . $wpdb->base_prefix . "upgrades_package_status WHERE package_ID = '" . $tmp_pid . "' AND blog_ID = '" . $wpdb->blogid . "'");

	if ($tmp_package_stamp < time()){
		//expired
		$tmp_negative_count = $tmp_negative_count + 1;
	}

	if ($tmp_negative_count == 0){
		return 'active';
	} else {
		return 'expired';
	}
}

function upgrades_blog_subscribed_check(){
	global $wpdb, $wp_roles, $current_user;

	$tmp_count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "upgrades_package_status WHERE package_expire > '" . time() . "' AND blog_ID = '" . $wpdb->blogid . "'");

	if ($tmp_count > 0){
		return '1';
	} else {
		return '0';
	}
}

if( defined( 'MUPLUGINDIR' ) == false ) 
	define( 'MUPLUGINDIR', 'wp-content/mu-plugins' );

if( defined( 'UPGRADEDIR' ) == false ) 
	define( 'UPGRADEDIR', '/upgrade-plugins' );

if( is_dir( ABSPATH . MUPLUGINDIR . UPGRADEDIR ) ) {
	if( $udh = opendir( ABSPATH . MUPLUGINDIR . UPGRADEDIR ) ) {
		while( ( $upgrade_plugin = readdir( $udh ) ) !== false ) {
			if( substr( $upgrade_plugin, -4 ) == '.php' ) {
				include_once( ABSPATH . MUPLUGINDIR . UPGRADEDIR . '/' . $upgrade_plugin );
			}
		}
	}
}

?>
