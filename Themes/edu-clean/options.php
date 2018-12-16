<?php

global $options, $options4, $options5, $options6, $options7, $options8, $options9;

foreach ($options as $value) {
if (get_settings( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_settings( $value['id'] ); } }


foreach ($options4 as $value) {
if (get_settings( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_settings( $value['id'] ); } }

foreach ($options5 as $value) {
if (get_settings( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_settings( $value['id'] ); } }

foreach ($options6 as $value) {
if (get_settings( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_settings( $value['id'] ); } }

foreach ($options7 as $value) {
if (get_settings( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_settings( $value['id'] ); } }

foreach ($options8 as $value) {
if (get_settings( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_settings( $value['id'] ); } }

foreach ($options9 as $value) {
if (get_settings( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_settings( $value['id'] ); } }


//////////////////////////////////////////////
//////check platform/////////////////////////
//////////////////////////////////////////////
if (function_exists("is_site_admin")) {
$mu = true;
} else {
$mu = false;
}
if($mu == "true") {
global $blog_id;
define( 'ABSPATH', dirname(__FILE__) . '/' );
$gallery_folder = "thumbs";
$upload_path = ABSPATH . 'wp-content/blogs.dir/' . $blog_id . "/" . $gallery_folder . "/";
$ttpl_url = get_bloginfo('wpurl');
$ttpl_path = $ttpl_url . "/" . "wp-content/blogs.dir/" . $blog_id . "/" . $gallery_folder;

} else {

define( 'ABSPATH', dirname(__FILE__) . '/' );
$gallery_folder = "thumbs";
$upload_path = ABSPATH . 'wp-content/' . $gallery_folder . "/"; // The path to where the image will be saved
$ttpl_url = get_bloginfo('wpurl');
$ttpl_path = $ttpl_url . "/" . "wp-content/" . $gallery_folder;
}


?>