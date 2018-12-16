<?php
/*
This file is part of the Wordpress Plugin "Who Sees Ads" version 2.0
It contains personal and custom settings for *ADVANCED* users.
See http://planetozh.com/blog/my-projects/wordpress-plugin-who-sees-ads-control-adsense-display/
*/

/******************************************************************************
 * Copy my_options_sample.php to my_options.php then edit to suit your needs. *
 * Disclaimer: use this file if you know what it implies. You're on your own. * 
 ******************************************************************************/

/* Where to add the "Who Sees Ads" submenu ? */
 $wp_ozh_wsa['my_menu'] = 'wpmu-admin.php';

/* Override the ['iknowphp'] variable */
// $wp_ozh_wsa['my_iknowphp'] = false;

/* Height of textarea for pasting code in. Must be a proper CSS value */
// $wp_ozh_wsa['my_codetextarea'] = '220px';

/* Support for multiple code in a single context, to be randomly picked (rotated) */
// $wp_ozh_wsa['my_rotatecode_separator'] = '**** ROTATE ****'

/* List of custom search engines. Overrides, does not add to original list */
// $wp_ozh_wsa['my_search_engines'] = array('/search?', 'images.google.', 'web.info.com', 'search.', 'del.icio.us/search', 'soso.com', '/search/', '.yahoo.', );

/* List of standard context conditions. Feel free to remove the one you'll never use. */
// $wp_ozh_wsa['my_conditions'] = array ('fromSE', 'regular', 'olderthan', 'logged', 'date', 'numviews', 'readerviews', 'fallback', 'any',);

/* Disable widget support */
 $wp_ozh_wsa['my_widgets'] = false;

/* Disable additional buttons in the "Write Post / Page" interface */
 $wp_ozh_wsa['my_wsa-buttons'] = false;

?>