<?php
/*
Plugin Name: Pay To Blog
Plugin URI: 
Description:
Author: Andrew Billits (Incsub)
Version: 1.5.2
Author URI:
*/

/* 
Copyright 2007-2009 Incsub (http://incsub.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License (Version 2 - GPLv2) as published by
the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

if (!isset($_POST['payment_status'])) {
	// Did not find expected POST variables. Possible access attempt from a non PayPal site.
	header('Status: 404 Not Found');
	exit;
} elseif (!isset($_POST['custom'])) {
	echo 'Error: Missing POST variables. Identification is not possible.';
	exit;
} else {
	define('ABSPATH', dirname(__FILE__) . '/');
	require_once(ABSPATH . 'wp-config.php');

	if (get_site_option( "pay_to_blog_paypal_status" ) == 'live'){
		$domain = 'https://www.paypal.com';
	} else {
		$domain = 'https://www.sandbox.paypal.com';
	}
	
	$req = 'cmd=_notify-validate';
	if (!isset($_POST)) $_POST = $HTTP_POST_VARS;
	foreach ($_POST as $k => $v) {
		if (get_magic_quotes_gpc()) $v = stripslashes($v);
		$req .= '&' . $k . '=' . $v;
	}

	$header = 'POST /cgi-bin/webscr HTTP/1.0' . "\r\n"
			. 'Content-Type: application/x-www-form-urlencoded' . "\r\n"
			. 'Content-Length: ' . strlen($req) . "\r\n"
			. "\r\n";

	@set_time_limit(60);
	if ($conn = @fsockopen($domain, 80, $errno, $errstr, 30)) {
		fputs($conn, $header . $req);
		socket_set_timeout($conn, 30);
	
		$response = '';
		$close_connection = false;
		while (true) {
			if (feof($conn) || $close_connection) {
				fclose($conn);
				break;
			}

			$st = @fgets($conn, 4096);
			if ($st === false) {
				$close_connection = true;
				continue;
			}
	
			$response .= $st;
		}	
	
		$error = '';
		$lines = explode("\n", str_replace("\r\n", "\n", $response));
		// looking for: HTTP/1.1 200 OK
		if (count($lines) == 0) $error = 'Response Error: Header not found';
		else if (substr($lines[0], -7) != ' 200 OK') $error = 'Response Error: Unexpected HTTP response';
		else {
			// remove HTTP header
			while (count($lines) > 0 && trim($lines[0]) != '') array_shift($lines);

			// first line will be empty, second line will have the result
			if (count($lines) < 2) $error = 'Response Error: No content found in transaction response';
			else if (strtoupper(trim($lines[1])) != 'VERIFIED') $error = 'Response Error: Unexpected transaction response';
		}

		if ($error != '') {
			echo $error;
			exit;
		}
	}

	// handle cases that the system must ignore
	if ($_POST['payment_status'] == 'In-Progress' || $_POST['payment_status'] == 'Partially-Refunded') exit;

	// get custom field values
	list($period, $currency, $blog_id) = explode('_', $_POST['custom']);
	
	// find user
	pay_to_blog_extend($period, $blog_id);
	/*
	$user_data = get_usermeta('wpb_paypal_user', (int) $user_id);
	if (empty($user_data)) {
		$user_data = new WPB_User();
		$user_data->update(wpb_new_user());
	}
	
	if (empty($user_data->period)) {
		$user_data->period = $period;
		$user_data->amount = $amount;
		$user_data->currency = $currency;
	}
	*/
	// process PayPal response
	$new_status = false;
	switch ($_POST['payment_status']) {
		case 'Completed':
		case 'Processed':
			// case: successful payment

			break;

		case 'Reversed':
		case 'Refunded':
		case 'Denied':
			// case: charge back or refund
			break;

		case 'Pending':
			// case: payment is pending
			$pending_str = array(
				'address' => 'Customer did not include a confirmed shipping address',
				'authorization' => 'Funds not captured yet',
				'echeck' => 'eCheck that has not cleared yet',
				'intl' => 'Payment waiting for aproval by service provider',
				'multi-currency' => 'Payment waiting for service provider to handle multi-currency process',
				'unilateral' => 'Customer did not register or confirm his/her email yet',
				'upgrade' => 'Waiting for service provider to upgrade the PayPal account',
				'verify' => 'Waiting for service provider to verify his/her PayPal account',
				'*' => ''
				);
			$reason = @$_POST['pending_reason'];
			//$user_data->status_str = 'Last payment is pending. Reason: ' . (isset($pending_str[$reason]) ? $pending_str[$reason] : $pending_str['*']);
			break;

		default:
			// case: various error cases
	}
}

?>