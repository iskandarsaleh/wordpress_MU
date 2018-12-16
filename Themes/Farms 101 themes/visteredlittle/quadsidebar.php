<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("160x600-vistered-little"); } ?>
<?php

//$widget_args = array(
//	        'before_widget' => '<div class="menu">',
//	        'after_widget' => '</div>',
//	        'before_title' => '<h4>',
//	        'after_title' => '</h4>'
//	    );
		
$split_widget_args = array(
	        'before_widget' => '<div class="menubefore"></div><div class="menu">',
	        'after_widget' => '</div><div class="menuafter"></div>',
	        'before_title' => '<h4>',
	        'after_title' => '</h4>'
	    );

?><div class="topmenugroup"><?php
	if ( !function_exists('dynamic_sidebar')
		|| !dynamic_sidebar( __('Quadbar - Top', VL_DOMAIN) ) ) {
		widget_post_info( $split_widget_args );

		if( sidebarThumbs() ) {
			widget_wallpaper_selector( $split_widget_args );
		}
	}
?></div><?php // end topmenugroup

?><div class="middlemenugroup-before"></div><?php
?><div class="middlemenugroup"><?php
	?><div class="leftmenugroup" style="float: left;"><?php
		if ( !function_exists('dynamic_sidebar')
			|| !dynamic_sidebar( __('Quadbar - Left', VL_DOMAIN) ) ) {
			?><div class="menubefore"></div><div class="menu"><?php
				get_calendar();
			?></div><div class="menuafter"></div><?php

			$links = wp_get_links( 'echo=0' );
			if( !empty( $links ) ) {
				?><div class="menubefore"></div><div class="menu"><?php
					?><ul id="links"><?php
						get_links_list('id'); 
					?></ul><?php
				?></div><div class="menuafter"></div><?php // end menu
			}
		}
	?></div><?php // end leftmenugroup

	?><div class="rightmenugroup" style="float: right;"><?php
		if ( !function_exists('dynamic_sidebar')
			|| !dynamic_sidebar( __('Quadbar - Right', VL_DOMAIN) ) ) {
			?><div class="menubefore"></div><div class="menu"><?php
			?><h3><?php _e( 'Pages', VL_DOMAIN ); ?></h3><ul><?php
				wp_list_pages('title_li=');
			?></ul><?php
			?></div><div class="menuafter"></div><?php

			?><div class="menubefore"></div><div class="menu"><?php
			?><h3><?php _e( 'Categories', VL_DOMAIN ); ?></h3><ul><?php
				wp_list_categories("show_count=1&hierarchical=0&title_li=");
			?></ul><?php
			?></div><div class="menuafter"></div><?php
		}
	?></div><?php // end rightmenugroup
	?><div style="clear: both;"></div><?php
?></div><?php // end middlemenugroup
?><div class="middlemenugroup-after"></div><?php


?><div class="bottommenugroup"><?php
	if ( !function_exists('dynamic_sidebar')
		|| !dynamic_sidebar( __('Quadbar - Bottom', VL_DOMAIN) ) ) {
		vl_widget_meta($split_widget_args);
	}
?></div><?php // en bottommenugroup
