<?php
require_once( dirname(__FILE__) . '../../../../wp-config.php');
require_once( dirname(__FILE__) . '/functions.php');
header("Content-type: text/css");

global $options;

foreach ($options as $value) {
	if (get_settings( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_settings( $value['id'] ); } }
?>

body {
	font-family: <?php echo $oc_om_body_font; ?>;
	font-size: <?php echo $oc_om_body_font_size; ?>;
}

h1, h2, h3, h4, h5, h6 {
   font-family: <?php echo $oc_om_headline_font; ?>!important;
}

#rotateimg { height: <?php echo $oc_om_image_height; ?>px!important; }