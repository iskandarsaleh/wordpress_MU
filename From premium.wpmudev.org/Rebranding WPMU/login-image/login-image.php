<?php
/*
Plugin Name: Login Image
Plugin URI: 
Description:
Author: Andrew Billits (Incsub)
Version: 1.0.2
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

//------------------------------------------------------------------------//
//---Config---------------------------------------------------------------//
//------------------------------------------------------------------------//

//------------------------------------------------------------------------//
//---Hook-----------------------------------------------------------------//
//------------------------------------------------------------------------//
add_action('admin_menu', 'login_image_plug_pages');
add_action('login_head', 'login_image_stylesheet');
//------------------------------------------------------------------------//
//---Functions------------------------------------------------------------//
//------------------------------------------------------------------------//

function login_image_plug_pages() {
	add_submenu_page('wpmu-admin.php', __('Login Image'), __('Login Image'), '0', 'login-image', 'login_image_manage_output' );
}

//------------------------------------------------------------------------//
//---Output Functions-----------------------------------------------------//
//------------------------------------------------------------------------//

function login_image_stylesheet() {
	global $current_site;
	if ( file_exists( ABSPATH . 'wp-content/login-image/login-form-image.png' ) ) {
	?>
	<style type="text/css">
		h1 a {
			background: url(http://<?php echo $current_site->domain . $current_site->path; ?>wp-content/login-image/login-form-image.png) no-repeat;
			width: 326px;
			height: 67px;
			text-indent: -9999px;
			overflow: hidden;
			padding-bottom: 15px;
			display: block;
		}
	</style>
	<?php
	}
}

//------------------------------------------------------------------------//
//---Page Output Functions------------------------------------------------//
//------------------------------------------------------------------------//

function login_image_manage_output() {
	global $wpdb, $current_site;
	
	if(!current_user_can('edit_users')) {
		echo "<p>" . __('Nice Try...') . "</p>";  //If accessed properly, this message doesn't appear.
		return;
	}

	if (isset($_GET['updated'])) {
		?><div id="message" class="updated fade"><p><?php _e('' . urldecode($_GET['updatedmsg']) . '') ?></p></div><?php
	}

	echo '<div class="wrap">';
	switch( $_GET[ 'action' ] ) {
		//---------------------------------------------------//
		default:
		?>
            <h2><?php _e('Login Image') ?></h2>
			<form action="wpmu-admin.php?page=login-image&action=process" method="post" enctype="multipart/form-data">
			<p>
            <p><?php _e('This is the image that is displayed on the login page (wp-login.php).'); ?></p>
            <?php
			if ( file_exists( ABSPATH . 'wp-content/login-image/login-form-image.png' ) ) {
				?>
                <img src="http://<?php echo $current_site->domain . $current_site->path; ?>wp-content/login-image/login-form-image.png?<?php echo md5(time()); ?>" />
                <?php
			} else {
				?>
                <img src="http://<?php echo $current_site->domain . $current_site->path; ?>wp-admin/images/logo-login.gif" />
                <?php
			}
			?>
			</p>
			<h3><?php _e('Change Image'); ?></h3>
			<p>
			  <input name="login_form_image_file" id="login_form_image_file" size="20" type="file">
			  <input type="hidden" name="MAX_FILE_SIZE" value="100000" />
			</p>
			<p><?php _e('Image will be cropped to 310px wide and 70px tall. For best results use an image of this size. Allowed Formats: jpeg, gif, and png'); ?></p>
			<p><?php _e('Note that gif animations will not be preserved.'); ?></p>
			<p class="submit">
			  <input name="Submit" value="<?php _e('Upload') ?>" type="submit">
			  <input name="Reset" value="<?php _e('Reset') ?>" type="submit">
			</p>
			</form>
        <?php
		break;
		//---------------------------------------------------//
		case "process":
			if ( isset( $_POST['Reset'] ) ) {
				login_image_remove_file( ABSPATH . 'wp-content/login-image/login-form-image.png' );
				echo "
				<SCRIPT LANGUAGE='JavaScript'>
				window.location='wpmu-admin.php?page=login-image&updated=true&updatedmsg=" . urlencode(__('Changes saved.')) . "';
				</script>
				";
			} else {
				$login_form_image_path = ABSPATH . 'wp-content/login-image/';
		
				if (is_dir(ABSPATH . 'wp-content/login-image/')) {
				} else {
					mkdir(ABSPATH . 'wp-content/login-image/', 0777);
				}
				$login_form_image_path = ABSPATH . 'wp-content/login-image/' . basename($_FILES['login_form_image_file']['name']);
	
				if(move_uploaded_file($_FILES['login_form_image_file']['tmp_name'], $login_form_image_path)) {
					//file uploaded...
					chmod($login_form_image_path, 0777);
				} else{
					echo __("There was an error uploading the file, please try again.");
				}
				list($login_form_image_width, $login_form_image_height, $login_form_image_type, $login_form_image_attr) = getimagesize($login_form_image_path);
				
				if ($_FILES['login_form_image_file']['type'] == "image/gif"){
					$login_form_image_type = 'gif';
				}
				if ($_FILES['login_form_image_file']['type'] == "image/jpeg"){
					$login_form_image_type = 'jpeg';
				}
				if ($_FILES['login_form_image_file']['type'] == "image/pjpeg"){
					$login_form_image_type = 'jpeg';
				}
				if ($_FILES['login_form_image_file']['type'] == "image/jpg"){
					$login_form_imagee_type = 'jpeg';
				}
				if ($_FILES['login_form_image_file']['type'] == "image/png"){
					$login_form_image_type = 'png';
				}
				if ($_FILES['login_form_image_file']['type'] == "image/x-png"){
					$login_form_image_type = 'png';
				}

				if ($login_form_image_type == 'jpeg'){
					$im = ImageCreateFromjpeg( $login_form_image_path );
				}
				if ($login_form_image_type == 'png'){
					$im = ImageCreateFrompng( $login_form_image_path );
				}
				if ($login_form_image_type == 'gif'){
					$im = ImageCreateFromgif( $login_form_image_path );
				}

				$im_dest = imagecreatetruecolor (310, 70);
				imagecopyresampled($im_dest, $im, 0, 0, 0, 0, 310, 70, $login_form_image_width, $login_form_image_height);
				if ($login_form_image_type == 'png'){
					imagesavealpha($im_dest, true);
				}
				imagepng($im_dest, ABSPATH . 'wp-content/login-image/login-form-image.png');

				login_image_remove_file( $login_form_image_path );

				echo "
				<SCRIPT LANGUAGE='JavaScript'>
				window.location='wpmu-admin.php?page=login-image&updated=true&updatedmsg=" . urlencode(__('Changes saved.')) . "';
				</script>
				";
			}
		break;
		//---------------------------------------------------//
		case "update":

		break;
		//---------------------------------------------------//
	}
	echo '</div>';
}

//------------------------------------------------------------------------//
//---Support Functions----------------------------------------------------//
//------------------------------------------------------------------------//

function login_image_remove_file($file) {
	chmod($file, 0777);
	if(unlink($file))
	{ 
		return true; 
	}else{ 
		return false; 
	} 
}

?>