<?php
/*
Plugin Name: Upgrades (Feature: Quota)
Plugin URI: 
Description:
Author: Andrew Billits (Incsub)
Version: 1.4.2
Author URI:
*/

//------------------------------------------------------------------------//
//---Config---------------------------------------------------------------//
//------------------------------------------------------------------------//

//------------------------------------------------------------------------//
//---Hook-----------------------------------------------------------------//
//------------------------------------------------------------------------//
//register upgrade features
upgrades_register_feature('ca6b47d19bac12356ba79dc49cfa1fb0', 'Quota Increase (50MB)', 'Increases the allowed upload space to 50MB. ');
upgrades_register_feature('32e6cbec1036a33eee5f0596bc740a4c', 'Quota Increase (100MB)', 'Increases the allowed upload space to 100MB. ');
upgrades_register_feature('a559c694da1b6423eea2937e1ddfcd44', 'Quota Increase (250MB)', 'Increases the allowed upload space to 250MB. ');
upgrades_register_feature('f284b7e869b9381ac186a33dc6818f07', 'Quota Increase (500MB)', 'Increases the allowed upload space to 500MB. ');
upgrades_register_feature('47674db61a0415a369e167c543ed1921', 'Quota Increase (750MB)', 'Increases the allowed upload space to 750MB. ');
upgrades_register_feature('796a68dae69caa02527c956a7472ad1d', 'Quota Increase (1GB)', 'Increases the allowed upload space to 1GB. ');
upgrades_register_feature('4ea68a6eb5c5085b5a89374d446b403f', 'Quota Increase (3GB)', 'Increases the allowed upload space to 3GB. ');
upgrades_register_feature('e2d641fa2c2fee7b155b34c4b93514c6', 'Quota Increase (5GB)', 'Increases the allowed upload space to 5GB. ');
upgrades_register_feature('0a201b01f43bd4bc69cad2665d1c0b44', 'Quota Increase (10GB)', 'Increases the allowed upload space to 10GB. ');

$quota_upgrade_active = '0';
$quota_upgrade_space = 1;

//load upgrade features
if (upgrades_active_feature('ca6b47d19bac12356ba79dc49cfa1fb0') == 'active'){
	if ($quota_upgrade_active == '1' && $quota_upgrade_space > 50) {
		//already active with more space
	} else {
		$quota_upgrade_active = '1';
		$quota_upgrade_space = 50;
		quota_active(50);
	}
}
if (upgrades_active_feature('32e6cbec1036a33eee5f0596bc740a4c') == 'active'){
	if ($quota_upgrade_active == '1' && $quota_upgrade_space > 100) {
		//already active with more space
	} else {
		$quota_upgrade_active = '1';
		$quota_upgrade_space = 100;
		quota_active(100);
	}
}
if (upgrades_active_feature('a559c694da1b6423eea2937e1ddfcd44') == 'active'){
	if ($quota_upgrade_active == '1' && $quota_upgrade_space > 250) {
		//already active with more space
	} else {
		$quota_upgrade_active = '1';
		$quota_upgrade_space = 250;
		quota_active(250);
	}
}
if (upgrades_active_feature('f284b7e869b9381ac186a33dc6818f07') == 'active'){
	if ($quota_upgrade_active == '1' && $quota_upgrade_space > 500) {
		//already active with more space
	} else {
		$quota_upgrade_active = '1';
		$quota_upgrade_space = 500;
		quota_active(500);
	}
}
if (upgrades_active_feature('47674db61a0415a369e167c543ed1921') == 'active'){
	if ($quota_upgrade_active == '1' && $quota_upgrade_space > 750) {
		//already active with more space
	} else {
		$quota_upgrade_active = '1';
		$quota_upgrade_space = 750;
		quota_active(750);
	}
}
if (upgrades_active_feature('796a68dae69caa02527c956a7472ad1d') == 'active'){
	if ($quota_upgrade_active == '1' && $quota_upgrade_space > 1024) {
		//already active with more space
	} else {
		$quota_upgrade_active = '1';
		$quota_upgrade_space = 1024;
		quota_active(1024);
	}
}
if (upgrades_active_feature('4ea68a6eb5c5085b5a89374d446b403f') == 'active'){
	if ($quota_upgrade_active == '1' && $quota_upgrade_space > 3072) {
		//already active with more space
	} else {
		$quota_upgrade_active = '1';
		$quota_upgrade_space = 3072;
		quota_active(3072);
	}
}
if (upgrades_active_feature('e2d641fa2c2fee7b155b34c4b93514c6') == 'active'){
	if ($quota_upgrade_active == '1' && $quota_upgrade_space > 5124) {
		//already active with more space
	} else {
		$quota_upgrade_active = '1';
		$quota_upgrade_space = 5124;
		quota_active(5124);
	}
}
if (upgrades_active_feature('0a201b01f43bd4bc69cad2665d1c0b44') == 'active'){
	if ($quota_upgrade_active == '1' && $quota_upgrade_space > 10240) {
		//already active with more space
	} else {
		$quota_upgrade_active = '1';
		$quota_upgrade_space = 10240;
		quota_active(10240);
	}
}
if ( $quota_upgrade_active == '0' && $quota_upgrade_space == 1 ){
	quota_inactive();
	$quota_upgrade_active = '0';
}

//------------------------------------------------------------------------//
//---Functions------------------------------------------------------------//
//------------------------------------------------------------------------//
function quota_active($tmp_new_quota){
	$tmp_current_quota = get_option("blog_upload_space");
	if ($tmp_current_quota == $tmp_new_quota){
		//already updated
	} else {
		update_option("blog_upload_space", $tmp_new_quota);
	}
}

function quota_inactive(){
	$tmp_default_quota = get_site_option("blog_upload_space");
	$tmp_current_quota = get_option("blog_upload_space");
	if( empty($tmp_default_quota) || !is_numeric($tmp_default_quota) ){
		$tmp_default_quota = 50;
	}
	update_option("blog_upload_space", $tmp_default_quota);
}

//------------------------------------------------------------------------//
//---Output Functions-----------------------------------------------------//
//------------------------------------------------------------------------//

//------------------------------------------------------------------------//
//---Page Output Functions------------------------------------------------//
//------------------------------------------------------------------------//

?>
