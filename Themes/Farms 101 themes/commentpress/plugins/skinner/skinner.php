<?php
/* 
Plugin Name: Skinner
Version: 0.0.5
Plugin URI: http://windyroad.org/software/wordpress/skinner-plugin
Description: Provides the ability to apply different skins to a theme
Author: Windy Road
Author URI: http://windyroad.com

Copyright (C)2007 Windy Road

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.This work is licensed under a Creative Commons Attribution 2.5 Australia License http://creativecommons.org/licenses/by/2.5/au/
*/ 

$_BENICE[]='skinner;6770968883708243;5432787455';

require_once( 'skin_switcher.php' );

function get_skin_root() {
	return apply_filters('skin_root', get_template_directory() . '/skins' );
}
function get_skin_root_uri() {
	return apply_filters('skin_root_uri', get_template_directory_uri() . '/skins' );
}

function get_skin() {
	$skin = skinner_get_selected_skin();
	if (empty($skin)) {
		$skin = get_option('skin');
	}
	return apply_filters('skin', $skin);
}

function get_skin_directory() {
	$skin = get_skin();
	$skin_dir = get_skin_root() . "/$skin";
	return apply_filters('skin_directory', $skin_dir, $skin);
}
function get_skin_directory_uri() {
	$skin = get_skin();
	$skin_dir_uri = get_skin_root_uri() . "/$skin";
	return apply_filters('skin_directory_uri', $skin_dir_uri, $skin);
}


function get_skin_data( $skin_file ) {
	$skin_data = implode( '', file( $skin_file ) );
	$skin_data = str_replace ( '\r', '\n', $skin_data );
	preg_match( '|Skin Name:(.*)|i', $skin_data, $skin_name );
	preg_match( '|Skin URI:(.*)|i', $skin_data, $skin_uri );
	preg_match( '|Description:(.*)|i', $skin_data, $description );
	preg_match( '|Author:(.*)|i', $skin_data, $author_name );
	preg_match( '|Author URI:(.*)|i', $skin_data, $author_uri );
	if ( preg_match( '|Parent Skin:(.*)|i', $skin_data, $parent ) )
		$parent = trim( $parent[1] );
	else
		$parent = null;
		
	if ( preg_match( '|Version:(.*)|i', $skin_data, $version ) )
		$version = trim( $version[1] );
	else
		$version ='';
	if ( preg_match('|Status:(.*)|i', $skin_data, $status) )
		$status = trim($status[1]);
	else
		$status = 'publish';

	$description = wptexturize( trim( $description[1] ) );

	$name = $skin_name[1];
	$name = trim( $name );
	$skin = $name;

	if ( '' == $author_uri[1] ) {
		$author = trim( $author_name[1] );
	} else {
		$author = '<a href="' . trim( $author_uri[1] ) . '" title="' . __('Visit author homepage') . '">' . trim( $author_name[1] ) . '</a>';
	}

	return array( 'Name' => $name, 'Title' => $skin, 'Description' => $description, 
				  'Author' => $author, 'Version' => $version, 'Parent Skin' => $parent,
				  'Status' => $status );
}


function get_skins() {
	global $wp_skins, $wp_broken_skins;

	if( isset( $wp_skins ) )
		return $wp_skins;
		
	$skins = array();
	$wp_broken_skins = array();
	$skin_root = get_skin_root();
	$skin_loc = str_replace(ABSPATH, '', $skin_root);
	// Files in wp-content/skins directory and one subdir down
	$skins_dir = @ dir($skin_root);
	if ( !$skins_dir )
		return false;
	while ( ($skin_dir = $skins_dir->read()) !== false ) {
		if ( is_dir($skin_root . '/' . $skin_dir) && is_readable($skin_root . '/' . $skin_dir) ) {
			if ( $skin_dir{0} == '.' || $skin_dir == '..' || $skin_dir == 'CVS' )
				continue;
			$stylish_dir = @ dir($skin_root . '/' . $skin_dir);
			$found_stylesheet = false;
			while ( ($skin_file = $stylish_dir->read()) !== false ) {
				if ( $skin_file == 'style.css' || $skin_file == 'style.css.php' ) {
					$skin_files[] = $skin_dir . '/' . $skin_file;
					$found_stylesheet = true;
					break;
				}
			}
			if ( !$found_stylesheet ) { 
				$wp_broken_skins[$skin_dir] = array('Name' => $skin_dir, 'Title' => $skin_dir, 'Description' => __("Stylesheet is missing: $skin_root/$skin_dir/style.css"));
			}
		}
	}

	if ( !$skins_dir || !$skin_files )
		return $skins;

	sort($skin_files);

	foreach ( (array) $skin_files as $skin_file ) {
		if ( !is_readable("$skin_root/$skin_file") ) {
			$wp_broken_skins[$skin_file] = array('Name' => $skin_file, 'Title' => $skin_file, 'Description' => __("File not readable: $skin_root/$skin_file"));
			continue;
		}

		$skin_data = get_skin_data("$skin_root/$skin_file");
		$name        = $skin_data['Name'];
		$title       = $skin_data['Title'];
		$description = wptexturize($skin_data['Description']);
		$version     = $skin_data['Version'];
		$author      = $skin_data['Author'];
		$stylesheet  = dirname($skin_file);
		$screenshot = null;
		
		foreach ( array('png', 'gif', 'jpg', 'jpeg') as $ext ) {
			if (file_exists("$skin_root/$stylesheet/screenshot.$ext")) {
				$screenshot = "screenshot.$ext";
				break;
			}
		}
		if ( empty($name) ) {
			$name = dirname($skin_file);
			$title = $name;
		}

		$stylesheet_files = array();
		$template_files = array();
		$stylesheet_dir = @ dir("$skin_root/$stylesheet");
		if ( $stylesheet_dir ) {
			while ( ($file = $stylesheet_dir->read()) !== false ) {
				if ( !preg_match('|^\.+$|', $file) ) {
					if( preg_match('|\.css(\.php)?$|', $file) ) {
						$stylesheet_files[] = "$skin_loc/$stylesheet/$file";
					}
					else if( preg_match('|\.php$|', $file) ) {
						$template_files[] = "$skin_loc/$stylesheet/$file";
					}
				}
			}
		}

		$stylesheet_dir = dirname($stylesheet_files[0]);

		if ( empty($stylesheet_dir) )
			$stylesheet_dir = '/';
		// Check for skin name collision.  This occurs if a skin is copied to
		// a new skin directory and the skin header is not updated.  Whichever
		// skin is first keeps the name.  Subsequent skins get a suffix applied.
		// The Default and Shiny and Citrus skins always trump their pretenders.
		if ( isset($skins[$name]) ) {
			if ( ('Default' == $name || 'Citrus' == $name || 'Shiny' == $name ) &&
				 ('default' == $stylesheet || 'citrus' == $stylesheet || 'shiny' == $stylesheet ) ) {
				// If another skin has claimed to be one of our default skins, move
				// them aside.
				$suffix = $skins[$name]['Stylesheet'];
				$new_name = "$name/$suffix";
				$skins[$new_name] = $skins[$name];
				$skins[$new_name]['Name'] = $new_name;
			} else {
				$name = "$name/$stylesheet";
			}
		}
		$skins[$name] = array('Name' => $name,
							  'Title' => $title,
							  'Description' => $description,
							  'Author' => $author,
							  'Version' => $version,
							  'Stylesheet' => $stylesheet,
							  'Stylesheet Files' => $stylesheet_files,
							  'Template Files' => $template_files,
							  'Stylesheet Dir' => $stylesheet_dir, 
							  'Status' => $skin_data['Status'], 
							  'Screenshot' => $screenshot,
							  'Parent Skin' => $skin_data['Parent Skin']);
	}

	// Chek skin dependencies.
	$skin_names = array_keys($skins);

	foreach ( (array) $skin_names as $skin_name ) {
		$parent = $skins[$skin_name]['Parent Skin'];
		if ( $parent ) {
			if( !isset( $skins[ $parent ] ) ) {
				$wp_broken_skins[$skin_file] = array('Name' => $skins[$skin_name]['Name'], 'Title' => $skins[$skin_name]['Title'], 'Description' => __("Parent skin not found: $parent"));
				unset( $skins[$skin_name] );
			}
		}
	}

	$wp_skins = $skins;

	return $skins;
}

function validate_current_skin() {
	// Don't validate during an install/upgrade.
	if ( defined('WP_INSTALLING') )
		return true;

	if ( get_skin() != 'default' && !file_exists(get_skin_directory() . '/style.css') && !file_exists(get_skin_directory() . '/style.css.php') ) {
		update_option('skin', 'default');
		do_action('switch_skin', 'Default');
		return false;
	}

	return true;
}

function get_current_skin() {
	$skins = get_skins();
	if( !$skins )
		return;
	$current_skin = get_skin();
	foreach( $skins as $skin ) {
		if( $skin[ 'Stylesheet'] == $current_skin ) {
			return $skin[ 'Name'];
		}
	}
	return 'Default';
}

function current_skin_info() {
        $skins = get_skins();
        $current_skin = get_current_skin();
        $cs->name = $current_skin;
        $cs->title = $skins[$current_skin]['Title'];
        $cs->version = $skins[$current_skin]['Version'];
        $cs->parent_skin = $skins[$current_skin]['Parent Skin'];
        $cs->stylesheet_dir = $skins[$current_skin]['Stylesheet Dir'];
        $cs->stylesheet = $skins[$current_skin]['Stylesheet'];
        $cs->screenshot = $skins[$current_skin]['Screenshot'];
        $cs->description = $skins[$current_skin]['Description'];
        $cs->author = $skins[$current_skin]['Author'];
        $cs->stylesheet_files = $skins[$current_skin]['Stylesheet Files'];
        return $cs;
}

function get_blogskinstyles() {
	$skins = get_skins();
	if( !$skins )
		return;
	$cs = current_skin_info();
	$styles = array();
	foreach( $cs->stylesheet_files as $file ) {
		$url = get_option('siteurl') . '/' . $file;
		if( preg_match('|\-ie\.css\.php?$|', $file) ) {
			$url = add_query_arg( 'skin', $cs->stylesheet, $url );
		}
		$styles[] = $url;
	}
	return apply_filters('skinstyles', $styles );
}

function blogskinstyles() {
	$urls = get_blogskinstyles();
	if( !$urls )
		return;
	foreach( $urls as $url ) {
		if( !preg_match('|\-ie\.css(\.php)?|', $url) ) {
?>
<link rel="stylesheet" href="<?php echo $url ?>" type="text/css" />
<?php
		}
	}
	// always process ie after
	foreach( $urls as $url ) {
		if( preg_match('|\-ie\.css(\.php)?|', $url) ) {
?>
<!--[if lte IE 6]>
<link rel="stylesheet" href="<?php echo $url ?>" type="text/css" media="screen" />
<![endif]-->
<?php
		}
	}
}


function get_broken_skins() {
        global $wp_broken_skins;

        get_skins();
        return $wp_broken_skins;
}

function add_skins_admin() {
    global $wp_skin, $wp_broken_skins;

	if ( isset($_GET['action']) ) {
		if ('activateskin' == $_GET['action']) {
			if ( isset($_GET['skin']) ) {
				update_option('skin', $_GET['skin']);
			}
			
			do_action('switch_skin', get_current_skin());

			wp_redirect('themes.php?page=skinner.php&activated=true');
			exit;
		}
	}
    add_theme_page('Manage Skins', 'Skins', 'edit_themes', basename(__FILE__), 'skin_admin');
}

function skin_admin() {
?>
<?php if ( ! validate_current_skin() ) : ?>
<div id="message1" class="updated fade"><p><?php _e('The active skin is broken.  Reverting to the default skin.'); ?></p></div>
<?php elseif ( isset($_GET['activated']) ) : ?>
<div id="message2" class="updated fade"><p><?php printf(__('New skin activated. <a href="%s">View site &raquo;</a>'), get_bloginfo('home') . '/'); ?></p></div>
<?php endif; ?>

<?php
$skins = get_skins();
$ct = current_skin_info();
?>

<div class="wrap">
<h2><?php _e('Current Skin'); ?></h2>
<div id="currenttheme">
<?php if ( $ct->screenshot ) : ?>
<img src="<?php echo get_skin_directory_uri() . '/' . $ct->screenshot; ?>" alt="<?php _e('Current skin preview'); ?>" />
<?php endif; ?>
<h3><?php printf(__('%1$s %2$s by %3$s'), $ct->title, $ct->version, $ct->author) ; ?></h3>
<p><?php echo $ct->description; ?></p>
<?php if ($ct->parent_skin) { ?>
	<p><?php printf(__('The stylesheet files are located in <code>%2$s</code>.  <strong>%3$s</strong> uses files from <strong>%4$s</strong>.  Changes made to %4$s files will affect both skins.'), $ct->title, $ct->stylesheet_dir, $ct->title, $ct->parent_skin); ?></p>
<?php } else { ?>
	<p><?php printf(__('All of this skin&#8217;s files are located in <code>%2$s</code>.'), $ct->title, $ct->stylesheet_dir); ?></p>
<?php } ?>
</div>

<h2><?php _e('Available Skins'); ?></h2>
<?php if ( 1 < count($skins) ) { ?>

<?php
$style = '';

$skin_names = array_keys($skins);
natcasesort($skin_names);

foreach ($skin_names as $skin_name) {
	if ( $skin_name == $ct->name )
		continue;
	$stylesheet = $skins[$skin_name]['Stylesheet'];
	$title = $skins[$skin_name]['Title'];
	$version = $skins[$skin_name]['Version'];
	$description = $skins[$skin_name]['Description'];
	$author = $skins[$skin_name]['Author'];
	$screenshot = $skins[$skin_name]['Screenshot'];
	$stylesheet_dir = $skins[$skin_name]['Stylesheet Dir'];
	$activate_link = "themes.php?page=skinner.php&amp;action=activateskin&amp;skin=$stylesheet";
?>
<div class="available-theme">
<h3><a href="<?php echo $activate_link; ?>"><?php echo "$title $version"; ?></a></h3>

<a href="<?php echo $activate_link; ?>" class="screenshot">
<?php if ( $screenshot ) : ?>
<img src="<?php echo get_option('siteurl') . '/' . $stylesheet_dir . '/' . $screenshot; ?>" alt="" />
<?php endif; ?>
</a>

<p><?php echo $description; ?></p>
</div>
<?php } // end foreach skin_names ?>

<?php } ?>

<?php
// List broken skins, if any.
$broken_skins = get_broken_skins();
if ( count($broken_skins) ) {
?>

<h2><?php _e('Broken skins'); ?></h2>
<p><?php _e('The following skins are installed but incomplete.  skins must have a stylesheet called style.css or style.css.php.'); ?></p>

<table width="100%" cellpadding="3" cellspacing="3">
	<tr>
		<th><?php _e('Name'); ?></th>
		<th><?php _e('Description'); ?></th>
	</tr>
<?php
	$skin = '';

	$skin_names = array_keys($broken_skins);
	natcasesort($skin_names);

	foreach ($skin_names as $skin_name) {
		$title = $broken_skins[$skin_name]['Title'];
		$description = $broken_skins[$skin_name]['Description'];

		$skin = ('class="alternate"' == $skin) ? '' : 'class="alternate"';
		echo "
		<tr $skin>
			 <td>$title</td>
			 <td>$description</td>
		</tr>";
	}
?>
</table>
<?php
}
?>

<?php 
	$themes = get_themes();
	$curr_theme = current_theme_info();
	$archive = get_theme_skin_directory( $curr_theme );
	$parent = $curr_theme->title . ' ' . $curr_theme->version;
	if( $archive ) { ?>
<h2><?php _e('Get More Skins'); ?></h2>
<p>You can find additional skins for <?php echo($parent); ?> in the <a href="<?php echo(trim($archive)); ?>"><?php echo($parent); ?> skin directory</a>. To install a skin you generally just need to upload the skin folder into your <code><?php echo $curr_theme->stylesheet_dir; ?>/skins</code> directory. Once a skin is uploaded, you should see it on this page.</p>
</div>

<?php
	}
?>
		<div class="clear"> &nbsp; </div>
<?php
	skinner_admin_footer();
}

function add_skins_editor() {
	if( $_GET[ 'page' ] == 'editskinner.php' ) {
	
		$skin = null;
		if(!isset( $_REQUEST[ 'skin' ] ) ) {
			$skin = get_current_skin();
		}
		else {
			$skin = stripslashes($_REQUEST[ 'skin' ]);
		}

		$skins = get_skins();
			
		$allowed_files = array_merge($skins[$skin]['Stylesheet Files'], $skins[$skin]['Template Files']);

		$file = null;
		if(!isset( $_REQUEST[ 'skinfile' ] )) {
			$file = $allowed_files[0];
		}
		else {
			$file = $_REQUEST[ 'skinfile' ];
		}

		$file = validate_file_to_edit($file, $allowed_files);
		$real_file = get_real_file_to_edit($file);

		$file_show = basename( $file );
		
		$skinaction = null;
		if(isset( $_REQUEST[ 'skinaction' ] )) {
			$skinaction = $_REQUEST[ 'skinaction' ];
		}

		if ( !current_user_can('edit_themes') )
			wp_die('<p>'.__('You do not have sufficient permissions to edit skins for this blog.').'</p>');
		
		switch($skinaction) {
			case 'update':

				check_admin_referer('edit-skin_' . $file . $skin);

				$newcontent = stripslashes($_POST['newcontent']);
				$skin = urlencode($skin);
				if (is_writeable($real_file)) {
					$f = fopen($real_file, 'w+');
					fwrite($f, $newcontent);
					fclose($f);
					$location = "themes.php?page=editskinner.php&skinfile=$file&skin=$skin&a=te";
				} else {
					$location = "themes.php?page=editskinner.php&skinfile=$file&skin=$skin";
				}

				$location = wp_kses_no_null($location);
				$strip = array('%0d', '%0a');
				$location = str_replace($strip, '', $location);
				header("Location: $location");
				exit();

				break;
			case 'switch':
				$skin = urlencode($skin);
				$location = "themes.php?page=editskinner.php&skinfile=$file&skin=$skin";
				$location = wp_kses_no_null($location);
				$strip = array('%0d', '%0a');
				$location = str_replace($strip, '', $location);
				header("Location: $location");
				exit();
			
				break;
				
			default:

		}
	}
	
}

// attribute_escape() was only introduced in wp 2.1 
if( function_exists('attribute_escape')) {
	function skinner_attribute_escape($text) {
		return attribute_escape($text);
	}
}
else {
	function skinner_attribute_escape($text) {
		$safe_text = wp_specialchars($text, true);
		return apply_filters('attribute_escape', $safe_text, $text);
	}
}


function skin_editor() {
	$skin = null;
	if(!isset( $_REQUEST[ 'skin' ] ) ) {
		$skin = get_current_skin();
	} else {
		$skin = stripslashes($_REQUEST[ 'skin' ]);
	}

	$skins = get_skins();
	$allowed_files = array_merge($skins[$skin]['Stylesheet Files'], $skins[$skin]['Template Files']);

	$file = null;
	if(!isset( $_REQUEST[ 'skinfile' ] )) {
		$file = $allowed_files[0];
	}
	else {
		$file = $_REQUEST[ 'skinfile' ];
	}

	$file = validate_file_to_edit($file, $allowed_files);
	$real_file = get_real_file_to_edit($file);

	$file_show = basename( $file );
	
	require_once('admin-header.php');

	update_recently_edited($file);

	if (!is_file($real_file))
		$error = 1;

	if (!$error && filesize($real_file) > 0) {
		$f = fopen($real_file, 'r');
		$content = fread($f, filesize($real_file));
		$content = htmlspecialchars($content);
	}

	if( isset($_GET['a']) ) {
		?><div id="message" class="updated fade"><?php
			?><p><?php _e('File edited successfully.') ?></p><?php
		?></div><?php
	}
 	?><div class="wrap"><?php
		?><form name="theme" action="themes.php?page=editskinner.php" method="post"><?php
			?><input type="hidden" name="skinaction" value="switch" /><?php
				 _e('Select skin to edit:');
				?><select name="skin" id="skin"><?php
					foreach ($skins as $a_skin) {
						$skin_name = $a_skin['Name'];
						if ($skin_name == $skin) $selected = " selected='selected'";
						else $selected = '';
						$skin_name = skinner_attribute_escape($skin_name);
						echo "\n\t<option value=\"$skin_name\" $selected>$skin_name</option>";
					}
				?></select>
		<input type="submit" name="Submit" value="<?php _e('Select &raquo;') ?>" class="button" />
		</form>
		</div>

		<div class="wrap"> 
<?php
	if ( is_writeable($real_file) ) {
		echo '<h2>' . sprintf(__('Editing <code>%s</code>'), $file_show) . '</h2>';
	} else {
		echo '<h2>' . sprintf(__('Browsing <code>%s</code>'), $file_show) . '</h2>';
	}
?>
			<div id="templateside">
				<h3><?php printf(__("<strong>'%s'</strong> skin files"), $skin) ?></h3>

<?php
	if ($allowed_files) :
?>
				<ul>
	<?php foreach($allowed_files as $allowed_file) : ?>
					<li><a href="themes.php?page=editskinner.php&amp;skinfile=<?php echo "$allowed_file"; ?>&amp;skin=<?php echo urlencode($skin) ?>"><?php echo get_file_description($allowed_file); ?></a></li>
	<?php endforeach; ?>
				</ul>
<?php
	endif; ?>
			</div>
<?php
	if (!$error) {
?>
			<form name="template" id="template" action="themes.php?page=editskinner.php" method="post">
	<?php wp_nonce_field('edit-skin_' . $file . $skin) ?>
				<div><textarea cols="70" rows="25" name="newcontent" id="newcontent" tabindex="1"><?php echo $content ?></textarea>
					<input type="hidden" name="skinaction" value="update" />
					<input type="hidden" name="skinfile" value="<?php echo $file ?>" />
					<input type="hidden" name="skin" value="<?php echo $skin ?>" />
				</div>
	<?php if ( is_writeable($real_file) ) : ?>
				<p class="submit">
	<?php
			echo "<input type='submit' name='submit' value='	" . __('Update File &raquo;') . "' tabindex='2' />";
	?>
				</p>
	<?php else : ?>
				<p><em><?php _e('If this file were writable you could edit it.'); ?></em></p>
	<?php endif; ?>
			</form>
	<?php
	}
	else {
		echo '<div class="error"><p>' . __('Oops, no such file exists! Double check the name and try again, merci.') . '</p></div>';
	}
	?>
		<div class="clear"> &nbsp; </div>
		</div>
	<?php
	skinner_admin_footer();
}

function skinner_admin_footer()
{
?>
<p style="text-align: center;">
<a style="text-decoration: none;" href="http://windyroad.org/software/wordpress/skinner-plugin">Skinner Plugin</a><br />
by<br />
<a style="text-decoration: none;" href="http://windyroad.org">
<img src="http://windyroad.org/static/logos/windyroad-105x15.png" style="border: none;" alt="Windy Road" />
</a>
</p>
<?php
}


function get_theme_skin_directory( $curr_theme )
{
	$theme_file = get_stylesheet_directory() . '/style.css';
	$theme_data = implode( '', file( $theme_file ) );
	$theme_data = str_replace ( '\r', '\n', $theme_data );
	if( preg_match( '|Skins URI:(.*)|i', $theme_data, $skin_dir ) )
		return $skin_dir[1];
	else
		return null;
}

function skinner_init() {
	if( get_skins() ) {
		add_action('admin_menu', 'add_skins_admin'); 
		add_action('admin_menu', 'add_skins_editor'); 
		add_action('wp_head', 'blogskinstyles');
		// Check for a functions.php in the selected skin directory
		$vl_skin_functions = get_skin_directory() . "/functions.php";
		if( file_exists( $vl_skin_functions ) ) {
			include( $vl_skin_functions );
		}
	}
}
skinner_init();

?>