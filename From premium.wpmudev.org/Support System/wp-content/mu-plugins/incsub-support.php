<?php
// no kiddies.
if ( !defined("ABSPATH") ) {
	die("I don't think so, Tim.");
}

function incsub_support_menu() {
	global $menu, $submenu;
	$menu[39] = $menu[40];
	$menu[40] = array(__('Support'), '1', 'support.php', '', 'wp-menu-open menu-top menu-top-first', 'menu-site', 'div');
	$submenu[ 'support.php' ][1] = array( __('Main'), '1', 'support.php' );
//	$submenu[ 'support.php' ][2] = array( __('Video Tutorials'), '1', 'support.php?action=videos' );
}
 
function incsub_support_submenu() {
	add_submenu_page('support.php', __('Frequently Asked Questions'), __('FAQ'), '1', 'faq', 'incsub_support_output' );
	add_submenu_page('support.php', __('Support Tickets'), __('Support Tickets'), 'edit_posts', 'tickets', 'incsub_support_output' );
	if ( is_site_admin() ) {
		add_submenu_page('wpmu-admin.php', __('Frequently Asked Questions'), __('FAQ Manager'), 'edit_users', 'faq-manager', 'incsub_support_faqadmin' );
		add_submenu_page('wpmu-admin.php', __('Support Ticket Management System'), __('Support Ticket Manager'), 'edit_users', 'ticket-manager', 'incsub_support_ticketadmin' );
	}
}
function incsub_support_add_dbsctucture() {
	global $wpdb, $ticket_status, $ticket_priority;
	$wpdb->faq = $wpdb->base_prefix.'support_faq';
	$wpdb->faq_cats = $wpdb->base_prefix.'support_faq_cats';
	$wpdb->tickets = $wpdb->base_prefix . 'support_tickets';
	$wpdb->tickets_cats = $wpdb->base_prefix . 'support_tickets_cats';
	$wpdb->tickets_messages = $wpdb->base_prefix . 'support_tickets_messages';

	$ticket_priority = array(
		0	=>	"Low",
		1	=>	"Normal",
		2	=>	"Elevated",
		3	=>	"High",
		4	=>	"Critical"
	);

	$ticket_status = array(
		0	=>	"New",
		1	=>	"In progress",
		2	=>	"Waiting on User to reply",
		3	=>	"Waiting on Admin to reply",
		4	=>	"Stalled",
		5	=>	"Closed"
	);
}

function incsub_support_include($file = 'main') {
	incsub_support_add_dbsctucture();
	include_once(dirname(__FILE__) .'/incsub-support/incsub-support-'. $file .'.php');
}

add_action( '_admin_menu', 'incsub_support_menu', 1);
add_action( 'admin_menu', 'incsub_support_submenu', 20);

if ( defined("WP_ADMIN") and constant("WP_ADMIN") == true and !empty($_GET['page']) and ($_GET['page'] == 'faq-manager' or $_GET['page'] == 'ticket-manager') ) {
	incsub_support_add_dbsctucture();
	if ( $_GET['page'] == 'faq-manager' ) {
		include_once(dirname(__FILE__) .'/incsub-support/admin-pages/incsub-support-faq-admin.php');
	} elseif ( $_GET['page'] == 'ticket-manager' ) {
		include_once(dirname(__FILE__) .'/incsub-support/admin-pages/incsub-support-ticket-admin.php');
	}
}



?>
