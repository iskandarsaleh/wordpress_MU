<?php
// no kiddies.
if ( !defined("ABSPATH") and !defined("INCSUBSUPPORT") ) {
	die("I don't think so, Tim.");
}


function incsub_support_faqinstall() {
	global $wpdb;
	$wpdb->query("
		CREATE TABLE IF NOT EXISTS `". $wpdb->base_prefix ."support_faq` (
		  `faq_id` bigint(20) unsigned NOT NULL auto_increment,
		  `site_id` bigint(20) unsigned NOT NULL,
		  `cat_id` bigint(20) unsigned NOT NULL,
		  `question` varchar(255) NOT NULL,
		  `answer` mediumtext NOT NULL,
		  `help_views` bigint(20) unsigned NOT NULL default '0',
		  `help_count` bigint(20) unsigned NOT NULL default '0',
		  `help_yes` int(12) unsigned NOT NULL default '0',
		  `help_no` int(12) unsigned NOT NULL default '0',
		  PRIMARY KEY  (`faq_id`),
		  KEY `site_id` (`site_id`,`cat_id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=". $wpdb->charset .";
	");

	$wpdb->query("
		CREATE TABLE IF NOT EXISTS `". $wpdb->base_prefix ."support_faq_cats` (
		  `cat_id` bigint(20) unsigned NOT NULL auto_increment,
		  `site_id` bigint(20) unsigned NOT NULL,
		  `cat_name` varchar(255) NOT NULL,
		  `qcount` smallint(3) unsigned NOT NULL,
		  `defcat` enum('0','1') NOT NULL default '0',
		  PRIMARY KEY  (`cat_id`),
		  KEY `site_id` (`site_id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=". $wpdb->charset .";
	");
}

function incsub_support_ticketinstall() {
		global $wpdb;
		$wpdb->query("
			CREATE TABLE IF NOT EXISTS `". $wpdb->base_prefix ."support_tickets` (
				`ticket_id` bigint(20) unsigned NOT NULL auto_increment,
				`site_id` bigint(20) unsigned NOT NULL,
				`blog_id` bigint(20) unsigned NOT NULL,
				`cat_id` bigint(20) unsigned NOT NULL,
				`user_id` bigint(20) unsigned NOT NULL,
				`admin_id` bigint(20) unsigned NOT NULL default '0',
				`last_reply_id` bigint(20) unsigned NOT NULL default '0',
				`ticket_type` tinyint(1) unsigned NOT NULL default '1',
				`ticket_priority` tinyint(1) unsigned NOT NULL default '1',
				`ticket_status` tinyint(1) unsigned NOT NULL default '0',
				`ticket_opened` timestamp NOT NULL default '0000-00-00 00:00:00',
				`ticket_updated` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
				`num_replies` smallint(3) unsigned NOT NULL default '0',
				`title` varchar(120) NOT NULL,
				PRIMARY KEY  (`ticket_id`),
				KEY `site_id` (`site_id`),
				KEY `blog_id` (`blog_id`),
				KEY `user_id` (`user_id`),
				KEY `admin_id` (`admin_id`),
				KEY `ticket_status` (`ticket_status`),
				KEY `ticket_updated` (`ticket_updated`)
			) ENGINE=MyISAM  DEFAULT CHARSET=". $wpdb->charset .";
		");

		$wpdb->query("
			CREATE TABLE IF NOT EXISTS `". $wpdb->base_prefix ."support_tickets_cats` (
				`cat_id` bigint(20) unsigned NOT NULL auto_increment,
				`site_id` bigint(20) unsigned NOT NULL,
				`cat_name` varchar(100) NOT NULL,
				`defcat` enum('0','1') NOT NULL default '0',
				PRIMARY KEY  (`cat_id`),
				KEY `site_id` (`site_id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=". $wpdb->charset .";
		");

		$wpdb->query("
			CREATE TABLE IF NOT EXISTS `". $wpdb->base_prefix ."support_tickets_messages` (
				`message_id` bigint(20) unsigned NOT NULL auto_increment,
				`site_id` bigint(20) unsigned NOT NULL,
				`ticket_id` bigint(20) unsigned NOT NULL,
				`user_id` bigint(20) unsigned NOT NULL default '0',
				`admin_id` bigint(20) unsigned NOT NULL default '0',
				`message_date` timestamp NOT NULL default CURRENT_TIMESTAMP,
				`subject` varchar(255) NOT NULL,
				`message` mediumtext NOT NULL,
				PRIMARY KEY  (`message_id`),
				KEY `ticket_id` (`ticket_id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=". $wpdb->charset .";
		");
}

?>