<?php
/*
Plugin Name: Offload theme css and images to Amazon-S3
Plugin URI: http://www.ringofblogs.com
Description: 
Version: 0.1
Author: Elad Salomons
Author URI: http://wwww.ringofblogs.com
*/

$s3_bucket = 's3.domain.com';

function stylesheet_directory_uri_s3 ($stylesheet_dir_uri, $stylesheet) {
	global $blog_id, $site_id, $s3_bucket;
	if( $site_id == 1 && !in_array($blog_id, array(1)) ) {
		$stylesheet_dir_uri = 'http://' . $s3_bucket . '/wp-content/themes/'. $stylesheet;
	}
	return $stylesheet_dir_uri;
}

add_filter('stylesheet_directory_uri' , 'stylesheet_directory_uri_s3', 1, 2);

?>