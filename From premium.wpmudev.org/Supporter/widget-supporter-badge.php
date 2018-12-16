<?php
/*
Plugin Name: Supporter (Feature: Badge)
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
$supporter_badge_image_path = '/wp-content/supporter_badge.gif';
//------------------------------------------------------------------------//
//---Hook-----------------------------------------------------------------//
//------------------------------------------------------------------------//
add_action('widgets_init', 'widget_supporter_badge_init');
//------------------------------------------------------------------------//
//---Functions------------------------------------------------------------//
//------------------------------------------------------------------------//
function widget_supporter_badge_init() {
	global $supporter_badge_image_path;
	
	// Check for the required API functions
	if ( !function_exists('register_sidebar_widget') || !function_exists('register_widget_control') )
		return;

	// This prints the widget
	function widget_supporter_badge($args) {
		global $supporter_badge_image_path;
		extract($args);
		$defaults = array('count' => 10, 'username' => 'wordpress');
		$options = (array) get_option('widget_supporter_badge');

		foreach ( $defaults as $key => $value )
			if ( !isset($options[$key]) )
				$options[$key] = $defaults[$key];


		?>
		<?php echo $before_widget; ?>
			<?php echo $before_title . "" . $after_title; ?>
			<center>
			<img src="<?php echo get_option('siteurl') . $supporter_badge_image_path; ?>"/>
			</center>
		<?php echo $after_widget; ?>
<?php
	}

	// Tell Dynamic Sidebar about our new widget and its control
	if ( is_supporter() ) {
	register_sidebar_widget(array('Supporter Badge', 'widgets'), 'widget_supporter_badge');
	}
	
}
?>