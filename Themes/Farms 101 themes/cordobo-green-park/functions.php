<?php

// Widget Settings

if ( function_exists('register_sidebar') )
	register_sidebar(array(
		'name' => 'Left Navigation',
		'before_widget' => '<li>', // Removes <li>
		'after_widget' => '</li>', // Removes </li>
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	));

if ( function_exists('register_sidebar') )
	register_sidebar(array(
		'name' => 'Right Sidebar',
		'before_widget' => '<li>', // Removes <li>
		'after_widget' => '</li>', // Removes </li>
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	));


// Search 	
	function widget_green_park_search() {
?>

		<?php include (TEMPLATEPATH . '/searchform.php'); ?>
	
<?php
}
if ( function_exists('register_sidebar_widget') )
    register_sidebar_widget(__('Search'), 'widget_green_park_search');

    
    


	
?>