<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title><?php
		if( function_exists( 'is_tag' ) && is_tag() ) {
			UTW_ShowCurrentTagSet('tagsettextonly'); 
			echo ' ' . __('@', VL_DOMAIN) . ' ';
			bloginfo('name');
		}
		else if( is_category() || is_month() || is_day() || is_year() || is_author() ) {
			wp_title('',true); 
			echo ' ' . __('@', VL_DOMAIN) . ' ';
			bloginfo('name');
		}
		else if (is_search()) {
			echo( htmlspecialchars( stripslashes( $_GET['s'] ) ) );
			echo ' ' . __('@', VL_DOMAIN) . ' ';
			bloginfo('name');
		}
		else if ( is_page() ) {
			$id = 0;
			$parent;
			for( $parent = &get_post($id); $parent->post_parent != 0; $parent = &get_post($parent->post_parent) ) {
				echo $parent->post_title . ' &laquo; ';
			}
			echo $parent->post_title;
			echo ' ' . __('@', VL_DOMAIN) . ' ';
			bloginfo('name');			
		}
		else if (is_single() || is_page() || is_archive()) {
			wp_title('',true);
			echo ' ' . __('@', VL_DOMAIN) . ' ';
			bloginfo('name');
		} 
		else if (is_404()) {
			_e('Page not found', VL_DOMAIN );
			echo ' ' . __('@', VL_DOMAIN) . ' ';
			bloginfo('name');
		}
		else if( is_home() ) {
			bloginfo('name'); echo(' &raquo; '); bloginfo('description'); 
		}
		else {
			if( function_exists('g2_init')) {
				if (!defined('G2INIT')) {
					g2_init();
				}
				$g2data = GalleryEmbed::handleRequest();
				if( !empty( $g2data[ 'themeData' ]) ) {
					echo $g2data[ 'themeData' ][ 'item' ][ 'title' ];
					for( $i = count( $g2data[ 'themeData' ][ 'parents' ] ); $i > 0; --$i ) {
						if( $g2data[ 'themeData' ][ 'item' ][ 'id' ] != $g2data[ 'themeData' ][ 'parents' ][ $i-1 ][ 'id'] ) {
							?> &laquo; <?php
							echo $g2data[ 'themeData' ][ 'parents' ][$i- 1 ][ 'title' ];
						}
					}
					echo ' ' . __('@', VL_DOMAIN) . ' ';
					bloginfo('name');
				}
				GalleryEmbed::done();
			}
			else {
				bloginfo('name'); echo(' &raquo; '); bloginfo('description'); 		
			}				
		}
		?></title><?php
?><link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" /><?php
vl_bloglogostyle();
if( !function_exists( 'blogskinstyles' ) ) {
	$url = get_stylesheet_directory_uri() . '/skins/default/style.css.php';
	$ieurl = get_stylesheet_directory_uri() . '/skins/default/style-ie.css.php?skin=default';
	if( function_exists( 'add_presentationtoolkit_skin_query' ) ) {
		$url = add_presentationtoolkit_skin_query( 'Default', $url );
		$ieurl = add_presentationtoolkit_skin_query( 'Default', $ieurl );
	}
?>
<link rel="stylesheet" href="<?php echo $url; ?>" type="text/css" media="screen" />
<!--[if lte IE 6]>
<link rel="stylesheet" href="<?php echo $ieurl; ?>" type="text/css" media="screen" />
<![endif]-->
<?php
}

if( menu_position_stylesheet_url() ) { ?>
<link rel="stylesheet" href="<?php bloginfo('template_directory'); print menu_position_stylesheet_url(); ?>" type="text/css" media="screen" />
<?php } ?>
<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/wallpaper.css.php" type="text/css" media="screen" />
<?php
if( function_exists('g2_init') ) {
	?><link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/wpg2.css" type="text/css" media="screen" /><?php
	?><link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/siriux.css" type="text/css" media="screen" /><?php
}?>
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="<?php bloginfo('description'); ?>" />
<?php
$theme = get_current_theme();
$ct = get_theme($theme);
?>

<?php
if( !function_exists('get_theme_option') || get_theme_option('headcredits') != 'remove' ) {
	?><link rel='theme' title='Vistered Little Theme' href='http://windyroad.org/software/wordpress/vistered-little-theme' /><?php
}
?>
 <script type="text/javascript">
 var vl_wallpaper_count = <?php global $vl_wallpapers; echo count( array_merge( $vl_wallpapers[ 'tiled'], $vl_wallpapers['bottom-left'] ) ); ?>;
 var vl_wallpaper_current = <?php echo wallpaper_selection(); ?>;
 var search_phrase = "<?php echo __('Search', VL_DOMAIN) . '...'; ?>";
 var search_label = "<?php _e('Type and press enter.', VL_DOMAIN); ?>";
 </script>
 <script src="<?php bloginfo('template_directory'); ?>/scripts/behaviour.js" type="text/javascript"></script>

<?php
wp_get_archives('type=monthly&format=link'); 
wp_head();
?>

</head>
<body id="<?php echo wallpaper_class();?>" class="<?php
if( !function_exists( 'get_theme_option' ) 
	|| get_theme_option('headerposition') != "normal" )
{
	echo " headerfixed";
}
if( function_exists( 'get_theme_option' ) 
	&& ( get_theme_option( 'thumbpos' ) == "sidebar"
		 || get_theme_option( 'thumbpos' ) == "none" )
	&& ( vl_get_bloglogodir() == null ) ) {
		echo " plainheader";
}
if( function_exists('get_theme_option') && get_theme_option('quadpossidebar') == 'quad' ) {
	echo " quadbar";
}
?>" style='font-family: <?php 
	echo vl_get_theme_option('font-family', '"verdana", sans-serif' );
?>; font-size: <?php
	echo vl_get_theme_option('font-size', '14px');
?>'><?php
?><div id="header"><?php
?><div class="header_content"><?php
if( !function_exists('get_theme_option')
	|| get_theme_option( 'headersearch' ) != "hide" )
{
?>
 <form method="get" id="searchform" action="<?php bloginfo('url'); ?>">
    <p class="right" id="search">
    <input type="text" value="<?php echo __('Search', VL_DOMAIN) . '...'; ?>" name="s" id="s" alt="Search"/><br />
    <label id="label" for="s"></label>
<?php
	if( function_exists( 'mfg_search_inputs' ) )
		mfg_search_inputs();
?>
    </p>
 </form>
<?php
}
if( is_single() || is_page() ) {
	?><div class="blogtitle" <?php
}
else { 
	?><h1 <?php
}
?>style='font-family: <?php 
	echo vl_get_theme_option('title-font-family', '"Trebuchet MS", sans-serif' );
?>; font-size: <?php
	echo vl_get_theme_option('font-size', '20px');
?>'><?php
?><a href="<?php bloginfo('url'); ?>" title="<?php _e( 'Go home.', VL_DOMAIN); ?>"><?php bloginfo('title'); ?></a><br /><?php  
if( is_single() || is_page() ) {
	echo '</div>';
}
else { 
	echo '</h1>';
}

if( headerThumbs() ) spitOutWallpaperThumbs(); ?>
<div style="clear: both;"></div>
</div>
<div class="header_bottom">
<div class="left"></div>
<div class="right"></div>
</div>
</div>
 <div id="bodyowner">

<?php
if( function_exists('dynamic_sidebar') ) {
	if ( vl_widget_count(__('Banner', VL_DOMAIN)) > 0 ) {
		?><div class="banner">
		<div class="blogbefore">
			<div class="left"></div>
			<div class="right"></div>
			<div class="middle"></div>
		</div><?php
		dynamic_sidebar(__('Banner', VL_DOMAIN));
		?><div class="blogafter">
	    	<div class="left"></div>
	    	<div class="right"></div>
	    	<div class="middle"></div>
		</div>
		</div><?php
	}
}
?>
