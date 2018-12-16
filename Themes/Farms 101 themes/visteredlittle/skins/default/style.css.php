<?php
/*  
Skin Name: Default
Skin URI: http://windyroad.org/software/wordpress/vistered-little-theme
Description: Translucent skin with adjustable width and tone.
Version:
Author:Windy Road &amp; Nik Iliadis
Author URI: http://windyroad.org/
*/

$width = "wide";
if( isset( $_REQUEST[ 'width' ] ) ) 
{
	$width = $_REQUEST[ 'width' ];
}
$tone = "dark";
if( isset( $_REQUEST[ 'tone' ] ) ) 
{
	$tone = $_REQUEST[ 'tone' ];
}


$timestamp = filemtime( __FILE__ );
$timestamp = gmdate('D, d M Y H:i:s T', $timestamp);
$etag = md5(__FILE__ . $width . $tone ); 

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

?>
.header_content {
	background-image: url('<?php echo $tone; ?>_background.png'); 
}

.header_bottom {
	background-image: url('<?php echo $tone; ?>_header_bottom.png'); 
}

.menu {	background-image: url('<?php echo $tone; ?>_menubackground.png'); }
	
	.quadbar .topmenugroup .menu, 
	.quadbar .bottommenugroup .menu { 
		background-image: url('narrow_<?php echo $tone; ?>_blogbackground.png'); 
	}
/*
	.quadbar .middlemenugroup { 
		background: url('<?php echo $tone; ?>_quadmenubackground.png') top center repeat-y;
	}

	.quadbar .middlemenugroup-before { 
		background: url('<?php echo $tone; ?>_quadmenutop.png') top center repeat-y;
	}

	.quadbar .middlemenugroup-after { 
		background: url('<?php echo $tone; ?>_quadmenubottom.png') top center repeat-y;
	}
*/

.menubefore { background-image: url('<?php echo $tone; ?>_menutop.png'); }

	.quadbar .topmenugroup .menubefore,
	.quadbar .bottommenugroup .menubefore {
		background-image: url('narrow_<?php echo $tone; ?>_blogtop.png'); 
	}

.menuafter { background-image: url('<?php echo $tone; ?>_menubottom.png'); }

	.quadbar .topmenugroup .menuafter,
	.quadbar .bottommenugroup .menuafter {
		background-image: url('narrow_<?php echo $tone; ?>_blogbottom.png');
	}

#thumbs.framed img {
	background: url('<?php echo $tone; ?>_thumbframe.png');
	border: none;
}

#thumbs.framed img:hover,
#thumbs.framed img.selected {
	background: url('<?php echo $tone; ?>_thumbframe_hover.png');
}


<?php
if( $width == 'wide' )
{
?>
#bodyowner,
.banner .blogbefore .middle, 
.banner .blogafter .middle {
	width: 964px;
}

	.quadbar #bodyowner,
	.quadbar .banner .blogbefore .middle, 
	.quadbar .banner .blogafter .middle {
		width: 1224px;
	}

.banner .post {
	width: 894px;
}

	.quadbar .banner .post {
		width: 1154px;
	}

#contentcontainer {
	width: 716px;
}
	
#contentcontainer .post,
.mceContentBody {
	width: 646px;
}

#contentcontainer .blogbefore .middle,
#contentcontainer .blogafter .middle {
	width: 716px;
}

<?php
}

if( $width == "flex" )
{
?>
#header,
.quadbar #header{
	min-width: 800px;
}

#bodyowner,
.quadbar #bodyowner
{
	width: auto;
	min-width: 800px;
	max-width: 1400px;
}

#menucontainer
{
	float: right;
	margin-left: -233px;
}

	.quadbar #menucontainer
	{
		margin-left: -492px;
	}

	
#contentcontainer
{
	width: auto;
	margin-right: 233px;
}

	.quadbar #contentcontainer
	{
		margin-right: 492px;
	}

.banner .blogbefore,
.banner .blogafter {
	background: url('<?php echo $tone; ?>_middle.png') repeat-x;
	height: 58px;
	margin: 0px 35px;
	overflow: visible;
}

.banner .blogbefore .middle, 
.banner .blogafter .middle,
.quadbar .banner .blogbefore .middle,
.quadbar .banner .blogafter .middle 
{
	background: none;
}

.banner .post,
.quadbar .banner .post
{
	width: auto;
	overflow: visible;
	background: url('<?php echo $tone; ?>_background.png') repeat;
	margin: -25px 28px;
	position: relative;
	padding: 0px 7px;
	min-height: 29px;
}

#contentcontainer .blogbefore,
#contentcontainer .blogafter {
	background: url('<?php echo $tone; ?>_middle.png') repeat-x;
	height: 58px;
	margin: 0px 35px;
	overflow: visible;
}

#contentcontainer .blogbefore {
	margin-top: 10px;
}

#contentcontainer .blogbefore .middle, 
#contentcontainer .blogafter .middle
{
	width: auto;
}


.blogbefore .left, .blogbefore .right,
.blogafter .left, .blogafter .right
{
	height: 58px;
	width: 35px;
	margin-bottom: -33px;
	overflow: visible;
}

.blogbefore .left,
.blogafter .left
{
	float: left;
	background: url('<?php echo $tone; ?>_left.png') no-repeat;
	margin-left: -35px;
}

.blogbefore .right,
.blogafter .right
{
	float: right;
	background: url('<?php echo $tone; ?>_right.png') no-repeat;
	margin-right: -35px;
}

#contentcontainer .post,
.mceContentBody
{
	width: auto;
	overflow: visible;
	background: url('<?php echo $tone; ?>_background.png') repeat;
	margin: -25px 28px;
	position: relative;
	padding: 0px 7px;
	min-height: 29px;
	text-align: left;
}

#contentcontainer p,
.mceContentBody p {
	width: 100%;
	margin: 0px;
	margin-right: auto;
}

#contentcontainer div.headertext,
.mceContentBody div.headertext {
	width: auto;
	margin: 0px;
}

#contentcontainer .footeritems,
#contentcontainer p.postlinks, 
#contentcontainer p.credits,
.mceContentBody .footeritems,
.mceContentBody p.postlinks,
.mceContentBody p.credits {
	width: auto;
	margin: 0px;
	display: block;
}

#contentcontainer #commentform p,
.mceContentBody #commentform p {
	width: auto;
	margin: auto;
	text-align: center;
}
<?php
}
else {
?>

.banner .post { 
	background-image: url('<?php echo $width; ?>_<?php echo $tone; ?>_bannerbackground.png'); 
}

	.quadbar .banner .post { 
		background-image: url('<?php echo $width; ?>_<?php echo $tone; ?>_quadbarbannerbackground.png'); 
	}

#contentcontainer .post,
.mceContentBody {
	background-image: url('<?php echo $width; ?>_<?php echo $tone; ?>_blogbackground.png'); 
}

.banner .blogbefore .middle { 
	background-image: url('<?php echo $width; ?>_<?php echo $tone; ?>_bannertop.png'); 
}

	.quadbar .banner .blogbefore .middle { 
		background-image: url('<?php echo $width; ?>_<?php echo $tone; ?>_quadbarbannertop.png'); 
	}

#contentcontainer .blogbefore .middle {
	background-image: url('<?php echo $width; ?>_<?php echo $tone; ?>_blogtop.png');
}

.banner .blogafter .middle { 
	background-image: url('<?php echo $width; ?>_<?php echo $tone; ?>_bannerbottom.png'); 
}

	.quadbar .banner .blogafter .middle { 
		background-image: url('<?php echo $width; ?>_<?php echo $tone; ?>_quadbarbannerbottom.png'); 
	}

#contentcontainer .blogafter .middle { 
	background-image: url('<?php echo $width; ?>_<?php echo $tone; ?>_blogbottom.png');
}
<?php
}

if( $tone == 'light' ) {
?>
body {
	color: #222;
}

a:link, a:active, a:visited {
	color: #00cd52;
}

a:hover	{
	color: #000;
}

#contentcontainer h1 a,
.mceContentBody h1 a,
#menucontainer h4,
#wp-calendar caption,
.comment-author a,
#footer h4 {
	color: #3ba6e4;
}

#header h1 a:link, #header h1 a:active, #header h1 a:visited, #header h1 a:hover,
div.blogtitle a:link, div.blogtitle a:active, div.blogtitle a:visited, div.blogtitle a:hover {
	color: #333;
}

#thumbs img, pre, #s, #comment, #namefield input, #emailfield input, #urlfield input, .reply {
	border: 1px dotted #777;
}

#thumbs.framed img {
	border: none;
}

.post blockquote {
    border: 1px dotted #3ba6e4;
}

#contentcontainer div.headertext,
.mceContentBody div.headertext {
	color: #555;
	border-bottom: 1px dotted #777;
}

body {
	color:#555;
}

.footeritems {
	color: #555;
	border-top: 1px dotted #777;	
}

#s,
#contentcontainer h1,
.mceContentBody h1, 
#comment, #namefield input, 
#emailfield input, #urlfield input {
	color: #111;
}
<?php
}
else {
?>

body {
	color: #ccc;
}

a:link, a:active, a:visited {
	color: #eaab02;
}

a:hover	{
	color: #fff;
}

#contentcontainer h1 a,
.mceContentBody h1 a,
#menucontainer h4,
#wp-calendar caption,
.comment-author a,
#footer h4 {
	color: #3ba6e4;
}

#header h1 a:link, #header h1 a:active, #header h1 a:visited, #header h1 a:hover,
div.blogtitle a:link, div.blogtitle a:active, div.blogtitle a:visited, div.blogtitle a:hover {
	color: #ddd;
}

#thumbs img, pre, #s, #comment, #namefield input, #emailfield input, #urlfield input, .reply {
	border: 1px dotted #777;
}

#thumbs.framed img {
	border: none;
}

.post blockquote {
    border: 1px dotted #3ba6e4;
}

#contentcontainer div.headertext,
.mceContentBody div.headertext {
	color: #eee;
	border-bottom: 1px dotted #777;
}

.footeritems {
	color: #eee;
	border-top: 1px dotted #777;	
}

#s, #contentcontainer h1, .mceContentBody h1, #comment, #namefield input, #emailfield input, #urlfield input {
	color: #bbb;
}

<?php
}
?>