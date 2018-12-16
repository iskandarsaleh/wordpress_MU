<?php
/*
Plugin Name: Site wide text change
Version: 1.0.0
Plugin URI: http://premium.wpmudev.org
Description: This plugin allows a site admin user to modify any piece of admin text across their entire install.
Author: Barry at clearskys.net (incsub)
Author URI: http://incsub.com
*/

/* 
Copyright 2007-2009 Barry at clearskys.net and Incsub (http://incsub.com)

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

// Un comment for full belt and braces replacements, warnings:
// 1. TEST TEST TEST
// 2. This WILL change a users blog content, comments, tags, categories, links, etc... when viewed in the admin area.
//define('SWTC-BELTANDBRACES', 'yes');

class sitewidetextchange {

	var $build = 3;

	var $mylocation = "";
	var $plugindir = "";
	var $base_uri = '';

	var $mypages = array('sitewidetext_admin');

	var $translationtable = false;
	var $translationops = false;


	function __construct() {

		$this->detect_location(1);

		add_action('init', array(&$this, 'initialise_plugin'));

		add_action('admin_menu', array(&$this,'add_adminmenu'));

		add_filter('gettext', array(&$this, 'replace_text'), 10, 3);

		if(defined('SWTC-BELTANDBRACES')) {
			if( in_array(addslashes($_GET['page']), $this->mypages)) {
				add_action('admin_notices', array(&$this, 'warning'));
			} else {
				add_action('init', array(&$this, 'start_cache'), 1);
				add_action('admin_print_footer_scripts', array(&$this, 'end_cache'), 999);
			}

		}

	}

	function autoblogpremium() {
		$this->__construct();
	}

	function detect_location($level = 1) {
			$directories = explode(DIRECTORY_SEPARATOR,dirname(__FILE__));

			$mydir = array();
			for($depth = $level; $depth >= 1; $depth--) {
				$mydir[] = $directories[count($directories)-$depth];
			}

			$mydir = implode('/', $mydir);
			$this->mylocation = $mydir . DIRECTORY_SEPARATOR . basename(__FILE__);

			if(defined('WP_PLUGIN_DIR') && file_exists(WP_PLUGIN_DIR . '/' . $this->mylocation)) {
				$this->plugindir = WP_PLUGIN_URL;
			} else {
				$this->plugindir = WPMU_PLUGIN_URL;
			}

			$this->base_uri = $this->plugindir . '/' . $directories[count($directories)-$level] . '/';

		}

	function warning() {
		echo '<div id="update-nag">Warning, this page is not loaded with the full replacements processed.</div>';
	}

	function initialise_plugin() {

		if(in_array(addslashes($_GET['page']), $this->mypages)) {
			wp_enqueue_style('sitewidecss', $this->plugindir . '/sitewidetextincludes/styles/sitewide.css', array(), $this->build);
			wp_enqueue_script('jquery-ui-sortable');
			wp_enqueue_script('jquery-form');
			wp_enqueue_script('sitewidejs', $this->plugindir . '/sitewidetextincludes/js/sitewideadmin.js', array('jquery'), $this->build);
		}

	}

	function add_adminmenu() {
		add_submenu_page('wpmu-admin.php', __('Text Change','sitewidetext'), __('Text Change','sitewidetext'), 10, "sitewidetext_admin", array(&$this,'handle_admin_page'));
	}

	function handle_ajax() {

	}

	function show_table($key, $table) {

		echo '<div class="postbox " id="swtc-' . $key . '">';

		echo '<div title="Click to toggle" class="handlediv"><br/></div><h3 class="hndle"><input type="checkbox" name="deletecheck[]" class="deletecheck" value="' . $key . '" /><span>' . $table['title'] . '</span></h3>';
		echo '<div class="inside">';

		echo "<table width='100%'>";

		echo "<tr>";
		echo "<td valign='top' class='heading'>";
		echo __('Find this text','sitewidetext');
		echo "</td>";
		echo "<td valign='top' class=''>";
		echo "<input type='text' name='swtble[$key][find]' value='" . htmlentities(stripslashes($table['find']),ENT_QUOTES, 'UTF-8') . "' class='long find' />";
		echo "<br/>";
		echo "<input type='checkbox' name='swtble[$key][ignorecase]' class='case' value='1' ";
		if($table['ignorecase'] == '1') echo "checked='checked' ";
		echo "/>&nbsp;<span>" . __('Ignore case when finding text.','sitewidetext') . "</span>";
		echo "</td>";
		echo "</tr>";

		echo "<tr>";
		echo "<td valign='top' class='heading'>";
		echo __('in this text domain','sitewidetext');
		echo "</td>";
		echo "<td valign='top' class=''>";
		echo "<input type='text' name='swtble[$key][domain]' value='" . htmlentities(stripslashes($table['domain']),ENT_QUOTES, 'UTF-8') . "' class='short domain' />";
		echo "&nbsp;<span>" . __('( leave blank for global changes )','sitewidetext') , '</span>';
		echo "</td>";
		echo "</tr>";

		echo "<tr>";
		echo "<td valign='top' class='heading'>";
		echo __('and replace it with','sitewidetext');
		echo "</td>";
		echo "<td valign='top' class=''>";
		echo "<input type='text' name='swtble[$key][replace]' value='" . htmlentities(stripslashes($table['replace']),ENT_QUOTES, 'UTF-8') . "' class='long replace' />";
		echo "</td>";
		echo "</tr>";

		echo "</table>";

		echo '</div>';

		echo '</div>';

	}

	function show_table_template() {

		echo '<div class="postbox blanktable" id="blanktable" style="display: none;">';

		echo '<div title="Click to toggle" class="handlediv"><br/></div><h3 class="hndle"><input type="checkbox" name="deletecheck[]" class="deletecheck" value="" /><span>New Text Change Rule</span></h3>';
		echo '<div class="inside">';

		echo "<table width='100%'>";

		echo "<tr>";
		echo "<td valign='top' class='heading'>";
		echo __('Find this text','sitewidetext');
		echo "</td>";
		echo "<td valign='top' class=''>";
		echo "<input type='text' name='swtble[][find]' value='' class='long find' />";
		echo "<br/>";
		echo "<input type='checkbox' name='swtble[][ignorecase]' class='case' value='1' ";
		echo "/>&nbsp;<span>" . __('Ignore case when finding text.','sitewidetext') . "</span>";
		echo "</td>";
		echo "</tr>";

		echo "<tr>";
		echo "<td valign='top' class='heading'>";
		echo __('in this text <abbr title="A text domain is related to the internationisation of the text, you should leave this blank unless you know what it means.">domain</abbr>','sitewidetext');
		echo "</td>";
		echo "<td valign='top' class=''>";
		echo "<input type='text' name='swtble[][domain]' value='' class='short domain' />";
		echo "&nbsp;<span>" . __('( leave blank for global changes )','sitewidetext') , '</span>';
		echo "</td>";
		echo "</tr>";

		echo "<tr>";
		echo "<td valign='top' class='heading'>";
		echo __('and replace it with','sitewidetext');
		echo "</td>";
		echo "<td valign='top' class=''>";
		echo "<input type='text' name='swtble[][replace]' value='' class='long replace' />";
		echo "</td>";
		echo "</tr>";

		echo "</table>";

		echo '</div>';

		echo '</div>';

	}

	function handle_admin_page() {

		if(isset($_POST['action']) && addslashes($_POST['action']) == 'sitewide') {

			check_admin_referer('sitewidetext');

			if(!empty($_POST['delete'])) {
				$deletekeys = (array) $_POST['deletecheck'];
			} else {
				$deletekeys = array();
			}

			if(!empty($_POST['swtble'])) {
				$save = array();
				$op = array();
				foreach($_POST['swtble'] as $key => $table) {
					if(!in_array($key, $deletekeys) && !empty($table['find'])) {
						$save[addslashes($key)]['title'] = 'Text Change : ' . htmlentities($table['find'],ENT_QUOTES, 'UTF-8');
						$save[addslashes($key)]['find'] = $table['find'];
						$save[addslashes($key)]['ignorecase'] = $table['ignorecase'];
						$save[addslashes($key)]['domain'] = $table['domain'];
						$save[addslashes($key)]['replace'] = $table['replace'];

						if($table['ignorecase'] == '1') {
							$op['domain-' . $table['domain']]['find'][] = '/' . stripslashes($table['find']) . '/i';
						} else {
							$op['domain-' . $table['domain']]['find'][] = '/' . stripslashes($table['find']) . '/';
						}
						$op['domain-' . $table['domain']]['replace'][] = stripslashes($table['replace']);

					}

				}

				if(!empty($op)) {
					update_site_option('translation_ops',$op);
					update_site_option('translation_table',$save);
				} else {
					update_site_option('translation_ops', 'none');
					update_site_option('translation_table', 'none');
				}


				echo '<div id="message" class="updated fade"><p>' . sprintf(__("Your Settings have been updated. <a href='%s'>Click here</a> to reload page.", 'sitewidetext'), trailingslashit(get_option('siteurl')) . 'wp-admin/wpmu-admin.php?page=sitewidetext_admin') . '</p></div>';
			}

		}

		$translations = $this->get_translation_table(true);

		echo "<div class='wrap'>";

		// Show the heading
		echo '<div class="icon32" id="icon-tools"><br/></div>';
		echo "<h2>" . __('Text Change Settings','sitewidetext') . "</h2>";

		echo "<form action='' method='post'>";
		echo "<input type='hidden' name='action' value='sitewide' />";

		wp_nonce_field( 'sitewidetext' );

		echo '<div class="tablenav">';
		echo '<div class="alignleft">';
		echo '<input class="button-secondary delete save" type="submit" name="save" value="' . __('Save all settings', 'sitewidetext') . '" />';
		echo '<input class="button-secondary del" type="submit" name="delete" value="' . __('Delete selected', 'sitewidetext') . '" />';
		echo '</div>';

		echo '<div class="alignright">';
		echo '<input class="button-secondary addnew" type="submit" name="add" value="' . __('Add New', 'sitewidetext') . '" />';
		echo '</div>';

		echo '</div>';

		echo "<div id='entryholder'>";

		if($translations && is_array($translations)) {

			foreach($translations as $key => $table) {

				$this->show_table($key, $table);

			}

		} else {

			echo "<p style='padding: 10px;' id='holdingtext'>";

			echo __('You do not have any text change rules entered. Click on the Add New button on the right hand side to add a new rule.','sitewidetext');

			echo "</p>";

		}

		echo "</div>";	// Entry holder

		echo '<div class="tablenav">';
		echo '<div class="alignleft">';
		echo '<input class="button-secondary delete save" type="submit" name="save" value="' . __('Save all settings', 'sitewidetext') . '" />';
		echo '<input class="button-secondary del" type="submit" name="delete" value="' . __('Delete selected', 'sitewidetext') . '" />';
		echo '</div>';

		echo '<div class="alignright">';
		echo '<input class="button-secondary addnew" type="submit" name="add" value="' . __('Add New', 'sitewidetext') . '" />';
		echo '</div>';

		echo '</div>';

		echo "</form>";

		$this->show_table_template();

		echo "</div>";	// wrap

	}

	function show_admin_page() {

	}

	// Cache functions

	function get_translation_table($reload = false) {

		if($this->translationtable && !$reload) {
			return $this->translationtable;
		} else {
			$this->translationtable = get_site_option('translation_table', array());
			return $this->translationtable;
		}

	}

	function get_translation_ops($reload = false) {

		if($this->translationops && !$reload) {
			return $this->translationops;
		} else {
			$this->translationops = get_site_option('translation_ops', array());
			return $this->translationops;
		}

	}

	function replace_text($transtext, $normtext, $domain) {

		$tt = $this->get_translation_ops();

		if(!is_array($tt)) return $transtext;

		$toprocess =  (array) $tt['domain-' . $domain]['find'] + (array) $tt['domain-']['find'];
		$toreplace =  (array) $tt['domain-' . $domain]['replace'] + (array) $tt['domain-']['replace'];

		$transtext = preg_replace($toprocess, $toreplace, $transtext);

		return $transtext;

	}

	function start_cache() {
		ob_start();
	}

	function end_cache() {

		$tt = $this->get_translation_ops();

		if(!is_array($tt)) {
			ob_end_flush();
		} else {
			$content = ob_get_contents();

			$toprocess =  (array) $tt['domain-']['find'];
			$toreplace =  (array) $tt['domain-']['replace'];

			$content = preg_replace($toprocess, $toreplace, $content);

			ob_end_clean();
			echo $content;
		}

	}

	// Ajax functions
	function add_translatable() {

	}

	function update_translatable() {

	}

	function delete_translatable() {

	}


}

if(is_admin()) {
	$swtc =& new sitewidetextchange();
}
?>