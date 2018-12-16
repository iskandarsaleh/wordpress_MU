<?php

function vl_get_comment_links( $type ) {
	$id = 0;
	$post = &get_post($id);
	$id = $post->ID;
	$tb_url = get_option('siteurl') . '/wp-trackback.php?p=' . $id;
	if ( '' != get_option('permalink_structure') )
		$tb_url = trailingslashit(get_permalink()) . 'trackback/';
	if ( comments_open() && pings_open() ) {
		_e('You can leave a', VL_DOMAIN);
		?> <a href="#respond"><?php _e( 'comment', VL_DOMAIN ); ?></a> <?php
		_e( 'on or', VL_DOMAIN );
		?> <a href="<?php echo $tb_url; ?>" title="<?php _e( 'Trackback to', VL_DOMAIN ); echo ' '; the_title(); ?>"><?php
		_e( 'trackback', VL_DOMAIN );
		?></a> <?php
		_e("to this", VL_DOMAIN );
		?> <?php
		echo $type;
	}
	else if( comments_open() ) {
		_e('You can leave a', VL_DOMAIN);
		?> <a href="#respond"><?php _e( 'comment', VL_DOMAIN ); ?></a> <?php
		_e('on this', VL_DOMAIN);
		echo ' ' . $type . '.';
	}
	else if( pings_open() ) {
		_e('You can leave a', VL_DOMAIN);
		?> <a href="<?php echo $tb_url; ?>xx" title="<?php _e( 'Trackback to', VL_DOMAIN ); echo ' '; the_title(); ?>"><?php
		_e( 'trackback', VL_DOMAIN );
		?></a> <?php
		_e('to this', VL_DOMAIN);
		echo ' ' . $type . '.';
	}
}

function widget_post_info( $args ) {
	extract($args);
	if( isset( $before_widget ) )
		echo $before_widget;
	
	if(is_home()) {
		if( isset( $before_title ) )
			echo $before_title;
		_e( 'Home', VL_DOMAIN );
		if( isset( $after_title ) )
			echo $after_title;
		echo '<p>';
		bloginfo('description');
		echo '</p>';
	}
	elseif(is_attachment()) {
		if( isset( $before_title ) )
			echo $before_title;
		_e( 'Attachment', VL_DOMAIN );
		if( isset( $after_title ) )
			echo $after_title;
		?><p><?php
			_e( 'You are viewing the attachment', VL_DOMAIN );
			?> <em><?php
				the_title();
			?></em>. <?php
			vl_get_comment_links(__('attachment', VL_DOMAIN));
		?></p><?php		
	}
	elseif(is_single()) {
		if( isset( $before_title ) )
			echo $before_title;
		_e( 'Post Information', VL_DOMAIN );
		if( isset( $after_title ) )
			echo $after_title;
		?><p><?php
			_e( 'You are reading', VL_DOMAIN );
			?> <em><?php
				the_title();
			?></em>. <?php
			vl_get_comment_links('post');
		?></p><?php
	}
	elseif(is_404()) { 
		if( isset( $before_title ) )
			echo $before_title;
		_e( 'Oops!', VL_DOMAIN );
		if( isset( $after_title ) )
			echo $after_title;
	}
	elseif(is_day()) { 
		if( isset( $before_title ) )
			echo $before_title;
		$post_date = the_date('','','',false);
		echo $post_date;
		if( isset( $after_title ) )
			echo $after_title;
		?><p><?php
		_e('You are looking at posts', VL_DOMAIN);
		echo ' ';
		_e('that were written on', VL_DOMAIN);
		?> <em><?php echo $post_date; ?></em>.</p><?php 
	} 
	elseif(is_category()) { 
		if( isset( $before_title ) )
			echo $before_title;
		single_cat_title();
		if( isset( $after_title ) )
			echo $after_title;
		?><p><?php
		_e('You are looking at posts', VL_DOMAIN);
		echo ' ';
		_e('in the category', VL_DOMAIN);
		?> <em><?php single_cat_title(); ?></em>.</p><?php
	} 
	elseif(is_page()) {
		if( isset( $before_title ) )
			echo $before_title;
		_e( 'Page Information', VL_DOMAIN );
		if( isset( $after_title ) )
			echo $after_title;
		?><p><?php
		_e('You are reading', VL_DOMAIN);
		?> <em><?php the_title(); ?></em>. <?php
			vl_get_comment_links( 'page' );
		?></p><?php
	} 
	elseif(is_month()) {
		if( isset( $before_title ) )
			echo $before_title;
		the_time('F, Y');
		if( isset( $after_title ) )
			echo $after_title;
		?><p><?php
		_e('You are looking at posts', VL_DOMAIN);
		echo ' ';
		_e('that were written', VL_DOMAIN);
		echo ' ';
		_e('in the month of', VL_DOMAIN);
		?> <em><?php the_time('F'); ?></em> <?php
		_e('in the year', VL_DOMAIN);
		?> <em><?php the_time('Y'); ?></em>.</p><?php
	} 
	elseif(is_year()) {
		if( isset( $before_title ) )
			echo $before_title;
		the_time('Y');
		if( isset( $after_title ) )
			echo $after_title;
		?><p><?php
		_e('You are looking at posts', VL_DOMAIN);
		echo ' ';
		_e('that were written', VL_DOMAIN);
		echo ' ';
		_e('in the year', VL_DOMAIN);
		?> <em><?php the_time('Y'); ?></em>.</p><?php
	} 
	elseif(is_search()) {
		if( isset( $before_title ) )
			echo $before_title;
		_e( 'Search Results', VL_DOMAIN );
		if( isset( $after_title ) )
			echo $after_title;
		?><p><?php
		_e('You searched for', VL_DOMAIN);
		?> <em><?php echo( htmlspecialchars( stripslashes( $_GET['s'] ) ) ); ?></em>.</p><?php
	}
	elseif(is_author()) { 
		if( isset( $before_title ) )
			echo $before_title;
		_e( 'Author Archives', VL_DOMAIN );
		if( isset( $after_title ) )
			echo $after_title;
		$id = 0;
		$post = &get_post($id);
		$author = get_userdata($post->post_author);
		?><p><?php
		_e('You are looking at posts', VL_DOMAIN);
		echo ' ';
		_e('written by', VL_DOMAIN);
		?> <em><a href="<?php echo $author->user_url; ?>"><?php
		echo $author->display_name;
		?></a></em>.</p><?php
	} 
	else if( function_exists( 'is_tag' ) && is_tag() ) {
		if( isset( $before_title ) )
			echo $before_title;
		_e( 'Tagged', VL_DOMAIN );
		if( isset( $after_title ) )
			echo $after_title;
		?><p><?php
		_e('You are looking at posts', VL_DOMAIN);
		echo ' ';
		_e('that have been tagged', VL_DOMAIN);
		?> <em><?php UTW_ShowCurrentTagSet('tagsetcommalist'); ?></em></p><?php
	}
	else {
		// could this be and gallery2 embedded page?
		if( function_exists('g2_init')) {
			if (!defined('G2INIT')) {
				g2_init();
			}
			$g2data = GalleryEmbed::handleRequest();
			if( !empty( $g2data[ 'themeData' ]) ) {
		if( isset( $before_title ) )
			echo $before_title;
				_e( 'Gallery', VL_DOMAIN );
				if( isset( $after_title ) )
					echo $after_title;

				_e('You are looking at the ', VL_DOMAIN);
				echo $g2data[ 'themeData' ][ 'pageType' ];
				?> <em><?php
				echo $g2data[ 'themeData' ][ 'item' ][ 'title' ];
				?> </em><?php
				if( !empty( $g2data[ 'themeData' ][ 'item' ][ 'summary' ] ) ) {
					?><br/><?php
					echo $g2data[ 'themeData' ][ 'item' ][ 'summary' ];
				}
			}
			GalleryEmbed::done();
		}
		else {		
			if( isset( $before_title ) )
				echo $before_title;
		the_title();
		if( isset( $after_title ) )
			echo $after_title;
	}
	}

	if( function_exists('ls_getinfo') && ls_getinfo('isref') ) {
		?><p><?php _e('You came here from', VL_DOMAIN); ?> <em><?php
			ls_getinfo('referrer');
		?></em> <?php _e('searching for', VL_DOMAIN); ?> <em><?php 
			ls_getinfo('terms'); 
		?></em>. <?php _e('These posts might also be of interest', VL_DOMAIN); ?>:</p><ul><?php
			ls_related(10, 10, '<li>', '</li>', '', '', false, false);
		?></ul><?php
	}

	if( function_exists('get_theme_option') 
		&& ( get_theme_option('archive_links') == 'monthly' 
			 || get_theme_option('archive_links') == 'both' ) ) {
		if( isset( $before_title ) )
			echo $before_title;
		_e('Archives', VL_DOMAIN );
		if( isset( $after_title ) )
			echo $after_title;
		echo '<ul>';
		wp_get_archives('type=monthly');
		echo '</ul>';
	}
	if( !function_exists('get_theme_option') 
		|| get_theme_option('archive_links') != 'monthly' ) {
		if( is_single() ) { 
			next_post_link('%link', '<span class="right">' . __('Newer', VL_DOMAIN ) . ' &raquo;</span>'); 
			previous_post_link('%link', '<span class="left">&laquo; ' . __('Older', VL_DOMAIN ) . '</span>'); 
		}
		else { 
			previous_posts_link('<span class="right">' . __('Newer', VL_DOMAIN ) . ' &raquo;</span>');
			next_posts_link('<span class="left">&laquo; ' . __('Older', VL_DOMAIN ) . '</span>');
		}
	}
	if( isset( $after_widget ) )	
		echo $after_widget;
}

if ( function_exists('register_sidebar_widget') )
	register_sidebar_widget(__('Post Info', VL_DOMAIN), 'widget_post_info');

	
	
function widget_wallpaper_selector( $args ) {
	extract($args);
	if( isset( $before_widget ) )	
		echo $before_widget;
	spitOutWallpaperThumbs();
	if( isset( $after_widget ) )	
		echo $after_widget;
}

if ( sidebarThumbs() && function_exists('register_sidebar_widget') )
	register_sidebar_widget(__('Wallpaper Selector'. VL_DOMAIN), 'widget_wallpaper_selector');

	
function vl_widget_meta($args) {
	extract($args);
	$options = get_option('vl_widget_meta');
	$title = empty($options['title']) ? __('Site Meta', VL_DOMAIN) : $options['title'];

	echo $before_widget;
	?><div class="rss"><?php
	?><a href="<?php bloginfo('rss2_url'); ?>" title="<?php _e('Syndicate this site using RSS 2.0', VL_DOMAIN); ?>"><?php
	_e('Syndicate this site using RSS 2.0', VL_DOMAIN);
	?></a><?php
	?><a href="<?php bloginfo('comments_rss2_url'); ?>" title="<?php _e('The latest comments to all posts in RSS 2.0', VL_DOMAIN); ?>"><?php
	_e('The latest comments to all posts in RSS 2.0', VL_DOMAIN);
	?></a><?php
	?></div><?php
	echo $before_title . $title . $after_title;
	?><ul><?php
		wp_register();
		?><li><?php wp_loginout(); ?></li><?php
		?><li><a href="http://jigsaw.w3.org/css-validator/check/referer">css</a></li><?php
		?><li><a title="xhtml 1.0 strict" href="http://validator.w3.org/check/referer">xhtml 1.0</a></li><?php
		?><li><a href="http://wordpress.com/" title="<?php _e('Powered by WordPress, state-of-the-art semantic personal publishing platform.', VL_DOMAIN); ?>">WordPress.com</a></li><?php
		wp_meta();
	?></ul><?php
	echo $after_widget;
}

function vl_widget_meta_reduced($args) {
	extract($args);
	$options = get_option('vl_widget_meta');
	$title = empty($options['title']) ? __('Site Meta') : $options['title'];

	echo $before_widget;
	?><div class="rss"><?php
	?><a href="<?php bloginfo('rss2_url'); ?>" title="<?php _e('Syndicate this site using RSS 2.0', VL_DOMAIN); ?>"><?php
	_e('Syndicate this site using RSS 2.0', VL_DOMAIN);
	?></a><?php
	?><a href="<?php bloginfo('comments_rss2_url'); ?>" title="<?php _e('The latest comments to all posts in RSS 2.0', VL_DOMAIN); ?>"><?php
	_e('The latest comments to all posts in RSS 2.0', VL_DOMAIN);
	?></a><?php
	?></div><?php
	echo $before_title . $title . $after_title;
	?><ul><?php
		wp_register();
		wp_meta();
	?></ul><?php
	echo $after_widget;
}


function vl_link() {
		?><li><a href="http://windyroad.org/software/wordpress/vistered-little-theme" title="<?php _e('Download your own copy of', VL_DOMAIN); ?>Vistered Little">Vistered Little <?php _e( 'Theme', VL_DOMAIN ); ?></a></li><?php	
}

if( !function_exists('get_theme_option') || get_theme_option('metacredits') != 'hide' ) {
	add_action('wp_meta', 'vl_link' );
}

function vl_widget_meta_control() {
	$options = $newoptions = get_option('vl_widget_meta');
	if ( $_POST["meta-submit"] ) {
		$newoptions['title'] = strip_tags(stripslashes($_POST["meta-title"]));
	}
	if ( $options != $newoptions ) {
		$options = $newoptions;
		update_option('vl_widget_meta', $options);
	}
	$title = htmlspecialchars($options['title'], ENT_QUOTES);
	?><p><label for="meta-title"><?php _e('Title:', VL_DOMAIN); ?> <input style="width: 250px;" id="meta-title" name="meta-title" type="text" value="<?php echo $title; ?>" /></label></p><?php
	?><input type="hidden" id="meta-submit" name="meta-submit" value="1" /><?php
}

if( function_exists( 'register_sidebar_widget' ) )
	register_sidebar_widget(array('Meta', 'widgets'), 'vl_widget_meta');
if( function_exists( 'register_sidebar_widget' ) )
	register_sidebar_widget(array('Reduced Meta', 'widgets'), 'vl_widget_meta_reduced');
if( function_exists( 'register_widget_control' ) )
	register_widget_control(array('Meta', 'widgets'), 'vl_widget_meta_control', 300, 90);
if( function_exists( 'register_widget_control' ) )
	register_widget_control(array('Reduced Meta', 'widgets'), 'vl_widget_meta_control', 300, 90);


function vl_widget_calendar($args) {
	extract($args);
	echo $before_widget;
	get_calendar();
	?><div style="clear: both;"></div><?php
	echo $after_widget;
}
 
if ( function_exists('register_sidebar_widget') )
	register_sidebar_widget(array('Calendar', 'widgets'), 'vl_widget_calendar');

	
function vl_widget_links( $args ) {
	extract($args);
	echo $before_widget;
	?><ul id="links"><?php
	vl_get_links_list();
	?></ul><?php
	echo $after_widget;
}

if ( function_exists('register_sidebar_widget') )
	register_sidebar_widget(__('Links', VL_DOMAIN), 'vl_widget_links');


function vl_widget_sideblogwidget($args,$number=1){
	global $registered_widgets;
	extract($args);
	$options = get_option('widget_sideblog');
	$title = $options[$number]['title'];
	$category = $options[$number]['category'];
	if( !function_exists('get_theme_option')
		|| get_theme_option('sideblog_format') != 'combined' ) {
		if(!empty($title)) {
			echo $before_widget . $before_title . $title . $after_title . $after_widget;
		}
		sideblog($category);
	}
	else {
		echo $before_widget;
		if(!empty($title)) {
			echo $before_title . $title . $after_title;
		}
		sideblog($category);
		echo $after_widget;
	}
}

if(function_exists('register_sidebar_widget') && function_exists('sideblog') ){
	$sideblog_options = get_option('sideblog_options');
	if($sideblog_options['setaside']){
		$number = count($sideblog_options['setaside']);
		for($i=1;$i<=$number;$i++){
			$sbname = array(__('Sideblog', VL_DOMAIN) . ' %s',null,$i);
			register_sidebar_widget($sbname,'vl_widget_sideblogwidget',$i);
		}
	}
}

function vl_widget_text($args, $number = 1) {
	extract($args);
	$options = get_option('widget_text');
	$title = $options[$number]['title'];
	$text = $options[$number]['text'];
?>
		<?php echo $before_widget; ?>
			<?php !empty( $title ) ? print($before_title . $title . $after_title) : null; ?>
			<div class="textwidget"><?php echo $text; ?></div>
		<?php echo $after_widget; ?>
<?php
}


function vl_widget_text_register() {
	$options = get_option('widget_text');
	$number = $options['number'];
	if ( $number < 1 ) $number = 1;
	if ( $number > 9 ) $number = 9;
	$dims = array('width' => 460, 'height' => 350);
	$class = array('classname' => 'widget_text');
	for ($i = 1; $i <= 9; $i++) {
		if( function_exists( 'wp_register_sidebar_widget' ) ) {
			$name = sprintf(__('Text', VL_DOMAIN) . ' %d', $i);
			$id = "text-$i"; // Never never never translate an id
			wp_register_sidebar_widget($id, $name, $i <= $number ? 'vl_widget_text' : /* unregister */ '', $class, $i);
		}
		else if( functions_exists( 'register_sidebar_widget' ) ) {
			$name = array('Text %s', 'widgets', $i);
			register_sidebar_widget($name, $i <= $number ? 'widget_text' : /* unregister */ '', $i);
		}
	}
}

if( function_exists('wp_theme_switcher') ) {
	function vl_widget_theme_switcher($args) {
		extract($args);
		echo $before_widget;
		echo $before_title;
		_e( "Themes", VL_DOMAIN );
		echo $after_title;
		wp_theme_switcher();
		echo $after_widget;
	}
	
	if ( function_exists('register_sidebar_widget') )
		register_sidebar_widget(__('Theme Switcher', VL_DOMAIN), 'vl_widget_theme_switcher');
}

add_action('widgets_init', 'vl_widget_text_register' );
