<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("160x600-vistered-little"); } ?>

<?php

$widget_args = array(
	        'before_widget' => '<div class="menubefore"></div><div class="menu">',
	        'after_widget' => '</div><div class="menuafter"></div>',
	        'before_title' => '<h4>',
	        'after_title' => '</h4>'
	    );
		
if ( !function_exists('dynamic_sidebar')
	|| !dynamic_sidebar( __('Sidebar', VL_DOMAIN) ) ) {
	widget_post_info( $widget_args );

	if( sidebarThumbs() ) {
		widget_wallpaper_selector( $widget_args );
	}
	extract($widget_args);

	echo $before_widget;
	get_calendar();
	echo $before_title;
	_e('Pages', VL_DOMAIN); 
	echo $after_title;
	?><ul><?php
		wp_list_pages('title_li=');
	?></ul><?php
	echo $before_title;
	_e( 'Categories', VL_DOMAIN ); 
	echo $after_title;
	?><ul><?php
		if( function_exists('wp_list_categories') ) {
			wp_list_categories("show_count=1&hierarchical=0&title_li=");
		}
		else {
			wp_list_cats("show_count=1&hierarchical=0&title_li=");
		}
	?></ul><?php
	echo $after_widget;

	$links = wp_get_links( 'echo=0' );
	if( !empty( $links ) ) {
		echo $before_widget;
		?><ul id="links"><?php
			vl_get_links_list(); 
		?></ul><?php
		echo $after_widget;
	}

	vl_widget_meta($widget_args);
}