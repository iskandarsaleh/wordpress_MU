<?php
/*
Plugin Name: Blog Types
Plugin URI: 
Description:
Author: Andrew Billits (Incsub)
Version: 2.0.0
Author URI: http://incsub.com
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

$blog_types_current_version = '2.0.0';
if (file_exists(ABSPATH . 'wp-content/blog-types-config.php')) {
	include_once(ABSPATH . 'wp-content/blog-types-config.php');
} else {
	die('Blog Types configuration file not found.');
}
//------------------------------------------------------------------------//
//---Config---------------------------------------------------------------//
//------------------------------------------------------------------------//

//------------------------------------------------------------------------//
//---Hook-----------------------------------------------------------------//
//------------------------------------------------------------------------//
//check for activating
if ($_GET['key'] == '' || $_GET['key'] === ''){
	add_action('admin_head', 'blog_types_make_current');
	blog_types_import();
}
//admin pages
if ( $blog_types_display_admin_page == 'yes' ) {
	add_action('admin_menu', 'blog_types_plug_pages');
}
//blog edit
//Removing this feature
/*
if ( $blog_types_selection == 'single' ) {
	add_action('wpmueditblogaction', 'blog_types_blog_edit');
}
*/
//signup form
if ( $blog_types_display_signup_form == 'yes' ) {
	add_action( 'wp_head', 'blog_types_stylesheet');
	add_action('signup_blogform', 'blog_types_signup_form');
	add_filter('wpmu_validate_blog_signup', 'blog_types_signup_form_validate');
	add_filter('wpmu_validate_blog_signup', 'blog_types_signup_form_process');
	if ( $blog_types_enable_subtypes == 'yes' ) {
		add_action( 'wp_head', 'blog_types_subtype_signup_js');
		add_action( 'admin_head', 'blog_types_subtype_admin_js');
	}
}
//remove spam/mature/archived/deleted blogs
add_action('make_spam_blog', 'blog_types_global_remove');
add_action('archive_blog', 'blog_types_global_remove');
add_action('deactivate_blog', 'blog_types_global_remove');
add_action('mature_blog', 'blog_types_global_remove');
add_action('delete_blog', 'blog_types_global_remove', 1);
add_action('update_blog_public', 'blog_types_global_public');
//------------------------------------------------------------------------//
//---Functions------------------------------------------------------------//
//------------------------------------------------------------------------//
function blog_types_make_current() {
	global $wpdb, $blog_types_current_version;
	if (get_site_option( "blog_types_version" ) == '') {
		add_site_option( 'blog_types_version', '0.0.0' );
	}
	
	if (get_site_option( "blog_types_version" ) == $blog_types_current_version) {
		// do nothing
	} else {
		//update to current version
		update_site_option( "blog_types_installed", "no" );
		update_site_option( "blog_types_version", $blog_types_current_version );
	}
	blog_types_global_install();
	//--------------------------------------------------//
	if (get_option( "blog_types_version" ) == '') {
		add_option( 'blog_types_version', '0.0.0' );
	}
	
	if (get_option( "blog_types_version" ) == $blog_types_current_version) {
		// do nothing
	} else {
		//update to current version
		update_option( "blog_types_version", $blog_types_current_version );
		blog_types_blog_install();
	}
}

function blog_types_blog_install() {
	global $wpdb, $blog_types_current_version;
	//$blog_types_table1 = "";
	//$wpdb->query( $blog_types_table1 );
}

function blog_types_global_install() {
	global $wpdb, $blog_types_current_version;
	if (get_site_option( "blog_types_installed" ) == '') {
		add_site_option( 'blog_types_installed', 'no' );
	}
	
	if (get_site_option( "blog_types_installed" ) == "yes") {
		// do nothing
	} else {
	
		$blog_types_table1 = "CREATE TABLE `" . $wpdb->base_prefix . "blog_types` (
  `blog_types_ID` bigint(20) unsigned NOT NULL auto_increment,
  `blog_ID` bigint(20) NOT NULL,
  `blog_types` TEXT NULL,
  `blog_subtypes` TEXT NULL,
  PRIMARY KEY  (`blog_types_ID`)
) ENGINE=MyISAM;
";
		$blog_types_table2 = "CREATE TABLE `" . $wpdb->base_prefix . "signup_blog_types` (
  `blog_types_ID` bigint(20) unsigned NOT NULL auto_increment,
  `blog_types_domain` varchar(255) NOT NULL,
  `blog_types_path` varchar(255) NOT NULL,
  `blog_types` TEXT NULL,
  `blog_subtypes` TEXT NULL,
  PRIMARY KEY  (`blog_types_ID`)
) ENGINE=MyISAM;";
		$blog_types_table3 = "";
		$blog_types_table4 = "";
		$blog_types_table5 = "";

		$wpdb->query( $blog_types_table1 );
		$wpdb->query( $blog_types_table2 );
		//$wpdb->query( $blog_types_table3 );
		//$wpdb->query( $blog_types_table4 );
		//$wpdb->query( $blog_types_table5 );
		update_site_option( "blog_types_installed", "yes" );
	}
}

function blog_types_global_public() {
	global $wpdb, $value, $current_blog;
	if ($value == 0){
		$wpdb->query("DELETE FROM " . $wpdb->base_prefix . "blog_types WHERE blog_ID = '" . $wpdb->blogid . "'");
	} else {
		$blog_types = get_option("blog_types");
		$blog_subtypes = get_option("blog_subtypes");
		if ( !empty( $blog_types ) && $blog_types != 'NA' && $blog_types != '|' && !empty( $blog_subtypes ) && $blog_subtypes != 'NA' && $blog_subtypes != '|' ) {
			if ($current_blog->archived == 0 && $current_blog->mature == 0 && $current_blog->spam == 0 && $current_blog->deleted == 0){
				$global_count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "blog_types WHERE blog_ID = '" . $wpdb->blogid . "'");
				if ($global_count > 0){
					//update row in global table
					$wpdb->query( "UPDATE " . $wpdb->base_prefix . "blog_types SET blog_types = '" . $blog_types . "' WHERE blog_ID = '" . $wpdb->blogid . "'" );
					$wpdb->query( "UPDATE " . $wpdb->base_prefix . "blog_types SET blog_subtypes = '" . $blog_subtypes . "' WHERE blog_ID = '" . $wpdb->blogid . "'" );
				} else {
					//insert into global table
					$wpdb->query( "INSERT INTO " . $wpdb->base_prefix . "blog_types (blog_ID, blog_types, blog_subtypes) VALUES ( '" . $wpdb->blogid . "', '" . $blog_types . "', '" . $blog_subtypes . "' )" );
				}
			} else {
				//remove from global table
				$wpdb->query("DELETE FROM " . $wpdb->base_prefix . "blog_types WHERE blog_ID = '" . $wpdb->blogid . "'");
			}	
		}
	}
}

function blog_types_global_remove($blog_ID) {
	global $wpdb;
	//remove from global table
	$wpdb->query("DELETE FROM " . $wpdb->base_prefix . "blog_types WHERE blog_ID = '" . $blog_ID . "'");
}

function blog_types_global_sync($blog_ID = '') {
	global $wpdb, $current_blog;
	if ( empty( $blog_ID ) ) {
		$blog_ID = $wpdb->blogid;
		$blog_types = get_option("blog_types");
		$blog_subtypes = get_option("blog_subtypes");
		$blog_public = $current_blog->public;
		$blog_archived = $current_blog->archived;
		$blog_mature = $current_blog->mature;
		$blog_spam = $current_blog->spam;
		$blog_deleted = $current_blog->deleted;
	} else {
		$blog_types = get_blog_option($blog_ID,"blog_types");
		$blog_subtypes = get_blog_option($blog_ID,"blog_subtypes");
		$blog_details = get_blog_details($blog_ID,true);
		$blog_public = $blog_details->public;
		$blog_archived = $blog_details->archived;
		$blog_mature = $blog_details->mature;
		$blog_spam = $blog_details->spam;
		$blog_deleted = $blog_details->deleted;
	}
	
	if ($blog_types != '' && $blog_types != 'NA') {
		if ($blog_public == 1 && $blog_archived == 0 && $blog_mature == 0 && $blog_spam == 0 && $blog_deleted == 0){
			$global_count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "blog_types WHERE blog_ID = '" . $blog_ID . "'");
			if ($global_count > 0){
				//update row in global table
				$wpdb->query( "UPDATE " . $wpdb->base_prefix . "blog_types SET blog_types = '" . $blog_types . "'  WHERE blog_ID = '" . $blog_ID . "'" );
				$wpdb->query( "UPDATE " . $wpdb->base_prefix . "blog_types SET blog_subtypes = '" . $blog_subtypes . "'  WHERE blog_ID = '" . $blog_ID . "'" );
			} else {
				//insert into global table
				$wpdb->query( "INSERT INTO " . $wpdb->base_prefix . "blog_types (blog_ID, blog_types, blog_subtypes) VALUES ( '" . $blog_ID . "', '" . $blog_types . "', '" . $blog_subtypes . "' )" );
			}
		} else {
			//remove from global table
			$wpdb->query("DELETE FROM " . $wpdb->base_prefix . "blog_types WHERE blog_ID = '" . $blog_ID . "'");		
		}	
	}
	do_action('blog_types_update', $blog_ID);
	do_action('blog_subtypes_update', $blog_ID);
}

function blog_types_import() {
	global $wpdb, $current_blog;
	if (get_option("blog_types_imported") != '1') {
		$signup_blog_types_count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "signup_blog_types WHERE blog_types_domain = '" . $current_blog->domain . "' AND blog_types_path = '" . $current_blog->path . "'");
		if ($signup_blog_types_count > 0) {
			//info was provided at signup
			$selected_blog_types = $wpdb->get_var("SELECT blog_types FROM " . $wpdb->base_prefix . "signup_blog_types WHERE blog_types_domain = '" . $current_blog->domain . "' AND blog_types_path = '" . $current_blog->path . "'");
			update_option('blog_types', $selected_blog_types);
			if ( $selected_blog_types == '|' ) {
				$selected_blog_types = 'NA';
			}
			$selected_blog_subtypes = $wpdb->get_var("SELECT blog_subtypes FROM " . $wpdb->base_prefix . "signup_blog_types WHERE blog_types_domain = '" . $current_blog->domain . "' AND blog_types_path = '" . $current_blog->path . "'");
			if ( $selected_blog_subtypes == '|' ) {
				$selected_blog_subtypes = 'NA';
			}
			update_option('blog_subtypes', $selected_blog_subtypes);
		} else {
			//no info provided at signup
			update_option('blog_types', 'NA');
			update_option('blog_subtypes', 'NA');
		}
		update_option("blog_types_imported", '1');
		blog_types_global_sync();
	}
}

function blog_types_plug_pages() {
	global $blog_types, $blog_types_selection, $blog_types_branding_singular, $blog_types_branding_plural;
	if ( current_user_can('manage_options') ) {
		if (count($blog_types) > 1){
			if ($blog_types_selection == 'single'){
				add_submenu_page('options-general.php', $blog_types_branding_singular, $blog_types_branding_singular, '0', 'blog-types', 'blog_types_manage_output' );
			} else {
				add_submenu_page('options-general.php', $blog_types_branding_plural, $blog_types_branding_plural, '0', 'blog-types', 'blog_types_manage_output' );
			}
		}
	}
}
function blog_types_signup_form_validate($content){
	global $blog_types, $blog_subtypes, $blog_types_selection, $blog_subtypes_selection, $blog_types_branding_singular, $blog_types_branding_plural, $blog_subtypes_branding_singular, $blog_subtypes_branding_plural, $blog_types_enable_subtypes;
	//blog types
	if (count($blog_types) > 0){
		if (count($blog_types) > 1){
			if ($blog_types_selection == 'single' || $blog_types_selection == ''){
				if($_POST['stage'] == 'validate-blog-signup' || $_POST['stage'] == 'gimmeanotherblog') {
					if ( empty( $_POST['blog_type'] ) ){
							$content['errors']->add('blog_type', __('You must select a ' . strtolower($blog_types_branding_singular) . '.'));
					}
				}
			} else if ($blog_types_selection == 'multiple') {
				if($_POST['stage'] == 'validate-blog-signup' || $_POST['stage'] == 'gimmeanotherblog') {
					if ( empty( $_POST['blog_types'] ) ){
							$content['errors']->add('blog_types', __('You must select at least one ' . strtolower($blog_types_branding_singular) . '.'));
					}
				}
			}		
		}
	}
	//blog subtypes
	if ( $blog_types_enable_subtypes == 'yes' && $blog_types_selection == 'single' && $blog_subtypes_selection == 'multiple' ) {
		if($_POST['stage'] == 'validate-blog-signup' || $_POST['stage'] == 'gimmeanotherblog') {
			if ( empty( $_POST['blog_subtypes'] ) ){
					$content['errors']->add('blog_subtypes', __('You must select at least one ' . strtolower($blog_subtypes_branding_singular) . '.'));
			}
		}
	}
	return $content;
}
function blog_types_signup_form_process($content){
	global $wpdb, $blog_types, $blog_subtypes, $blog_types_selection, $blog_subtypes_selection, $blog_types_branding_singular, $blog_types_branding_plural, $blog_subtypes_branding_singular, $blog_subtypes_branding_plural, $blog_types_enable_subtypes;

	$content_original = $content;
	extract($content);

	if ( $errors->get_error_code() ) {
		//error
	} else {
		//no error
		//blog types
		if ($blog_types_selection == 'single'){
			$selected_blog_types = '|' . $_POST['blog_type'] . '|';
		} else if ($blog_types_selection == 'multiple') {
			$selected_blog_types = '|' . join("|", $_POST['blog_types']) . '|';
		}
		//blog subtypes
		if ($blog_subtypes_selection == 'single'){
			$selected_blog_subtypes = '|' . $_POST['blog_subtype'] . '|';
			$selected_blog_types = str_replace("||","|",$selected_blog_types);
		} else if ($blog_subtypes_selection == 'multiple') {
			$selected_blog_subtypes = '|' . join("|", $_POST['blog_subtypes']) . '|';
			$selected_blog_subtypes = str_replace("||","|",$selected_blog_subtypes);
		}
		$wpdb->query( "INSERT INTO " . $wpdb->base_prefix . "signup_blog_types (blog_types_domain, blog_types_path, blog_types, blog_subtypes) VALUES ( '" . $domain . "', '" . $path . "', '" . $selected_blog_types . "', '" . $selected_blog_subtypes . "' )" );
	}

	return $content_original;
}
//------------------------------------------------------------------------//
//---Output Functions-----------------------------------------------------//
//------------------------------------------------------------------------//

function blog_types_stylesheet() {
?>
<style type="text/css">
	.mu_register #blog_subtype,
	.mu_register #blog_subtypes,
	.mu_register #blog_type,
	.mu_register #blog_types { width:100%; font-size: 24px; margin:5px 0; }
</style>
<?php
}

function blog_types_subtype_admin_js() {
	global $blog_types, $blog_subtypes, $blog_types_selection, $blog_subtypes_selection;

	if ( $blog_types_selection == 'single' ) {
		if ( $blog_subtypes_selection == 'single' ) {
			$form_item_id = 'blog_subtype';
			$post_item_name = 'blog_subtype';
		} else {
			$form_item_id = 'blog_subtypes[]';
			$post_item_name = 'blog_subtypes';
		}
		?>
		<SCRIPT language="JavaScript">
		<!--
		function update_subtypes_box() {
			var types_box = document.getElementById('blog_type');
			var types_box_value = types_box.options[types_box.selectedIndex].value;
			var subtypes_box = document.getElementById('<?php echo $form_item_id; ?>');
			subtypes_box.options.length=0;
			<?php
				foreach ( $blog_types as $blog_type ) {
					?>
					if ( types_box_value == '<?php echo $blog_type['nicename']; ?>' ) {
						<?php
						$loop_count = 0;
						foreach ( $blog_subtypes as $blog_subtype ) {
							if ( $blog_subtype['type_nicename'] == $blog_type['nicename'] ) {
								?>
								subtypes_box.options[<?php echo $loop_count; ?>]=new Option("<?php echo $blog_subtype['name']; ?>", "<?php echo $blog_subtype['nicename']; ?>", false, false);
								<?php
								$loop_count = $loop_count + 1;
							}
						}
						?>
					}
					<?php
				}
			?>
		}
		//-->
		</SCRIPT>
		<?php
	}
}

function blog_types_subtype_signup_js() {
	global $blog_types, $blog_subtypes, $blog_types_selection, $blog_subtypes_selection;

	if ( $blog_types_selection == 'single' ) {
		if ( $blog_subtypes_selection == 'single' ) {
			$form_item_id = 'blog_subtype';
			$post_item_name = 'blog_subtype';
		} else {
			$form_item_id = 'blog_subtypes[]';
			$post_item_name = 'blog_subtypes';
		}
		?>
		<SCRIPT language="JavaScript">
		<!--
		function update_subtypes_box() {
			var types_box = document.getElementById('blog_type');
			var types_box_value = types_box.options[types_box.selectedIndex].value;
			var subtypes_box = document.getElementById('<?php echo $form_item_id; ?>');
			subtypes_box.options.length=0;
			<?php
				foreach ( $blog_types as $blog_type ) {
					?>
					if ( types_box_value == '<?php echo $blog_type['nicename']; ?>' ) {
						<?php
						$loop_count = 0;
						foreach ( $blog_subtypes as $blog_subtype ) {
							if ( $blog_subtype['type_nicename'] == $blog_type['nicename'] ) {
								?>
								subtypes_box.options[<?php echo $loop_count; ?>]=new Option("<?php echo $blog_subtype['name']; ?>", "<?php echo $blog_subtype['nicename']; ?>", false, false);
								<?php
								$loop_count = $loop_count + 1;
							}
						}
						?>
					}
					<?php
				}
			?>
		}
		
		function setup_subtypes_box() {
			var types_box = document.getElementById('blog_type');
			var types_box_value = types_box.options[types_box.selectedIndex].value;
			var subtypes_box = document.getElementById('<?php echo $form_item_id; ?>');
			subtypes_box.options.length=0;
			<?php
				foreach ( $blog_types as $blog_type ) {
					?>
					if ( types_box_value == '<?php echo $blog_type['nicename']; ?>' ) {
						<?php
						$loop_count = 0;
						foreach ( $blog_subtypes as $blog_subtype ) {
							if ( $blog_subtype['type_nicename'] == $blog_type['nicename'] ) {
								if ( $blog_subtypes_selection == 'single' ) {
									if ( $blog_subtype['nicename'] == $_POST[$post_item_name] ) {
										$subtype_selected = 'true';
									} else {
										$subtype_selected = 'false';
									}
								} else {
									if ( !empty( $_POST[$post_item_name] ) ) {
										$selected_blog_subtypes = $_POST[$post_item_name];
										$subtype_selected = 'false';
										foreach ( $selected_blog_subtypes as $selected_blog_subtype ) {
											if ( $selected_blog_subtype == $blog_subtype['nicename'] ) {
												$subtype_selected = 'true';
											}
										}
									} else {
										$subtype_selected = 'false';
									}
								}
								?>
								subtypes_box.options[<?php echo $loop_count; ?>]=new Option("<?php echo $blog_subtype['name']; ?>", "<?php echo $blog_subtype['nicename']; ?>", false, <?php echo $subtype_selected; ?>);
								<?php
								$loop_count = $loop_count + 1;
							}
						}
						?>
					}
					<?php
				}
			?>
		}
		window.onload = setup_subtypes_box;
		//-->
		</SCRIPT>
		<?php
	}
}

function blog_types_signup_form($errors) {
	global $blog_types, $blog_subtypes, $blog_types_selection, $blog_subtypes_selection, $blog_types_branding_singular, $blog_types_branding_plural, $blog_subtypes_branding_singular, $blog_subtypes_branding_plural, $blog_types_enable_subtypes;

	if ($blog_types_selection == 'single' || $blog_types_selection == ''){
		$selected_blog_type = $_POST['blog_type'];
	} else {
		$selected_blog_types = $_POST['blog_types'];
	}
	if (count($blog_types) > 0){
		if ($blog_types_selection == 'single' || $blog_types_selection == ''){
			$error = $errors->get_error_message('blog_type');
			?>
			<label for="blog_type"><?php _e($blog_types_branding_singular) ?>:</label>
			<?php
			if($error) {
				echo '<p class="error">' . $error . '</p>';
			}
			?>
			<select name="blog_type" id="blog_type" <?php if ( $blog_types_enable_subtypes == 'yes' ) { echo 'onchange="update_subtypes_box()"'; } ?> style="width: 90%; text-align: left; font-size: 20px;">
				<?php
				if ( empty( $_POST['blog_type'] ) && $blog_types_enable_subtypes != 'yes' ) {
					echo '<option value=""> </option>';
				}
				foreach ($blog_types as $blog_type) {
					echo '<option value="' . $blog_type['nicename'] . '"'.(($selected_blog_type == $blog_type['nicename']) ? ' selected="selected"' : '').'> ' . $blog_type['name'] . '</option>';
				}
				?>
			</select>
			<?php
		} else if ($blog_types_selection == 'multiple') {
			$error = $errors->get_error_message('blog_types');
			?>
			<label for="blog_types"><?php _e($blog_types_branding_plural) ?>:</label>
			<?php
			if($error) {
				echo '<p class="error">' . $error . '</p>';
			}
			?>
			<select name="blog_types[]" id="blog_types[]" multiple="multiple" <?php if ( $blog_types_enable_subtypes == 'yes' ) { echo 'onchange="update_subtypes_box()"'; } ?> style="width: 90%; text-align: left; font-size: 20px;"  size="4">
				<?php
				foreach ($blog_types as $blog_type) {
					if ( !empty( $_POST['blog_types'] ) ) {
						$selected_blog_types = $_POST['blog_types'];
						$selected = '';
						foreach ( $selected_blog_types as $selected_blog_type ) {
							if ( $selected_blog_type == $blog_type['nicename'] ) {
								$selected = ' selected="selected"';
							}
						}
					}
					echo '<option value="' . $blog_type['nicename'] . '"' . $selected . '> ' . $blog_type['name'] . '</option>';
				}
				?>
			</select>
			<?php
		}
		if ( $blog_types_enable_subtypes == 'yes' && $blog_types_selection == 'single' ) {
			if ($blog_subtypes_selection == 'single' || $blog_subtypes_selection == ''){
				$error = $errors->get_error_message('blog_subtype');
				?>
				<label for="blog_subtype"><?php _e($blog_subtypes_branding_singular) ?>:</label>
				<?php
				if($error) {
					echo '<p class="error">' . $error . '</p>';
				}
				?>
				<select name="blog_subtype" id="blog_subtype" style="width: 90%; text-align: left; font-size: 20px;">
					<?php
					echo '<option value=""> ' . __('Please select a ') . $blog_subtypes_branding_singular . '</option>';
					foreach ($blog_subtypes as $blog_subtype) {
						echo '<option value="' . $blog_subtype['nicename'] . '"> ' . $blog_subtype['name'] . '</option>';
					}
					?>
				</select>
				<?php
			} else if ($blog_subtypes_selection == 'multiple') {
				$error = $errors->get_error_message('blog_subtypes');
				?>
				<label for="blog_subtypes"><?php _e($blog_subtypes_branding_plural) ?>:</label>
				<?php
				if($error) {
					echo '<p class="error">' . $error . '</p>';
				}
				?>
				<select name="blog_subtypes[]" id="blog_subtypes[]" multiple="multiple" style="width: 90%; text-align: left; font-size: 20px;"  size="4">
					<?php
					foreach ($blog_subtypes as $blog_subtype) {
						echo '<option value="' . $blog_subtype['nicename'] . '"> ' . $blog_subtype['name'] . '</option>';
					}
					?>
				</select>
				<?php
			}
		}
	}
}

function blog_types_blog_edit($id) {
	global $wpdb, $blog_types, $blog_types_branding_singular, $blog_types_branding_plural;
	blog_types_global_sync($id);
	$tmp_blog_types = explode('|', get_blog_option($id,"blog_types"));
	?>
	<tr valign="top"> 
		<th scope="row"><?php _e($blog_types_branding_singular) ?>:</th> 
		<td>
		<select name="option[blog_types]" id="option[blog_types]">
			<?php
			foreach ($blog_types as $blog_type) {
				$tmp_found = '0';
				foreach ($tmp_blog_types as $tmp_blog_type) {
					if ($tmp_blog_type == $blog_type['nicename']){
						$tmp_found = '1';
					}
				}
				if ($tmp_found == '1'){
					echo '<option value="|' . $blog_type['nicename'] . '|"  selected="selected"> ' . $blog_type['name'] . '</option>';
				} else {
					echo '<option value="|' . $blog_type['nicename'] . '|"> ' . $blog_type['name'] . '</option>';
				}
			}
			?>
		</select>
		</td>
	</tr>
	<?php
}

//------------------------------------------------------------------------//
//---Page Output Functions------------------------------------------------//
//------------------------------------------------------------------------//

function blog_types_manage_output() {
	global $wpdb, $blog_types, $blog_subtypes, $blog_types_selection, $blog_subtypes_selection, $blog_types_branding_singular, $blog_types_branding_plural, $blog_subtypes_branding_singular, $blog_subtypes_branding_plural, $blog_types_enable_subtypes;
	
	if(!current_user_can('edit_users')) {
		echo "<p>" . __('Nice Try...') . "</p>";  //If accessed properly, this message doesn't appear.
		return;
	}
	/*
	if (isset($_GET['updated'])) {
		?><div id="message" class="updated fade"><p><?php _e('' . urldecode($_GET['updatedmsg']) . '') ?></p></div><?php
	}
	*/
	echo '<div class="wrap">';
	switch( $_GET[ 'action' ] ) {
		//---------------------------------------------------//
		default:
		
		blog_types_global_sync();
		
		$selected_blog_types = explode('|', get_option("blog_types"));
		$selected_blog_subtypes = explode('|', get_option("blog_subtypes"));
		
		if ($blog_types_selection == 'single'){
		?>
            <h2><?php _e($blog_types_branding_singular) ?></h2>
        <?php
		} else {
		?>
            <h2><?php _e($blog_types_branding_plural) ?></h2>
        <?php
		}
		?>
            <form method="post" action="options-general.php?page=blog-types&action=update"> 
            <table class="form-table">
            <tr valign="top"> 
            <?php
			if ($blog_types_selection == 'single'){
			?>
                <th scope="row"><?php _e($blog_types_branding_singular) ?>:</th> 
                <td>
				<select name="blog_type" id="blog_type" <?php if ( $blog_types_enable_subtypes == 'yes' ) { echo 'onchange="update_subtypes_box()"'; } ?> >
					<?php
					foreach ($blog_types as $blog_type) {
						$selected = '';
						foreach ($selected_blog_types as $selected_blog_type) {
							if ($selected_blog_type == $blog_type['nicename']){
								$selected = ' selected="selected"';
								$selected_blog_type_store = $blog_type['nicename'];
							}
						}
						echo '<option value="' . $blog_type['nicename'] . '" ' . $selected . '> ' . $blog_type['name'] . '</option>';
					}
					?>
				</select>
                </td>
			<?php
			} else {
			?>
                <th scope="row"><?php _e($blog_types_branding_plural) ?>:</th> 
                <td>
				<select name="blog_types[]" id="blog_types[]" multiple="multiple" <?php if ( $blog_types_enable_subtypes == 'yes' ) { echo 'onchange="update_subtypes_box()"'; } ?> style="width:250px; height:150px;" size="10">
					<?php
					foreach ($blog_types as $blog_type) {
						$selected = '';
						foreach ($selected_blog_types as $selected_blog_type) {
							if ($selected_blog_type == $blog_type['nicename']){
								$selected = ' selected="selected"';
							}
						}
						echo '<option value="' . $blog_type['nicename'] . '" ' . $selected . '> ' . $blog_type['name'] . '</option>';
					}
					?>
				</select>
                </td>
			<?php
			}
			?>
            </tr>
            <?php
            if ( $blog_types_enable_subtypes == 'yes' && $blog_types_selection == 'single' ) {
			?>
            <tr valign="top"> 
            <?php
			if ($blog_subtypes_selection == 'single'){
			?>
                <th scope="row"><?php _e($blog_subtypes_branding_singular) ?>:</th> 
                <td>
				<select name="blog_subtype" id="blog_subtype">
					<?php
					foreach ($blog_subtypes as $blog_subtype) {
						if ( $blog_subtype['type_nicename'] == $selected_blog_type_store ) {
							$selected = '';
							foreach ($selected_blog_subtypes as $selected_blog_subtype) {
								if ($selected_blog_subtype == $blog_subtype['nicename']){
									$selected = ' selected="selected"';
								}
							}
							echo '<option value="' . $blog_subtype['nicename'] . '" ' . $selected . '> ' . $blog_subtype['name'] . '</option>';
						}
					}
					?>
				</select>
                </td>
			<?php
			} else {
			?>
                <th scope="row"><?php _e($blog_subtypes_branding_plural) ?>:</th> 
                <td>
				<select name="blog_subtypes[]" id="blog_subtypes[]" multiple="multiple" style="width:250px; height:150px;" size="10">
					<?php
					foreach ($blog_subtypes as $blog_subtype) {
						if ( $blog_subtype['type_nicename'] == $selected_blog_type_store ) {
							$selected = '';
							foreach ($selected_blog_subtypes as $selected_blog_subtype) {
								if ($selected_blog_subtype == $blog_subtype['nicename']){
									$selected = ' selected="selected"';
								}
							}
							echo '<option value="' . $blog_subtype['nicename'] . '" ' . $selected . '> ' . $blog_subtype['name'] . '</option>';
						}
					}
					?>
				</select>
                </td>
			<?php
			}
			?>
            </tr>
            <?php
            }
			?>
            </table>
            <p class="submit">
            <input type="submit" name="Submit" value="<?php _e('Save Changes') ?>" />
            </p>
            </form>
        <?php
		break;
		//---------------------------------------------------//
		case "update":
			$selected_blog_types = $_POST['blog_type'];
			if ( empty( $selected_blog_types ) ) {
				$selected_blog_types = $_POST['blog_types'];
			}
			$selected_blog_subtypes = $_POST['blog_subtype'];
			if ( empty( $selected_blog_subtypes ) ) {
				$selected_blog_subtypes = $_POST['blog_subtypes'];
			}
			if ( empty( $selected_blog_types ) && empty( $selected_blog_subtypes ) ){
				echo "
				<SCRIPT LANGUAGE='JavaScript'>
				window.location='options-general.php?page=blog-types';
				</script>
				";		
			} else {
				if ($blog_types_selection == 'single'){
					$selected_blog_types = '|' . $selected_blog_types . '|';
					update_option('blog_types', $selected_blog_types);
				} else {
					$selected_blog_types = '|' . join("|", $selected_blog_types) . '|';
					update_option('blog_types', $selected_blog_types);
				}
				if ($blog_subtypes_selection == 'single'){
					$selected_blog_subtypes = '|' . $selected_blog_subtypes . '|';
					update_option('blog_subtypes', $selected_blog_subtypes);
				} else {
					$selected_blog_subtypes = '|' . join("|", $selected_blog_subtypes) . '|';
					update_option('blog_subtypes', $selected_blog_subtypes);
				}
				blog_types_global_sync();
				echo "
				<SCRIPT LANGUAGE='JavaScript'>
				window.location='options-general.php?page=blog-types&updated=true&updatedmsg=" . urlencode(__('Settings saved.')) . "';
				</script>
				";
			}
		break;
		//---------------------------------------------------//
	}
	echo '</div>';
}

//------------------------------------------------------------------------//
//---Support Functions----------------------------------------------------//
//------------------------------------------------------------------------//

?>