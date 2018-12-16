<?php
/*
Plugin Name: Supporter (Feature: Widget)
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
$supporters_widget_main_blog_only = 'yes'; //Either 'yes' or 'no'
//------------------------------------------------------------------------//
//---Hook-----------------------------------------------------------------//
//------------------------------------------------------------------------//

//------------------------------------------------------------------------//
//---Functions------------------------------------------------------------//
//------------------------------------------------------------------------//
function widget_supporters_init() {
	global $wpdb, $supporters_widget_main_blog_only;
		
	// Check for the required API functions
	if ( !function_exists('register_sidebar_widget') || !function_exists('register_widget_control') )
		return;

	// This saves options and prints the widget's config form.
	function widget_supporters_control() {
		global $wpdb;
		$options = $newoptions = get_option('widget_supporters');
		if ( $_POST['supporters-submit'] ) {
			$newoptions['supporters-title'] = $_POST['supporters-title'];
			$newoptions['supporters-display'] = $_POST['supporters-display'];
			$newoptions['supporters-blog-name-characters'] = $_POST['supporters-blog-name-characters'];
			$newoptions['supporters-order'] = $_POST['supporters-order'];
			$newoptions['supporters-number'] = $_POST['supporters-number'];
			$newoptions['supporters-avatar-size'] = $_POST['supporters-avatar-size'];
		}
		if ( $options != $newoptions ) {
			$options = $newoptions;
			update_option('widget_supporters', $options);
		}
	?>
				<div style="text-align:left">
                
				<label for="supporters-title" style="line-height:35px;display:block;"><?php _e('Title', 'widgets'); ?>:<br />
                <input class="widefat" id="supporters-title" name="supporters-title" value="<?php echo $options['supporters-title']; ?>" type="text" style="width:95%;">
                </select>
                </label>
				<label for="supporters-display" style="line-height:35px;display:block;"><?php _e('Display', 'widgets'); ?>:
                <select name="supporters-display" id="supporters-display" style="width:95%;">
                <option value="avatar_blog_name" <?php if ($options['supporters-display'] == 'avatar_blog_name'){ echo 'selected="selected"'; } ?> ><?php _e('Avatar + Blog Name'); ?></option>
                <option value="avatar" <?php if ($options['supporters-display'] == 'avatar'){ echo 'selected="selected"'; } ?> ><?php _e('Avatar Only'); ?></option>
                <option value="blog_name" <?php if ($options['supporters-display'] == 'blog_name'){ echo 'selected="selected"'; } ?> ><?php _e('Blog Name Only'); ?></option>
                </select>
                </label>
				<label for="supporters-blog-name-characters" style="line-height:35px;display:block;"><?php _e('Blog Name Characters', 'widgets'); ?>:<br />
                <select name="supporters-blog-name-characters" id="supporters-blog-name-characters" style="width:95%;">
                <?php
					if ( empty($options['supporters-blog-name-characters']) ) {
						$options['supporters-blog-name-characters'] = 30;
					}
					$counter = 0;
					for ( $counter = 1; $counter <= 500; $counter += 1) {
						?>
                        <option value="<?php echo $counter; ?>" <?php if ($options['supporters-blog-name-characters'] == $counter){ echo 'selected="selected"'; } ?> ><?php echo $counter; ?></option>
                        <?php
					}
                ?>
                </select>
                </label>
				<label for="supporters-order" style="line-height:35px;display:block;"><?php _e('Order', 'widgets'); ?>:
                <select name="supporters-order" id="supporters-order" style="width:95%;">
                <option value="most_recent" <?php if ($options['supporters-order'] == 'most_recent'){ echo 'selected="selected"'; } ?> ><?php _e('Most Recent'); ?></option>
                <option value="random" <?php if ($options['supporters-order'] == 'random'){ echo 'selected="selected"'; } ?> ><?php _e('Random'); ?></option>
                </select>
                </label>
				<label for="supporters-number" style="line-height:35px;display:block;"><?php _e('Number', 'widgets'); ?>:<br />
                <select name="supporters-number" id="supporters-number" style="width:95%;">
                <?php
					if ( empty($options['supporters-number']) ) {
						$options['supporters-number'] = 10;
					}
					$counter = 0;
					for ( $counter = 1; $counter <= 25; $counter += 1) {
						?>
                        <option value="<?php echo $counter; ?>" <?php if ($options['supporters-number'] == $counter){ echo 'selected="selected"'; } ?> ><?php echo $counter; ?></option>
                        <?php
					}
                ?>
                </select>
                </label>
				<label for="supporters-avatar-size" style="line-height:35px;display:block;"><?php _e('Avatar Size', 'widgets'); ?>:<br />
                <select name="supporters-avatar-size" id="supporters-avatar-size" style="width:95%;">
                <option value="16" <?php if ($options['supporters-avatar-size'] == '16'){ echo 'selected="selected"'; } ?> ><?php _e('16px'); ?></option>
                <option value="32" <?php if ($options['supporters-avatar-size'] == '32'){ echo 'selected="selected"'; } ?> ><?php _e('32px'); ?></option>
                <option value="48" <?php if ($options['supporters-avatar-size'] == '48'){ echo 'selected="selected"'; } ?> ><?php _e('48px'); ?></option>
                <option value="96" <?php if ($options['supporters-avatar-size'] == '96'){ echo 'selected="selected"'; } ?> ><?php _e('96px'); ?></option>
                <option value="128" <?php if ($options['supporters-avatar-size'] == '128'){ echo 'selected="selected"'; } ?> ><?php _e('128px'); ?></option>
                </select>
                </label>
				<input type="hidden" name="supporters-submit" id="supporters-submit" value="1" />
				</div>
	<?php
	}
// This prints the widget
	function widget_supporters($args) {
		global $wpdb, $current_site;
		extract($args);
		$defaults = array('count' => 10, 'supportername' => 'wordpress');
		$options = (array) get_option('widget_supporters');

		foreach ( $defaults as $key => $value )
			if ( !isset($options[$key]) )
				$options[$key] = $defaults[$key];

		?>
		<?php echo $before_widget; ?>
			<?php echo $before_title . __($options['supporters-title']) . $after_title; ?>
            <br />
            <?php

			$newoptions['supporters-display'] = $_POST['supporters-display'];
			$newoptions['supporters-order'] = $_POST['supporters-order'];
			$newoptions['supporters-number'] = $_POST['supporters-number'];
			$newoptions['supporters-avatar-size'] = $_POST['supporters-avatar-size'];
				//=================================================//
				$now = time();
				if ( $options['supporters-order'] == 'most_recent' ) {
					$query = "SELECT supporter_ID, blog_ID, expire FROM " . $wpdb->base_prefix . "supporters WHERE expire > '" . $now . "' ORDER BY supporter_ID DESC LIMIT " . $options['supporters-number'];
				} else if ( $options['supporters-order'] == 'random' ) {
					$query = "SELECT supporter_ID, blog_ID, expire FROM " . $wpdb->base_prefix . "supporters WHERE expire > '" . $now . "' ORDER BY RAND() LIMIT " . $options['supporters-number'];
				}
				$supporters = $wpdb->get_results( $query, ARRAY_A );
				if (count($supporters) > 0){
					if ( $options['supporters-display'] == 'blog_name' || $options['supporters-display'] == 'avatar_blog_name' ) {
						echo '<ul>';
					}
					foreach ($supporters as $supporter){
						$blog_details = get_blog_details( $supporter['blog_ID'] );
						if ( $options['supporters-display'] == 'avatar_blog_name' ) {
							echo '<li>';
							echo '<a href="' . $blog_details->siteurl . '">' . get_blog_avatar( $supporter['blog_ID'], $options['supporters-avatar-size'], '' ) . '</a>';
							echo ' ';
							echo '<a href="' . $blog_details->siteurl . '">' . substr($blog_details->blogname, 0, $options['supporters-blog-name-characters']) . '</a>';
							echo '</li>';
						} else if ( $options['supporters-display'] == 'avatar' ) {
							echo '<a href="' . $blog_details->siteurl . '">' . get_avatar( $supporter['blog_ID'], $options['supporters-avatar-size'], '' ) . '</a>';
						} else if ( $options['supporters-display'] == 'blog_name' ) {
							echo '<li>';
							echo '<a href="' . $blog_details->siteurl . '">' . substr($blog_details->blogname, 0, $options['supporters-blog-name-characters']) . '</a>';
							echo '</li>';
						}
					}
					if ( $options['supporters-display'] == 'blog_name' || $options['supporters-display'] == 'avatar_blog_name' ) {
						echo '</ul>';
					}
				}
				//=================================================//
			?>
		<?php echo $after_widget; ?>
<?php
	}
	// Tell Dynamic Sidebar about our new widget and its control
	if ( $supporters_widget_main_blog_only == 'yes' ) {
		if ( $wpdb->blogid == 1 ) {
			register_sidebar_widget(array(__('supporters'), 'widgets'), 'widget_supporters');
			register_widget_control(array(__('supporters'), 'widgets'), 'widget_supporters_control');
		}
	} else {
		register_sidebar_widget(array(__('supporters'), 'widgets'), 'widget_supporters');
		register_widget_control(array(__('supporters'), 'widgets'), 'widget_supporters_control');
	}
}

add_action('widgets_init', 'widget_supporters_init');

?>