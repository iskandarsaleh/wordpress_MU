<div id="menucontainer">
<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("160x600-vistered-little"); } ?>
<?php
if( !function_exists('get_theme_option')
	|| get_theme_option('quadpossidebar') != 'quad' ) {
	require_once( dirname(__FILE__).'/monosidebar.php' );
}
else {
	require_once( dirname(__FILE__).'/quadsidebar.php' );
}
?>
</div>