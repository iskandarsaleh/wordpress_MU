<?php

$timestamp = filemtime( __FILE__ );
$timestamp = gmdate('D, d M Y H:i:s T', $timestamp);
$etag = md5(__FILE__); 

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

$skin = "citrus";
$path = dirname( $_SERVER[ 'SCRIPT_NAME' ] );

?>
/* ie css hacks */
/* modified from the png hack provided by Christopher Walker */
/* special thanks to Christopher Walker (http://tibetanportal.com/) 
   for his contribution */

#contentcontainer ul li,
.mceContentBody ul li,
.menu p.links a, .menu ul li,
ul#links li li {
	background-image: url('star.gif');
}

.header_content { 
	background-image: none;
	filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true, src='<?php echo $path; ?>/background.png', sizingMethod=scale);
}

.header_bottom { 
	background-image: none;
	filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true, src='<?php echo $path; ?>/header_bottom.png', sizingMethod=scale);
}

.banner .post { 
	background: none;
	filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true, src='<?php echo $path; ?>/bannerbackground.png', sizingMethod=scale); 
}

	.quadbar .banner .post { 
		background-image: none; 
		filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true, src='<?php echo $path; ?>/quadbarbannerbackground.png', sizingMethod=scale); 
	}

.banner .blogbefore .middle {
	background-image: none;
	filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true, src='<?php echo $path; ?>/bannertop.png', sizingMethod=scale);
}

	.quadbar .banner .blogbefore .middle {
		background-image: none;
		filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true, src='<?php echo $path; ?>/quadbarbannertop.png', sizingMethod=scale);
	}

.banner .blogafter .middle {
	background-image: none;
	filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true, src='<?php echo $path; ?>/bannerbottom.png', sizingMethod=scale); 
}

	.quadbar .banner .blogafter .middle {
		background-image: none;
		filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true, src='<?php echo $path; ?>/quadbarbannerbottom.png', sizingMethod=scale); 
	}

#contentcontainer .post,
.mceContentBody { 
	background-image: none;
	filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true, src='<?php echo $path; ?>/blogbackground.png', sizingMethod=scale); 
}

#contentcontainer .blogbefore .middle {
	background-image: none;
	filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true, src='<?php echo $path; ?>/blogtop.png', sizingMethod=scale);
}

#contentcontainer .blogafter .middle {
	background-image: none;
	filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true, src='<?php echo $path; ?>/blogbottom.png', sizingMethod=scale); 
}

.menu {
	background-image: none;
	filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true, src='<?php echo $path; ?>/menubackground.png', sizingMethod=scale);
}

	.quadbar .topmenugroup .menu, 
	.quadbar .bottommenugroup .menu { 
		background-image: none;
		filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true, src='<?php echo $path; ?>/blogbackground.png', sizingMethod=scale);
	}

/*
	.quadbar .middlemenugroup { 
		background-image: none;
		filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true, src='<?php echo $path; ?>/quadmenubackground.png', sizingMethod=scale);
	}


	.quadbar .middlemenugroup .menu { 
		filter:none;	
	}

	.quadbar .middlemenugroup-before { 
		background-image: none;
		filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true, src='<?php echo $path; ?>/quadmenutop.png', sizingMethod=scale);
	}

	.quadbar .middlemenugroup-after { 
		background-image: none;
		filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true, src='<?php echo $path; ?>/quadmenubottom.png', sizingMethod=scale);
	}
*/
.menubefore {
	background-image: none;
	filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true, src='<?php echo $path; ?>/menutop.png', sizingMethod=scale);
}

	.quadbar .topmenugroup .menubefore,
	.quadbar .bottommenugroup .menubefore {
		background-image: none;
		filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true, src='<?php echo $path; ?>/blogtop.png', sizingMethod=scale);
	}

.menuafter {
	background-image: none;
	filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true, src='<?php echo $path; ?>/menubottom.png', sizingMethod=scale);
}

	.quadbar .topmenugroup .menuafter,
	.quadbar .bottommenugroup .menuafter {
		background-image: none;
		filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true, src='<?php echo $path; ?>/blogbottom.png', sizingMethod=scale);
	}



#menucontainer h4,
#wp-calendar caption,
#footer h4 { 
	background-image: url('bigstar.gif'); 
}

#contentcontainer { 
	padding-top: 0px;
}

body.headerfixed #header {
	position:absolute;
	top:expression(eval(document.documentElement.scrollTop));
	left:0px;
}

body.plainheader #header {
	margin-bottom: -57px;
}

body.headerfixed #bodyowner {
	padding-top: 137px;
}

body.headerfixed.plainheader #bodyowner {
	padding-top: 97px;
}

#thumbs.framed img{
	background-image: none;
	filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true, src='<?php echo $path; ?>/thumbframe.png', sizingMethod=scale);
}

#thumbs.framed img:hover,
#thumbs.framed img.selected {
	background-image: none;
	filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true, src='<?php echo $path; ?>/thumbframe_hover.png', sizingMethod=scale);
}

