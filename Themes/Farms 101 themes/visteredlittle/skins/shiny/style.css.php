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

$skin = "shiny";

// why is this a php file and not just a css file, well
// themes.wordpress.net doesn't like having multiple files called style.css
// within a theme.  Doesn't like it one little bit.

?>
/*  
Skin Name: Shiny
Skin URI: http://windyroad.org/software/wordpress/vistered-little-theme
Description: Oooh... shiny.
Version: 
Author: Nik Iliadis & Windy Road
Author URI: http://scarylittlemonkey.com/
*/

/* Shiny theme. */
.header_content { background-image: url('background.png'); }
.header_bottom { background-image: url('header_bottom.png'); }

.banner .post { 
	background-image: url('bannerbackground.png'); 
}

	.quadbar .banner .post { 
		background-image: url('quadbarbannerbackground.png'); 
	}

#contentcontainer .post,
.mceContentBody {
	background-image: url('blogbackground.png'); 
}

.banner .blogbefore .middle { 
	background-image: url('bannertop.png'); 
}

	.banner .blogbefore .middle { 
		background-image: url('quadbarbannertop.png'); 
	}

#contentcontainer .blogbefore .middle { 
	background-image: url('blogtop.png');
}

.banner .blogafter .middle { 
	background-image: url('bannerbottom.png'); 
}

	.quadbar .banner .blogafter .middle { 
		background-image: url('quadbarbannerbottom.png'); 
	}

#contentcontainer .blogafter .middle { 
	background-image: url('blogbottom.png');
}

.menu {	background: url('menubackground.png'); }

	.quadbar .topmenugroup .menu, 
	.quadbar .bottommenugroup .menu { 
		background-image: url('blogbackground.png'); 
	}
/*
	.quadbar .middlemenugroup { 
		background: url('quadmenubackground.png') top center repeat-y;
	}

	.quadbar .middlemenugroup-before { 
		background: url('quadmenutop.png') top center repeat-y;
	}

	.quadbar .middlemenugroup-after { 
		background: url('quadmenubottom.png') top center repeat-y;
	}
*/

.menubefore { background: url('menutop.png') bottom center no-repeat; }

	.quadbar .topmenugroup .menubefore,
	.quadbar .bottommenugroup .menubefore {
		background-image: url('blogtop.png'); 
	}
	
.menuafter { background: url('menubottom.png') top center no-repeat; }

	.quadbar .topmenugroup .menuafter,
	.quadbar .bottommenugroup .menuafter {
		background-image: url('blogbottom.png');
	}
	
#thumbs.framed img {
	background: url('thumbframe.png');
}

#thumbs.framed img:hover,
#thumbs.framed img.selected {
	background: url('thumbframe_hover.png');
}

body {
	color: #000;
}

a:link, a:active, a:visited {
	color: #174E19;
}

a:hover	{
	color: #359B38;
}

#contentcontainer h1 a,
.mceContentBody h1 a,
#menucontainer h4,
#wp-calendar caption,
.comment-author a,
#footer h4 {
	color: #000;
}

#header h1 a:link, #header h1 a:active, #header h1 a:visited, #header h1 a:hover,
div.blogtitle a:link, div.blogtitle a:active, div.blogtitle a:visited, div.blogtitle a:hover {
	color: #000;
}

#thumbs img, pre, #s, #comment, #namefield input, #emailfield input, #urlfield input, .reply {
	border: 1px dotted #111;
}

.post blockquote {
    border: 1px dotted #174E19;
}

#contentcontainer div.headertext,
.mceContentBody div.headertext {
	color: #111;
	border-bottom: 1px dotted #000;
}

.footeritems {
	color: #eee;
	border-top: 1px dotted #000;	
}

#s, #contentcontainer h1, .mceContentBody h1, #comment, #namefield input, #emailfield input, #urlfield input {
	color: #111;
}

.banner .blogbefore { margin-top: -25px; }

.blogbefore { margin: -20px 0px 0px 0px; }

.blogafter { margin: 0px; }

.menubefore { margin: -10px 0px 0px 0px; }

.menuafter { margin: 0px; }

	.quadbar .bottommenugroup { float: left; }

#header #thumbs  {
	margin-bottom: 5px;
}