<?php
/*
Plugin Name: Custom Content Dashboard Widget
Plugin URI: 
Description:
Author: Andrew Billits
Version: 1.1.0
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
$custom_content_widegt_title = 'Custom Content';
function custom_content_widegt_content(){
?>
<!--- custom content goes here --->
<?php
}
//------------------------------------------------------------------------//
//---Hook-----------------------------------------------------------------//
//------------------------------------------------------------------------//
add_action( 'wp_dashboard_setup', 'custom_content_dashboard_widget' );
//------------------------------------------------------------------------//
//---Functions------------------------------------------------------------//
//------------------------------------------------------------------------//

function custom_content_dashboard_widget(){
	global $custom_content_widegt_title;
	wp_add_dashboard_widget( 'custom_content_dashboard_widget', __( $custom_content_widegt_title ), 'custom_content_widegt_content' );
}
//------------------------------------------------------------------------//
//---Output Functions-----------------------------------------------------//
//------------------------------------------------------------------------//

function wp_dashboard_custom_content( $sidebar_args ) {
	extract( $sidebar_args, EXTR_SKIP );

	echo $before_widget;

	echo $before_title;
	echo $widget_name;
	echo $after_title;
	custom_content_widegt_content();
	echo $after_widget;
}

//------------------------------------------------------------------------//
//---Page Output Functions------------------------------------------------//
//------------------------------------------------------------------------//

//------------------------------------------------------------------------//
//---Support Functions----------------------------------------------------//
//------------------------------------------------------------------------//

?>