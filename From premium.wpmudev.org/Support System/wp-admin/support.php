<?php
/*
Plugin Name: Support System
Plugin URI: 
Description:
Author: Luke Poland (Incsub)
Version: 1.5.2
Author URI:
*/
require_once('admin.php');

$title = __('Support');
$parent_file = 'support.php';

function index_css() {
	wp_admin_css( 'css/dashboard' );
}
add_action( 'admin_head', 'index_css' );


require_once('admin-header.php');
/*
if ( !is_site_admin() ) {
    wp_die('You do not have permission to access this page.');
}
*/
?>
<div class="wrap">

<?php
		incsub_support_include();
?>

</div>

<?php

include('admin-footer.php');

function incsub_support_output() {
?>
<div class="wrap">

<?php
	$support_actions = array("videos", "faq", "tickets");
	$support_actions = apply_filters("incsub_support_actions", $support_actions);

	if (in_array($_GET['page'], $support_actions) ) {
		incsub_support_include($_GET['page']);
	} else {
		incsub_support_include();
	}
?>

</div>
<?php
}
?>