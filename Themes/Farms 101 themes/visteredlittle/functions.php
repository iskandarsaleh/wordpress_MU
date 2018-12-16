<?php

define('VL_DOMAIN', 'vistered-little');

$_BENICE[]='vistered-little;6770968883708243;0065577911';


$visteredlittle_is_setup = FALSE;

function visteredlittle_setup()
{
	$locale = get_locale();
	if ( empty($locale) )
		$locale = 'en_US';	
    load_textdomain(VL_DOMAIN, dirname(__FILE__) . '/localization/' . $locale . '.mo');
    $visteredlittle_is_setup = 1;
}

add_action('init', 'visteredlittle_setup');


require_once( dirname(__FILE__).'/wallpaper_functions.php' );
if( !function_exists( 'get_skin' ) ) {
	include( dirname(__FILE__).'/skins/default/functions.php' );
}

if( function_exists( 'presentationtoolkit' ) ) {
	$vl_wallpaper_options = 'Wallpaper {radio|random|' . __('Random', VL_DOMAIN). ' (' . __('default', VL_DOMAIN) . ')';
	$count_wallpapers = 0;
	foreach( $vl_wallpapers as $format => $vl_sub_wallpapers )
	{
		foreach( $vl_sub_wallpapers as $vl_wallpaper )
		{
			$vl_wallpaper_options .= "|$count_wallpapers|" . basename($vl_wallpaper->wallpaper);
			++$count_wallpapers;
		}
	}
	$vl_wallpaper_options .= '} ## ';
	$vl_wallpaper_options .= __('Select a default wallpaper for your page.', VL_DOMAIN);

	$logo_width_help_string = __('Enter the width of the logo in pixels. The default is 500.', VL_DOMAIN);
	$logo_height_help_string = __('Enter the height of the logo in pixels. The default is 90.', VL_DOMAIN);
	if( function_exists( 'imagesx' ) )
	{
		$logo_width_help_string .= __('An attempt will be made to determine the logo width automatically.', VL_DOMAIN);
		$logo_height_help_string .= __('An attempt will be made to determine the logo height automatically.', VL_DOMAIN);
	}
	$options = array();

	$options['sidebarlocation'] = __('Sidebar Location', VL_DOMAIN )
		. ' {radio|right|' 
		. __('Right', VL_DOMAIN)
		. ' (' 
		. __('default', VL_DOMAIN) 
		. ')|left|'
		. __('Left', VL_DOMAIN)
		. '} ## '
		. __('Select which side of the page you want your sidebar to be on.', VL_DOMAIN);

	$options['quadpossidebar'] = __('Side Bar Type', VL_DOMAIN) 
		. ' {radio|mono|' 
		. __('Single Position', VL_DOMAIN) 
		. ' (' . __('default', VL_DOMAIN) . ')|quad|' 
		. __('Quad Position', VL_DOMAIN) 
		. '} ## ' 
		. __('A quad position sidebar allows you to configure widgets that are displayed in a wide section at the top of the side bar, on the left and right of the side bar and a wide sections at the bottom of the side bar.', VL_DOMAIN);

	$options['headerposition'] = __('Header Position', VL_DOMAIN ) 
		. ' {radio|normal|' 
		. __('Normal', VL_DOMAIN ) 
		. '|fixed|' 
		. __('Fixed', VL_DOMAIN) 
		. ' (' 
		. __('default', VL_DOMAIN) 
		. ')} ## ' 
		. __('Select whether the header should have normal or Fixed positioning.', VL_DOMAIN);

	$options['headersearch'] = __('Header Search Field', VL_DOMAIN ) 
		. ' {radio|show|' 
		. __('Show', VL_DOMAIN ) 
		. ' (' 
		. __('default', VL_DOMAIN) 
		. ')|hide|' 
		. __('Hide', VL_DOMAIN) 
		. '} ## ' 
		. __('Select whether to display a search box in the header.', VL_DOMAIN);

	$options['framedthumbs'] = __('Thumbnail Frames', VL_DOMAIN ) 
		. ' {radio|border|' 
		. __('Use CSS Border', VL_DOMAIN ) 
		. ' (' 
		. __('default', VL_DOMAIN) 
		. ')|image|' 
		. __('Use Image', VL_DOMAIN) 
		. '} ## ' 
		. __('Select whether to use a CSS border or an image to frame the wallpaper thumbnails.', VL_DOMAIN);

	$options['thumbpos'] = __('Thumbnail Location', VL_DOMAIN ) 
		. ' {radio|left|' 
		. __('Left', VL_DOMAIN ) 
		. ' (' 
		. __('default', VL_DOMAIN)
		. ')|right|' 
		. __('Right', VL_DOMAIN) 
		. '|sidebar|' 
		. __('Sidebar', VL_DOMAIN) 
		. '|none|' 
		. __('None', VL_DOMAIN) 
		. '} ## ' 
		. __('Select where you would like the thumbnails to be displayed.', VL_DOMAIN);

	$options['wallpaper'] = $vl_wallpaper_options;

	$options['randomthumb'] = __('Random Wallpaper Option', VL_DOMAIN ) 
		. ' {radio|hide|' 
		. __('Hide', VL_DOMAIN ) 
		. ' (' 
		. __('default', VL_DOMAIN) 
		. ')|show|' 
		. __('Show', VL_DOMAIN) 
		. '} ## ' 
		. __('Select if a thumbnail should be shown to the user to have random wallpapers.', VL_DOMAIN);

	$options['logo_dir'] = __('Logo Path', VL_DOMAIN ) 
		. ' ## ' 
		. __('Enter the path (relative to "', VL_DOMAIN) 
		. get_bloginfo('template_directory') 
		. __('") to the directory containing your site logos or the path to a single logo (leave blank to use "' , VL_DOMAIN)
		. get_bloginfo( 'title' ) 
		. __('" instead).<br/>If a directory is specified, then every time the site is displayed, a random logo will be selected from this directory.<br/>Recognised types: gif, png, jpeg and tiff', VL_DOMAIN);

	$options['logo_width'] = __('Logo Width', VL_DOMAIN ) 
		. ' ## ' . $logo_width_help_string;

	$options['logo_height'] = __('Logo Height', VL_DOMAIN ) 
		. ' ## ' . $logo_height_help_string;

	$options['archive_links'] = __('Archive Links', VL_DOMAIN ) 
		. ' {radio|oldnew|' 
		. __('Older and Newer', VL_DOMAIN ) 
		. ' (' 
		. __('default', VL_DOMAIN) 
		. ')|monthly|' 
		. __('Monthly', VL_DOMAIN) 
		. '|both|' 
		. __('Both', VL_DOMAIN) 
		. '} ## ' 
		. __('Select if the Archived menu should display an Older/Newer link, Monthly links or both.', VL_DOMAIN);

	$options['credits'] = __('Credits', VL_DOMAIN ) 
		. ' {radio|show|' 
		. __('Show', VL_DOMAIN ) 
		. ' (' 
		. __('default', VL_DOMAIN) 
		. ')|hide|' 
		. __('Hide', VL_DOMAIN) 
		. '} ## ' 
		. __('If you like Vistered Little, then you can say thank you by showing me some link love.  Otherwise you can disable the link in the footer by selecting hide.', VL_DOMAIN);

	$options['metacredits'] = __('Credits in Meta', VL_DOMAIN ) 
		. ' {radio|show|' 
		. __('Show', VL_DOMAIN ) 
		. ' (' 
		. __('default', VL_DOMAIN) 
		. ')|hide|' 
		. __('Hide', VL_DOMAIN) 
		. '} ## ' 
		. __('You can also hide the link to Vistered Little in the Meta widget, by selecting hide here.', VL_DOMAIN);

	$options['headcredits'] = __('Credits in Head', VL_DOMAIN ) 
		. ' {radio|include|' 
		. __('Include', VL_DOMAIN ) 
		. ' (' 
		. __('default', VL_DOMAIN) 
		. ')|remove|' 
		. __('Remove', VL_DOMAIN) 
		. '} ## ' 
		. __('There is one more link to Vistered Little, which is located in the xhtml head section (i.e. not visible).  Select remove to get rid of it as well.', VL_DOMAIN);

	$options['comment-policy'] = __('Comment Policy', VL_DOMAIN ) 
		. ' {textarea|10|100%}## ' 
		. __('Here you can specify the comment moderation policy for your site.', VL_DOMAIN);

	$options['custom_path'] = __('Customization directory', VL_DOMAIN ) 
		. ' ## ' 
		. __('Enter the path (relative to "', VL_DOMAIN) 
		. get_bloginfo('template_directory') 
		. __('") to a directory containing custom stylesheets and/or custom php files.<br/>Files ending with ".css" or ".css.php" will be included as stylesheets.  Files ending in "-ie.css" or "-ie.css.php" will also be included as stylesheets, but will only be visible to IE 6.  All other files ending in ".php" will be included at the end of this themes "functions.php" file.', VL_DOMAIN);

	if( function_exists('sideblog') ) {
		$options[ 'sideblog_format' ] = __('Sideblog format', VL_DOMAIN)
				. ' {radio|combined|' 
				. __('Combined', VL_DOMAIN ) 
				. '|separated|' 
				. __('Separated (' , VL_DOMAIN)
				. __('default', VL_DOMAIN) 
				. ')} ## '
				. __('If you want your sideblog to display in a single box, select "Combined" and set the sideblog display format to <pre><code>&lt;div&gt;&lt;h4&gt;%title_url%&lt;/h4&gt;%content%&lt;/div&gt;</code></pre>If you want the sideblog title and posts to appear in separate boxes, select "Separated" and set the sideblog display format to <pre><code>&lt;div class="menubefore"&gt;&lt;/div&gt;&lt;div class="menu"&gt;&lt;h4&gt;%title_url%&lt;/h4&gt;%content%&lt;/div&gt;&lt;div class="menuafter"&gt;&lt;/div&gt;</code></pre>', VL_DOMAIN);		
	}	

	$options['showauthor'] = __('Show Author', VL_DOMAIN ) 
		. ' {radio|show|' 
		. __('Show', VL_DOMAIN ) 
		. ' (' 
		. __('default', VL_DOMAIN) 
		. ')|hide|' 
		. __('Hide', VL_DOMAIN) 
		. '} ## ' 
		. __("Select Hide if you don't want the author to be displayed at the top of posts.", VL_DOMAIN);

	$options['font-family'] = __('Font', VL_DOMAIN ) 
		. ' ## ' 
		. __('Specify the font you want to use for the site.', VL_DOMAIN)
		. __('<br/>The default is <code>"verdana", sans-serif</code>', VL_DOMAIN);

	$options['title-font-family'] = __('Title Font', VL_DOMAIN ) 
		. ' ## ' 
		. __("Specify the font you want to use for the site's Title.", VL_DOMAIN)
		. __('<br/>The default is <code>"Trebuchet MS", sans-serif</code>', VL_DOMAIN);

	$options['font-size'] = __('Font Size', VL_DOMAIN ) 
		. ' ## ' 
		. __("Specify the font size you want to use for the site.", VL_DOMAIN)
		. __('<br/>The default is <code>20px</code>', VL_DOMAIN);

	presentationtoolkit( $options, __FILE__ );
}

if( function_exists('get_theme_option') ) {
	function vl_get_theme_option( $option, $default = null ) {
		$rval = get_theme_option( $option );
		return empty( $rval ) ? $default : $rval;
	}	
}
else {
	function vl_get_theme_option( $option, $default = null ) {
		return $default;
	}		
}
 
function ie_skin_stylesheet_url() {
	global $vl_skin;
   	$vl_css="/skins/$vl_skin-ie.css.php";
    
    if( file_exists(dirname(__FILE__).$vl_css) )
    	return $vl_css;
    else
    	return "/skins/common-ie.css.php?skin=$vl_skin";
}

function wallpaper_selection()
{
	global $vl_wallpapers;
	$keys = array_merge( array_keys( $vl_wallpapers[ 'tiled' ] ), array_keys( $vl_wallpapers[ 'bottom-left' ] ) );
	$idx = array_rand( $keys );
	if( function_exists('get_theme_option') && get_theme_option('wallpaper') ) {
		$idx = get_theme_option('wallpaper');
	}
	if( isset( $_SESSION['vl_wallpaper'] ) )
	{
		if( $_SESSION['vl_wallpaper'] == "-1" )
			$idx = "-1";
		else if( isset( $keys[$_SESSION['vl_wallpaper']]))
			$idx = $_SESSION['vl_wallpaper'];
	}
	return $idx;
}

function wallpaper_id()
{
	$idx = wallpaper_selection();
	if( $idx == "-1" ) {
		global $vl_wallpapers;
		$keys = array_merge( array_keys( $vl_wallpapers[ 'tiled' ] ), array_keys( $vl_wallpapers[ 'bottom-left' ] ) );
		$idx = array_rand( $keys );
	}
	return $idx;
}

function wallpaper_class()
{
	return 'wallpaper' . wallpaper_id();
}

$vl_thumbpos = "left";
if( function_exists('get_theme_option') && get_theme_option('thumbpos') )
	$vl_thumbpos = get_theme_option('thumbpos');

function headerThumbs()
{
    global $vl_thumbpos;
	return  $vl_thumbpos == "left" || $vl_thumbpos == "right";
}

function sidebarThumbs()
{
    global $vl_thumbpos;
	return  $vl_thumbpos == "sidebar";
}

function menu_position_stylesheet_url() {
    if( function_exists('get_theme_option') 
		&& get_theme_option('sidebarlocation') == "left") {
		return '/menuleft.css';
    }
    else {
    	return false;
	}
}

if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'name' => __('Banner', VL_DOMAIN),
		'before_widget' => '<div class="post">',
		'after_widget' => '</div>',
		'before_title' => '<h4>',
		'after_title' => '</h4>'
	));

	if( !function_exists('get_theme_option') || get_theme_option('quadpossidebar') != 'quad' ) {
	    register_sidebar(array(
			'name' => __('Sidebar', VL_DOMAIN),
	        'before_widget' => '<div class="menubefore"></div><div class="menu">',
	        'after_widget' => '</div><div class="menuafter"></div>',
	        'before_title' => '<h4>',
	        'after_title' => '</h4>'
	    ));
	}
	else {
		$options = array(
			'name' => __('Quadbar - Top', VL_DOMAIN),
	        'before_widget' => '<div class="menubefore"></div><div class="menu">',
	        'after_widget' => '</div><div class="menuafter"></div>',
	        'before_title' => '<h4>',
	        'after_title' => '</h4>'
	    );
	    register_sidebar( $options );
		$options[ 'name' ] = __('Quadbar - Left', VL_DOMAIN);
	    register_sidebar( $options );

		$options[ 'name' ] = __('Quadbar - Right', VL_DOMAIN);
	    register_sidebar( $options );

		$options[ 'name' ] = __('Quadbar - Bottom', VL_DOMAIN);
	    register_sidebar( $options );
	}
	
	register_sidebar(array(
		'name' => __('Footer Bar', VL_DOMAIN),
		'before_widget' => '<div class="post">',
		'after_widget' => '</div>',
		'before_title' => '<h4>',
		'after_title' => '</h4>'
	));

	// if you change before_widget, make sure you change miniwigets as well
	register_sidebar(array(
		'name' => __('End Of Post', VL_DOMAIN),
		'before_widget' => '<div class="footer-item" style="">',
		'after_widget' => '</div>',
		'before_title' => '<h4>',
		'after_title' => '</h4>'
	));

	register_sidebar(array(
		'name' => __('2nd Banner', VL_DOMAIN),
		'before_widget' => '<div class="post">',
		'after_widget' => '</div>',
		'before_title' => '<h4>',
		'after_title' => '</h4>'
	));

	register_sidebar(array(
		'name' => __('3rd Banner', VL_DOMAIN),
		'before_widget' => '<div class="post">',
		'after_widget' => '</div>',
		'before_title' => '<h4>',
		'after_title' => '</h4>'
	));

}



function get_bloghaslogos() {
    if( vl_get_theme_option('logo_dir') )
	{
		$path = trim( vl_get_theme_option('logo_dir') );
		if( !empty( $path ) ) {
			$d=dirname(__FILE__) . "/" . $path;
			if( file_exists( $d ) )
			{
				$dir = @opendir($d);
				if( $dir ) {
					while ($f = readdir($dir)) { 
						$matches = null;
						if (eregi("(.*)\.(gif)|(jpe?g)|(png)|(tiff?)",$f,$matches)) { 
							return true; 
						}
					}
				}
				else {
					$matches = null;
					if (eregi("(.*)\.(gif)|(jpe?g)|(png)|(tiff?)",$path,$matches)) { 
						return true; 
					}
				}
			}
		}
	}
    return false;
}

$vl_has_logos = -1;

function vl_get_bloglogodir()
{
	global $vl_has_logos;
	if( $vl_has_logos == -1 ) {
		$vl_has_logos = get_bloghaslogos();
	}
	if( $vl_has_logos ) {
		return trim( get_theme_option('logo_dir') );
	}
	return null;
}

function vl_bloglogostyle()
{
	if( vl_get_bloglogodir() )
	{
		$link = get_bloginfo('template_directory') . '/logos.css.php?dir=' . vl_get_bloglogodir();
		if( get_theme_option('logo_width') ) {
			$vl_logo_width = trim( get_theme_option('logo_width') );
			if( !empty( $vl_logo_width) ) {
				$link .= '&amp;width=' . $vl_logo_width;
			}
		}
		if( get_theme_option('logo_height') ) {
			$vl_logo_height = trim( get_theme_option('logo_height') );
			if( !empty( $vl_logo_height) ) {
				$link .= '&amp;height=' . $vl_logo_height;
			}
		}
	?>
<link rel="stylesheet" href="<?php echo $link; ?>" type="text/css" media="screen" />
<!--[if lte IE 6]>
<link rel="stylesheet" href="<?php echo $link; ?>&amp;ie" type="text/css" media="screen" />
<![endif]-->
	<?php
	}
}

/*
 * function vl_get_links_list()
 *
 * Copied from Wordpress
 *
 * Output a list of all links, listed by category, using the
 * settings in $wpdb->linkcategories and output it as a nested
 * HTML unordered list.
 *
 * Parameters:
 *   order (default 'name')  - Sort link categories by 'name' or 'id'
 *   hide_if_empty (default true)  - Supress listing empty link categories
 */
function vl_get_links_list($order = 'name', $hide_if_empty = 'obsolete') {
	$order = strtolower($order);

	// Handle link category sorting
	$direction = 'ASC';
	if ( '_' == substr($order,0,1) ) {
		$direction = 'DESC';
		$order = substr($order,1);
	}

	if ( !isset($direction) )
		$direction = '';

	$cats = get_categories("type=link&orderby=$order&order=$direction&hierarchical=0");

	// Display each category
	if ( $cats ) {
		foreach ( (array) $cats as $cat ) {
			// Handle each category.

			// Display the category name
			echo '	<li id="linkcat-' . $cat->cat_ID . '" class="linkcat"><h4>' . $cat->cat_name . "</h4>\n\t<ul>\n";
			// Call get_links() with all the appropriate params
			get_links($cat->cat_ID, '<li>', "</li>", "\n", true, 'name', false);

			// Close the last category
			echo "\n\t</ul>\n</li>\n";
		}
	}
}


require_once( dirname(__FILE__).'/widgets.php' );
require_once( dirname(__FILE__).'/miniwidgets.php' );

if( function_exists( 'get_theme_option' ) && get_theme_option('custom_path') != null )
{
	$d=dirname(__FILE__) . "/" . get_theme_option('custom_path');
	if( file_exists( $d ) )
	{
		$dir = opendir($d);
		while ($f = readdir($dir)) { 
			$matches = null;
			if (eregi("(.*)\.css.php",$f,$matches)) { 
				continue;
			}
			$matches = null;
			if (eregi("(.*)\.php",$f,$matches)) { 
				include( $d . '/' . $f );
			}
		}
	}
}

function customstyles() {
	if( function_exists( 'get_theme_option' ) && get_theme_option('custom_path') != null )
	{
		$d=dirname(__FILE__) . "/" . get_theme_option('custom_path');
		if( file_exists( $d ) )
		{
			$dir = opendir($d);
			$iefiles = array();
			while ($f = readdir($dir)) { 
				$matches = null;
				if( preg_match('|\.css(\.php)?|', $f) ) {
					$url = get_stylesheet_directory_uri() . '/' . get_theme_option('custom_path') . '/' . $f; 
					if( preg_match('|\-ie\.css(\.php)?|', $f) ) {
						$iefiles[] = $url;
					}
					else {
						?><link rel="stylesheet" href="<?php echo $url ?>" type="text/css" /><?php
					}
				}
			}
			foreach( $iefiles as $url ) {
				?><!--[if lte IE 6]><?php
				?><link rel="stylesheet" href="<?php echo $url ?>" type="text/css" media="screen" /><?php
				?><![endif]--><?php
			}
		}
	}
}

add_action('wp_head', 'customstyles');


function vl_widget_count($index = 1) {
	global $wp_registered_sidebars, $wp_registered_widgets;

	if( $wp_registered_sidebars ) {
		if ( is_int($index) ) {
			$index = "sidebar-$index";
		} else {
			$index = sanitize_title($index);
			foreach ( $wp_registered_sidebars as $key => $value ) {
				if ( sanitize_title($value['name']) == $index ) {
					$index = $key;
					break;
				}
			}
		}
	
		$sidebars_widgets = wp_get_sidebars_widgets();
	
		if ( empty($wp_registered_sidebars[$index]) || !is_array($sidebars_widgets[$index]) || empty($sidebars_widgets[$index]) )
			return false;
		return count($sidebars_widgets[$index]);
	}

	global $registered_sidebars, $registered_widgets;

	if( $registered_sidebars ) {
		if ( is_int($index) ) {
			$index = sanitize_title('Sidebar ' . $index);
		} else {
			$index = sanitize_title($index);
		}
	
		$sidebars_widgets = get_option('sidebars_widgets');
	
		$sidebar = $registered_sidebars[$index];
	
		if ( empty($sidebar) || !is_array($sidebars_widgets[$index]) || empty($sidebars_widgets[$index]) )
			return false;
		return count($sidebars_widgets[$index]);
	}	
	return false;
}

function vl_add_styles( $styles ) {
	if( !function_exists( 'blogskinstyles' ) ) {
		$url = get_stylesheet_directory_uri() . '/skins/default/style.css.php';
		if( function_exists( 'add_presentationtoolkit_skin_query' ) ) {
			$url = add_presentationtoolkit_skin_query( 'Default', $url );
		}
		$styles[] = $url;
	}
	return $styles;
}

function vl_add_styles_ie( $styles ) {
	if( !function_exists( 'blogskinstyles' ) ) {
		$ieurl = get_stylesheet_directory_uri() . '/skins/default/style-ie.css.php?skin=default';
		if( function_exists( 'add_presentationtoolkit_skin_query' ) ) {
			$ieurl = add_presentationtoolkit_skin_query( 'Default', $ieurl );
		}
		$styles[] = $ieurl;
	}
	return $styles;
}

function vl_add_extra_css( $css ) {
	$font = vl_get_theme_option('font-family', '"verdana", sans-serif' );
	$size = vl_get_theme_option('font-size', '14px');
	$css = <<<VL_EOD
.mceContentBody {
	font-family: $font;
	font-size: $size; 
}
VL_EOD;
	return $css;
}

add_action( 'real_wysiwyg_style_sheets', 'vl_add_styles' );
add_action( 'real_wysiwyg_style_sheets_ie', 'vl_add_styles_ie' );
add_action( 'real_wysiwyg_extra_css', 'vl_add_extra_css' );

?>
