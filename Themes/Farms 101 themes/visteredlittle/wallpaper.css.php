<?php

require_once( 'wallpaper_functions.php' );
 
 function spitOutWallpaperCSS() {
    global $vl_wallpapers;
	$countwallpapers = 0;
	foreach($vl_wallpapers as $format => $sub_wallpapers) {
		foreach($sub_wallpapers as $name => $wallpaper) {
			print "#wallpaper" . $countwallpapers . " { background-image: url('";
			print $wallpaper->wallpaper . "');";
			if( $format == 'bottom-left' )
			{
				print "background-repeat:no-repeat;background-position: bottom left;";
			}
			print "}\n";
			$countwallpapers++;
	    }
	}
}

$timestamp = filemtime( __FILE__ );
$timestamp = gmdate('D, d M Y H:i:s T', $timestamp);
global $vl_wallpapers;
$etag = md5(__FILE__ . $vl_wallpapers ); 

if( isset( $_SERVER[ 'HTTP_IF_NONE_MATCH' ] ) 
	&& $_SERVER[ 'HTTP_IF_NONE_MATCH' ] == $etag
	&& isset( $_SERVER[ 'HTTP_IF_MODIFIED_SINCE' ] )
	&& $_SERVER[ 'HTTP_IF_MODIFIED_SINCE' ] == $timestamp ) {
	header('HTTP/1.1 304 Not Modified');
	header('Status: 304 Not Modified');
	header('ETag: ' . $etag );
	exit;	
}

header('ETag: ' . $etag );
header('Content-type: text/css'); 
header('Last-Modified: ' . $timestamp );

spitOutWallpaperCSS();

?>