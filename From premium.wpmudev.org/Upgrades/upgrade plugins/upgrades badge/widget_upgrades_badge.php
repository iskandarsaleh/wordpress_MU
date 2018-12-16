<?php
/*
Plugin Name: Upgrades Badge (Widget)
Description: 
Author: Andrew Billits (Incsub)
Version: 1.4.2
Author URI:
*/

function widget_upgrades_badge_init() {
	
	// Check for the required API functions
	if ( !function_exists('register_sidebar_widget') || !function_exists('register_widget_control') )
		return;

	// This prints the widget
	function widget_upgrades_badge($args) {
		extract($args);
		$defaults = array('count' => 10, 'username' => 'wordpress');
		$options = (array) get_option('widget_upgrades_badge');

		foreach ( $defaults as $key => $value )
			if ( !isset($options[$key]) )
				$options[$key] = $defaults[$key];


		?>
		<?php echo $before_widget; ?>
			<?php echo $before_title . "" . $after_title; ?>
			<center>
			<img src="<?php echo get_option('siteurl'); ?>/wp-content/upgrades_badge.png"/>
			</center>
		<?php echo $after_widget; ?>
<?php
	}

	// Tell Dynamic Sidebar about our new widget and its control
	register_sidebar_widget(array($upgrades_branding_plural . ' Badge', 'widgets'), 'widget_upgrades_badge');
	
}

if (upgrades_blog_subscribed_check() == '1') {
	add_action('widgets_init', 'widget_upgrades_badge_init');
}

?>