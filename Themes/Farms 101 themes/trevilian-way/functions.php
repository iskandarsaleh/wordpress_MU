<?php
	// Special thanks to Johnny Spade (http://www.johnnyspade.com)  in the WP Support forums (http://wordpress.org/support/topic/111551?replies=11)
	// And Otto42 (http://ottodestruct.com/blog/) in the support forums also (http://wordpress.org/support/topic/86875#post-443392)
	
	if ( function_exists('register_sidebar') )
	{
		register_sidebar(array('name'=>'Index Top Right Only',
		'before_widget' => '<div id="%1$s" class="widget %2$s">', // Removes <li>
		'after_widget' => '</div>', // Removes </li>
		'before_title' => '<h3>', // Replaces <h2>
		'after_title' => '</h3>', // Replaces </h2>
		));
		register_sidebar(array('name'=>'Widget Block Wide',
		'before_widget' => '<div id="%1$s" class="widget %2$s">', // Removes <li>
		'after_widget' => '</div>', // Removes </li>
		'before_title' => '<h3>', // Replaces <h2>
		'after_title' => '</h3>', // Replaces </h2>
		));
		register_sidebar(array('name'=>'Widget Block 1',
		'before_widget' => '<div id="%1$s" class="widget %2$s">', // Removes <li>
		'after_widget' => '</div>', // Removes </li>
		'before_title' => '<h3>', // Replaces <h2>
		'after_title' => '</h3>', // Replaces </h2>
		));
		register_sidebar(array('name'=>'Widget Block 2',
		'before_widget' => '<div id="%1$s" class="widget %2$s">', // Removes <li>
		'after_widget' => '</div>', // Removes </li>
		'before_title' => '<h3>', // Replaces <h2>
		'after_title' => '</h3>', // Replaces </h2>
		));
		register_sidebar(array('name'=>'Widget Block 3',
		'before_widget' => '<div id="%1$s" class="widget %2$s">', // Removes <li>
		'after_widget' => '</div>', // Removes </li>
		'before_title' => '<h3>', // Replaces <h2>
		'after_title' => '</h3>', // Replaces </h2>
		));
		
		function unregister_problem_widgets()
		{
			unregister_sidebar_widget('Links');
			unregister_sidebar_widget('Search');
		}
		add_action('widgets_init','unregister_problem_widgets');
	}
?>