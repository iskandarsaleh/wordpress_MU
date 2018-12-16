<?php
/*
Plugin Name: Supporter
Plugin URI: 
Description:
Author: Andrew Billits (Incsub)
Version: 1.6.1
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

	if (get_site_option( "supporter_paypal_status" ) == 'live'){
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
	//if ($_POST['payment_status'] == 'In-Progress' || $_POST['payment_status'] == 'Partially-Refunded') exit;
	$new_status = false;
	// process PayPal response
	switch ($_POST['payment_status']) {
		case 'Partially-Refunded':
			// case: partially-refunded
			list($bid, $period, $amount, $currency, $stamp) = explode('_', $_POST['custom']);
			supporter_insert_update_transaction($bid, $_POST['txn_id'], $_POST['payment_type'], $stamp, $amount, $currency, $_POST['payment_status']);
			break;
			
		case 'In-Progress':
			// case: in-progress
			list($bid, $period, $amount, $currency, $stamp) = explode('_', $_POST['custom']);
			supporter_insert_update_transaction($bid, $_POST['txn_id'], $_POST['payment_type'], $stamp, $amount, $currency, $_POST['payment_status']);
			break;

		case 'Completed':
		case 'Processed':
			// case: successful payment
			list($bid, $period, $amount, $currency, $stamp) = explode('_', $_POST['custom']);
			supporter_insert_update_transaction($bid, $_POST['txn_id'], $_POST['payment_type'], $stamp, $amount, $currency, $_POST['payment_status']);
			supporter_extend($bid, $period);
			supporter_update_note($bid, '');
			break;

		case 'Reversed':
			// case: charge back
			$note = 'Last transaction has been reversed. Reason: Payment has been reversed (charge back)';
			list($bid, $period, $amount, $currency, $stamp) = explode('_', $_POST['custom']);
			supporter_insert_update_transaction($bid, $_POST['parent_txn_id'], $_POST['payment_type'], $stamp, $amount, $currency, $_POST['payment_status']);
			supporter_withdraw($bid, $period);
			supporter_update_note($bid, $note);
			break;

		case 'Refunded':
			// case: refund
			$note = 'Last transaction has been reversed. Reason: Payment has been refunded';
			list($bid, $period, $amount, $currency, $stamp) = explode('_', $_POST['custom']);
			supporter_insert_update_transaction($bid, $_POST['parent_txn_id'], $_POST['payment_type'], $stamp, $amount, $currency, $_POST['payment_status']);
			supporter_withdraw($bid, $period);
			supporter_update_note($bid, $note);
			break;

		case 'Denied':
			// case: denied
			$note = 'Last transaction has been reversed. Reason: Payment Denied';
			list($bid, $period, $amount, $currency, $stamp) = explode('_', $_POST['custom']);
			$paypal_ID = $_POST['parent_txn_id'];
			if ( empty( $paypal_ID ) ) {
				$paypal_ID = $_POST['txn_id'];
			}
			supporter_insert_update_transaction($bid, $paypal_ID, $_POST['payment_type'], $stamp, $amount, $currency, $_POST['payment_status']);
			supporter_withdraw($bid, $period);
			supporter_update_note($bid, $note);
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
			$note = 'Last transaction is pending. Reason: ' . (isset($pending_str[$reason]) ? $pending_str[$reason] : $pending_str['*']);
			list($bid, $period, $amount, $currency, $stamp) = explode('_', $_POST['custom']);
			supporter_insert_update_transaction($bid, $_POST['txn_id'], $_POST['payment_type'], $stamp, $amount, $currency, $_POST['payment_status']);
			supporter_update_note($bid, $note);
			break;

		default:
			// case: various error cases
	}
}

?>