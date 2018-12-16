<?php

if ( function_exists('register_sidebar') )
	register_sidebar(array(
		'before_widget' => '<li class="sidebox">', 
		'after_widget' => '</li>',
		'before_title' => '<h2>',
		'after_title' => '</h2>', 
	));

if ( function_exists('unregister_sidebar_widget') )
	unregister_sidebar_widget( __('Links') );	
if ( function_exists('register_sidebar_widget') )
	register_sidebar_widget(__('Links'), 'mistylook_ShowLinks');

function mistylook_ShowLinks($args) {
	global $wp_db_version;
	extract($args);
	if ( $wp_db_version < 3582 ) {
		// This ONLY works with li/h2 sidebars.
		get_links_list();
	} else {
		wp_list_bookmarks(array(
			'title_before' => $before_title,
			'title_after' => $after_title,
			'category_before' => $before_widget,
			'category_after' => $after_widget,
			'show_images' => true,
			'class' => 'linkcat widget'
		));
	}
}

define('HEADER_TEXTCOLOR', '');
define('HEADER_IMAGE', '%s/img/misty.jpg'); // %s is theme dir uri
define('HEADER_IMAGE_WIDTH', 760);
define('HEADER_IMAGE_HEIGHT', 190);
define( 'NO_HEADER_TEXT', true );

function mistylook_admin_header_style() {
?>
<style type="text/css">
#headimg {
	background: url(<?php header_image() ?>) no-repeat;
}
#headimg {
	height: <?php echo HEADER_IMAGE_HEIGHT; ?>px;
	width: <?php echo HEADER_IMAGE_WIDTH; ?>px;
}

#headimg h1, #headimg #desc {
	display: none;
}
</style>
<?php
}
function mistylook_header_style() {
?>
<style type="text/css">
#headerimage {
	background: url(<?php header_image() ?>) no-repeat;
}
</style>
<?php
}
if ( function_exists('add_custom_image_header') ) {
	add_custom_image_header('mistylook_header_style', 'mistylook_admin_header_style');
}
?>
