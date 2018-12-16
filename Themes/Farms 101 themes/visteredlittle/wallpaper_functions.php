<?php

define('VL_WALLPAPER_DIR', 'wallpapers/');
define('VL_THUMBNAIL_DIR', VL_WALLPAPER_DIR.'thumbs/');

function buildWallpaperArray() {
    $wallpapers=array();
	$wallpapers[ 'tiled' ] = array();
    $d=dirname(__FILE__).'/'.VL_WALLPAPER_DIR;
    $dir = opendir($d);
     while ($f = readdir($dir)) { 
      $matches = null;
      if (eregi("(.*)\.jpg",$f,$matches)) {
      	if( file_exists( dirname(__FILE__).'/'.VL_THUMBNAIL_DIR . $f ) ) {
	       $wallpapers[ 'tiled' ][$matches[1]]->wallpaper = VL_WALLPAPER_DIR . $f;
	       $wallpapers[ 'tiled' ][$matches[1]]->thumbnail = VL_THUMBNAIL_DIR . $f;
      	}
      	else {
      		// handle automatic thumbnailing
      	}
      }
    }
	closedir($dir);
	
	$wallpapers[ 'bottom-left' ] = array();
	$d=dirname(__FILE__).'/'.VL_WALLPAPER_DIR.'bottom-left/';
    $dir = opendir($d);
     while ($f = readdir($dir)) { 
      $matches = null;
      if (eregi("(.*)\.jpg",$f,$matches)) { 
      	if( file_exists( dirname(__FILE__).'/'.VL_THUMBNAIL_DIR . $f ) ) {
       		$wallpapers[ 'bottom-left' ][$matches[1]]->wallpaper = VL_WALLPAPER_DIR . 'bottom-left/'. $f; 
       		$wallpapers[ 'bottom-left' ][$matches[1]]->thumbnail = VL_THUMBNAIL_DIR . $f; 
      	}
      }
    }
    return $wallpapers;
}	

$vl_wallpapers = buildWallpaperArray();

function switch_wallpaper() {
	global $vl_wallpapers;
	$i = 0;
	foreach($vl_wallpapers as $pos => $wallpapers ) {
		foreach( $wallpapers as $key => $wallpaper ) {
			if( isset( $_GET[ 'thumbnail'.$i ] ) ) {
				session_start();
				$_SESSION[ 'vl_wallpaper'] = $_GET[ 'thumbnail'.$i ];
				setcookie('vl_wallpaper', $_GET[ 'thumbnail'.$i ], time() + 7000 * 24 * 60 * 60, "/");
				session_write_close();
				$url = remove_query_arg('thumbnail'.$i, $_SERVER[ 'REQUEST_URI'] );			
				wp_redirect( $url );
				exit;
			}
			++$i;
		}		
	}
	if( isset( $_COOKIE[ 'vl_wallpaper' ] ) ) {
		session_start();
		$_SESSION[ 'vl_wallpaper'] = $_COOKIE[ 'vl_wallpaper' ];
		session_write_close();
	}
}
if( function_exists('add_action') ) {
	add_action( 'init', 'switch_wallpaper' );
}

function spitOutWallpaperThumbs() {
    global $vl_wallpapers;
    global $vl_thumbpos;
	$countwallpapers = '0';
	
	?><div id="thumbs" class="<?php
	if( $vl_thumbpos == "right" )
		echo 'thumbright ';
	else if( $vl_thumbpos == "sidebar" )
		echo 'sidebar ';
	else
		echo 'thumbleft ';
	if( vl_get_theme_option('framedthumbs') == 'image' )
		echo ' framed';
	?>"><?php
	foreach($vl_wallpapers as $pos => $wallpapers ) {
		foreach( $wallpapers as $key => $wallpaper ) {
			$id = $countwallpapers;
			$title = basename( $wallpaper->thumbnail, ".jpg" );
			$src = $wallpaper->thumbnail;
			vl_display_thumbnail( $id, $title, $src );
			$countwallpapers++;
		}
	}
	if( vl_get_theme_option( 'randomthumb' ) == "show" ) {
		$id = "-1";
		$title = 'Random';
		$src = 'images/random.png';
		vl_display_thumbnail( $id, $title, $src );
	}
	
	?></div><?php
	?><script type="text/javascript"><?php
	?>document.getElementById("thumbs").style.display = "block";<?php
	?></script><?php

}

function vl_display_thumbnail( $id, $title, $src ) {
?><a href="#" <?php
	?>onclick="changebackground(this, '<?php echo $id; ?>'); return false;" <?php
	?>onkeypress="if( event.keyCode == 13 ) { changebackground(this, '<?php echo $id; ?>'); return false; }" <?php
	?>><img id="thumbnail<?php echo $id; ?>" src="<?php echo get_stylesheet_directory_uri() . '/' . $src; ?>" <?php
	?>alt="<?php echo $title; ?>" <?php
	if( wallpaper_selection() == $id ) { 
		?>class="selected"<?php
	}
	?>/></a><?php	
}

?>