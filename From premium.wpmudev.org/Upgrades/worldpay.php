<?php
/*
Plugin Name: Upgrades (Payment Callback: WorldPay)
Plugin URI: 
Description:
Author: Andrew Billits (Incsub)
Version: 1.4.2
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

require_once('wp-config.php');

$tmp_upgrades_user_id = $_GET['M_user'];
if ($tmp_upgrades_user_id == ''){
	$tmp_upgrades_user_id = $_POST['M_user'];
}
$tmp_upgrades_credits = $_GET['M_credits'];
if ($tmp_upgrades_credits == ''){
	$tmp_upgrades_credits = $_POST['M_credits'];
}
$tmp_transaction_status = $_GET['transStatus'];
if ($tmp_transaction_status == ''){
	$tmp_transaction_status = $_POST['transStatus'];
}

$tmp_upgrades_user = get_userdata((int) $tmp_upgrades_user_id);
if ((empty($tmp_upgrades_user)) || ($tmp_upgrades_user === false)) {
	echo 'User cannot be found.';
} else {
	if ($tmp_transaction_status == 'Y'){
		//Transaction Complete!
		upgrades_user_credits_add($tmp_upgrades_credits, $tmp_upgrades_user_id);
		echo '1';
	} else {
		//Transaction Cancelled
		echo '0';
	}
}

?>