<?php
/*
Plugin Name: Supporter (Feature: Plugins)
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
add_action('admin_menu', 'supporter_plugins_modify_menu_items',99);
add_action('admin_footer', 'supporter_plugins_disable_plugins');
//------------------------------------------------------------------------//
//---Functions------------------------------------------------------------//
//------------------------------------------------------------------------//

function supporter_plugins_disable_plugins() {
	if ( !is_supporter() ) {
		$active_plugins = get_option('active_plugins');
		if ( !empty( $active_plugins ) ) {
			deactivate_plugins( $active_plugins );
		}
	}
}

function supporter_plugins_modify_menu_items() {
	global $submenu, $menu;
	if ( $wpdb->blogid != 1 && !is_site_admin() ) {
	//if ( $wpdb->blogid != 1 ) {
		if ( !is_supporter() ) {
			unset( $menu[45] );
			unset( $submenu['plugins.php'][5] );
			unset( $submenu['plugins.php'][10] );
			unset( $submenu['plugins.php'][15] );
		}
	}
}

//------------------------------------------------------------------------//
//---Output Functions-----------------------------------------------------//
//------------------------------------------------------------------------//

//------------------------------------------------------------------------//
//---Page Output Functions------------------------------------------------//
//------------------------------------------------------------------------//

?>