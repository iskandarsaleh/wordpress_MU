<?php
/*
  Plugin Name: Premium Themes
	Plugin URI: http://missionsplace.com
	Description: Setup premium themes that only paid supporters have access to.
	Version: 1.0.2
	Author: Aaron Edwards
	Author URI: http://missionsplace.com
	
	Instructions: Drop into wp-content/mu-plugins/ and visit the "Premium Themes" menu item under Site Admin.
	
	Copyright 2009, MissionsPlace.com

	This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

//------------------------------------------------------------------------//
//---Config---------------------------------------------------------------//
//------------------------------------------------------------------------//


//------------------------------------------------------------------------//
//---Hook-----------------------------------------------------------------//
//------------------------------------------------------------------------//
add_action('admin_menu', 'mp_supporter_themes_plug_pages');
add_filter('allowed_themes', 'mp_supporter_themes_add');

//------------------------------------------------------------------------//
//---Functions------------------------------------------------------------//
//------------------------------------------------------------------------//


function mp_supporter_themes_plug_pages() {
  //check for WPMUdev Premium Supporter plugin
  global $supporter;
  if (function_exists(is_supporter))
    $supporter = true;
  else
    $supporter = false;

	if ( is_site_admin() ) {
		add_submenu_page('wpmu-admin.php', 'Premium Themes', 'Premium Themes', 10, 'supporter-themes', 'mp_supporter_themes_page');
	}
}

function mp_supporter_themes_add($allowed_themes) {
  global $supporter;
  //skip functionality if Supporter plugin is not enabled
  if ($supporter == FALSE)
    return $allowed_themes;
  
  $supporter_allowed_themes = get_site_option( "mp_supporter_themes" );
  
  if( is_array( $supporter_allowed_themes ) && is_supporter())
  	$allowed_themes = array_merge( $allowed_themes, $supporter_allowed_themes );
  
  return $allowed_themes;
}

//------------------------------------------------------------------------//
//---Page Output Functions------------------------------------------------//
//------------------------------------------------------------------------//

function mp_supporter_themes_page() {
  global $supporter;
  
  if (isset($_POST['Submit'])) {
    $supporter_allowed_themes = array();
    
    if (is_array($_POST['theme'])) {
      foreach ($_POST['theme'] as $theme => $value) {
        $supporter_allowed_themes[$theme] = $value;
      }
      update_site_option( "mp_supporter_themes", $supporter_allowed_themes );
    } else {
      update_site_option( "mp_supporter_themes", array(0) );
    }
  }
  
  // Blog Themes
  $themes = get_themes();
  $supporter_allowed_themes = get_site_option( "mp_supporter_themes" );
  $allowed_themes = get_site_option( "allowedthemes" );
  if( $allowed_themes == false ) {
  	$allowed_themes = array_keys( $themes );
  }

?>
  <div class="wrap">
<?php
	if (isset($_GET['action'])) {
	?><div id="message" class="updated fade"><p>Settings Saved!</p></div><?php
	}

  if ($supporter == FALSE) {
    echo '<h2>Premium Themes</h2>
    <div id="message" class="error"><p>You must have the <a href="http://premium.wpmudev.org/?ref=prayhumbly-3442">WPMU Dev Premium</a> Supporter plugin installed for Premium Themes to work.</p></div>
    <a href="http://premium.wpmudev.org/?ref=prayhumbly-3442"><img src="http://premium.wpmudev.org/banners/728x90-banner.png" alt="728x90-banner.png" title="Check Out WPMU DEV Premium" /></a>
    </div>';
    
    return;
  }
?>
  
  	<h2><?php _e('Premium Themes'); ?></h2>
	<div class="donate-message" style="border:1px gray solid;margin:10px;padding:10px;">
  	<table>
  	 <tr>
       <td>You are making money with this plugin. Why not send me a small donation in honor of the time I put into this? Thanks!</td>
       <td>
        <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
        <input type="hidden" name="cmd" value="_s-xclick">
        <input type="hidden" name="hosted_button_id" value="5935926">
        <input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
        <img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
        </form>
       </td>
     </tr>
     <tr>
       <td>I provide support and answer feature requests for this plugin exclusively through the forums at <a href="http://premium.wpmudev.org/?ref=prayhumbly-3442">WPMU Dev Premium</a>. If you are not a member, signup using this button and you can post your questions there.</td>
       <td><a href='http://premium.wpmudev.org/?ref=prayhumbly-3442'><img src='http://premium.wpmudev.org/banners/180x60-banner.png' alt='180x60-banner.png' title='Check Out WPMU DEV Premium' /></a></td>
     </tr>
    </table>
  </div>
  <form method="post" action="wpmu-admin.php?page=supporter-themes&action=updated">
	<p>Select the premium themes that you want to enable for Supporters only. Only <a href="./wpmu-themes.php">inactive themes</a> are shown in this list.</p>
  <table class="widefat">
			<thead>
				<tr>
					<th style="width:15%;text-align:center;"><?php _e('Supporter') ?></th>
					<th style="width:25%;"><?php _e('Theme') ?></th>
					<th style="width:10%;"><?php _e('Version') ?></th>
					<th style="width:60%;"><?php _e('Description') ?></th>
				</tr>
			</thead>
			<tbody id="plugins">
			<?php
			foreach( (array) $themes as $key => $theme ) {
				$theme_key = wp_specialchars($theme['Stylesheet']);
				$class = ('alt' == $class) ? '' : 'alt';
				$class1 = $enabled = $disabled = '';
				
		    if( isset($allowed_themes[$theme_key] ) == false ) {
  		    $checked = ( isset($supporter_allowed_themes[ $theme_key ]) ) ? 'checked="checked"' : '';
  				if ( isset( $supporter_allowed_themes[ $theme_key ] ) == true )
  					$class1 = ' active';
  				?>
  				<tr valign="top" class="<?php echo $class.$class1; ?>">
  					<td style="text-align:center;">
  					<label>
  					  <input name="theme[<?php echo $theme_key ?>]" type="checkbox" value="1" <?php echo $checked; ?>/> Enable
  					</label>
            </td>
  					<th scope="row" style="text-align:left;"><?php echo $key ?></th> 
  					<td><?php echo $theme['Version'] ?></td>
  					<td><?php echo $theme['Description'] ?></td>
  				</tr> 
  			<?php 
        }
      } ?>
			</tbody>
		</table>
		<p class="submit"><input type="submit" name="Submit" value="<?php _e('Update Options &raquo;') ?>" /></p>
	</form>
	</div>
<?php

}

?>
