<?php
/*
Plugin Name: Site Generator Replacement
Plugin URI: http://premium.wpmudev.org/
Description: Easily customize ALL "Site Generator" text and links. Edit under Site Admin "Options" menu.
Author: Luke Poland (Incsub)
Version: 1.0
Author URI: http://incsub.com/
*/

/* 
Copyright 2007-2009 Incsub (http://incsub.com)
Copyright 2008 Luke Poland

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

	if ( !defined("ABSPATH") ) { die("I don't think so, Tim."); }
	function incsub_generator_replace($gen, $type) {
		$global_site_generator = get_site_option("incsub_site_generator");
		$global_site_link = get_site_option("incsub_site_generator_link");
		if ( empty($global_site_generator) ) {
			global $current_site;
			$global_site_generator = $current_site->site_name;
		}
		if ( empty($global_site_link) ) {
			global $current_site;
			$global_site_link = "http://". $current_site->domain . $current_site->path;
		}
		switch($type) {
			case 'html':
				$gen = '<meta name="generator" content="' . $global_site_generator . '">' . "\n";
				break;
			case 'xhtml':
				$gen = '<meta name="generator" content="' . $global_site_generator . '" />' . "\n";
				break;
			case 'atom':
				$gen = '<generator uri="' . $global_site_link . '" version="' . get_bloginfo_rss( 'version' ) . '">' . $global_site_generator . '</generator>';
				break;
			case 'rss2':
				$gen = '<generator>' . $global_site_link . '?v=' . get_bloginfo_rss( 'version' ) . '</generator>';
				break;
			case 'rdf':
				$gen = '<admin:generatorAgent rdf:resource="' . $global_site_link . '?v=' . get_bloginfo_rss( 'version' ) . '" />';
				break;
			case 'comment':
				$gen = '<!-- generator="' . $global_site_generator . '/' . get_bloginfo( 'version' ) . '" -->';
				break;
			case 'export':
				$gen = '<!-- generator="' . $global_site_generator . '/' . get_bloginfo_rss('version') . '" created="'. date('Y-m-d H:i') . '"-->';
				break;
		}
		return $gen;
	}
	function incsub_generator_options() {
		$global_site_generator = get_site_option("incsub_site_generator");
		$global_site_link = get_site_option("incsub_site_generator_link");
		if ( empty($global_site_generator) ) {
			global $current_site;
			$global_site_generator = $current_site->site_name;
		}
		if ( empty($global_site_link) ) {
			global $current_site;
			$global_site_link = "http://". $current_site->domain . $current_site->path;
		}
?>
			<h3><?php _e('Site Generator Options') ?></h3>
			<table class="form-table">
				<tr valign="top"> 
					<th scope="row">
						<?php _e('Generator Text') ?>
					</th>
					<td>
						<input type="text" name="incsub_site_generator" id="incsub_site_generator" style="width: 95%" value="<?php echo stripslashes($global_site_generator); ?>" />
						<?php _e('<br /><small>Change the "generator" information from WordPress to something you prefer.</small>'); ?>
					</td>
				</tr>
				<tr valign="top"> 
					<th scope="row">
						<?php _e('Generator Link') ?>
					</th>
					<td>
						<input type="text" name="incsub_site_generator_link" id="incsub_site_generator_link" style="width: 95%" value="<?php echo stripslashes($global_site_link); ?>" />
						<?php _e('<br /><small>Change the "generator link" from WordPress to something you prefer.</small>'); ?>
					</td>
				</tr>
			</table>
<?php
	}
	function incsub_generator_options_update() {
		update_site_option( "incsub_site_generator", $_POST['incsub_site_generator'] );
		update_site_option( "incsub_site_generator_link", $_POST['incsub_site_generator_link'] );
	
	}
	if ( function_exists("incsub_admin_footer_options") ) { 
		add_action("incsub_admin_options", "incsub_generator_options");
	} else {
		add_action("wpmu_options", "incsub_generator_options");
	}
	add_action("update_wpmu_options", "incsub_generator_options_update");
	add_filter("get_the_generator_html", "incsub_generator_replace", 20, 2);
	add_filter("get_the_generator_xhtml", "incsub_generator_replace", 20, 2);
	add_filter("get_the_generator_atom", "incsub_generator_replace", 20, 2);
	add_filter("get_the_generator_rss2", "incsub_generator_replace", 20, 2);
	add_filter("get_the_generator_rdf", "incsub_generator_replace", 20, 2);
	add_filter("get_the_generator_comment", "incsub_generator_replace", 20, 2);
	add_filter("get_the_generator_export", "incsub_generator_replace", 20, 2);
?>