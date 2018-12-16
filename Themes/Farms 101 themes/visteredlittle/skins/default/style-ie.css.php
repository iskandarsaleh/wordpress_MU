<?php

$path = dirname( $_SERVER[ 'SCRIPT_NAME' ] ) . 	"/";

$width = "wide_";
if( isset( $_REQUEST[ 'width' ] ) ) 
{
	$width = $_REQUEST[ 'width' ] . '_';
}
$tone = "dark_";
if( isset( $_REQUEST[ 'tone' ] ) ) 
{
	$tone = $_REQUEST[ 'tone' ] . '_';
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
#contentcontainer ul li,
.mceContentBody ul li,
.menu p.links a, .menu ul li,
ul#links li li {
	background-image: url('star.gif');
}


#menucontainer h4,
#wp-calendar caption,
#footer h4 { 
	background-image: url('bigstar.gif'); 
}

#contentcontainer, .mceContentBody { 
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

#thumbs.framed img {
	background-image: none;
	filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true, src=<?php echo $path . $tone; ?>thumbframe.png, sizingMethod=scale);
}

#thumbs.framed img:hover,
#thumbs.framed img.selected {
	background-image: none;
	filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true, src=<?php echo $path . $tone; ?>thumbframe_hover.png, sizingMethod=scale);
}

.header_content { 
	background-image: none;
	filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true, src=<?php echo $path . $tone; ?>background.png, sizingMethod=scale);
}

.header_bottom { 
	background-image: none;
	filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true, src=<?php echo $path . $tone; ?>header_bottom.png, sizingMethod=scale);
}

.menu {
	background-image: none;
	filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true, src=<?php echo $path . $tone; ?>menubackground.png, sizingMethod=scale);
}


.menubefore {
	background-image: none;
	filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true, src=<?php echo $path . $tone; ?>menutop.png, sizingMethod=scale);
}

.menuafter {
	background-image: none;
	filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true, src=<?php echo $path . $tone; ?>menubottom.png, sizingMethod=scale);
}


<?php
if( $width == "flex_" )
{
?>

.banner .blogbefore,
.banner .blogafter {
	background: none;
	filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true, src=<?php echo $path . $tone; ?>middle.png, sizingMethod=scale);
	overflow: hidden;
}


.banner .post,
.quadbar .banner .post {
	background: white;
	filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true, src='<?php echo $path . $tone; ?>background.png', sizingMethod=scale); 
	z-index: 10;
}

#contentcontainer .blogbefore,
#contentcontainer .blogafter {
	background-image: none;
	filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true, src=<?php echo $path . $tone; ?>middle.png, sizingMethod=scale);
	overflow: hidden;
}

.blogbefore .left,
.blogafter .left
{
	background-image: none;
	filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true, src=<?php echo $path . $tone; ?>left.png, sizingMethod=scale);
	margin: 0px;
	position: relative;
	right: 35px;
}

.blogbefore .right,
.blogafter .right
{
	background-image: none;
	filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true, src=<?php echo $path . $tone; ?>right.png, sizingMethod=scale);
	margin: 0px;
	position: relative;
	left: 35px;
}

#contentcontainer .post,
.mceContentBody .post,
.quadbar #contentcontainer .post
{
	background: white;
	border: white solid 1px;
	/* don;t know why, but the filter 'aint working here any more, hence the white */
	filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true, src=<?php echo $path . $tone; ?>background.png, sizingMethod=scale);
	margin: -25px 0px;
	margin-left: 30px;
	margin-right: 40px;
	z-index: 10;
}

<?php
	if( $tone == 'dark_' ) {
	?>
	.banner .post,
	.quadbar .banner .post {
		background: black;
	}
	
	#contentcontainer .post,
	.mceContentBody .post,
	.quadbar #contentcontainer .post
	{
		background: black;
		border: solid black 1px;
	}
<?php
	}
}
else {
?>

.banner .post { 
	background: none;
	filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true, src=<?php echo $path . $width . $tone; ?>bannerbackground.png, sizingMethod=scale); 
}

	.quadbar .banner .post { 
		background-image: none; 
		filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true, src='<?php echo $path . $width . $tone; ?>quadbarbannerbackground.png', sizingMethod=scale); 
	}

.banner .blogbefore .middle {
	background-image: none;
	filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true, src=<?php echo $path . $width . $tone; ?>bannertop.png, sizingMethod=scale);
}

	.quadbar .banner .blogbefore .middle {
		background-image: none;
		filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true, src='<?php echo $path . $width . $tone; ?>quadbarbannertop.png', sizingMethod=scale);
	}

.banner .blogafter .middle {
	background-image: none;
	filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true, src=<?php echo $path . $width . $tone; ?>bannerbottom.png, sizingMethod=scale); 
}

	.quadbar .banner .blogafter .middle {
		background-image: none;
		filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true, src='<?php echo $path . $width . $tone; ?>quadbarbannerbottom.png', sizingMethod=scale); 
	}

#contentcontainer .post,
.mceContentBody .post { 
	background-image: none;
	filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true, src=<?php echo $path . $width . $tone; ?>blogbackground.png, sizingMethod=scale); 
}

#contentcontainer .blogbefore .middle {
	background-image: none;
	filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true, src=<?php echo $path . $width . $tone; ?>blogtop.png, sizingMethod=scale);
}

#contentcontainer .blogafter .middle {
	background-image: none;
	filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true, src=<?php echo $path . $width . $tone; ?>blogbottom.png, sizingMethod=scale); 
}



<?php
}
?>

	.quadbar .topmenugroup .menu, 
	.quadbar .bottommenugroup .menu { 
		background-image: none;
		filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true, src=<?php echo $path . 'narrow_' . $tone; ?>blogbackground.png, sizingMethod=scale);
	}

	.quadbar .topmenugroup .menubefore,
	.quadbar .bottommenugroup .menubefore {
		background-image: none;
		filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true, src=<?php echo $path . 'narrow_' . $tone; ?>blogtop.png, sizingMethod=scale);
	}

	.quadbar .topmenugroup .menuafter,
	.quadbar .bottommenugroup .menuafter {
		background-image: none;
		filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true, src=<?php echo $path . 'narrow_' . $tone; ?>blogbottom.png, sizingMethod=scale);
	}

.page_item ul {
	display: block;
}
