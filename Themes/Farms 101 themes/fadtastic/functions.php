<?php

$themecolors = array(
	'bg' => 'ffffff',
	'text' => '000000',
	'link' => '80ae14'
	);

function widget_fadtastic_links() {
	if ( function_exists('wp_list_bookmarks') ) {
		wp_list_bookmarks(array('title_before'=>'<h3>', 'title_after'=>'</h3>', 'show_images'=>true));
	}
}

function fadtastic_widget_init() {
	register_sidebar(array('before_title' => "<h3 class='widgettitle'>", 'after_title' => "</h3>", 'name' => 'Main Sidebar', 'id' => 'main-sidebar'));
	register_sidebar(array('before_title' => "<h3 class='widgettitle'>", 'after_title' => "</h3>", 'name' => 'Bottom Bar', 'id' => 'bottom-bar'));
	register_sidebar_widget(__('Links', 'sandbox'), 'widget_fadtastic_links', null, 'links');
	unregister_widget_control('links');
}
add_action('widgets_init', 'fadtastic_widget_init');

?>
