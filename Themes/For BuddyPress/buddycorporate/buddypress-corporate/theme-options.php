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
font-family: <?php echo $tn_buddycorp_body_font; ?>!important;
}

h1,h2,h3,h4,h5,h6 {
font-family: <?php echo $tn_buddycorp_headline_font; ?>!important;
}

<?php if(($tn_buddycorp_font_size == "normal") || ($tn_buddycorp_font_size == "")) { ?>
#wrapper, #footer { font-size: 0.6875em; }
<?php } elseif ($tn_buddycorp_font_size == "medium") { ?>
#wrapper, #footer { font-size: 0.75em; }
<?php } elseif ($tn_buddycorp_font_size == "bigger") { ?>
#wrapper, #footer { font-size: 0.875em; }
<?php } elseif ($tn_buddycorp_font_size == "largest") { ?>
#wrapper, #footer { font-size: 1em; }
<?php } ?>

.custom-img-header {
height: <?php echo $tn_buddycorp_image_height; ?>px!important;
}
