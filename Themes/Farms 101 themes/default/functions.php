<?php

$themecolors = array(
	'bg' => 'ffffff',
	'text' => '000000',
	'link' => '0060ff'
);

// No CSS, just IMG call

define('HEADER_TEXTCOLOR', '');
define('HEADER_IMAGE', '%s/images/header_1.jpg'); // %s is theme dir uri
define('HEADER_IMAGE_WIDTH', 970);
define('HEADER_IMAGE_HEIGHT', 140);
define( 'NO_HEADER_TEXT', true );

function cutline_admin_header_style() {
?>
<style type="text/css">
#headimg {
	height: <?php echo HEADER_IMAGE_HEIGHT; ?>px;
	width: <?php echo HEADER_IMAGE_WIDTH; ?>px;
}

#headimg h1, #headimg #desc {
	display: none;
}

</style>
<?php
}

if ( function_exists('register_sidebar') )
	register_sidebar(array('name' => 'Left Sidebar'));

if ( function_exists('register_sidebar') )
	register_sidebar(array('name' => 'Right Sidebar'));


add_custom_image_header('', 'cutline_admin_header_style');

?>
