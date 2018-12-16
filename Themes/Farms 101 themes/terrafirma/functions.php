<?php
if ( function_exists('register_sidebar') )
	register_sidebar();
if ( function_exists('unregister_sidebar_widget') )
	{
		unregister_sidebar_widget( __('Links') );	
	}
	if ( function_exists('register_sidebar_widget') )
	{
		register_sidebar_widget(__('Links'), 'terrafirma_ShowLinks');
	}
	
function terrafirma_ShowLinks() {?>
    <?php 
        if (function_exists('wp_list_bookmarks'))
          wp_list_bookmarks();
        else
          get_links_list('name'); 
    ?> 
<?php }	
function terrafirma_add_theme_page() {

	if ( $_GET['page'] == basename(__FILE__) ) {
	
	    // save settings
		if ( 'save' == $_REQUEST['action'] ) {

			update_option( 'terrafirma_asideid', $_REQUEST[ 's_asideid' ] );
			update_option( 'terrafirma_sortpages', $_REQUEST[ 's_sortpages' ] );
			if( isset( $_POST[ 'excludepages' ] ) ) { update_option( 'terrafirma_excludepages', implode(',', $_POST['excludepages']) ); } else { delete_option( 'terrafirma_excludepages' ); }
			// goto theme edit page
			header("Location: themes.php?page=functions.php&saved=true");
			die;

  		// reset settings
		} else if( 'reset' == $_REQUEST['action'] ) {

			delete_option( 'terrafirma_asideid' );
			delete_option( 'terrafirma_sortpages' );			
			delete_option( 'terrafirma_excludepages' );
			
			
			// goto theme edit page
			header("Location: themes.php?page=functions.php&reset=true");
			die;

		}
	}


    add_theme_page("TerraFirma Options", "TerraFirma Options", 'edit_themes', basename(__FILE__), 'terrafirma_theme_page');

}

function terrafirma_theme_page() {

	// --------------------------
	// TerraFirma theme page content
	// --------------------------

	if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>TerraFirma Theme: Settings saved.</strong></p></div>';
	if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>TerraFirma Theme: Settings reset.</strong></p></div>';
	
?>
<style>
	.wrap { border:#ccc 1px dashed;}
	.block { margin:1em;padding:1em;line-height:1.6em;}
	table tr td {border:#ddd 1px solid;font-family:Verdana, Arial, Serif;font-size:0.9em;}
	h4 {font-size:1.3em;color:#969669;font-weight:bold;margin:0;padding:10px 0;}	
</style>
<div class="wrap">

<h2>TerraFirma 3.5</h2>

<div class="block">
  <img src="<?php bloginfo('stylesheet_directory'); ?>/screenshot.jpg" alt="TerraFirma Screenshot" style="float:left;margin:1em;" />
  <h4>WordPress Theme: <a href="http://wpthemepark.com/themes/terrafirma/">TerraFirma</a> </h4> 
					<h4>based on design by <a href="http://www.nodethirtythree.com/" title="nodethirtythree">nodethirtythree</a></h4>
					<h4>Sponsored by: <a href="http://www.top10webhosting.com/" title="Top 10 Web Hosting">Top 10 Web Hosting</a></h4>
</div>

<br style="clear:both;" />
<form method="post">


<!-- blog layout options -->
<fieldset class="options">
<legend>Theme Settings</legend>

<p>Change the way your blog looks and acts with the many blog settings below</p>

<table width="100%" cellspacing="5" cellpadding="10" class="editform">
<tr>
<td valign="top" colspan="2" style="border:0px;margin:0;padding:0;">
	<input type="hidden" name="action" value="save" />
	<?php tf_input( "save", "submit", "", "Save Settings" );?>
</td>
</tr>

<tr valign="top">
<td align="left">
	<?php
	tf_heading("List Pages / Navigation");		
		global $wpdb;
		$results = $wpdb->get_results("SELECT ID, post_title from $wpdb->posts WHERE post_status='static' or post_type='page' AND post_parent=0 ORDER BY post_title");
		$excludepages = explode(',', get_settings('terrafirma_excludepages'));
		
		if($results) {				
			_e('<br/>Exclude the Following Pages from the Top Navigation <br/><br/>');
			foreach($results as $page) {
				echo '<input type="checkbox" name="excludepages[]" value="' . $page->ID . '"';
				if(in_array($page->ID, $excludepages)) { echo ' checked="checked"'; }
				echo ' /> <a href="' . get_permalink($page->ID) . '">' . $page->post_title . '</a><br />';
			}		
		}
		_e('<br/><br/>');
		echo "<br/><strong> Sort the List Pages by </strong><br/>";
		
		tf_input( "s_sortpages", "radio", "Page Title ?", "post_title", get_settings( 'terrafirma_sortpages' ) );		
		tf_input( "s_sortpages", "radio", "Date ?", "post_date", get_settings( 'terrafirma_sortpages' ) );		
		tf_input( "s_sortpages", "radio", "Page Order ?", "menu_order", get_settings( 'terrafirma_sortpages' ) );
		echo "(Each Page can be given a page order number, from the wordpress admin, edit page area)";
		echo "<br/>";			
?>
</td>
<td>
<?php
	tf_heading( "Support for Asides / Side Notes" );	
	echo "Asides are the 'quick bits' of information you want to post. They do not have to look like a regular post.";
	echo "<br/><br/>Learn More at <a href='http://photomatt.net/2004/05/19/asides/'>Matt's Asides technique</a>";
?>
	<?php
		global $wpdb;
		$id = get_option('terrafirma_asideid');
		$defaults = array(
			'show_option_all' => '', 'show_option_none' => '', 
			'orderby' => 'ID', 'order' => 'ASC', 
			'show_last_update' => 0, 'show_count' => 0, 
			'hide_empty' => 1, 'child_of' => 0, 
			'exclude' => '', 'echo' => 1, 
			'selected' => 0, 'hierarchical' => 0, 
			'name' => 'cat', 'class' => 'postform'
		);
		$r = wp_parse_args( $args, $defaults );
		extract( $r );

		$asides_cats = get_categories($r);      

	?>
			<p>Select the category here. Any posts under this category will look like an Aside.</p>
			<select name="s_asideid" id="s_asideid">
        <option value="0">NOT SELECTED</option>
        <?php
					foreach ($asides_cats as $cat) {
					if ($id == $cat->cat_ID)
					{
						$sIsSelected = "selected='true'";
					}
					else
					{
						$sIsSelected = "";			
					}
						echo '<option value="' . $cat->cat_ID . '"'. $sIsSelected. '>' . $cat->cat_name . '</option>';
				}?>
		</select>	
</td>

</td>
</tr>	
<tr>
<td valign="top" colspan="2" style="border:0px;margin:0;padding:0;">
	<input type="hidden" name="action" value="save" />
	<?php tf_input( "save", "submit", "", "Save Settings" );?>
</td>
</tr>
</table>
</fieldset>
</form>

<form method="post">

<fieldset class="options">
<legend>Reset</legend>

<p>If for some reason you want to uninstall TerraFirma then press the reset button to clean things up in the database.</p>
<p>You have to make sure to delete the theme folder, if you want to completely remove the theme.</p>
<?php

	tf_input( "reset", "submit", "", "Reset Settings" );
	
?>

</div>
<input type="hidden" name="action" value="reset" />
</form>

<?php
}
add_action('admin_menu', 'terrafirma_add_theme_page');


function tf_input( $var, $type, $description = "", $value = "", $selected="" ) {

	// ------------------------
	// add a form input control
	// ------------------------
	
 	echo "\n";
 	
	switch( $type ){
	
	    case "text":

	 		echo "<input name=\"$var\" id=\"$var\" type=\"$type\" style=\"width: 60%\" class=\"text\" value=\"$value\" />";
			
			break;
			
		case "submit":
		
	 		echo "<p class=\"submit\"><input name=\"$var\" type=\"$type\" value=\"$value\" /></p>";

			break;

		case "option":
		
			if( $selected == $value ) { $extra = "selected=\"true\""; }

			echo "<option value=\"$value\" $extra >$description</option>";
		
		    break;
  		case "radio":
  		
			if( $selected == $value ) { $extra = "checked=\"true\""; }
  		
  			echo "<label><input name=\"$var\" id=\"$var\" type=\"$type\" value=\"$value\" $extra /> $description</label><br/>";
  			
  			break;
  			
		case "checkbox":
		
			if( $selected == $value ) { $extra = "checked=\"true\""; }

  			echo "<label for=\"$var\"><input name=\"$var\" id=\"$var\" type=\"$type\" value=\"$value\" $extra /> $description</label><br/>";

  			break;

		case "textarea":
		
		    echo "<textarea name=\"$var\" id=\"$var\" style=\"width: 80%; height: 10em;\" class=\"code\">$value</textarea>";
		
		    break;
	}

}

function tf_heading( $title ) {

	// ------------------
	// add a table header
	// ------------------

   echo "<h4>" .$title . "</h4>";

}
?>