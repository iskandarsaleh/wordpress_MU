<?php


require_once('../../../wp-config.php');
require_once( dirname(__FILE__) . '/functions.php');


/* only in member theme for calling functions.php
define( 'ABSPATH', dirname(__FILE__) . '/' );
$current_theme = get_current_theme();
$site_directory = ABSPATH . '/';
require_once($site_directory . 'wp-content/themes/' . $current_theme . '/functions.php');
*/

header("Content-type: text/css");



global $options;
foreach ($options as $value) {
if (get_settings( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_settings( $value['id'] ); } }
// wp theme option
?>



body {
font-family: <?php echo $tn_buddycom_body_font; ?>!important;
background: <?php if($tn_buddycom_bg_color == ""){ ?><?php echo "#E4E4E4"; } else { ?><?php echo $tn_buddycom_bg_color; ?><?php } ?><?php if($tn_buddycom_bg_image == "") { ?><?php } else { ?> url(<?php echo $tn_buddycom_bg_image; ?>)<?php } ?> <?php echo $tn_buddycom_bg_image_repeat; ?> <?php echo $tn_buddycom_bg_image_attachment; ?> <?php echo $tn_buddycom_bg_image_horizontal; ?> <?php echo $tn_buddycom_bg_image_vertical; ?>
!important;
}

h1,h2,h3,h4,h5,h6 {
font-family: <?php echo $tn_buddycom_headline_font; ?>!important;
}