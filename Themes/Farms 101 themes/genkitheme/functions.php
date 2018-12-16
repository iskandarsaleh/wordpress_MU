<?php
if ( function_exists('register_sidebar') ) {
    register_sidebar( array('name' => 'sidebar_left', 'before_widget' => '', 'after_widget' => '', 'before_title' => '<h2>', 'after_title' => '</h2>') );
    register_sidebar( array('name' => 'sidebar_right', 'before_widget' => '', 'after_widget' => '', 'before_title' => '<h2>', 'after_title' => '</h2>') );
}

function wp_version() {
	global $wp_db_version;

	if ( $wp_db_version < 3582 ) {
		return '20';
	} else {
		return '21';
	}
}
?>