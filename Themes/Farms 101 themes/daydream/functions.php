<?php
if ( function_exists('register_sidebar') )
    register_sidebar();


function dd_add_admin() {
		
		if ( 'save' == $_REQUEST['dd_action'] ) {

			// Update Options
			update_option('dd_asides_cat', $_REQUEST['dd_asides_cat'] );
			update_option('dd_colour_scheme', $_REQUEST['dd_colour_scheme'] );
			update_option('dd_menu_home', $_REQUEST['dd_menu_home'] );
			update_option('dd_menu_order', $_REQUEST['dd_menu_order'] );
			update_option('dd_gravatars', $_REQUEST['dd_gravatars'] );
			update_option('dd_title', $_REQUEST['dd_title'] );
			update_option('dd_archives_page', $_REQUEST['dd_archives_page'] );
			update_option('dd_tags_page', $_REQUEST['dd_tags_page'] );
			update_option('dd_tagsearch_page', $_REQUEST['dd_tagsearch_page'] );
			update_option('dd_tags_cats', $_REQUEST['dd_tags_cats'] );
			update_option('dd_tags_desc', $_REQUEST['dd_tags_desc'] );
			
				if (get_option('dd_archives_page') == "yes" && !checkForStaticPage('Archives')) {
					createStaticPage('Archives', '', 'archives.php');
				} else if (get_option('dd_archives_page') != "yes") {
					deleteStaticPage('Archives');
				}
				
				if (get_option('dd_tags_page') == "yes" && !checkForStaticPage('Tags')) {
					createStaticPage('Tags', '', 'tags.php');
				} else if (get_option('dd_tags_page') != "yes" || !function_exists('UTW_ShowTagsForCurrentPost')) {
					deleteStaticPage('Tags');
				}
				
				if (get_option('dd_tagsearch_page') == "yes" && !checkForStaticPage('Tag Search')) {
					createStaticPage('Tag Search', '', 'searchtags.php');
				} else if (get_option('dd_tagsearch_page') != "yes" || !function_exists('UTW_ShowTagsForCurrentPost')) {
					deleteStaticPage('Tag Search');
				}
				
	
			// Go back to the options
			header("Location: themes.php?page=functions.php&saved=true");
			die;
		}

    add_theme_page("Day Dream Options", "Day Dream Options", 'edit_themes', basename(__FILE__), 'dd_admin');
	add_option('dd_colour_scheme', 'Blue', 'Holds colour scheme type', 'yes');
	add_option('dd_menu_home', 'yes', 'Show home link the in pages menu', 'yes');
	add_option('dd_menu_order', 'alpha', 'Sorts order of the menu', 'yes');
	add_option('dd_gravatars', 'off', 'Toggles gravatars on and off', 'yes');
	add_option('dd_title', 'left', 'Text alignment in the header', 'yes');
	add_option('dd_tags_desc', 'yes', 'Tag Description', 'yes');
	add_option('dd_archives_page', 'no', 'Create Archives Page', 'yes');
	add_option('dd_tags_page', 'no', 'Create Tags Page', 'yes');
	add_option('dd_tagsearch_page', 'no', 'Create Tag Search Page', 'yes');
	add_option('dd_tags_cats', 'both', 'Display of Tags and Categories', 'yes');
	add_option('dd_tags_desc', 'yes', 'Show Tag Description', 'yes');


}

function dd_admin() {

	if ( $_GET['saved'] ) echo '<div id="message" class="updated fade"><p>Day Dream options saved. <a href="'. get_bloginfo('url') .'">View Site &raquo;</a></strong></p></div>';
	
?>

<div class="wrap">
<h2>Day Dream Options</h2>



	<form id='dd_options' method="post">
	
			<h3>Title</h3>
			
				<p><label for="dd_title" style="width: 90px;">Title and Description:</label>
					<input type="radio" name="dd_title" value="left" <?php if (get_option('dd_title') == "left") { echo "checked='checked'"; } ?> /> Left Align (default)<br />
					<input type="radio" name="dd_title" value="centre" <?php if (get_option('dd_title') == "centre") { echo "checked='checked'"; } ?> /> Centre<br />
					<input type="radio" name="dd_title" value="right" style="margin-left: 90px;" <?php if (get_option('dd_title') == "right") { echo "checked='checked'"; } ?> /> Right Align<br />
					<div class="hint" style="margin-left: 90px;">Right aligning can look pretty good, it provides some balance against the left aligned menu.</div></p>
			
			
			<h3>Menu</h3>
				
				<p><label for="dd_menu_home" style="width: 90px;">Home link:</label>
					<input type="radio" name="dd_menu_home" value="yes" <?php if (get_option('dd_menu_home') == "yes") { echo "checked='checked'"; } ?> /> Show in the menu<br />
					<input type="radio" name="dd_menu_home" value="no" style="margin-left: 90px;" <?php if (get_option('dd_menu_home') == "no") { echo "checked='checked'"; } ?> /> Do not show in the menu<br />
					<div class="hint" style="margin-left: 90px;">A link home is also created in the header but an additional link is shown in the menu by deafult.</div></p>
					
				<p><label for="dd_menu_order" style="width: 90px;">Order:</label>
					<input type="radio" name="dd_menu_order" value="alpha" <?php if (get_option('dd_menu_order') == "alpha") { echo "checked='checked'"; } ?> /> Alphabetically<br />
					<input type="radio" name="dd_menu_order" value="by_id" style="margin-left: 90px;" <?php if (get_option('dd_menu_order') == "by_id") { echo "checked='checked'"; } ?> /> By ID<br />
					<input type="radio" name="dd_menu_order" value="page_order" style="margin-left: 90px;" <?php if (get_option('dd_menu_order') == "page_order") { echo "checked='checked'"; } ?> /> Page Order<br />
					<div class="hint" style="margin-left: 90px;">Page order is set when creating and editing pages. Alphabetical is the default.</div></p>

			
			<h3>Pages</h3>
			
				<p><label for="dd_archives_page" style="width: 90px;">Archives:</label>
					<input type="checkbox" name="dd_archives_page" value="yes" <?php if (get_option('dd_archives_page') == "yes" || checkForStaticPage('Archives') ) { echo "checked='checked'"; } ?> /> Create Page<br />
					</p>
				
				
				
					<?php if (function_exists('UTW_ShowTagsForCurrentPost') && function_exists('UTW_TagArchive')) { ?>
					
						<input type="checkbox" name="dd_tags_page" value="yes" <?php if (get_option('dd_tags_page') == "yes" || checkForStaticPage('Tags') ) { echo "checked='checked'"; } ?> /> Create Tag Cloud Page<br />
						<div class="hint" style="margin-left: 90px;">Read more about tags <a href="http://www.neato.co.nz/wp-content/plugins/UltimateTagWarrior/ultimate-tag-warrior-help.html">here</a>. Credit goes to <a href="http://www.neato.co.nz/">Christine Davis</a> for this plugin.</div></p>
					
					<?php } else { ?>
						
					
						
					<?php } ?>
			
			
			
			
				<?php if (function_exists('UTW_ShowTagsForCurrentPost')) { ?>
				
					<p><label for="dd_tags_cats" style="width: 90px;">Display:</label>
						<input type="radio" name="dd_tags_cats" value="both" <?php if (get_option('dd_tags_cats') == "both") { echo "checked='checked'"; } ?> /> Show both Tags and Categories<br />
						<input type="radio" name="dd_tags_cats" value="tags" style="margin-left: 90px;" <?php if (get_option('dd_tags_cats') == "tags") { echo "checked='checked'"; } ?> /> Replace Categories with Tags<br />
						<div class="hint" style="margin-left: 90px;">Tags will only replace categories visibly on the index page, your categories won't be destroyed, I promise.</div></p>
					
					<p><label for="dd_tags_desc" style="width: 90px;">Description:</label>
						<input type="checkbox" name="dd_tags_desc" value="yes" <?php if (get_option('dd_tags_desc') == "yes") { echo "checked='checked'"; } ?> /> Display description of Tags on Tag Cloud Page.<br />
						<div class="hint" style="margin-left: 90px;">"A tag cloud (more traditionally known as a weighted list in the field of visual design) 
						is a visual depiction of content tags used on this blog."</div></p>
				
				<?php } else { ?>
						
					
						
				<?php } ?>
					
			
			<h3>Asides</h3>
			
				<p><label for="dd_asides_cat">Category for Asides:</label>
					<?php
					global $wpdb;
					$asides_cats = get_categories();
					?>
					<select name="dd_asides_cat" id="dd_asides_cat">
						<option value="0">No Asides</option>
						<option value="0">----</option>
						<?php
						foreach ($asides_cats as $cat) {
							if ($cat->cat_ID == get_option('dd_asides_cat')) {
								echo '<option value="' . $cat->cat_ID . '" selected="selected">' . $cat->cat_name . '</option>';
							} else {
								echo '<option value="' . $cat->cat_ID . '">' . $cat->cat_name . '</option>';
							}
						}
						?>
					</select><br />
					<?php 
						if (get_option('dd_asides_cat') == 0) { 
							echo "<div class='hint'>To enable asides please select the category you'd like to use.</div>";
						} else {
							echo "<div class='hint'>Select 'No Asides' to turn Asides off.</div>";
						}
					?>
					</p>
		
		

		
			<?php if (function_exists('gravatar')) { ?>
			
			
			
			<?php } else { ?>
			
		
			
			<?php }	?>
	
			
		
		<h3>Colour Schemes</h3>
		
			<p><label for="dd_colour_scheme">Select a Colour Scheme:</label>
				<img src="<?php bloginfo('template_directory'); ?>/images/option_blue.jpg" alt="Blue" />
				<input type="radio" name="dd_colour_scheme" value="Blue" <?php if (get_option('dd_colour_scheme') == "Blue") { echo "checked='checked'"; } ?> />
			
				
				<img src="<?php bloginfo('template_directory'); ?>/images/option_green.jpg" alt="Green" />
				<input type="radio" name="dd_colour_scheme" value="Green" <?php if (get_option('dd_colour_scheme') == "Green") { echo "checked='checked'"; } ?> /><br />
				
				<p style="margin-left: 140px;">
				<img src="<?php bloginfo('template_directory'); ?>/images/option_pink.jpg" alt="Pink" />
				<input type="radio" name="dd_colour_scheme" value="Pink" <?php if (get_option('dd_colour_scheme') == "Pink") { echo "checked='checked'"; } ?> />
				
				
				<img src="<?php bloginfo('template_directory'); ?>/images/option_grey.jpg" alt="Grey" />
				<input type="radio" name="dd_colour_scheme" value="Grey" <?php if (get_option('dd_colour_scheme') == "Grey") { echo "checked='checked'"; } ?> /></p>

				
				<div class='hint'>Blue is the default, select the button next to the square to select that colour scheme. The grey version 
				is a little plain compared to the others, it encourages customisation.</div></p>
				
		<p><input name="save" id="save" type="submit" value="Save Options" /></p>
		
		<input type="hidden" name="dd_action" value="save" />
	
	</form>

<?php
}

function dd_admin_header() { ?>

	<style media="screen" type="text/css">
		
		form#dd_options { margin: 20px 0 0 40px; }
		
			form#dd_options h3 {
				font-size: 1.5em;
				font-weight: normal;
				margin: 30px 0 0 0;
				}
				
				form#dd_options p { margin: 10px 0; }
				
				form#dd_options label { 
					width: 140px;
					display: block;
					float: left;
					}
					
					form#dd_options div.hint {
						color: #666;
						margin: -8px 0 0 140px;
						width: 500px;
						}
						
			form#dd_options input#save { margin: 20px 0 0 140px; }
			
			
		
	</style>

<?php }

add_action('admin_head', 'dd_admin_header');
add_action('admin_menu', 'dd_add_admin');

	/*
	Plugin Name: Nice Categories
	Plugin URI: http://txfx.net/2004/07/22/wordpress-conversational-categories/
	Description: Displays the categories conversationally, like: Category1, Category2 and Category3
	Version: 1.5.1
	Author: Mark Jaquith
	Author URI: http://txfx.net/
	*/
	
	function the_nice_category($normal_separator = ', ', $penultimate_separator = ' and ') {
		$categories = get_the_category();
	   
		  if (empty($categories)) {
			_e('Uncategorized');
			return;
		}
	
		$thelist = '';
			$i = 1;
			$n = count($categories);
			foreach ($categories as $category) {
				$category->cat_name = $category->cat_name;
					if (1 < $i && $i != $n) $thelist .= $normal_separator;
					if (1 < $i && $i == $n) $thelist .= $penultimate_separator;
				$thelist .= '<a href="' . get_category_link($category->cat_ID) . '" title="' . sprintf(__("View all posts in %s"), $category->cat_name) . '">'.$category->cat_name.'</a>';
						 ++$i;
			}
		echo apply_filters('the_category', $thelist, $normal_separator);
	} 
	
	/*
	This next function is stolen directly
	from the Tarski theme, it is used to 
	create static pages. It'll be used to create the archives page and
	the tags page.
	*/
	
	function createStaticPage($post_title, $content, $template) {
		global $wpdb, $user_ID;
		get_currentuserinfo();
		
		$now = current_time('mysql');
		$now_gmt = current_time('mysql', 1);
		$post_author = $user_ID;
		$id_result = $wpdb->get_row("SHOW TABLE STATUS LIKE '$wpdb->posts'");
		$post_ID = $id_result->Auto_increment;
		$post_name = sanitize_title($post_title, $post_ID);
		$ping_status = get_option('default_ping_status');
		$comment_status = get_option('default_comment_status');
		
		$postquery ="INSERT INTO $wpdb->posts (ID, post_author, post_date, post_date_gmt, post_content, post_title, post_excerpt,  post_status, comment_status, ping_status, post_password, post_name, to_ping, post_modified, post_modified_gmt, post_parent, menu_order) VALUES ('$post_ID', '$post_author', '$now', '$now_gmt', '$content', '$post_title', '', 'static', '$comment_status', '$ping_status', '', '$post_name', '', '$now', '$now_gmt', '', '')";
		$result = $wpdb->query($postquery);
		
		$metaquery = "INSERT INTO $wpdb->postmeta(meta_id, post_id, meta_key, meta_value) VALUES('', '$post_ID', '_wp_page_template', '$template')";
		$result2 = $wpdb->query($metaquery);
	}
	
	function checkForStaticPage($title) {
		global $wpdb, $user_ID;
		get_currentuserinfo();
		
		$query = "SELECT ID FROM $wpdb->posts WHERE post_title='$title' AND post_status='static'";
		$result = $wpdb->query($query);
		
		if($result > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	function deleteStaticPage($title) {
		global $wpdb;
		
		$result_del = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_title = '$title' AND post_status = 'static'");
		
		wp_delete_post($result_del);
	}

?>