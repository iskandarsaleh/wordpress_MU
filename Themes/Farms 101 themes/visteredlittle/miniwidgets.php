<?php

// returns true if the miniwidget should be displayed on this page
function vl_display_miniwidget( $mw_id ) {
	$options = get_option($mw_id);
	$mfg_home = $options['home'] ? '1' : '0';
	$mfg_post = $options['post'] ? '1' : '0';
	$mfg_page = $options['page'] ? '1' : '0';
	$mfg_cat = $options['cat'] ? '1' : '0';
	$mfg_date = $options['date'] ? '1' : '0';
	$mfg_style = $options['style'];
	$mfg_class = $options['class'];
	return ( is_home() && !$mfg_home )
		|| ( is_single() && !$mfg_post )
		|| ( is_page() && !$mfg_page )
		|| ( is_category() && !$mfg_cat )
		|| ( is_date() && !$mfg_date )
		|| ( !is_home() && !is_single() && !is_page() && !is_category() && !is_date() );
}

// returns the style for the miniwidget is set
function vl_get_miniwidget_style( $mw_id ) {
	$options = get_option($mw_id);
	return strip_tags(stripslashes( $options['style'] ) );
}

// returns the class for the miniwidget is set
function vl_get_miniwidget_class( $mw_id ) {
	$options = get_option($mw_id);
	return strip_tags(stripslashes( $options['class'] ) );
}

/* Shows the miniwidget.
 * 
 * $display is the function to call to display the contents of
 * the widget
 * 
 * $checkDisplay is the function to call to check if the miniwidget
 * should be displayed.  $checkDisplay may be null
 */ 
function vl_miniwidget( $mw_id, $display, $checkDisplay, $args ) {
	if( vl_display_miniwidget( $mw_id ) ) {
		if( !$checkDisplay || $checkDisplay() ) {
			extract($args);
			$before_widget = str_replace('style=""', 
						'style="' . vl_get_miniwidget_style( $mw_id ) . '"',
						$before_widget );
			$before_widget = str_replace('class="footer-item"', 
						'class="footer-item ' . vl_get_miniwidget_class( $mw_id ) . '"',
						$before_widget );
			echo $before_widget;
			$display();
			echo $after_widget;
		}
	}
}

/* displays the config menu for the miniwidget
 * 
 * $mw_id is a unique identifier for the miniwidget  
 */
function vl_miniwidget_control( $mw_id ) {
	$options = $newoptions = get_option( $mw_id);
	if ( $_POST[ $mw_id . '-submit'] ) {
		$newoptions['style'] = strip_tags(stripslashes($_POST[ $mw_id . '-style']));
		$newoptions['class'] = strip_tags(stripslashes($_POST[ $mw_id . '-class']));
		$newoptions['home'] = isset($_POST[ $mw_id . '-home']);
		$newoptions['post'] = isset($_POST[ $mw_id . '-post']);
		$newoptions['page'] = isset($_POST[ $mw_id . '-page']);
		$newoptions['cat'] = isset($_POST[ $mw_id . '-cat']);
		$newoptions['date'] = isset($_POST[ $mw_id . '-date']);
	}
	if ( $options != $newoptions ) {
		$options = $newoptions;
		update_option( $mw_id, $options);
	}
	$mfg_style = wp_specialchars($options['style']);
	$mfg_class = wp_specialchars($options['class']);
	$mfg_home = $options['home'] ? 'checked="checked"' : '';
	$mfg_post = $options['post'] ? 'checked="checked"' : '';
	$mfg_page = $options['page'] ? 'checked="checked"' : '';
	$mfg_cat = $options['cat'] ? 'checked="checked"' : '';
	$mfg_date = $options['date'] ? 'checked="checked"' : '';
	?><p><label for="<?php echo $mw_id; ?>-style"><?php _e('Style:', VL_DOMAIN); ?> <input style="width: 250px;" id="<?php echo $mw_id; ?>-style" name="<?php echo $mw_id; ?>-style" type="text" value="<?php echo $mfg_style; ?>" /></label></p><?php
	?><p><label for="<?php echo $mw_id; ?>-class"><?php _e('Class:', VL_DOMAIN); ?> <input style="width: 250px;" id="<?php echo $mw_id; ?>-class" name="<?php echo $mw_id; ?>-class" type="text" value="<?php echo $mfg_class; ?>" /></label></p><?php
	?><p style="text-align:right;margin-right:40px;"><label for="<?php echo $mw_id; ?>-home"><?php _e('Hide on front page', VL_DOMAIN); ?> <input class="checkbox" type="checkbox" <?php echo $mfg_home; ?> id="<?php echo $mw_id; ?>-home" name="<?php echo $mw_id; ?>-home" /></label></p><?php
	?><p style="text-align:right;margin-right:40px;"><label for="<?php echo $mw_id; ?>-post"><?php _e('Hide on individual posts', VL_DOMAIN); ?> <input class="checkbox" type="checkbox" <?php echo $mfg_post; ?> id="<?php echo $mw_id; ?>-post" name="<?php echo $mw_id; ?>-post" /></label></p><?php
	?><p style="text-align:right;margin-right:40px;"><label for="<?php echo $mw_id; ?>-page"><?php _e('Hide on "pages"', VL_DOMAIN); ?> <input class="checkbox" type="checkbox" <?php echo $mfg_page; ?> id="<?php echo $mw_id; ?>-page" name="<?php echo $mw_id; ?>-page" /></label></p><?php
	?><p style="text-align:right;margin-right:40px;"><label for="<?php echo $mw_id; ?>-cat"><?php _e('Hide on category archives', VL_DOMAIN); ?> <input class="checkbox" type="checkbox" <?php echo $mfg_cat; ?> id="<?php echo $mw_id; ?>-cat" name="<?php echo $mw_id; ?>-cat" /></label></p><?php
	?><p style="text-align:right;margin-right:40px;"><label for="<?php echo $mw_id; ?>-date"><?php _e('Hide on date based archives', VL_DOMAIN); ?> <input class="checkbox" type="checkbox" <?php echo $mfg_date; ?> id="<?php echo $mw_id; ?>-date" name="<?php echo $mw_id; ?>-date" /></label></p><?php
	?><input type="hidden" id="<?php echo $mw_id; ?>-submit" name="<?php echo $mw_id; ?>-submit" value="1" /><?php
}	

/*
 * Register a new miniwidget.
 * 
 * $name is the display name of the miniwidget in the admin screen.
 * The name will be prefixed by "MW » " to distinguish it from normal widgets
 * 
 * $mw_id is a unique identifier for the miniwidget
 * 
 * $display is the function to call to display the contents of
 * the widget
 * 
 * $checkDisplay is the function to call to check if the miniwidget
 * should be displayed.  $checkDisplay may be null
 * 
 */
function vl_register_miniwidget( $name, $mw_id, $display, $checkDisplay = null ) {
	if ( function_exists('register_sidebar_widget') ) {
		$code = 'vl_miniwidget("vl_miniwidget_' . $mw_id . '", "' . $display .  '", ';
		if( $checkDisplay )
			$code .= '"' . $checkDisplay . '"';
		else
			$code .= 'null';
		$code .= ', $args );';
		$func = create_function('$args', $code);
		register_sidebar_widget(__('MW &raquo; ', VL_DOMAIN) . $name, "$func");
	}


	if( function_exists( 'register_widget_control' ) ) {
		$func = create_function('', 'vl_miniwidget_control("vl_miniwidget_' . $mw_id . '");');
		register_widget_control(__('MW &raquo; ', VL_DOMAIN) . $name, "$func", 300, 300);
	}	
}

/*******************************************************
 * 
 * The rest of this file is just registering miniwidgets
 * 
 *******************************************************/


/*
 * WP-Print
 */
if(function_exists('wp_print')) { 
	vl_register_miniwidget(__('Print This Post', VL_DOMAIN), 'print', 'print_link');			
}


/*
 * Sociable
 * 
 * Because the Sociable plugin, will normally display itself
 * at the end of the_content, this Sociable miniwidget will check
 * to see if Sociable has been configured to display on this page
 * and of so, then the miniwidget won't display.  i.e., when you
 * turn Sociable on for a particular page, it turns this miniwidget
 * off for that page.
 * The reasoning behind this is we don't want it to display twice. 
 */
if( function_exists( 'sociable_html' ) ) {
	function vl_display_sociable() {
		$conditionals = get_option('sociable_conditionals');
		return !((is_home()     and $conditionals['is_home']) or
		       (is_single()   and $conditionals['is_single']) or
		       (is_page()     and $conditionals['is_page']) or
		       (is_category() and $conditionals['is_category']) or
		       (is_date()     and $conditionals['is_date']) or
		       (is_search()   and $conditionals['is_search']) or
		       0);
	}	

	function vl_sociable() {
		print sociable_html();
	}
	
	vl_register_miniwidget(__('Sociable', VL_DOMAIN), 'sociable', 'vl_sociable', 'vl_display_sociable');		
}	

/*
 * Jerome's Keywords
 */
if( function_exists( 'the_post_keytags' ) ) {
	function vl_jeromes_keywords() {
		_e('Tags: ', VL_DOMAIN );
		the_post_keytags();
	}
	
	vl_register_miniwidget(__('Jerome\'s Keywords', VL_DOMAIN), 'jeromes_keywords', 'vl_jeromes_keywords');		
}


/*
 * Bunny's Technorati Tags
 */
if( function_exists( 'the_bunny_tags' ) ) {
	vl_register_miniwidget(__('Bunny\'s Technorati Tags', VL_DOMAIN), 'bunny_tags', 'the_bunny_tags');		
}


/*
 * Ultimate Tag Warrior
 */

if( function_exists( 'UTW_ShowTagsForCurrentPost' ) ) {
	function vl_utw_primary() {
		$custom = array();
		if (get_option('utw_primary_automagically_included_prefix') != '') {
			$custom['pre'] = stripslashes(get_option('utw_primary_automagically_included_prefix'));
		}
		if (get_option('utw_primary_automagically_included_suffix') != '') {
			$custom['post'] = stripslashes(get_option('utw_primary_automagically_included_suffix'));
		}
		global $post, $utw;
		$tags = $utw->GetTagsForPost($post->ID);	
		$format = $utw->GetFormat(get_option('utw_primary_automagically_included_link_format'), $custom);
		$tagHTML = '<span class="UTWPrimaryTags">' . $utw->FormatTags($tags, $format) . '</span>';
		echo $tagHTML;
	}

	function vl_utw_display_primary() {
		return ( !get_option('utw_include_local_links') 
				 || get_option('utw_include_local_links') == 'No' 
				 || get_option('utw_include_local_links') == 'no' )
			    && get_option('utw_primary_automagically_included_link_format') != '';
	}


	function vl_utw_secondary() {
		$custom = array();
		if (get_option('utw_secondary_automagically_included_prefix') != '') {
			$custom['pre'] = stripslashes(get_option('utw_secondary_automagically_included_prefix'));
		}
		if (get_option('utw_secondary_automagically_included_suffix') != '') {
			$custom['post'] = stripslashes(get_option('utw_secondary_automagically_included_suffix'));
		}
		global $post, $utw;
		$tags = $utw->GetTagsForPost($post->ID);	
		$format = $utw->GetFormat(get_option('utw_secondary_automagically_included_link_format'), $custom);
		$tagHTML = '<span class="UTWSecondaryTags">' . $utw->FormatTags($tags, $format) . '</span>';
		echo $tagHTML;
	}

	function vl_utw_display_secondary() {
		return ( !get_option('utw_include_technorati_links') 
				 || get_option('utw_include_technorati_links') == 'No' 
				 || get_option('utw_include_technorati_links') == 'no' )
			    && get_option('utw_secondary_automagically_included_link_format') != '';
	}

	function vl_utw_related() {
		_e('Related Posts:', VL_DOMAIN);
		?><ul><?php
		UTW_ShowRelatedPostsForCurrentPost("posthtmllist");
		?></ul><?php
	}
			
	vl_register_miniwidget(__('UTW Primary Tags', VL_DOMAIN), 'utw_primary', 'vl_utw_primary', 'vl_utw_display_primary');
	vl_register_miniwidget(__('UTW Secondary Tags', VL_DOMAIN), 'utw_secondary', 'vl_utw_secondary', 'vl_utw_display_secondary');
	vl_register_miniwidget(__('UTW Related Posts', VL_DOMAIN), 'utw_related', 'vl_utw_related');	
}

/* 
 * More From Google
 */
if( function_exists( 'mfg_link' ) ) {
	
	function vl_display_mfg() {
		if( !mfg_get_append_to_content() ) {
			mfg_link();
		}
	}
	vl_register_miniwidget(__('More From Google', VL_DOMAIN), 'morefromgoogle', 'vl_display_mfg', 'mfg_get_search_term');
}

/* 
 * WP-Email
 */
if(function_exists('wp_email')) {
	vl_register_miniwidget(__('WP-EMail', VL_DOMAIN), 'wpemail', 'email_link');
}

?>
